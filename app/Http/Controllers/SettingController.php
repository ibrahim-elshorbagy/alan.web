<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\Plan;
use App\Models\User;
use App\Models\Setting;
use Laracasts\Flash\Flash;
use App\Models\MailSetting;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\CustomDomain;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Mail\CustomDomainReject;
use App\Mail\CustomDomainApprove;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\MobileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\HomeBannerRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Requests\UpdateAdvancedRequest;
use App\Http\Requests\UpdateFrontCmsRequest;
use App\Http\Requests\HomePageSettingRequest;
use App\Http\Requests\UpdateOurMissionRequest;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Image;

class SettingController extends AppBaseController
{
  private SettingRepository $settingRepository;

  /**
   * SettingController constructor.
   */
  public function __construct(SettingRepository $settingRepository)
  {
    $this->settingRepository = $settingRepository;
  }

  /**
   * @return Application|Factory|View
   */
  public function index(Request $request): \Illuminate\View\View
  {
    $setting = Setting::pluck('value', 'key')->toArray();
    $social_setting = [
      'recaptcha_site_key' => config('services.recaptcha.site_key'),
      'recaptcha_secret_key' => config('services.recaptcha.secret_key'),
      'google_client_id' => config('services.google.client_id'),
      'google_client_secret' => config('services.google.client_secret'),
      'google_redirect_url' => config('services.google.redirect'),
      'facebook_app_id' => config('services.facebook.client_id'),
      'facebook_app_secret' => config('services.facebook.client_secret'),
      'facebook_redirect_url' => config('services.facebook.redirect'),
    ];
    $paymentGateways = Plan::PAYMENT_METHOD;
    $paypalMode = Plan::PAYPAL_MODE;
    $iyzicoMode = Plan::IYZICO_MODE;
    $payfastMode = Plan::PAYFAST_MODE;
    // $sslcommerzMode = Plan::SSLCOMMERZ_MODE;
    $selectedPaymentGateways = PaymentGateway::pluck('payment_gateway_id', 'payment_gateway')->toArray();

    $metas = Meta::first();
    $sectionName = ($request->get('section') === null) ? 'general' : $request->get('section');
    if (! empty($metas)) {
      $metas = $metas->toArray();
    }
    $mailsetting = MailSetting::first();
    $customDomain = CustomDomain::whereTenantId(getLogInUser()->tenant_id)->first();

    return view(
      "settings.$sectionName",
      compact('setting', 'selectedPaymentGateways', 'metas', 'sectionName', 'paymentGateways', 'paypalMode', 'payfastMode', 'mailsetting', 'customDomain', 'social_setting', 'iyzicoMode')
    );
  }

  public function update(UpdateSettingRequest $request): RedirectResponse
  {
    if ($request->favicon) {
      $imageSize = getimagesize($request->favicon);
      $width = $imageSize[0];
      $height = $imageSize[1];

      if ($width > 16 && $height > 16) {
        Flash::error(__('messages.placeholder.favicon_invalid'));

        return redirect()->back();
      }
    }

    $id = Auth::id();
    $this->settingRepository->update($request->all(), $id);

    if ($request->filled('app_name')) {
      $this->setEnvValue('APP_NAME', $request->get('app_name'));
    }

    Flash::success(__('messages.flash.setting_update'));

    return redirect(route('setting.index'));
  }

  /**
   * @return Application|Factory|View
   */
  public function frontCmsIndex(): \Illuminate\View\View
  {
    $setting = Setting::pluck('value', 'key')->toArray();

    return view('settings.front_cms.index', compact('setting'));
  }

  /**
   * @return Application|RedirectResponse|Redirector
   */
  public function frontCmsUpdate(UpdateFrontCmsRequest $request): RedirectResponse
  {
    $id = Auth::id();

    $this->settingRepository->update($request->all(), $id);

    Flash::success(__('messages.flash.front_cms'));

    return redirect(route('setting.front.cms'));
  }

  public function settingTermsConditions(Request $request): RedirectResponse
  {
    $inputs = $request->all();
    $inputs = Arr::except($inputs, ['_token']);
    $inputs['terms_conditions'] = json_decode($inputs['terms_conditions']);
    $inputs['privacy_policy'] = json_decode($inputs['privacy_policy']);
    $inputs['refund_cancellation'] = json_decode($inputs['refund_cancellation']);
    $inputs['shipping_delivery'] = json_decode($inputs['shipping_delivery']);
    $inputs['imprint'] = json_decode($inputs['imprint']);
    foreach ($inputs as $key => $value) {

      /** @var FrontCMSSetting $cmsSetting */
      $termsConditions = Setting::where('key', $key)->first();

      $termsConditions->update(['value' => $value]);
    }
    Flash::success(__('messages.vcard.term-condition') . ' ' . __('messages.flash.vcard_update'));

    return Redirect::back();
  }

