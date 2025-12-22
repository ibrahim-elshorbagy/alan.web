<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Nfc;
use App\Models\Plan;
use App\Models\Vcard;
use App\Models\Product;
use App\Models\Currency;
use App\Models\NfcOrders;
use Laracasts\Flash\Flash;
use App\Models\Appointment;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\AffiliateUser;
use App\Mail\AdminNfcOrderMail;
use App\Mail\ProductOrderSendUser;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\NfcOrderTransaction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductOrderSendCustomer;
use App\Models\AppointmentTransaction;
use Stripe\Exception\ApiErrorException;
use App\Repositories\AppointmentRepository;
use App\Mail\SubscriptionPaymentSuccessMail;
use App\Repositories\SubscriptionRepository;

class PayfastController extends Controller
{
    protected $subscriptionRepository;
    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function payfastSubscription(Request $request)
    {
        try {
            $merchant_id = getSelectedPaymentGateway('payfast_merchant_id');
            $merchant_key = getSelectedPaymentGateway('payfast_merchant_key');
            $passphrase = getSelectedPaymentGateway('payfast_passphrase_key');
            $sandbox = getSelectedPaymentGateway('payfast_mode') == 'sandbox' ? true : false;

            if (empty($merchant_id) || empty($merchant_key)) {
                Flash::error(__('messages.placeholder.please_add_payment_credentials'));
                return Redirect()->back();
            }

            $plan = Plan::with('currency')->findOrFail($request->planId);
            $currency = $plan->currency->currency_code;

            if ($currency != "ZAR") {
                Flash::error(__('messages.placeholder.currency_supported_payfast'));
                return Redirect()->back();
            }

            $data = $this->subscriptionRepository->manageSubscription($request->all());

            if (!isset($data['plan'])) {
                if (isset($data['status']) && $data['status'] == true) {
                    Flash::error(__('messages.subscription_pricing_plans.has_been_subscribed'));
                    return Redirect()->back();
                } else {
                    if (isset($data['status']) && $data['status'] == false) {
                        Flash::error(__('messages.placeholder.cannot_switch_to_zero'));
                        return Redirect()->back();
                    }
                }
            }

            $subscriptionsPricingPlan = $data['plan'];
            $subscription = $data['subscription'];
            $amount = number_format($data['amountToPay'], 2, '.', '');
            $reference = 'sub_' . uniqid();
            $data['m_payment_id'] = $reference;

            $payfastData = [
                'merchant_id' => $merchant_id,
                'merchant_key' => $merchant_key,
                'return_url' => route('payfast.subscription.success', $data),
                'cancel_url' => route('payfast.subscription.failed', $data),
                'name_first' => $request->user()->full_name,
                'email_address' => $request->user()->email,
                'm_payment_id' => $reference,
                'amount' => $amount,
                'item_name' => 'Subscription Plan - ' . $subscriptionsPricingPlan->name,
            ];

            $queryString = http_build_query($payfastData);
            if (!empty($passphrase)) {
                $queryString .= '&passphrase=' . urlencode($passphrase);
            }
            $signature = md5($queryString);
            $payfastData['signature'] = $signature;


            $baseUrl = $sandbox ? 'https://sandbox.payfast.co.za/eng/process' : 'https://www.payfast.co.za/eng/process';
            $payfastUrl = $baseUrl . '?' . http_build_query($payfastData);

            return redirect()->away($payfastUrl);
        } catch (\Exception $e) {

            Log::error('Payfast Subscription Error: ' . $e->getMessage());

            Flash::error($e->getMessage());
            return Redirect()->back();
        }
    }

