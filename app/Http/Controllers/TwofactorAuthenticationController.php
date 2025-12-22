<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorAuthenticationEnabledMail;

class TwofactorAuthenticationController extends AppBaseController
{
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $google2fa = app('pragmarx.google2fa');
        $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();
        $registration_data['email'] = Auth()->user()->email;
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $registration_data['email'],
            $registration_data['google2fa_secret']
        );
        return $this->sendResponse(['QR_Image' => $QR_Image, 'secret_key' => $registration_data['google2fa_secret']], 'Code generated successfully.');
    }

    public function enable2FA(Request $request)
    {
        $request->validate([
            'secret_key' => 'required',
            'code' => 'required|digits:6',
        ]);
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($request->secret_key, $request->code);
        if (!$valid) {
            return $this->sendError(__('messages.two_factor_auth.invalid_authentication_code'));
        }
        $user = auth()->user();
        $user->google2fa_secret = $request->secret_key;
        $user->enable_two_factor_authentication = true;
        $user->save();

        if ($user->save()) {
            Mail::to($user->email)->send(new TwoFactorAuthenticationEnabledMail($user, $user->google2fa_secret));
        }
        return $this->sendSuccess(__('messages.two_factor_auth.2fa_enabled_successfully'));
    }

    public function disable(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|digits:6',
        ]);
        $user = auth()->user();
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->verification_code);
        if (!$valid) {
            return $this->sendError(__('messages.two_factor_auth.invalid_authentication_code'));
        }
        $user->google2fa_secret = null;
        $user->enable_two_factor_authentication = false;
        $user->save();
        return $this->sendSuccess(__('messages.two_factor_auth.two_factor_authentication_has_been_disabled'));
    }

    public function showVerifyForm()
    {
        if (!session('2fa:user:id')) {
            return redirect()->route('login');
        }
        $authTheme = Setting::where('key', 'auth_page_theme')->value('value') ?? 1;
        $registerImage = Setting::where('key', 'register_image')->value('value');

        $themeViews = [
            1 => 'twofactor_authentication.2fa_verify_theme1',
            2 => 'twofactor_authentication.2fa_verify_theme2',
        ];

        $loginView = $themeViews[$authTheme] ?? $themeViews[1];

        return view($loginView, compact('registerImage'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|digits:6',
        ]);
        $userId = session('2fa:user:id');
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => __('messages.two_factor_auth.user_not_found')]);
        }
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->verification_code);
        if (!$valid) {
            return redirect()->back()->withErrors(['verification_code' => __('messages.two_factor_auth.invalid_authentication_code')]);
        }
        auth()->login($user);
        session()->forget('2fa:user:id');

        return redirect()->intended(getDashboardURL());
    }
}
