<?php

namespace App\Http\Controllers;

use App\Models\Nfc;
use App\Models\Vcard;
use App\Models\Currency;
use App\Models\NfcOrders;
use Laracasts\Flash\Flash;
use Illuminate\Support\Arr;
use App\Models\NfcCardOrder;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Mail\AdminNfcOrderMail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\NfcOrderStatusMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\NfcOrderTransaction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\NfcOrderRequest;
use Illuminate\Support\Facades\Session;
use App\Repositories\NfcOrderRepository;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AppBaseController;
use Modules\SlackIntegration\Entities\SlackIntegration;
use Modules\SlackIntegration\Notifications\SlackNotification;
use Modules\MercadoPago\App\Http\Controllers\MercadoPagoController;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class NfcOrdersController extends AppBaseController
{
    private NfcOrderRepository $nfcOrderRepository;

    public function __construct(NfcOrderRepository $nfcOrderRepository)
    {
        $this->nfcOrderRepository = $nfcOrderRepository;
    }

    public function index()
    {
        return view('nfc.index');
    }

    public function create()
    {
        $vcards = Vcard::whereTenantId(getLogInTenantId())->where('status', Vcard::ACTIVE)->pluck('name', 'id')->toArray();
        $nfcCards  = Nfc::all();
        $paymentTypes = getPaymentGateway();
        $currency = getCurrencyIcon(getSuperAdminSettingValue('default_currency'));

        return view('nfc.order', compact('vcards', 'nfcCards', 'paymentTypes', 'currency'));
    }

    public function getVcardData(Request $request)
    {
        $input = $request->all();

        $vcard = Vcard::with('socialLink')->findOrFail($input['vcardId']);

        $data = [
            'id' => $vcard['id'],
            'first_name' => $vcard['first_name'],
            'last_name' => $vcard['last_name'],
            'email' => $vcard['email'],
            'occupation' => $vcard['occupation'],
            'location' => $vcard['location'],
            'phone' => $vcard['phone'],
            'region_code' => $vcard['region_code'],
            'company' => $vcard['company'],

        ];

        return response()->json(['data' => $data, 'success' => true]);
    }

    public function store(NfcOrderRequest $request)
    {
        try {
            DB::beginTransaction();


            $input = $request->all();
            $input['user_id'] = getLogInUserId();

            if ($input['payment_method'] != NfcOrders::RAZOR_PAY) {
                $nfcOrder = NfcOrders::create($input);
                if (isset($input['logo']) && !empty($input['logo'])) {
                    $nfcOrder->addMedia($input['logo'])->toMediaCollection(NfcOrders::LOGO_PATH);
                }
                $orderId = $nfcOrder->id;
                $userId = $nfcOrder->user_id;
                $email = $input['email'];
                $nfc = NfcOrders::with('nfcCard')->findOrFail($orderId);
            }


            $currency = getSuperAdminSettingValue('default_currency');

            if (isset($input['payment_method'])) {

                // PhonePe
                if ($input['payment_method'] == 6) {
                    if ($currency != "INR") {
                        return $this->sendError(__('messages.placeholder.this_currency_is_not_supported_phonepe'));
                    }
                    /** @var PhonepeController $phonepe */
                    $phonepe = App::make(PhonepeController::class);
                    $result = $phonepe->nfcOrder($orderId, $email, $nfc, $currency);
                    if (isset($result->original['status']) && $result->original['status'] != 200) {
                        return $this->sendError($result->original['message']);
                    }
                    DB::commit();

                    // Send Slack Notification after successful payment initialization
                    $cardType = Nfc::find($nfcOrder['card_type'])->name;

                    if (moduleExists('SlackIntegration')) {
                        $slackIntegration = SlackIntegration::first();

                        if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                            $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                            $slackIntegration->notify(new SlackNotification($message));
                        }
                    }

                    return $this->sendResponse([
                        'payment_method' => $input['payment_method'],
                        $result,
                    ], __('messages.placeholder.phonepe_created'));
                }

                // Paystack
                if ($input['payment_method'] == 5) {
                    if (isset($currency) && !in_array(strtoupper($currency), getPayStackSupportedCurrencies())) {
                        return $this->sendError(__('messages.placeholder.this_currency_is_not_supported_paystack'));
                    }
                    /** @var PaystackController $paystack */
                    $paystack = App::make(PaystackController::class);
                    $result = $paystack->nfcOrder($orderId, $email, $nfc, $currency);
                    DB::commit();
                    $targetUrl = $result->getTargetUrl();

                    // Send Slack Notification after successful payment initialization
                    $cardType = Nfc::find($nfcOrder['card_type'])->name;
                    if (moduleExists('SlackIntegration')) {
                        $slackIntegration = SlackIntegration::first();

                        if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                            $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                            $slackIntegration->notify(new SlackNotification($message));
                        }
                    }

                    return $this->sendResponse(['payment_method' => $input['payment_method'], $targetUrl], __('messages.placeholder.paystack_created'));
                }

                // Flutterwave
                if ($input['payment_method'] == 7) {
                    $supportedCurrency = ['GBP', 'CAD', 'XAF', 'CLP', 'COP', 'EGP', 'EUR', 'GHS', 'GNF', 'KES', 'MWK', 'MAD', 'NGN', 'RWF', 'SLL', 'STD', 'ZAR', 'TZS', 'UGX', 'USD', 'XOF', 'ZMW'];

                    if (isset($currency) && !in_array(strtoupper($currency), $supportedCurrency)) {
                        return $this->sendError(__('messages.placeholder.this_currency_is_not_supported_flutterwave'));
                    }
                    /** @var FlutterwaveController $paystack */
                    $flutterwave = App::make(FlutterwaveController::class);
                    $targetUrl = $flutterwave->nfcOrder($orderId, $email, $nfc, $currency);
                    DB::commit();

                    // Send Slack Notification after successful payment initialization
                    $cardType = Nfc::find($nfcOrder['card_type'])->name;
                    if (moduleExists('SlackIntegration')) {
                        $slackIntegration = SlackIntegration::first();

                        if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                            $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                            $slackIntegration->notify(new SlackNotification($message));
                        }
                    }

                    return $this->sendResponse(['payment_method' => $input['payment_method'], $targetUrl], __('messages.placeholder.flutterwave_created'));
                }

                if ($input['payment_method'] == NfcOrders::MERCADO_PAGO) {
                    // if (isset($currency) && !in_array(
                    //     strtoupper($currency),
                    //     getMercadoPagoSupportedCurrencies()
                    // )) {
                    //     return $this->sendError(__('messages.placeholder.this_currency_is_not_supported'));
                    // }

                    config(['mercadopago.access_token' => getSelectedPaymentGateway('mp_access_token')]);
                    config(['mercadopago.public_key' => getSelectedPaymentGateway('mp_public_key')]);

                    $baseAmount = $nfc->nfcCard->price * $nfc->quantity;

                    $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
                    $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
                    $taxAmount = 0;

                    if ($isTaxEnabled && $taxValue > 0) {
                        $taxAmount = ($baseAmount * $taxValue) / 100;
                    }

                    $amount = $baseAmount + $taxAmount;

                    $response = App::make(MercadoPagoController::class)->nfcOnBoard($orderId, $email, $nfc, $amount, $currency);

                    DB::commit();

                    // Send Slack Notification after successful payment initialization
                    $cardType = Nfc::find($nfcOrder['card_type'])->name;
                    if (moduleExists('SlackIntegration')) {
                        $slackIntegration = SlackIntegration::first();

                        if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                            $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                            $slackIntegration->notify(new SlackNotification($message));
                        }
                    }

                    return $this->sendResponse([
                        'payment_method' => $input['payment_method'],
                        $response,
                    ], __('messages.placeholder.mercadopago_created'));
                }
                //Stripe
                if ($input['payment_method'] == NfcOrders::STRIPE) {

                    $repo = App::make(NfcOrderRepository::class);

                    $result = $repo->userCreateSession($orderId, $email, $nfc, $currency);

                    DB::commit();

                    // Send Slack Notification after successful payment initialization
                    $cardType = Nfc::find($nfcOrder['card_type'])->name;
                    if (moduleExists('SlackIntegration')) {
                        $slackIntegration = SlackIntegration::first();

                        if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                            $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                            $slackIntegration->notify(new SlackNotification($message));
                        }
                    }

                    return $this->sendResponse([
                        'payment_method' => $input['payment_method'],
                        $result,
                    ], __('messages.placeholder.stripe_created'));
                }

                // Razor Pay
                if ($input['payment_method'] == NfcOrders::RAZOR_PAY) {

                    $nfc = Nfc::get()->find($input['card_type']);

                    $nfcOrder = NfcOrders::create($input);
                    if (isset($input['logo']) && !empty($input['logo'])) {
                        $nfcOrder->addMedia($input['logo'])->toMediaCollection(NfcOrders::LOGO_PATH);
                    }
                    $orderId = $nfcOrder->id;
                    $userId = $nfcOrder->user_id;
                    $email = $input['email'];
                    Session::put('orderid', $orderId);

                    $repo = App::make(NfcOrderRepository::class);

                    $result = $repo->userCreateRazorPaySession($input, $nfc, $currency);

                    DB::commit();

                    // Send Slack Notification after successful payment initialization
                    $cardType = Nfc::find($nfcOrder['card_type'])->name;
                    if (moduleExists('SlackIntegration')) {
                        $slackIntegration = SlackIntegration::first();

                        if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                            $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                            $slackIntegration->notify(new SlackNotification($message));
                        }
                    }

                    return $this->sendResponse([
                        'payment_method' => $input['payment_method'],
                        $result,
                    ], __('messages.nfc.razorpay_session_success'));
                }

                //PayPal
                if ($input['payment_method'] == NfcOrders::PAYPAL) {
                    if (isset($currency) && !in_array(
                        strtoupper($currency),
                        getPayPalSupportedCurrencies()
                    )) {
                        return $this->sendError(__('messages.placeholder.this_currency_is_not_supported'));
                    }

                    /** @var PaypalController $payPalCont */
                    $payPalCont = App::make(PaypalController::class);

                    $result = $payPalCont->nfcOrderOnboard($orderId, $email, $nfc, $currency);

                    DB::commit();

                    // Send Slack Notification after successful payment initialization
                    $cardType = Nfc::find($nfcOrder['card_type'])->name;
                    if (moduleExists('SlackIntegration')) {
                        $slackIntegration = SlackIntegration::first();

                        if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                            $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                            $slackIntegration->notify(new SlackNotification($message));
                        }
                    }

                    return $this->sendResponse([
                        'payment_method' => $input['payment_method'],
                        $result,
                    ], __('messages.placeholder.paypal_created'));
                }

                //Payfast
                if ($input['payment_method'] == NfcOrders::PAYFAST) {

                    if ($currency != "ZAR") {
                        return $this->sendError(__('messages.placeholder.currency_supported_payfast'));
                    }

                    $payfast = App::make(PayfastController::class);

                    $result = $payfast->nfcOrder($orderId, $email, $nfc);

                    DB::commit();

                    // Send Slack Notification after successful payment initialization
                    $cardType = Nfc::find($nfcOrder['card_type'])->name;
                    if (moduleExists('SlackIntegration')) {
                        $slackIntegration = SlackIntegration::first();

                        if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                            $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                            $slackIntegration->notify(new SlackNotification($message));
                        }
                    }

                    return $this->sendResponse([
                        'payment_method' => $input['payment_method'],
                        $result,
                    ], __('messages.placeholder.payfast_created'));
                }

                // Sslcommerz
                // if ($input['payment_method'] == NfcOrders::SSLCOMMERZ) {

                //     if ($currency != "BDT") {
                //         return $this->sendError(__('messages.placeholder.currency_not_supported_sslcommerz'));
                //     }

                //     $sslcommerz = App::make(SslcommerzController::class);
                //     $result = $sslcommerz->nfcOrder($orderId, $email, $nfc);

                //     DB::commit();

                //     // Send Slack Notification after successful payment initialization
                //     $cardType = Nfc::find($nfcOrder['card_type'])->name;

                //     if (moduleExists('SlackIntegration')) {
                //         $slackIntegration = SlackIntegration::first();

                //         if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                //             $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                //             $slackIntegration->notify(new SlackNotification($message));
                //         }
                //     }

                //     return $this->sendResponse([
                //         'payment_method' => $input['payment_method'],
                //         $result,
                //     ], __('messages.placeholder.sslcommerz_created'));
                // }

                //Iyzico
                if ($input['payment_method'] == NfcOrders::IYZICO) {

                    $supportedCurrency = ['USD', 'EUR', 'GBP', 'RUB', 'CHF', 'NOK', 'TRY'];

                    if (isset($currency) && !in_array(strtoupper($currency), $supportedCurrency)) {
                        return $this->sendError(__('messages.placeholder.currency_supported_iyzico'));
                    }

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
                            return $this->sendError(__('messages.payment.address_not_found'));
                        }
                    }

                    $iyzico = App::make(IyzicoController::class);

                    $result = $iyzico->nfcOrder($orderId, $email, $nfc, $currency, $nfcOrder);

                    DB::commit();

                    // Send Slack Notification after successful payment initialization
                    $cardType = Nfc::find($nfcOrder['card_type'])->name;
                    if (moduleExists('SlackIntegration')) {
                        $slackIntegration = SlackIntegration::first();

                        if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                            $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                            $slackIntegration->notify(new SlackNotification($message));
                        }
                    }

                    return $this->sendResponse([
                        'payment_method' => $input['payment_method'],
                        $result,
                    ], __('messages.placeholder.iyzico_created'));
                }

                //manual
                if ($input['payment_method'] == NfcOrders::MANUALLY) {

                    $baseAmount = $nfc->nfcCard->price * $nfc->quantity;
                    $isTaxEnabled = getSuperAdminSettingValue('nfc_tax_enabled') ?? false;
                    $taxValue = getSuperAdminSettingValue('nfc_tax_value') ?? 0;
                    $taxAmount = 0;

                    if ($isTaxEnabled && $taxValue > 0) {
                        $taxAmount = ($baseAmount * $taxValue) / 100;
                    }

                    $totalAmount = $baseAmount + $taxAmount;
                    $tax = null;

                    if ($isTaxEnabled && $taxValue > 0) {
                        $tax = $taxValue;
                    }

                    NfcOrderTransaction::create([
                        'nfc_order_id' => $orderId,
                        'type' => NfcOrders::MANUALLY,
                        'transaction_id' => null,
                        'amount' => $totalAmount,
                        'user_id' => $userId,
                        'status' => NfcOrders::PENDING,
                        'tax' => $tax,
                    ]);
                    $vcardName = VCard::find($nfcOrder['vcard_id'])->name;
                    $cardType = Nfc::find($nfcOrder['card_type'])->name;

                    Mail::to(getSuperAdminSettingValue('email'))->send(new AdminNfcOrderMail($nfcOrder, $vcardName, $cardType));

                    Flash::success(__('messages.nfc.order_placed_success'));
                    DB::commit();
                    // return redirect(route('user.orders'));

                    // Send Slack Notification after successful payment initialization
                    if (moduleExists('SlackIntegration')) {
                        $slackIntegration = SlackIntegration::first();

                        if ($slackIntegration && $slackIntegration->user_order_nfc_card_notification == 1 && !empty($slackIntegration->webhook_url)) {
                            $message = "🔔 New NFC Order Received !!!\n{$request->name} has ordered {$cardType} with Qty: {$request->quantity}.";
                            $slackIntegration->notify(new SlackNotification($message));
                        }
                    }

                    return $this->sendResponse(['payment_method' => $input['payment_method']], __('messages.nfc.order_placed_success'));
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }


    public function updatePaymentStatus(NfcOrderTransaction $transaction)
    {
        $transaction->update([
            'status' => NfcOrders::SUCCESS,
        ]);

        return $this->sendSuccess(__('messages.nfc.payment_status_update_success'));
    }

    public function updateOrderStatus(Request $request, NfcOrders $order)
    {
        $status = $request['status'];
        $order->update([
            'order_status' => $status,
        ]);

        Mail::to($order['email'])->send(new NfcOrderStatusMail($order, $status));

        return $this->sendSuccess(__('messages.nfc.order_status_update_success'));
    }

    public function show($nfcOrder)
    {
        $nfcCardOrder = NfcOrders::with('nfcTransaction', 'vcard', 'nfcCard', 'nfcPaymentType')->select('*')->findOrFail($nfcOrder);

        return view('nfc.columns.show', compact('nfcCardOrder'));
    }
    public function nfcCardDetails(Request $request): JsonResponse
    {
        $nfcCardDetails = Nfc::with('media') // Eager load the 'media' relationship
            ->whereId($request->id)
            ->first();
        $currency = getCurrencyIcon(getSuperAdminSettingValue('default_currency'));

        return $this->sendResponse($nfcCardDetails, $currency, 'Nfc Card data successfully retrieved.');
    }

    public function downloadNfcCardPdf(Request $request, $id)
    {
        $order = NfcOrders::with(['user', 'vcard', 'nfcCard', 'nfcTransaction'])->findOrFail($id);

        $user = getLogInUser();

        if ($order->user_id !== $user->id && !$user->hasRole('super_admin')) {
            abort(404);
        }

        $appLogo = getLogoUrl();
        $companyLogo = (string) \Image::make($appLogo)->encode('data-url');

        $pdf = Pdf::loadView('sadmin.nfc_card_order.nfc_card_order_pdf', [
            'nfcOrder' => $order,
            'companyLogo' => $companyLogo,
            'appName' => getAppName(),
        ]);

        return $pdf->download('nfc-card-order-'.$order->id.'.pdf');
    }

    public function printNfcCardOrder(Request $request, $id)
    {
        $order = NfcOrders::with(['user', 'vcard', 'nfcCard', 'nfcTransaction'])->findOrFail($id);
        $user = getLogInUser();
        if ($order->user_id !== $user->id && !$user->hasRole('super_admin')) {
            abort(404);
        }
        return view('sadmin.nfc_card_order.nfc_card_order_print', [
            'nfcOrder' => $order,
            'appName' => getAppName(),
        ]);
    }
}