    public function payfastSubscriptionSuccess(Request $request)
    {
        $input = $request->all();
        $subscriptionID = $input['subscription'];

        Subscription::findOrFail($subscriptionID)->update(['status' => Subscription::ACTIVE]);

        // De-activate all other subscriptions
        Subscription::whereTenantId(getLogInTenantId())
            ->where('id', '!=', $subscriptionID)
            ->where('status', '!=', Subscription::REJECT)
            ->update(['status' => Subscription::INACTIVE]);

        $transaction = Transaction::create([
            'tenant_id' => getLogInTenantId(),
            'transaction_id' => $input['m_payment_id'],
            'type' => Subscription::PAYFAST,
            'amount' => $input['amountToPay'],
            'status' => Subscription::ACTIVE,
        ]);

        Subscription::findOrFail($subscriptionID)->update(['transaction_id' => $transaction->id]);

        $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
        $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');

        if ($affiliateAmountType == 1) {
            AffiliateUser::whereUserId(getLogInUserId())->where('amount', 0)->withoutGlobalScopes()
                ->update(['amount' => $affiliateAmount, 'is_verified' => 1]);
        } else if ($affiliateAmountType == 2) {
            $commission = $input['amountToPay'] * $affiliateAmount / 100;
            AffiliateUser::whereUserId(getLogInUserId())->where('amount', 0)->withoutGlobalScopes()
                ->update(['amount' => $commission, 'is_verified' => 1]);
        }

        $user = getLogInUser();
        Mail::to($user->email)->send(new SubscriptionPaymentSuccessMail([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'planName' => Subscription::findOrFail($subscriptionID)->plan->name,
        ]));

        if (moduleExists('SlackIntegration')) {
            $slackIntegration = SlackIntegration::first();

            if ($slackIntegration && $slackIntegration->user_plan_purchase_notification == 1 && !empty($slackIntegration->webhook_url)) {
                $message = "🔔 New Plan Purchased !!!\nPlan {$user->plan->name} Purchased by {$user->first_name} {$user->last_name} Successfully.";
                $slackIntegration->notify(new SlackNotification($message));
            }
        }


        return view('sadmin.plans.payment.paymentSuccess');
    }


    public function payfastSubscriptionCancel(Request $request)
    {
        $input = $request->all();
        $subscriptionID = $input['subscription'];
        $subscription = Subscription::findOrFail($subscriptionID);
        $subscription->delete();

        return view('sadmin.plans.payment.paymentcancel');
    }


    public function nfcOrder($orderId, $email, $nfc)
    {
        try {
            $merchant_id = getSelectedPaymentGateway('payfast_merchant_id');
            $merchant_key = getSelectedPaymentGateway('payfast_merchant_key');
            $passphrase = getSelectedPaymentGateway('payfast_passphrase_key');
            $sandbox = getSelectedPaymentGateway('payfast_mode') == 'sandbox' ? true : false;

            $baseAmount = $nfc->nfcCard->price * $nfc->quantity;
            $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
            $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
            $taxAmount = 0;

            if ($isTaxEnabled && $taxValue > 0) {
                $taxAmount = ($baseAmount * $taxValue) / 100;
            }

            $amount = $baseAmount + $taxAmount;

            $reference = 'nfc_' . uniqid();

            $data = [
                'order_id' => $orderId,
                'nfc' => $nfc,
                'amountToPay' => $amount,
                'm_payment_id' => $reference,
            ];

            $payfastData = [
                'merchant_id' => $merchant_id,
                'merchant_key' => $merchant_key,
                'return_url' => route('nfc.payfast.success', $data),
                'cancel_url' => route('nfc.payfast.failed', $data),
                'name_first' => getLogInUser()->full_name,
                'email_address' => $email,
                'm_payment_id' => $reference,
                'amount' => $amount,
                'item_name' => 'NFC Card - ' . $nfc->nfcCard->name,
            ];

            $queryString = http_build_query($payfastData);
            if (!empty($passphrase)) {
                $queryString .= '&passphrase=' . urlencode($passphrase);
            }
            $signature = md5($queryString);

            $payfastData['signature'] = $signature;


            $baseUrl = $sandbox ? 'https://sandbox.payfast.co.za/eng/process' : 'https://www.payfast.co.za/eng/process';
            $payfastUrl = $baseUrl . '?' . http_build_query($payfastData);

            return $payfastUrl;
        } catch (\Exception $e) {
            Log::error('Payfast NFC Order Error: ' . $e->getMessage());
            Flash::error($e->getMessage());
            return Redirect()->back();
        }
    }

    public function nfcPurchaseSuccess(Request $request)
    {
        $input = $request->all();

        $nfcOrder = NfcOrders::get()->find($input['order_id']);

        $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
        $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
        $tax = null;

        if ($isTaxEnabled && $taxValue > 0) {
            $tax = $taxValue;
        }

        NfcOrderTransaction::create([
            'nfc_order_id' => $input['order_id'],
            'type' => NfcOrders::PAYFAST,
            'transaction_id' => $input['m_payment_id'],
            'amount' => $input['amountToPay'],
            'user_id' => getLogInUser()->id,
            'status' => NfcOrders::SUCCESS,
            'tax' => $tax,
        ]);

        $vcardName = Vcard::find($nfcOrder['vcard_id'])->name;
        $cardType = Nfc::find($nfcOrder['card_type'])->name;

        App::setLocale(getLogInUser()->language);

        Mail::to(getSuperAdminSettingValue('email'))->send(new AdminNfcOrderMail($nfcOrder, $vcardName, $cardType));

        Flash::success(__('messages.nfc.order_placed_success'));

        return redirect(route('user.orders'));
    }

