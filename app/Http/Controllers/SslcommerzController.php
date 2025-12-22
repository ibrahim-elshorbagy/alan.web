<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\AffiliateUser;
use App\Models\PaymentSession;
use App\Mail\AdminNfcOrderMail;
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
use Raziul\Sslcommerz\Facades\Sslcommerz;
use App\Repositories\AppointmentRepository;
use App\Mail\SubscriptionPaymentSuccessMail;
use App\Repositories\SubscriptionRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SslcommerzController extends AppBaseController
{
    protected $subscriptionRepository;
    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }
    public function pay(Request $request)
    {
        $planId = $request->input('planId');
        $customFieldId = $request->input('customFieldId');
        $tenantId = $request->input('tenant_id');
        $plan = Plan::with('currency')->findOrFail($planId);
        $currency = $plan->currency->currency_code;

        if ($currency != "BDT") {
            Flash::error(__('messages.placeholder.currency_not_supported_sslcommerz'));
            return Redirect()->back();
        }

        $data = $this->subscriptionRepository->manageSubscription($request->all());

        if (!isset($data['plan'])) {
            if (isset($data['status']) && $data['status'] == true) {
                Flash::error(__('messages.subscription.has_been_subscribed'));
                return Redirect()->back();
            } else {
                if (isset($data['status']) && $data['status'] == false) {
                    Flash::error(__('messages.placeholder.cannot_switch_to_zero'));
                    return Redirect()->back();
                }
            }
        }
        $amount = $data['amountToPay'];
        $subscription = $data['subscription'];
        $invoice = (string) Str::uuid();

        PaymentSession::create([
            'invoice_id' => $invoice,
            'user_id' => getLogInUserId(),
            'tenant_id' => $tenantId,
            'plan_id' => $planId,
            'subscription_id' => $subscription->id,
            'amount' => $amount,
            'custom_field_id' => $customFieldId,
            'payment_type' => 'subscription',
        ]);

        $storeId = getSelectedPaymentGateway('sslc_store_id');
        $storePassword = getSelectedPaymentGateway('sslc_store_password');
        $mode = getSelectedPaymentGateway('sslcommerz_mode');
        $sandbox = strtolower($mode) === 'sandbox';

        if (is_null($mode)) {
            $sandbox = env('SSLC_SANDBOX', true);
        }

        if (empty($storeId) || empty($storePassword) || empty($mode)) {
            Flash::error(__('messages.placeholder.please_add_payment_credentials'));
            return redirect()->back();
        }

        config([
            'sslcommerz.sandbox' => $sandbox,
            'sslcommerz.store.id' => $storeId,
            'sslcommerz.store.password' => $storePassword,
        ]);

        $response = Sslcommerz::setOrder($amount, $invoice, $plan->name)
            ->setCustomer(Auth::user()->fullName, Auth::user()->email)
            ->setShippingInfo(0, 'NO')
            ->makePayment();

        if ($response->success()) {
            return redirect($response->gatewayPageURL());
        }
        $subscription->delete();
        PaymentSession::where('invoice_id', $invoice)->delete();

        Flash::error(__('messages.placeholder.failed_to_initiate_payment'));
        return redirect()->back();
    }

    public function nfcOrder($orderId, $email, $nfc)
    {
        try {
            $storeId = getSelectedPaymentGateway('sslc_store_id');
            $storePassword = getSelectedPaymentGateway('sslc_store_password');
            $mode = getSelectedPaymentGateway('sslcommerz_mode');
            $sandbox = strtolower($mode) === 'sandbox';
            if (is_null($mode)) {
                $sandbox = env('SSLC_SANDBOX', true);
            }

            if (empty($storeId) || empty($storePassword) || empty($mode)) {
                Flash::error(__('messages.placeholder.please_add_payment_credentials'));
                return redirect()->back();
            }

            config([
                'sslcommerz.sandbox' => $sandbox,
                'sslcommerz.store.id' => $storeId,
                'sslcommerz.store.password' => $storePassword,
            ]);

            $baseAmount = $nfc->nfcCard->price * $nfc->quantity;
            $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
            $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
            $taxAmount = 0;

            if ($isTaxEnabled && $taxValue > 0) {
                $taxAmount = ($baseAmount * $taxValue) / 100;
            }

            $amount = $baseAmount + $taxAmount;
            $invoice = Str::uuid();

            $data = [
                'order_id' => $orderId,
                'nfc' => $nfc,
                'amountToPay' => $amount,
                'invoice_id' => $invoice,
            ];

            PaymentSession::create([
                'invoice_id' => $invoice,
                'user_id' => getLogInUserId(),
                'amount' => $amount,
                'payment_type' => 'nfc',
                'meta' => json_encode($data),
            ]);

            $itemName = $nfc->nfcCard->name;
            $customerName = getLogInUser()->fullName;

            $response = Sslcommerz::setOrder($amount, $invoice, $itemName)
                ->setCustomer($customerName, $email)
                ->setShippingInfo($nfc->quantity, $nfc->address)
                ->makePayment();

            if ($response->success()) {
                return $response->gatewayPageURL();
            }

            Flash::error(__('messages.placeholder.failed_to_initiate_payment'));
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('SSLCommerz NFC Order Error: ' . $e->getMessage());
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function productBuy($input, $product)
    {
        try {
            $userId = $product->vcard->user->id;
            $storeId = getUserSettingValue('sslc_store_id', $userId);
            $storePassword = getUserSettingValue('sslc_store_password', $userId);
            $mode = getUserSettingValue('sslcommerz_mode', $userId);
            $sandbox = strtolower($mode) === 'sandbox';
            if (is_null($mode)) {
                $sandbox = env('SSLC_SANDBOX', true);
            }

            if (empty($storeId) || empty($storePassword) || empty($mode)) {
                Flash::error(__('messages.placeholder.please_add_payment_credentials'));
                return redirect()->back();
            }

            config([
                'sslcommerz.sandbox' => $sandbox,
                'sslcommerz.store.id' => $storeId,
                'sslcommerz.store.password' => $storePassword,
            ]);

            $invoice = Str::uuid();
            $amount = $product->price;
            if (empty($product->currency_id)) {
                $product->currency_id = getUserSettingValue('currency_id', $userId);
            }
            $currencyCode = Currency::whereId($product->currency_id)->first()->id;
            $productId = Product::whereId($input['product_id'])->first();
            $productName = $productId->name;
            $data = [
                'invoice_id' => $invoice,
                'product_id' => $input['product_id'],
                'product_name' => $productName,
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'address' => $input['address'],
                'currency_id' => $currencyCode,
                'type' =>  $input['payment_method'],
                'transaction_id' => $invoice,
                'amount' => $amount,
            ];

            PaymentSession::create([
                'invoice_id' => $invoice,
                'user_id' => $userId,
                'amount' => $amount,
                'currency' => $currencyCode,
                'payment_type' => 'productBuy',
                'meta' => json_encode($data),
            ]);

            $customerName = getLogInUser()->fullName;
            $email = $input['email'];

            $response = Sslcommerz::setOrder($amount, $invoice, $productName)
                ->setCustomer($customerName, $email)
                ->setShippingInfo(0, $input['address'])
                ->makePayment();

            if ($response->success()) {
                return $response->gatewayPageURL();
            }

            Flash::error(__('messages.placeholder.failed_to_initiate_payment'));
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('SSLCommerz NFC Order Error: ' . $e->getMessage());
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function success(Request $request)
    {
        $tranId = $request->tran_id;
        $amount = (float) $request->amount;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();

        if (!$paymentData) {
            Flash::error(__('messages.placeholder.payment_session_not_found'));
            return redirect()->route('home');
        }

        if ($paymentData->payment_type == 'subscription' || $paymentData->payment_type == 'nfc') {
            $storeId = getSelectedPaymentGateway('sslc_store_id');
            $storePassword = getSelectedPaymentGateway('sslc_store_password');
            $mode = getSelectedPaymentGateway('sslcommerz_mode');
            $sandbox = strtolower($mode) === 'sandbox';
            if (is_null($mode)) {
                $sandbox = env('SSLC_SANDBOX', true);
            }

            if (empty($storeId) || empty($storePassword) || empty($mode)) {
                Flash::error(__('messages.placeholder.please_add_payment_credentials'));
                return redirect()->back();
            }

            config([
                'sslcommerz.sandbox' => $sandbox,
                'sslcommerz.store.id' => $storeId,
                'sslcommerz.store.password' => $storePassword,
            ]);
        } elseif ($paymentData->payment_type == 'appointment' || $paymentData->payment_type == 'productBuy') {
            $userId = $paymentData->user_id;
            $storeId = getUserSettingValue('sslc_store_id', $userId);
            $storePassword = getUserSettingValue('sslc_store_password', $userId);
            $mode = getUserSettingValue('sslcommerz_mode', $userId);
            $sandbox = strtolower($mode) === 'sandbox';
            if (is_null($mode)) {
                $sandbox = env('SSLC_SANDBOX', true);
            }

            if (empty($storeId) || empty($storePassword) || empty($mode)) {
                Flash::error(__('messages.placeholder.please_add_payment_credentials'));
                return redirect()->back();
            }

            config([
                'sslcommerz.sandbox' => $sandbox,
                'sslcommerz.store.id' => $storeId,
                'sslcommerz.store.password' => $storePassword,
            ]);
        }

        if (!Sslcommerz::validatePayment($request->all(), $tranId, $amount)) {
            $paymentData->delete();
            Flash::error(__('messages.placeholder.payment_verification_failed'));
            return redirect()->route('home');
        }

        switch ($paymentData->payment_type) {
            case 'subscription':
                return $this->handleSubscriptionSuccess($request, $paymentData);
            case 'appointment':
                return $this->handleAppointmentSuccess($request, $paymentData);
            case 'nfc':
                return $this->handleNfcSuccess($request, $paymentData);
            case 'productBuy':
                return $this->handleProductBuySuccess($request, $paymentData);
            default:
                Flash::error(__('messages.placeholder.invalid_payment_type'));
                return redirect()->route('home');
        }
    }

    private function handleSubscriptionSuccess(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;
        $amount = (float) ($request->amount);

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();

        if (!$paymentData) {
            Flash::error(__('messages.placeholder.payment_session_not_found'));
            return redirect()->route('subscription.index');
        }

        if (!Sslcommerz::validatePayment($request->all(), $tranId, $amount)) {
            PaymentSession::where('invoice_id', $tranId)->delete();
            Flash::error(__('messages.placeholder.payment_verification_failed'));
            return redirect()->route('subscription.index');
        }

        $subscription = Subscription::findOrFail($paymentData->subscription_id);

        $subscription->update([
            'payment_type' => Subscription::SSLCOMMERZ,
            'status' => Subscription::ACTIVE,
        ]);

        Subscription::whereTenantId($paymentData->tenant_id)
            ->where('id', '!=', $subscription->id)
            ->where('status', '!=', Subscription::REJECT)
            ->update(['status' => Subscription::INACTIVE]);

        $transaction = Transaction::create([
            'tenant_id' => $subscription->tenant_id,
            'transaction_id' => $tranId,
            'type' => Subscription::SSLCOMMERZ,
            'amount' => $paymentData->amount,
            'status' => Subscription::ACTIVE,
            'meta' => json_encode($request->all()),
        ]);

        $subscription->update(['transaction_id' => $transaction->id]);
        $amountToPay = $paymentData->amount;

        $userId = $subscription->tenant->user->id;

        if ($userId) {
            $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
            $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');

            if ($affiliateAmountType == 1) {
                AffiliateUser::whereUserId($userId)->where('amount', 0)->withoutGlobalScopes()->update(['amount' => $affiliateAmount, 'is_verified' => 1]);
            } else if ($affiliateAmountType == 2) {
                $amount = $amountToPay * $affiliateAmount / 100;
                AffiliateUser::whereUserId($userId)->where('amount', 0)->withoutGlobalScopes()->update(['amount' => $amount, 'is_verified' => 1]);
            }

            $userEmail = $subscription->tenant->user->email;
            $firstName = $subscription->tenant->user->first_name;
            $lastName = $subscription->tenant->user->last_name;
            $subscriptionID = $paymentData->subscription_id;
            $planName = $subscription->plan->name;
            $emailData = [
                'subscriptionID' => $subscriptionID,
                'amountToPay' => $amountToPay,
                'planName' => $planName,
                'first_name' => $firstName,
                'last_name' => $lastName,
            ];

            manageVcards($subscription->tenant->user);
            Mail::to($userEmail)->send(new SubscriptionPaymentSuccessMail($emailData));
            Flash::success(__('messages.placeholder.purchased_plan'));
            $purchaseUserFullName = implode(' ', [$firstName, $lastName]);
            if (moduleExists('SlackIntegration')) {
                $slackIntegration = SlackIntegration::first();

                if ($slackIntegration && $slackIntegration->user_plan_purchase_notification == 1 && !empty($slackIntegration->webhook_url)) {
                    $message = "🔔 New Plan Purchased !!!\nPlan {$planName} Purchased by {$purchaseUserFullName} Successfully.";
                    $slackIntegration->notify(new SlackNotification($message));
                }
            }
        }

        PaymentSession::where('invoice_id', $tranId)->delete();

        return view('sadmin.plans.payment.paymentSuccess');
    }

    private function handleAppointmentSuccess(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;
        $amount = (float) $request->amount;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();

        if (!$paymentData) {
            Flash::error(__('messages.placeholder.payment_session_not_found'));
            return redirect()->route('vcard.show', ['alias' => $request->alias ?? 'home']);
        }

        if (!Sslcommerz::validatePayment($request->all(), $tranId, $amount)) {
            PaymentSession::where('invoice_id', $tranId)->delete();
            Flash::error(__('messages.placeholder.payment_verification_failed'));
            return redirect()->route('vcard.show', ['alias' => $request->alias ?? 'home']);
        }

        $vcard = Vcard::with('tenant.user', 'template')->where('id', $paymentData->vcard_id)->first();

        try {
            DB::beginTransaction();

            $appointmentTran = AppointmentTransaction::create([
                'vcard_id' => $vcard->id,
                'transaction_id' => $tranId,
                'currency_id' => $paymentData->currency,
                'amount' => $paymentData->amount,
                'tenant_id' => $vcard->tenant_id,
                'type' => Appointment::SSLCOMMERZ,
                'status' => Transaction::SUCCESS,
                'meta' => json_encode($request->all()),
            ]);

            $meta = json_decode($paymentData->meta, true);
            $inputDate = Carbon::parse($meta['date'])->format('Y-m-d');

            $input = [
                'appointment_tran_id' => $appointmentTran->id,
                'vcard_id'      => $vcard->id,
                'vcard_name'    => $vcard->name,
                'name'          => $meta['name'],
                'toName'        => $meta['to_name'],
                'email'         => $meta['email'],
                'phone'         => $meta['phone'],
                'date'          => $inputDate,
                'from_time'     => $meta['from_time'],
                'to_time'       => $meta['to_time'],
                'payment_type'  => Appointment::SSLCOMMERZ,
                'status'        => 0,
            ];

            $appointmentRepo = App::make(AppointmentRepository::class);
            $vcardUserEmail = is_null($vcard->email) ? $vcard->tenant->user->email : $vcard->email;
            $appointmentRepo->appointmentStoreOrEmail($input, $vcardUserEmail);

            PaymentSession::where('invoice_id', $tranId)->delete();
            DB::commit();

            Flash::success(__('messages.payment.payment_success'));
            $url = ($vcard->template->name == 'vcard11') ? $vcard->url_alias . '/contact' : $vcard->url_alias;

            return redirect(route('vcard.show', [$url, __('messages.placeholder.appointment_created')]));
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            Log::error('SSLCommerz Appointment IPN Error: ' . $e->getMessage());
            Flash::error(__('messages.placeholder.payment_failed'));
            return redirect()->route('vcard.show', ['alias' => $request->alias ?? 'home']);
        }
    }

    private function handleNfcSuccess(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;
        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();

        if (!$paymentData) {
            Flash::error(__('messages.placeholder.payment_session_not_found'));
            return redirect(route('user.orders'));
        }

        $userId = $paymentData->user_id;
        $meta = json_decode($paymentData->meta, true);

        if ($request->status !== 'VALID') {
            Flash::error(__('messages.placeholder.payment_failed'));
            return redirect(route('user.orders'));
        }

        $nfcOrder = NfcOrders::find($meta['order_id']);
        if (!$nfcOrder) {
            Flash::error(__('messages.placeholder.order_not_found'));
            return redirect(route('user.orders'));
        }

        $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
        $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
        $tax = null;

        if ($isTaxEnabled && $taxValue > 0) {
            $tax = $taxValue;
        }

        NfcOrderTransaction::create([
            'nfc_order_id' => $meta['order_id'],
            'type' => NfcOrders::SSLCOMMERZ,
            'transaction_id' => $tranId,
            'amount' => $meta['amountToPay'],
            'user_id' => $userId,
            'status' => NfcOrders::SUCCESS,
            'tax' => $tax,
        ]);

        $vcardName = Vcard::find($nfcOrder['vcard_id'])->name;
        $cardType = Nfc::find($nfcOrder['card_type'])->name;

        Mail::to(getSuperAdminSettingValue('email'))->send(new AdminNfcOrderMail($nfcOrder, $vcardName, $cardType));

        PaymentSession::where('invoice_id', $tranId)->delete();

        Flash::success(__('messages.nfc.order_placed_success'));
        return redirect(route('user.orders'));
    }

    public function handleProductBuySuccess(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;
        $amount = (float) $request->amount;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();
        if (!$paymentData) {
            Flash::error(__('messages.placeholder.payment_session_not_found'));
            return redirect(route('vcard.show', ['alias' => $request->alias ?? 'home']));
        }

        $meta = json_decode($paymentData->meta, true);

        $product = Product::whereId($meta['product_id'])->first();
        $userId = $product->vcard->user->id;

        if (empty($product->currency_id)) {
            $product->currency_id = getUserSettingValue('currency_id', $userId);
        }
        $currencyId = Currency::whereId($product->currency_id)->first()->id;

        try {
            DB::beginTransaction();

            ProductTransaction::create([
                'product_id' => $meta['product_id'],
                'name' => $meta['name'],
                'email' => $meta['email'],
                'amount' => $amount,
                'currency_id' => $currencyId,
                'phone' => $meta['phone'],
                'type' => Product::SSLCOMMERZ,
                'status' => Product::APPROVED,
                'transaction_id' => $tranId,
                'address' => $meta['address'],
                'meta' => json_encode($request->all()),
            ]);

            $orderMailData = [
                'user_name' => $product->vcard->user->full_name,
                'customer_name' => $meta['name'],
                'product_name' => $product->name,
                'product_price' => $product->price,
                'phone' => $meta['phone'],
                'address' => $meta['address'],
                'payment_type' => __('messages.Sslcommerz'),
                'order_date' => Carbon::now()->format('d M Y'),
            ];

            if (getUserSettingValue('product_order_send_mail_customer', $userId)) {
                Mail::to($meta['email'])->send(new ProductOrderSendCustomer($orderMailData));
            }

            if (getUserSettingValue('product_order_send_mail_user', $userId)) {
                Mail::to($product->vcard->user->email)->send(new ProductOrderSendUser($orderMailData));
            }

            $vcard = $product->vcard;
            DB::commit();
            PaymentSession::where('invoice_id', $tranId)->delete();
            return redirect(route('showProducts', [$vcard->id, $vcard->url_alias, __('messages.placeholder.product_purchase')]));
        } catch (HttpException $ex) {
            print_r($ex->getMessage());
        }
    }

    public function failure(Request $request)
    {
        $tranId = $request->tran_id;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();

        switch ($paymentData->payment_type) {
            case 'subscription':
                return $this->handleSubscriptionFailure($request, $paymentData);
            case 'appointment':
                return $this->handleAppointmentFailure($request, $paymentData);
            case 'nfc':
                return $this->handleNfcCardOrderFailure($request, $paymentData);
            case 'productBuy':
                return $this->handleProductBuyFailure($request, $paymentData);
            default:
                Flash::error(__('messages.placeholder.invalid_payment_type'));
                return redirect()->route('home');
        }
    }

    private function handleSubscriptionFailure(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();
        if ($paymentData) {
            Subscription::where('id', $paymentData->subscription_id)->delete();
            $paymentData->delete();
        }
        Flash::error(__('messages.placeholder.payment_cancel'));
        return redirect()->route('subscription.index');
    }

    private function handleAppointmentFailure(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();
        $meta = json_decode($paymentData->meta, true);
        $alias = $meta['vcard_alias'];
        if ($paymentData) {
            $paymentData->delete();
        }

        Flash::error(__('messages.placeholder.payment_cancel'));

        return redirect(route('vcard.show',  $alias));
    }

    private function handleNfcCardOrderFailure(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();
        if ($paymentData) {
            $paymentData->delete();
        }

        Flash::error(__('messages.placeholder.payment_cancel'));
        return redirect(route('user.orders'));
    }

    private function handleProductBuyFailure(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();
        $meta = json_decode($paymentData->meta, true);
        $product = Product::whereId($meta['product_id'])->first();
        $vcard = $product->vcard;
        if ($paymentData) {
            $paymentData->delete();
        }

        Flash::error(__('messages.placeholder.payment_cancel'));
        return redirect(route('showProducts', [$vcard->id, $vcard->url_alias]));
    }

    public function cancel(Request $request)
    {
        $tranId = $request->tran_id;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();

        switch ($paymentData->payment_type) {
            case 'subscription':
                return $this->handleSubscriptionCancel($request, $paymentData);
            case 'appointment':
                return $this->handleAppointmentCancel($request, $paymentData);
            case 'nfc':
                return $this->handleNfcCardOrderCancel($request, $paymentData);
            case 'productBuy':
                return $this->handleProductBuyCancel($request, $paymentData);
            default:
                Flash::error(__('messages.placeholder.invalid_payment_type'));
                return redirect()->route('home');
        }
    }

    private function handleSubscriptionCancel(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();

        if ($paymentData) {
            Subscription::where('id', $paymentData->subscription_id)->delete();
            $paymentData->delete();
        }
        Flash::error(__('messages.placeholder.payment_cancel'));
        return view('sadmin.plans.payment.paymentcancel');
    }

    private function handleAppointmentCancel(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();
        $meta = json_decode($paymentData->meta, true);
        $alias = $meta['vcard_alias'];
        if ($paymentData) {
            $paymentData->delete();
        }

        Flash::error(__('messages.placeholder.payment_cancel'));
        return redirect(route('vcard.show',  $alias));
    }

    private function handleNfcCardOrderCancel(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();
        if ($paymentData) {
            $paymentData->delete();
        }

        Flash::error(__('messages.placeholder.payment_cancel'));
        return redirect(route('user.orders'));
    }

    private function handleProductBuyCancel(Request $request, $paymentData)
    {
        $tranId = $request->tran_id;

        $paymentData = PaymentSession::where('invoice_id', $tranId)->first();
        $meta = json_decode($paymentData->meta, true);
        $product = Product::whereId($meta['product_id'])->first();
        $vcard = $product->vcard;
        if ($paymentData) {
            $paymentData->delete();
        }

        Flash::error(__('messages.placeholder.payment_cancel'));
        return redirect(route('showProducts', [$vcard->id, $vcard->url_alias]));
    }

    public function ipn()
    {
        //
    }
}
