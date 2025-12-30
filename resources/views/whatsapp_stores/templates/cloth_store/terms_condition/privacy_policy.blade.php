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
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family={{ urlencode($whatsappStore->font_family) }}:wght@400;500;600;700&display=swap{{ in_array($whatsappStore->font_family, ['Tajawal', 'Cairo', 'Amiri', 'Noto Sans Arabic', 'Noto Naskh Arabic', 'Noto Kufi Arabic', 'Scheherazade', 'Lateef', 'Harmattan', 'Reem Kufi', 'Jomhuria', 'Mada', 'Lemonada', 'Zain']) ? '&subset=arabic' : '' }}">
  @endif
  <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/cloth_store.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
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
          i {
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

<body>
  <div
    class="main-content mx-auto w-100 overflow-hidden d-flex flex-column justify-content-between {{ getLocalLanguage() == 'ar' || getLocalLanguage() == 'fa' ? 'rtl' : '' }}"
    @if (getLanguage($whatsappStore->default_language) == 'Arabic' ||
            getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
    <div>
      <nav class="navbar navbar-expand-lg px-50 position-relative">
        <div class="container-fluid p-0">
          <div class="d-flex align-items-center gap-3">
            <a class="navbar-brand p-0 m-0" href="{{ request()->url() }}">
              <img src="{{ $whatsappStore->logo_url }}" alt="logo" class="w-100 h-100 object-fit-cover" />
            </a>
            <span class="fw-5 fs-18"><a href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}"
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
    </div>
    <div class="main-content">
      @if (isset($privacyPolicy))
        <div>
          <div class="conatiner">
            <div class="text-center">
              <h4 class="">
                {{ __('messages.vcard.privacy_policy') }}
              </h4>
            </div>
            <div class="px-sm-3 px-2 py-md-5 py-3 m-3 card-back">
              <div class="px-3">
                {!! $privacyPolicy->privacy_policy !!}
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
    <div>
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
                <i class="fas fa-headset me-2 text-white"></i>{{ __('messages.whatsapp_stores.support_services') }}
              </h5>
              <ul class="list-unstyled">
                <li class="mb-2">
                  <a href="{{ route('whatsapp.store.show-terms-conditions', $whatsappStore->url_alias) }}"
                    target="_blank" class="text-decoration-none text-white footer-link-hover">
                    <i class="fas fa-file-contract me-2"></i>{{ __('messages.vcard.term_condition') }}
                  </a>
                </li>
                <li class="mb-2">
                  <a href="{{ route('whatsapp.store.show-privacy-policy', $whatsappStore->url_alias) }}"
                    target="_blank" class="text-decoration-none text-white footer-link-hover">
                    <i class="fas fa-shield-alt me-2"></i>{{ __('messages.vcard.privacy_policy') }}
                  </a>
                </li>
                <li class="mb-2">
                  <a href="{{ route('whatsapp.store.show-refund-cancellation', $whatsappStore->url_alias) }}"
                    target="_blank" class="text-decoration-none text-white footer-link-hover">
                    <i class="fas fa-undo-alt me-2"></i>{{ __('messages.vcard.refund_cancellation_policy') }}
                  </a>
                </li>
                <li class="mb-2">
                  <a href="{{ route('whatsapp.store.show-shipping-delivery', $whatsappStore->url_alias) }}"
                    target="_blank" class="text-decoration-none text-white footer-link-hover">
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
                  <i class="fa-solid fa-phone"></i> +{{ $whatsappStore->region_code }}
                  {{ $whatsappStore->whatsapp_no }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
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
  let templateName = "cloth_store";
</script>
<script src="{{ asset('messages.js?$mixID') }}"></script>
<script src="{{ asset('assets/js/intl-tel-input/build/intlTelInput.js') }}"></script>
<script src="{{ asset('assets/js/vcard11/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party-vcard11.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ mix('assets/js/whatsapp_store_template.js') }}"></script>
<script>
  let defaultCountryCodeValue = "{{ getSuperAdminSettingValue('default_country_code') }}"
</script>
<script>
  const getCookieUrl = "{{ route('whatsapp.store.getCookie') }}";
  const emailSubscriptionUrl =
    "{{ route('whatsapp.store.emailSubscriprion-store', ['alias' => $whatsappStore->url_alias]) }}";
</script>

</html>