  public function updateManualPaymentGuide(Request $request): RedirectResponse
  {
    $input = $request->all();

    $input = Arr::except($input, ['_token']);
    $input['manual_payment_guide'] = json_decode($input['manual_payment_guide']);
    $input['is_manual_payment_guide_on'] = isset($input['is_manual_payment_guide_on']);

    foreach ($input as $key => $value) {
      $manualPaymentGuide = Setting::where('key', $key)->first();
      $manualPaymentGuide->update(['value' => $value]);
    }

    Flash::success(__('messages.vcard.manual_payment_guide') . ' ' . __('messages.flash.vcard_update'));

    return redirect()->back();
  }

  public function updateMobileValidation()
  {
    $setting = Setting::where('key', 'mobile_validation')->firstOrFail();
    $setting->update([
      'value' => $setting->value ? 0 : 1,
    ]);
    Flash::success(__('messages.flash.mobile_validation'));

    return $this->sendSuccess('messages.flash.mobile_validation');
  }

  public function updateGoogleAnalytics(Request $request): RedirectResponse
  {
    Meta::query()->delete();

    if (isset($request->site_title) || isset($request->site_title) || isset($request->site_title) || isset($request->site_title) || isset($request->google_analytics)) {
      Meta::updateOrCreate([
        'site_title' => $request->site_title,
        'home_title' => $request->home_title,
        'meta_keyword' => $request->meta_keyword,
        'meta_description' => $request->meta_description,
        'google_analytics' => $request->google_analytics,
      ]);
    }

    Flash::success(__('messages.vcard.google_config') . ' ' . __('messages.flash.vcard_update'));

    return Redirect::back();
  }

  public function updatePaymentMethod(UpdatePaymentRequest $request): RedirectResponse
  {
    $paymentGateways = $request->payment_gateway;
    $input = $request->all();

    PaymentGateway::query()->delete();

    if (isset($paymentGateways)) {
      foreach ($paymentGateways as $paymentGateway) {
        PaymentGateway::updateOrCreate(
          ['payment_gateway_id' => $paymentGateway],
          [
            'payment_gateway' => Plan::PAYMENT_METHOD[$paymentGateway],
          ]
        );
      }
    }

    $paymentMethodKeys = [
      'stripe_key',
      'stripe_secret',
      'flutterwave_key',
      'flutterwave_secret',
      'paypal_client_id',
      'paypal_secret',
      'paypal_mode',
      'razorpay_key',
      'razorpay_secret',
      'paystack_key',
      'paystack_secret',
      'phonepe_merchant_id',
      'phonepe_merchant_user_id',
      'phonepe_env',
      'phonepe_salt_key',
      'phonepe_salt_index',
      'manual_payment_guide',
      'mp_public_key',
      'mp_access_token',
      'iyzico_key',
      'iyzico_secret',
      'iyzico_mode',
      'payfast_merchant_id',
      'payfast_merchant_key',
      'payfast_passphrase_key',
      'payfast_mode',
      // 'sslcommerz_mode',
      // 'sslc_store_id',
      // 'sslc_store_password',
    ];
    foreach ($paymentMethodKeys as $key) {
      $setting = Setting::where('key', $key)->first();
      $input[$key] = isset($input[$key]) ? $input[$key] : '';

      if ($setting) {
        $setting->update(['value' => $input[$key]]);
      } else {
        Setting::create(['key' => $key, 'value' => $input[$key]]);
      }
    }

    Flash::success(__('messages.vcard.payment_config') . ' ' . __('messages.flash.vcard_update'));

    return Redirect::back();
  }

  public function updateTheme(Request $request)
  {

    $themeSetting = Setting::where('key', 'home_page_theme')->first();
    $themeSetting->update(['value' => $request->theme_id]);

    $authThemeSetting = Setting::where('key', 'auth_page_theme')->first();
    $authThemeSetting->update(['value' => $request->auth_theme_id]);

    Flash::success(__('messages.flash.success_theme_update'));
    return Redirect::back();
  }


  public function upgradeDatabase()
  {

    Artisan::call('migrate', ['--force' => true]);
    Flash::success(__('messages.flash.database_upgrade_succesfully'));

    return Redirect::back();
  }

  public function generateSitemap()
  {

    Artisan::call('sitemap:generate');
    Flash::success(__('messages.sitemap_generated'));

    return Redirect::back();
  }

