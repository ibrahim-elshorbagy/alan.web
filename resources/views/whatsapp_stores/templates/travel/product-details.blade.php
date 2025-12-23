<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} | {{ $whatsappStore->store_name }}</title>
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if (checkFeature('custom-fonts') && $whatsappStore->font_family)
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family={{ urlencode($whatsappStore->font_family) }}:wght@400;500;600;700&display=swap{{ in_array($whatsappStore->font_family, ['Tajawal', 'Cairo', 'Amiri', 'Noto Sans Arabic', 'Noto Naskh Arabic', 'Noto Kufi Arabic', 'Scheherazade', 'Lateef', 'Harmattan', 'Reem Kufi', 'Jomhuria', 'Mada', 'Lemonada', 'Zain']) ? '&subset=arabic' : '' }}">
    @endif
    <link rel="icon" href="{{ $whatsappStore->logo_url }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/travel.css') }}" />
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
    <div class="main-content" @if (getLanguage($whatsappStore->default_language) == 'Arabic' || getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
        <nav class="navbar navbar-expand-lg position-static">
            <div class="container-fluid bg-white flex-nowrap custom-card">
                <div class="d-flex align-items-center">
                    <a class="navbar-brand" href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
                        <img
                            src="{{ $whatsappStore->logo_url }}"
                            alt="logo"
                            class="w-100 h-100 object-fit-cover"
                        />
                    </a>
                    <span class="d-none d-sm-block">
                        <a
                            href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}" class="text-decoration-none primary-text fs-18 fw-bold primary-text text-uppercase">{{ $whatsappStore->store_name }}</a>
                    </span>
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

        <section class="product-detail-section item-details-section">
            <div class="item-details-card">
            <div class="product-slider">
                @foreach ($product->images_url as $image)
                    <div>
                        <div class="slide-img details-img">
                            <img src="{{ $image }}" alt="image" class="w-100 h-100 object-fit-cover" />
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex align-items-center title flex-column flex-md-row details mt-3">
                <input type="hidden" value="{{ $product->available_stock }}" class="available-stock">
                <input type="hidden" value="{{ $product->category->name }}" class="product-category">
                <input type="hidden" value="{{ $product->images_url[0] }}" class="product-image">

                <div class="pb-4 pb-md-0 flex-grow-1">
                    <h4 class="text-black product-name">{{ $product->name }}</h4>
                    <p class="text-gray fs-18 font-normal">
                        <span class="product-category">{{ $product->category->name }}</span>
                    </p>
                    <div>
                    <p class="fs-28 fw-5 mt-2 d-flex align-items-center flex-wrap gap-2">
                        @if ($product->net_price)
                            <span class="fs-14 fw-semibold">
                                <del class="fs-18 fw-5 text-gray pe-2">{{ currencyFormat($product->net_price, 2, $product->currency->currency_code) }}</del>
                            </span>
                        @endif
                        <span class="badge rounded-pill px-3 py-2 fs-16" style="background-color: #faeee6; color: #dc834e; border: 1px solid #dc834e;">
                            <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                        </span>
                        @if ($product->available_stock == 0)
                            <span class="badge badge-danger bg-danger text-sm out-of-stock-text">{{ __('messages.whatsapp_stores.out_of_stock') }}</span>
                        @endif
                    </p>
                    </div>
                </div>
                @if ($product->available_stock != 0)
                    <div class="d-flex justify-content-end">
                        <div class="button-primary-small">
                            <button class="addToCartBtn" data-id="{{ $product->id }}">{{ __('messages.whatsapp_stores_templates.book_now') }}</button>
                        </div>
                    </div>
                @endif
            </div>

            </div>
        </section>

        <section class="product-description">
          <div>
            <div class="d-flex flex-column gap-20 mb-4 pb-1">
              <h5 class="fs-20 fw-semibold leading-104 text-black">{{ __('messages.whatsapp_stores_templates.description') }}</h5>
                  <p class="fw-5 fs-18 mb-20 text-gray-200">
                      {!! $product->description !!}
                  </p>
          </div>
        </section>

        <section class="product-section position-relative">
            <h2 class="font-aclonica text-center">
                <span class="font-dancing">{{ __('messages.whatsapp_stores_templates.recommended') }} </span> <br />{{ __('messages.whatsapp_stores.package') }}
            </h2>
            <div class="plane-img position-absolute start-0">
                <img src="{{ asset('assets/img/whatsapp_stores/travel/plane.png') }}" alt="img" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="product-main-cards">
                <div class="recommanded-slider">
                    @foreach ($whatsappStore->products as $index => $product)
                        @php
                            $cardClass = 'product-card-' . (($index % 5) + 1);
                        @endphp
                        <div>
                            <div class="product-card {{ $cardClass }}">
                                <div class="product-img">
                                    <img src="{{ $product->images_url[0] ?? '' }}" alt="img" class="w-100 h-100 object-fit-cover" />
                                    <div class="hover-explore d-flex align-items-center position-absolute top-50 start-50 translate-middle">
                                        <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}" class="fs-20 fw-semibold         primary-text">Explore</a>
                                        <span>
                                            <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.5 7H17.4993" stroke="#DC834E" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                                                <path d="M12.5 1L18.4997 6.99973L12.5 13" stroke="#DC834E" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <!-- Hidden inputs for cart functionality -->
                                    <input type="hidden" class="product-category" value="{{ $product->category->name }}" />
                                    <input type="hidden" class="available-stock" value="{{ $product->available_stock }}" />
                                    <input type="hidden" class="product-image" value="{{ $product->images_url[0] ?? '' }}" />

                                    <h6 class="fs-18 fw-medium product-name">{{ $product->name }}</h6>
                                    <div class="d-flex justify-content-between card-title flex-wrap">
                                        <p class="fs-14 fw-medium">{{ $product->category->name }}</p>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 card-title">
                                        @if ($product->net_price)
                                            <span class="fs-14 fw-semibold" style="color: #B1B5C3">
                                                <del>{{ currencyFormat($product->net_price, 2, $product->currency->currency_code) }}</del>
                                            </span>
                                        @endif
                                        <span class="badge rounded-pill px-3 py-2 fs-16" style="background-color: #faeee6; color: #dc834e; border: 1px solid #dc834e;">
                                            <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                                        </span>
                                    </div>
                                    <div class="line"></div>
                                    <div class="card-time button-primary-small">
                                        @if ($product->available_stock > 0)
                                            <button class="d-flex align-items-center justify-content-between addToCartBtn " data-id="{{ $product->id }}">
                                                {{ __('messages.whatsapp_stores_templates.book_now') }}
                                            </button>
                                        @else
                                            <button class="badge bg-danger text-white fs-10 float-end disabled">{{ __('messages.whatsapp_stores.out_of_stock') }}</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
      <div class="bottom-bg-img">
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
<script src="{{ asset('messages.js?$mixID') }}"></script>
<script src="{{ asset('assets/js/intl-tel-input/build/intlTelInput.js') }}"></script>
<script src="{{ asset('assets/js/vcard11/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party-vcard11.js') }}"></script>
<script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/whatsapp_store_template.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>

    <script>
      $(".product-slider").slick({
        dots: false,
        infinite: true,
        prevArrow:
          '<div class="slick-prev"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="20" viewBox="0 0 10 20" fill="none"><path d="M8.01843 19.124L0.253456 10.7018C0.16129 10.6016 0.0961597 10.493 0.0580645 10.376C0.0193548 10.259 0 10.1337 0 10C0 9.86631 0.0193548 9.74098 0.0580645 9.62401C0.0961597 9.50704 0.16129 9.39842 0.253456 9.29815L8.01843 0.850923C8.23349 0.616974 8.50231 0.5 8.82489 0.5C9.14747 0.5 9.42396 0.62533 9.65438 0.875989C9.88479 1.12665 10 1.41909 10 1.7533C10 2.08751 9.88479 2.37995 9.65438 2.63061L2.88018 10L9.65438 17.3694C9.86943 17.6033 9.97696 17.8914 9.97696 18.2337C9.97696 18.5766 9.86175 18.8734 9.63134 19.124C9.40092 19.3747 9.1321 19.5 8.82489 19.5C8.51767 19.5 8.24885 19.3747 8.01843 19.124Z" fill="currentColor"/></svg></div>',
        nextArrow:
          '<div class="slick-next"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="20" viewBox="0 0 10 20" fill="none"><path d="M1.98157 19.124L9.74654 10.7018C9.83871 10.6016 9.90384 10.493 9.94194 10.376C9.98065 10.259 10 10.1337 10 10C10 9.86631 9.98065 9.74098 9.94194 9.62401C9.90384 9.50704 9.83871 9.39842 9.74654 9.29815L1.98157 0.850923C1.76651 0.616974 1.49769 0.5 1.17511 0.5C0.852534 0.5 0.576037 0.62533 0.345622 0.875989C0.115208 1.12665 0 1.41909 0 1.7533C0 2.08751 0.115208 2.37995 0.345622 2.63061L7.11982 10L0.345622 17.3694C0.130569 17.6033 0.0230408 17.8914 0.0230408 18.2337C0.0230408 18.5766 0.138248 18.8734 0.368663 19.124C0.599078 19.3747 0.867895 19.5 1.17511 19.5C1.48233 19.5 1.75115 19.3747 1.98157 19.124Z" fill="currentColor"/></svg></div>',
        slidesToShow: 1,
        centerMode: true,
        centerPadding: "380px",
        slidesToScroll: 1,
        arrows: true,
        rtl: isRtl,
        autoplay: true,
        responsive: [
          {
            breakpoint: 1199,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              centerPadding: "300px",
              centerMode: true,
            },
          },
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              centerPadding: "150px",
              centerMode: true,
            },
          },
          {
            breakpoint: 767,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              centerPadding: "100px",
              centerMode: true,
            },
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              centerPadding: "40px",
              centerMode: true,
            },
          },
        ],
      });
    </script>

<script>
    $(".recommanded-slider").slick({
      dots: false,
      infinite: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: false,
      autoplay: true,
      rtl: isRtl,
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

  </body>
</html>
