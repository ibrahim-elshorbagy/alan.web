<!DOCTYPE html>
<html lang="en" dir="{{ getLocalLanguage() == 'ar' || getLocalLanguage() == 'fa' ? 'rtl' : 'ltr' }}">

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
  <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/restaurant.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/third-party.css') }}">
  <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
  <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/custom.css') }}" />
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
  <div class="main-content mx-auto w-100 d-flex flex-column justify-content-between position-relative">
    <div>
      <div class="position-relative top-0 header w-100 px-50 z-3">
        <nav class="navbar  navbar-expand-lg w-100" id="header">
          <div class="container-fluid p-0">
            <div class="d-flex align-items-center gap-2 gap-sm-3">
              <a class="navbar-brand p-0 m-0" href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
                <img src="{{ $whatsappStore->logo_url }}" alt="logo" class="w-100 h-100 object-fit-cover" />
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
                <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="8"
                  viewBox="0 0 18 10" fill="none">
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
                            src="{{ asset(\App\Models\User::FLAG[$language->iso_code]) }} " loading="lazy" />
                        @else
                          @if (count($language->media) != 0)
                            <img src="{{ $language->image_url }}" class="me-1" loading="lazy" />
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
                <div
                  class="position-absolute cart-count d-flex align-items-center justify-content-center product-count-badge">
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
      </div>
      <div class="hero-img position-relative">
        @if ($whatsappStore->slider_video_banner)
          <div class="banner-slider">
            <div class="banner-slide video-slide">
              <div class="position-absolute vector-1 vector">
                <img src="{{ asset('assets/img/whatsapp_stores/restaurant/hero-vector-1.png') }}" loading="lazy"
                  alt="images" />
              </div>

              <div class="banner-video-wrapper">
                <iframe
                  src="https://www.youtube.com/embed/{{ YoutubeID($whatsappStore->slider_video_banner) }}?autoplay=1&mute=1&loop=1&playlist={{ YoutubeID($whatsappStore->slider_video_banner) }}&controls=0&modestbranding=1&showinfo=0&rel=0"
                  class="banner-video w-100 h-100 hero-img-vector" frameborder="0" allow="autoplay; encrypted-media"
                  allowfullscreen>
                </iframe>
              </div>
            </div>

            <div class="banner-slide image-slide">
              <div class="position-absolute vector-1 vector">
                <img src="{{ asset('assets/img/whatsapp_stores/restaurant/hero-vector-1.png') }}" loading="lazy"
                  alt="images" />
              </div>

              <div class="banner-img">
                <img src="{{ $whatsappStore->cover_url }}" class="w-100 h-100 object-fit-cover hero-img-vector"
                  alt="banner" loading="lazy" />
              </div>
            </div>
          </div>
        @else
          <div class="banner-img">
            <img src="{{ $whatsappStore->cover_url }}" class="w-100 h-100 object-fit-cover hero-img-vector"
              alt="banner" loading="lazy" />
          </div>
        @endif
      </div>
      <div class="category-section px-50 pt-40px pb-40px position-relative">
        <div class="text-center">
          <h2 class="text-center text-white fs-28 fw-semibold mb-40 section-heading position-relative d-inline-block">
            {{ __('messages.whatsapp_stores_templates.choos_your_category') }}</h2>
        </div>
        <div class="category-slider">
          @foreach ($whatsappStore->categories as $category)
            <a href="{{ route('whatsapp.store.products', ['alias' => $whatsappStore->url_alias, 'category' => $category->id]) }}"
              style="color: #FFFFFF">
              <div>
                <div class="category-box">
                  <div class="category-img mx-auto">
                    <img src="{{ $category->image_url }}" alt="category-img"
                      class="h-100 w-100 object-fit-cover rounded" loading="lazy" />
                  </div>
                  <p class="fw-medium fs-16 text-white text-center">{{ $category->name }}</p>
                </div>
              </div>
            </a>
          @endforeach

        </div>
        @if ($whatsappStore->categories->count() == 0)
          <div class="text-center mb-5 mt-3">
            <h3 class="fs-20 fw-6 mb-0 text-white">
              {{ __('messages.whatsapp_stores_templates.category_not_found') }}</h3>
          </div>
        @endif
      </div>
      <div class="product-section px-50 position-relative">
        <div class="position-absolute vector-2 vector text-end">
          <img src="{{ asset('assets/img/whatsapp_stores/restaurant/vector-2.png') }}" alt="images" />
        </div>
        <div class="text-center">
          <h2 class="text-center text-white fs-28 fw-semibold mb-40 section-heading position-relative d-inline-block">
            {{ __('messages.whatsapp_stores_templates.choose_your_item') }}</h2>
        </div>
        <div class="row row-gap-30px">
          @foreach ($whatsappStore->products()->latest()->take(8)->get() as $product)
            <div class="col-lg-3 col-sm-6">
              <div class="product-card d-flex justify-content-between flex-column h-100">
                <a class="d-flex justify-content-between flex-column"
                  href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}">
                  <div>
                    <div class="product-img">
                      <img src="{{ $product->images_url[0] ?? '' }}" alt="product-img"
                        class="h-100 w-100 ovject-fit-cover  product-image" />
                    </div>
                    <div class="product-details">
                      <input type="hidden" value="{{ $product->category->name }}" class="product-category">
                      <p class="fs-18 fw-normal text-white text-center mb-0 product-name">
                        {{ $product->name }}</p>
                      <p class="text-primary fs-20 fw-semibold text-center mb-4 ">
                        <span
                          class="currency_icon selling_price">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                      </p>
                    </div>
                    <input type="hidden" value="{{ $product->available_stock }}" class="available-stock">
                  </div>
                </a>
                <button
                  class="@if ($product->available_stock == 0) disabled @endif btn btn-primary d-flex justify-content-center align-items-center w-100 mx-auto addToCartBtn"
                  data-id="{{ $product->id }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                    class="me-1">
                    <path
                      d="M13.5264 20.4167C13.5262 21.5727 13.8127 22.7108 14.3605 23.7288C14.9082 24.7469 15.6999 25.6132 16.6647 26.25H4.50225C4.08859 26.2504 3.67958 26.1628 3.30243 25.9929C2.92529 25.8229 2.58865 25.5746 2.31493 25.2645C2.04121 24.9544 1.83667 24.5895 1.71494 24.1941C1.59321 23.7988 1.55706 23.3821 1.60892 22.9717L3.35892 8.97167C3.44705 8.26638 3.78969 7.61755 4.32247 7.14708C4.85524 6.6766 5.54148 6.41687 6.25225 6.41667H7.69308V9.91667C7.69308 10.0714 7.75454 10.2197 7.86394 10.3291C7.97333 10.4385 8.12171 10.5 8.27642 10.5C8.43112 10.5 8.5795 10.4385 8.68889 10.3291C8.79829 10.2197 8.85975 10.0714 8.85975 9.91667V6.41667H15.8597V9.91667C15.8597 10.0714 15.9212 10.2197 16.0306 10.3291C16.14 10.4385 16.2884 10.5 16.4431 10.5C16.5978 10.5 16.7462 10.4385 16.8556 10.3291C16.965 10.2197 17.0264 10.0714 17.0264 9.91667V6.41667H18.4672C19.178 6.41687 19.8643 6.6766 20.397 7.14708C20.9298 7.61755 21.2724 8.26638 21.3606 8.97167L21.9322 13.5567C20.9149 13.3503 19.8645 13.3723 18.8567 13.6212C17.8489 13.8702 16.909 14.3397 16.1048 14.9961C15.3006 15.6524 14.6521 16.4791 14.2062 17.4165C13.7603 18.3539 13.5281 19.3786 13.5264 20.4167ZM17.0264 6.41667H15.8597C15.8597 5.48841 15.491 4.59817 14.8346 3.94179C14.1782 3.28542 13.288 2.91667 12.3597 2.91667C11.4315 2.91667 10.5413 3.28542 9.88487 3.94179C9.2285 4.59817 8.85975 5.48841 8.85975 6.41667H7.69308C7.69308 5.17899 8.18475 3.992 9.05992 3.11683C9.93509 2.24167 11.1221 1.75 12.3597 1.75C13.5974 1.75 14.7844 2.24167 15.6596 3.11683C16.5347 3.992 17.0264 5.17899 17.0264 6.41667Z"
                      fill="currentColor" />
                    <path
                      d="M20.5264 14.5834C19.3727 14.5834 18.2449 14.9255 17.2856 15.5665C16.3263 16.2074 15.5786 17.1185 15.1371 18.1844C14.6956 19.2503 14.5801 20.4232 14.8052 21.5547C15.0303 22.6863 15.5858 23.7257 16.4016 24.5415C17.2174 25.3573 18.2568 25.9129 19.3884 26.138C20.5199 26.363 21.6928 26.2475 22.7587 25.806C23.8246 25.3645 24.7357 24.6168 25.3767 23.6575C26.0176 22.6982 26.3598 21.5704 26.3598 20.4167C26.3581 18.8701 25.7429 17.3874 24.6493 16.2938C23.5557 15.2002 22.073 14.5851 20.5264 14.5834ZM22.2764 21H21.1098V22.1667C21.1098 22.3214 21.0483 22.4698 20.9389 22.5792C20.8295 22.6886 20.6811 22.75 20.5264 22.75C20.3717 22.75 20.2233 22.6886 20.1139 22.5792C20.0045 22.4698 19.9431 22.3214 19.9431 22.1667V21H18.7764C18.6217 21 18.4733 20.9386 18.3639 20.8292C18.2545 20.7198 18.1931 20.5714 18.1931 20.4167C18.1931 20.262 18.2545 20.1136 18.3639 20.0042C18.4733 19.8948 18.6217 19.8334 18.7764 19.8334H19.9431V18.6667C19.9431 18.512 20.0045 18.3636 20.1139 18.2542C20.2233 18.1448 20.3717 18.0834 20.5264 18.0834C20.6811 18.0834 20.8295 18.1448 20.9389 18.2542C21.0483 18.3636 21.1098 18.512 21.1098 18.6667V19.8334H22.2764C22.4311 19.8334 22.5795 19.8948 22.6889 20.0042C22.7983 20.1136 22.8598 20.262 22.8598 20.4167C22.8598 20.5714 22.7983 20.7198 22.6889 20.8292C22.5795 20.9386 22.4311 21 22.2764 21Z"
                      fill="currentColor" />
                  </svg>
                  {{ __('messages.whatsapp_stores_templates.add_to_cart') }}
                </button>
              </div>
            </div>
          @endforeach
          @if ($whatsappStore->products->count() == 0)
            <div class="text-center mb-5 mt-3 text-white">
              <h3 class="fs-20 fw-6 mb-0 text-break">
                {{ __('messages.whatsapp_stores_templates.item_not_added') }}</h3>
            </div>
          @endif
        </div>
      </div>
      @if ($whatsappStore->products->count() > 0)
        <div class="view-more position-relative">
          <div class="position-absolute vector-3 vector">
            <img src="{{ asset('assets/img/whatsapp_stores/restaurant/vector-3.png') }}" alt="images" />
          </div>
          <a href="{{ route('whatsapp.store.products', $whatsappStore->url_alias) }}"
            class="d-block w-100 mb-3 mb-sm-4 mb-lg-5 text-end mx-auto view-more-button fs-20 fw-semibold position-relative">
            <div
              class="view-arrow rounded-circle h-100 w-100 d-flex justify-content-center align-items-center position-absolute">
              <svg xmlns="http://www.w3.org/2000/svg" width="26" height="22" viewBox="0 0 26 22"
                fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M13.7199 0.595177C13.8546 0.423237 14.0185 0.282523 14.2022 0.181083C14.3858 0.0796421 14.5857 0.0194658 14.7903 0.00399616C14.9948 -0.0114735 15.2002 0.0180676 15.3945 0.0909283C15.5888 0.163789 15.7683 0.27854 15.9227 0.428618L25.4659 9.68188C25.6336 9.84473 25.7681 10.0456 25.8602 10.2711C25.9523 10.4965 26 10.7413 26 10.9889C26 11.2365 25.9523 11.4813 25.8602 11.7067C25.7681 11.9322 25.6336 12.1331 25.4659 12.2959L15.9227 21.5492C15.7691 21.7044 15.5892 21.8239 15.3936 21.9008C15.198 21.9777 14.9905 22.0105 14.7834 21.9971C14.5762 21.9837 14.3735 21.9245 14.1872 21.823C14.0009 21.7215 13.8346 21.5796 13.6982 21.4057C13.5618 21.2318 13.4579 21.0294 13.3927 20.8104C13.3275 20.5913 13.3022 20.3599 13.3184 20.1299C13.3345 19.8998 13.3918 19.6756 13.4868 19.4705C13.5819 19.2653 13.7127 19.0833 13.8718 18.9351L20.2783 12.7239H1.56003C1.14628 12.7239 0.749484 12.5411 0.456922 12.2157C0.164359 11.8903 0 11.449 0 10.9889C0 10.5288 0.164359 10.0875 0.456922 9.76208C0.749484 9.4367 1.14628 9.25391 1.56003 9.25391H20.2762L13.8697 3.04266C13.5581 2.74014 13.3672 2.31237 13.3392 1.8534C13.3111 1.39444 13.448 0.94186 13.7199 0.595177Z"
                  fill="currentColor" />
              </svg>

            </div>
            {{ __('messages.whatsapp_stores_templates.view_more') }}
          </a>
        </div>
      @endif
      {{-- Business Hours section --}}
      @if ($business_hours == true)
        @if ($whatsappStore->businessHours->count())
          <div class="businesshour-section px-50 pb-5">
            <div class="text-center">
              <h2
                class="text-center text-white fs-28 fw-semibold mb-40 section-heading position-relative d-inline-block">
                {{ __('messages.business.business_hours') }}</h2>
            </div>

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
            <div class="row row-gap-3 justify-content-center">
              @foreach ($businessDaysTime as $key => $dayTime)
                <div class="col-xl-3 col-lg-4 col-md-6">
                  <div class="businesshour-item d-flex gap-3 align-items-center">
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
                      <h3 class="fs-18 fw-6 mb-0 text-break text-primary">
                        {{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}:
                      </h3>
                      <p class="fs-16 fw-5 mb-0 text-break text-white">
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
          <div class="text-center">
            <h2
              class="text-center text-white fs-28 fw-semibold mb-40 section-heading position-relative d-inline-block">
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
    </div>

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
                    {!! QrCode::size($whatsappStore->qr_code_download_size ?? 200)->format('svg')->generate($shareUrl) !!}
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
                <div class="col-2">
                  <i class="fab fa-facebook fa-2x" style="color: #1B95E0"></i>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_facebook') }}</p>
                </div>
                <div class="col-1 p-1">
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
                <div class="col-2">
                  <span><svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 512 512">
                      <path
                        d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                    </svg></span>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_twitter') }}</p>
                </div>
                <div class="col-1 p-1">
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
                <div class="col-2">
                  <i class="fab fa-linkedin fa-2x" style="color: #1B95E0"></i>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_linkedin') }}</p>
                </div>
                <div class="col-1 p-1">
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
                <div class="col-2">
                  <i class="fas fa-envelope fa-2x" style="color: #191a19  "></i>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_email') }}</p>
                </div>
                <div class="col-1 p-1">
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
                <div class="col-2">
                  <i class="fab fa-pinterest fa-2x" style="color: #bd081c"></i>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_pinterest') }}</p>
                </div>
                <div class="col-1 p-1">
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
                <div class="col-2">
                  <i class="fab fa-reddit fa-2x" style="color: #ff4500"></i>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_reddit') }}</p>
                </div>
                <div class="col-1 p-1">
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
                <div class="col-2">
                  <i class="fab fa-whatsapp fa-2x" style="color: limegreen"></i>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_whatsapp') }}</p>
                </div>
                <div class="col-1 p-1">
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
                <div class="col-2">
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
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_snapchat') }}</p>
                </div>
                <div class="col-1 p-1">
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
                      placeholder="{{ __('messages.form.enter_your_email') }}" name="email" id="emailSubscription"
                      aria-label="Email" aria-describedby="button-addon2">
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
    @include('whatsapp_stores.templates.restaurant.cart_modal')
    <footer class="position-relative">
      <div class="container pt-3">
        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <img src="{{ $whatsappStore->logo_url }}" alt="logo"
                style="width: 50px !important; height: 50px !important;">
            </div>
            <div class="text-white">
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
              <div class="mb-2 text-white">
                <i class="fas fa-map-marker-alt"></i> {{ $whatsappStore->address }}
              </div>
              <div class="text-white">
                <i class="fa-solid fa-phone"></i> +{{ $whatsappStore->region_code }}
                {{ $whatsappStore->whatsapp_no }}
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
  let userlanguage = "{{ getLanguage($whatsappStore->default_language) }}";
  let isRtl = "{{ getLocalLanguage() == 'ar' || getLocalLanguage() == 'fa' ? 'true' : 'false' }}" === "true";
</script>
<script>
  let templateName = "restaurant";
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
      slidesToShow: 6,
      slidesToScroll: 1,
      rtl: isRtl,
      autoplay: true,
      prevArrow: '<button class="slide-arrow prev-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="20" viewBox="0 0 10 20" fill="none"><path d="M8.01843 19.124L0.253456 10.7018C0.16129 10.6016 0.0961597 10.493 0.0580645 10.376C0.0193548 10.259 0 10.1337 0 10C0 9.86631 0.0193548 9.74098 0.0580645 9.62401C0.0961597 9.50704 0.16129 9.39842 0.253456 9.29815L8.01843 0.850923C8.23349 0.616974 8.50231 0.5 8.82489 0.5C9.14747 0.5 9.42396 0.62533 9.65438 0.875989C9.88479 1.12665 10 1.41909 10 1.7533C10 2.08751 9.88479 2.37995 9.65438 2.63061L2.88018 10L9.65438 17.3694C9.86943 17.6033 9.97696 17.8914 9.97696 18.2337C9.97696 18.5766 9.86175 18.8734 9.63134 19.124C9.40092 19.3747 9.1321 19.5 8.82489 19.5C8.51767 19.5 8.24885 19.3747 8.01843 19.124Z" fill="black"/></svg></button>',
      nextArrow: '<button class="slide-arrow next-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="20" viewBox="0 0 10 20" fill="none"><path d="M1.98157 19.124L9.74654 10.7018C9.83871 10.6016 9.90384 10.493 9.94194 10.376C9.98065 10.259 10 10.1337 10 10C10 9.86631 9.98065 9.74098 9.94194 9.62401C9.90384 9.50704 9.83871 9.39842 9.74654 9.29815L1.98157 0.850923C1.76651 0.616974 1.49769 0.5 1.17511 0.5C0.852534 0.5 0.576037 0.62533 0.345622 0.875989C0.115208 1.12665 0 1.41909 0 1.7533C0 2.08751 0.115208 2.37995 0.345622 2.63061L7.11982 10L0.345622 17.3694C0.130569 17.6033 0.0230408 17.8914 0.0230408 18.2337C0.0230408 18.5766 0.138248 18.8734 0.368663 19.124C0.599078 19.3747 0.867895 19.5 1.17511 19.5C1.48233 19.5 1.75115 19.3747 1.98157 19.124Z" fill="black"/></svg></button>',
      responsive: [{
          breakpoint: 1399,
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
          breakpoint: 640,
          settings: {
            slidesToShow: 3,
          },
        },
        {
          breakpoint: 575,
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
  const emailSubscriptionUrl =
    "{{ route('whatsapp.store.emailSubscriprion-store', ['alias' => $whatsappStore->url_alias]) }}";
</script>

</html>