  public function bannerStore(HomeBannerRequest $request)
  {
    $requestData = $request->all();
    $this->settingRepository->updateBanner($requestData);
    Flash::success(__('messages.flash.banner_data_update'));
    return Redirect::back();
  }

  public function appUrlStore(MobileRequest $request)
  {
    $requestData = $request->all();
    $this->settingRepository->updateAppUrl($requestData);
    Flash::success(__('messages.app_download_url'));
    return Redirect::back();
  }

  public function homePageUpdate(HomePageSettingRequest $request): RedirectResponse
  {
    $input = $request->all();

    // Auto-resize images to appropriate dimensions
    if ($request->hasFile('app_logo')) {
      $appLogoFile = $request->file('app_logo');
      $image = Image::make($appLogoFile);
      $image->fit(100, 100); // App logo: 100x100

      $tempPath = sys_get_temp_dir() . '/' . uniqid() . '_app_logo.png';
      $image->save($tempPath, 100, 'png');

      $input['app_logo'] = new \Illuminate\Http\UploadedFile(
        $tempPath,
        'app_logo.png',
        'image/png',
        null,
        true
      );
    }

    if ($request->hasFile('favicon')) {
      $faviconFile = $request->file('favicon');
      $image = Image::make($faviconFile);
      $image->fit(16, 16); // Favicon: 16x16

      $tempPath = sys_get_temp_dir() . '/' . uniqid() . '_favicon.png';
      $image->save($tempPath, 100, 'png');

      $input['favicon'] = new \Illuminate\Http\UploadedFile(
        $tempPath,
        'favicon.png',
        'image/png',
        null,
        true
      );
    }

    if ($request->hasFile('register_image')) {
      $registerImageFile = $request->file('register_image');
      $image = Image::make($registerImageFile);
      $image->fit(970, 841); // Register image: 970x841

      $tempPath = sys_get_temp_dir() . '/' . uniqid() . '_register_image.png';
      $image->save($tempPath, 100, 'png');

      $input['register_image'] = new \Illuminate\Http\UploadedFile(
        $tempPath,
        'register_image.png',
        'image/png',
        null,
        true
      );
    }

    if ($request->hasFile('dashboard_logo')) {
      $dashboardLogoFile = $request->file('dashboard_logo');
      $image = Image::make($dashboardLogoFile);
      $image->fit(60, 60); // Dashboard logo: 60x60

      $tempPath = sys_get_temp_dir() . '/' . uniqid() . '_dashboard_logo.png';
      $image->save($tempPath, 100, 'png');

      $input['dashboard_logo'] = new \Illuminate\Http\UploadedFile(
        $tempPath,
        'dashboard_logo.png',
        'image/png',
        null,
        true
      );
    }

    $id = Auth::id();
    $this->settingRepository->homePageUpdate($input, $id);
    Flash::success(__('messages.flash.setting_update'));
    return redirect()->back();
  }

  public function socialSettingsPageUpdate(Request $request): RedirectResponse
  {
    $input = $request->all();
    $envFilePath = base_path('.env');
    $envFileContent = file_get_contents($envFilePath);
    if (isset($input['recaptcha_site_key'])) {
      $setting = Setting::where('key', 'recaptcha_version')->first();
      $setting->update(['value' => $input['recaptcha_version']]);
      $envFileContent = preg_replace('/^RECAPTCHA_SITE_KEY=.*/m', "RECAPTCHA_SITE_KEY={$input['recaptcha_site_key']}", $envFileContent);
      $envFileContent = preg_replace('/^RECAPTCHA_SECRET_KEY=.*/m', "RECAPTCHA_SECRET_KEY={$input['recaptcha_secret_key']}", $envFileContent);
      file_put_contents($envFilePath, $envFileContent);
      Flash::success(__('messages.setting.google_recaptcha') . ' ' . __('messages.flash.vcard_update'));
    }
    if (isset($input['google_client_id'])) {
      $envFileContent = preg_replace('/^GOOGLE_CLIENT_ID=.*/m', "GOOGLE_CLIENT_ID={$input['google_client_id']}", $envFileContent);
      $envFileContent = preg_replace('/^GOOGLE_CLIENT_SECRET=.*/m', "GOOGLE_CLIENT_SECRET={$input['google_client_secret']}", $envFileContent);
      $envFileContent = preg_replace('/^GOOGLE_REDIRECT=.*/m', "GOOGLE_REDIRECT={$input['google_redirect_url']}", $envFileContent);
      $envFileContent = preg_replace('/^FACEBOOK_APP_ID=.*/m', "FACEBOOK_APP_ID={$input['facebook_app_id']}", $envFileContent);
      $envFileContent = preg_replace('/^FACEBOOK_APP_SECRET=.*/m', "FACEBOOK_APP_SECRET={$input['facebook_app_secret']}", $envFileContent);
      $envFileContent = preg_replace('/^FACEBOOK_REDIRECT=.*/m', "FACEBOOK_REDIRECT={$input['facebook_redirect_url']}", $envFileContent);
      file_put_contents($envFilePath, $envFileContent);
      Flash::success(__('messages.setting.social_settings') . ' ' . __('messages.flash.vcard_update'));
    }
    return redirect()->back();
  }

