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
  <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/home_decor.css') }}" />
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
  <div class="main-content mx-auto w-100 d-flex flex-column justify-content-between position-relative"
    @if (getLanguage($whatsappStore->default_language) == 'Arabic' ||
            getLanguage($whatsappStore->default_language) == 'Persian') dir="rtl" @endif>
    <div class="position-relative">
      <div class="position-sticky top-0 nav-top w-100 px-50 z-3">
        <nav class="navbar navbar-expand-lg w-100" id="header">
          <div class="container-fluid p-0">
            <div class="d-flex align-items-center gap-2 gap-sm-3">
              <a class="navbar-brand p-1 m-0" href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
                <img src="{{ $whatsappStore->logo_url }}" alt="logo" class="w-100 h-100 object-fit-cover" />
              </a>
              <span class="fw-bold fs-18 text-black"><a
                  href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}"
                  style="color: #212529 ">{{ $whatsappStore->store_name }}</a></span>
            </div>
            <div class="d-flex align-items-center gap-lg-4 gap-sm-3 gap-2">
              <div class="language-dropdown position-relative">
                <button class="dropdown-btn position-relative text-black" id="dropdownMenuButton"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  @if (array_key_exists(checkLanguageSession($whatsappStore->url_alias), \App\Models\User::FLAG))
                    <img class="flag" alt="flag"
                      src="{{ asset(\App\Models\User::FLAG[getLanguageIsoCode($whatsappStore->default_language) ?? 'en']) }}"
                      loading="lazy" />
                  @endif
                  {{ strtoupper(getLanguageIsoCode($whatsappStore->default_language) ?? 'en') }}
                </button>
                <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-arrow" width="30" height="30"
                  viewBox="0 0 30 30" fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M6.61626 10.3665C6.38192 10.6009 6.25027 10.9188 6.25027 11.2502C6.25027 11.5817 6.38192 11.8996 6.61626 12.134L14.1163 19.634C14.3507 19.8683 14.6686 20 15 20C15.3315 20 15.6493 19.8683 15.8838 19.634L23.3838 12.134C23.6115 11.8982 23.7375 11.5825 23.7346 11.2547C23.7318 10.927 23.6003 10.6135 23.3685 10.3817C23.1368 10.1499 22.8233 10.0185 22.4955 10.0156C22.1678 10.0128 21.852 10.1388 21.6163 10.3665L15 16.9827L8.38376 10.3665C8.14935 10.1321 7.83146 10.0005 7.50001 10.0005C7.16855 10.0005 6.85067 10.1321 6.61626 10.3665Z"
                    fill="black" />
                </svg>
                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
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
              {{-- Add to card button --}}
              <button class="add-to-cart-btn d-flex align-items-center justify-content-center position-relative"
                id="addToCartViewBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="41" height="40" viewBox="0 0 41 40"
                  fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M27.1301 11.6667C27.1301 11.9982 26.9984 12.3161 26.764 12.5505C26.5296 12.785 26.2116 12.9167 25.8801 12.9167C25.5486 12.9167 25.2306 12.785 24.9962 12.5505C24.7618 12.3161 24.6301 11.9982 24.6301 11.6667V9.16666C24.6301 7.95109 24.1472 6.7853 23.2877 5.92576C22.4281 5.06621 21.2623 4.58333 20.0468 4.58333C18.8312 4.58333 17.6654 5.06621 16.8059 5.92576C15.9463 6.7853 15.4634 7.95109 15.4634 9.16666V11.6667C15.4634 11.9982 15.3317 12.3161 15.0973 12.5505C14.8629 12.785 14.545 12.9167 14.2134 12.9167C13.8819 12.9167 13.564 12.785 13.3296 12.5505C13.0951 12.3161 12.9634 11.9982 12.9634 11.6667V9.16666C12.9634 7.28804 13.7097 5.48637 15.0381 4.15799C16.3665 2.82961 18.1682 2.08333 20.0468 2.08333C21.9254 2.08333 23.7271 2.82961 25.0554 4.15799C26.3838 5.48637 27.1301 7.28804 27.1301 9.16666V11.6667Z"
                    fill="white" />
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M32.2835 13.9167L33.6168 33.9167C33.6503 34.4289 33.5784 34.9425 33.4056 35.4258C33.2328 35.9092 32.9627 36.352 32.6121 36.7268C32.2614 37.1017 31.8376 37.4007 31.3669 37.6053C30.8961 37.81 30.3884 37.9159 29.8751 37.9167H10.2185C9.70502 37.9164 9.19708 37.8108 8.72611 37.6063C8.25514 37.4018 7.83116 37.1028 7.48041 36.7279C7.12966 36.3529 6.85961 35.9099 6.68698 35.4264C6.51435 34.9428 6.44281 34.429 6.4768 33.9167L7.81013 13.9167C7.87355 12.9675 8.29533 12.0779 8.99005 11.428C9.68477 10.7782 10.6005 10.4167 11.5518 10.4167H28.5418C29.4931 10.4167 30.4088 10.7782 31.1035 11.428C31.7983 12.0779 32.22 12.9675 32.2835 13.9167ZM24.1901 17.7967C23.8175 18.5799 23.2305 19.2415 22.4971 19.7047C21.7638 20.1679 20.9142 20.4138 20.0468 20.4138C19.1794 20.4138 18.3298 20.1679 17.5965 19.7047C16.8631 19.2415 16.2761 18.5799 15.9035 17.7967C15.833 17.6484 15.734 17.5154 15.6121 17.4054C15.4903 17.2954 15.3479 17.2104 15.1933 17.1554C15.0386 17.1004 14.8746 17.0764 14.7106 17.0847C14.5466 17.0931 14.3859 17.1337 14.2376 17.2042C14.0893 17.2746 13.9564 17.3736 13.8464 17.4955C13.7363 17.6173 13.6514 17.7597 13.5964 17.9144C13.5414 18.069 13.5173 18.2331 13.5257 18.397C13.5341 18.561 13.5747 18.7217 13.6451 18.87C14.2192 20.0821 15.1255 21.1063 16.2588 21.8235C17.3921 22.5407 18.7056 22.9214 20.0468 22.9214C21.3879 22.9214 22.7015 22.5407 23.8348 21.8235C24.9681 21.1063 25.8744 20.0821 26.4485 18.87C26.5189 18.7217 26.5595 18.561 26.5679 18.397C26.5762 18.2331 26.5522 18.069 26.4972 17.9144C26.4422 17.7597 26.3573 17.6173 26.2472 17.4955C26.1372 17.3736 26.0042 17.2746 25.856 17.2042C25.7077 17.1337 25.547 17.0931 25.383 17.0847C25.219 17.0764 25.055 17.1004 24.9003 17.1554C24.7456 17.2104 24.6033 17.2954 24.4815 17.4054C24.3596 17.5154 24.2606 17.6484 24.1901 17.7967Z"
                    fill="white" />
                </svg>
                <div class="position-absolute product-count-badge count-product  badge rounded-pill bg-danger">
                </div>
              </button>
            </div>
          </div>
        </nav>
      </div>
      <div class="item-details-section px-50 mb-30">
        <div class="item-details-card overflow-hidden position-relative">
          <div class="row row-gap-4">
            <div class="col-lg-6 mb-40">
              <div class="row flex-sm-row flex-column">
                <div class="col-lg-9 col-sm-10 mb-4 mb-sm-0">
                  <div class="slider-for">
                    @foreach ($product->images_url as $image)
                      <div>
                        <div class="details-img h-100 w-100">
                          <img src="{{ $image }}" alt="items" class="w-100 h-100 object-fit-contain" />
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
                <div class="col-lg-3 col-sm-2 left-slider">
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
              </div>
            </div>
            <div class="col-lg-6">
              <div class="details ps-0 ps-lg-3">
                <h4 class="fs-30 fw-6 mb-3 text-black product-name">{{ $product->name }}</h4>
                <input type="hidden" value="{{ $product->available_stock }}" class="available-stock">
                <input type="hidden" value="{{ $product->category->name }}" class="product-category">
                <input type="hidden" value="{{ $product->images_url[0] ?? '' }}" class="product-image">

                <div class="d-flex align-items-center gap-4 row-gap-2 flex-wrap ">
                  <div>
                    <p class="fs-30 fw-semibold mb-0 lh-sm text-primary mb-30">
                      @if ($product->net_price)
                        <del class="fs-18 fw-6 text-gray-200">{{ $product->currency->currency_icon }}
                          {{ $product->net_price }}</del>
                      @endif
                    <div class="d-flex align-content-center">
                      <p class="d-flex align-items-center align-content-center">
                        <span
                          class="currency_icon selling_price fs-30 fw-semibold">{{ currencyFormat($product->selling_price, 2, $product->currency->currency_code) }}</span>
                        @if ($product->available_stock == 0)
                          <span
                            class="badge badge-danger bg-danger text-sm out-of-stock-text mt-0 ms-2">{{ __('messages.whatsapp_stores.out_of_stock') }}</span>
                        @endif
                      </p>
                    </div>
                    <p class="fs-20 fw-semibold text-gray mb-10 lh-sm">
                      {{ __('messages.whatsapp_stores_templates.description') }}</p>
                    <p class="fs-18 text-gray mb-3 fw-normal">{!! $product->description !!}</p>
                    </p>
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  @if ($product->available_stock != 0)
                    <button
                      class="btn btn-primary add-to-cart-btn d-flex justify-content-center align-items-center w-100 fs-18 gap-2 addToCartBtn"
                      data-id="{{ $product->id }}">
                      <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                          fill="none">
                          <path
                            d="M4.06864 11.7857L6.75321 23.5389C6.8827 24.1133 7.20391 24.6265 7.66397 24.994C8.12403 25.3615 8.69552 25.5614 9.28435 25.5609H15.5766C15.804 25.5609 16.022 25.4706 16.1827 25.3098C16.3435 25.1491 16.4338 24.931 16.4338 24.7037C16.4338 24.4764 16.3435 24.2584 16.1827 24.0976C16.022 23.9369 15.804 23.8466 15.5766 23.8466H9.28435C8.87292 23.8466 8.51807 23.5603 8.42378 23.154L5.7375 11.3974C5.70906 11.2683 5.70992 11.1345 5.74001 11.0058C5.7701 10.8771 5.82866 10.7567 5.91138 10.6536C5.99409 10.5505 6.09887 10.4672 6.218 10.41C6.33713 10.3527 6.46759 10.3228 6.59978 10.3226H8.78378V12.3309C8.78378 12.5582 8.87409 12.7762 9.03483 12.9369C9.19558 13.0977 9.4136 13.188 9.64092 13.188C9.86825 13.188 10.0863 13.0977 10.247 12.9369C10.4078 12.7762 10.4981 12.5582 10.4981 12.3309V10.3217H20.1101V12.3309C20.1101 12.5582 20.2004 12.7762 20.3611 12.9369C20.5219 13.0977 20.7399 13.188 20.9672 13.188C21.1945 13.188 21.4126 13.0977 21.5733 12.9369C21.734 12.7762 21.8244 12.5582 21.8244 12.3309V10.3217H24.0084C24.1412 10.3219 24.2723 10.3521 24.3919 10.4099C24.5115 10.4678 24.6166 10.5518 24.6992 10.6558C24.7819 10.7598 24.8401 10.8811 24.8695 11.0107C24.8989 11.1403 24.8987 11.2748 24.8689 11.4043L22.9146 19.956C22.8896 20.0657 22.8864 20.1794 22.9053 20.2903C22.9241 20.4013 22.9647 20.5075 23.0246 20.6028C23.0845 20.6981 23.1625 20.7807 23.2543 20.8458C23.3462 20.911 23.4499 20.9574 23.5596 20.9824C23.6694 21.0075 23.783 21.0107 23.894 20.9918C24.0049 20.9729 24.1111 20.9324 24.2064 20.8725C24.3017 20.8126 24.3843 20.7345 24.4495 20.6427C24.5146 20.5509 24.561 20.4472 24.5861 20.3374L26.5378 11.7917C26.6282 11.4129 26.6312 11.0184 26.5465 10.6382C26.4619 10.258 26.2918 9.90213 26.0492 9.59743C25.8066 9.28838 25.4969 9.03862 25.1434 8.86708C24.79 8.69555 24.4021 8.60676 24.0092 8.60743H21.7532C21.3075 5.44457 18.5886 3 15.3041 3C12.0195 3 9.3015 5.44371 8.85492 8.60743H6.59978C5.80007 8.60743 5.05692 8.96829 4.55978 9.59743C4.31745 9.90112 4.14732 10.2559 4.06223 10.635C3.97715 11.0141 3.97934 11.4076 4.06864 11.7857ZM15.3041 4.71429C16.4197 4.71598 17.5 5.10517 18.3604 5.8153C19.2208 6.52543 19.8077 7.5124 20.0209 8.60743H10.5872C10.8004 7.5124 11.3874 6.52543 12.2477 5.8153C13.1081 5.10517 14.1885 4.71598 15.3041 4.71429Z"
                            fill="currentColor"></path>
                          <path
                            d="M20.9296 20.7959C20.7023 20.7959 20.4843 20.8862 20.3235 21.047C20.1628 21.2077 20.0725 21.4257 20.0725 21.653V23.0408H18.6848C18.4575 23.0408 18.2394 23.1311 18.0787 23.2918C17.9179 23.4526 17.8276 23.6706 17.8276 23.8979C17.8276 24.1252 17.9179 24.3432 18.0787 24.504C18.2394 24.6647 18.4575 24.755 18.6848 24.755H20.0734V26.1428C20.0734 26.3701 20.1637 26.5881 20.3244 26.7488C20.4851 26.9096 20.7032 26.9999 20.9305 26.9999C21.1578 26.9999 21.3758 26.9096 21.5366 26.7488C21.6973 26.5881 21.7876 26.3701 21.7876 26.1428V24.7542H23.1754C23.4027 24.7542 23.6207 24.6639 23.7814 24.5031C23.9422 24.3424 24.0325 24.1244 24.0325 23.897C24.0325 23.6697 23.9422 23.4517 23.7814 23.291C23.6207 23.1302 23.4027 23.0399 23.1754 23.0399H21.7868V21.653C21.7868 21.4257 21.6965 21.2077 21.5357 21.047C21.375 20.8862 21.157 20.7959 20.9296 20.7959Z"
                            fill="currentColor"></path>
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
      </div>
      <div class="recommended-product-section px-50 position-relative">
        <div class="text-center section-heading">
          <svg width="0" height="0">
            <defs>
              <linearGradient id="textGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#19496A" />
                <stop offset="86.28%" stop-color="rgba(25, 73, 106, 0)" />
              </linearGradient>
            </defs>
          </svg>
          <div class="gradient-text-wrapper">
            <svg viewBox="0 0 1000 120" class="gradient-stroke-text">
              <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle">
                {{ __('messages.whatsapp_stores_templates.recommended') }}
              </text>
            </svg>
          </div>
          <h4 class="fw-semibold mb-0">{{ __('messages.whatsapp_stores_templates.recommended_products') }}</h4>
        </div>
        <div class="product-slider">
          @foreach ($whatsappStore->products as $index => $product)
            @php
              $cardClass = 'product-card-' . (($index % 5) + 1);
            @endphp
            <div class="product-col slick-slide">
              <div
                class="product-card d-flex product-card-1 justify-content-between flex-column h-100 {{ $cardClass }}">
                <a class="d-flex justify-content-between flex-column"
                  href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}">
                  <div>
                    <div class="product-img">
                      <img src="{{ $product->images_url[0] ?? '' }}" alt="product-img"
                        class="h-100 w-100 ovject-fit-cover product-image" />
                    </div>
                    <div class="product-details d-flex gap-2 align-items-center justify-content-between mt-3">
                      <div>
                        <h6 class="fs-18 fw-6 text-black mb-2 product-name">{{ $product->name }}</h6>
                        <input type="hidden" class="product-category" value="{{ $product->category->name }}" />
                        <p class="text-black fs-18 fw-semibold mb-0">
                          <span class="currency_icon">{{ $product->currency->currency_icon }}</span>
                          <span class="selling_price">{{ $product->selling_price }}</span>
                          @if ($product->net_price)
                            <del class="fs-14 fw-5 text-gray-200">{{ $product->currency->currency_icon }}
                              {{ $product->net_price }}</del>
                          @endif
                        </p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      @include('whatsapp_stores.templates.order_modal')
      @include('whatsapp_stores.templates.home_decor.cart_modal')
      <div class="position-absolute start-0 bottom-0 body-vector">
        <img src="{{ asset('assets/img/whatsapp_stores/home_decor/body-vector.png') }}" alt="images"
          class="w-100 object-fit-contain" />
      </div>
    </div>
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
            <div class="fw-5 fs-16 text-white">
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
  let templateName = "home_decor";
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
      slidesToScroll: 1,
      autoplay: true,
      rtl: isRtl,
      arrows: false,
      prevArrow: '<button class="slide-arrow prev-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none"><path d="M0 6.99998C0 6.74907 0.0960374 6.49819 0.287709 6.3069L6.32224 0.287199C6.70612 -0.0957328 7.3285 -0.0957328 7.71221 0.287199C8.09593 0.669975 8.09593 1.29071 7.71221 1.67367L2.37252 6.99998L7.71203 12.3263C8.09574 12.7092 8.09574 13.3299 7.71203 13.7127C7.32831 14.0958 6.70593 14.0958 6.32206 13.7127L0.287522 7.69306C0.09582 7.50167 0 7.25079 0 6.99998Z" fill="currentColor" /></svg></button>',
      nextArrow: '<button class="slide-arrow next-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none"><path d="M8 7.00002C8 7.25093 7.90396 7.50181 7.71229 7.6931L1.67776 13.7128C1.29388 14.0957 0.671503 14.0957 0.287787 13.7128C-0.095929 13.33 -0.095929 12.7093 0.287787 12.3263L5.62748 7.00002L0.287973 1.67369C-0.0957425 1.29076 -0.0957425 0.670084 0.287973 0.287339C0.67169 -0.0957785 1.29407 -0.0957785 1.67794 0.287339L7.71248 6.30694C7.90418 6.49833 8 6.74921 8 7.00002Z" fill="currentColor"/></svg></button>',
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
      arrows: false,
      focusOnSelect: true,
      vertical: true,
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
          breakpoint: 576,
          settings: {
            slidesToShow: 4,
            vertical: false,
            dots: true,
          },
        },
        {
          breakpoint: 436,
          settings: {
            slidesToShow: 3,
            vertical: false,
          },
        },
        {
          breakpoint: 360,
          settings: {
            slidesToShow: 2,
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
  const getCookieUrl = "{{ route('whatsapp.store.getCookie') }}";
  const emailSubscriptionUrl =
    "{{ route('whatsapp.store.emailSubscriprion-store', ['alias' => $whatsappStore->url_alias]) }}";
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
