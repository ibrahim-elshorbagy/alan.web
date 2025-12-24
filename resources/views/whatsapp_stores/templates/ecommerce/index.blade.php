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
                        </div>

                        <div class="banner-slide image-slide">
                            <div class="banner-img">
                                <img src="{{ $whatsappStore->cover_url }}"
                                     class="w-100 h-100 object-fit-cover"
                                     alt="banner"
                                     loading="lazy" />
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
                @endif
            </div>
            <div class="category-section px-50 pt-30 mb-2 pb-1 position-relative">
                <div class="section-heading">
                    <h2 class="position-relative mb-0">
                        {{ __('messages.whatsapp_stores_templates.choos_your_category') }}</h2>
                </div>
                <div class="category-slider">
                    @foreach ($whatsappStore->categories as $category)
                        <a href="{{ route('whatsapp.store.products', ['alias' => $whatsappStore->url_alias, 'category' => $category->id]) }}"
                            style="color: #212529">
                            <div>
                                <div class="category-box bg-white mx-auto">
                                    <div class="category-img h-100 w-100 mb-20 mx-auto">
                                        <img src="{{ $category->image_url }}" alt="images"
                                            class="h-100 w-100 object-fit-cover rounded" loading="lazy" />
                                    </div>
                                    <p class="fs-20 fw-5 text-center lh-sm mb-0 text-black text-break">
                                        {{ $category->name }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    @if ($whatsappStore->categories->count() == 0)
                        <div class="text-center mb-5 mt-3">
                            <h3 class="fs-20 fw-6 mb-0">
                                {{ __('messages.whatsapp_stores_templates.category_not_found') }}</h3>
                        </div>
                    @endif
                </div>
            </div>
            <div class="product-section px-50 position-relative">
                <div class="section-heading">
                    <h2 class="position-relative">{{ __('messages.whatsapp_stores_templates.choose_your_product') }}
                    </h2>
                </div>
                <div class="row mb-20">
                    @foreach ($whatsappStore->products()->latest()->take(8)->get() as $product)
                        <div class="col-xl-3 col-lg-4 col-sm-6 mb-28">
                            <div class="product-card d-flex flex-column h-100">
                                <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}"
                                    class="d-flex text-black flex-column h-100">
                                    <div class="product-img w-100 h-100 mx-auto">
                                        <img src="{{ $product->images_url[0] ?? '' }}" alt="product"
                                            class="w-100 h-100 object-fit-cover product-image" loading="lazy" />
                                    </div>
                                </a>
                                <div class="product-details h-100" style="flex-grow:1;">
                                    <div class="d-flex flex-column h-100 justify-content-between">
                                        <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}"
                                            class="d-flex text-black flex-column h-100">
                                            <div>
                                                <h5 class="fs-24 fw-6 mb-1 product-name">{{ $product->name }}</h5>
                                                <p class="fs-20 fw-5 mb-2 text-gray-200 lh-sm product-category">
                                                    {{ $product->category->name }}
                                                </p>
                                            </div>
                                        </a>
                                        <div class="d-flex gap-2 align-items-center justify-content-between">
                                            <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}"
                                                class="d-flex text-black flex-column h-100">
                                                <p class="fs-30 fw-6 lh-sm mb-0">
                                                    <span class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                                                    @if ($product->net_price)
                                                        <del class="fs-20 fw-5 text-gray-200 text-nowrap">{{ currencyFormat($product->net_price, 2, $product->currency->currency_code) }}</del>
                                                    @endif
                                                </p>
                                                <input type="hidden" value="{{ $product->available_stock }}"
                                                class="available-stock">
                                            </a>
                                            <button data-id="{{ $product->id }}"
                                                class="@if($product->available_stock == 0) disabled @endif btn btn-primary d-flex justify-content-center align-items-center addToCartBtn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    viewBox="0 0 30 30" fill="none">
                                                    <path
                                                        d="M23.6158 19.0898L24.4896 14.3458C24.5087 14.246 24.503 14.1431 24.4731 14.046C24.4432 13.9489 24.39 13.8606 24.3181 13.7888C24.2462 13.7171 24.1578 13.664 24.0606 13.6343C23.9635 13.6046 23.8605 13.5991 23.7608 13.6184C23.3462 13.7058 22.9237 13.7499 22.5 13.75C20.9414 13.75 19.4389 13.1676 18.2875 12.1171C17.136 11.0666 16.4185 9.62377 16.2758 8.07164C16.2626 7.91607 16.1917 7.77107 16.0769 7.66525C15.9621 7.55943 15.8118 7.50047 15.6557 7.5H6.8555L6.76503 7.09289C6.67249 6.67657 6.44076 6.30424 6.10809 6.03737C5.77541 5.7705 5.36169 5.62504 4.9352 5.625H3.15823C2.84686 5.625 2.55835 5.8377 2.50831 6.14502C2.49311 6.23471 2.49765 6.32663 2.52162 6.41438C2.54559 6.50214 2.58842 6.5836 2.64711 6.65311C2.7058 6.72261 2.77894 6.77847 2.86144 6.8168C2.94394 6.85513 3.03381 6.87501 3.12477 6.87504H4.93473C5.0771 6.87439 5.21538 6.92261 5.32647 7.01165C5.43756 7.10069 5.51474 7.22515 5.54511 7.36424L8.93428 22.6162C8.43929 22.7715 8.00475 23.0767 7.69073 23.4897C7.37672 23.9026 7.19874 24.4029 7.18139 24.9214C7.16404 25.4399 7.30818 25.951 7.59389 26.384C7.8796 26.8171 8.29276 27.1506 8.77627 27.3387C9.25978 27.5267 9.78976 27.5599 10.293 27.4337C10.7962 27.3075 11.2477 27.028 11.5852 26.634C11.9227 26.2401 12.1295 25.751 12.177 25.2343C12.2245 24.7177 12.1103 24.1991 11.8503 23.7502H19.7123C19.4374 24.2267 19.3275 24.7805 19.3996 25.3258C19.4716 25.8711 19.7216 26.3774 20.1107 26.7662C20.4998 27.1549 21.0064 27.4044 21.5517 27.4759C22.0971 27.5474 22.6508 27.437 23.127 27.1617C23.6032 26.8864 23.9753 26.4617 24.1855 25.9534C24.3957 25.4451 24.4323 24.8817 24.2896 24.3505C24.147 23.8192 23.833 23.35 23.3964 23.0154C22.9598 22.6808 22.425 22.4996 21.875 22.5H10.189L9.77229 20.625H21.7719C22.2102 20.625 22.6347 20.4714 22.9715 20.191C23.3084 19.9105 23.5363 19.5209 23.6158 19.0898ZM9.68751 25.9375C9.50209 25.9375 9.32083 25.8825 9.16666 25.7795C9.01249 25.6765 8.89233 25.5301 8.82137 25.3588C8.75041 25.1875 8.73185 24.999 8.76802 24.8171C8.80419 24.6353 8.89348 24.4682 9.02459 24.3371C9.15571 24.206 9.32275 24.1167 9.50461 24.0805C9.68647 24.0444 9.87497 24.0629 10.0463 24.1339C10.2176 24.2048 10.364 24.325 10.467 24.4792C10.57 24.6333 10.625 24.8146 10.625 25C10.625 25.2487 10.5262 25.4871 10.3504 25.6629C10.1746 25.8387 9.93615 25.9375 9.68751 25.9375ZM22.8125 25C22.8125 25.1854 22.7575 25.3667 22.6545 25.5209C22.5515 25.675 22.4051 25.7952 22.2338 25.8662C22.0625 25.9371 21.874 25.9557 21.6921 25.9195C21.5103 25.8833 21.3432 25.794 21.2121 25.6629C21.081 25.5318 20.9917 25.3648 20.9555 25.1829C20.9193 25.0011 20.9379 24.8126 21.0089 24.6413C21.0798 24.4699 21.2 24.3235 21.3542 24.2205C21.5083 24.1175 21.6896 24.0625 21.875 24.0625C22.1236 24.0625 22.3621 24.1613 22.5379 24.3371C22.7137 24.5129 22.8125 24.7514 22.8125 25Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M22.5 2.5C21.5111 2.5 20.5444 2.79324 19.7221 3.34265C18.8999 3.89205 18.259 4.67294 17.8806 5.58657C17.5022 6.5002 17.4031 7.50553 17.5961 8.47543C17.789 9.44533 18.2652 10.3362 18.9645 11.0355C19.6637 11.7348 20.5546 12.211 21.5245 12.4039C22.4944 12.5968 23.4998 12.4978 24.4134 12.1194C25.327 11.7409 26.1079 11.1001 26.6573 10.2778C27.2067 9.45558 27.5 8.48888 27.5 7.49998C27.4999 6.17391 26.9732 4.90215 26.0355 3.96448C25.0978 3.0268 23.8261 2.50002 22.5 2.5ZM24.6875 8.125H23.125V9.68752C23.1258 9.7701 23.1102 9.85203 23.0792 9.92856C23.0481 10.0051 23.0022 10.0747 22.9441 10.1334C22.886 10.1921 22.8168 10.2386 22.7406 10.2704C22.6644 10.3022 22.5826 10.3186 22.5 10.3186C22.4174 10.3186 22.3357 10.3022 22.2594 10.2704C22.1832 10.2386 22.114 10.1921 22.0559 10.1334C21.9978 10.0747 21.9519 10.0051 21.9208 9.92856C21.8898 9.85203 21.8742 9.7701 21.875 9.68752V8.125H20.3125C20.2299 8.1258 20.148 8.11022 20.0715 8.07917C19.9949 8.04812 19.9253 8.00221 19.8666 7.9441C19.808 7.88598 19.7614 7.81682 19.7296 7.74059C19.6978 7.66437 19.6814 7.5826 19.6814 7.50001C19.6814 7.41742 19.6978 7.33565 19.7296 7.25943C19.7614 7.1832 19.808 7.11403 19.8666 7.05592C19.9253 6.9978 19.9949 6.9519 20.0715 6.92085C20.148 6.8898 20.2299 6.87422 20.3125 6.87502H21.875V5.3125C21.8742 5.22992 21.8898 5.14799 21.9208 5.07146C21.9519 4.99493 21.9978 4.92532 22.0559 4.86664C22.114 4.80796 22.1832 4.76138 22.2594 4.72959C22.3357 4.6978 22.4174 4.68143 22.5 4.68143C22.5826 4.68143 22.6644 4.6978 22.7406 4.72959C22.8168 4.76138 22.886 4.80796 22.9441 4.86664C23.0022 4.92532 23.0481 4.99493 23.0792 5.07146C23.1102 5.14799 23.1258 5.22992 23.125 5.3125V6.87502H24.6875C24.8522 6.87661 25.0097 6.94316 25.1256 7.0602C25.2415 7.17723 25.3065 7.33529 25.3065 7.50001C25.3065 7.66473 25.2415 7.82279 25.1256 7.93982C25.0097 8.05686 24.8522 8.12341 24.6875 8.125H24.6875Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if ($whatsappStore->products->count() == 0)
                        <div class="text-center mb-5 mt-3">
                            <h3 class="fs-20 fw-6 mb-0 text-break">
                                {{ __('messages.whatsapp_stores_templates.product_not_found') }}</h3>
                        </div>
                    @endif
                </div>
                @if ($whatsappStore->products->count() > 0)
                    <div class="text-center mb-3 mb-sm-4 mb-lg-5">
                        <a href="{{ route('whatsapp.store.products', $whatsappStore->url_alias) }}"
                            class="btn view-more-btn d-flex align-items-center justify-content-center mx-auto gap-1">
                            <span class="text">{{ __('messages.whatsapp_stores_templates.view_more') }}</span>
                            <span
                                class="arrow-box rounded-circle bg-white d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                    viewBox="0 0 26 26" fill="none">
                                    <g clip-path="url(#clip0_237_335)">
                                        <path
                                            d="M1.47655 12.0234H22.1581L18.7321 8.61406C18.3498 8.23359 18.3484 7.61528 18.7288 7.233C19.1093 6.85068 19.7277 6.84926 20.1099 7.22968L25.2127 12.3078L25.2136 12.3087C25.5949 12.6892 25.5961 13.3095 25.2137 13.6913L25.2128 13.6922L20.11 18.7703C19.7278 19.1507 19.1095 19.1494 18.7289 18.767C18.3485 18.3847 18.3499 17.7664 18.7322 17.3859L22.1581 13.9766H1.47655C0.937189 13.9766 0.499983 13.5394 0.499983 13C0.499983 12.4606 0.937189 12.0234 1.47655 12.0234Z"
                                            fill="black" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_237_335">
                                            <rect width="25" height="25" fill="white"
                                                transform="matrix(-1 0 0 1 25.5 0.5)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                        </a>
                    </div>
                @endif
                {{-- Business Hours section --}}
                @if ($business_hours == true)
                @if ($whatsappStore->businessHours->count())
                <div class="businesshour-section">
                    <div class="section-heading">
                        <h2 class="position-relative mb-0">{{ __('messages.business.business_hours') }}</h2>
                    </div>
                    <div class="row row-gap-3">
                        @php
                            $todayWeekName = strtolower(\Carbon\Carbon::now()->rawFormat('D'));
                        @endphp
                        @php
                            $weekFormat = $whatsappStore->week_format ?? 1;

                            if ($weekFormat == 2) {
                                $businessDaysTime = collect($businessDaysTime)->sortKeysUsing(function ($a, $b) {
                                    if ($a == 7) return -1;  // Sunday first
                                    if ($b == 7) return 1;
                                    return $a <=> $b;
                                })->toArray();
                            }
                        @endphp
                        @foreach ($businessDaysTime as $key => $dayTime)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="businesshour-item d-flex gap-2 align-items-center flex-column">
                                    <div class="time-icons d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-calendar-time text-white" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
                                            <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M15 3v4"></path>
                                            <path d="M7 3v4"></path>
                                            <path d="M3 11h16"></path>
                                            <path d="M18 16.496v1.504l1 1"></path>
                                        </svg>
                                    </div>
                                    <div class="businesshour-content d-flex gap-2 gap-xl-1 gap-xxl-2 align-items-center">
                                        <h3 class="fs-14 fw-5 mb-0 text-break">{{ __('messages.business.' .
                                            \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}:</h3>
                                        <p class="fs-16 fw-6 mb-0 text-break">
                                            {{ $dayTime ?? __('messages.common.closed') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @endif

                {{-- Trending Video Section --}}
                @if ($whatsappStore->trendingVideo->count() > 0)
                    <div class="trending-videos-section">
                        <div class="section-heading">
                            <h2 class="position-relative mb-0">{{ __('messages.whatsapp_stores.our_trending_videos') }}</h2>
                        </div>

                        <div class="trending-videos-slider" id="trendingVideosSlider">
                            @foreach($whatsappStore->trendingVideo as $video)
                                @php
                                    $videoId = TrendingYoutubeID($video->youtube_link);
                                    $isShort = strpos($video->youtube_link, '/shorts/') !== false;

                                    if ($isShort) {
                                        $embedParams = "autoplay=1&controls=0&loop=1&playlist={$videoId}&mute=1&modestbranding=1&rel=0";
                                        $modalParams = "autoplay=1&controls=1&modestbranding=1&rel=0";
                                    } else {
                                        $embedParams = "autoplay=1&mute=1&loop=1&playlist={$videoId}&controls=0&modestbranding=0&showinfo=0&rel=0";
                                        $modalParams = "autoplay=1&controls=1&modestbranding=1&showinfo=0&rel=0";
                                    }
                                @endphp
                                <div class="trending-video-slide horizontal-videos">
                                    <div class="video-wrapper">
                                        <!-- Your original iframe exactly as it was -->
                                        <iframe
                                            src="https://www.youtube-nocookie.com/embed/{{ $videoId }}?{{ $embedParams }}"
                                            class="trending-video"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen
                                            loading="lazy">
                                        </iframe>

                                        <!-- Invisible overlay div for click detection -->
                                        <div class="video-click-overlay"
                                            data-video-id="{{ $videoId }}"
                                            data-modal-params="{{ $modalParams }}"
                                            title="Click to enlarge video"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="videoModal" class="video-popup-modal">
                        <div class="video-modal-content">
                            <span class="video-modal-close">&times;</span>
                            <div class="video-modal-container">
                                <iframe id="modalVideoFrame"
                                    src=""
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sticky Bar Button --}}
        @php
            $shareUrl = $whatsappStoreUrl;
        @endphp
        <div class="btn-section cursor-pointer @if (getLanguage($whatsappStore->default_language) == 'Arabic' || getLanguage($whatsappStore->default_language) == 'Persian') rtl @endif">
            <div class="fixed-btn-section">
                @if (empty($whatsappStore->hide_stickybar))
                    <div class="bars-btn whatsapp-store-bars-btn">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.4135 0.540405H22.4891C23.5721 0.540405 24.4602 1.42855 24.4602 2.51152V9.58713C24.4602 10.6773 23.5732 11.5582 22.4891 11.5582H15.4135C14.3223 11.5582 13.4424 10.6783 13.4424 9.58713V2.51152C13.4424 1.42746 14.3234 0.540405 15.4135 0.540405Z"
                                stroke="#ffffff" />
                            <path
                                d="M2.97143 0.5H8.74589C10.1129 0.5 11.2173 1.6122 11.2173 2.97143V8.74589C11.2173 10.1139 10.1139 11.2173 8.74589 11.2173H2.97143C1.6122 11.2173 0.5 10.1129 0.5 8.74589V2.97143C0.5 1.61328 1.61328 0.5 2.97143 0.5Z"
                                stroke="#ffffff" />
                            <path
                                d="M2.97143 13.7828H8.74589C10.1139 13.7828 11.2173 14.8862 11.2173 16.2543V22.0287C11.2173 23.388 10.1129 24.5002 8.74589 24.5002H2.97143C1.61328 24.5002 0.5 23.3869 0.5 22.0287V16.2543C0.5 14.8873 1.6122 13.7828 2.97143 13.7828Z"
                                stroke="#ffffff" />
                            <path
                                d="M16.2537 13.7828H22.0281C23.3873 13.7828 24.4995 14.8873 24.4995 16.2543V22.0287C24.4995 23.3869 23.3863 24.5002 22.0281 24.5002H16.2537C14.8867 24.5002 13.7822 23.388 13.7822 22.0287V16.2543C13.7822 14.8862 14.8856 13.7828 16.2537 13.7828Z"
                                stroke="#ffffff" />
                        </svg>
                    </div>
                @endif
                <div class="sub-btn d-none">
                    <div class="sub-btn-div @if (getLanguage($whatsappStore->default_language) == 'Arabic' || getLanguage($whatsappStore->default_language) == 'Persian') sub-btn-div-left @endif">
                        @if (empty($whatsappStore->hide_stickybar))
                            <div class="stickyIcon">
                                <button type="button"
                                    class="whatsapp-store-btn-group whatsapp-store-share whatsapp-store-sticky-btn mb-3 px-2 py-1">
                                    <i class="fas fa-share-alt fs-4 pt-0"></i>
                                </button>
                                @if (!empty($whatsappStore->enable_download_qr_code))
                                    <div class="qr-code-image d-none">
                                        {!! QrCode::size($whatsappStore->qr_code_download_size ?? 200)->format('svg')->generate($shareUrl) !!}
                                    </div>
                                    <a type="button"
                                        class="whatsapp-store-btn-group whatsapp-store-sticky-btn d-flex justify-content-center align-items-center text-decoration-none px-2 mb-3 py-2 whatsapp-store-qr-code-btn"
                                        title="{{ __('messages.vcard.qr_code') }}"
                                        download="whatsapp_store_qr_code.png">
                                        <i class="fa-solid fa-qrcode fs-4"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        {{-- share modal code --}}
        <div id="whatsapp-store-shareModel" class="modal fade" role="dialog" style="z-index: 9999;">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                <div class="modal-content" @if (getLanguage($whatsappStore->default_language) == 'Arabic' || getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
                    <div class="">
                        <div class="row align-items-center mt-3">
                            <div class="col-10 text-center">
                                <h5 class="modal-title pl-50">{{ __('messages.whatsapp_stores.share_my_whatsapp_store') }}</h5>
                            </div>
                            <div class="col-2 p-0">
                                <button type="button" aria-label="Close"
                                    class="p-3 btn btn-sm btn-icon btn-active-color-danger border-none"
                                    data-bs-dismiss="modal">
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                                fill="#000000">
                                                <rect fill="#000000" x="0" y="7" width="16" height="2"
                                                    rx="1" />
                                                <rect fill="#000000" opacity="0.5"
                                                    transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                    x="0" y="7" width="16" height="2" rx="1" />
                                            </g>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body p-2">
                        <a href="http://www.facebook.com/sharer.php?u={{ $shareUrl }}" target="_blank"
                            class="text-decoration-none share" title="Facebook">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-facebook fa-2x" style="color: #1B95E0"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_facebook') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="http://twitter.com/share?url={{ $shareUrl }}&text={{ $whatsappStore->name }}&hashtags=sharebuttons"
                            target="_blank" class="text-decoration-none share" title="Twitter">
                            <div class="row">
                                <div class="col-2">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" height="2em"
                                            viewBox="0 0 512 512">
                                            <path
                                                d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                        </svg></span>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_twitter') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}"
                            target="_blank" class="text-decoration-none share" title="Linkedin">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-linkedin fa-2x" style="color: #1B95E0"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_linkedin') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="mailto:?Subject=&Body={{ $shareUrl }}" target="_blank"
                            class="text-decoration-none share" title="Email">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-envelope fa-2x" style="color: #191a19  "></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_email') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="http://pinterest.com/pin/create/link/?url={{ $shareUrl }}" target="_blank"
                            class="text-decoration-none share" title="Pinterest">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-pinterest fa-2x" style="color: #bd081c"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_pinterest') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="http://reddit.com/submit?url={{ $shareUrl }}&title={{ $whatsappStore->name }}"
                            target="_blank" class="text-decoration-none share" title="Reddit">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-reddit fa-2x" style="color: #ff4500"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_reddit') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="https://wa.me/?text={{ $shareUrl }}" target="_blank"
                            class="text-decoration-none share" title="Whatsapp">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-whatsapp fa-2x" style="color: limegreen"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_whatsapp') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="https://www.snapchat.com/scan?attachmentUrl={{ $shareUrl }}"
                            target="_blank" class="text-decoration-none share" title="Snapchat">
                            <div class="row">
                                <div class="col-2">
                                    <svg width="30px" height="30px" viewBox="147.353 39.286 514.631 514.631"
                                        version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
                                        fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path style="fill:#FFFC00;"
                                                d="M147.553,423.021v0.023c0.308,11.424,0.403,22.914,2.33,34.268 c2.042,12.012,4.961,23.725,10.53,34.627c7.529,14.756,17.869,27.217,30.921,37.396c9.371,7.309,19.608,13.111,30.94,16.771 c16.524,5.33,33.571,7.373,50.867,7.473c10.791,0.068,21.575,0.338,32.37,0.293c78.395-0.33,156.792,0.566,235.189-0.484 c10.403-0.141,20.636-1.41,30.846-3.277c19.569-3.582,36.864-11.932,51.661-25.133c17.245-15.381,28.88-34.205,34.132-56.924 c3.437-14.85,4.297-29.916,4.444-45.035v-3.016c0-1.17-0.445-256.892-0.486-260.272c-0.115-9.285-0.799-18.5-2.54-27.636 c-2.117-11.133-5.108-21.981-10.439-32.053c-5.629-10.641-12.68-20.209-21.401-28.57c-13.359-12.81-28.775-21.869-46.722-26.661 c-16.21-4.327-32.747-5.285-49.405-5.27c-0.027-0.004-0.09-0.173-0.094-0.255H278.56c-0.005,0.086-0.008,0.172-0.014,0.255 c-9.454,0.173-18.922,0.102-28.328,1.268c-10.304,1.281-20.509,3.21-30.262,6.812c-15.362,5.682-28.709,14.532-40.11,26.347 c-12.917,13.386-22.022,28.867-26.853,46.894c-4.31,16.084-5.248,32.488-5.271,49.008">
                                            </path>
                                            <path style="fill:#FFFFFF;"
                                                d="M407.001,473.488c-1.068,0-2.087-0.039-2.862-0.076c-0.615,0.053-1.25,0.076-1.886,0.076 c-22.437,0-37.439-10.607-50.678-19.973c-9.489-6.703-18.438-13.031-28.922-14.775c-5.149-0.854-10.271-1.287-15.22-1.287 c-8.917,0-15.964,1.383-21.109,2.389c-3.166,0.617-5.896,1.148-8.006,1.148c-2.21,0-4.895-0.49-6.014-4.311 c-0.887-3.014-1.523-5.934-2.137-8.746c-1.536-7.027-2.65-11.316-5.281-11.723c-28.141-4.342-44.768-10.738-48.08-18.484 c-0.347-0.814-0.541-1.633-0.584-2.443c-0.129-2.309,1.501-4.334,3.777-4.711c22.348-3.68,42.219-15.492,59.064-35.119 c13.049-15.195,19.457-29.713,20.145-31.316c0.03-0.072,0.065-0.148,0.101-0.217c3.247-6.588,3.893-12.281,1.926-16.916 c-3.626-8.551-15.635-12.361-23.58-14.882c-1.976-0.625-3.845-1.217-5.334-1.808c-7.043-2.782-18.626-8.66-17.083-16.773 c1.124-5.916,8.949-10.036,15.273-10.036c1.756,0,3.312,0.308,4.622,0.923c7.146,3.348,13.575,5.045,19.104,5.045 c6.876,0,10.197-2.618,11-3.362c-0.198-3.668-0.44-7.546-0.674-11.214c0-0.004-0.005-0.048-0.005-0.048 c-1.614-25.675-3.627-57.627,4.546-75.95c24.462-54.847,76.339-59.112,91.651-59.112c0.408,0,6.674-0.062,6.674-0.062 c0.283-0.005,0.59-0.009,0.908-0.009c15.354,0,67.339,4.27,91.816,59.15c8.173,18.335,6.158,50.314,4.539,76.016l-0.076,1.23 c-0.222,3.49-0.427,6.793-0.6,9.995c0.756,0.696,3.795,3.096,9.978,3.339c5.271-0.202,11.328-1.891,17.998-5.014 c2.062-0.968,4.345-1.169,5.895-1.169c2.343,0,4.727,0.456,6.714,1.285l0.106,0.041c5.66,2.009,9.367,6.024,9.447,10.242 c0.071,3.932-2.851,9.809-17.223,15.485c-1.472,0.583-3.35,1.179-5.334,1.808c-7.952,2.524-19.951,6.332-23.577,14.878 c-1.97,4.635-1.322,10.326,1.926,16.912c0.036,0.072,0.067,0.145,0.102,0.221c1,2.344,25.205,57.535,79.209,66.432 c2.275,0.379,3.908,2.406,3.778,4.711c-0.048,0.828-0.248,1.656-0.598,2.465c-3.289,7.703-19.915,14.09-48.064,18.438 c-2.642,0.408-3.755,4.678-5.277,11.668c-0.63,2.887-1.271,5.717-2.146,8.691c-0.819,2.797-2.641,4.164-5.567,4.164h-0.441 c-1.905,0-4.604-0.346-8.008-1.012c-5.95-1.158-12.623-2.236-21.109-2.236c-4.948,0-10.069,0.434-15.224,1.287 c-10.473,1.744-19.421,8.062-28.893,14.758C444.443,462.88,429.436,473.488,407.001,473.488">
                                            </path>
                                            <path style="fill:#020202;"
                                                d="M408.336,124.235c14.455,0,64.231,3.883,87.688,56.472c7.724,17.317,5.744,48.686,4.156,73.885 c-0.248,3.999-0.494,7.875-0.694,11.576l-0.084,1.591l1.062,1.185c0.429,0.476,4.444,4.672,13.374,5.017l0.144,0.008l0.15-0.003 c5.904-0.225,12.554-2.059,19.776-5.442c1.064-0.498,2.48-0.741,3.978-0.741c1.707,0,3.521,0.321,5.017,0.951l0.226,0.09 c3.787,1.327,6.464,3.829,6.505,6.093c0.022,1.28-0.935,5.891-14.359,11.194c-1.312,0.518-3.039,1.069-5.041,1.7 c-8.736,2.774-21.934,6.96-26.376,17.427c-2.501,5.896-1.816,12.854,2.034,20.678c1.584,3.697,26.52,59.865,82.631,69.111 c-0.011,0.266-0.079,0.557-0.229,0.9c-0.951,2.24-6.996,9.979-44.612,15.783c-5.886,0.902-7.328,7.5-9,15.17 c-0.604,2.746-1.218,5.518-2.062,8.381c-0.258,0.865-0.306,0.914-1.233,0.914c-0.128,0-0.278,0-0.442,0 c-1.668,0-4.2-0.346-7.135-0.922c-5.345-1.041-12.647-2.318-21.982-2.318c-5.21,0-10.577,0.453-15.962,1.352 c-11.511,1.914-20.872,8.535-30.786,15.543c-13.314,9.408-27.075,19.143-48.071,19.143c-0.917,0-1.812-0.031-2.709-0.076 l-0.236-0.01l-0.237,0.018c-0.515,0.045-1.034,0.068-1.564,0.068c-20.993,0-34.76-9.732-48.068-19.143 c-9.916-7.008-19.282-13.629-30.791-15.543c-5.38-0.896-10.752-1.352-15.959-1.352c-9.333,0-16.644,1.428-21.978,2.471 c-2.935,0.574-5.476,1.066-7.139,1.066c-1.362,0-1.388-0.08-1.676-1.064c-0.844-2.865-1.461-5.703-2.062-8.445 c-1.676-7.678-3.119-14.312-9.002-15.215c-37.613-5.809-43.659-13.561-44.613-15.795c-0.149-0.352-0.216-0.652-0.231-0.918 c56.11-9.238,81.041-65.408,82.63-69.119c3.857-7.818,4.541-14.775,2.032-20.678c-4.442-10.461-17.638-14.653-26.368-17.422 c-2.007-0.635-3.735-1.187-5.048-1.705c-11.336-4.479-14.823-8.991-14.305-11.725c0.601-3.153,6.067-6.359,10.837-6.359 c1.072,0,2.012,0.173,2.707,0.498c7.747,3.631,14.819,5.472,21.022,5.472c9.751,0,14.091-4.537,14.557-5.055l1.057-1.182 l-0.085-1.583c-0.197-3.699-0.44-7.574-0.696-11.565c-1.583-25.205-3.563-56.553,4.158-73.871 c23.37-52.396,72.903-56.435,87.525-56.435c0.36,0,6.717-0.065,6.717-0.065C407.744,124.239,408.033,124.235,408.336,124.235 M408.336,115.197h-0.017c-0.333,0-0.646,0-0.944,0.004c-2.376,0.024-6.282,0.062-6.633,0.066c-8.566,0-25.705,1.21-44.115,9.336 c-10.526,4.643-19.994,10.921-28.14,18.66c-9.712,9.221-17.624,20.59-23.512,33.796c-8.623,19.336-6.576,51.905-4.932,78.078 l0.006,0.041c0.176,2.803,0.361,5.73,0.53,8.582c-1.265,0.581-3.316,1.194-6.339,1.194c-4.864,0-10.648-1.555-17.187-4.619 c-1.924-0.896-4.12-1.349-6.543-1.349c-3.893,0-7.997,1.146-11.557,3.239c-4.479,2.63-7.373,6.347-8.159,10.468 c-0.518,2.726-0.493,8.114,5.492,13.578c3.292,3.008,8.128,5.782,14.37,8.249c1.638,0.645,3.582,1.261,5.641,1.914 c7.145,2.271,17.959,5.702,20.779,12.339c1.429,3.365,0.814,7.793-1.823,13.145c-0.069,0.146-0.138,0.289-0.201,0.439 c-0.659,1.539-6.807,15.465-19.418,30.152c-7.166,8.352-15.059,15.332-23.447,20.752c-10.238,6.617-21.316,10.943-32.923,12.855 c-4.558,0.748-7.813,4.809-7.559,9.424c0.078,1.33,0.39,2.656,0.931,3.939c0.004,0.008,0.009,0.016,0.013,0.023 c1.843,4.311,6.116,7.973,13.063,11.203c8.489,3.943,21.185,7.26,37.732,9.855c0.836,1.59,1.704,5.586,2.305,8.322 c0.629,2.908,1.285,5.898,2.22,9.074c1.009,3.441,3.626,7.553,10.349,7.553c2.548,0,5.478-0.574,8.871-1.232 c4.969-0.975,11.764-2.305,20.245-2.305c4.702,0,9.575,0.414,14.48,1.229c9.455,1.574,17.606,7.332,27.037,14 c13.804,9.758,29.429,20.803,53.302,20.803c0.651,0,1.304-0.021,1.949-0.066c0.789,0.037,1.767,0.066,2.799,0.066 c23.88,0,39.501-11.049,53.29-20.799l0.022-0.02c9.433-6.66,17.575-12.41,27.027-13.984c4.903-0.814,9.775-1.229,14.479-1.229 c8.102,0,14.517,1.033,20.245,2.15c3.738,0.736,6.643,1.09,8.872,1.09l0.218,0.004h0.226c4.917,0,8.53-2.699,9.909-7.422 c0.916-3.109,1.57-6.029,2.215-8.986c0.562-2.564,1.46-6.674,2.296-8.281c16.558-2.6,29.249-5.91,37.739-9.852 c6.931-3.215,11.199-6.873,13.053-11.166c0.556-1.287,0.881-2.621,0.954-3.979c0.261-4.607-2.999-8.676-7.56-9.424 c-51.585-8.502-74.824-61.506-75.785-63.758c-0.062-0.148-0.132-0.295-0.205-0.438c-2.637-5.354-3.246-9.777-1.816-13.148 c2.814-6.631,13.621-10.062,20.771-12.332c2.07-0.652,4.021-1.272,5.646-1.914c7.039-2.78,12.07-5.796,15.389-9.221 c3.964-4.083,4.736-7.995,4.688-10.555c-0.121-6.194-4.856-11.698-12.388-14.393c-2.544-1.052-5.445-1.607-8.399-1.607 c-2.011,0-4.989,0.276-7.808,1.592c-6.035,2.824-11.441,4.368-16.082,4.588c-2.468-0.125-4.199-0.66-5.32-1.171 c0.141-2.416,0.297-4.898,0.458-7.486l0.067-1.108c1.653-26.19,3.707-58.784-4.92-78.134c-5.913-13.253-13.853-24.651-23.604-33.892 c-8.178-7.744-17.678-14.021-28.242-18.661C434.052,116.402,416.914,115.197,408.336,115.197">
                                            </path>
                                            <rect x="147.553" y="39.443" style="fill:none;" width="514.231"
                                                height="514.23"></rect>
                                        </g>
                                    </svg>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_snapchat') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="col-12 justify-content-between social-link-modal">
                            <div class="input-group">
                                <input type="text" class="form-control"
                                    placeholder="{{ request()->fullUrl() }}" disabled>
                                <span id="whatsappStoreUrlCopy{{ $whatsappStore->id }}" class="d-none" target="_blank">
                                    {{ $whatsappStoreUrl }} </span>
                                <button class="copy-whatsapp-store-clipboard btn btn-dark" title="Copy Link"
                                    data-id="{{ $whatsappStore->id }}">
                                    <i class="fa-regular fa-copy fa-2x"></i>
                                </button>
                            </div>
                        </div>
                        <div class="text-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Newsletter Popup --}}
        @if ($whatsappStore->news_letter_popup)
            <div class="modal fade" id="newsLetterModal" tabindex="-1" aria-labelledby="newsLetterModalLabel" aria-hidden="true">
                <div class="modal-dialog news-modal modal-dialog-centered">
                    <div class="modal-content animate-bottom" id="newsLetter-content">
                        <div class="newsmodal-header px-0 position-relative">
                            <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                                aria-label="Close" id="closeNewsLetterModal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3 class="content newsmodal-title text-start mb-2">{{ __('messages.vcard.subscribe_newslatter') }}</h3>
                            <p class="modal-desc text-start">{{ __('messages.vcard.update_directly') }}</p>
                            <form action="" method="post" id="newsLetterForm">
                                @csrf
                                <input type="hidden" name="whatsapp_store_id" value="{{ $whatsappStore->id ?? '' }}">
                                <div class="mb-3 d-flex gap-1 justify-content-center align-items-center email-input">
                                    <div class="w-100">
                                        <input type="email"
                                            class="email-input form-control bg-light border-dark text-dark w-100"
                                            placeholder="{{ __('messages.form.enter_your_email') }}"
                                            name="email" id="emailSubscription" aria-label="Email"
                                            aria-describedby="button-addon2">
                                    </div>
                                    <button class="btn ms-1" type="submit"
                                        id="email-send">{{ __('messages.subscribe') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
         {{-- Pwa support --}}
        @if (isset($enable_pwa) && $enable_pwa == 1 && !isiOSDevice())
            <div class="mt-0">
                <div class="pwa-support d-flex align-items-center justify-content-center">
                    <div>
                        <h1 class="text-start pwa-heading">{{ __('messages.pwa.add_to_home_screen') }}</h1>
                        <p class="text-start pwa-text text-dark fs-16 fw-5">{{ __('messages.pwa.pwa_description') }} </p>
                        <div class="text-end d-flex">
                            <button id="installPwaBtn"
                                class="pwa-install-button w-50 mb-1 btn">{{ __('messages.pwa.install') }}
                            </button>
                            <button
                                class= "pwa-cancel-button w-50  pwa-close btn btn-secondary mb-1 {{ getLocalLanguage() == 'ar' || getLocalLanguage() == 'fa' ? 'me-2' : 'ms-2' }}">{{ __('messages.common.cancel') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
    $(document).ready(function() {
        $(".category-slider").slick({
            infinite: true,
            slidesToShow: 5,
            rtl: isRtl,
            slidesToScroll: 1,
            // autoplay: true,
            prevArrow: '<button class="slide-arrow prev-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"><path d="M2.61048 5.99881L2.52357 5.91829L2.61048 6.01208L6.74799 10.4776C6.74801 10.4776 6.74802 10.4777 6.74804 10.4777C6.89859 10.6459 6.98199 10.8714 6.98011 11.1056C6.97822 11.3398 6.89118 11.5637 6.73792 11.7291C6.58468 11.8945 6.37755 11.9882 6.16119 11.9902C5.94487 11.9922 5.7363 11.9025 5.58044 11.7401C5.58042 11.74 5.58039 11.74 5.58037 11.74L0.851898 6.63663C0.696935 6.46933 0.609765 6.24231 0.609765 6.00545C0.609765 5.76859 0.696935 5.54156 0.851899 5.37426L5.58049 0.270777C5.73548 0.103552 5.94549 0.00976553 6.1643 0.00976555C6.3831 0.00976557 6.59311 0.103552 6.7481 0.270777L6.7481 0.270775C6.90306 0.438075 6.99023 0.665102 6.99023 0.901961C6.99023 1.13882 6.90306 1.36585 6.7481 1.53315L2.61048 5.99881Z" stroke="#141414" stroke-width="0.0195312"/></svg></button>',
            nextArrow: '<button class="slide-arrow next-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"><path d="M4.38952 6.00119L4.47643 6.08171L4.38952 5.98792L0.252014 1.52238C0.251996 1.52236 0.251977 1.52234 0.251959 1.52232C0.101415 1.35406 0.0180061 1.12857 0.0198916 0.894392C0.0217773 0.660185 0.108825 0.43628 0.262083 0.270871C0.415319 0.105486 0.622448 0.0118285 0.838806 0.0098001C1.05513 0.00776977 1.2637 0.097502 1.41956 0.259938C1.41958 0.25996 1.41961 0.259983 1.41963 0.260006L6.1481 5.36337C6.30307 5.53067 6.39024 5.75769 6.39024 5.99455C6.39024 6.23141 6.30307 6.45844 6.1481 6.62574L1.41951 11.7292C1.26452 11.8964 1.05451 11.9902 0.835705 11.9902C0.616899 11.9902 0.406885 11.8964 0.251898 11.7292L0.2519 11.7292C0.0969359 11.5619 0.00976574 11.3349 0.00976578 11.098C0.00976582 10.8612 0.096936 10.6342 0.2519 10.4669L4.38952 6.00119Z" stroke="#2650D7" stroke-width="0.0195312"/></svg></button>',
            responsive: [{
                    breakpoint: 1399,
                    settings: {
                        slidesToShow: 6,
                    },
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 5,
                    },
                },
                {
                    breakpoint: 860,
                    settings: {
                        slidesToShow: 4,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 460,
                    settings: {
                        slidesToShow: 2,
                        dots: true,
                        arrows: false,
                    },
                },
                {
                    breakpoint: 360,
                    settings: {
                        slidesToShow: 1,
                        dots: true,
                        arrows: false,
                    },
                },
            ],
        });
    });
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
    $(document).ready(function(){
        $('#trendingVideosSlider').slick({
            dots: false,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            pauseOnHover: true,
            arrows: true,
            rtl: isRtl,
            variableWidth: false,
            adaptiveHeight: false,
            centerMode: false,
            autoplay: false,
            prevArrow: '<button class="slide-trending-arrow prev-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none"><path d="M0 6.99998C0 6.74907 0.0960374 6.49819 0.287709 6.3069L6.32224 0.287199C6.70612 -0.0957328 7.3285 -0.0957328 7.71221 0.287199C8.09593 0.669975 8.09593 1.29071 7.71221 1.67367L2.37252 6.99998L7.71203 12.3263C8.09574 12.7092 8.09574 13.3299 7.71203 13.7127C7.32831 14.0958 6.70593 14.0958 6.32206 13.7127L0.287522 7.69306C0.09582 7.50167 0 7.25079 0 6.99998Z" fill="currentColor" /></svg></button>',
            nextArrow: '<button class="slide-trending-arrow next-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none"><path d="M8 7.00002C8 7.25093 7.90396 7.50181 7.71229 7.6931L1.67776 13.7128C1.29388 14.0957 0.671503 14.0957 0.287787 13.7128C-0.095929 13.33 -0.095929 12.7093 0.287787 12.3263L5.62748 7.00002L0.287973 1.67369C-0.0957425 1.29076 -0.0957425 0.670084 0.287973 0.287339C0.67169 -0.0957785 1.29407 -0.0957785 1.67794 0.287339L7.71248 6.30694C7.90418 6.49833 8 6.74921 8 7.00002Z" fill="currentColor"/></svg></button>',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        centerMode: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        centerMode: false
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        centerMode: false
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerMode: true,
                        centerPadding: '40px'
                    }
                },
                {
                    breakpoint: 320,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerMode: true,
                        centerPadding: '40px'
                    }
                }
            ]
        });
    });
</script>
<script>
$(document).ready(function() {
    $('.video-click-overlay').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const videoId = $(this).data('video-id');
        openVideoModal(videoId);
    });

    $('.video-modal-close').on('click', function() {
        closeVideoModal();
    });

    $('#videoModal').on('click', function(e) {
        if (e.target === this) {
            closeVideoModal();
        }
    });

    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            closeVideoModal();
        }
    });
});

function openVideoModal(videoId) {
    const modalVideoSrc = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1&controls=1&showinfo=1&enablejsapi=1`;

    $('#modalVideoFrame').attr('src', modalVideoSrc);
    $('#videoModal').fadeIn(300);

    $('body').css('overflow', 'hidden');
}

function closeVideoModal() {
    $('#videoModal').fadeOut(300);
    $('#modalVideoFrame').attr('src', '');
    $('body').css('overflow', 'auto');
}
</script>
<script>
    let deferredPrompt = null;
    window.addEventListener("beforeinstallprompt", (event) => {
        /* event.preventDefault(); */
        deferredPrompt = event;
        document.getElementById("installPwaBtn").style.display = "block";
    });
    document.getElementById("installPwaBtn").addEventListener("click", async () => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            await deferredPrompt.userChoice;
            deferredPrompt = null;
        }
    });
</script>
<script>
    let defaultCountryCodeValue = "{{ getSuperAdminSettingValue('default_country_code') }}"
</script>
<script>
    const getCookieUrl = "{{ route('whatsapp.store.getCookie') }}";
    const emailSubscriptionUrl = "{{ route('whatsapp.store.emailSubscriprion-store', ['alias' => $whatsappStore->url_alias]) }}";
</script>
</html>
