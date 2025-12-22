    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('title') | {{ getAppName() }}</title>
        <!-- Favicon -->
        <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!-- General CSS Files -->

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
        {{--        <link rel="stylesheet" type="text/css" href="{{ asset('assets/scss/custom.css') }}"> --}}
        @livewireStyles
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">



        <link rel="stylesheet" type="text/css"
            href="{{ asset('vendor/rappasoft/livewire-tables/css/laravel-livewire-tables.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('vendor/rappasoft/livewire-tables/css/laravel-livewire-tables-thirdparty.min.css') }}">
        @if (!getLogInUser()->theme_mode)
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css?id=$mixID') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
        @else
            <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.dark.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.dark.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/custom-pages-dark.css') }}">
        @endif
        <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/page.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/theme.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/lazy-loading.css') }}">

        @livewireScripts
        <script src="{{ asset('vendor/rappasoft/livewire-tables/js/laravel-livewire-tables.min.js') }}"></script>
        <script src="{{ asset('vendor/rappasoft/livewire-tables/js/laravel-livewire-tables-thirdparty.min.js') }}"></script>

        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://checkout.razorpay.com/v1/checkout.js" data-turbolinks-eval="false" data-turbo-eval="false">
        </script>

        <script src="{{ asset('assets/js/third-party.js') }}"></script>

        <script data-turbo-eval="false">
            let mobileValidation = "{{ getSuperAdminSettingValue('mobile_validation') }}"
            let phoneNumberRequired = "{{ getSuperAdminSettingValue('phone_number_required') }}"
            let stripe = ''
            @if (getSelectedPaymentGateway('stripe_key'))
                stripe = Stripe('{{ getSelectedPaymentGateway('stripe_key') }}')
            @endif
            let appUrl = "{{ config('app.url') }}"
            let noData = "{{ __('messages.no_data') }}"
            let utilsScript = "{{ asset('assets/js/inttel/js/utils.min.js') }}"
            let defaultProfileUrl = "{{ asset('web/media/avatars/user.png') }}"
            let defaultTemplate = "{{ asset('assets/images/default_cover_image.jpg') }}"
            let defaultServiceIconUrl = "{{ asset('assets/images/default_service.png') }}"
            let defaultProductIconUrl = "{{ asset('images/wp-product.png') }}"
            let defaltNfcLogo = "{{ asset('assets/img/nfc/nfc_default_logo.png') }}"
            let defaultCoverUrl = "{{ asset('assets/images/default_cover_image.jpg') }}"
            let defaultGalleryUrl = "{{ asset('assets/images/default_service.png') }}"
            let defaultAppLogoUrl = "{{ asset(getAppLogo()) }}"
            let defaultFaviconUrl = "{{ getFaviconUrl() }}"
            let getLoggedInUserdata = "{{ getLogInUser() }}"
            window.getLoggedInUserLang = "{{ getCurrentLanguageName() }}"
            let lang = "{{ Illuminate\Support\Facades\Auth::user()->language ?? 'en' }}"
            let getCurrencyCode = "{{ getMaximumCurrencyCode($getIcon = true) }}"
            let sweetAlertIcon = "{{ asset('images/remove.png') }}"
            let sweetCompletedAlertIcon = "{{ asset('images/Alert.png') }}"
            let defaultCountryCodeValue = "{{ getSuperAdminSettingValue('default_country_code') }}"
            let getUniqueVcardUrlAlias = "{{ getUniqueVcardUrlAlias() }}"
            let currencyAfterAmount = "{{ getSuperAdminSettingValue('currency_after_amount') }}"
            let userDateFormate = "{{ getSuperAdminSettingValue('datetime_method') ?? 1 }}";
            let defaultVideoCoverImg = "{{ asset('assets/images/video-icon.png') }}";
            let getLoggedInUsersteps = "{{ getLogInUser()->steps }}"
            let hasActiveSubscription = "{{ hasActiveSubscription() }}"
            let defaultPlaceholderImgUrl = "{{ asset('web/media/logos/placeholder.png') }}"
            let defaultNfcCard = "{{ asset('assets/img/nfc/card_default.png') }}"
            $(document).ready(function() {
                $('[data-bs-toggle="tooltip"]').tooltip()
            })
        </script>
        <script src="{{ asset('vendor/rappasoft/livewire-tables/js/laravel-livewire-tables.min.js') }}"></script>
        <script src="{{ asset('vendor/rappasoft/livewire-tables/js/laravel-livewire-tables-thirdparty.min.js') }}"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> --}}
        @stack('scripts')
        @routes
        <script src="{{ asset('messages.js?$mixID') }}"></script>
        <script src="{{ mix('assets/js/pages.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/js/shepherd.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/css/shepherd.css" />
        <style>
            :root {
                /* --bs-primary: {{ getSuperAdminSettingValue('primary_color') ?? '#6571FF' }};
                --bs-secondary: {{ getSuperAdminSettingValue('secondary_color') ?? '#ADB5BD' }};
                --bs-info: {{ getSuperAdminSettingValue('primary_color') ?? '#0099FB' }};
                --bs-primary-rgb: {{ hexToRgb(getSuperAdminSettingValue('primary_color') ?? '#6571FF') }};
                --bs-bg-blur: rgba(var(--bs-primary-rgb), 0.2); */
                --bs-primary: {{ getSuperAdminSettingValue('primary_color') ?? '#1C274C' }};
                --bs-secondary: {{ getSuperAdminSettingValue('secondary_color') ?? '#ADB5BD' }};
                --bs-info: {{ getSuperAdminSettingValue('primary_color') ?? '#0099FB' }};
                --bs-primary-rgb: {{ hexToRgb(getSuperAdminSettingValue('primary_color') ?? '#1C274C') }};
                --bs-bg-blur: rgba(var(--bs-primary-rgb), 0.2);
            }


            .btn-primary,
            .btn-outline-primary:hover {
                background-color: var(--bs-primary) !important;
                color: #fff !important;
                border-color: var(--bs-primary) !important;
            }

            .bg-primary {
                background-color: var(--bs-primary) !important;
            }

            .bg-info {
                background-color: var(--bs-primary) !important;
                opacity: 0.7 !important;
            }

            .bg-secondary {
                background-color: var(--bs-secondary) !important;
            }

            .btn-outline-primary {
                color: var(--bs-primary) !important;
                border-color: var(--bs-primary) !important;
            }

            .btn-secondary {
                background-color: var(--bs-secondary) !important;
                border-color: var(--bs-secondary) !important;
                color: #fff !important;
            }

            /* Text */
            .text-primary {
                color: var(--bs-primary) !important;
            }

            .text-secondary {
                color: var(--bs-secondary) !important;
            }

            .text-info {
                color: var(--bs-primary) !important;
            }

            /* Badge */
            .badge-primary {
                background-color: var(--bs-primary) !important;
            }

            .badge-secondary {
                background-color: var(--bs-secondary) !important;
            }

            /* Alerts */
            .alert-primary {
                background-color: var(--bs-primary) !important;
                color: #fff !important;
            }

            .alert-secondary {
                background-color: var(--bs-secondary) !important;
                color: #fff !important;
            }

            .alert-info {
                background-color: var(--bs-primary) !important;
                color: #fff !important;
            }

            .form-check-input:checked {
                background-color: var(--bs-primary) !important;
                border-color: var(--bs-primary) !important;
            }

            .form-check-input[type="checkbox"]:indeterminate {
                background-color: var(--bs-primary) !important;
                border-color: var(--bs-primary) !important;
            }

            .form-switch .form-check-input:checked {
                background-color: var(--bs-primary) !important;
                border-color: var(--bs-primary) !important;
            }

            .btn-info {
                background-color: var(--bs-primary) !important;
                border-color: var(--bs-primary) !important;
            }

            .page-item.active .page-link {
                background-color: var(--bs-primary) !important;
                border-color: var(--bs-primary) !important;
            }

            .header .navbar-nav .nav-item .active.nav-link:after {
                border-bottom-color: var(--bs-primary) !important;
            }

            .header .navbar-nav .nav-item:hover .nav-link:after {
                border-bottom-color: var(--bs-primary) !important;
            }

            .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option.select2-results__option--selected,
            .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option[aria-selected=true]:not(.select2-results__option--highlighted) {
                background-color: var(--bs-primary) !important;
            }

            .nav-tabs .nav-item .nav-link.active:after,
            .nav-tabs .nav-item:hover .nav-link:after {
                border-bottom-color: var(--bs-primary) !important;
                /* border-bottom-color: #1C274C !important; */
            }

            .nav-tabs .nav-item.show .nav-link,
            .nav-tabs .nav-link.active {
                color: var(--bs-primary) !important;
                /* color: #1C274C !important; */
            }

            .nav-pills .nav-link.active,
            .nav-pills .show>.nav-link {
                background-color: var(--bs-primary) !important;
            }

            .btn-group-toggle input[type=radio]:checked+label,
            .btn-group-toggle input[type=radio]:focus+label {
                background-color: var(--bs-primary) !important;
                border: 1px solid var(--bs-primary) !important;
            }

            .aside-menu-container__aside-menu .nav-item .nav-link:hover,
            .aside-menu-container__aside-menu .nav-item.active>.nav-link {
                /* border-left-color: var(--bs-primary) !important;
                background-color: rgba(var(--bs-primary-rgb), 0.2) !important; */
                background-color: var(--bs-primary) !important;
            }

            .blur-bg {
                background-color: rgba(var(--bs-primary-rgb), 0.2) !important;
            }

            .setting-tab .nav-item .nav-link.active {
                /* border-left-color: transparent !important; */
                background-color: rgba(var(--bs-primary-rgb)) !important;
                border-radius: 8px !important;
            }

            .setting-tab .nav-item .nav-link:not(.active):hover {
                /* border-left-color: transparent !important; */
                background-color: rgba(var(--bs-primary-rgb)) !important;
                color: #fff !important;
                border-radius: 8px !important;
            }

            .setting-tab .nav-item .nav-link:not(.active):hover .icon-color-gray{
                color: #fff !important;
            }

            .setting-tab .nav-item .nav-link.active .icon-color-gray{
                color: #ffffff !important;
            }

            /* .nav-tabs-1 .nav-item-1 .nav-link-1.active,
            .nav-tabs-1 .nav-item-1 .nav-link-1:hover {
                border-left-color: transparent !important;
                background-color: rgba(var(--bs-primary-rgb), 0.2) !important; */
                /* border-left-color: var(--bs-primary) !important; */
            /* } */

            .nav-tabs-1 .nav-item-1 .nav-link-1 {
                color: #6c757d !important;
            }

            .img-radio.img-border {
                border: 3px solid var(--bs-primary) !important;

            }

            .template-border {
                border: 3px solid var(--bs-primary) !important;
            }

            .progress-bar {
                background-color: var(--bs-primary) !important;
                /* background-color: #1C274C !important; */
            }

            .setting-tab {
                background: #f8f8f8;
                border-radius: 16px;
                padding: 15px;
                border: 1px solid #e8ecef;
                width: 100%;
                max-width: 100%;
                box-shadow: rgba(0, 0, 0, 0.15) 0.85px 0.85px 1.6px;
                overflow-x: hidden;
                /* height: -webkit-fill-available; */
            }

            .setting-tab .nav-item {
                /* margin: 0 16px 12px 16px; */
                border-radius: 12px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                background: #f8f9fa;
                border: 1px solid transparent;
                width: 100%;
                min-height: 48px;
            }

            .setting-tab .nav-item:not(.active):hover {
                /* transform: translateY(-2px); */
                /* background: #e9ecef; */
                /* border-color: #dee2e6; */
            }

            .setting-tab .nav-link {
                color: #A4A4A4 !important;
                font-weight: 600 !important;
                font-size: 14px !important;
                padding: 16px 20px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                transition: all 0.3s ease;
                font-size: 14px;
                width: 100%;
                min-height: 48px;
                box-sizing: border-box;
            }

            .setting-tab .nav-link.active {
                /* background: linear-gradient(135deg, #007bff, #0056b3); */
                color: #ffffff !important;
            }

            .setting-tab .nav-link i {
                margin-right: 14px;
                font-size: 18px;
                width: 24px;
                text-align: center;
                flex-shrink: 0;
            }

            /* Tablet-specific improvements (768px - 1024px) */
            @media (min-width: 768px) and (max-width: 1024px) {
                .me-5 {
                    margin-right: 2rem !important;
                    width: 280px; /* Fixed width for better tablet layout */
                    max-width: 280px;
                    flex-shrink: 0;
                }

                .setting-tab {
                    border-radius: 18px;
                    padding: 20px 0;
                    height: fit-content;
                    max-height: calc(100vh - 100px);
                    overflow-y: auto;
                }

                .setting-tab .nav-item {
                    margin: 0 14px 10px 14px;
                    width: calc(100% - 28px);
                    border-radius: 14px;
                }

                .setting-tab .nav-link {
                    padding: 15px 18px;
                    font-size: 13px;
                    min-height: 50px;
                    border-radius: 14px;
                }

                .setting-tab .nav-link i {
                    margin-right: 12px;
                    font-size: 17px;
                    width: 22px;
                }

                /* Better spacing for tablet portrait */
                .setting-tab .nav-link {
                    white-space: nowrap;
                    /* overflow: hidden; */
                    text-overflow: ellipsis;
                }
            }

            /* Tablet landscape specific (1024px width) */
            @media (min-width: 1024px) and (max-width: 1200px) {
                .me-5 {
                    width: 300px;
                    max-width: 300px;
                }

                /* .setting-tab {
                    padding: 24px 0;
                } */

                /* .setting-tab .nav-item {
                    margin: 0 16px 12px 16px;
                } */

                .setting-tab .nav-link {
                    padding: 16px 20px;
                    font-size: 14px;
                }
            }

            /* Mobile fixes (up to 767px) */
            @media (max-width: 767px) {
                .me-5 {
                    margin-right: 0 !important;
                    width: 100%;
                    max-width: 100vw;
                    overflow-x: hidden;
                }

                /* .setting-tab {
                    border-radius: 12px;
                    padding: 16px 0;
                    margin: 0 8px;
                }

                .setting-tab .nav-item {
                    margin: 0 12px 8px 12px;
                    width: calc(100% - 24px);
                } */

                .setting-tab .nav-link {
                    padding: 14px 16px;
                    font-size: 13px;
                    min-height: 44px;
                }

                .setting-tab .nav-link i {
                    margin-right: 12px;
                    font-size: 16px;
                    width: 20px;
                }

                /* Fix horizontal scroll issues */
                .overflow-auto {
                    overflow-x: hidden !important;
                    overflow-y: auto;
                }

                .flex-nowrap {
                    flex-wrap: wrap !important;
                }

                .text-nowrap {
                    white-space: normal !important;
                }
            }

            /* Extra small screens (480px and below) */
            @media (max-width: 480px) {
                /* .setting-tab {
                    margin: 0 4px;
                    border-radius: 8px;
                    padding: 12px 0;
                }

                .setting-tab .nav-item {
                    margin: 0 8px 6px 8px;
                    width: calc(100% - 16px);
                    border-radius: 8px;
                } */

                .setting-tab .nav-link {
                    padding: 12px 14px;
                    font-size: 12px;
                    border-radius: 8px;
                    min-height: 40px;
                }

                .setting-tab .nav-link i {
                    margin-right: 10px;
                    font-size: 14px;
                    width: 18px;
                }
            }

            /* Container overflow fixes */
            /* .d-flex.nav.nav-tabs.mb-5.pb-1.overflow-auto.flex-nowrap.text-nowrap.flex-column.setting-tab {
                max-width: 100%;
                overflow-x: hidden !important;
            } */

            /* Additional tablet layout optimization */
            @media (min-width: 768px) and (max-width: 1024px) {
                /* Ensure main content area adjusts properly */
                .container-fluid {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }

                /* Optimize for tablet orientation changes */
                @media (orientation: portrait) {
                    .me-5 {
                        width: 260px;
                        max-width: 260px;
                    }

                    .setting-tab .nav-link {
                        font-size: 12px;
                        padding: 14px 16px;
                    }
                }

                @media (orientation: landscape) {
                    .me-5 {
                        width: 300px;
                        max-width: 300px;
                    }
                }
            }

            /* Language Tabs Styling */
            .language-tabs {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                padding: 15px 0;
                margin: 0;
            }

            .language-tabs .nav-item {
                margin: 0;
            }

            .language-tabs .nav-link {
                background-color: #f8f9fa;
                color: #495057;
                border: none;
                border-radius: 6px;
                padding: 10px 18px;
                font-weight: 500;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
                cursor: pointer;
                min-width: 65px;
                width: 65px;
                text-align: center;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                white-space: nowrap;
            }

            .language-tabs .nav-link:hover:not(.active) {
                background-color: #e9ecef;
                color: #212529;
                transform: translateY(-1px);
            }

            .language-tabs .nav-link.active {
                background-color: var(--bs-primary);
                color: white;
            }

            .language-tabs .nav-link.active:hover {
                background-color: var(--bs-primary);
            }

            .tab-content {
                margin-top: 20px;
                padding-top: 20px;
            }

            .tab-pane {
                padding-top: 0;
            }

            .selected-language-info {
                padding: 12px 16px;
                background: #f8f9fa;
                border-left: 4px solid var(--bs-primary);
                border-radius: 4px;
            }

            #selectedLanguageName {
                font-size: 16px;
                font-weight: 600;
            }
            .shortcode-sidebar {
                background: white;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                overflow: hidden;
            }

            .sidebar-header {
                padding: 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .sidebar-body {
                padding: 15px;
                max-height: 500px;
                overflow-y: auto;
            }

            .shortcode-item {
                padding: 12px;
                margin-bottom: 8px;
                background: #f8f9fa;
                border-radius: 8px;
                cursor: pointer;
                transition: all 0.2s;
                border: 1px solid #e9ecef;
            }

            .shortcode-item:hover {
                background: #e7f3ff;
                border-color: var(--bs-primary);
                transform: translateX(5px);
            }

            .shortcode-icon {
                width: 35px;
                height: 35px;
                background: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 12px;
                color: #667eea;
            }

            .shortcode-name {
                font-weight: 600;
                font-size: 13px;
                color: #333;
            }

            .shortcode-desc {
                font-size: 11px;
                color: #6c757d;
            }

            .shortcode-action {
                opacity: 0;
                transition: opacity 0.2s;
            }

            .shortcode-item:hover .shortcode-action {
                opacity: 1;
            }
        </style>
        <style>
            .note-editable ul {
                list-style: disc;
                padding-left: 35px;
            }

            .note-editable ol {
                list-style: decimal;
                padding-left: 35px;
            }
        </style>
        <style>
            .vcard-sidebar-submenu {
                height: 100% !important;
            }
        </style>


    </head>

    <body>

        @if (getLogInUser()->language != 'ar' && getLogInUser()->language != 'fa')
            <div class="d-flex flex-column flex-root vh-100">
                <div class="d-flex flex-row flex-column-fluid">
                    @include('layouts.sidebar')
                    <div class="wrapper d-flex flex-column flex-row-fluid">
                        <div class='container-fluid d-flex align-items-stretch justify-content-between px-0'>
                            @include('layouts.header')
                        </div>
                        <div class='content d-flex flex-column flex-column-fluid pt-7 overflow-scroll'>
                            @yield('header_toolbar')
                            <div class='d-flex flex-wrap flex-column-fluid'>
                                @yield('content')
                            </div>
                        </div>
                        <div class='container-fluid'>
                            @include('layouts.footer')
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa')
            <div class="rtl" dir="rtl">
                <div class="d-flex flex-column flex-root vh-100">
                    <div class="d-flex flex-row flex-column-fluid">
                        @include('layouts.sidebar')
                        <div class="wrapper d-flex flex-column flex-row-fluid">
                            <div class='container-fluid d-flex align-items-stretch justify-content-between px-0'>
                                @include('layouts.header')
                            </div>
                            <div class='content d-flex flex-column flex-column-fluid pt-7 overflow-scroll'>
                                @yield('header_toolbar')
                                <div class='d-flex flex-wrap flex-column-fluid'>
                                    @yield('content')
                                </div>
                            </div>
                            <div class='container-fluid'>
                                @include('layouts.footer')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @include('profile.changePassword')
        @include('profile.changelanguage')
        @include('layouts.shepherd-js')
        @include('twofactor_authentication.two_factor_authentication')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cropper/1.0.1/jquery-cropper.min.js"></script>
    </body>


    </html>
