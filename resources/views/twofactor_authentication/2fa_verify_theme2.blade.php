@extends('layouts.auth2')
@section('title')
    {{ __('messages.two_factor_auth.twofactor_authentication') }}
@endsection
@section('content')
<div class="login-section bg-white overflow-hidden position-relative min-vh-100"
     style="background-image: url('{{ asset($registerImage) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="d-flex align-items-center justify-content-center min-vh-100 p-3 p-md-4"
         @if(getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' || getLanguageByKey(checkFrontLanguageSession()) == 'Persian') dir="rtl" @endif style="position: relative;">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-9 col-md-6 col-lg-5 col-xl-4">

                    <div class="text-center mb-3 mb-md-3">
                        <div class="d-flex flex-column justify-content-center align-items-center logo-container">
                            <div class="mb-3">
                                <a href="{{ route('home') }}">
                                    <img alt="Logo" src="{{ getLogoUrl() }}"
                                         class="img-fluid"
                                         style="max-height: 80px; max-width: 120px; width: 90px;">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 p-sm-5 modern-login-card" style="border-radius: 24px; max-width: 500px; margin: 0 auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1); border: 1px solid rgba(0, 0, 0, 0.05);">

                        @include('layouts.errors')
                        @include('flash::message')
                        @if (Session::has('status'))
                            <div class="alert alert-success fs-4 text-white align-items-center" role="alert">
                                <i class="fa-solid fa-face-smile me-4"></i>
                                {{ Session::get('status') }}
                            </div>
                        @endif

                        <h1 class="text-center mb-7">{{ __('messages.two_factor_auth.twofactor_authentication') }}</h1>

                        <div class="fs-4 text-center mb-5">
                            {{ __('messages.two_factor_auth.please_enter_6_digit_code_from_your_authenticator_app_to_login') }}
                        </div>

                        <form class="form w-100" method="POST" action="{{ route('2fa.verify') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="verification_code" class="form-label fw-semibold mb-2 text-gray-700" style="font-size: 14px;">
                                    {{ __('messages.two_factor_auth.one_time_password_otp') }}<span class="required"></span>
                                </label>
                                <input type="password" name="verification_code" class="form-control modern-input" id="verification_code"
                                    placeholder="{{ __('messages.two_factor_auth.enter_6_digit_code') }}" autocomplete="one-time-code">
                            </div>

                            <div class="d-flex flex-column flex-md-row gap-3">
                                <button type="submit"
                                    class="btn text-white fw-bold border-0 modern-login-btn flex-fill"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                        border-radius: 12px; font-size: 16px; transition: all 0.3s ease;
                                        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);">
                                    {{ __('messages.two_factor_auth.verify_otp') }}
                                </button>

                                <a href="{{ route('login') }}"
                                class="btn btn-light border text-decoration-none flex-fill modern-cancel-btn"
                                style="border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px;
                                        transition: all 0.3s ease; background: #ffffff; color: #374151;
                                        font-weight: 600;">
                                    {{ __('messages.common.cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="text-center mt-4 mt-md-5 copy-right">
                        <div class="copyright text-black" style="font-size: 14px;">
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
