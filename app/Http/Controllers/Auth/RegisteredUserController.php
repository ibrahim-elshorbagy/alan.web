<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRegisterRequest;
use App\Mail\VerifyMail;
use App\Mail\NewUserRegisteredMail;
use App\Models\AffiliateUser;
use App\Models\MultiTenant;
use App\Models\Plan;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\User;
use App\Models\PhoneVerification;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RegisteredUserController extends AppBaseController
{
  /**
   * @return Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse
   */
  public function create()
  {
    $registerImage = Setting::where('key', 'register_image')->value('value');
    $authTheme = Setting::where('key', 'auth_page_theme')->value('value') ?? 1;

    if (!getSuperAdminSettingValue('register_enable')) {
      return redirect()->back();
    }

    $themeViews = [
      1 => 'auth.register',
      2 => 'auth.register2',
    ];

    $registerView = $themeViews[$authTheme] ?? $themeViews[1];

    return view($registerView, ['registerImage' => $registerImage]);
  }

  /**
   * Handle an incoming registration request.
   *
   * @return Application|RedirectResponse|Redirector
   */
  public function store(CreateRegisterRequest $request): RedirectResponse
  {
    $referral_code = $request->input('referral_code') ?? $request->input('referral-code');
    $referral_user = '';
    if ($referral_code) {
      $referral_user = User::where('affiliate_code', $referral_code)->first();
    }
    try {
      DB::beginTransaction();

      $tenant = MultiTenant::create(['tenant_username' => $request->first_name]);
      $userDefaultLanguage = Setting::where('key', 'user_default_language')->first()->value ?? 'en';

      // Validate email domain if email is provided
      if ($request->filled('email')) {
        $email = $request->email;
        $emailDomain = strtolower(substr(strrchr($email, "@"), 1));

        $blockedSetting = Setting::where('key', 'block_email_domains')->first();
        $blockedDomains = [];

        if ($blockedSetting && $blockedSetting->value) {
          $blockedDomains = explode(',', strtolower($blockedSetting->value));
          $blockedDomains = array_map('trim', $blockedDomains);
        }

        // Check if the Email Domain is in the blocked list
        if (in_array($emailDomain, $blockedDomains)) {
          Flash::error(__('messages.placeholder.registration_using_email_domain_not_allowed', [
            'domain' => '@' . $emailDomain,
          ]));
          return redirect()->back()->withInput();
        }
      }

      // Determine verification status based on registration type
      $registerType = $request->input('register_type', 'email');
      $isVerified = false;

      if ($registerType === 'email') {
        // Email registration - verify immediately if setting allows
        $isVerified = (getSuperAdminSettingValue('user_verified_email') == 0);
      } elseif ($registerType === 'phone') {
        // Phone registration - will verify via SMS later
        $isVerified = false;
      }

      // Normalize phone number if provided
      $normalizedContact = $request->filled('contact') ? normalizePhoneNumber($request->contact) : $request->contact;

      $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'region_code' => $registerType === 'phone' ? 'JO' : $request->region_code,
        'contact' => $normalizedContact,
        'language' => $userDefaultLanguage,
        'steps' => 0,
        'email_verified_at' => $isVerified ? Carbon::now() : null,
        'password' => Hash::make($request->password),
        'tenant_id' => $tenant->id,
        'affiliate_code' => generateUniqueAffiliateCode(),
      ])->assignRole(Role::ROLE_ADMIN);

      $plan = Plan::whereIsDefault(true)->first();
      $customFields = $plan->planCustomFields;
      if ($plan->custom_select == 1 && $customFields->isNotEmpty()) {
        $vcardsOfNo = $customFields->first()->custom_vcard_number;
        $PlanPrice = $customFields->first()->custom_vcard_price;
      } else {
        $vcardsOfNo = $plan->no_of_vcards;
        $PlanPrice = $plan->price;
      }
      Subscription::create([
        'plan_id' => $plan->id,
        'plan_amount' => $plan->price,
        'plan_frequency' => $plan->frequency,
        'starts_at' => Carbon::now(),
        'ends_at' => Carbon::now()->addDays($plan->trial_days),
        'trial_ends_at' => Carbon::now()->addDays($plan->trial_days),
        'status' => Subscription::ACTIVE,
        'tenant_id' => $tenant->id,
        'no_of_vcards' => $vcardsOfNo,
      ]);

      if ($referral_user) {
        $affiliateUser = new AffiliateUser();
        $affiliateUser->affiliated_by = $referral_user->id;
        $affiliateUser->user_id = $user->id;
        $affiliateUser->amount = 0;
        $affiliateUser->save();
      }

      // Send verification based on registration method
      if ($registerType === 'email' && $request->filled('email')) {
        $token = Password::getRepository()->create($user);
        $data['url'] = config('app.url') . '/verify-email/' . $user->id . '/' . $token;
        $data['user'] = $user;

        if (getSuperAdminSettingValue('user_verified_email')) {
          Mail::to($user->email)->send(new VerifyMail($data));
        }
      } elseif ($registerType === 'phone' && $request->filled('contact')) {
        // Send phone verification SMS
        $smsService = new SmsService();
        $verificationCode = $smsService->generateVerificationCode();

        // Store verification code
        PhoneVerification::create([
          'phone' => $normalizedContact,
          'code' => $verificationCode,
          'expires_at' => Carbon::now()->addHours(2),
        ]);

        // Send SMS
        $smsResult = $smsService->sendVerificationCode($normalizedContact, $verificationCode);

        if (!$smsResult['success']) {
          Log::error('Failed to send verification SMS', $smsResult);
        }
      }

      if (getSuperAdminSettingValue('register_mail') && $request->filled('email')) {
        Mail::to(getSuperAdminSettingValue('email'))->send(new NewUserRegisteredMail($user));
      }

      DB::commit();

      if ($registerType === 'email' && getSuperAdminSettingValue('user_verified_email')) {
        Flash::success(__('messages.placeholder.registered_success'));
        return redirect(route('login'));
      } elseif ($registerType === 'phone') {
        // Store phone and user_id in session for verification page
        session([
          'phone_number' => $normalizedContact,
          'phone_verification_user_id' => $user->id
        ]);
        return redirect(route('phone.verification.show'));
      } else {
        Flash::success(__('messages.placeholder.user_registered_success'));
        return redirect(route('login'));
      }
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Registration error', ['error' => $e->getMessage()]);
      throw new UnprocessableEntityHttpException($e->getMessage());
    }
  }
  /**
   * Show the phone verification form
   */
  public function showPhoneVerification()
  {
    if ((!session('phone_number') || !session('phone_verification_user_id')) &&
      (!session('password_reset_phone') || !session('password_reset_user_id'))
    ) {
      Flash::error(__('messages.verify_phone.session_expired'));
      return redirect()->route('login');
    }

    $registerImage = Setting::where('key', 'register_image')->value('value');
    return view('auth.verify-phone', ['registerImage' => $registerImage]);
  }

  /**
   * Verify phone number with code
   */
  public function verifyPhone(Request $request): JsonResponse
  {
    $request->validate([
      'code' => 'required|string|size:6',
    ]);

    try {
      $userId = session('phone_verification_user_id');
      $phone = session('phone_number');

      // Check if this is a password reset verification
      if (!$userId && !$phone) {
        $userId = session('password_reset_user_id');
        $phone = session('password_reset_phone');
      }

      if (!$userId || !$phone) {
        return response()->json([
          'success' => false,
          'message' => __('messages.verify_phone.session_expired'),
          'redirect' => route('login')
        ]);
      }

      // Normalize phone number for verification lookup
      $normalizedPhone = normalizePhoneNumber($phone);

      Log::info('Phone verification attempt', [
        'phone' => $phone,
        'normalized_phone' => $normalizedPhone,
        'code' => $request->code,
        'user_id' => $userId
      ]);

      $verification = PhoneVerification::where('phone', $normalizedPhone)
        ->where('code', $request->code)
        ->unverified()
        ->valid()
        ->latest()
        ->first();

      if (!$verification) {
        // Log all matching records for debugging
        $allRecords = PhoneVerification::where('phone', $normalizedPhone)->get();
        Log::error('Phone verification failed - no valid code found', [
          'phone' => $normalizedPhone,
          'code' => $request->code,
          'all_records' => $allRecords->map(function ($r) {
            return [
              'id' => $r->id,
              'code' => $r->code,
              'verified' => $r->verified,
              'expires_at' => $r->expires_at,
              'is_valid' => $r->isValid()
            ];
          })
        ]);
        return $this->sendError(__('messages.verify_phone.invalid_code'), 422);
      }

      Log::info('Phone verification code found', [
        'verification_id' => $verification->id,
        'code' => $verification->code,
        'expires_at' => $verification->expires_at
      ]);

      $verification->markAsVerified();

      $user = User::find($userId);
      if (!$user) {
        return $this->sendError(__('messages.verify_phone.user_not_found'), 404);
      }

      // Check if this is password reset verification
      if (session()->has('password_reset_phone')) {

        session([
          'password_reset_code' => $request->code,
        ]);

        // Don't clean up session yet - keep for password reset page
        return response()->json([
          'success' => true,
          'message' => __('messages.verify_phone.code_verified'),
          'redirect' => route('password.phone.reset')
        ]);
      }

      // Regular registration verification
      $user->markEmailAsVerified();
      session()->forget(['phone_number', 'phone_verification_user_id']);

      // Auto-login the user after successful verification
      Auth::login($user);

      return response()->json([
        'success' => true,
        'message' => __('messages.verify_phone.phone_verified'),
        'redirect' => route('admin.dashboard')
      ]);
    } catch (\Exception $e) {
      Log::error('Phone verification error', ['error' => $e->getMessage()]);
      return $this->sendError(__('messages.verify_phone.verification_failed'), 500);
    }
  }

  /**
   * Resend verification code via SMS
   */
  public function resendPhoneVerification(Request $request): JsonResponse
  {
    try {
      // Check if it's password reset or registration
      if (session('password_reset_phone') && session('password_reset_user_id')) {
        $userId = session('password_reset_user_id');
        $phone = session('password_reset_phone');
        $isPasswordReset = true;
      } elseif (session('phone_number') && session('phone_verification_user_id')) {
        $userId = session('phone_verification_user_id');
        $phone = session('phone_number');
        $isPasswordReset = false;
      } else {
        return response()->json([
          'success' => false,
          'message' => __('messages.verify_phone.session_expired'),
          'redirect' => route('login')
        ]);
      }

      $user = User::find($userId);
      if (!$user) {
        return $this->sendError(__('messages.verify_phone.user_not_found'), 404);
      }

      if (!$isPasswordReset && $user->email_verified_at) {
        return $this->sendError(__('messages.verify_phone.already_verified'), 422);
      }

      $smsService = new SmsService();
      $verificationCode = $smsService->generateVerificationCode();

      // Normalize phone number for verification
      $normalizedPhone = normalizePhoneNumber($phone);

      PhoneVerification::where('phone', $normalizedPhone)->where('verified', 0)
        ->delete();

      PhoneVerification::create([
        'phone' => $normalizedPhone,
        'code' => $verificationCode,
        'expires_at' => Carbon::now()->addHours(2),
      ]);

      $smsResult = $smsService->sendVerificationCode($normalizedPhone, $verificationCode);

      if (!$smsResult['success']) {
        Log::error('SMS send failed', ['phone' => $phone, 'error' => $smsResult['message']]);
        return $this->sendError(__('messages.verify_phone.sms_failed'), 500);
      }

      return $this->sendSuccess(__('messages.verify_phone.code_sent'));
    } catch (\Exception $e) {
      Log::error('Resend verification error', ['error' => $e->getMessage()]);
      return $this->sendError(__('messages.verify_phone.resend_failed'), 500);
    }
  }

  /**
   * Check if email is available for registration
   */
  public function checkEmail($email): JsonResponse
  {
    $isUnique = !User::where('email', $email)->exists();

    if ($isUnique) {
      return $this->sendResponse(['isUnique' => true], 'Email is available to use.');
    }

    return $this->sendResponse(['isUnique' => false], 'This email is already in use');
  }
}
