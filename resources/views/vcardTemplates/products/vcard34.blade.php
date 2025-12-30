<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  @if (checkFeature('seo'))
    @if ($vcard->meta_description)
      <meta name="description" content="{{ $vcard->meta_description }}">
    @endif
    @if ($vcard->meta_keyword)
      <meta name="keywords" content="{{ $vcard->meta_keyword }}">
    @endif
  @else
    <meta name="description" content="{{ strip_tags($vcard->description) }}">
    <meta name="keywords" content="">
  @endif
  <meta property="og:image"
    content="{{ $vcard->cover_type == App\Models\Vcard::VIDEO || $vcard->cover_type == App\Models\Vcard::YOUTUBE_link ? $vcard->profile_url : $vcard->cover_url }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @if (checkFeature('seo') && $vcard->site_title && $vcard->home_title)
    <title>{{ $vcard->home_title }} | {{ $vcard->site_title }}</title>
  @else
    <title>{{ $vcard->name }} | {{ getAppName() }}</title>
  @endif

  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicon -->
  <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">

  <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
  <link rel="stylesheet" href="{{ mix('assets/css/vcard34.css') }}">

  {{-- google font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  @if (checkFeature('custom-fonts') && $vcard->font_family)
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family={{ $vcard->font_family }}">
  @endif
  @if ($vcard->font_family || $vcard->font_size || $vcard->custom_css)
    <style>
      @if (checkFeature('custom-fonts'))
        @if ($vcard->font_family)
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
            font-family: {{ $vcard->font_family }} !important;
          }

        @endif
        @if ($vcard->font_size)
          div>h4 {
            font-size: {{ $vcard->font_size }}px !important;
          }
        @endif
      @endif

      @if (isset(checkFeature('advanced')->custom_css))
        {!! $vcard->custom_css !!}
      @endif
    </style>
  @endif
</head>

<body>
  @php
    $animations = [
        ['top' => '5%', 'left' => '2%', 'size' => '40px', 'animation' => 'zoomOut 5s ease-in-out infinite'],
        ['top' => '25%', 'left' => '2%', 'size' => '70px', 'animation' => 'zoomIn'],
        ['top' => '45%', 'left' => '2%', 'size' => '50px', 'animation' => 'zoomOut'],
        ['top' => '65%', 'left' => '2%', 'size' => '80px', 'animation' => 'zoomIn'],
        ['top' => '85%', 'left' => '2%', 'size' => '60px', 'animation' => 'zoomOut'],
        ['top' => '10%', 'left' => '14%', 'size' => '70px', 'animation' => 'zoomIn'],
        ['top' => '30%', 'left' => '14%', 'size' => '40px', 'animation' => 'zoomOut'],
        ['top' => '50%', 'left' => '14%', 'size' => '80px', 'animation' => 'zoomIn'],
        ['top' => '70%', 'left' => '14%', 'size' => '50px', 'animation' => 'zoomOut'],
        ['top' => '90%', 'left' => '14%', 'size' => '70px', 'animation' => 'zoomIn'],
        ['top' => '5%', 'left' => '25%', 'size' => '40px', 'animation' => 'zoomOut'],
        ['top' => '25%', 'left' => '25%', 'size' => '70px', 'animation' => 'zoomIn'],
        ['top' => '45%', 'left' => '25%', 'size' => '50px', 'animation' => 'zoomOut'],
        ['top' => '65%', 'left' => '25%', 'size' => '80px', 'animation' => 'zoomIn'],
        ['top' => '85%', 'left' => '25%', 'size' => '60px', 'animation' => 'zoomOut'],
        ['top' => '5%', 'left' => '71%', 'size' => '40px', 'animation' => 'zoomIn'],
        ['top' => '25%', 'left' => '71%', 'size' => '70px', 'animation' => 'zoomOut'],
        ['top' => '45%', 'left' => '71%', 'size' => '50px', 'animation' => 'zoomIn'],
        ['top' => '65%', 'left' => '71%', 'size' => '80px', 'animation' => 'zoomOut'],
        ['top' => '85%', 'left' => '71%', 'size' => '60px', 'animation' => 'zoomIn'],
        ['top' => '10%', 'left' => '82%', 'size' => '70px', 'animation' => 'zoomOut'],
        ['top' => '30%', 'left' => '82%', 'size' => '40px', 'animation' => 'zoomIn'],
        ['top' => '50%', 'left' => '82%', 'size' => '80px', 'animation' => 'zoomOut'],
        ['top' => '70%', 'left' => '82%', 'size' => '50px', 'animation' => 'zoomIn'],
        ['top' => '90%', 'left' => '82%', 'size' => '70px', 'animation' => 'zoomOut'],
        ['top' => '5%', 'left' => '94%', 'size' => '40px', 'animation' => 'zoomIn'],
        ['top' => '25%', 'left' => '94%', 'size' => '70px', 'animation' => 'zoomOut'],
        ['top' => '45%', 'left' => '94%', 'size' => '50px', 'animation' => 'zoomIn'],
        ['top' => '65%', 'left' => '94%', 'size' => '80px', 'animation' => 'zoomOut'],
        ['top' => '85%', 'left' => '94%', 'size' => '60px', 'animation' => 'zoomIn'],
    ];
  @endphp
  <div class="body-animated-background w-100 overflow-hidden position-fixed" style="height:100vh;">
    @foreach ($animations as $anim)
      <lottie-player src="{{ asset('assets/img/vcard34/body-animated-vector.json') }}" background="transparent"
        speed="1" loop autoplay class="position-absolute"
        style="top: {{ $anim['top'] }}; left: {{ $anim['left'] }}; width: {{ $anim['size'] }}; height: {{ $anim['size'] }};    animation: {{ $anim['animation'] }} 5s ease-in-out infinite; opacity:0.5; ">
      </lottie-player>
    @endforeach
  </div>
  <div class="container p-0">
    <div class="vcard-thirtyfour main-content bg-light w-100 mx-auto content-blur allSection collapse show">
      <div class="vcard-one__product py-3 mt-0 px-30">
        <div class="d-flex gap-3 align-items-center justify-content-between mb-8"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div>
            <h4 class="product-heading mb-0">{{ __('messages.vcard.products') }}</h4>
          </div>
          <div class="text-center">
            <a class="back-btn text-decoration-none d-block" href="{{ $vcardUrl }}"
              role="button">{{ __('messages.common.back') }}</a>
          </div>
        </div>
        <div class="product-slider">
          @foreach ($vcard->products as $product)
            <div>
              <div class="product-card card mb-7 bg-transparent">
                <div class="clip-img">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="49" viewBox="0 0 20 49"
                    fill="none">
                    <path d="M5.09042 13.5243L3.45197 13.5243L3.45197 26.0779L5.06511 26.0779L5.09042 13.5243Z"
                      fill="#ffffff" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M8.15127 0.0176844C6.15352 0.0218675 4.11638 0.831224 2.70172 2.18386C1.2239 3.59645 0.214504 5.55687 0.221679 7.85536L0.221997 12.1004C0.234226 16.7896 0.269521 21.5665 0.269484 26.0779C0.26946 29.038 0.243326 31.8394 0.223678 34.5825C0.206523 36.9774 0.242457 35.7069 0.230447 37.8219L1.85028 37.8219C1.84327 35.0027 1.80612 35.4422 1.79817 32.1528C1.79339 30.1767 1.79851 28.1465 1.80725 26.079C1.82644 21.5404 1.86308 16.822 1.85076 12.1004L1.85076 7.85536C1.84457 5.92203 2.57534 4.35576 3.77831 3.2052C5.11719 1.92555 6.91618 1.46691 8.15616 1.46431L8.16224 1.4643C8.73462 1.4631 10.7336 1.55297 12.4596 2.76252C14.0582 3.88262 14.8712 5.58611 14.8757 7.82479C14.8867 11.3178 14.9068 18.487 14.9273 26.0879L16.4464 26.0889C16.4259 18.4865 16.4058 11.3152 16.3947 7.82161C16.3877 4.43055 14.7405 2.5648 13.3591 1.59716C11.9422 0.60403 9.99808 0.0133406 8.15887 0.0171917L8.15127 0.0176844Z"
                      fill="#ffffff" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M1.85076 12.1004L1.85076 7.85536C1.84457 5.92203 2.57534 4.35576 3.77831 3.2052C5.11719 1.92555 6.91618 1.46691 8.15616 1.46431L8.16224 1.4643C8.73462 1.4631 10.7336 1.55297 12.4596 2.76252C14.0582 3.88262 14.8712 5.58611 14.8757 7.82479C14.8867 11.3178 14.9068 18.487 14.9273 26.0879L1.80725 26.079C1.82644 21.5404 1.86308 16.822 1.85076 12.1004ZM5.09042 13.5243L3.45197 13.5243C3.45197 13.5243 3.43611 20.0874 3.45197 26.0779L5.06511 26.0779L5.09042 13.5243Z"
                      fill="#191919" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M16.9953 45.4436C15.2938 47.2184 12.8332 48.29 10.413 48.3116L10.4038 48.3123C8.1756 48.3322 5.81487 47.5778 4.08922 46.2944C2.40685 45.044 0.27235 42.6085 0.232811 38.1876C0.20613 35.5018 0.243705 31.1507 0.259697 26C0.270824 22.416 0.271502 18.4448 0.23281 14.3781L1.85264 14.3781C1.94692 24.2873 1.8074 33.6338 1.85264 38.1876C1.87852 41.1062 3.22143 43.3205 5.16835 44.7679C7.2704 46.3309 9.69304 46.4319 10.3865 46.4257L10.3938 46.4256C11.896 46.4123 14.0713 45.7998 15.6817 44.1207C17.1286 42.611 18.0655 40.5626 18.0404 38.0421L18.0404 32.5078C17.9967 27.8748 18.0772 22.914 18.0502 18.3837C18.0431 17.1901 18.0569 14.7022 18.0496 13.5243L19.6701 13.5243C19.7026 17.9899 19.625 24.2917 19.6693 28.9126C19.6809 30.1299 19.6586 31.2895 19.6701 32.5078L19.6695 38.0421C19.6992 41.0386 18.7728 43.59 16.9953 45.4436Z"
                      fill="#ffffff" />
                  </svg>
                </div>
                <div class="product-img card-img">
                  <a @if ($product->product_url) href="{{ $product->product_url }}" @endif target="_blank"
                    class="text-decoration-none fs-6">
                    <div
                      class=" {{ $product->media->count() < 2 ? 'd-flex justify-content-center' : '' }} product-img-slider">
                      @foreach ($product->media as $media)
                        <div>
                          <div>
                            <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}"
                              class="text-center object-fit-contain w-100" height="208px" loading="lazy" />
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </a>
                </div>
                <div class="card-body">
                  <div class="product-desc d-flex justify-content-between align-items-center mb-2"
                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <h3 class="text-white fs-18 fw-5 mb-0 me-2">{{ $product->name }}</h3>
                    <div class="product-amount fw-bold fs-18">
                      @if ($product->currency_id && $product->price)
                        <span
                          class="fs-18 fw-6 text-primary  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                      @elseif($product->price)
                        <span
                          class="fs-18 fw-6 text-primary product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                      @endif
                    </div>
                  </div>
                  <p class="fs-14 text-gray-200 mb-2">{{ $product->description }}</p>
                  @if (!empty($product->price))
                    <div class="text-center">
                      <button class="buy-product"
                        data-id="{{ $product->id }}">{{ __('messages.subscription.buy_now') }}</button>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  @include('vcardTemplates.product-buy')
  <script src="https://js.stripe.com/v3/"></script>
  <script type="text/javascript" src="{{ asset('assets/js/front-third-party.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
  <script>
    @if (checkFeature('seo') && $vcard->google_analytics)
      {!! $vcard->google_analytics !!}
    @endif

    @if (isset(checkFeature('advanced')->custom_js) && $vcard->custom_js)
      {!! $vcard->custom_js !!}
    @endif
  </script>
  @php
    $setting = \App\Models\UserSetting::where('user_id', $vcard->tenant->user->id)
        ->where('key', 'stripe_key')
        ->first();
  @endphp

  <script>
    let stripe = '';
    @if (!empty($setting) && !empty($setting->value))
      stripe = Stripe('{{ $setting->value }}');
    @endif
    let isEdit = false;
    let password = "{{ isset(checkFeature('advanced')->password) && !empty($vcard->password) }}";
    let passwordUrl = "{{ route('vcard.password', $vcard->id) }}";
    let enquiryUrl = "{{ route('enquiry.store', ['vcard' => $vcard->id, 'alias' => $vcard->url_alias]) }}";
    let appointmentUrl = "{{ route('appointment.store', ['vcard' => $vcard->id, 'alias' => $vcard->url_alias]) }}";
    let paypalUrl = "{{ route('paypal.init') }}";
    let slotUrl = "{{ route('appointment-session-time', $vcard->url_alias) }}";
    let appUrl = "{{ config('app.url') }}";
    let vcardId = {{ $vcard->id }};
    let vcardAlias = "{{ $vcard->url_alias }}";
    let languageChange = "{{ url('language') }}";
    let lang = "{{ checkLanguageSession($vcard->url_alias) }}";
  </script>
  <script>
    let options = {
      'key': "{{ getSelectedPaymentGateway('razorpay_key') }}",
      'amount': 0, //  100 refers to 1
      'currency': 'INR',
      'name': "{{ getAppName() }}",
      'order_id': '',
      'description': '',
      'image': '{{ asset(getAppLogo()) }}', // logo here
      'callback_url': "{{ route('product.razorpay.success') }}",
      'prefill': {
        'email': '', // recipient email here
        'name': '', // recipient name here
        'contact': '', // recipient phone here
      },
      'readonly': {
        'name': 'true',
        'email': 'true',
        'contact': 'true',
      },
      'theme': {
        'color': '#0ea6e9',
      },
      'modal': {
        'ondismiss': function() {
          $('#paymentGatewayModal').modal('hide');
          displayErrorMessage(Lang.get('js.payment_not_complete'));
          setTimeout(function() {
            Turbo.visit(window.location.href);
          }, 1000);
        },
      },
    };
  </script>
  <script>
    $('.product-img-slider').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      autoplay: true,
      slidesToScroll: 1,
      arrows: false,
      responsive: [{
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
          dots: true,
        },
      }, ],
    });
  </script>
  @routes
  <script src="{{ asset('messages.js') }}"></script>
  <script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
  <script src="{{ mix('assets/js/custom/custom.js') }}"></script>
  <script src="{{ mix('assets/js/vcards/vcard-view.js') }}"></script>
  <script src="{{ mix('assets/js/lightbox.js') }}"></script>
</body>

</html>
