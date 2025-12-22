<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserSettingRequest;
use App\Models\Language;
use App\Models\ScheduleAppointment;
use App\Models\Setting;
use App\Models\UserSetting;
use App\Models\Vcard;
use App\Repositories\UserSettingRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SettingAPIController extends AppBaseController
{
    /**
     * @var UserSettingRepository
     */
    private $userSettingRepository;

    /**
     * SettingController constructor.
     */
    public function __construct(UserSettingRepository $userSettingRepository)
    {
        $this->userSettingRepository = $userSettingRepository;
    }

    public function editSettings()
    {
        $setting = UserSetting::where('user_id', getLogInUserId())->pluck('value', 'key')->toArray();

        $language = Language::where('iso_code', getCurrentLanguageName())->value('name');

        $data[] = [
            'paypal_email' => $setting['paypal_email'] ?? '',
            'currency_id' => $setting['currency_id'] ?? '',
            'subscription_model_time' => $setting['subscription_model_time'] ?? '',
            'time_format' => $setting['time_format'] ?? '',
            'ask_details_before_downloading_contact' => $setting['ask_details_before_downloading_contact'] ?? '',
            'enable_attachment_for_inquiry' => $setting['enable_attachment_for_inquiry'] ?? '',
            'enable_pwa' => $setting['enable_pwa'] ?? '',
            'pwa_icon' => $setting['pwa_icon'] ?? '',
            'language' => $language ?? '',
        ];

        return $this->sendResponse($data, 'Setting data retrieved successfully.');
    }

    public function updateSettings(UpdateUserSettingRequest $request)
    {
        $input = $request->all();
        $id = Auth::id();
        $setting = UserSetting::where('user_id', getLogInUserId())->where('key', 'time_format')->first();
        $userVcards = Vcard::where('tenant_id', getLogInTenantId())->pluck('id')->toArray();
        $bookedAppointment = ScheduleAppointment::whereIn('vcard_id', $userVcards)->where(
            'status',
            ScheduleAppointment::PENDING
        )->count();
        if ($setting) {
            $timeFormat = $setting->value == UserSetting::HOUR_24 ? UserSetting::HOUR_24  : UserSetting::HOUR_12;
        }
        $requestTimeFormat = isset($request->time_format) ? $request->time_format : $timeFormat;

        $this->userSettingRepository->updateAPI($input, $id);


        return $this->sendSuccess("Setting updated successfully");
    }

    public function getPaymentConfig()
    {
        $setting = UserSetting::where('user_id', getLogInUserId())->pluck('value', 'key')->toArray();

        return $this->sendResponse($setting, 'Setting data retrieved successfully.');
    }

    public  function updatePaymentConfig(Request $request)
    {
        $id = Auth::id();
        $this->userSettingRepository->paymentMethodUpdate($request->all(), $id);
        return $this->sendSuccess("Setting updated successfully");
    }

        function getSuperAdminPaymentConfig()
    {
        try {
                DB::connection()->getPdo();

            $allSettings = Setting::all()->pluck('value', 'key')->toArray();

            $paymentKeys = [
                'stripe_key', 'stripe_secret',
                'paypal_client_id', 'paypal_secret', 'paypal_mode',
                'razorpay_key', 'razorpay_secret',
                'flutterwave_key', 'flutterwave_secret',
                'paystack_key', 'paystack_secret',
                'phonepe_merchant_id', 'phonepe_merchant_user_id', 'phonepe_env', 'phonepe_salt_key', 'phonepe_salt_index',
                'iyzico_key', 'iyzico_secret', 'iyzico_mode',
                'payfast_merchant_id', 'payfast_merchant_key', 'payfast_passphrase_key', 'payfast_mode',
                'manual_payment_guide',
            ];

            $settings = collect($allSettings)->only($paymentKeys)->toArray();

            $enabledGateways = \App\Models\PaymentGateway::pluck('payment_gateway')->map(fn($g) => strtolower($g))->toArray();

            $status = [
                'stripe_enabled'      => in_array('stripe', $enabledGateways)
                                    && !empty($settings['stripe_key'])
                                    && !empty($settings['stripe_secret']),

                'paypal_enabled'      => in_array('paypal', $enabledGateways)
                                    && !empty($settings['paypal_client_id'])
                                    && !empty($settings['paypal_secret']),

                'razorpay_enabled'    => in_array('razorpay', $enabledGateways)
                                    && !empty($settings['razorpay_key'])
                                    && !empty($settings['razorpay_secret']),

                'flutterwave_enabled' => in_array('flutterwave', $enabledGateways)
                                    && !empty($settings['flutterwave_key'])
                                    && !empty($settings['flutterwave_secret']),

                'paystack_enabled'    => in_array('paystack', $enabledGateways)
                                    && !empty($settings['paystack_key'])
                                    && !empty($settings['paystack_secret']),

                'phonepe_enabled'     => in_array('phonepe', $enabledGateways)
                                    && !empty($settings['phonepe_merchant_id'])
                                    && !empty($settings['phonepe_salt_key']),

                'iyzico_enabled'      => in_array('iyzico', $enabledGateways)
                                    && !empty($settings['iyzico_key'])
                                    && !empty($settings['iyzico_secret']),

                'payfast_enabled'     => in_array('payfast', $enabledGateways)
                                    && !empty($settings['payfast_merchant_id'])
                                    && !empty($settings['payfast_merchant_key']),

                'manual_enabled' => in_array('manual', $enabledGateways) || in_array('manually', $enabledGateways),
            ];

            return [
                'credentials' => $settings,
                'status'      => $status,
                'message'     => 'Super Admin Payment Config retrieved successfully.',
            ];
        } catch (\Exception $e) {
            \Log::error('Payment Config Error: ' . $e->getMessage());
            return [
                'credentials' => [],
                'status'      => [],
            ];
        }
    }
}
