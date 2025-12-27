<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserSettingRequest;
use App\Models\CustomDomain;
use App\Models\ScheduleAppointment;
use App\Models\UserSetting;
use App\Models\Vcard;
use App\Repositories\UserSettingRepository;
use Google\Service\Monitoring\Custom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class UserSettingController extends AppBaseController
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

  /**
   * @return Application|Factory|View
   */
  public function index(Request $request): \Illuminate\View\View
  {
    $sectionName = ($request->get('section') === null) ? 'general' : $request->get('section');
    $setting = UserSetting::where('user_id', getLogInUserId())->pluck('value', 'key')->toArray();
    $customDomain = CustomDomain::where('user_id', getLogInUserId())->first();
    $paymentMode = UserSetting::PAYMENT_MODE;
    $payfastMode = UserSetting::PAYFAST_MODE;
    // $sslcommerzMode = UserSetting::SSLCOMMERZ_MODE;

    $isAllowCustomDomain = getPlanFeature(getCurrentSubscription()->plan)['allow_custom_domain'];
    if ($sectionName == 'custom_domain' && !$isAllowCustomDomain) {
      abort(404);
    }

    return view("user-settings.$sectionName", compact('setting', 'sectionName', 'customDomain', 'isAllowCustomDomain', 'payfastMode', 'paymentMode'));
  }

  public function update(UpdateUserSettingRequest $request): RedirectResponse
  {
    $id = Auth::id();
    if (isset($request->time_format)) {
      $setting = UserSetting::where('user_id', getLogInUserId())->where('key', 'time_format')->first();
    }

    $userVcards = Vcard::where('tenant_id', getLogInTenantId())->pluck('id')->toArray();
    $bookedAppointment = ScheduleAppointment::whereIn('vcard_id', $userVcards)->where(
      'status',
      ScheduleAppointment::PENDING
    )->count();
    if (! empty($setting) && $bookedAppointment > 0 && $setting->value != $request->time_format) {
      Flash::error(__('messages.flash.can_not_change_time_format'));
      return Redirect::back();
    }

    $this->userSettingRepository->update($request->all(), $id);

    Flash::success(__('messages.flash.setting_update'));

    return Redirect::back();
  }

  public function paymentMethodUpdate(Request $request)
  {
    $id = Auth::id();
    $this->userSettingRepository->paymentMethodUpdate($request->all(), $id);
    Flash::success(__('messages.flash.setting_update'));
    return Redirect::back();
  }

  public function customDomainStore(Request $request)
  {
    $request->validate([
      'domain' => [
        'required',
        'regex:/^(?!https?:\/\/|www\.|http:\/\/)[a-zA-Z0-9.-]+$/',
        'unique:custom_domain,domain'
      ],
    ]);
    $id = Auth::id();
    CustomDomain::create([
      'user_id' => $id,
      'domain' => $request->domain,
      'is_approved' => false
    ]);

    Flash::success(__('Custom domain Applied successfully'));
    return Redirect::back();
  }

  public function changeDomainStatus(Request $request, $customDomainId)
  {
    if ($request->ajax()) {
      $customDomain = CustomDomain::findOrFail($customDomainId);

      if ($customDomain->user_id == Auth::id()) {
        $checked = $request->boolean('useCustomDomainUrl');
        $customDomain->update(['is_use_vcard' => $checked]);

        return $this->sendSuccess('Custom domain status updated successfully');
      }

      return $this->sendError('Unauthorized action', 403);
    }

    return $this->sendError('Invalid request', 400);
  }
}
