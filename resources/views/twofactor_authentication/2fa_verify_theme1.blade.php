@extends('layouts.auth')
@section('title')
    {{ __('messages.two_factor_auth.twofactor_authentication') }}
@endsection
@section('content')
    <div class="forget-password-section bg-white overflow-hidden position-relative  h-100">
        <div class="top-vector">
            <img src="{{ asset('assets/images/top-vector.png') }}">
        </div>
        <div class="bottom-vector">
            <img src="{{ asset('assets/images/bottom-vector.png') }}">
        </div>
        <div class="row">
            <div class="col-md-6 col-12 p-0">
                <div class="forget-password-img ">
                    <img src="{{ asset($registerImage) }}" alt="Register Image" class="w-100 h-100">
                </div>
            </div>
            <div class="col-md-6 col-12 p-0 d-flex flex-column justify-content-center forget-password-section"
                @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' || getLanguageByKey(checkFrontLanguageSession()) == 'Persian') dir="rtl" @endif>
                <div class="forget-password-form ">
                    <div class="col-12 text-center mt-0 mb-5 d-flex justify-content-center align-items-center">
                        <div class="image image-mini me-3 mb-0">
                            <a href="{{ route('home') }}" class="image">
                                <img alt="Logo" src="{{ getLogoUrl() }}" class="img-fluid logo-fix-size">
                            </a>
                        </div>
                        <span class="text-gray-900 fs-1 fw-bold">{{ getAppName() }}</span>
                    </div>
                    <div class="row element">
                        <div class="width-540 col-md-12 mt-1">
                            @include('layouts.errors')
                            @include('flash::message')
                            @if (Session::has('status'))
                                <div class="alert alert-success fs-4 text-white align-items-center" role="alert">
                                    <i class="fa-solid fa-face-smile me-4"></i>
                                    {{ Session::get('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-white width-540 px-5 py-10 pt-0 mx-auto">
                        <h1 class="text-center mb-7">{{ __('messages.two_factor_auth.twofactor_authentication') }}</h1>

                        <div class="fs-4 text-center mb-5">
                            {{ __('messages.two_factor_auth.please_enter_6_digit_code_from_your_authenticator_app_to_login') }}
                        </div>
                        <form class="form w-100" method="POST" action="{{ route('2fa.verify') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-4 z-index-9">
                                    <label for="email" class="form-label">
                                        {{ __('messages.two_factor_auth.one_time_password_otp') }}<span class="required"></span>
                                    </label>
                                    <input type="password" name="verification_code" class="form-control password-input"
                                        id="varificationotp" placeholder="{{ __('messages.two_factor_auth.enter_6_digit_code') }}">
                                </div>
                            </div>
                            <div class="row">
                                <!-- Submit Field -->
                                <div
                                    class="form-group col-sm-12 d-flex text-start align-items-center z-index-9 btn-section mt-2">
                                    <button type="submit" class="btn reset-link">
                                        <span class="indicator-label text-light">
                                             {{ __('messages.two_factor_auth.verify_otp') }}</span>
                                    </button>
                                    <a href="{{ route('login') }}"
                                        class="btn btn-secondary my-0 ms-5 me-0">{{ __('messages.common.cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <footer>
                    <div class="container-fluid padding-0 mb-5 copy-right">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-6 w-100">
                                <div class="copyright text-center text-muted">
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
