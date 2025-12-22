<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" href="{{ $whatsappStore->logo_url }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.whatsapp_stores_templates.product_listing') }} | {{ $whatsappStore->store_name }}</title>
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/travel.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/custom.css') }}" />
    @if ($whatsappStore->font_family || $whatsappStore->font_size || $whatsappStore->custom_css)
        <style>
            @if ($whatsappStore->font_family)
                body {
                    font-family: {{ $whatsappStore->font_family }};
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
    @livewireStyles
  </head>
  <body>
    <div class="main-content" @if (getLanguage($whatsappStore->default_language) == 'Arabic' || getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid bg-white flex-nowrap">
                <div class="d-flex align-items-center">
                    <a class="navbar-brand" href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
                        <img
                            src="{{ $whatsappStore->logo_url }}"
                            alt="logo"
                            class="w-100 h-100 object-fit-cover"
                        />
                    </a>
                    <a class="text-decoration-none" href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
                        <span class="fs-18 fw-bold primary-text text-uppercase d-none d-sm-block">
                            {{ $whatsappStore->store_name }}
                        </span>
                    </a>
                </div>
                <div class="d-flex align-items-center">
                    <div class="language-dropdown position-relative d-flex align-items-center">
                        <button
                            class="dropdown-btn position-relative bg-transparent border-0 ps-0 primary-text d-flex align-items-center"
                            id="dropdownMenuButton"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            @if (array_key_exists(checkLanguageSession($whatsappStore->url_alias), \App\Models\User::FLAG))
                                <img
                                    src="{{ asset(\App\Models\User::FLAG[getLanguageIsoCode($whatsappStore->default_language) ?? 'en']) }}"
                                    class="flag"
                                    alt="flag"
                                />
                            @endif
                            {{ strtoupper(getLanguageIsoCode($whatsappStore->default_language) ?? 'en') }}
                        </button>
                        <svg
                            width="14"
                            height="10"
                            viewBox="0 0 18 10"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M0.662858 0.365983C0.428519 0.600393 0.296875 0.918278 0.296875 1.24973C0.296875 1.58119 0.428519 1.89907 0.662858 2.13348L8.16286 9.63348C8.39727 9.86782 8.71515 9.99947 9.04661 9.99947C9.37806 9.99947 9.69595 9.86782 9.93036 9.63348L17.4304 2.13348C17.6581 1.89773 17.7841 1.58198 17.7812 1.25423C17.7784 0.926486 17.6469 0.61297 17.4151 0.38121C17.1834 0.14945 16.8699 0.0179888 16.5421 0.0151408C16.2144 0.0122927 15.8986 0.138286 15.6629 0.365983L9.04661 6.98223L2.43036 0.365983C2.19595 0.131644 1.87806 0 1.54661 0C1.21515 0 0.897268 0.131644 0.662858 0.365983Z"
                                fill="#DC834E"
                            />
                        </svg>

                        <ul
                            class="dropdown-menu w-100 p-0"
                            aria-labelledby="dropdownMenuButton"
                        >
                            @foreach (getAllLanguageWithFullData() as $language)
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="javascript:void(0)"
                                        id="languageName"
                                        data-name="{{ $language->iso_code }}"
                                    >
                                        @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                            <img
                                                class="flag"
                                                alt="flag"
                                                src="{{ asset(\App\Models\User::FLAG[$language->iso_code]) }}"
                                                loading="lazy"
                                            />
                                        @else
                                            @if (count($language->media) != 0)
                                                <img src="{{ $language->image_url }}" class="flag" loading="lazy" />
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
                        class="add-to-cart-btn bg-transparent border-0 p-0 d-flex align-items-center justify-content-center position-relative"
                        data-bs-toggle="modal"
                        data-bs-target="#cartModal"
                        id="addToCartViewBtn"
                    >
                        <div class="position-relative">
                            <div
                                class="position-absolute cart-count d-flex align-items-center justify-content-center product-count-badge"
                            >
                                0
                            </div>
                            <svg
                                width="28"
                                height="28"
                                viewBox="0 0 28 36"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M21.1774 9.66634C21.1774 9.99786 21.0457 10.3158 20.8113 10.5502C20.5769 10.7846 20.2589 10.9163 19.9274 10.9163C19.5959 10.9163 19.2779 10.7846 19.0435 10.5502C18.8091 10.3158 18.6774 9.99786 18.6774 9.66634V7.16634C18.6774 5.95077 18.1945 4.78498 17.335 3.92543C16.4754 3.06589 15.3097 2.58301 14.0941 2.58301C12.8785 2.58301 11.7127 3.06589 10.8532 3.92543C9.99363 4.78498 9.51074 5.95077 9.51074 7.16634V9.66634C9.51074 9.99786 9.37905 10.3158 9.14463 10.5502C8.9102 10.7846 8.59226 10.9163 8.26074 10.9163C7.92922 10.9163 7.61128 10.7846 7.37686 10.5502C7.14244 10.3158 7.01074 9.99786 7.01074 9.66634V7.16634C7.01074 5.28772 7.75702 3.48605 9.0854 2.15767C10.4138 0.829285 12.2155 0.0830078 14.0941 0.0830078C15.9727 0.0830078 17.7744 0.829285 19.1027 2.15767C20.4311 3.48605 21.1774 5.28772 21.1774 7.16634V9.66634Z"
                                    fill="#DC834E"
                                />
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M26.3305 11.916L27.6639 31.916C27.6973 32.4282 27.6255 32.9419 27.4527 33.4252C27.2798 33.9085 27.0098 34.3513 26.6591 34.7262C26.3085 35.101 25.8847 35.4 25.4139 35.6047C24.9432 35.8093 24.4355 35.9153 23.9222 35.916H4.26552C3.75207 35.9158 3.24414 35.8101 2.77317 35.6057C2.3022 35.4012 1.87822 35.1022 1.52746 34.7272C1.17671 34.3523 0.906665 33.9093 0.734034 33.4257C0.561403 32.9422 0.489867 32.4283 0.523853 31.916L1.85719 11.916C1.92061 10.9668 2.34239 10.0773 3.03711 9.4274C3.73183 8.77755 4.64757 8.41601 5.59885 8.41602H22.5889C23.5401 8.41601 24.4559 8.77755 25.1506 9.4274C25.8453 10.0773 26.2671 10.9668 26.3305 11.916ZM18.2372 15.796C17.8646 16.5793 17.2775 17.2409 16.5442 17.7041C15.8109 18.1673 14.9612 18.4132 14.0939 18.4132C13.2265 18.4132 12.3769 18.1673 11.6435 17.7041C10.9102 17.2409 10.3232 16.5793 9.95052 15.796C9.88004 15.6477 9.78105 15.5148 9.65919 15.4048C9.53734 15.2947 9.395 15.2098 9.24031 15.1548C9.08563 15.0997 8.92162 15.0757 8.75765 15.0841C8.59368 15.0925 8.43297 15.133 8.28469 15.2035C8.1364 15.274 8.00345 15.373 7.89342 15.4948C7.7834 15.6167 7.69845 15.759 7.64343 15.9137C7.58841 16.0684 7.5644 16.2324 7.57277 16.3964C7.58113 16.5604 7.62171 16.7211 7.69219 16.8693C8.26624 18.0814 9.1726 19.1056 10.3059 19.8228C11.4391 20.5401 12.7527 20.9208 14.0939 20.9208C15.435 20.9208 16.7486 20.5401 17.8818 19.8228C19.0151 19.1056 19.9215 18.0814 20.4955 16.8693C20.566 16.7211 20.6066 16.5604 20.6149 16.3964C20.6233 16.2324 20.5993 16.0684 20.5443 15.9137C20.4893 15.759 20.4043 15.6167 20.2943 15.4948C20.1843 15.373 20.0513 15.274 19.903 15.2035C19.7547 15.133 19.594 15.0925 19.4301 15.0841C19.2661 15.0757 19.1021 15.0997 18.9474 15.1548C18.7927 15.2098 18.6504 15.2947 18.5285 15.4048C18.4067 15.5148 18.3077 15.6477 18.2372 15.796Z"
                                    fill="#DC834E"
                                />
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </nav>
        <section class="banner-section position-relative">
            <div class="banner-section position-relative">
                @if($whatsappStore->slider_video_banner)
                    <div class="banner-slider">
                        <div class="banner-slide video-slide">
                            <div class="banner-video-wrapper">
                                <iframe
                                    src="https://www.youtube.com/embed/{{ YoutubeID($whatsappStore->slider_video_banner) }}?autoplay=1&mute=1&loop=1&playlist={{ YoutubeID($whatsappStore->slider_video_banner) }}&controls=0&modestbranding=1&showinfo=0&rel=0"
                                    class="banner-video w-100 h-100"
                                    frameborder="0"
                                    allow="autoplay; encrypted-media"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <div class="bottom-img">
                                <img
                                  src="{{ asset('assets/img/whatsapp_stores/travel/banner-bottom.png') }}"
                                  alt="img"
                                  class="w-100 h-100 object-fit-cover"
                                />
                            </div>
                        </div>

                        <div class="banner-slide image-slide">
                            <div class="banner-img">
                                <img src="{{ $whatsappStore->cover_url }}"
                                     class="w-100 h-100 object-fit-cover"
                                     alt="banner"
                                     loading="lazy" />
                            </div>
                            <div class="bottom-img">
                                <img
                                  src="{{ asset('assets/img/whatsapp_stores/travel/banner-bottom.png') }}"
                                  alt="img"
                                  class="w-100 h-100 object-fit-cover"
                                />
                            </div>
                        </div>
                    </div>
                @else
                    <div class="banner-img">
                        <img src="{{ $whatsappStore->cover_url }}"
                             class="w-100 h-100 object-fit-cover"
                             alt="banner"
                             loading="lazy" />
                    </div>
                    <div class="bottom-img">
                        <img
                          src="{{ asset('assets/img/whatsapp_stores/travel/banner-bottom.png') }}"
                          alt="img"
                          class="w-100 h-100 object-fit-cover"
                        />
                    </div>
                @endif
            </div>
        </section>
        <div class="product-filter-section px-4 pt-3 mt-1 position-relative">
            <livewire:wp-store-templates-products-list :whatsappStoreId="$whatsappStore->id" />
        </div>

        <div class="bottom-bg-img-product view-more-product">
          <img
            src="{{ asset('assets/img/whatsapp_stores/travel/bg-bottom-img.png') }}"
            alt="img"
            class="w-100 h-100 object-fit-cover"
          />
        </div>
        @include('whatsapp_stores.templates.order_modal')
        @include('whatsapp_stores.templates.travel.cart_modal')

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

@livewireScripts
<script>
    @if ($whatsappStore->custom_js)
        {!! $whatsappStore->custom_js !!}
    @endif
</script>
<script>
    let vcardAlias = "{{ $whatsappStore->url_alias }}";
    let languageChange = "{{ url('whatsapp-stores/language') }}";
    let lang = "{{ checkLanguageSession($whatsappStore->url_alias) }}";
    let userlanguage = "{{ getLanguage($whatsappStore->default_language) }}";
    let isRtl = "{{ getLocalLanguage() == 'ar' || getLocalLanguage() == 'fa' ? 'true' : 'false' }}" === "true";
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
    $(document).ready(function () {
        $('.custom-select-box').click(function () {
            $(this).next('.custom-select-options').toggle();
        });

        $('.custom-select-option').click(function () {
            var selectedValue = $(this).text();
            $('.select-text').text(selectedValue);
            $('.custom-select-options').hide();
        });
        $(document).click(function (event) {
            if (!$(event.target).closest('.custom-select').length) {
                $('.custom-select-options').hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".banner-slider").slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            rtl: isRtl,
            prevArrow: '<button class="slide-banner-arrow prev-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none"><path d="M0 6.99998C0 6.74907 0.0960374 6.49819 0.287709 6.3069L6.32224 0.287199C6.70612 -0.0957328 7.3285 -0.0957328 7.71221 0.287199C8.09593 0.669975 8.09593 1.29071 7.71221 1.67367L2.37252 6.99998L7.71203 12.3263C8.09574 12.7092 8.09574 13.3299 7.71203 13.7127C7.32831 14.0958 6.70593 14.0958 6.32206 13.7127L0.287522 7.69306C0.09582 7.50167 0 7.25079 0 6.99998Z" fill="currentColor" /></svg></button>',
            nextArrow: '<button class="slide-banner-arrow next-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none"><path d="M8 7.00002C8 7.25093 7.90396 7.50181 7.71229 7.6931L1.67776 13.7128C1.29388 14.0957 0.671503 14.0957 0.287787 13.7128C-0.095929 13.33 -0.095929 12.7093 0.287787 12.3263L5.62748 7.00002L0.287973 1.67369C-0.0957425 1.29076 -0.0957425 0.670084 0.287973 0.287339C0.67169 -0.0957785 1.29407 -0.0957785 1.67794 0.287339L7.71248 6.30694C7.90418 6.49833 8 6.74921 8 7.00002Z" fill="currentColor"/></svg></button>',
            responsive: [{
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 1,
                    },
                },
                {
                    breakpoint: 860,
                    settings: {
                        slidesToShow: 1,
                    },
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        dots: false,
                        arrows: true,
                    },
                },
            ],
        });
    });
</script>
<script>
    let templateName = "travel";
</script>
<script>
    let defaultCountryCodeValue = "{{ getSuperAdminSettingValue('default_country_code') }}"
</script>
<script>
    const getCookieUrl = "{{ route('whatsapp.store.getCookie') }}";
    const emailSubscriptionUrl = "{{ route('whatsapp.store.emailSubscriprion-store', ['alias' => $whatsappStore->url_alias]) }}";
</script>
  </body>
</html>
