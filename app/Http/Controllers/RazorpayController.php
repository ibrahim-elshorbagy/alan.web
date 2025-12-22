<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Nfc;
use App\Models\Vcard;
use Razorpay\Api\Api;
use App\Models\Product;
use App\Models\Currency;
use App\Models\NfcOrders;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use App\Models\Appointment;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\AffiliateUser;
use App\Mail\AdminNfcOrderMail;
use Illuminate\Http\JsonResponse;
use App\Mail\ProductOrderSendUser;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\NfcOrderTransaction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductOrderSendCustomer;
use App\Models\AppointmentTransaction;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AppointmentRepository;
use App\Mail\SubscriptionPaymentSuccessMail;
use App\Repositories\SubscriptionRepository;
use Modules\SlackIntegration\Entities\SlackIntegration;
use Modules\SlackIntegration\Notifications\SlackNotification;

class RazorpayController extends AppBaseController
{
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function onBoard(Request $request): JsonResponse
    {
        $data = $this->subscriptionRepository->manageSubscription($request->all());

        $subscription = $data['subscription'];
        $api = new Api(getSelectedPaymentGateway('razorpay_key'), getSelectedPaymentGateway('razorpay_secret'));
        $orderData = [
            'receipt' => 1,
            'amount' => $data['amountToPay'] * 100,
            'currency' => $subscription->plan->currency->currency_code,
            'notes' => [
                'email' => Auth::user()->email,
                'name' => Auth::user()->full_name,
                'subscriptionId' => $subscription->id,
                'amountToPay' => $data['amountToPay'],
            ],
        ];

        session(['payment_type' => request()->get('payment_type')]);

        $razorpayOrder = $api->order->create($orderData);
        $data['id'] = $razorpayOrder->id;
        $data['amount'] = $data['amountToPay'];
        $data['name'] = Auth::user()->full_name;
        $data['email'] = Auth::user()->email;
        $data['contact'] = Auth::user()->contact;

        return $this->sendResponse($data, 'Order created successfully');
    }

