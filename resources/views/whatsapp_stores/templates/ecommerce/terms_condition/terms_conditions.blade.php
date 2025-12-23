<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />

    @if (checkFeature('seo') && $whatsappStore->site_title && $whatsappStore->home_title)
        <title>{{ $whatsappStore->home_title }} | {{ $whatsappStore->site_title }}</title>
    @else
        <title>{{ $whatsappStore->store_name }} | {{ getAppName() }}</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ $whatsappStore->logo_url }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (checkFeature('seo'))
        @if ($whatsappStore->meta_description)
            <meta name="description" content="{{ $whatsappStore->meta_description }}">
        @endif
        @if ($whatsappStore->meta_keyword)
            <meta name="keywords" content="{{ $whatsappStore->meta_keyword }}">
        @endif
    @else
        <meta name="description" content="{{ $whatsappStore->description }}">
        <meta name="keywords" content="">
    @endif

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('pwa/1.json') }}">

    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if (checkFeature('custom-fonts') && $whatsappStore->font_family)
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family={{ urlencode($whatsappStore->font_family) }}:wght@400;500;600;700&display=swap{{ in_array($whatsappStore->font_family, ['Tajawal', 'Cairo', 'Amiri', 'Noto Sans Arabic', 'Noto Naskh Arabic', 'Noto Kufi Arabic', 'Scheherazade', 'Lateef', 'Harmattan', 'Reem Kufi', 'Jomhuria', 'Mada', 'Lemonada', 'Zain']) ? '&subset=arabic' : '' }}">
    @endif
    <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/ecommerce.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/custom.css') }}" />
    @if ($whatsappStore->font_family || $whatsappStore->font_size || $whatsappStore->custom_css)
        <style>
            @if ($whatsappStore->font_family)
                body {
                    font-family: {{ $whatsappStore->font_family }} !important;
                }
            @endif

            @if ($whatsappStore->font_size)
                div > h4 {
                    font-size: {{ $whatsappStore->font_size }}px !important;
                }
            @endif

            @if ($whatsappStore->custom_css)
                {!! $whatsappStore->custom_css !!}
            @endif
        </style>
    @endif
</head>

