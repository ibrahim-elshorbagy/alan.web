@extends('layouts.auth2')
@section('title')
    {{ __('messages.common.login') }}
@endsection
@section('content')
    <div class="login-section bg-white overflow-hidden position-relative min-vh-100"
         style="background-image: url('{{ asset($registerImage) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

        <div class="d-flex align-items-center justify-content-center min-vh-100 p-3 p-md-4" @if(getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' || getLanguageByKey(checkFrontLanguageSession()) == 'Persian') dir="rtl" @endif style="position: relative;">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-11 col-sm-9 col-md-6 col-lg-5 col-xl-4">

                        <div class="text-center mb-3 mb-md-3">
                            <div class="d-flex flex-column justify-content-center align-items-center logo-container">
                                <div class="mb-3">
                                    <a href="{{ route('home') }}">
                                        <img alt="Logo" src="{{ getLogoUrl() }}"
                                             class="img-fluid"
                                             style="max-height: 80px !important; max-width: 120px !important; width: 90px;">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 p-sm-5 modern-login-card" style="border-radius: 24px !important; max-width: 500px; margin: 0 auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.2) inset; border: 1px solid rgba(0, 0, 0, 0.05);">

                            @include('flash::message')
                            @include('layouts.errors')

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">

                                <div class="mb-4 pt-2">
                                    <label for="email" class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
                                        {{ __('messages.user.email') }}:<span class="required"></span>
                                    </label>
                                    <input name="email" type="email"
                                           class="form-control modern-input"
                                           id="email" required placeholder="{{ __('messages.user.email') }}"
                                           value="{{ old('email', \Cookie::get('email', '')) }}"
                                           style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;">
                                </div>

                                <div class="mb-4 pt-2">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="password" class="form-label fw-semibold mb-0" style="color: #374151; font-size: 14px;">
                                            {{ __('messages.user.password') }}:<span class="required"></span>
                                        </label>
                                    </div>

                                    <div class="position-relative">
                                        <input name="password" type="password" class="form-control modern-input" id="password" required
                                            placeholder="{{ __('messages.user.password') }}" aria-label="Password"
                                            data-toggle="password" @if (\Cookie::has('password')) value="{{ \Cookie::get('password') }}" @endif
                                            style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;">
                                        <span class="position-absolute top-50 @if(getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' || getLanguageByKey(checkFrontLanguageSession()) == 'Persian') start-0 ms-3 @else end-0 me-3 @endif translate-middle-y text-muted input-icon input-password-hide cursor-pointer modern-eye-btn" style="color: #a0aec0; padding: 8px; border-radius: 8px; transition: all 0.3s ease;">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="pt-2 mb-4 d-flex flex-column flex-sm-row justify-content-sm-between align-items-start align-items-sm-center gap-0">
                                    <label class="modern-checkbox d-flex align-items-center m-0 order-1" style="cursor: pointer; user-select: none;">
                                        <input type="checkbox" class="modern-checkbox-input" id="remember" name="remember"
                                            @if (\Cookie::has('remember')) checked @endif style="display: none;">
                                        <span class="checkbox-design me-2"
                                            style="width: 20px; height: 20px; border: 2px solid #e2e8f0; border-radius: 6px; background: #ffffff; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; position: relative;">
                                        </span>
                                        <span class="form-check-label @if(getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' || getLanguageByKey(checkFrontLanguageSession()) == 'Persian') me-2 @endif" style="color: #4a5568; font-size: 14px; font-weight: 500;">
                                            {{ __('messages.common.remember_me') }}
                                        </span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="modern-link order-2 mt-1 mt-sm-0"
                                            style="color: #667eea; text-decoration: none; font-weight: 600; font-size: 14px;">
                                            {{ __('messages.common.forgot_your_password') }}?
                                        </a>
                                    @endif
                                </div>

                                <div class="mb-4 mb-md-5">
                                    <button type="submit" class="btn w-100 text-white fw-bold border-0 modern-login-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);">
                                        {{ __('messages.common.login') }}
                                    </button>
                                </div>

                                @if (getSuperAdminSettingValue('register_enable') || config('app.google_client_id') && config('app.google_client_secret') && config('app.google_redirect') || config('app.facebook_app_id') && config('app.facebook_app_secret') && config('app.facebook_redirect'))
                                    <div class="text-center pt-1 mb-4">
                                        <div class="position-relative">
                                            <hr class="my-4" style="border-color: #e5e7eb;">
                                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted" style="font-size: 14px; font-weight: 500;">
                                                {{ __('messages.or_continue') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if (getSuperAdminSettingValue('register_enable'))
                                    <div class="text-center mb-4 p-3" style="background: rgba(102, 126, 234, 0.05); border-radius: 12px; border: 1px solid rgba(102, 126, 234, 0.1);">
                                        <span class="text-muted" style="font-size: 15px;">{{ __('messages.common.new_here') }}? </span>
                                        <a href="{{ route('register') }}" class="modern-link" style="color: #667eea; text-decoration: none; font-weight: 700; font-size: 15px;">
                                            {{ __('messages.common.create_an_account') }}
                                        </a>
                                    </div>
                                @endif

                                <div class="d-flex flex-column flex-md-row gap-3 @if (!getSuperAdminSettingValue('register_enable')) pt-3 @endif">
                                    @if (config('app.google_client_id') && config('app.google_client_secret') && config('app.google_redirect'))
                                        <a href="{{ route('social.login', 'google') }}" class="btn google-btn py-3 d-flex align-items-center justify-content-center border shadow-sm text-dark flex-fill modern-social-btn" style=" transition: all 0.3s ease;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48" class="me-2">
                                                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                                                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                                                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                                                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                                            </svg>
                                            <span style="font-size: 15px; font-weight: 600;">{{ __('messages.placeholder.login_via_google') }}</span>
                                        </a>
                                    @endif
                                    @if (config('app.facebook_app_id') && config('app.facebook_app_secret') && config('app.facebook_redirect'))
                                        <a href="{{ route('social.login', 'facebook') }}" class="btn facebook-btn py-3 d-flex align-items-center justify-content-center text-white flex-fill modern-social-btn" style="transition: all 0.3s ease;">
                                            <i class="fab fa-facebook-f me-2"></i>
                                            <span style="font-size: 15px; font-weight: 600;">{{ __('messages.placeholder.login_via_facebook') }}</span>
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <div class="text-center mt-4 mt-md-5 copy-right">
                            <div class="copyright text-black" style="font-size: 14px; ">
                                {{ __('messages.placeholder.all_rights_reserve') }} &copy; {{ date('Y') }}
                                <a href="{{ route('home') }}" class="font-weight-bold ms-1" target="_blank" style="color: #667eea; text-decoration: none;">{{ getAppName() }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
