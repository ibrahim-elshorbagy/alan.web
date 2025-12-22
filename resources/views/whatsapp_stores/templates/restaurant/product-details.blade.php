<!DOCTYPE html>
<html lang="en" dir="{{ getLocalLanguage() == 'ar' || getLocalLanguage() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} | {{ $whatsappStore->store_name }}</title>
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ $whatsappStore->logo_url }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/restaurant.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/third-party.css') }}">
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
</head>

<body>
    <div class="main-content mx-auto w-100 d-flex flex-column justify-content-between position-relative">
        <div>
            <div class="position-absolute vector-3 vector">
                <img src="{{ asset('assets/img/whatsapp_stores/restaurant/vector-3.png') }}" alt="images" />
            </div>
            <div class="position-absolute vector-2-product-detail text-end vector">
                <img src="{{ asset('assets/img/whatsapp_stores/restaurant/vector-2.png') }}" alt="images" />
            </div>
            <div class="px-50 header  position-relative top-0 z-3">
                <nav class="navbar navbar-expand-lg w-100" id="header">
                    <div class="container-fluid p-0">
                        <div class="d-flex align-items-center gap-2 gap-sm-3">
                            <a class="navbar-brand p-0 m-0"
                                href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
                                <img src="{{ $whatsappStore->logo_url }}" alt="logo"
                                    class="w-100 h-100 object-fit-cover" loading="lazy" />
                            </a>
                            <span class="fw-semibold fs-18 text-white"><a
                                    href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}"
                                    style="color: #FFFFFF ">{{ $whatsappStore->store_name }}</a></span>
                        </div>

                        <div class="d-flex align-items-center gap-lg-4 gap-sm-3 gap-2">
                            <div class="language-dropdown position-relative">
                                <button class="dropdown-btn position-relative text-white" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (array_key_exists(checkLanguageSession($whatsappStore->url_alias), \App\Models\User::FLAG))
                                        <img class="flag" alt="flag"
                                            src="{{ asset(\App\Models\User::FLAG[getLanguageIsoCode($whatsappStore->default_language) ?? 'en']) }}"
                                            loading="lazy" />
                                    @endif
                                    {{ strtoupper(getLanguageIsoCode($whatsappStore->default_language) ?? 'en') }}
                                </button>
                                <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="14"
                                    height="8" viewBox="0 0 18 10" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.615983 0.366227C0.381644 0.600637 0.25 0.918522 0.25 1.24998C0.25 1.58143 0.381644 1.89932 0.615983 2.13373L8.11598 9.63373C8.35039 9.86807 8.66828 9.99971 8.99973 9.99971C9.33119 9.99971 9.64907 9.86807 9.88348 9.63373L17.3835 2.13373C17.6112 1.89797 17.7372 1.58222 17.7343 1.25448C17.7315 0.92673 17.6 0.613214 17.3683 0.381454C17.1365 0.149694 16.823 0.0182329 16.4952 0.0153849C16.1675 0.0125369 15.8517 0.13853 15.616 0.366227L8.99973 6.98248L2.38348 0.366227C2.14907 0.131889 1.83119 0.000244141 1.49973 0.000244141C1.16828 0.000244141 0.850393 0.131889 0.615983 0.366227Z"
                                        fill="white" />
                                </svg>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach (getAllLanguageWithFullData() as $language)
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" id="languageName"
                                                data-name="{{ $language->iso_code }}">

                                                @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                                    <img class="flag" alt="flag"
                                                        src="{{ asset(\App\Models\User::FLAG[$language->iso_code]) }}"
                                                        loading="lazy" />
                                                @else
                                                    @if (count($language->media) != 0)
                                                        <img src="{{ $language->image_url }}" class="me-1"
                                                            loading="lazy" loading="lazy" />
                                                    @else
                                                        <i class="fa fa-flag fa-xl me-3 text-danger"
                                                            aria-hidden="true"></i>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="41" height="40"
                                    viewBox="0 0 41 40" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M27.1301 11.6667C27.1301 11.9982 26.9984 12.3161 26.764 12.5505C26.5296 12.785 26.2116 12.9167 25.8801 12.9167C25.5486 12.9167 25.2306 12.785 24.9962 12.5505C24.7618 12.3161 24.6301 11.9982 24.6301 11.6667V9.16666C24.6301 7.95109 24.1472 6.7853 23.2877 5.92576C22.4281 5.06621 21.2623 4.58333 20.0468 4.58333C18.8312 4.58333 17.6654 5.06621 16.8059 5.92576C15.9463 6.7853 15.4634 7.95109 15.4634 9.16666V11.6667C15.4634 11.9982 15.3317 12.3161 15.0973 12.5505C14.8629 12.785 14.545 12.9167 14.2134 12.9167C13.8819 12.9167 13.564 12.785 13.3296 12.5505C13.0951 12.3161 12.9634 11.9982 12.9634 11.6667V9.16666C12.9634 7.28804 13.7097 5.48637 15.0381 4.15799C16.3665 2.82961 18.1682 2.08333 20.0468 2.08333C21.9254 2.08333 23.7271 2.82961 25.0554 4.15799C26.3838 5.48637 27.1301 7.28804 27.1301 9.16666V11.6667Z"
                                        fill="white" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M32.2835 13.9167L33.6168 33.9167C33.6503 34.4289 33.5784 34.9425 33.4056 35.4258C33.2328 35.9092 32.9627 36.352 32.6121 36.7268C32.2614 37.1017 31.8376 37.4007 31.3669 37.6053C30.8961 37.81 30.3884 37.9159 29.8751 37.9167H10.2185C9.70502 37.9164 9.19708 37.8108 8.72611 37.6063C8.25514 37.4018 7.83116 37.1028 7.48041 36.7279C7.12966 36.3529 6.85961 35.9099 6.68698 35.4264C6.51435 34.9428 6.44281 34.429 6.4768 33.9167L7.81013 13.9167C7.87355 12.9675 8.29533 12.0779 8.99005 11.428C9.68477 10.7782 10.6005 10.4167 11.5518 10.4167H28.5418C29.4931 10.4167 30.4088 10.7782 31.1035 11.428C31.7983 12.0779 32.22 12.9675 32.2835 13.9167ZM24.1901 17.7967C23.8175 18.5799 23.2305 19.2415 22.4971 19.7047C21.7638 20.1679 20.9142 20.4138 20.0468 20.4138C19.1794 20.4138 18.3298 20.1679 17.5965 19.7047C16.8631 19.2415 16.2761 18.5799 15.9035 17.7967C15.833 17.6484 15.734 17.5154 15.6121 17.4054C15.4903 17.2954 15.3479 17.2104 15.1933 17.1554C15.0386 17.1004 14.8746 17.0764 14.7106 17.0847C14.5466 17.0931 14.3859 17.1337 14.2376 17.2042C14.0893 17.2746 13.9564 17.3736 13.8464 17.4955C13.7363 17.6173 13.6514 17.7597 13.5964 17.9144C13.5414 18.069 13.5173 18.2331 13.5257 18.397C13.5341 18.561 13.5747 18.7217 13.6451 18.87C14.2192 20.0821 15.1255 21.1063 16.2588 21.8235C17.3921 22.5407 18.7056 22.9214 20.0468 22.9214C21.3879 22.9214 22.7015 22.5407 23.8348 21.8235C24.9681 21.1063 25.8744 20.0821 26.4485 18.87C26.5189 18.7217 26.5595 18.561 26.5679 18.397C26.5762 18.2331 26.5522 18.069 26.4972 17.9144C26.4422 17.7597 26.3573 17.6173 26.2472 17.4955C26.1372 17.3736 26.0042 17.2746 25.856 17.2042C25.7077 17.1337 25.547 17.0931 25.383 17.0847C25.219 17.0764 25.055 17.1004 24.9003 17.1554C24.7456 17.2104 24.6033 17.2954 24.4815 17.4054C24.3596 17.5154 24.2606 17.6484 24.1901 17.7967Z"
                                        fill="white" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="item-details-section px-50 mb-30">
                <div class="item-details-card overflow-hidden position-relative">
                    <div class="row row-gap-30px">
                        <div class="col-xl-5 col-lg-6">
                            <div class="slider-for mb-15px">
                                @foreach ($product->images_url as $image)
                                    <div>
                                        <div class="details-img h-100 w-100 mx-auto">
                                            <img src="{{ $image }}" alt="items"
                                                class="w-100 h-100 object-fit-cover" loading="lazy" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="slider-nav">
                                @foreach ($product->images_url as $image)
                                    <div>
                                        <div class="thumbnail-img h-100 w-100 mx-auto position-relative">
                                            <img src="{{ $image }}" alt="items"
                                                class="w-100 h-100 object-fit-cover" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6">
                            <div class="product-detail-content d-flex h-100 justify-content-between flex-column" >
                                <div>
                                    <div class="d-flex align-items-center gap-20px mb-10">
                                        <p class="fs-24 text-white fw-semibold mb-0 product-name">{{ $product->name }}</p>
                                        <input type="hidden" value="{{ $product->available_stock }}"
                                            class="available-stock">
                                        <input type="hidden" value="{{ $product->category->name }}"
                                            class="product-category">
                                        <input type="hidden" value="{{ $product->images_url[0] ?? '' }}"
                                            class="product-image">
                                    </div>
                                    <p class="text-primary fs-28 fw-semibold mb-10">
                                        <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                                        @if ($product->available_stock == 0)
                                            <span class="badge badge-danger bg-danger text-sm out-of-stock-text mt-0 ms-2">{{ __('messages.whatsapp_stores.out_of_stock') }}</span>
                                        @endif
                                    </p>
                                    <p class="fs-20 fw-6 text-gray-200 mb-3">
                                        {{ __('messages.whatsapp_stores_templates.description') }} :</p>
                                    <p class="fs-16 text-white fw-normal mb-20 ">{!! $product->description !!}</p>
                                </div>
                                <div>
                                    @if ($product->available_stock != 0)
                                        <button class="btn btn-primary add-to-cart-items addToCartBtn"
                                            data-id="{{ $product->id }}">{{ __('messages.whatsapp_stores_templates.add_to_cart') }}</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="recommended-product-section px-50 position-relative">
                <div class="text-center">
                    <h2
                        class="text-center text-white fs-28 fw-semibold mb-40 section-heading position-relative d-inline-block">
                        {{ __('messages.whatsapp_stores_templates.recommended_items') }}</h2>
                    </h2>
                </div>
                <div class="product-slider">
                    @foreach ($whatsappStore->products as $product)
                        <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}"
                            class="d-block h-100" style="color: #FFFFFF;">
                            <div>
                                <div class="product-card">
                                    <div class="product-img mx-auto h-100 w-100">
                                        <img src="{{ $product->images_url[0] ?? '' }}" alt="item"
                                            class="w-100 h-100 object-fit-cover" />
                                    </div>
                                    <div class="product-details">
                                        <h5 class="fs-20 fw-normal text-white mb-0 text-center product-name">{{ $product->name }}
                                        </h5>
                                        <p class="fs-24 fw-semibold mb-0 text-primary text-center">
                                            {{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @include('whatsapp_stores.templates.order_modal')
        @include('whatsapp_stores.templates.restaurant.cart_modal')
        <footer class="position-relative">
            <div class="container pt-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <img src="{{ $whatsappStore->logo_url }}" alt="logo" style="width: 50px !important; height: 50px !important;">
                        </div>
                        <div class="text-white">
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
                            <div class="mb-2 text-white">
                                <i class="fas fa-map-marker-alt"></i> {{ $whatsappStore->address }}
                            </div>
                            <div class="text-white">
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
</script>
<script>
    let templateName = "jewellery";
</script>
<script src="{{ asset('messages.js?$mixID') }}"></script>
<script src="{{ asset('assets/js/intl-tel-input/build/intlTelInput.js') }}"></script>
<script src="{{ asset('assets/js/vcard11/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party-vcard11.js') }}"></script>
<script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/whatsapp_store_template.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $(".product-slider").slick({
            infinite: true,
            slidesToShow: 4,
            rtl: isRtl,
            slidesToScroll: 1,
            autoplay: true,
            arrows: false,
            responsive: [{
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 860,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        dots: false,
                        arrows: false,
                    },
                },
            ],
        });
    });
    $(document).ready(function() {
        $(".slider-for").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            dots: false,
            rtl: isRtl,
            asNavFor: ".slider-nav",
        });
        $(".slider-nav").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: ".slider-for",
            dots: false,
            rtl: isRtl,
            arrows: false,
            focusOnSelect: true,
            responsive: [{
                    breakpoint: 1129,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 5,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4,
                    },
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 4,
                        vertical: false,
                        dots: true,
                    },
                },
                {
                    breakpoint: 460,
                    settings: {
                        slidesToShow: 3,
                        vertical: false,
                        dots: true,
                    },
                },
            ],
        });
    });