<body>
    <div class="main-content mx-auto w-100 overflow-hidden d-flex flex-column justify-content-between {{ getLocalLanguage() == 'ar' || getLocalLanguage() == 'fa' ? 'rtl' : '' }}"
        @if (getLanguage($whatsappStore->default_language) == 'Arabic' || getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
        <div>
            <nav class="navbar navbar-expand-lg px-50 position-relative">
                <div class="container-fluid p-0">
                    <div class="d-flex align-items-center gap-3">
                        <a class="navbar-brand p-0 m-0"
                            href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
                            <img src="{{ $whatsappStore->logo_url }}" alt="logo"
                                class="w-100 h-100 object-fit-cover" loading="lazy" />
                        </a>
                        <span class="fw-6 fs-18"><a
                                href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}"
                                style="color: #212529 ">{{ $whatsappStore->store_name }}</a></span>
                    </div>

                    <div class="d-flex align-items-center gap-lg-4 gap-sm-3 gap-2">
                        <div class="language-dropdown position-relative">
                            <button class="dropdown-btn position-relative" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if (array_key_exists(checkLanguageSession($whatsappStore->url_alias), \App\Models\User::FLAG))
                                    <img class="flag" alt="flag"
                                        src="{{ asset(\App\Models\User::FLAG[getLanguageIsoCode($whatsappStore->default_language) ?? 'en']) }}"
                                        loading="lazy" />
                                @endif
                                {{ strtoupper(getLanguageIsoCode($whatsappStore->default_language) ?? 'en') }}
                            </button>
                            <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="8"
                                viewBox="0 0 18 10" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.615983 0.366227C0.381644 0.600637 0.25 0.918522 0.25 1.24998C0.25 1.58143 0.381644 1.89932 0.615983 2.13373L8.11598 9.63373C8.35039 9.86807 8.66828 9.99971 8.99973 9.99971C9.33119 9.99971 9.64907 9.86807 9.88348 9.63373L17.3835 2.13373C17.6112 1.89797 17.7372 1.58222 17.7343 1.25448C17.7315 0.92673 17.6 0.613214 17.3683 0.381454C17.1365 0.149694 16.823 0.0182329 16.4952 0.0153849C16.1675 0.0125369 15.8517 0.13853 15.616 0.366227L8.99973 6.98248L2.38348 0.366227C2.14907 0.131889 1.83119 0.000244141 1.49973 0.000244141C1.16828 0.000244141 0.850393 0.131889 0.615983 0.366227Z"
                                    fill="black" />
                            </svg>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach (getAllLanguageWithFullData() as $language)
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" id="languageName"
                                            data-name="{{ $language->iso_code }}">

                                            @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                                <img class="flag" alt="flag"
                                                    src="{{ asset(\App\Models\User::FLAG[$language->iso_code]) }} "
                                                    loading="lazy" />
                                            @else
                                                @if (count($language->media) != 0)
                                                    <img src="{{ $language->image_url }}" class="me-1"
                                                        loading="lazy" />
                                                @else
                                                    <i class="fa fa-flag fa-xl me-3 text-danger" aria-hidden="true"></i>
                                                @endif
                                            @endif
                                            {{ strtoupper($language->iso_code) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>


                        <button
                            class="add-to-cart-btn d-flex align-items-center justify-content-center position-relative"
                            id="addToCartViewBtn">
                            <div
                                class="position-absolute cart-count d-flex align-items-center justify-content-center product-count-badge">

                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M27.0834 11.6668C27.0834 11.9984 26.9517 12.3163 26.7172 12.5507C26.4828 12.7851 26.1649 12.9168 25.8334 12.9168C25.5018 12.9168 25.1839 12.7851 24.9495 12.5507C24.7151 12.3163 24.5834 11.9984 24.5834 11.6668V9.16683C24.5834 7.95125 24.1005 6.78546 23.2409 5.92592C22.3814 5.06638 21.2156 4.5835 20 4.5835C18.7844 4.5835 17.6187 5.06638 16.7591 5.92592C15.8996 6.78546 15.4167 7.95125 15.4167 9.16683V11.6668C15.4167 11.9984 15.285 12.3163 15.0506 12.5507C14.8161 12.7851 14.4982 12.9168 14.1667 12.9168C13.8352 12.9168 13.5172 12.7851 13.2828 12.5507C13.0484 12.3163 12.9167 11.9984 12.9167 11.6668V9.16683C12.9167 7.28821 13.663 5.48654 14.9913 4.15816C16.3197 2.82977 18.1214 2.0835 20 2.0835C21.8786 2.0835 23.6803 2.82977 25.0087 4.15816C26.3371 5.48654 27.0834 7.28821 27.0834 9.16683V11.6668Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M32.2367 13.917L33.57 33.917C33.6035 34.4292 33.5316 34.9428 33.3588 35.4262C33.186 35.9095 32.9159 36.3523 32.5653 36.7272C32.2146 37.102 31.7908 37.401 31.3201 37.6057C30.8493 37.8103 30.3416 37.9163 29.8283 37.917H10.1717C9.65823 37.9167 9.1503 37.8111 8.67933 37.6066C8.20836 37.4022 7.78437 37.1032 7.43362 36.7282C7.08287 36.3532 6.81282 35.9103 6.64019 35.4267C6.46756 34.9432 6.39603 34.4293 6.43001 33.917L7.76334 13.917C7.82676 12.9678 8.24855 12.0782 8.94327 11.4284C9.63799 10.7785 10.5537 10.417 11.505 10.417H28.495C29.4463 10.417 30.362 10.7785 31.0568 11.4284C31.7515 12.0782 32.1733 12.9678 32.2367 13.917ZM24.1433 17.797C23.7707 18.5803 23.1837 19.2418 22.4504 19.7051C21.717 20.1683 20.8674 20.4141 20 20.4141C19.1326 20.4141 18.283 20.1683 17.5497 19.7051C16.8163 19.2418 16.2293 18.5803 15.8567 17.797C15.7862 17.6487 15.6872 17.5158 15.5654 17.4057C15.4435 17.2957 15.3012 17.2108 15.1465 17.1557C14.9918 17.1007 14.8278 17.0767 14.6638 17.0851C14.4998 17.0934 14.3391 17.134 14.1908 17.2045C14.0426 17.275 13.9096 17.374 13.7996 17.4958C13.6896 17.6177 13.6046 17.76 13.5496 17.9147C13.4946 18.0694 13.4706 18.2334 13.4789 18.3974C13.4873 18.5613 13.5279 18.722 13.5983 18.8703C14.1724 20.0824 15.0788 21.1066 16.212 21.8238C17.3453 22.541 18.6589 22.9218 20 22.9218C21.3412 22.9218 22.6547 22.541 23.788 21.8238C24.9213 21.1066 25.8276 20.0824 26.4017 18.8703C26.4722 18.722 26.5127 18.5613 26.5211 18.3974C26.5295 18.2334 26.5055 18.0694 26.4504 17.9147C26.3954 17.76 26.3105 17.6177 26.2004 17.4958C26.0904 17.374 25.9575 17.275 25.8092 17.2045C25.6609 17.134 25.5002 17.0934 25.3362 17.0851C25.1722 17.0767 25.0082 17.1007 24.8536 17.1557C24.6989 17.2108 24.5565 17.2957 24.4347 17.4057C24.3128 17.5158 24.2138 17.6487 24.1433 17.797Z"
                                    fill="black" />
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>
        </div>
        <div class="main-content">
            @if (isset($termCondition))
                <div>
                    <div class="conatiner">
                    <div class="text-center">
                        <h4 class="">
                            {{ __('messages.vcard.term_condition') }}
                        </h4>
                    </div>
                        <div class="px-sm-3 px-2 py-md-5 py-3 m-3 card-back">
                            <div class="px-3">
                                {!! $termCondition->term_condition !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @include('whatsapp_stores.templates.order_modal')
        @include('whatsapp_stores.templates.cart_modal')
        <footer class="position-relative">
            <div class="container pt-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <img src="{{ $whatsappStore->logo_url }}" alt="logo" style="width: 50px !important; height: 50px !important;">
                        </div>
                        <div>
                            © Copyright {{ now()->year }} {{ env('APP_NAME') }}. All Rights Reserved.
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-2 pt-3 pt-sm-0">
                        <h5 class="fw-bold text-white mb-3">
                            <i class="fas fa-headset me-2 text-white"></i>{{ __('messages.whatsapp_stores.support_services') }}
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="{{ route('whatsapp.store.show-terms-conditions', $whatsappStore->url_alias) }}"
                                target="_blank"
                                class="text-decoration-none text-white footer-link-hover">
                                    <i class="fas fa-file-contract me-2"></i>{{ __('messages.vcard.term_condition') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('whatsapp.store.show-privacy-policy', $whatsappStore->url_alias) }}"
                                target="_blank"
                                class="text-decoration-none text-white footer-link-hover">
                                    <i class="fas fa-shield-alt me-2"></i>{{ __('messages.vcard.privacy_policy') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('whatsapp.store.show-refund-cancellation', $whatsappStore->url_alias) }}"
                                target="_blank"
                                class="text-decoration-none text-white footer-link-hover">
                                    <i class="fas fa-undo-alt me-2"></i>{{ __('messages.vcard.refund_cancellation_policy') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('whatsapp.store.show-shipping-delivery', $whatsappStore->url_alias) }}"
                                target="_blank"
                                class="text-decoration-none text-white footer-link-hover">
                                    <i class="fas fa-shipping-fast me-2"></i>{{ __('messages.vcard.shipping_delivery_policy') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <div class="fw-5 fs-16">
                            <h5 class="fw-bold text-white mb-3">
                                <i class="fas fa-comments me-2 text-white"></i>{{ __('messages.whatsapp_stores.talk_to_us') }}
                            </h5>
                            <div class="mb-2">
                                <i class="fas fa-map-marker-alt"></i> {{ $whatsappStore->address }}
                            </div>
                            <div>
                                <i class="fa-solid fa-phone"></i> +{{ $whatsappStore->region_code }} {{ $whatsappStore->whatsapp_no }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
<script>
    @if ($whatsappStore->custom_js)
        {!! $whatsappStore->custom_js !!}
    @endif
</script>
<script>
    let vcardAlias = "{{ $whatsappStore->url_alias }}";
    let languageChange = "{{ url('whatsapp-stores/language') }}";
    let lang = "{{ checkLanguageSession($whatsappStore->url_alias) }}";
    let userlanguage = "{{ getLanguage($whatsappStore->default_language) }}"
    let isRtl = "{{ getLocalLanguage() == 'ar' || getLocalLanguage() == 'fa' ? 'true' : 'false' }}" === "true";
</script>
<script>
    let templateName = "ecommerce";
</script>
<script src="{{ asset('messages.js?$mixID') }}"></script>
<script src="{{ asset('assets/js/intl-tel-input/build/intlTelInput.js') }}"></script>
<script src="{{ asset('assets/js/vcard11/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party-vcard11.js') }}"></script>
<script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/js/whatsapp_store_template.js') }}"></script>
<script>
    let defaultCountryCodeValue = "{{ getSuperAdminSettingValue('default_country_code') }}"
</script>
<script>
    const getCookieUrl = "{{ route('whatsapp.store.getCookie') }}";
    const emailSubscriptionUrl = "{{ route('whatsapp.store.emailSubscriprion-store', ['alias' => $whatsappStore->url_alias]) }}";
</script>
</html>