  public function customDomainUpdate(Request $request, $id)
  {
    $input = $request->all();
    $customDomain = CustomDomain::where('id', $id)->first();
    $input['email'] = $customDomain->user->email;
    $input['toName'] = $customDomain->user->full_name;
    $input['domain_name'] = $customDomain->domain;

    $customDomain->update([
      'is_approved' => $input['isApproved'],
    ]);

    if ($input['isApproved'] == CustomDomain::APPROVED) {
      $customDomain->update([
        'is_active' => CustomDomain::ACTIVE,
      ]);

      Mail::to($input['email'])
        ->send(new CustomDomainApprove(
          'emails.custom_domain_approve',
          __('Custom Domian Update'),
          $input
        ));
    }

    if ($input['isApproved'] == CustomDomain::REJECTED) {
      Mail::to($input['email'])
        ->send(new CustomDomainReject(
          'emails.custom_domain_reject',
          __('Custom Domian Update'),
          $input
        ));
    }


    return $this->sendSuccess('Custom domain updated successfully');
  }

  public function customDomainStatusUpdate($id)
  {
    $customDomain = CustomDomain::where('id', $id)->first();

    $useVcard = $customDomain->is_use_vcard;

    if ($useVcard) {
      $useVcard = false;
    }

    $customDomain->update([
      'is_active' => !$customDomain->is_active,
      'is_use_vcard' => $useVcard
    ]);

    return $this->sendSuccess('Custom domain status updated successfully');
  }

  public function customDomainNoteUpdate(Request $request, $id)
  {
    $domain = CustomDomain::findOrFail($id);
    $domain->note = $request->note;
    $domain->save();

    return response()->json(['success' => true]);
  }

  public function changeThemeColor(Request $request)
  {
    $request->validate([
      'check_color' => 'required|in:1,2',
      'color' => 'required|string|max:255',
    ]);

    $colorField = $request->check_color == 1 ? 'primary_color' : 'secondary_color';

    $setting = Setting::where('key', $colorField)->first();

    if (!$setting) {
      Setting::create([
        'key' => $colorField,
        'value' => $request->color,
      ]);
    } else {
      $setting->update([
        'value' => $request->color,
      ]);
    }

    $colorName = Str::before($colorField, '_');

    $translatedColorName = __('messages.theme_color.' . $colorName);

    Flash::success(__('messages.theme_color.color_changed_susccessfully', [
      'color' => $translatedColorName,
    ]));

    return redirect()->back()->with('success', __(
      $colorField === 'primary_color'
        ? 'messages.theme_color.primary_color_changed'
        : 'messages.theme_color.secondary_color_changed'
    ));
  }

  public function ourMissionStore(UpdateOurMissionRequest $request)
  {
    $requestData = $request->all();
    $this->settingRepository->updateOurMission($requestData);
    Flash::success(__('messages.flash.our_mission_update'));
    return Redirect::back();
  }

  public function advancedIndex(): \Illuminate\View\View
  {
    $setting = Setting::pluck('value', 'key')->toArray();

    return view('settings.advanced.index', compact('setting'));
  }
  public function advancedUpdate(UpdateAdvancedRequest $request): RedirectResponse
  {
    $id = Auth::id();

    $this->settingRepository->update($request->all(), $id);

    Flash::success(__('messages.flash.advanced_updated'));

    return redirect(route('setting.advanced'));
  }

  private function setEnvValue($key, $value): void
  {
    $envPath = base_path('.env');
    if (! file_exists($envPath)) {
      return;
    }

    $value = str_replace(' ', '_', $value); // optional: avoid spaces
    $value = '"' . $value . '"'; // keep as quoted string

    $env = file_get_contents($envPath);

    if (preg_match("/^{$key}=.*/m", $env)) {
      $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
    } else {
      $env .= PHP_EOL . "{$key}={$value}";
    }

    file_put_contents($envPath, $env);
  }
}
