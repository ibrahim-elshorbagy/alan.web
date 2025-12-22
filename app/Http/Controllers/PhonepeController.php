<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionPaymentSuccessMail;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNfcOrderMail;
use App\Models\AffiliateUser;
use App\Models\Nfc;
use App\Models\NfcOrders;
use App\Models\NfcOrderTransaction;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Vcard;
use Illuminate\Http\Request;
use App\Repositories\SubscriptionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\SlackIntegration\Entities\SlackIntegration;
use Modules\SlackIntegration\Notifications\SlackNotification;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PhonepeController extends AppBaseController
{
    private SubscriptionRepository $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function phonePe(Request $request)
    {
        $data = $this->subscriptionRepository->manageSubscription($request->all());
        $subscription = $data['subscription'];

        $currency = $subscription->plan->currency->currency_code;
        if ($currency != "INR") {
            Flash::error(__('messages.placeholder.this_currency_is_not_supported_phonepe'));
            return redirect()->back();
        }

        $email =  $request->user()->email;
        $amount = $data['amountToPay'];

        $redirectbackurl = route('phonepe-subscription-response') . '?' . http_build_query(['subscriptionId' => $subscription->id, 'userId' => getLogInUserId()]);

        $paymentConfig = [
            'merchantId' => getSelectedPaymentGateway('phonepe_merchant_id'),
            'clientId' => getSelectedPaymentGateway('phonepe_merchant_user_id'),
            'clientVersion' => getSelectedPaymentGateway('phonepe_salt_index'),
            'clientSecret' => getSelectedPaymentGateway('phonepe_salt_key'),
            'tokenUrl' => getSelectedPaymentGateway('phonepe_env') == 'production' ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token' : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
            'baseUrl' => getSelectedPaymentGateway('phonepe_env') == 'production' ? 'https://api.phonepe.com/apis/pg' : 'https://api-preprod.phonepe.com/apis/pg-sandbox',
            'callbackUrl' => $redirectUrl ?? route('phonepe-subscription-response'),
        ];


        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            Flash::error(__('messages.placeholder.authentication_failed'));
            return redirect()->back();
        }

        $transactionId = date('dmYhmi') . rand(111111, 999999);

        $payload = [
            'merchantOrderId' => $transactionId,
            'amount' => $amount * 100,
            'callbackUrl' => $paymentConfig['callbackUrl'],
            'expireAfter' => '1200',
            'paymentFlow' => [
                'type' => 'PG_CHECKOUT',
                'merchantUrls' => [
                    'redirectUrl' => $redirectbackurl
                ]
            ]
        ];

        $response = $this->makePhonePePaymentRequest($payload, $paymentConfig, $accessToken);
        Session::put('phonepe_order_id', $transactionId);
        return redirect()->away($response->redirectUrl);
    }


    public function callbackPhonePe(Request $request)
    {
        $transactionId = session()->pull('phonepe_order_id');

        $paymentConfig = [
            'merchantId' => getSelectedPaymentGateway('phonepe_merchant_id'),
            'clientId' => getSelectedPaymentGateway('phonepe_merchant_user_id'),
            'clientVersion' => getSelectedPaymentGateway('phonepe_salt_index'),
            'clientSecret' => getSelectedPaymentGateway('phonepe_salt_key'),
            'tokenUrl' => getSelectedPaymentGateway('phonepe_env') == 'production' ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token' : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
            'baseUrl' => getSelectedPaymentGateway('phonepe_env') == 'production' ? 'https://api.phonepe.com/apis/pg' : 'https://api-preprod.phonepe.com/apis/pg-sandbox',
            'callbackUrl' => $redirectUrl ?? route('phonepe-subscription-response'),
        ];

        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            Flash::error(__('messages.placeholder.authentication_failed'));
            return redirect()->back();
        }
        $merchantId = getSelectedPaymentGateway('phonepe_merchant_id');


        $response = $this->verifyPhonePePayment($merchantId, $transactionId, $paymentConfig, $accessToken);
        if ($response->state == 'COMPLETED') {
            try {
                $transactionID = $transactionId;
                $transactionAmount = $response->amount / 100;
                $subscriptionId = request()->input('subscriptionId');
                $userId = request()->input('userId');
                Auth::loginUsingId($userId);
                Subscription::findOrFail($subscriptionId)->update([
                    'payment_type' => Subscription::PHONEPE,
                    'status' => Subscription::ACTIVE
                ]);
                Subscription::findOrFail($subscriptionId)->get();
                // De-Active all other subscription
                Subscription::whereTenantId(getLogInTenantId())
                    ->where('id', '!=', $subscriptionId)
                    ->where('status', '!=', Subscription::REJECT)
                    ->update([
                        'status' => Subscription::INACTIVE,
                    ]);

                $transaction = Transaction::create([
                    'transaction_id' => $transactionID,
                    'type' => Transaction::PHONEPE,
                    'amount' => $transactionAmount,
                    'status' => Subscription::ACTIVE,
                    'meta' => json_encode($response),
                ]);

                // updating the transaction id on the subscription table
                $subscription = Subscription::findOrFail($subscriptionId);
                $subscription->update(['transaction_id' => $transaction->id]);

                $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
                $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');
                if ($affiliateAmountType == 1) {
                    AffiliateUser::whereUserId(getLogInUserId())->where('amount', 0)->withoutGlobalScopes()->update(['amount' => $affiliateAmount, 'is_verified' => 1]);
                } else if ($affiliateAmountType == 2) {
                    $amount = $transactionAmount * $affiliateAmount / 100;
                    AffiliateUser::whereUserId(getLogInUserId())->where('amount', 0)->withoutGlobalScopes()->update(['amount' => $amount, 'is_verified' => 1]);
                }

                $planName = $subscription->plan->name;
                $userEmail = getLogInUser()->email;
                $firstName = getLogInUser()->first_name;
                $lastName =  getLogInUser()->last_name;
                $emailData = [
                    'subscriptionId' => $subscriptionId,
                    'subscriptionAmount' => $transactionAmount,
                    'transactionID' => $transactionID,
                    'planName' => $planName,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ];

                manageVcards();
                Mail::to($userEmail)->send(new SubscriptionPaymentSuccessMail($emailData));

                // Send Slack Notification after successful payment initialization
                $purchaseUserFullName  = implode(' ', [$firstName, $lastName]);
                if (moduleExists('SlackIntegration')) {
                    $slackIntegration = SlackIntegration::first();

                    if ($slackIntegration && $slackIntegration->user_plan_purchase_notification == 1 && !empty($slackIntegration->webhook_url)) {
                        $message = "🔔 New Plan Purchased !!!\nPlan {$planName} Purchased by {$purchaseUserFullName} Successfully.";
                        $slackIntegration->notify(new SlackNotification($message));
                    }
                }
                return view('sadmin.plans.payment.paymentSuccess');
            } catch (\Exception $e) {
                DB::rollBack();
                throw new UnprocessableEntityHttpException($e->getMessage());
            }
        } else {
            DB::rollBack();
            Flash::error(__('messages.payment.payment_error'));
            return redirect()->route('subscription.index');
        }
    }


    /**
     * Get access token from PhonePe.
     */
    public function getAccessToken(): ?string
    {
        $merchantId = getSelectedPaymentGateway('phonepe_merchant_id');
        $clientId = getSelectedPaymentGateway('phonepe_merchant_user_id');
        $clientVersion = getSelectedPaymentGateway('phonepe_salt_index');
        $clientSecret = getSelectedPaymentGateway('phonepe_salt_key');
        $tokenUrl = getSelectedPaymentGateway('phonepe_env') == 'production'
            ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token'
            : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token';


        // Prepare request for token
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $tokenUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'client_version' => $clientVersion,
                'grant_type' => 'client_credentials',
            ]),
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        ]);


        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $responseData = json_decode($response, true);

        return $responseData['access_token'] ?? null;
    }

    /**
     * Verify PhonePe payment status.
     */
    public function verifyPhonePePayment($merchantId, $transactionId, array $config, string $accessToken)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $config['baseUrl'] . '/checkout/v2/order/' . $transactionId . '/status?details=true',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: O-Bearer ' . $accessToken,
                'X-MERCHANT-ID: ' . $merchantId
            ],
        ]);


        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }


    /**
     * Make a payment request to PhonePe.
     */
    public function makePhonePePaymentRequest(array $payload, array $config, string $accessToken)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $config['baseUrl'] . '/checkout/v2/pay',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS =>  json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: O-Bearer ' . $accessToken,
                'X-MERCHANT-ID: ' . $config['merchantId']
            ],
        ]);


        $response = curl_exec($curl);
        curl_close($curl);


        return json_decode($response);
    }

    public function nfcOrder($orderId, $email, $nfc, $currency)
    {
        $baseAmount = $nfc->nfcCard->price * $nfc->quantity;

        $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
        $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
        $taxAmount = 0;

        if ($isTaxEnabled && $taxValue > 0) {
            $taxAmount = ($baseAmount * $taxValue) / 100;
        }

        $totalAmount = $baseAmount + $taxAmount;
        $redirectbackurl = route('phonepe-nfcorder-response') . '?' . http_build_query(['nfcorderId' => $orderId]);

        $paymentConfig = [
            'merchantId' => getSelectedPaymentGateway('phonepe_merchant_id'),
            'clientId' => getSelectedPaymentGateway('phonepe_merchant_user_id'),
            'clientVersion' => getSelectedPaymentGateway('phonepe_salt_index'),
            'clientSecret' => getSelectedPaymentGateway('phonepe_salt_key'),
            'tokenUrl' => getSelectedPaymentGateway('phonepe_env') == 'production' ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token' : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
            'baseUrl' => getSelectedPaymentGateway('phonepe_env') == 'production' ? 'https://api.phonepe.com/apis/pg' : 'https://api-preprod.phonepe.com/apis/pg-sandbox',
            'callbackUrl' => $redirectbackurl ?? route('phonepe-nfcorder-response'),
        ];


        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return response()->json(['message' => __('messages.placeholder.authentication_failed'), 'status' => 500]);
        }

        $transactionId = date('dmYhmi') . rand(111111, 999999);

        $payload = [
            'merchantOrderId' => $transactionId,
            'amount' => $totalAmount * 100,
            'callbackUrl' => $paymentConfig['callbackUrl'],
            'expireAfter' => '1200',
            'paymentFlow' => [
                'type' => 'PG_CHECKOUT',
                'merchantUrls' => [
                    'redirectUrl' => $redirectbackurl
                ]
            ]
        ];

        $response = $this->makePhonePePaymentRequest($payload, $paymentConfig, $accessToken);
        if ($response->redirectUrl) {
            Session::put('phonepe_nfc_order_id', $transactionId);
        }
        return response()->json(['link' => $response->redirectUrl, 'status' => 200]);
    }

    public function nfcOrderSuccess(Request $request)
    {

        $transactionId = session()->pull('phonepe_nfc_order_id');

        $paymentConfig = [
            'merchantId' => getSelectedPaymentGateway('phonepe_merchant_id'),
            'clientId' => getSelectedPaymentGateway('phonepe_merchant_user_id'),
            'clientVersion' => getSelectedPaymentGateway('phonepe_salt_index'),
            'clientSecret' => getSelectedPaymentGateway('phonepe_salt_key'),
            'tokenUrl' => getSelectedPaymentGateway('phonepe_env') == 'production' ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token' : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
            'baseUrl' => getSelectedPaymentGateway('phonepe_env') == 'production' ? 'https://api.phonepe.com/apis/pg' : 'https://api-preprod.phonepe.com/apis/pg-sandbox',
            'callbackUrl' => $redirectUrl ?? route('phonepe-nfcorder-response'),
        ];

        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            Flash::error(__('messages.placeholder.authentication_failed'));
            return redirect()->back();
        }
        $merchantId = getSelectedPaymentGateway('phonepe_merchant_id');
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            Flash::error(__('messages.placeholder.authentication_failed'));
            return redirect()->back();
        }


        $response = $this->verifyPhonePePayment($merchantId, $transactionId, $paymentConfig, $accessToken);

        if ($response->state == 'COMPLETED') {
            try {
                $orderId = request()->input('nfcorderId');
                $userId = NfcOrders::findOrFail($orderId)->user_id;
                Auth::loginUsingId($userId);
                $status = NfcOrders::SUCCESS;
                $nfcOrder = NfcOrders::get()->find($orderId);
                $type = NfcOrders::PHONEPE;
                $transactionId = $transactionId;
                $amount = $response->amount / 100;
                $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
                $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
                $tax = null;

                if ($isTaxEnabled && $taxValue > 0) {
                    $tax = $taxValue;
                }

                $transactionDetails = [
                    'nfc_order_id' => $orderId,
                    'type' => $type,
                    'transaction_id' => $transactionId,
                    'amount' => $amount,
                    'user_id' => $userId,
                    'status' =>  $status,
                    'tax' => $tax,
                ];

                NfcOrderTransaction::create($transactionDetails);

                $vcardName = Vcard::find($nfcOrder['vcard_id'])->name;
                $cardType = Nfc::find($nfcOrder['card_type'])->name;

                Mail::to(getSuperAdminSettingValue('email'))->send(new AdminNfcOrderMail($nfcOrder, $vcardName, $cardType));
                Flash::success(__('messages.nfc.order_placed_success'));
                Auth::loginUsingId($userId);
                return redirect(route('user.orders'));
            } catch (\Exception $e) {
                DB::rollBack();
                throw new UnprocessableEntityHttpException($e->getMessage());
            }
        } else {
            Flash::error(__('messages.payment.payment_error'));
            return redirect(route('user.orders'));
        }
    }
}
