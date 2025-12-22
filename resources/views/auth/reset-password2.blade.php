@extends('layouts.auth2')
@section('title')
    {{ __('messages.reset_password') }}
@endsection
@section('content')
    <div class="reset-password-section bg-white overflow-hidden position-relative min-vh-100"
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

                        <div class="bg-white p-4 p-sm-5 modern-reset-card" style="border-radius: 24px !important; max-width: 500px; margin: 0 auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.2) inset; border: 1px solid rgba(0, 0, 0, 0.05);">

                            <div class="row element">
                                <div class="col-md-12">
                                    @include('layouts.errors')
                                    @if (Session::has('status'))
                                        <div class="alert alert-success fs-6 text-dark align-items-center mb-4 modern-alert" role="alert"
                                             style="border-radius: 12px !important; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; color: white !important; font-weight: 500;">
                                            <i class="fa-solid fa-face-smile me-3"></i>
                                            {{ Session::get('status') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <h1 class="text-center mb-4 fs-3 fw-bold" style="color: #1f2937; font-size: 1.5rem;">{{__('messages.common.forgot_password').' ?'}}</h1>

                            <form class="form w-100" method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
                                        {{ __('messages.user.email') }}:<span class="required"></span>
                                    </label>
                                    <input id="email" class="form-control modern-input"
                                           value="{{ old('email', $request->email) }}"
                                           type="email" name="email" required autocomplete="off" autofocus
                                           style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;" />
                                    @if($errors->has('email'))
                                        <div class="text-danger small mt-2" style="font-size: 13px; font-weight: 500;">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
                                        {{ __('messages.user.password') }}:<span class="required"></span>
                                    </label>
                                    <div class="position-relative">
                                        <input id="password" class="form-control modern-input"
                                               type="password" name="password" required autocomplete="off" style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;" />
                                    </div>
                                    @if($errors->has('password'))
                                        <div class="text-danger small mt-2" style="font-size: 13px; font-weight: 500;">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
                                        {{ __('messages.user.confirm_password') }}:<span class="required"></span>
                                    </label>
                                    <div class="position-relative">
                                        <input class="form-control modern-input" type="password"
                                               id="password_confirmation" name="password_confirmation"
                                               autocomplete="off" required style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;" />
                                    </div>
                                    @if($errors->has('password_confirmation'))
                                        <div class="text-danger small mt-2" style="font-size: 13px; font-weight: 500;">{{ $errors->first('password_confirmation') }}</div>
                                    @endif
                                </div>

                                <div class=" d-flex flex-column flex-md-row gap-3">
                                    <button type="submit" class="btn text-white fw-bold border-0 modern-reset-btn flex-fill" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);">
                                        {{ __('messages.reset_password') }}
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
                                <a href="{{ route('home') }}" class="font-weight-bold ms-1" style="color: #667eea; text-decoration: none;">{{ getAppName() }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" id="zsiqchat">
        var $zoho = $zoho || {};
        $zoho.salesiq = $zoho.salesiq || {
            widgetcode: 'f2e92e58c41f499182d7ab0aa52668889d66adc7a843882454c2869ab82b8b8e',
            values: {},
            ready: function () {},
        };
        var d = document;
        s = d.createElement('script');
        s.type = 'text/javascript';
        s.id = 'zsiqscript';
        s.defer = true;
        s.src = 'https://salesiq.zoho.com/widget';
        t = d.getElementsByTagName('script')[0];
        t.parentNode.insertBefore(s, t);
    </script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-BLPPF2NWL3"></script>

    <script>

        window.dataLayer = window.dataLayer || [];

        function gtag(){dataLayer.push(arguments);}

        gtag('js', new Date());

        gtag('config', 'G-BLPPF2NWL3');

    </script>
@endpush