    public function nfcPurchaseFailed(Request $request)
    {
        $input = $request->all();

        $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
        $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
        $tax = null;

        if ($isTaxEnabled && $taxValue > 0) {
            $tax = $taxValue;
        }

        NfcOrderTransaction::create([
            'nfc_order_id' => $input['order_id'],
            'type' => NfcOrders::PAYFAST,
            'amount' => $input['amountToPay'],
            'user_id' => getLogInUser()->id,
            'status' => NfcOrders::FAIL,
            'tax' => $tax,
        ]);

        Flash::error(__('messages.placeholder.payment_cancel'));

        return redirect(route('user.orders'));
    }

    public function productBuy($input, $product, $userId)
    {
        try {
            $merchant_id = getUserSettingValue('payfast_merchant_id', $userId);
            $merchant_key = getUserSettingValue('payfast_merchant_key', $userId);
            $passphrase = getUserSettingValue('payfast_passphrase_key', $userId);
            $sandbox = getUserSettingValue('payfast_mode', $userId) == 'sandbox' ? true : false;

            $amount = $product->price;

            $reference = 'product_' . uniqid();

            $data = [
                'product' => $product,
                'amountToPay' => $amount,
                'm_payment_id' => $reference,
                'name' => $input['name'] ?? '',
                'email' => $input['email'] ?? '',
                'phone' => $input['phone'] ?? '',
                'address' => $input['address'] ?? '',
                'vcard_default_language' => $product->vcard->default_language,
                'vcard_url_alias' => $product->vcard->url_alias,
            ];

            $payfastData = [
                'merchant_id' => $merchant_id,
                'merchant_key' => $merchant_key,
                'return_url' => route('product.payfast.success', $data),
                'cancel_url' => route('product.payfast.failed', $data),
                'name_first' => $input['name'],
                'email_address' => $input['email'],
                'm_payment_id' => $reference,
                'amount' => $amount,
                'item_name' => 'Product - ' . $product->name,
            ];

            $queryString = http_build_query($payfastData);
            if (!empty($passphrase)) {
                $queryString .= '&passphrase=' . urlencode($passphrase);
            }
            $signature = md5($queryString);

            $payfastData['signature'] = $signature;


            $baseUrl = $sandbox ? 'https://sandbox.payfast.co.za/eng/process' : 'https://www.payfast.co.za/eng/process';
            $payfastUrl = $baseUrl . '?' . http_build_query($payfastData);

            return $payfastUrl;
        } catch (\Exception $e) {
            Log::error('Payfast NFC Order Error: ' . $e->getMessage());
            Flash::error($e->getMessage());
            return Redirect()->back();
        }
    }

