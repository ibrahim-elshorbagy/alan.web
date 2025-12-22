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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use KingFlamez\Rave\Facades\Rave as FlutterWave;
use Laracasts\Flash\Flash;

class UserFlutterwaveController extends Controller
{
    public function userOnBoard($userId, $vcard, $input)
    {
        $amount = $input['amount'];
        $currencyCode = $input['currency_code'];

        $clientId = getUserSettingValue('flutterwave_key', $userId);
        $clientSecret = getUserSettingValue('flutterwave_secret', $userId);
        config([
            'flutterwave.publicKey' => $clientId,
            'flutterwave.secretKey' => $clientSecret,
        ]);

        $reference = FlutterWave::generateReference();
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $amount,
            'email' => $vcard->tenant->user->email,
            'tx_ref' => $reference,
            'currency' => $currencyCode,
            'redirect_url' => route('flutterwave.appointment.success'),
            'customer' => [
                'email' => getLogInUser()->email,
            ],
            'customizations' => [
                'title' => 'Appointment Book Payment',
            ],
            'meta' => [
                'vcard_id' =>  $vcard->id,
                'amount' => $amount,
                'payment_mode' => Appointment::FLUTTERWAVE,
            ],
        ];

        $payment = FlutterWave::initializePayment($data);

        if ($payment['status'] !== 'success') {
            return redirect()->route('vcard.show', ['alias' => $vcard->url_alias]);
        }

        session(['vcard_user_id' => $userId, 'tenant_id' => $vcard->tenant->id, 'vcard_id' => $vcard->id, 'appointment_details' => $input]);
        session()->put('appointment_vcard_data', [
            'vcard_id' => $vcard->id,
            'default_language' => $vcard->default_language,
            'url_alias' => $vcard->url_alias,
        ]);

