<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Nfc;
use App\Models\Plan;
use Iyzipay\Options;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductOrderSendCustomer;
use App\Models\AppointmentTransaction;
use App\Repositories\AppointmentRepository;
use App\Mail\SubscriptionPaymentSuccessMail;
use App\Repositories\SubscriptionRepository;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class IyzicoController extends Controller
{
    private SubscriptionRepository $subscriptionRepository;
    protected $options;
    protected $userId = null;

    public function __construct(SubscriptionRepository $subscriptionRepository, $userId = null)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->initializeOptions();
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        $this->initializeOptions();
    }


    protected function initializeOptions()
    {
        $clientId = !empty($this->userId)
            ? getUserSettingValue('iyzico_key', $this->userId)
            : getSelectedPaymentGateway('iyzico_key');

        $clientSecret = !empty($this->userId)
            ? getUserSettingValue('iyzico_secret', $this->userId)
            : getSelectedPaymentGateway('iyzico_secret');

        $iyzicoMode = !empty($this->userId)
            ? getUserSettingValue('iyzico_mode', $this->userId)
            : getSelectedPaymentGateway('iyzico_mode');

        $this->options = new Options();
        $this->options->setApiKey($clientId);
        $this->options->setSecretKey($clientSecret);
        $this->options->setBaseUrl(
            $iyzicoMode === 'sandbox'
                ? 'https://sandbox-api.iyzipay.com'
                : 'https://api.iyzipay.com'
        );
    }


    public function iyzicoSubscription(Request $request)
    {

        $supportedCurrency = ['USD', 'EUR', 'GBP', 'RUB', 'CHF', 'NOK', 'TRY'];

        $plan = Plan::with('currency')->findOrFail($request->planId);

        if (Auth::check()) {

            $address = auth()->user()?->address;

            if (
                !$address ||
                collect($address->only([
                    'address',
                    'city',
                    'postal_code',
                    'identification_number',
                    'country',
                ]))->contains(fn($value) => empty($value))
            ) {
                Flash::error(__('messages.payment.address_not_found'));
                return redirect()->route('subscription.index');
            }
        }

        if (!in_array(strtoupper($plan->currency->currency_code), $supportedCurrency)) {
            Flash::error(__('Currency not supported for Iyzico payment.'));
            return redirect()->route('subscription.index');
        }

        $data = $this->subscriptionRepository->manageSubscription($request->all());

        if (!isset($data['plan'])) {
            if (isset($data['status']) && $data['status'] == true) {
                Flash::error(__('messages.subscription_pricing_plans.has_been_subscribed'));
                return redirect()->route('subscription.index');
            } else {
                if (isset($data['status']) && $data['status'] == false) {
                    Flash::error(__('messages.placeholder.cannot_switch_to_zero'));
                    return redirect()->route('subscription.index');
                }
            }
        }

        $subscriptionsPricingPlan = $data['plan'];
        $subscription = $data['subscription'];

        $paymentData = [
            'amount' => $data['amountToPay'],
            'currency' => $plan->currency->currency_code,
            'itemName' => $subscriptionsPricingPlan->name,
            'conversationId' => $subscription->id,
            'callbackUrl' => 'iyzico.subscription.success',
        ];

        $url = $this->iyzicoPayment($paymentData);

        session(['iyzico_conversation_id' => $subscription->id]);

        return redirect()->away($url);
    }

    public function iyzicoSubscriptionSuccess(Request $request)
    {
        if (!$request->has('token')) {
            Flash::error(__('Payment failed or token missing.'));
            return redirect()->route('subscription.index');
        }

        try {

            $retrieveRequest = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
            $retrieveRequest->setLocale(\Iyzipay\Model\Locale::EN);
            $retrieveRequest->setConversationId(session('iyzico_conversation_id'));
            $retrieveRequest->setToken($request->token);

            $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($retrieveRequest, $this->options);

            session()->forget('iyzico_conversation_id');

            if ($checkoutForm->getStatus() === 'success' && $checkoutForm->getPaymentStatus() === 'SUCCESS') {
                $amount = $checkoutForm->getPaidPrice();
                $subscriptionId = $checkoutForm->getConversationId();

                Subscription::whereTenantId(getLogInTenantId())
                    ->where('id', '!=', $subscriptionId)
                    ->where('status', '!=', Subscription::REJECT)
                    ->update(['status' => Subscription::INACTIVE]);

                $transaction = Transaction::create([
                    'transaction_id' => $checkoutForm->getPaymentId(),
                    'type' => Subscription::IYZICO,
                    'amount' => $amount,
                    'status' => Subscription::ACTIVE,
                    'meta' => json_encode($checkoutForm->getRawResult()),
                ]);

                $subscription = Subscription::findOrFail($subscriptionId);
                $subscription->update(['transaction_id' => $transaction->id, 'status' => Subscription::ACTIVE, 'payment_type' => Subscription::IYZICO]);
                $planName = $subscription->plan->name;

                $affiliateAmount = getSuperAdminSettingValue('affiliation_amount');
                $affiliateAmountType = getSuperAdminSettingValue('affiliation_amount_type');

                if ($affiliateAmountType == 1) {
                    AffiliateUser::whereUserId(getLogInUserId())
                        ->where('amount', 0)
                        ->withoutGlobalScopes()
                        ->update(['amount' => $affiliateAmount, 'is_verified' => 1]);
                } elseif ($affiliateAmountType == 2) {
                    $commission = $amount * $affiliateAmount / 100;
                    AffiliateUser::whereUserId(getLogInUserId())
                        ->where('amount', 0)
                        ->withoutGlobalScopes()
                        ->update(['amount' => $commission, 'is_verified' => 1]);
                }

                $user = getLogInUser();
                $emailData = [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'planName' => $planName,
                ];

                manageVcards();
                Mail::to($user->email)->send(new SubscriptionPaymentSuccessMail($emailData));


                if (moduleExists('SlackIntegration')) {
                    $slackIntegration = SlackIntegration::first();
                    if ($slackIntegration && $slackIntegration->user_plan_purchase_notification == 1 && !empty($slackIntegration->webhook_url)) {
                        $message = "🔔 New Plan Purchased !!!\nPlan {$planName} Purchased by {$user->first_name} {$user->last_name} Successfully.";
                        $slackIntegration->notify(new SlackNotification($message));
                    }
                }

                return view('sadmin.plans.payment.paymentSuccess');
            } else {
                Flash::error(__('Payment failed: ') . $checkoutForm->getErrorMessage());
                return redirect()->route('subscription.index');
            }
        } catch (\Exception $e) {
            Flash::error(__('messages.subscription_pricing_plans.payment_failed') . ' ' . $e->getMessage());
            return redirect()->route('subscription.index');
        }
    }


    //NFC Order

    public function nfcOrder($orderId, $email, $nfc, $currency, $nfcOrder)
    {
        try {
            $baseAmount = $nfc->nfcCard->price * $nfc->quantity;
            $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
            $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
            $taxAmount = 0;

            if ($isTaxEnabled && $taxValue > 0) {
                $taxAmount = ($baseAmount * $taxValue) / 100;
            }

            $amount = $baseAmount + $taxAmount;

            $paymentData = [
                'amount' => $amount,
                'currency' =>  $currency,
                'itemName' => $nfc->name,
                'conversationId' => $nfcOrder->id,
                'callbackUrl' => 'nfc.iyzico.success',
            ];

            $url = $this->iyzicoPayment($paymentData);

            session(['iyzico_conversation_id' => $nfcOrder->id]);

            return $url;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function nfcPurchaseSuccess(Request $request)
    {
        if (!$request->has('token')) {
            Flash::error(__('Payment failed or token missing.'));
            return redirect()->route('user.orders');
        }
        try {

            $retrieveRequest = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
            $retrieveRequest->setLocale(\Iyzipay\Model\Locale::EN);
            $retrieveRequest->setConversationId(session('iyzico_conversation_id'));
            $retrieveRequest->setToken($request->token);

            $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($retrieveRequest, $this->options);

            session()->forget('iyzico_conversation_id');

            $amount = $checkoutForm->getPaidPrice();
            $orderId = $checkoutForm->getConversationId();

            if ($checkoutForm->getStatus() === 'success' && $checkoutForm->getPaymentStatus() === 'SUCCESS') {


                $nfcOrder = NfcOrders::findOrFail($orderId);
                $nfc = Nfc::findOrFail($nfcOrder->card_type);

                $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
                $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
                $tax = null;

                if ($isTaxEnabled && $taxValue > 0) {
                    $tax = $taxValue;
                }

                NfcOrderTransaction::create([
                    'nfc_order_id' => $orderId,
                    'type' => NfcOrders::IYZICO,
                    'transaction_id' => $checkoutForm->getPaymentId(),
                    'amount' => $amount,
                    'user_id' => getLogInUser()->id,
                    'status' => NfcOrders::SUCCESS,
                    'tax' => $tax,
                ]);

                $vcardName = Vcard::find($nfcOrder->vcard_id)->name;
                $cardType = Nfc::find($nfcOrder->card_type)->name;

                App::setLocale(getLogInUser()->language);

                Mail::to(getSuperAdminSettingValue('email'))->send(new AdminNfcOrderMail($nfcOrder, $vcardName, $cardType));

                Flash::success(__('messages.nfc.order_placed_success'));

                return redirect(route('user.orders'));
            } else {

                session()->forget('iyzico_conversation_id');

                $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
                $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
                $tax = null;

                if ($isTaxEnabled && $taxValue > 0) {
                    $tax = $taxValue;
                }

                NfcOrderTransaction::create([
                    'nfc_order_id' => $orderId,
                    'type' => NfcOrders::IYZICO,
                    'amount' => $amount,
                    'user_id' => getLogInUser()->id,
                    'status' => NfcOrders::FAIL,
                    'tax' => $tax,
                ]);

                Flash::error(__('Payment failed: ') . $checkoutForm->getErrorMessage());
                return redirect()->route('user.orders');
            }
        } catch (\Exception $e) {

            session()->forget('iyzico_conversation_id');

            Flash::error(__('messages.nfc.order_placed_failed') . ' ' . $e->getMessage());
            return redirect()->route('user.orders');
        }
    }

    //appoitment payment
    public function appointmentBook($vcard, $input, $currency)
    {
        try {
            $amount = $input['amount'];

            $paymentData = [
                'amount' => $amount,
                'currency' =>  $currency,
                'itemName' => 'Appointment - ' . $vcard->name,
                'conversationId' => 'appointment_' . uniqid(),
                'callbackUrl' => 'appointment.iyzico.success',
            ];
            $url = $this->iyzicoPayment($paymentData);

            session(['appointment_details' => $input]);
            session(['iyzico_conversation_id' => $paymentData['conversationId']]);
            session(['appointment_vcard_data' => [
                'vcard_id' => $vcard->id,
                'default_language' => $vcard->default_language,
                'url_alias' => $vcard->url_alias,
            ]]);

            return $url;
        } catch (\Exception $e) {
            Log::error('Iyzico Appointment Booking Error: ' . $e->getMessage());
            Flash::error($e->getMessage());

            return $e->getMessage();
        }
    }

    public function appointmentBookSuccess(Request $request)
    {
        if (!$request->has('token')) {
            Flash::error(__('Payment failed or token missing.'));
            Log::error('Iyzico Appointment Booking Error: Payment failed or token missing.');
            throw new UnprocessableEntityHttpException(__('Payment failed or token missing.'));
        }
        try {

            $retrieveRequest = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
            $retrieveRequest->setLocale(\Iyzipay\Model\Locale::EN);
            $retrieveRequest->setConversationId(session('iyzico_conversation_id'));
            $retrieveRequest->setToken($request->token);

            $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($retrieveRequest, $this->options);

            session()->forget('iyzico_conversation_id');

            $amount = $checkoutForm->getPaidPrice();
            $orderId = $checkoutForm->getConversationId();

            $input = session('appointment_details');

            if(empty($input)){
                return __('messages.payment.payment_error');
            }

            session()->forget('appointment_details');

            $vcard = Vcard::with('tenant.user', 'template')->where('id', $input['vcard_id'])->first();
            $url = ($vcard->template->name == 'vcard11') ? $vcard->url_alias . '/contact' : $vcard->url_alias;

            if ($checkoutForm->getStatus() === 'success' && $checkoutForm->getPaymentStatus() === 'SUCCESS') {

                DB::beginTransaction();

                $userId = $vcard->tenant->user->id;

                $appointmentTran = AppointmentTransaction::create([
                    'vcard_id' => $vcard->id,
                    'transaction_id' => $checkoutForm->getPaymentId(),
                    'currency_id' => $input['currency_id'] ?? getUserSettingValue('currency_id', $userId),
                    'amount' => $input['amount'],
                    'tenant_id' => $vcard->tenant->id,
                    'type' => Appointment::IYZICO,
                    'status' => Transaction::SUCCESS,
                ]);

                $input['appointment_tran_id'] = $appointmentTran->id;
                $vcardData = session()->get('appointment_vcard_data', [
                    'default_language' => $vcard->default_language,
                    'url_alias' => $vcard->url_alias,
                ]);
                /** @var AppointmentRepository $appointmentRepo */
                $appointmentRepo = App::make(AppointmentRepository::class);
                $vcardEmail = is_null($vcard->email) ? $vcard->tenant->user->email : $vcard->email;
                $appointmentRepo->appointmentStoreOrEmail($input, $vcardEmail,$vcardData['default_language'],$vcardData['url_alias']);
                session()->forget('appointment_vcard_data');

                DB::commit();

                Flash::success('Payment successfully done');

                return redirect(route('vcard.show', [$url, __('messages.placeholder.appointment_created')]));
            } else {
                Flash::error(__('messages.nfc.order_placed_failed') . ' ' . $checkoutForm->getErrorMessage());

                session()->forget('appointment_details');
                session()->forget('iyzico_conversation_id');
                session()->forget('appointment_vcard_data');

                return redirect(route('vcard.show', [$url]))->with(
                    'error',
                    __('Payment failed: ') . $checkoutForm->getErrorMessage()
                );
            }
        } catch (\Exception $e) {

            session()->forget('appointment_details');
            session()->forget('iyzico_conversation_id');
            session()->forget('appointment_vcard_data');

            Log::error('Iyzico Appointment Booking  Error: ' . $e->getMessage());
            DB::rollBack();

            return redirect(route('vcard.show', [$url]))->with(
                'error',
                __('Payment failed: ') .  $e->getMessage()
            );
        }
    }

    //Buy Product
    public function productBuy($input, $product)
    {
        try {
            $amount = $product->price;
            $input['amount'] = $amount;
            $paymentData = [
                'amount' => $amount,
                'currency' =>  $product->currency->currency_code,
                'itemName' => $product->name,
                'conversationId' => 'product_' . uniqid(),
                'callbackUrl' => 'product.iyzico.success',
            ];

            $url = $this->iyzicoPayment($paymentData);

            session(['iyzico_conversation_id' => $paymentData['conversationId']]);
            session(['product_details' => $input]);
            session(['product_vcard_data' => [
                'vcard_id' => $product->vcard->id,
                'default_language' => $product->vcard->default_language,
                'url_alias' => $product->vcard->url_alias,
            ]]);

            return $url;
        } catch (\Exception $e) {

            Log::error('Iyzico Product Buy Error: ' . $e->getMessage());
            Flash::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function productBuySuccess(Request $request)
    {
        if (!$request->has('token')) {
            Flash::error(__('Payment failed or token missing.'));
            Log::error('Iyzico Appointment Booking Error: Payment failed or token missing.');
            throw new UnprocessableEntityHttpException(__('Payment failed or token missing.'));
        }
        try {
            $input = session('product_details');

            if(empty($input)){
                return __('messages.payment.payment_error');
            }

            $product = Product::whereId($input['product_id'])->first();
            $userId = $product->vcard->user->id;

            $retrieveRequest = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
            $retrieveRequest->setLocale(\Iyzipay\Model\Locale::EN);
            $retrieveRequest->setConversationId(session('iyzico_conversation_id'));
            $retrieveRequest->setToken($request->token);

            $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($retrieveRequest, $this->options);

            session()->forget('iyzico_conversation_id');

            $amount = $checkoutForm->getPaidPrice();
            $orderId = $checkoutForm->getConversationId();

            if (empty($product->currency_id)) {
                $product->currency_id = getUserSettingValue('currency_id', $userId);
            }
            $currencyId = Currency::whereId($product->currency_id)->first()->id;

            if ($checkoutForm->getStatus() === 'success' && $checkoutForm->getPaymentStatus() === 'SUCCESS') {
                DB::beginTransaction();

                ProductTransaction::create([
                    'product_id' => $input['product_id'],
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'phone' => $input['phone'],
                    'address' => $input['address'],
                    'currency_id' => $currencyId,
                    'type' =>  Product::IYZICO,
                    'transaction_id' => $checkoutForm->getPaymentId(),
                    'amount' => $input['amount'],
                ]);

                $vcardData = session()->get('product_vcard_data', [
                    'default_language' => $product->vcard->default_language,
                    'url_alias' => $product->vcard->url_alias,
                ]);

                $orderMailData = [
                    'user_name' => $product->vcard->user->full_name,
                    'customer_name' => $input['name'],
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'phone' => $input['phone'] ?? '',
                    'address' => $input['address'] ?? '',
                    'payment_type' => __('messages.Iyzico'),
                    'order_date' => Carbon::now()->format('d M Y'),
                ];

                if (getUserSettingValue('product_order_send_mail_customer', $userId)) {
                    Mail::to($input['email'])->send(new ProductOrderSendCustomer($orderMailData,$vcardData['default_language'],$vcardData['url_alias']));
                }

                if (getUserSettingValue('product_order_send_mail_user', $userId)) {
                    Mail::to($product->vcard->user->email)->send(new ProductOrderSendUser($orderMailData,$vcardData['default_language'],$vcardData['url_alias']));
                }

                $vcard = $product->vcard;

                session()->forget('product_vcard_data');

                DB::commit();

                return redirect(route('showProducts', [$vcard->id, $vcard->url_alias, __('messages.placeholder.product_purchase')]));
            } else {
                session()->forget('iyzico_conversation_id');
                session()->forget('product_details');

                Flash::error(__('Payment failed: ') . $checkoutForm->getErrorMessage());
                return redirect()->route('showProducts', [$product->vcard->id, $product->vcard->url_alias]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Iyzico Product Buy Error: ' . $e->getMessage());
            session()->forget('iyzico_conversation_id');
            session()->forget('product_details');

            throw new \Exception(__('Product purchase failed') . ' ' . $e->getMessage());
        }
    }
    public function iyzicoPayment(array $data)
    {
        try {
            $user = getLogInUser();
            $userAddress = $user?->address;

            $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
            $request->setLocale(\Iyzipay\Model\Locale::EN);
            $request->setConversationId($data['conversationId']);
            $request->setPrice($data['amount']);
            $request->setPaidPrice($data['amount']);
            $request->setCurrency(strtoupper($data['currency']));
            $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::SUBSCRIPTION);
            $request->setCallbackUrl(route($data['callbackUrl']));

            $buyer = new \Iyzipay\Model\Buyer();
            $buyer->setId((string) ($user?->id ?? '0'));
            $buyer->setName($user?->first_name ?? 'N/A');
            $buyer->setSurname($user?->last_name ?? 'N/A');
            $buyer->setGsmNumber($user?->phone ?? 'N/A');
            $buyer->setEmail($user?->email ?? 'dbHb0@example.com');
            $buyer->setIdentityNumber($userAddress?->identification_number ?? '123456');
            $buyer->setRegistrationAddress($userAddress?->address ?? 'N/A');
            $buyer->setIp(request()->ip());
            $buyer->setCity($userAddress?->city ?? 'N/A');
            $buyer->setCountry($userAddress?->country ?? 'N/A');
            $buyer->setZipCode($userAddress?->postal_code ?? '00000');
            $request->setBuyer($buyer);

            $address = new \Iyzipay\Model\Address();
            $address->setContactName($user?->full_name ?? 'N/A');
            $address->setCity($userAddress?->city ?? 'N/A');
            $address->setCountry($userAddress?->country ?? 'N/A');
            $address->setAddress($userAddress?->address ?? 'N/A');
            $address->setZipCode($userAddress?->postal_code ?? 'N/A');
            $request->setShippingAddress($address);
            $request->setBillingAddress($address);

            $basketItems = [];
            $basketItem = new \Iyzipay\Model\BasketItem();
            $basketItem->setId((string) $data['conversationId']);
            $basketItem->setName($data['itemName']);
            $basketItem->setCategory1('Subscription');
            $basketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
            $basketItem->setPrice($data['amount']);
            $basketItems[] = $basketItem;

            $request->setBasketItems($basketItems);

            $checkoutForm = \Iyzipay\Model\CheckoutFormInitialize::create($request, $this->options);

            if ($checkoutForm->getStatus() !== 'success') {
                Flash::error(__('Payment failed: ') . $checkoutForm->getErrorMessage());
                return $checkoutForm->getErrorMessage();
            }

            session(['iyzico_conversation_id' => $data['conversationId']]);

            return $checkoutForm->getPaymentPageUrl();

        } catch (\Exception $e) {
            Log::error('Iyzico Payment Error: ' . $e->getMessage());

            throw new \Exception(__('Payment initialization failed') . ' ' . $e->getMessage());
        }
    }
}
