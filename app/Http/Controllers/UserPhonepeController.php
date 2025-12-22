<?php

namespace App\Http\Controllers;

use App\Mail\ProductOrderSendCustomer;
use App\Mail\ProductOrderSendUser;
use App\Models\Appointment;
use App\Models\AppointmentTransaction;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Transaction;
use App\Models\Vcard;
use App\Repositories\AppointmentRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GeoIp2\Exception\HttpException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Illuminate\Support\Facades\Log;


class UserPhonepeController extends Controller
{
    public function appointmentBook($userId, $vcard, $input)
    {
        $amount = $input['amount'];
        $phone = $input['phone'];
        $input['vcard_default_language'] = $vcard->default_language;
        $input['vcard_url_alias'] = $vcard->url_alias;

        $redirectbackurl = route('phonepe-appointmentbook-response') . '?' . http_build_query(['input' => $input]);

        $paymentConfig = [
            'merchantId' => getUserSettingValue('phonepe_merchant_id', $userId),
            'clientId' =>  getUserSettingValue('phonepe_merchant_id', $userId),
            'clientVersion' => getUserSettingValue('phonepe_salt_index', $userId),
            'clientSecret' => getUserSettingValue('phonepe_salt_key', $userId),
            'tokenUrl' => getUserSettingValue('phonepe_env', $userId) == 'production' ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token' : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
            'baseUrl' => getUserSettingValue('phonepe_env', $userId) == 'production' ? 'https://api.phonepe.com/apis/pg' : 'https://api-preprod.phonepe.com/apis/pg-sandbox',
            'callbackUrl' => $redirectUrl ?? route('phonepe-subscription-response'),
        ];
        $accessToken = $this->getAccessToken($userId);
        if (!$accessToken) {
            return response()->json(['message' => __('messages.placeholder.authentication_failed'), 'status' => 500]);
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

        Session::put('phonepe_app_order_id', $transactionId);


        return response()->json(['link' => $response->redirectUrl, 'status' => 200]);
    }

    /**
     * Get access token from PhonePe.
     */
    public function getAccessToken($userId): ?string
    {

        $merchantId = getUserSettingValue('phonepe_merchant_id', $userId);
        $clientId = getUserSettingValue('phonepe_merchant_user_id', $userId);
        $clientVersion = getUserSettingValue('phonepe_salt_index', $userId);
        $clientSecret = getUserSettingValue('phonepe_salt_key', $userId);
        $tokenUrl = getUserSettingValue('phonepe_env', $userId) == 'production'
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

    public function appointmentBookSuccess(Request $request)
    {
        $input = request()->input('input');
        $vcard = Vcard::with('tenant.user')->where('id', $input['vcard_id'])->first();
        $userId = $vcard->tenant->user->id;
        $transactionId = session()->pull('phonepe_app_order_id');

        $paymentConfig = [
            'merchantId' => getUserSettingValue('phonepe_merchant_id', $userId),
            'clientId' =>  getUserSettingValue('phonepe_merchant_id', $userId),
            'clientVersion' => getUserSettingValue('phonepe_salt_index', $userId),
            'clientSecret' => getUserSettingValue('phonepe_salt_key', $userId),
            'tokenUrl' => getUserSettingValue('phonepe_env', $userId) == 'production' ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token' : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
            'baseUrl' => getUserSettingValue('phonepe_env', $userId) == 'production' ? 'https://api.phonepe.com/apis/pg' : 'https://api-preprod.phonepe.com/apis/pg-sandbox',
            'callbackUrl' => $redirectUrl ?? route('phonepe-subscription-response'),
        ];
        $accessToken = $this->getAccessToken($userId);

        if (!$accessToken) {
            throw new \Exception(__('messages.placeholder.authentication_failed'));
        }
        $merchantId = getUserSettingValue('phonepe_merchant_id', $userId);


        $response = $this->verifyPhonePePayment($merchantId, $transactionId, $paymentConfig, $accessToken);
        if ($response->state != 'COMPLETED') {
            throw new \Exception(__('messages.payment.payment_error'));
        }
        try {
            $transactionId = $transactionId;
            // Auth::loginUsingId($userId);
            $currencyId = Currency::whereCurrencyCode($input['currency_code'])->first()->id;
            $tenantId = $vcard->tenant->id;
            $amount = $input['amount'];

            $transactionDetails = [
                'vcard_id' => $vcard->id,
                'transaction_id' => $transactionId,
                'currency_id' => $currencyId,
                'amount' => $amount,
                'tenant_id' => $tenantId,
                'type' => Appointment::PHONEPE,
                'status' => Transaction::SUCCESS,
                'meta' => json_encode($response),
            ];

            $appointmentTran = AppointmentTransaction::create($transactionDetails);

            $appointmentInput = [
                'name' => $input['name'],
                'email' => $input['email'],
                'date' => $input['date'],
                'phone' => $input['phone'],
                'from_time' => $input['from_time'],
                'to_time' => $input['to_time'],
                'vcard_id' => $input['vcard_id'],
                'appointment_tran_id' => $appointmentTran->id,
                'toName' => $vcard->fullName > 1 ? $vcard->fullName : $vcard->tenant->user->fullName,
                'vcard_name' => $vcard->name,
            ];

            $vcardDefaultLanguage = $input['vcard_default_language'] ?? $vcard->default_language;
            $vcardUrlAlias = $input['vcard_url_alias'] ?? $vcard->url_alias;

            /** @var AppointmentRepository $appointmentRepo */
            $appointmentRepo = App::make(AppointmentRepository::class);
            $vcardEmail = is_null($vcard->email) ? $vcard->tenant->user->email : $vcard->email;
            $appointmentRepo->appointmentStoreOrEmail($appointmentInput, $vcardEmail, $vcardDefaultLanguage, $vcardUrlAlias);

            Flash::success(__('messages.placeholder.payment_done'));
            App::setLocale(session::get('languageChange_' . $vcard->url_alias));
            return redirect(route('vcard.show', [$vcard->url_alias, __('messages.placeholder.appointment_created')]));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
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

    public function productBuy($input, $product)
    {
        $amount = $product->price;
        $phone = $input['phone'];
        $userId = $product->vcard->user->id;
        $redirectbackurl = route('phonepe-Product-response') . '?' . http_build_query(['input' => $input]);


        $paymentConfig = [
            'merchantId' => getUserSettingValue('phonepe_merchant_id', $userId),
            'clientId' =>  getUserSettingValue('phonepe_merchant_id', $userId),
            'clientVersion' => getUserSettingValue('phonepe_salt_index', $userId),
            'clientSecret' => getUserSettingValue('phonepe_salt_key', $userId),
            'tokenUrl' => getUserSettingValue('phonepe_env', $userId) == 'production' ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token' : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
            'baseUrl' => getUserSettingValue('phonepe_env', $userId) == 'production' ? 'https://api.phonepe.com/apis/pg' : 'https://api-preprod.phonepe.com/apis/pg-sandbox',
            'callbackUrl' => $redirectbackurl ?? route('phonepe-Product-response'),
        ];


        $accessToken = $this->getAccessToken($userId);
        if (!$accessToken) {
            return response()->json(['message' => __('messages.placeholder.authentication_failed'), 'status' => 500]);
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

        Session::put('phonepe_product_order_id', $transactionId);
        Session::put('product_vcard_data', [
            'vcard_id' => $product->vcard->id,
            'default_language' => $product->vcard->default_language,
            'url_alias' => $product->vcard->url_alias,
        ]);

        return response()->json(['link' => $response->redirectUrl, 'status' => 200]);
    }

    public function productBuySuccess(Request $request)
    {
        $input = request()->input('input');
        $product = Product::whereId($input['product_id'])->first();
        $currencyId = isset($product->currency) ? $product->currency->id : Currency::whereId(getUserSettingValue('currency_id', $product->vcard->user->id))->first()->id;
        $userId = $product->vcard->user->id;
        $vcard = $product->vcard;
        $transactionId = session()->pull('phonepe_product_order_id');

        $paymentConfig = [
            'merchantId' => getUserSettingValue('phonepe_merchant_id', $userId),
            'clientId' =>  getUserSettingValue('phonepe_merchant_id', $userId),
            'clientVersion' => getUserSettingValue('phonepe_salt_index', $userId),
            'clientSecret' => getUserSettingValue('phonepe_salt_key', $userId),
            'tokenUrl' => getUserSettingValue('phonepe_env', $userId) == 'production' ? 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token' : 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
            'baseUrl' => getUserSettingValue('phonepe_env', $userId) == 'production' ? 'https://api.phonepe.com/apis/pg' : 'https://api-preprod.phonepe.com/apis/pg-sandbox',
            'callbackUrl' => $redirectbackurl ?? route('phonepe-Product-response'),
        ];
        $accessToken = $this->getAccessToken($userId);
        if (!$accessToken) {
            throw new \Exception(__('messages.placeholder.authentication_failed'));
        }
        $merchantId = getUserSettingValue('phonepe_merchant_id', $userId);

        $response = $this->verifyPhonePePayment($merchantId, $transactionId, $paymentConfig, $accessToken);

        if ($response->state != 'COMPLETED') {
            throw new \Exception(__('messages.payment.payment_error'));
        }
        try {
            $transactionId = $transactionId;
            $amount =  $response->amount / 100;
            DB::beginTransaction();

            ProductTransaction::create([
                'product_id' => $input['product_id'],
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'address' => $input['address'],
                'currency_id' => $currencyId,
                'meta' => json_encode($response),
                'type' =>  $input['payment_method'],
                'transaction_id' => $transactionId,
                'amount' => $amount,
            ]);

            $vcardData = Session::get('product_vcard_data', [
                'default_language' => $product->vcard->default_language,
                'url_alias' => $product->vcard->url_alias,
            ]);

            $orderMailData = [
                'user_name' => $product->vcard->user->full_name,
                'customer_name' => $input['name'],
                'product_name' => $product->name,
                'product_price' => $product->price,
                'phone' => $input['phone'],
                'address' => $input['address'],
                'payment_type' => __('messages.phonepe'),
                'order_date' => Carbon::now()->format('d M Y'),
            ];

            if (getUserSettingValue('product_order_send_mail_customer', $userId)) {
                Mail::to($input['email'])->send(new ProductOrderSendCustomer($orderMailData,$vcardData['default_language'],$vcardData['url_alias']));
            }

            if (getUserSettingValue('product_order_send_mail_user', $userId)) {
                Mail::to($product->vcard->user->email)->send(new ProductOrderSendUser($orderMailData,$vcardData['default_language'],$vcardData['url_alias']));
            }

            $vcard = $product->vcard;
            App::setLocale(Session::get('languageChange_' . $vcard->url_alias));
            Session::forget(['input', 'product_vcard_data']);
            DB::commit();

            return redirect(route('showProducts', [$vcard->id, $vcard->url_alias, __('messages.placeholder.product_purchase')]));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
