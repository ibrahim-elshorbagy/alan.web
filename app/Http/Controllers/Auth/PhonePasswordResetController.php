<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\PhoneVerification;
use App\Models\User;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\Setting;

class PhonePasswordResetController extends AppBaseController
{
  /**
   * Display the phone password reset request view.
   */
  public function create(): View
  {
    $registerImage = Setting::where('key', 'register_image')->value('value');
    return view('auth.forgot-password-phone', ['registerImage' => $registerImage]);
  }

  /**
   * Handle an incoming phone password reset request.
   */
  public function store(Request $request): JsonResponse
  {
    $request->validate([
      'phone' => 'required|string|regex:/^[0-9+\-\s()]+$/',
    ]);

    try {
      // Clean and format phone number
      $phone = preg_replace('/[^0-9]/', '', $request->phone);

      // Normalize phone number by removing leading zero if present
      $normalizedPhone = normalizePhoneNumber($phone);

      // Find user by phone number
      $user = User::where('contact', $normalizedPhone)->first();

      if (!$user) {
        return $this->sendError(__('messages.verify_phone.user_not_found'), 404);
      }

      // Generate verification code
      $smsService = new SmsService();
      $verificationCode = $smsService->generateVerificationCode();

      // Delete any existing verification for this phone
      PhoneVerification::where('phone', $normalizedPhone)->delete();

      // Create new verification record
      PhoneVerification::create([
        'phone' => $normalizedPhone,
        'code' => $verificationCode,
        'expires_at' => Carbon::now()->addMinutes(10),
      ]);

      // Send SMS
      $smsResult = $smsService->sendVerificationCode($normalizedPhone, $verificationCode);

      if (!$smsResult['success']) {
        Log::error('Password reset SMS failed', ['phone' => $normalizedPhone, 'error' => $smsResult['message']]);
        return $this->sendError(__('messages.verify_phone.sms_failed'), 500);
      }

      // Store phone in session for verification
      session([
        'password_reset_phone' => $normalizedPhone,
        'password_reset_user_id' => $user->id,
      ]);

      return $this->sendSuccess(__('messages.verify_phone.code_sent'));
    } catch (\Exception $e) {
      Log::error('Phone password reset request error', ['error' => $e->getMessage()]);
      return $this->sendError(__('messages.verify_phone.sms_failed'), 500);
    }
  }

  /**
   * Display the password reset form after phone verification.
   */
  public function showResetForm()
  {
    if (!session('password_reset_phone') || !session('password_reset_user_id')) {
      return redirect()->route('password.phone.request');
    }

    $registerImage = Setting::where('key', 'register_image')->value('value');
    return view('auth.reset-password-phone', ['registerImage' => $registerImage]);
  }

  /**
   * Handle password reset after phone verification.
   */
  public function reset(Request $request): JsonResponse
  {
    $request->validate([
      'password' => 'required|string|min:8|confirmed',
    ]);

    try {
      $userId = session('password_reset_user_id');
      $phone = session('password_reset_phone');
      $code = session('password_reset_code');

      if (!$userId || !$phone || !$code) {
        return response()->json([
          'success' => false,
          'message' => __('messages.verify_phone.session_expired'),
          'redirect' => route('password.phone.request')
        ]);
      }

      // Update user password
      $user = User::find($userId);
      $realCode = PhoneVerification::where('phone', $phone)->first();

      if (!$user || $user->contact !== $phone || $realCode->code !== $code) {
        return $this->sendError(__('messages.verify_phone.user_not_found'), 404);
      }

      $user->update([
        'password' => Hash::make($request->password),
      ]);

      $realCode->delete();
      // Clean up verification and session
      session()->forget(['password_reset_phone', 'password_reset_user_id']);

      return response()->json([
        'success' => true,
        'message' => __('messages.verify_phone.password_reset_success'),
        'redirect' => route('login')
      ]);
    } catch (\Exception $e) {
      Log::error('Phone password reset error', ['error' => $e->getMessage()]);
      return $this->sendError(__('messages.verify_phone.verification_failed'), 500);
    }
  }
}