    /**
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function paymentSuccess(Request $request)
    {
        $input = $request->all();
        Log::info('RazorPay Payment Successfully');
        Log::info($input);
        $api = new Api(getSelectedPaymentGateway('razorpay_key'), getSelectedPaymentGateway('razorpay_secret'));
        if (count($input) && ! empty($input['razorpay_payment_id'])) {
            try {
                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $generatedSignature = hash_hmac(
                    'sha256',
                    $payment['order_id'] . '|' . $input['razorpay_payment_id'],
                    getSelectedPaymentGateway('razorpay_secret')
                );
                if ($generatedSignature != $input['razorpay_signature']) {
                    return redirect()->back();
                }
                // Create Transaction Here

                $subscriptionID = $payment['notes']['subscriptionId'];
                $amountToPay = $payment['notes']['amountToPay'];
                $subscription = Subscription::findOrFail($subscriptionID);


                Subscription::findOrFail($subscriptionID)->update([
                    'payment_type' => Subscription::RAZORPAY,
                    'status' => Subscription::ACTIVE
                ]);

                // De-Active all other subscription
                Subscription::whereTenantId(getLogInTenantId())
                    ->where('id', '!=', $subscriptionID)
                    ->where('status', '!=', Subscription::REJECT)
                    ->update([
                        'status' => Subscription::INACTIVE,
                    ]);

                $transaction = Transaction::create([
                    'tenant_id' => $subscription->tenant_id,
                    'transaction_id' => $payment->id,
                    'type' => SUBSCRIPTION::RAZORPAY,
                    'amount' => $amountToPay,
                    'status' => Subscription::ACTIVE,
                    'meta' => json_encode($payment->toArray()),
                ]);

                $subscription = Subscription::findOrFail($subscriptionID);
                $planName = $subscription->plan->name;
                $subscription->update(['transaction_id' => $transaction->id]);

                $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
                $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');
                if ($affiliateAmountType == 1) {
                    AffiliateUser::whereUserId(getLogInUserId())->where('amount', 0)->withoutGlobalScopes()->update(['amount' => $affiliateAmount, 'is_verified' => 1]);
                } else if ($affiliateAmountType == 2) {
                    $amount = $amountToPay * $affiliateAmount / 100;
                    AffiliateUser::whereUserId(getLogInUserId())->where('amount', 0)->withoutGlobalScopes()->update(['amount' => $amount, 'is_verified' => 1]);
                }

                $userEmail = getLogInUser()->email;
                $firstName = getLogInUser()->first_name;
                $lastName =  getLogInUser()->last_name;
                $emailData = [
                    'subscriptionID' => $subscriptionID,
                    'amountToPay' => $amountToPay,
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
            } catch (Exception $e) {
                return false;
            }
        }

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function paymentFailed(): View
    {
        return view('sadmin.plans.payment.paymentcancel');
    }

    public function nfcPaymentSuccess(Request $request)
    {
        $input = $request->all();

        $api = new Api(getSelectedPaymentGateway('razorpay_key'), getSelectedPaymentGateway('razorpay_secret'));
        if (count($input) && ! empty($input['razorpay_payment_id'])) {
            try {
                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $generatedSignature = hash_hmac(
                    'sha256',
                    $payment['order_id'] . '|' . $input['razorpay_payment_id'],
                    getSelectedPaymentGateway('razorpay_secret')
                );

                if ($generatedSignature != $input['razorpay_signature']) {
                    return redirect()->back();
                }

                // $nfcOrder = NfcOrders::create([
                //     'name' => $payment['notes']['customer_name'],
                //     'designation' => $payment['notes']['designation'],
                //     'phone' => $payment['notes']['phone'],
                //     'email' => $payment['notes']['email'],
                //     'address' => $payment['notes']['address'],
                //     'company_name' => $payment['notes']['company_name'],
                //     'order_status' => NfcOrders::PENDING,
                //     'card_type' => $payment['notes']['card_type'],
                //     'user_id' => getLogInUserId(),
                //     'vcard_id' => $payment['notes']['vcard_id'],

                // ]);

                $id = session()->get('orderid');
                NfcOrders::where('id', $id)->update(['order_status' => NfcOrders::PENDING]);
                $nfcOrder = NfcOrders::where('id', $id)->get();

                $vcardName = VCard::find($nfcOrder[0]->vcard_id)->name;
                $cardType = Nfc::find($nfcOrder[0]->card_type)->name;

                $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
                $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
                $tax = null;

                if ($isTaxEnabled && $taxValue > 0) {
                    $tax = $taxValue;
                }

                NfcOrderTransaction::create([
                    'nfc_order_id' => $id,
                    'type' => NfcOrders::RAZOR_PAY,
                    'transaction_id' => $payment->id,
                    'amount' => $payment['notes']['amountToPay'],
                    'user_id' => getLogInUser()->id,
                    'status' => NfcOrders::SUCCESS,
                    'tax' => $tax,
                ]);

                Mail::to(getSuperAdminSettingValue('email'))->send(new AdminNfcOrderMail($nfcOrder[0], $vcardName, $cardType));

                Flash::success(__('messages.nfc.order_placed_success'));

                return redirect(route('user.orders'));
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return false;
            }
        }

        return redirect()->back();
    }

    public function nfcPaymentFailed(Request $request): View
    {
        $input = $request->all();
        $api = new Api(getSelectedPaymentGateway('razorpay_key'), getSelectedPaymentGateway('razorpay_secret'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        $id = session()->get('orderid');
        NfcOrders::where('id', $id)->update(['order_status' => NfcOrders::PENDING]);
        $nfcOrder = NfcOrders::where('id', $id)->get();

        $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
        $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
        $tax = null;

        if ($isTaxEnabled && $taxValue > 0) {
            $tax = $taxValue;
        }

        NfcOrderTransaction::create([
            'nfc_order_id' => $id,
            'type' => NfcOrders::RAZOR_PAY,
            'transaction_id' => $payment->id,
            'amount' => $payment['notes']['amountToPay'],
            'user_id' => getLogInUser()->id,
            'status' => NfcOrders::FAIL,
            'tax' => $tax,
        ]);

        return view('sadmin.plans.payment.paymentcancel');
    }

    public function productPaymentSuccess(Request $request)
    {
        $input = $request->all();
        $product = Session::get('productId');
        $userId = $product->vcard->user->id;
        $api = new Api(getUserSettingValue('razorpay_key', $userId), getUserSettingValue('razorpay_secret', $userId));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        $generatedSignature = hash_hmac(
            'sha256',
            $payment['order_id'] . '|' . $input['razorpay_payment_id'],
            getSelectedPaymentGateway('razorpay_secret')
        );

        if ($generatedSignature != $input['razorpay_signature']) {
            return redirect()->back();
        }
        if (empty($product->currency_id)) {
            $product->currency_id = getUserSettingValue('currency_id', $userId);
        }
        $currencyId = Currency::whereId($product->currency_id)->first()->id;
        $name = $payment['notes']['name'];
        $email = $payment['notes']['email'];
        $contact = $payment['contact'];
        $address = $payment['notes']['address'];
        $currency = $payment['currency'];
        $payment_type = $payment['notes']['payment_type'];
        $amount = $payment['amount'] / 100;
        $transaction_id = $payment['id'];
        try {
            DB::beginTransaction();

            ProductTransaction::create([
                'product_id' => $product->id,
                'name' => $name,
                'email' => $email,
                'phone' => $contact,
                'address' => $address,
                'currency_id' => $currencyId,
                'meta' => json_encode($payment),
                'type' =>  $payment_type,
                'transaction_id' => $transaction_id,
                'amount' => $amount,
            ]);

            $vcardData = Session::get('product_vcard_data', [
                'default_language' => $product->vcard->default_language,
                'url_alias' => $product->vcard->url_alias,
            ]);

            $orderMailData = [
                'user_name' => $product->vcard->user->full_name,
                'customer_name' => $name,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'phone' => $contact,
                'address' => $address,
                'payment_type' => __('messages.razorpay'),
                'order_date' => Carbon::now()->format('d M Y'),
            ];

            if (getUserSettingValue('product_order_send_mail_customer', $userId)) {
                Mail::to($email)->send(new ProductOrderSendCustomer($orderMailData,$vcardData['default_language'],$vcardData['url_alias']));
            }

            if (getUserSettingValue('product_order_send_mail_user', $userId)) {
                Mail::to($product->vcard->user->email)->send(new ProductOrderSendUser($orderMailData,$vcardData['default_language'],$vcardData['url_alias']));
            }

            $vcard = $product->vcard;
            App::setLocale(Session::get('languageChange_' . $vcard->url_alias));
            session()->forget(['productId', 'product_vcard_data']);
            DB::commit();

            return redirect(route('showProducts', [$vcard->id, $vcard->url_alias, __('messages.placeholder.product_purchase')]));
        } catch (HttpException $ex) {
            print_r($ex->getMessage());
        }
    }

    public function productPaymentFailed(Request $request): View
    {
        $input = $request->all();
        $product = Session::get('productId');
        $userId = $product->vcard->user->id;
        $api = new Api(getUserSettingValue('razorpay_key', $userId), getUserSettingValue('razorpay_secret', $userId));
        $vcard = $product->vcard;
        session()->forget('productId');
        Flash::error(__('messages.placeholder.payment_cancel'));

        return redirect(route('showProducts', [$vcard->id, $vcard->url_alias]));
    }

    public function razorPayPaymentSuccess(Request $request)
    {
        try {
            $userId = session()->get('vcard_user_id');
            $urlAlias = session()->get('alias');
            $vcardId = session()->get('vcard_id');

            $api = new Api(getUserSettingValue('razorpay_key', $userId), getUserSettingValue('razorpay_secret', $userId));

            if (isset($request->razorpay_payment_id) && !empty($request->razorpay_payment_id)) {
                $payment = $api->payment->fetch($request->razorpay_payment_id);

                if ($payment->status != 'captured') {
                    $response = $payment->capture(array('amount' => $payment->amount));
                }

                if ($payment->status == 'captured') {
                    $input = $payment->toArray();

                    $data = $input['notes'];
                    $amount = $input['amount'] / 100;
                    $vcardId = $vcardId;
                    $tenantId = session()->get('tenant_id');
                    $transactionId = $input['id'];
                    $currencyCode = $input['currency'];
                    $tenantId = session()->get('tenant_id');
                    $currencyId = Currency::whereCurrencyCode($currencyCode)->first()->id;
                    $vcard = Vcard::with('tenant.user')->where('id', $vcardId)->first();

                    $transactionDetails = [
                        'vcard_id' => $vcardId,
                        'transaction_id' => $transactionId,
                        'currency_id' => $currencyId,
                        'amount' => $amount,
                        'tenant_id' => $tenantId,
                        'type' => Appointment::RAZORPAY,
                        'status' => Transaction::SUCCESS,
                        'meta' => json_encode($data),
                    ];

                    $appointmentTran = AppointmentTransaction::create($transactionDetails);
                    $appointmentInput = session()->get('appointment_details');
                    session()->forget('appointment_details');
                    $appointmentInput['appointment_tran_id'] = $appointmentTran->id;
                    $vcardData = session()->get('appointment_vcard_data', [
                        'default_language' => $vcard->default_language,
                        'url_alias' => $vcard->url_alias,
                    ]);

                    /** @var AppointmentRepository $appointmentRepo */
                    $appointmentRepo = App::make(AppointmentRepository::class);
                    $vcardEmail = is_null($vcard->email) ? $vcard->tenant->user->email : $vcard->email;
                    $appointmentRepo->appointmentStoreOrEmail($appointmentInput, $vcardEmail, $vcardData['default_language'], $vcardData['url_alias']);

                    session()->forget(['vcard_user_id', 'tenant_id', 'vcard_id', 'alias', 'appointment_vcard_data']);

                    Flash::success(__('messages.placeholder.payment_done'));
                    App::setLocale(Session::get('languageChange_' . $vcard->url_alias));

                    return redirect(route('vcard.show', [$urlAlias, __('messages.placeholder.appointment_created')]));
                }

                return redirect(route('vcard.show', [$urlAlias, __('Something went wrong!')]));
            }
        } catch (HttpException $ex) {
            return redirect(route('vcard.show', [$urlAlias, __('Something went wrong!')]));
        }
    }
}
