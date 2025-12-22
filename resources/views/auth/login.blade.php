@extends('layouts.auth')
@section('title')
    {{ __('messages.common.login') }}
@endsection
@section('content')
    <div class="login-section bg-white overflow-hidden position-relative h-100">
        <div class="top-vector">
            <img src="{{ asset('assets/images/top-vector.png') }}">
        </div>
        <div class="bottom-vector">
            <img src="{{ asset('assets/images/bottom-vector.png') }}">
        </div>
        <div class="row">
            <div class="col-md-6 col-12 p-0">
                <div class="login-img d-sm-block d-none">
                    <img src="{{ asset($registerImage) }}" alt="Register Image" class="w-100 h-100">
                </div>
            </div>
            <div class="col-md-6 col-12 p-0 d-flex flex-column justify-content-center login-section" @if(getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' || getLanguageByKey(checkFrontLanguageSession()) == 'Persian') dir="rtl" @endif>
                <div class="login-form">
                    <div class="px-sm-10 px-6 mb-5  h-100 w-100">
                        <div class="text-center d-flex justify-content-center align-items-center login-app-name">
                            <div class="image image-mini me-3 mb-0">
                                <a href="{{ route('home') }}" class="image">
                                    <img alt="Logo" src="{{ getLogoUrl() }}" class="img-fluid logo-fix-size">
                                </a>
                            </div>
                            <span class="text-gray-900 fs-1 fw-bold">{{ getAppName() }}</span>
                        </div>
                        <div class="row element">
                            <div class="col-md-12 width-540">
                                @include('flash::message')
                                @include('layouts.errors')
                            </div>
                            <h1 class="text-center mb-7 mt-5 fs-2 fw-bold">{{ __('auth.sign_in') }}</h1>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
                                <div class="mb-sm-7 mb-4 element">
                                    <label for="email" class="form-label">
                                        {{ __('messages.user.email') . ':' }}<span class="required"></span>
                                    </label>
                                    <input name="email" type="email" class="form-control" id="email"
                                        aria-describedby="emailHelp" required
                                        placeholder=" {{ __('messages.user.email') }}" value="{{ old('email', \Cookie::get('email', '')) }}">
                                </div>
                                <div class="mb-sm-7 mb-4 element">
                                    <div class="d-flex justify-content-between">
                                        <label for="password"
                                            class="form-label">{{ __('messages.user.password') . ':' }}<span
                                                class="required"></span></label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}"
                                                class="link-info fs-6 text-decoration-none">
                                                {{ __('messages.common.forgot_your_password') . '?' }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="mb-3 position-relative ">
                                        <input name="password" type="password" class="form-control" id="password" required
                                            placeholder="{{ __('messages.user.password') }}" aria-label="Password"
                                            data-toggle="password" @if (\Cookie::has('password')) value="{{ \Cookie::get('password') }}" @endif>
                                        <span
                                            class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-sm-7 mb-4 form-check element">
                                    <input type="checkbox" class="form-check-input form-solid" id="remember"
                                    name="remember" @if (\Cookie::has('remember')) checked @endif>
                                    <label class="form-check-label"
                                        for="remember_me">{{ __('messages.common.remember_me') }}</label>
                                </div>
                                <div class="d-grid element">
                                    <button type="submit" class="btn login-btn">{{ __('messages.common.login') }}</button>
                                </div>
                                @if (getSuperAdminSettingValue('register_enable'))
                                    <div class="d-flex align-items-center mb-10 mt-4 element">
                                        <span class="text-gray-700 me-2">{{ __('messages.common.new_here') . '?' }}</span>
                                        <a href="{{ route('register') }}" class="link-info fs-6 text-decoration-none">
                                            {{ __('messages.common.create_an_account') }}
                                        </a>
                                    </div>
                                @endif
                                <div class="row justify-content-between mt-5">
                                    <div class="col-6">
                                        @if (config('app.google_client_id') && config('app.google_client_secret') && config('app.google_redirect'))
                                            <a href="{{ route('social.login', 'google') }}"
                                                class="btn google-btn d-flex align-items-center justify-content-center mb-sm-4 mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50"
                                                height="27" viewBox="0 0 48 48">
                                                <path fill="#FFC107"
                                                    d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z">
                                                </path>
                                                <path fill="#FF3D00"
                                                    d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z">
                                                </path>
                                                <path fill="#4CAF50"
                                                    d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z">
                                                </path>
                                                <path fill="#1976D2"
                                                    d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z">
                                                </path>
                                            </svg>{{ __('messages.placeholder.login_via_google') }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        @if (config('app.facebook_app_id') && config('app.facebook_app_secret') && config('app.facebook_redirect'))
                                            <a href="{{ route('social.login', 'facebook') }}"
                                                class="btn facebook-btn d-flex align-items-center justify-content-center">
                                                <i
                                                    class="fa-brands fa-facebook-f fs-2 me-3"></i>{{ __('messages.placeholder.login_via_facebook') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <footer>
                    <div class="container-fluid padding-0 mb-5 copy-right">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-6 w-100">
                                <div class="copyright text-center text-muted" style="z-index: 999; position: relative;">
                                    {{ __('messages.placeholder.all_rights_reserve') }} &copy; {{ date('Y') }} <a
                                        href="{{ route('home') }}" class="font-weight-bold ml-1"
                                        target="_blank">{{ getAppName() }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
@endsection
