<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Mail\SubscriptionPaymentSuccessMail;
use App\Models\AffiliateUser;
use App\Models\Plan;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use KingFlamez\Rave\Facades\Rave as FlutterWave;
use App\Models\CouponCode;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FlutterwaveAPIController extends AppBaseController
{
    private SubscriptionRepository $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function onBoard(Request $request): JsonResponse
    {
        $planId = $request->input('planId');
        $customFieldId = $request->input('customFieldId');
        $couponCodeId = $request->input('couponCodeId');
        $couponCode = $request->input('couponCode');

        $plan = Plan::with('currency')->findOrFail($planId);

        if ($plan->custom_select == 1) {
            if (empty($customFieldId)) {
                return $this->sendError('Please select a custom option for this plan.');
            }

            $validCustomField = $plan->planCustomFields()->where('id', $customFieldId)->exists();
            if (!$validCustomField) {
                return $this->sendError('Invalid custom field selection for this plan.');
            }
        } elseif (!empty($customFieldId)) {
            return $this->sendError('This plan does not have custom options.');
        }

        if (!empty($couponCodeId) && !empty($couponCode)) {
            $couponCodeRecord = CouponCode::where('id', $couponCodeId)
                ->where('coupon_name', $couponCode)
                ->where('status', 1)
                ->first();

            if (!$couponCodeRecord) {
                return $this->sendError('Invalid or inactive coupon code.');
            }

            $currentDate = Carbon::now();
            if ($currentDate->gt(Carbon::parse($couponCodeRecord->expire_at))) {
                return $this->sendError('This coupon code has expired.');
            }

            if ($couponCodeRecord->coupon_limit !== null && $couponCodeRecord->coupon_limit_left <= 0) {
                return $this->sendError('This coupon code has reached its usage limit.');
            }
        }

        $currentSubscription = getCurrentSubscription();
        if ($currentSubscription && $currentSubscription->plan_id == $planId) {
            $currentDate = Carbon::now();
            $expiresAt = Carbon::parse($currentSubscription->ends_at);

            if ($expiresAt->gt($currentDate)) {
                return $this->sendError('You already have this active subscription plan.');
            }
        }

        $data = $this->subscriptionRepository->manageSubscription($request->all());
        if (isset($data['status']) && $data['status'] === true) {
            return $this->sendResponse([
                'plan' => $data['subscriptionPlan'],
            ], 'Plan activated successfully.');
        }

        if (!isset($data['subscription'])) {
            return $this->sendError('Failed to create subscription.');
        }

        $subscription = $data['subscription'];

        if (empty($data['amountToPay']) || $data['amountToPay'] == 0) {
            return $this->sendResponse([
                'plan' => $plan,
            ], 'Plan activated successfully (Free Plan).');
        }

        $clientId = getSelectedPaymentGateway('flutterwave_key');
        $clientSecret = getSelectedPaymentGateway('flutterwave_secret');

        config([
            'flutterwave.publicKey' => $clientId,
            'flutterwave.secretKey' => $clientSecret,
        ]);

        $supportedCurrency = [
            'GBP', 'CAD', 'XAF', 'CLP', 'COP', 'EGP', 'EUR', 'GHS', 'GNF', 'KES',
            'MWK', 'MAD', 'NGN', 'RWF', 'SLL', 'STD', 'ZAR', 'TZS', 'UGX',
            'USD', 'XOF', 'ZMW'
        ];

        if ($plan->currency->currency_code != null &&
            !in_array(strtoupper($plan->currency->currency_code), $supportedCurrency)) {
            return $this->sendError(__('messages.placeholder.this_currency_is_not_supported_flutterwave'));
        }

        $reference = FlutterWave::generateReference();

        $baseUrl = config('app.frontend_url') ?: config('app.url');
        $redirectUrl = $baseUrl . '/flutterwave/success';

        $paymentData = [
            'payment_options' => 'card,banktransfer',
            'amount' => $data['amountToPay'],
            'email' => getLogInUser()->email,
            'tx_ref' => $reference,
            'currency' => $plan->currency->currency_code,
            'redirect_url' => $redirectUrl,
            'customer' => [
                'email' => getLogInUser()->email,
            ],
            'customizations' => [
                'title' => 'Purchase Subscription Payment',
            ],
            'meta' => [
                'subscription_id' => $subscription->id,
                'amount' => $data['amountToPay'] * 100,
                'payment_mode' => Subscription::FLUTTERWAVE,
            ],
        ];

        $payment = FlutterWave::initializePayment($paymentData);

        if ($payment['status'] !== 'success') {
            return $this->sendError('Unable to create Flutterwave payment session.');
        }

        $checkoutUrl = $payment['data']['link'];

        $response = [
            'plan_id' => $plan->id,
            'subscription_id' => $subscription->id,
            'payment_type' => 'flutterwave',
            'checkout_url' => $checkoutUrl,
            'currency' => $plan->currency->currency_code,
            'amount' => $data['amountToPay'],
            'email' => getLogInUser()->email,
            'contact' => getLogInUser()->contact,
            'tx_ref' => $reference,
        ];

        return $this->sendResponse($response, 'Flutterwave checkout session created successfully.');
    }

    public function flutterwavePaymentSuccess(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->email == 'admin@vcard.com') {
            return $this->sendError('Seems, you are not allowed to access this record.', 403);
        }

        try {
            $clientId = getSelectedPaymentGateway('flutterwave_key');
            $clientSecret = getSelectedPaymentGateway('flutterwave_secret');

            config([
                'flutterwave.publicKey' => $clientId,
                'flutterwave.secretKey' => $clientSecret,
            ]);

            $input = $request->all();
            Log::info('🔥 Flutterwave Payment Success Callback:', $input);

            if (!isset($input['status']) || $input['status'] !== 'successful') {
                return $this->sendError('Payment not completed or failed.', 400);
            }

            $txRef = $input['tx_ref'] ?? null;
            $transactionID = $input['transaction_id'] ?? null;

            if (!$transactionID && $txRef) {
                $verifyUrl = "https://api.flutterwave.com/v3/transactions/verify_by_reference?tx_ref={$txRef}";
                $response = Http::withToken($clientSecret)->get($verifyUrl);
                $verifyResponse = $response->json();

                Log::info('🧾 Flutterwave verify_by_reference response:', $verifyResponse);

                if (isset($verifyResponse['status']) && $verifyResponse['status'] === 'success' && isset($verifyResponse['data']['id'])) {
                    $transactionID = $verifyResponse['data']['id'];
                } else {
                    Log::error('❌ Flutterwave reference verification failed', ['response' => $verifyResponse]);
                    return $this->sendError('Unable to verify transaction with Flutterwave.', 400);
                }
            }

            $flutterWaveData = FlutterWave::verifyTransaction($transactionID);

            Log::info('✅ Flutterwave verifyTransaction response:', $flutterWaveData);

            if (!isset($flutterWaveData['status']) || $flutterWaveData['status'] !== 'success') {
                Log::error('❌ Flutterwave transaction verification failed', ['response' => $flutterWaveData]);
                return $this->sendError('Unable to verify transaction with Flutterwave.', 400);
            }

            $data = $flutterWaveData['data'];
            $amount = $data['amount'];
            $subscriptionID = $data['meta']['subscription_id'] ?? null;

            if (!$subscriptionID) {
                return $this->sendError('Invalid subscription reference.', 400);
            }

            $subscription = Subscription::findOrFail($subscriptionID);

            $subscription->update([
                'payment_type' => Subscription::FLUTTERWAVE,
                'status' => Subscription::ACTIVE,
            ]);

            Subscription::whereTenantId(getLogInTenantId())
                ->where('id', '!=', $subscriptionID)
                ->where('status', '!=', Subscription::REJECT)
                ->update(['status' => Subscription::INACTIVE]);

            $transaction = Transaction::create([
                'tenant_id' => $subscription->tenant_id,
                'transaction_id' => $transactionID,
                'type' => Subscription::FLUTTERWAVE,
                'amount' => $amount,
                'status' => Subscription::ACTIVE,
                'meta' => json_encode($data),
            ]);

            $planName = $subscription->plan->name;
            $subscription->update([
                'transaction_id' => $transaction->id,
                'payment_type' => Subscription::FLUTTERWAVE,
            ]);

            $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
            $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');

            if ($affiliateAmountType == 1) {
                AffiliateUser::whereUserId(getLogInUserId())
                    ->where('amount', 0)
                    ->withoutGlobalScopes()
                    ->update([
                        'amount' => $affiliateAmount,
                        'is_verified' => 1,
                    ]);
            } elseif ($affiliateAmountType == 2) {
                $affiliateValue = $amount * $affiliateAmount / 100;
                AffiliateUser::whereUserId(getLogInUserId())
                    ->where('amount', 0)
                    ->withoutGlobalScopes()
                    ->update([
                        'amount' => $affiliateValue,
                        'is_verified' => 1,
                    ]);
            }

            $emailData = [
                'subscriptionID' => $subscriptionID,
                'amountToPay' => $amount,
                'planName' => $planName,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ];

            manageVcards();
            Mail::to($user->email)->send(new SubscriptionPaymentSuccessMail($emailData));

            $responseData = [
                'subscription_id' => $subscriptionID,
                'transaction_id' => $transaction->id,
                'plan_name' => $planName,
                'amount' => $amount,
                'status' => 'active',
            ];

            return $this->sendResponse($responseData, 'Payment completed successfully.');
        } catch (\Throwable $e) {
            Log::error('Flutterwave Payment Error: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), 500);
        }
    }
}
