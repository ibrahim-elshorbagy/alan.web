@extends('layouts.auth2')
@section('title')
    {{ __('messages.common.forgot_password') }}
@endsection
@section('content')
    <div class="forget-password-section bg-white overflow-hidden position-relative min-vh-100"
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

                        <div class="bg-white p-4 p-sm-5 modern-forgot-card" style="border-radius: 24px !important; max-width: 500px; margin: 0 auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.2) inset; border: 1px solid rgba(0, 0, 0, 0.05);">

                            <div class="row element">
                                <div class="col-md-12">
                                    @include('layouts.errors')
                                    @include('flash::message')
                                    @if (Session::has('status'))
                                        <div class="alert alert-success fs-6 text-dark align-items-center mb-4 modern-alert" role="alert"
                                             style="border-radius: 12px !important; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; color: white !important; font-weight: 500;">
                                            <i class="fa-solid fa-face-smile me-3"></i>
                                            {{ Session::get('status') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="text-center mb-4 mb-md-5">
                                <div class="mb-3">
                                    <h2 class="fw-bold" style="color: #1f2937; font-size: 1.5rem; margin-bottom: 0.5rem;">
                                        {{ __('messages.placeholder.enter_your_email_to_reset') }}
                                    </h2>
                                </div>
                                <div class="text-muted" style="font-size: 1rem; font-weight: 500; line-height: 1.6;">
                                    {{ __('messages.placeholder.forgot_your_password_no_problem') }}
                                </div>
                            </div>

                            <form class="form w-100" method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-4 pt-2">
                                    <label for="email" class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
                                        {{ __('messages.user.email') }}:<span class="required"></span>
                                    </label>
                                    <input id="email" class="form-control modern-input" type="email"
                                           value="{{ old('email') }}" required autofocus name="email"
                                           autocomplete="off" placeholder="{{ __('messages.user.email') }}"
                                           style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;" />
                                </div>

                                <div class="d-flex flex-column flex-md-row gap-3">
                                    <button type="submit" class="btn text-white fw-bold border-0 modern-reset-btn flex-fill" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);">
                                        {{ __('messages.email_password_reset_link') }}
                                    </button>
                                    <a href="{{ route('login') }}"
                                       class="btn btn-light border text-decoration-none flex-fill modern-cancel-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; transition: all 0.3s ease; background: #ffffff; color: #374151; font-weight: 600;">
                                        {{ __('messages.common.cancel') }}
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div class="text-center mt-3 mt-md-3 copy-right">
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
