<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
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
  <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/travel.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/third-party.css') }}">
  <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
  <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/custom.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
  @if ($whatsappStore->font_family || $whatsappStore->font_size || $whatsappStore->custom_css)
    <style>
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
  <div class="main-content" @if (getLanguage($whatsappStore->default_language) == 'Arabic' ||
          getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid bg-white flex-nowrap">
        <div class="d-flex align-items-center">
          <a class="navbar-brand" href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
            <img src="{{ $whatsappStore->logo_url }}" alt="logo" class="w-100 h-100 object-fit-cover" />
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
              id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
              @if (array_key_exists(checkLanguageSession($whatsappStore->url_alias), \App\Models\User::FLAG))
                <img
                  src="{{ asset(\App\Models\User::FLAG[getLanguageIsoCode($whatsappStore->default_language) ?? 'en']) }}"
                  class="flag" alt="flag" />
              @endif
              {{ strtoupper(getLanguageIsoCode($whatsappStore->default_language) ?? 'en') }}
            </button>
            <svg width="14" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M0.662858 0.365983C0.428519 0.600393 0.296875 0.918278 0.296875 1.24973C0.296875 1.58119 0.428519 1.89907 0.662858 2.13348L8.16286 9.63348C8.39727 9.86782 8.71515 9.99947 9.04661 9.99947C9.37806 9.99947 9.69595 9.86782 9.93036 9.63348L17.4304 2.13348C17.6581 1.89773 17.7841 1.58198 17.7812 1.25423C17.7784 0.926486 17.6469 0.61297 17.4151 0.38121C17.1834 0.14945 16.8699 0.0179888 16.5421 0.0151408C16.2144 0.0122927 15.8986 0.138286 15.6629 0.365983L9.04661 6.98223L2.43036 0.365983C2.19595 0.131644 1.87806 0 1.54661 0C1.21515 0 0.897268 0.131644 0.662858 0.365983Z"
                fill="#DC834E" />
            </svg>

            <ul class="dropdown-menu w-100 p-0" aria-labelledby="dropdownMenuButton">
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

          <button
            class="add-to-cart-btn bg-transparent border-0 p-0 d-flex align-items-center justify-content-center position-relative"
            id="addToCartViewBtn">
            <div class="position-relative">
              <div class="position-absolute cart-count d-flex align-items-center justify-content-center">
                <span class="product-count-badge">1</span>
              </div>
              <svg width="28" height="28" viewBox="0 0 28 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M21.1774 9.66634C21.1774 9.99786 21.0457 10.3158 20.8113 10.5502C20.5769 10.7846 20.2589 10.9163 19.9274 10.9163C19.5959 10.9163 19.2779 10.7846 19.0435 10.5502C18.8091 10.3158 18.6774 9.99786 18.6774 9.66634V7.16634C18.6774 5.95077 18.1945 4.78498 17.335 3.92543C16.4754 3.06589 15.3097 2.58301 14.0941 2.58301C12.8785 2.58301 11.7127 3.06589 10.8532 3.92543C9.99363 4.78498 9.51074 5.95077 9.51074 7.16634V9.66634C9.51074 9.99786 9.37905 10.3158 9.14463 10.5502C8.9102 10.7846 8.59226 10.9163 8.26074 10.9163C7.92922 10.9163 7.61128 10.7846 7.37686 10.5502C7.14244 10.3158 7.01074 9.99786 7.01074 9.66634V7.16634C7.01074 5.28772 7.75702 3.48605 9.0854 2.15767C10.4138 0.829285 12.2155 0.0830078 14.0941 0.0830078C15.9727 0.0830078 17.7744 0.829285 19.1027 2.15767C20.4311 3.48605 21.1774 5.28772 21.1774 7.16634V9.66634Z"
                  fill="#DC834E" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M26.3305 11.916L27.6639 31.916C27.6973 32.4282 27.6255 32.9419 27.4527 33.4252C27.2798 33.9085 27.0098 34.3513 26.6591 34.7262C26.3085 35.101 25.8847 35.4 25.4139 35.6047C24.9432 35.8093 24.4355 35.9153 23.9222 35.916H4.26552C3.75207 35.9158 3.24414 35.8101 2.77317 35.6057C2.3022 35.4012 1.87822 35.1022 1.52746 34.7272C1.17671 34.3523 0.906665 33.9093 0.734034 33.4257C0.561403 32.9422 0.489867 32.4283 0.523853 31.916L1.85719 11.916C1.92061 10.9668 2.34239 10.0773 3.03711 9.4274C3.73183 8.77755 4.64757 8.41601 5.59885 8.41602H22.5889C23.5401 8.41601 24.4559 8.77755 25.1506 9.4274C25.8453 10.0773 26.2671 10.9668 26.3305 11.916ZM18.2372 15.796C17.8646 16.5793 17.2775 17.2409 16.5442 17.7041C15.8109 18.1673 14.9612 18.4132 14.0939 18.4132C13.2265 18.4132 12.3769 18.1673 11.6435 17.7041C10.9102 17.2409 10.3232 16.5793 9.95052 15.796C9.88004 15.6477 9.78105 15.5148 9.65919 15.4048C9.53734 15.2947 9.395 15.2098 9.24031 15.1548C9.08563 15.0997 8.92162 15.0757 8.75765 15.0841C8.59368 15.0925 8.43297 15.133 8.28469 15.2035C8.1364 15.274 8.00345 15.373 7.89342 15.4948C7.7834 15.6167 7.69845 15.759 7.64343 15.9137C7.58841 16.0684 7.5644 16.2324 7.57277 16.3964C7.58113 16.5604 7.62171 16.7211 7.69219 16.8693C8.26624 18.0814 9.1726 19.1056 10.3059 19.8228C11.4391 20.5401 12.7527 20.9208 14.0939 20.9208C15.435 20.9208 16.7486 20.5401 17.8818 19.8228C19.0151 19.1056 19.9215 18.0814 20.4955 16.8693C20.566 16.7211 20.6066 16.5604 20.6149 16.3964C20.6233 16.2324 20.5993 16.0684 20.5443 15.9137C20.4893 15.759 20.4043 15.6167 20.2943 15.4948C20.1843 15.373 20.0513 15.274 19.903 15.2035C19.7547 15.133 19.594 15.0925 19.4301 15.0841C19.2661 15.0757 19.1021 15.0997 18.9474 15.1548C18.7927 15.2098 18.6504 15.2947 18.5285 15.4048C18.4067 15.5148 18.3077 15.6477 18.2372 15.796Z"
                  fill="#DC834E" />
              </svg>
            </div>
          </button>
        </div>
      </div>
    </nav>

    <section class="banner-section position-relative">
      <div class="banner-section position-relative">
        @if ($whatsappStore->slider_video_banner)
          <div class="banner-slider">
            <div class="banner-slide video-slide">
              <div class="banner-video-wrapper">
                <iframe
                  src="https://www.youtube.com/embed/{{ YoutubeID($whatsappStore->slider_video_banner) }}?autoplay=1&mute=1&loop=1&playlist={{ YoutubeID($whatsappStore->slider_video_banner) }}&controls=0&modestbranding=1&showinfo=0&rel=0"
                  class="banner-video w-100 h-100" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                </iframe>
              </div>
              <div class="bottom-img">
                <img src="{{ asset('assets/img/whatsapp_stores/travel/banner-bottom.png') }}" alt="img"
                  class="w-100 h-100 object-fit-cover" />
              </div>
            </div>

            <div class="banner-slide image-slide">
              <div class="banner-img">
                <img src="{{ $whatsappStore->cover_url }}" class="w-100 h-100 object-fit-cover" alt="banner"
                  loading="lazy" />
              </div>
              <div class="bottom-img">
                <img src="{{ asset('assets/img/whatsapp_stores/travel/banner-bottom.png') }}" alt="img"
                  class="w-100 h-100 object-fit-cover" />
              </div>
            </div>
          </div>
        @else
          <div class="banner-img">
            <img src="{{ $whatsappStore->cover_url }}" class="w-100 h-100 object-fit-cover" alt="banner"
              loading="lazy" />
          </div>
          <div class="bottom-img">
            <img src="{{ asset('assets/img/whatsapp_stores/travel/banner-bottom.png') }}" alt="img"
              class="w-100 h-100 object-fit-cover" />
          </div>
        @endif
      </div>
    </section>

    <section class="category-section position-relative mb-30">
      <h2 class="font-aclonica text-center mb-30">
        <span class="font-dancing">{{ __('messages.whatsapp_stores_templates.choose_your') }}</span> <br />
        {{ __('messages.whatsapp_stores.category') }}
      </h2>
      <div class="position-absolute bottom-img end-0">
        <img src="{{ asset('assets/img/whatsapp_stores/travel/ballon-img.png') }}" alt="img"
          class="w-100 h-100 object-fit-cover" />
      </div>
      <div class="caegory-slider-container">
        <div class="category-slider mb-0">
          @foreach ($whatsappStore->categories as $category)
            <div>
              <a href="{{ route('whatsapp.store.products', ['alias' => $whatsappStore->url_alias, 'category' => $category->id]) }}"
                style="text-decoration: none; color: inherit;">
                <div class="category-item">
                  <div class="category-img mx-auto">
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                      class="w-100 h-100 object-fit-cover rounded-circle" loading="lazy" />
                  </div>
                  <div class="text-center">
                    <h5 class="fs-20 text-black fw-medium text-break">{{ $category->name }}</h5>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>

      @if ($whatsappStore->categories->count() == 0)
        <div class="text-center mb-5 mt-3">
          <h3 class="fs-20 fw-6 mb-0">
            {{ __('messages.whatsapp_stores_templates.category_not_found') }}
          </h3>
        </div>
      @endif
    </section>

    <section class="product-section position-relative">
      <h2 class="font-aclonica text-center mb-30">
        <span class="font-dancing">{{ __('messages.whatsapp_stores_templates.choose_your') }}</span> <br />
        {{ __('messages.whatsapp_stores.package') }}
      </h2>
      <div class="plane-img position-absolute start-0">
        <img src="{{ asset('assets/img/whatsapp_stores/travel/plane.png') }}" alt="img"
          class="w-100 h-100 object-fit-cover" />
      </div>
      <div class="product-main-cards">
        <div class="row row-gap-30">
          @forelse ($whatsappStore->products()->latest()->take(8)->get() as $product)
            <div class="col-sm-6 col-md-4 col-lg-3 d-flex">
              <div class="product-card w-100 d-flex flex-column h-100">
                <div class="product-img flex-shrink-0">
                  <img src="{{ $product->images_url[0] ?? '' }}" alt="{{ $product->name }}"
                    class="w-100 h-100 object-fit-cover product-image" loading="lazy" />
                  <div
                    class="hover-explore d-flex align-items-center position-absolute top-50 start-50 translate-middle">
                    <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}"
                      class="fs-20 fw-semibold primary-text">{{ __('messages.whatsapp_stores.explore') }}</a>
                    <span>
                      <svg width="20" height="14" viewBox="0 0 20 14" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.5 7H17.4993" stroke="#DC834E" stroke-width="2" stroke-miterlimit="10"
                          stroke-linecap="round" />
                        <path d="M12.5 1L18.4997 6.99973L12.5 13" stroke="#DC834E" stroke-width="2"
                          stroke-miterlimit="10" stroke-linecap="round" />
                      </svg>
                    </span>
                  </div>
                </div>
                <div class="card-content flex-grow-1 d-flex flex-column">
                  <input type="hidden" value="{{ $product->category->name }}" class="product-category">
                  <h6 class="fs-18 fw-medium product-name">{{ $product->name }}</h6>
                  <p class="fs-14 fw-medium product-category">{{ $product->category->name }}</p>
                  <div class="flex-grow-1"></div>
                  <div class="card-bottom-section">
                    <div class="card-title mb-3">
                      <div class="d-flex align-items-center gap-2 mt-3">
                        <h5 class="fw-semibold fs-18">
                          <span class="badge rounded-pill text-white px-3 py-2"
                            style="background-color: #faeee6; color: #dc834e!important; border: 1px solid #dc834e;">
                            <span
                              class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                          </span>
                          @if ($product->net_price)
                            <del class="fs-14 fw-semibold text-decoration-line-through ms-2">
                              {{ currencyFormat($product->net_price, 2, $product->currency->currency_code) }}
                            </del>
                          @endif
                        </h5>
                      </div>
                    </div>
                    <div class="line"></div>
                    <div class="card-time button-primary-small">
                      <button data-id="{{ $product->id }}"
                        class="@if ($product->available_stock == 0) disabled @endif btn addToCartBtn">
                        {{ __('messages.whatsapp_stores_templates.book_now') }}
                      </button>
                      <input type="hidden" class="available-stock" value="{{ $product->available_stock }}" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="text-center mb-5 mt-3">
              <h3 class="fs-20 fw-6 mb-0">
                {{ __('messages.whatsapp_stores_templates.product_not_found') }}
              </h3>
            </div>
          @endforelse
        </div>
      </div>
      @if ($whatsappStore->products()->count() > 0)
        <div class="view-more">
          <a href="{{ route('whatsapp.store.products', $whatsappStore->url_alias) }}"
            class="button-primary mx-auto text-decoration-none">
            <button>{{ __('messages.whatsapp_stores_templates.view_more') }}</button>
          </a>
        </div>
      @endif
    </section>
    @if ($business_hours == true)
      @if ($whatsappStore->businessHours->count())
        <div class="businesshour-section">
          <div class="section-heading text-center mb-30">
            <h2 class="position-relative mb-5 text-center font-aclonica">{{ __('messages.business.business_hours') }}
            </h2>
          </div>
          <div class="row row-gap-3 d-flex justify-content-center">
            @php
              $todayWeekName = strtolower(\Carbon\Carbon::now()->rawFormat('D'));
            @endphp
            @php
              $weekFormat = $whatsappStore->week_format ?? 1;

              if ($weekFormat == 2) {
                  $businessDaysTime = collect($businessDaysTime)
                      ->sortKeysUsing(function ($a, $b) {
                          if ($a == 7) {
                              return -1;
                          } // Sunday first
                          if ($b == 7) {
                              return 1;
                          }
                          return $a <=> $b;
                      })
                      ->toArray();
              }
            @endphp
            @foreach ($businessDaysTime as $key => $dayTime)
              <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="businesshour-item position-relative p-3 d-flex gap-3 align-items-center">
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
                  <div class="businesshour-content">
                    <h3 class="fs-18 fw-6 mb-0 text-break">
                      {{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}:
                    </h3>
                    <p class="fs-16 fw-5 mb-0 text-break text-gray-200">
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
        <div class="section-heading text-center mb-30">
          <h2 class="position-relative mb-5 text-center font-aclonica">
            {{ __('messages.whatsapp_stores.our_trending_videos') }}</h2>
        </div>
        <div class="trending-videos-slider" id="trendingVideosSlider">
          @foreach ($whatsappStore->trendingVideo as $video)
            @php
              $videoId = TrendingYoutubeID($video->youtube_link);
              $isShort = strpos($video->youtube_link, '/shorts/') !== false;

              if ($isShort) {
                  $embedParams = "autoplay=1&controls=0&loop=1&playlist={$videoId}&mute=1&modestbranding=1&rel=0";
                  $modalParams = 'autoplay=1&controls=1&modestbranding=1&rel=0';
              } else {
                  $embedParams = "autoplay=1&mute=1&loop=1&playlist={$videoId}&controls=0&modestbranding=0&showinfo=0&rel=0";
                  $modalParams = 'autoplay=1&controls=1&modestbranding=1&showinfo=0&rel=0';
              }
            @endphp
            <div class="trending-video-slide horizontal-videos">
              <div class="video-wrapper">
                <iframe src="https://www.youtube-nocookie.com/embed/{{ $videoId }}?{{ $embedParams }}"
                  class="trending-video" frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  allowfullscreen loading="lazy">
                </iframe>

                <!-- Invisible overlay div for click detection -->
                <div class="video-click-overlay" data-video-id="{{ $videoId }}"
                  data-modal-params="{{ $modalParams }}" title="Click to enlarge video"></div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div id="videoModal" class="video-popup-modal">
        <div class="video-modal-content">
          <span class="video-modal-close">&times;</span>
          <div class="video-modal-container">
            <iframe id="modalVideoFrame" src="" frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen></iframe>
          </div>
        </div>
      </div>
    @endif

    {{-- Sticky Bar Button --}}
    @php
      $shareUrl = $whatsappStoreUrl;
    @endphp
    <div class="btn-section cursor-pointer @if (getLanguage($whatsappStore->default_language) == 'Arabic' ||
            getLanguage($whatsappStore->default_language) == 'Persian') rtl @endif">
      <div class="fixed-btn-section">
        @if (empty($whatsappStore->hide_stickybar))
          <div class="bars-btn whatsapp-store-bars-btn">
            <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
              xmlns="http://www.w3.org/2000/svg">
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
          <div class="sub-btn-div @if (getLanguage($whatsappStore->default_language) == 'Arabic' ||
                  getLanguage($whatsappStore->default_language) == 'Persian') sub-btn-div-left @endif">
            @if (empty($whatsappStore->hide_stickybar))
              <div class="stickyIcon">
                <button type="button"
                  class="whatsapp-store-btn-group whatsapp-store-share whatsapp-store-sticky-btn mb-3 px-2 py-1">
                  <i class="fas fa-share-alt fs-4 pt-0"></i>
                </button>
                @if (!empty($whatsappStore->enable_download_qr_code))
                  <div class="qr-code-image d-none">
                    @if (isset($customQrCode['applySetting']) && $customQrCode['applySetting'] == 1)
                      {!! QrCode::color(
                          $qrcodeColor['qrcodeColor']->red(),
                          $qrcodeColor['qrcodeColor']->green(),
                          $qrcodeColor['qrcodeColor']->blue(),
                      )->backgroundColor(
                              $qrcodeColor['background_color']->red(),
                              $qrcodeColor['background_color']->green(),
                              $qrcodeColor['background_color']->blue(),
                          )->style($customQrCode['style'])->eye($customQrCode['eye_style'])->size($whatsappStore->qr_code_download_size ?? 200)->format('svg')->generate($shareUrl) !!}
                    @else
                      {!! QrCode::size($whatsappStore->qr_code_download_size ?? 200)->format('svg')->generate($shareUrl) !!}
                    @endif
                  </div>
                  <a type="button"
                    class="whatsapp-store-btn-group whatsapp-store-sticky-btn d-flex justify-content-center align-items-center text-decoration-none px-2 mb-3 py-2 whatsapp-store-qr-code-btn"
                    title="{{ __('messages.vcard.qr_code') }}" download="whatsapp_store_qr_code.png">
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
        <div class="modal-content" @if (getLanguage($whatsappStore->default_language) == 'Arabic' ||
                getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
          <div class="">
            <div class="row align-items-center mt-3">
              <div class="col-10 text-center">
                <h5 class="modal-title pl-50">{{ __('messages.whatsapp_stores.share_my_whatsapp_store') }}</h5>
              </div>
              <div class="col-2 p-0">
                <button type="button" aria-label="Close"
                  class="p-3 btn btn-sm btn-icon btn-active-color-danger border-none" data-bs-dismiss="modal">
                  <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                      version="1.1">
                      <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                        fill="#000000">
                        <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
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
                <div class="col-2 mb-3">
                  <i class="fab fa-facebook fa-2x" style="color: #1B95E0"></i>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_facebook') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
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
                <div class="col-2 mb-3">
                  <span><svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 512 512">
                      <path
                        d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                    </svg></span>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_twitter') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
                      <path
                        d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                    </g>
                  </svg>
                </div>
              </div>
            </a>
            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}" target="_blank"
              class="text-decoration-none share" title="Linkedin">
              <div class="row">
                <div class="col-2 mb-3">
                  <i class="fab fa-linkedin fa-2x" style="color: #1B95E0"></i>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_linkedin') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
                      <path
                        d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                    </g>
                  </svg>
                </div>
              </div>
            </a>
            <a href="mailto:?Subject=&Body={{ $shareUrl }}" target="_blank" class="text-decoration-none share"
              title="Email">
              <div class="row">
                <div class="col-2 mb-3">
                  <i class="fas fa-envelope fa-2x" style="color: #191a19  "></i>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_email') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
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
                <div class="col-2 mb-3">
                  <i class="fab fa-pinterest fa-2x" style="color: #bd081c"></i>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_pinterest') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
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
                <div class="col-2 mb-3">
                  <i class="fab fa-reddit fa-2x" style="color: #ff4500"></i>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_reddit') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
                      <path
                        d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                    </g>
                  </svg>
                </div>
              </div>
            </a>
            <a href="https://wa.me/?text={{ $shareUrl }}" target="_blank" class="text-decoration-none share"
              title="Whatsapp">
              <div class="row">
                <div class="col-2 mb-3">
                  <i class="fab fa-whatsapp fa-2x" style="color: limegreen"></i>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_whatsapp') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
                      <path
                        d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                    </g>
                  </svg>
                </div>
              </div>
            </a>
            <a href="https://www.snapchat.com/scan?attachmentUrl={{ $shareUrl }}" target="_blank"
              class="text-decoration-none share" title="Snapchat">
              <div class="row">
                <div class="col-2 mb-3">
                  <svg width="30px" height="30px" viewBox="147.353 39.286 514.631 514.631" version="1.1"
                    id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    xml:space="preserve" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
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
                      <rect x="147.553" y="39.443" style="fill:none;" width="514.231" height="514.23"></rect>
                    </g>
                  </svg>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_snapchat') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
                      <path
                        d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                    </g>
                  </svg>
                </div>
              </div>
            </a>
            <div class="col-12 justify-content-between social-link-modal">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="{{ request()->fullUrl() }}" disabled>
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
      <div class="modal fade" id="newsLetterModal" tabindex="-1" aria-labelledby="newsLetterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog news-modal modal-dialog-centered">
          <div class="modal-content animate-bottom" id="newsLetter-content">
            <div class="newsmodal-header d-flex justify-content-end">
              <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close"
                id="closeNewsLetterModal">
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
                    <input type="email" class="email-input form-control bg-light border-dark text-dark w-100"
                      placeholder="{{ __('messages.form.enter_your_email') }}" name="email"
                      id="emailSubscription" aria-label="Email" aria-describedby="button-addon2">
                  </div>
                  <button class="btn ms-1" type="submit" id="email-send">{{ __('messages.subscribe') }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endif
    @if (isset($enable_pwa) && $enable_pwa == 1 && !isiOSDevice())
      <div class="mt-0">
        <div class="pwa-support d-flex align-items-center justify-content-center">
          <div>
            <h1 class="text-start pwa-heading">{{ __('messages.pwa.add_to_home_screen') }}</h1>
            <p class="text-start pwa-text text-dark fs-16 fw-5">{{ __('messages.pwa.pwa_description') }} </p>
            <div class="text-end d-flex">
              <button id="installPwaBtn" class="pwa-install-button w-50 mb-1 btn">{{ __('messages.pwa.install') }}
              </button>
              <button
                class= "pwa-cancel-button w-50  pwa-close btn btn-secondary mb-1 {{ getLocalLanguage() == 'ar' || getLocalLanguage() == 'fa' ? 'me-2' : 'ms-2' }}">{{ __('messages.common.cancel') }}</button>
            </div>
          </div>
        </div>
      </div>
    @endif

    @include('whatsapp_stores.templates.order_modal')
    @include('whatsapp_stores.templates.travel.cart_modal')
    <div class="bottom-bg-img">
      <img src="{{ asset('assets/img/whatsapp_stores/travel/bg-bottom-img.png') }}" alt="img"
        class="w-100 h-100 object-fit-cover" />
    </div>
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
                <a href="{{ route('whatsapp.store.show-privacy-policy', $whatsappStore->url_alias) }}"
                  target="_blank" class="text-decoration-none text-white footer-link-hover">
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
                <i class="fa-solid fa-phone"></i> +{{ $whatsappStore->region_code }}
                {{ $whatsappStore->whatsapp_no }}
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
    let userlanguage = "{{ getLanguage($whatsappStore->default_language) }}";
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
    let templateName = "travel";
  </script>
  <script>
    let defaultCountryCodeValue = "{{ getSuperAdminSettingValue('default_country_code') }}"
  </script>
  <script>
    const getCookieUrl = "{{ route('whatsapp.store.getCookie') }}";
    const emailSubscriptionUrl =
      "{{ route('whatsapp.store.emailSubscriprion-store', ['alias' => $whatsappStore->url_alias]) }}";
  </script>
  <script>
    $(".category-slider").slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 5,
      slidesToScroll: 1,
      autoplay: true,
      arrows: false,
      rtl: isRtl,
      responsive: [{
          breakpoint: 1199,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
          },
        },
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
          },
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
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
    $(document).ready(function() {
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
        responsive: [{
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
      const modalVideoSrc =
        `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1&controls=1&showinfo=1&enablejsapi=1`;

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
</body>

</html>