        $url = $payment['data']['link'];
        return $url;
    }

    public function flutterwaveAppointmentSuccess(Request $request)
    {
        $input = $request->all();

        $userId = session()->get('vcard_user_id');
        $currencyCode = Currency::whereId(getUserSettingValue('currency_id', $userId))->first();
        $clientId = getUserSettingValue('flutterwave_key', $userId);
        $clientSecret = getUserSettingValue('flutterwave_secret', $userId);
        config([
            'flutterwave.publicKey' => $clientId,
            'flutterwave.secretKey' => $clientSecret,
        ]);
        if ($input['status'] == 'successful') {
            $transactionID = FlutterWave::getTransactionIDFromCallback();
            $flutterWaveData = FlutterWave::verifyTransaction($transactionID);
            $data = $flutterWaveData['data'];
            $amount = $data['amount'];
            $vcardId = $data['meta']['vcard_id'];
            $tenantId = session()->get('tenant_id');
            $transactionId = $input['transaction_id'];
            $currencyCode = $data['currency'];
            $currencyId = Currency::whereCurrencyCode($currencyCode)->first()->id;
            $vcard = Vcard::with('tenant.user')->where('id', $vcardId)->first();

            $transactionDetails = [
                'vcard_id' => $vcardId,
                'transaction_id' => $transactionId,
                'currency_id' => $currencyId,
                'amount' => $amount,
                'tenant_id' => $tenantId,
                'type' => Appointment::FLUTTERWAVE,
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

            session()->forget(['vcard_user_id', 'tenant_id', 'vcard_id', 'appointment_vcard_data']);

            Flash::success(__('messages.placeholder.payment_done'));
            App::setLocale(Session::get('languageChange_' . $vcard->url_alias));

            return redirect(route('vcard.show', [$vcard->url_alias, __('messages.placeholder.appointment_created')]));
        }
    }

    public function productBuy($input, $product)
    {

        $userId = $product->vcard->user->id;
        $vcard = $product->vcard;
        $clientId = getUserSettingValue('flutterwave_key', $userId);
        $clientSecret = getUserSettingValue('flutterwave_secret', $userId);
        config([
            'flutterwave.publicKey' => $clientId,
            'flutterwave.secretKey' => $clientSecret,
        ]);

        if (empty($product->currency_id)) {
            $product->currency_id = getUserSettingValue('currency_id', $userId);
        }
        $currencyCode = Currency::whereId($product->currency_id)->first()->currency_code;
        $email = $input['email'];
        $productId = $product->id;
        $productAmount = $product->price;


        $reference = FlutterWave::generateReference();
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $productAmount,
            'email' => is_null($vcard->email) ? $vcard->tenant->user->email : $vcard->email,
            'tx_ref' => $reference,
            'currency' => $currencyCode,
            'redirect_url' => route('flutterwave.product.success'),
            'customer' => [
                'email' => $email,
            ],
            'customizations' => [
                'title' => 'Product Buy Payment',
            ],
            'meta' => [
                'product_id' =>  $productId,
                'amount' => $productAmount,
                'payment_mode' => Product::FLUTTERWAVE,
            ],
        ];

        $payment = FlutterWave::initializePayment($data);

        if ($payment['status'] !== 'success') {
            return redirect()->route('showProducts', [$vcard->id, $vcard->url_alias]);
        }
        session()->put(['input' => $input]);
        session()->put(['vcard_user_id' => $userId]);
        session()->put('product_vcard_data', [
            'vcard_id' => $product->vcard->id,
            'default_language' => $product->vcard->default_language,
            'url_alias' => $product->vcard->url_alias,
        ]);

        $url = $payment['data']['link'];
        return $url;
    }

    public function flutterwaveProductSuccess(Request $request)
    {
        $input = $request->all();

        $userId = session()->get('vcard_user_id');
        $clientId = getUserSettingValue('flutterwave_key', $userId);
        $clientSecret = getUserSettingValue('flutterwave_secret', $userId);
        config([
            'flutterwave.publicKey' => $clientId,
            'flutterwave.secretKey' => $clientSecret,
        ]);

        if ($input['status'] == 'successful') {
            $transactionID = FlutterWave::getTransactionIDFromCallback();
            $flutterWaveData = FlutterWave::verifyTransaction($transactionID);
            $data = $flutterWaveData['data'];
            $amount = $data['amount'];
            $transactionId = $input['transaction_id'];
            $sessionInput = session()->get('input');
            $product = Product::whereId($sessionInput['product_id'])->first();
            if (empty($product->currency_id)) {
                $product->currency_id = getUserSettingValue('currency_id', $userId);
            }
            $currencyId = Currency::whereId($product->currency_id)->first()->id;

            ProductTransaction::create([
                'product_id' => $sessionInput['product_id'],
                'name' => $sessionInput['name'],
                'email' => $sessionInput['email'],
                'phone' => $sessionInput['phone'],
                'address' => $sessionInput['address'],
                'currency_id' => $currencyId,
                'meta' => json_encode($data),
                'type' =>  $sessionInput['payment_method'],
                'transaction_id' => $transactionId,
                'amount' => $amount,
            ]);

            $orderMailData = [
                'user_name' => $product->vcard->user->full_name,
                'customer_name' => $sessionInput['name'],
                'product_name' => $product->name,
                'product_price' => $product->price,
                'phone' => $sessionInput['phone'],
                'address' => $sessionInput['address'],
                'payment_type' => __('messages.flutterwave'),
                'order_date' => Carbon::now()->format('d M Y'),
            ];

            $vcardData = session()->get('product_vcard_data', [
                'default_language' => $product->vcard->default_language,
                'url_alias' => $product->vcard->url_alias,
            ]);

            if (getUserSettingValue('product_order_send_mail_customer', $userId)) {
                Mail::to($sessionInput['email'])->send(new ProductOrderSendCustomer($orderMailData,$vcardData['default_language'],$vcardData['url_alias']));
            }

            if (getUserSettingValue('product_order_send_mail_user', $userId)) {
                Mail::to($product->vcard->user->email)->send(new ProductOrderSendUser($orderMailData,$vcardData['default_language'],$vcardData['url_alias']));
            }

            $vcard = $product->vcard;
            App::setLocale(Session::get('languageChange_' . $vcard->url_alias));
            session()->forget('input');
            session()->forget('vcard_user_id');
            session()->forget('product_vcard_data');
            DB::commit();

            return redirect(route('showProducts', [$vcard->id, $vcard->url_alias, __('messages.placeholder.product_purchase')]));
        }
    }
}