    public function productBuySuccess(Request $request)
    {
        $input = $request->all();

        $product = Product::whereId($input['product'])->first();
        $userId = $product->vcard->user->id;

        if (empty($product->currency_id)) {
            $product->currency_id = getUserSettingValue('currency_id', $userId);
        }
        $currencyId = Currency::whereId($product->currency_id)->first()->id;

        try {

            DB::beginTransaction();

            ProductTransaction::create([
                'product_id' => $input['product'],
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'address' => $input['address'],
                'currency_id' => $currencyId,
                'type' =>  Product::PAYFAST,
                'transaction_id' => $input['m_payment_id'],
                'amount' => $input['amountToPay'],
            ]);

            $vcardDefaultLanguage = $input['vcard_default_language'];
            $vcardUrlAlias = $input['vcard_url_alias'];

            $orderMailData = [
                'user_name' => $product->vcard->user->full_name,
                'customer_name' => $input['name'],
                'product_name' => $product->name,
                'product_price' => $product->price,
                'phone' => $input['phone'] ?? '',
                'address' => $input['address'] ?? '',
                'payment_type' => __('messages.payfast'),
                'order_date' => Carbon::now()->format('d M Y'),
            ];

            if (getUserSettingValue('product_order_send_mail_customer', $userId)) {
                Mail::to($input['email'])->send(new ProductOrderSendCustomer($orderMailData,$vcardDefaultLanguage,$vcardUrlAlias));
            }

            if (getUserSettingValue('product_order_send_mail_user', $userId)) {
                Mail::to($product->vcard->user->email)->send(new ProductOrderSendUser($orderMailData,$vcardDefaultLanguage,$vcardUrlAlias));
            }

            $vcard = $product->vcard;

            DB::commit();

            return redirect(route('showProducts', [$vcard->id, $vcard->url_alias, __('messages.placeholder.product_purchase')]));
        } catch (ApiErrorException $e) {
            DB::rollBack();

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function productBuyFailed(Request $request)
    {
        $input = $request->all();
        $product = Product::whereId($input['product'])->first();
        $vcard = $product->vcard;

        Flash::error(__('messages.placeholder.payment_cancel'));

        return redirect(route('showProducts', [$vcard->id, $vcard->url_alias]));
    }

    public function appointmentBook($userId, $vcard, $input)
    {

        try {
            $merchant_id = getUserSettingValue('payfast_merchant_id', $userId);
            $merchant_key = getUserSettingValue('payfast_merchant_key', $userId);
            $passphrase = getUserSettingValue('payfast_passphrase_key', $userId);
            $sandbox = getUserSettingValue('payfast_mode', $userId) == 'sandbox' ? true : false;

            $amount = $input['amount'];

            $reference = 'appointment_' . uniqid();
            $input['m_payment_id'] = $reference;

            $input['vcard_default_language'] = $vcard->default_language;
            $input['vcard_url_alias'] = $vcard->url_alias;

            $payfastData = [
                'merchant_id' => $merchant_id,
                'merchant_key' => $merchant_key,
                'return_url' => route('appointment.payfast.success', $input),
                'cancel_url' => route('appointment.payfast.failed', $input),
                'name_first' => $input['name'],
                'email_address' => $input['email'],
                'm_payment_id' => $reference,
                'amount' => number_format($amount, 2, '.', ''),
                'item_name' => 'Appointment - ' . $vcard->name,
            ];

            $queryString = http_build_query($payfastData);
            if (!empty($passphrase)) {
                $queryString .= '&passphrase=' . urlencode($passphrase);
            }
            $signature = md5($queryString);

            $payfastData['signature'] = $signature;
            $baseUrl = $sandbox ? 'https://sandbox.payfast.co.za/eng/process' : 'https://www.payfast.co.za/eng/process';
            $payfastUrl = $baseUrl . '?' . http_build_query($payfastData);

            return $payfastUrl;
        } catch (\Exception $e) {
            Log::error('Payfast Appointment Booking Error: ' . $e->getMessage());
            Flash::error($e->getMessage());
            return Redirect()->back();
        }
    }

    public function appointmentBookSuccess(Request $request)
    {
        $input = $request->all();

        $vcard = Vcard::with('tenant.user', 'template')->where('id', $input['vcard_id'])->first();

        $userId = $vcard->tenant->user->id;

        try {
            DB::beginTransaction();

            $appointmentTran = AppointmentTransaction::create([
                'vcard_id' => $vcard->id,
                'transaction_id' => $input['m_payment_id'],
                'currency_id' => $input['currency_id'] ?? getUserSettingValue('currency_id', $userId),
                'amount' => $input['amount'],
                'tenant_id' => $vcard->tenant->id,
                'type' => Appointment::PAYFAST,
                'status' => Transaction::SUCCESS,
            ]);

            $input['appointment_tran_id'] = $appointmentTran->id;
            $vcardDefaultLanguage = $input['vcard_default_language'];
            $vcardUrlAlias = $input['vcard_url_alias'];
            /** @var AppointmentRepository $appointmentRepo */
            $appointmentRepo = App::make(AppointmentRepository::class);
            $vcardEmail = is_null($vcard->email) ? $vcard->tenant->user->email : $vcard->email;
            $appointmentRepo->appointmentStoreOrEmail($input, $vcardEmail,$vcardDefaultLanguage, $vcardUrlAlias);
            $url = ($vcard->template->name == 'vcard11') ? $vcard->url_alias . '/contact' : $vcard->url_alias;

            DB::commit();

            Flash::success('Payment successfully done');

            return redirect(route('vcard.show', [$url, __('messages.placeholder.appointment_created')]));
        } catch (ApiErrorException $e) {

            DB::rollBack();

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function appointmentBookFailed(Request $request)
    {
        $input = $request->all();

        Flash::error(__('messages.placeholder.payment_cancel'));

        return redirect(route('vcard.show',  $input['alias']));
    }
}
