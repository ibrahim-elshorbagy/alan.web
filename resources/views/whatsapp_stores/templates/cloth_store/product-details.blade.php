<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $product->name }} | {{ $whatsappStore->store_name }}</title>
  <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
  {{-- google Font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  @if (checkFeature('custom-fonts') && $whatsappStore->font_family)
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family={{ urlencode($whatsappStore->font_family) }}:wght@400;500;600;700&display=swap{{ in_array($whatsappStore->font_family, ['Tajawal', 'Cairo', 'Amiri', 'Noto Sans Arabic', 'Noto Naskh Arabic', 'Noto Kufi Arabic', 'Scheherazade', 'Lateef', 'Harmattan', 'Reem Kufi', 'Jomhuria', 'Mada', 'Lemonada', 'Zain']) ? '&subset=arabic' : '' }}">
  @endif
  <link rel="icon" href="{{ $whatsappStore->logo_url }}" type="image/png">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
  <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/cloth_store.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/third-party.css') }}">
  <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
  <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/custom.css') }}" />
  @if ($whatsappStore->font_family || $whatsappStore->font_size || $whatsappStore->custom_css)
    <style>
      @if (checkFeature('custom-fonts'))
        @if ($whatsappStore->font_family)
          body,
          body *,
          button,
          h1,
          h2,
          h3,
          h4,
          h5,
          h6,
          p,
          div,
          span,
          a,
          input,
          textarea,
          select,
          label,
          li,
          ul,
          ol,
          table,
          th,
          td,
          blockquote,
          strong,
          b,
          em,
          {
          font-family: {{ $whatsappStore->font_family }} !important;
        }
      @endif
      @endif

      @if ($whatsappStore->font_size)
        div>h4 {
          font-size: {{ $whatsappStore->font_size }}px !important;
        }
      @endif

      @if ($whatsappStore->custom_css)
        {!! $whatsappStore->custom_css !!}
      @endif
    </style>
  @endif
</head>

<div class="main-content mx-auto w-100 overflow-hidden d-flex flex-column justify-content-between"
  @if (getLanguage($whatsappStore->default_language) == 'Arabic' ||
          getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
  <div>
    <nav class="navbar navbar-expand-lg px-50 position-relative">
      <div class="container-fluid p-0">
        <div class="d-flex align-items-center gap-3">
          <a class="navbar-brand p-0 m-0" href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
            <img src="{{ $whatsappStore->logo_url }}" alt="logo" class="w-100 h-100 object-fit-cover" />
          </a>
          <span class="fw-6 fs-18"><a href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}"
              style="color: #212529 ">{{ $whatsappStore->store_name }}</a></span>

        </div>

        <div class="d-flex align-items-center gap-lg-4 gap-sm-3 gap-2">
          <div class="language-dropdown position-relative">
            <button class="dropdown-btn position-relative" id="dropdownMenuButton" data-bs-toggle="dropdown"
              aria-expanded="false">
              @if (array_key_exists(checkLanguageSession($whatsappStore->url_alias), \App\Models\User::FLAG))
                <img class="flag" alt="flag"
                  src="{{ asset(\App\Models\User::FLAG[getLanguageIsoCode($whatsappStore->default_language) ?? 'en']) }}" />
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
                        src="{{ asset(\App\Models\User::FLAG[$language->iso_code]) }}" />
                    @else
                      @if (count($language->media) != 0)
                        <img src="{{ $language->image_url }}" class="me-1" />
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

          <button class="add-to-cart-btn d-flex align-items-center justify-content-center position-relative"
            id="addToCartViewBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M20.0048 9.03985C20.0048 9.27694 19.9106 9.50433 19.7429 9.67198C19.5753 9.83964 19.3479 9.93382 19.1108 9.93382C18.8737 9.93382 18.6463 9.83964 18.4787 9.67198C18.311 9.50433 18.2168 9.27694 18.2168 9.03985V7.2519C18.2168 6.38254 17.8715 5.54879 17.2567 4.93406C16.642 4.31934 15.8083 3.97399 14.9389 3.97399C14.0696 3.97399 13.2358 4.31934 12.6211 4.93406C12.0063 5.54879 11.661 6.38254 11.661 7.2519V9.03985C11.661 9.27694 11.5668 9.50433 11.3992 9.67198C11.2315 9.83964 11.0041 9.93382 10.767 9.93382C10.5299 9.93382 10.3025 9.83964 10.1349 9.67198C9.96723 9.50433 9.87305 9.27694 9.87305 9.03985V7.2519C9.87305 5.90835 10.4068 4.61982 11.3568 3.66979C12.3068 2.71976 13.5954 2.18604 14.9389 2.18604C16.2825 2.18604 17.571 2.71976 18.521 3.66979C19.471 4.61982 20.0048 5.90835 20.0048 7.2519V9.03985Z"
                fill="#292929" />
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M23.6898 10.6489L24.6434 24.9525C24.6674 25.3188 24.616 25.6862 24.4924 26.0318C24.3688 26.3775 24.1756 26.6942 23.9249 26.9623C23.6741 27.2304 23.371 27.4442 23.0343 27.5905C22.6977 27.7369 22.3346 27.8127 21.9675 27.8132H7.90939C7.54218 27.813 7.17892 27.7375 6.84209 27.5913C6.50526 27.445 6.20204 27.2312 5.95119 26.963C5.70034 26.6948 5.5072 26.378 5.38374 26.0322C5.26028 25.6864 5.20912 25.3189 5.23342 24.9525L6.187 10.6489C6.23235 9.97006 6.534 9.33384 7.03086 8.86907C7.52771 8.40431 8.18262 8.14575 8.86296 8.14575H21.0139C21.6942 8.14575 22.3491 8.40431 22.846 8.86907C23.3428 9.33384 23.6445 9.97006 23.6898 10.6489ZM17.9017 13.4238C17.6351 13.984 17.2153 14.4571 16.6909 14.7884C16.1664 15.1197 15.5588 15.2955 14.9384 15.2955C14.3181 15.2955 13.7105 15.1197 13.186 14.7884C12.6615 14.4571 12.2417 13.984 11.9752 13.4238C11.9248 13.3177 11.854 13.2227 11.7668 13.144C11.6797 13.0653 11.5779 13.0045 11.4673 12.9652C11.3566 12.9258 11.2393 12.9086 11.1221 12.9146C11.0048 12.9206 10.8899 12.9496 10.7838 13C10.6778 13.0504 10.5827 13.1212 10.504 13.2084C10.4253 13.2955 10.3646 13.3973 10.3252 13.508C10.2859 13.6186 10.2687 13.7359 10.2747 13.8532C10.2807 13.9704 10.3097 14.0854 10.3601 14.1914C10.7706 15.0583 11.4188 15.7908 12.2293 16.3037C13.0398 16.8166 13.9793 17.0889 14.9384 17.0889C15.8976 17.0889 16.837 16.8166 17.6475 16.3037C18.458 15.7908 19.1062 15.0583 19.5168 14.1914C19.5672 14.0854 19.5962 13.9704 19.6022 13.8532C19.6082 13.7359 19.591 13.6186 19.5516 13.508C19.5123 13.3973 19.4515 13.2955 19.3728 13.2084C19.2942 13.1212 19.1991 13.0504 19.093 13C18.987 12.9496 18.872 12.9206 18.7548 12.9146C18.6375 12.9086 18.5202 12.9258 18.4096 12.9652C18.2989 13.0045 18.1972 13.0653 18.11 13.144C18.0229 13.2226 17.9521 13.3177 17.9017 13.4238Z"
                fill="#292929" />
            </svg>
            <div class="position-absolute product-count-badge count-product  badge rounded-pill bg-danger">

            </div>
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
                    <img src="{{ $image }}" alt="items" class="w-100 h-100 object-fit-cover" />
                  </div>
                </div>
              @endforeach

            </div>

            <div class="slider-nav">
              @foreach ($product->images_url as $image)
                <div>
                  <div class="thumbnail-img">
                    <img src="{{ $image }}" alt="items" class="w-100 h-100 object-fit-cover" />
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="col-xl-7 col-lg-6">
            <div class="details d-flex flex-column justify-content-between h-100">
              <div>
                <h4 class="fs-28 product-name">{{ $product->name }}</h4>
                <input type="hidden" value="{{ $product->available_stock }}" class="available-stock">
                <input type="hidden" value="{{ $product->category->name }}" class="product-category">
                <input type="hidden" value="{{ $product->images_url[0] ?? '' }}" class="product-image">
                <p class="fs-28 fw-5 mb-30">
                  <span
                    class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                  <del
                    class="fs-18 fw-6 text-gray-200">{{ currencyFormat($product->net_price, 2, $product->currency->currency_code) }}</del>
                  @if ($product->available_stock == 0)
                    <span
                      class="badge badge-danger bg-danger text-sm out-of-stock-text mt-0 ms-2">{{ __('messages.whatsapp_stores.out_of_stock') }}</span>
                  @endif
                </p>
                <p class="fs-20 fw-6 text-gray-200 mb-3">
                  {{ __('messages.whatsapp_stores_templates.description') }}</p>
                <p class="fw-5 fs-16 mb-4">
                  {!! $product->description !!}
                </p>

              </div>
              @if ($product->available_stock != 0)
                <button
                  class="btn btn-primary d-flex justify-content-center align-items-center w-100 fs-18 gap-2 fw-5 rounded-pill addToCartBtn"
                  data-id="{{ $product->id }}">
                  <span>
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M31.4875 25.4531L32.6527 19.1277C32.6781 18.9947 32.6706 18.8574 32.6307 18.728C32.5908 18.5985 32.5198 18.4808 32.424 18.3851C32.3281 18.2894 32.2102 18.2187 32.0807 18.1791C31.9512 18.1395 31.8139 18.1322 31.6809 18.1579C31.1281 18.2744 30.5648 18.3332 29.9999 18.3334C27.9216 18.3333 25.9184 17.5568 24.3831 16.1561C22.8478 14.7554 21.8912 12.8317 21.7009 10.7622C21.6834 10.5548 21.5887 10.3614 21.4357 10.2203C21.2826 10.0792 21.0823 10.0006 20.8741 10H9.1405L9.01987 9.45719C8.89649 8.90209 8.58751 8.40565 8.14395 8.04982C7.70039 7.694 7.14876 7.50005 6.58011 7.5H4.21081C3.79565 7.5 3.41097 7.78359 3.34425 8.19336C3.32398 8.31294 3.33004 8.43551 3.362 8.55251C3.39396 8.66952 3.45106 8.77814 3.52932 8.87081C3.60757 8.96348 3.7051 9.03796 3.81509 9.08907C3.92509 9.14018 4.04491 9.16667 4.1662 9.16672H6.57948C6.76931 9.16586 6.95368 9.23015 7.1018 9.34887C7.24992 9.46758 7.35282 9.63353 7.39331 9.81898L11.9122 30.1549C11.2522 30.362 10.6728 30.7689 10.2541 31.3196C9.83546 31.8702 9.59816 32.5372 9.57502 33.2286C9.55189 33.9199 9.74408 34.6013 10.125 35.1787C10.506 35.7561 11.0568 36.2009 11.7015 36.4516C12.3462 36.7023 13.0529 36.7465 13.7238 36.5782C14.3947 36.4099 14.9968 36.0374 15.4468 35.5121C15.8968 34.9867 16.1725 34.3346 16.2359 33.6458C16.2992 32.957 16.147 32.2655 15.8003 31.667H26.2828C25.9164 32.3022 25.7699 33.0407 25.8659 33.7678C25.962 34.4948 26.2953 35.1699 26.8141 35.6882C27.333 36.2065 28.0083 36.5392 28.7355 36.6345C29.4627 36.7299 30.201 36.5826 30.8359 36.2156C31.4708 35.8486 31.9669 35.2823 32.2472 34.6045C32.5275 33.9268 32.5763 33.1756 32.386 32.4673C32.1958 31.759 31.7772 31.1333 31.1951 30.6872C30.6129 30.2411 29.8999 29.9995 29.1665 30H13.5851L13.0296 27.5H29.029C29.6134 27.5 30.1794 27.2952 30.6285 26.9213C31.0777 26.5473 31.3816 26.0279 31.4875 25.4531ZM12.9165 34.5834C12.6693 34.5834 12.4276 34.51 12.2221 34.3727C12.0165 34.2353 11.8563 34.0401 11.7617 33.8117C11.6671 33.5833 11.6423 33.332 11.6905 33.0895C11.7388 32.847 11.8578 32.6243 12.0326 32.4495C12.2074 32.2747 12.4302 32.1556 12.6727 32.1074C12.9151 32.0591 13.1665 32.0839 13.3949 32.1785C13.6233 32.2731 13.8185 32.4333 13.9559 32.6389C14.0932 32.8445 14.1665 33.0861 14.1665 33.3334C14.1665 33.6649 14.0348 33.9828 13.8004 34.2172C13.566 34.4517 13.248 34.5834 12.9165 34.5834ZM30.4165 33.3334C30.4165 33.5806 30.3432 33.8223 30.2059 34.0278C30.0685 34.2334 29.8733 34.3936 29.6449 34.4882C29.4165 34.5828 29.1651 34.6076 28.9227 34.5593C28.6802 34.5111 28.4574 34.3921 28.2826 34.2172C28.1078 34.0424 27.9888 33.8197 27.9405 33.5772C27.8923 33.3347 27.9171 33.0834 28.0117 32.855C28.1063 32.6266 28.2665 32.4314 28.4721 32.294C28.6776 32.1567 28.9193 32.0834 29.1665 32.0834C29.498 32.0834 29.816 32.2151 30.0504 32.4495C30.2848 32.6839 30.4165 33.0018 30.4165 33.3334Z"
                        fill="currentColor" />
                      <path
                        d="M29.9997 3.33301C28.6811 3.33301 27.3922 3.724 26.2959 4.45654C25.1995 5.18908 24.3451 6.23027 23.8405 7.44844C23.3359 8.6666 23.2039 10.007 23.4611 11.3002C23.7183 12.5934 24.3533 13.7813 25.2856 14.7137C26.218 15.646 27.4059 16.281 28.6991 16.5382C29.9923 16.7954 31.3327 16.6634 32.5509 16.1588C33.769 15.6542 34.8102 14.7998 35.5428 13.7034C36.2753 12.6071 36.6663 11.3182 36.6663 9.99965C36.6663 8.23155 35.9639 6.53588 34.7137 5.28564C33.4634 4.03541 31.7677 3.33303 29.9997 3.33301ZM32.9163 10.833H30.833V12.9164C30.8341 13.0265 30.8133 13.1357 30.7719 13.2377C30.7305 13.3398 30.6693 13.4326 30.5918 13.5109C30.5143 13.5891 30.4221 13.6512 30.3205 13.6936C30.2188 13.736 30.1098 13.7578 29.9997 13.7578C29.8896 13.7578 29.7805 13.736 29.6789 13.6936C29.5773 13.6512 29.4851 13.5891 29.4076 13.5109C29.3301 13.4326 29.2689 13.3398 29.2275 13.2377C29.1861 13.1357 29.1653 13.0265 29.1664 12.9164V10.833H27.083C26.9729 10.8341 26.8637 10.8133 26.7616 10.7719C26.6596 10.7305 26.5668 10.6693 26.4885 10.5918C26.4103 10.5143 26.3482 10.4221 26.3058 10.3205C26.2634 10.2188 26.2416 10.1098 26.2416 9.99969C26.2416 9.88957 26.2634 9.78054 26.3058 9.67891C26.3482 9.57728 26.4103 9.48505 26.4885 9.40757C26.5668 9.33008 26.6596 9.26887 26.7616 9.22747C26.8637 9.18607 26.9729 9.1653 27.083 9.16637H29.1664V7.08301C29.1653 6.9729 29.1861 6.86366 29.2275 6.76163C29.2689 6.65959 29.3301 6.56677 29.4076 6.48852C29.4851 6.41028 29.5773 6.34818 29.6789 6.30579C29.7805 6.2634 29.8896 6.24158 29.9997 6.24158C30.1098 6.24158 30.2188 6.2634 30.3205 6.30579C30.4221 6.34818 30.5143 6.41028 30.5918 6.48852C30.6693 6.56677 30.7305 6.65959 30.7719 6.76163C30.8133 6.86366 30.8341 6.9729 30.833 7.08301V9.16637H32.9164C33.136 9.16849 33.3459 9.25723 33.5004 9.41327C33.655 9.56932 33.7417 9.78007 33.7417 9.99969C33.7417 10.2193 33.655 10.4301 33.5004 10.5861C33.3459 10.7421 33.136 10.8309 32.9164 10.833H32.9163Z"
                        fill="currentColor" />
                    </svg>

                  </span>
                  {{ __('messages.whatsapp_stores_templates.add_to_cart') }}
                </button>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="recommended-product-section px-50 position-relative">
      <div class="section-heading">
        <h2>{{ __('messages.whatsapp_stores_templates.recommended_products') }}</h2>
      </div>
      <div class="product-slider">
        @foreach ($whatsappStore->products as $product)
          <div>
            <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}"
              class="d-block h-100" style="color: #212529;">
              <div class="product-card h-100 d-flex flex-column">
                <div class="product-img w-100 h-100 mb-10 mx-auto">
                  <img src="{{ $product->images_url[0] ?? '' }}" alt="product"
                    class="w-100 h-100 object-fit-cover">
                </div>
                <div class="product-details h-100">
                  <div class="d-flex flex-column justify-content-between h-100">
                    <div>
                      <h5 class="fs-20 fw-5 mb-2 product-name">{{ $product->name }}</h5>
                      <p class="fs-16 fw-5 lh-sm mb-10 text-gray-200">
                        {{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  @include('whatsapp_stores.templates.cloth_store.cart_modal')

  @include('whatsapp_stores.templates.order_modal')
  <footer class="position-relative">
    <div class="container pt-3">
      <div class="row">
        <div class="col-md-4">
          <div class="mb-3">
            <img src="{{ $whatsappStore->logo_url }}" alt="logo"
              style="width: 50px !important; height: 50px !important;">
          </div>
          <div>
            © Copyright {{ now()->year }} {{ env('APP_NAME') }}. All Rights Reserved.
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-2 pt-3 pt-sm-0">
          <h5 class="fw-bold text-white mb-3">
            <i class="fas fa-headset mx-2 text-white"></i>{{ __('messages.whatsapp_stores.support_services') }}
          </h5>
          <ul class="list-unstyled">
            <li class="mb-2">
              <a href="{{ route('whatsapp.store.show-terms-conditions', $whatsappStore->url_alias) }}"
                target="_blank" class="text-decoration-none text-white footer-link-hover">
                <i class="fas fa-file-contract mx-2"></i>{{ __('messages.vcard.term_condition') }}
              </a>
            </li>
            <li class="mb-2">
              <a href="{{ route('whatsapp.store.show-privacy-policy', $whatsappStore->url_alias) }}" target="_blank"
                class="text-decoration-none text-white footer-link-hover">
                <i class="fas fa-shield-alt mx-2"></i>{{ __('messages.vcard.privacy_policy') }}
              </a>
            </li>
            <li class="mb-2">
              <a href="{{ route('whatsapp.store.show-refund-cancellation', $whatsappStore->url_alias) }}"
                target="_blank" class="text-decoration-none text-white footer-link-hover">
                <i class="fas fa-undo-alt mx-2"></i>{{ __('messages.vcard.refund_cancellation_policy') }}
              </a>
            </li>
            <li class="mb-2">
              <a href="{{ route('whatsapp.store.show-shipping-delivery', $whatsappStore->url_alias) }}"
                target="_blank" class="text-decoration-none text-white footer-link-hover">
                <i class="fas fa-shipping-fast mx-2"></i>{{ __('messages.vcard.shipping_delivery_policy') }}
              </a>
            </li>
          </ul>
        </div>

        <div class="col-md-4">
          <div class="fw-5 fs-16">
            <h5 class="fw-bold text-white mb-3">
              <i class="fas fa-comments mx-2 text-white"></i>{{ __('messages.whatsapp_stores.talk_to_us') }}
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
<script>
  let templateName = "cloth_store";
</script>
<script src="{{ asset('messages.js?$mixID') }}"></script>
<script src="{{ asset('assets/js/intl-tel-input/build/intlTelInput.js') }}"></script>
<script src="{{ asset('assets/js/vcard11/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party-vcard11.js') }}"></script>
<script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
<script type="text/javascript" src="{{ mix('assets/js/whatsapp_store_template.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
<script>
  $(document).ready(function() {
    $(".product-slider").slick({
      infinite: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      rtl: isRtl,
      autoplay: true,
      arrows: false,
      responsive: [{
          breakpoint: 1199,
          settings: {
            slidesToShow: 3,
            dots: true,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            dots: true,
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
  $(document).ready(function() {
    $(".slider-for").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      rtl: isRtl,
      fade: true,
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
