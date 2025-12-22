<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} | {{ $whatsappStore->store_name }}</title>
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ $whatsappStore->logo_url }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/jewellery.css') }}" />
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
    <div class="main-content mx-auto w-100 overflow-hidden d-flex flex-column justify-content-between"
        @if (getLanguage($whatsappStore->default_language) == 'Arabic' || getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
        <div>
            <nav class="navbar navbar-expand-lg px-50 position-relative">
                <div class="container-fluid header">
                    <div class="d-flex align-items-center gap-3">
                        <a class="navbar-brand m-0" href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
                            <img src="{{ $whatsappStore->logo_url }}" alt="logo" class="w-100 h-100 object-fit-cover" />
                        </a>
                        <span class="fw-bold fs-18 d-sm-block d-none"><a
                            href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}"
                            style="color: #212529">{{ $whatsappStore->store_name }}</a></span>
                    </div>
                    <div class="d-flex align-items-center gap-lg-4 gap-sm-3 gap-2">
                        <div class="language-dropdown position-relative">
                            <button class="dropdown-btn position-relative" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if (array_key_exists(checkLanguageSession($whatsappStore->url_alias), \App\Models\User::FLAG))
                                    <img src="{{ asset(\App\Models\User::FLAG[getLanguageIsoCode($whatsappStore->default_language) ?? 'en']) }}"
                                         class="flag" alt="flag" loading="lazy" />
                                @endif
                                {{ strtoupper(getLanguageIsoCode($whatsappStore->default_language) ?? 'en') }}
                            </button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" class="dropdown-arrow" height="26"
                                viewBox="0 0 25 26" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.97382 9.28803C5.78611 9.47579 5.68066 9.73042 5.68066 9.99591C5.68066 10.2614 5.78611 10.516 5.97382 10.7038L11.9813 16.7113C12.1691 16.899 12.4237 17.0045 12.6892 17.0045C12.9547 17.0045 13.2093 16.899 13.3971 16.7113L19.4046 10.7038C19.587 10.515 19.6879 10.262 19.6856 9.99952C19.6834 9.73699 19.5781 9.48586 19.3924 9.30022C19.2068 9.11458 18.9557 9.00928 18.6931 9.007C18.4306 9.00472 18.1777 9.10564 17.9888 9.28803L12.6892 14.5877L7.38959 9.28803C7.20183 9.10032 6.9472 8.99487 6.6817 8.99487C6.41621 8.99487 6.16158 9.10032 5.97382 9.28803Z"
                                    fill="black" />
                            </svg>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
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
                                                    <img src="{{ $language->image_url }}" class="flag"
                                                        loading="lazy" />
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
                        <button class="add-to-cart-btn d-flex align-items-center justify-content-center position-relative"
                            id="addToCartViewBtn">
                            <div class="position-absolute cart-count d-flex align-items-center justify-content-center count-product product-count-badge badge rounded-pill bg-danger">
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="40" viewBox="0 0 41 40"
                                fill="none">
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
            <div class="item-details-section px-50 mb-30 position-relative">
                <div class="item-details-card">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 mb-lg-0 mb-40">
                            <div class="slider-for mb-20">
                                @foreach ($product->images_url as $image)
                                    <div>
                                        <div class="details-img">
                                            <img src="{{ $image }}" alt="items"
                                                class="w-100 h-100 object-fit-cover" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="slider-nav">
                                @foreach ($product->images_url as $image)
                                    <div>
                                        <div class="thumbnail-img">
                                            <img src="{{ $image }}" alt="items"
                                                class="w-100 h-100 object-fit-cover" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6">
                            <div class="details d-flex flex-column justify-content-between h-100">
                                <div>
                                    <h4 class="fs-28 mb-20 product-name">{{ $product->name }}</h4>

                                    <input type="hidden" value="{{ $product->available_stock }}" class="available-stock">
                                    <input type="hidden" value="{{ $product->category->name }}" class="product-category">
                                    <input type="hidden" value="{{ $product->images_url[0] }}" class="product-image">

                                    <p class="fs-28 fw-5 mb-30">
                                        @if ($product->net_price)
                                            <del class="fs-18 fw-5 text-gray-200 pe-2">{{ $product->currency->currency_icon }}{{ $product->net_price }}</del>
                                        @endif
                                        <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                                        @if ($product->available_stock == 0)
                                            <span class="badge badge-danger bg-danger text-sm out-of-stock-text ms-2">{{ __('messages.whatsapp_stores.out_of_stock') }}</span>
                                        @endif
                                    </p>

                                    <p class="fs-28 text-gray-200 mb-10 lh-sm">
                                        {{ __('messages.whatsapp_stores_templates.description') }}</p>
                                    <p class="fw-5 fs-18 mb-20 text-gray-200">
                                        {!! $product->description !!}
                                    </p>

                                </div>

                                @if ($product->available_stock != 0)
                                    <div class="d-flex gap-2 align-items-center flex-wrap flex-sm-nowrap">
                                        <button class="btn add-to-cart px-2 d-flex align-items-center justify-content-center gap-20 fs-20 fw-5 position-relative addToCartBtn" data-id="{{ $product->id }}">
                                            {{ __('messages.whatsapp_stores_templates.add_to_cart') }}
                                            <span class="arrow-view d-flex justify-content-center align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16"
                                                    viewBox="0 0 24 18" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M12.1844 0.475262C12.304 0.337965 12.4495 0.225601 12.6126 0.144599C12.7757 0.063596 12.9532 0.0155439 13.1349 0.00319103C13.3166 -0.00916181 13.4989 0.0144274 13.6715 0.0726083C13.8441 0.130789 14.0035 0.22242 14.1406 0.342261L22.6157 7.7312C22.7646 7.86124 22.884 8.02166 22.9659 8.20168C23.0477 8.3817 23.09 8.57714 23.09 8.77488C23.09 8.97262 23.0477 9.16807 22.9659 9.34809C22.884 9.52811 22.7646 9.68853 22.6157 9.81857L14.1406 17.2075C14.0042 17.3314 13.8444 17.4269 13.6707 17.4883C13.497 17.5497 13.3127 17.5758 13.1288 17.5652C12.9448 17.5545 12.7648 17.5072 12.5993 17.4262C12.4339 17.3451 12.2862 17.2318 12.1651 17.0929C12.0439 16.9541 11.9517 16.7925 11.8938 16.6175C11.8358 16.4426 11.8134 16.2579 11.8277 16.0742C11.8421 15.8904 11.893 15.7114 11.9773 15.5476C12.0617 15.3838 12.178 15.2385 12.3192 15.1201L18.0087 10.1603H1.38543C1.01799 10.1603 0.665599 10.0143 0.405782 9.75452C0.145964 9.49471 0 9.14232 0 8.77488C0 8.40744 0.145964 8.05506 0.405782 7.79524C0.665599 7.53542 1.01799 7.38946 1.38543 7.38946H18.0068L12.3174 2.42963C12.0406 2.18806 11.8711 1.84648 11.8462 1.47999C11.8213 1.11349 11.9429 0.752096 12.1844 0.475262Z"
                                                        fill="#AE937D" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="recommended-product-section px-50 position-relative">
                <div class="section-heading mb-30">
                    <h2 class="mb-0 text-center">{{ __('messages.whatsapp_stores_templates.recommended_products') }}</h2>
                </div>
                <div class="product-slider">
                    @foreach ($whatsappStore->products as $index => $product)
                        @php
                            $cardClass = 'product-card-' . (($index % 5) + 1);
                        @endphp
                        <div>
                            <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}" class="product-card h-100 d-flex flex-column {{ $cardClass }}">
                                <div class="product-img w-100 h-100 d-flex justify-content-center align-items-center mx-auto">
                                    <img src="{{ $product->images_url[0] ?? '' }}" alt="images"
                                        class="h-100 w-100 object-fit-cover product-image" />
                                </div>
                                <div class="product-desc">
                                    <input type="hidden" class="product-category" value="{{ $product->category->name }}" />
                                    <p class="fs-20 text-black fw-normal mb-10 product-name">{{ $product->name }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="fs-22 text-black fw-6 mb-0">
                                            <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                                            @if ($product->net_price)
                                                <del class="fs-14 fw-5 text-gray-200 ms-2">{{ $product->currency->currency_icon }}{{ $product->net_price }}</del>
                                            @endif
                                        </h4>
                                        @if ($product->available_stock > 0)
                                            <button class="cart-btn d-flex justify-content-center align-items-center addToCartBtn" data-id="{{ $product->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.7103 6.00002H21.2921L19.8081 15H7.19428L5.7103 6.00002Z"
                                                        stroke="white" stroke-width="1.48438" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9 20C9.55228 20 10 19.5523 10 19C10 18.4477 9.55228 18 9 18C8.44772 18 8 18.4477 8 19C8 19.5523 8.44772 20 9 20Z"
                                                        stroke="white" stroke-width="1.48438" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M18 20C18.5523 20 19 19.5523 19 19C19 18.4477 18.5523 18 18 18C17.4477 18 17 18.4477 17 19C17 19.5523 17.4477 20 18 20Z"
                                                        stroke="white" stroke-width="1.48438" />
                                                    <path d="M7 6H3" stroke="white" stroke-width="1.48438"
                                                        stroke-linecap="round" />
                                                </svg>
                                            </button>
                                        @else
                                            <span class="badge bg-danger text-white">{{ __('messages.whatsapp_stores.out_of_stock') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @include('whatsapp_stores.templates.order_modal')
        @include('whatsapp_stores.templates.jewellery.cart_modal')
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
        <div class="position-absolute items-detials-vector-1 vector-all text-center">
            <img src="{{ asset('assets/img/whatsapp_stores/jewellery/product-items-details-vector-1.png') }}" alt="imagees" />
        </div>
        <div class="position-absolute items-detials-vector-1 vector-all text-center">
            <img src="{{ asset('assets/img/whatsapp_stores/jewellery/product-items-details-vector-2.png') }}" alt="imagees" />
        </div>
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
    $(document).ready(function () {
        $(".product-slider").slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            arrows: false,
            rtl:isRtl,
            responsive: [
                {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        dots: false,
                    },
                },
            ],
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".slider-for").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: ".slider-nav",
        });
        $(".slider-nav").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: ".slider-for",
            dots: false,
            arrows: false,
            focusOnSelect: true,
            responsive: [
                {
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
                        slidesToShow: 3,
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
    const getCookieUrl = "{{ route('whatsapp.store.getCookie') }}";
    const emailSubscriptionUrl = "{{ route('whatsapp.store.emailSubscriprion-store', ['alias' => $whatsappStore->url_alias]) }}";
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