</script>
<script>
    let defaultCountryCodeValue = "{{ getSuperAdminSettingValue('default_country_code') }}"
</script>
<script>
$(document).ready(function() {
    function addAdvancedCursorZoom(selector, zoomLevel = 2) {
        $(selector).each(function() {
            const $img = $(this);
            const $container = $img.parent();
            let isZoomed = false;

            $container.addClass('zoom-container');
            $img.addClass('zoomable-image');

            $container.on('mouseenter', function(e) {
                isZoomed = true;
                $img.css({
                    'transform': `scale(${zoomLevel})`,
                    'transition': 'transform 0.3s ease'
                });
                updateTransformOrigin(e);
            });

            $container.on('mouseleave', function() {
                isZoomed = false;
                $img.css({
                    'transform': 'scale(1)',
                    'transform-origin': 'center center',
                    'transition': 'transform 0.3s ease, transform-origin 0.1s ease'
                });
            });

            $container.on('mousemove', function(e) {
                if (isZoomed) {
                    updateTransformOrigin(e);
                }
            });

            function updateTransformOrigin(e) {
                const rect = $container[0].getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;

                $img.css({
                    'transform-origin': `${x}% ${y}%`,
                    'transition': 'transform 0.3s ease, transform-origin 0.1s ease'
                });
            }
        });
    }

    addAdvancedCursorZoom('.details-img img', 2.8);
    addAdvancedCursorZoom('.product-img img', 2.2);
    addAdvancedCursorZoom('.thumbnail-img img', 2);
});
</script>
</html>
