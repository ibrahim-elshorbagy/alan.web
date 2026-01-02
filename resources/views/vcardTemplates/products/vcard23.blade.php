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
  <link rel="stylesheet" href="{{ mix('assets/css/vcard23.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">

  {{-- google font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
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
          em { 
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
  <div class="vcardtwentythree-bg-animation d-flex align-items-end">
    <div class="bg-animation w-100 position-relative h-100 opacity-50">
      <div class="chats">Business Consulting</div>
      <div class="d-flex gap-3 chat-right">
        <span class="chat">Results</span>
        <span class="chat">Success</span>
        <span class="chat">Team</span>
      </div>
      <div class="bg-icon-images">
        <div class="icon icon1">
          <img src=" {{ asset('assets/img/vcard23/commercial.png') }}" />
        </div>
        <div class="icon icon2 rounded-0 bg-transparent">
          <div class="chats position-static">Business Consulting</div>
        </div>
        <div class="icon icon3">
          <img src="{{ asset('assets/img/vcard23/line-chart.png') }}" />
        </div>
        <div class="icon icon4">
          <img src="{{ asset('assets/img/vcard23/idea.png') }}" />
        </div>
      </div>
      <div class="graph1 graph">
        <svg viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">

          <!-- Axis -->
          <line x1="50" y1="350" x2="550" y2="350" stroke="#333" stroke-width="2" />
          <line x1="50" y1="50" x2="50" y2="350" stroke="#333" stroke-width="2" />

          <!-- Bars -->
          <g fill="#665d1e">
            <rect class="bars" x="90" y="200" width="40" height="150" />
            <rect class="bars" x="170" y="120" width="40" height="230" />
            <rect class="bars" x="250" y="160" width="40" height="190" />
            <rect class="bars" x="330" y="80" width="40" height="270" />
            <rect class="bars" x="410" y="140" width="40" height="210" />
          </g>

          <!-- Line chart -->
          <path class="line-path" d="M100 250 L190 170 L270 200 L350 130 L430 180" fill="none" stroke="#665d1e"
            stroke-width="3" />

          <!-- Dots -->
          <g fill="white">
            <circle class="dot" cx="100" cy="250" r="6" />
            <circle class="dot" cx="190" cy="170" r="6" />
            <circle class="dot" cx="270" cy="200" r="6" />
            <circle class="dot" cx="350" cy="130" r="6" />
            <circle class="dot" cx="430" cy="180" r="6" />
          </g>
        </svg>
      </div>
      <div class="float-icon gear">
        <img src="{{ asset('assets/img/vcard23/gear.png') }}" alt="gear">
      </div>
      <!-- Floating avatars -->
      <div class="avatar avatar1">
        <img src="{{ asset('assets/img/vcard23/user-male-circle.png') }}" alt="User 1" />
      </div>
      <div class="avatar avatar2">
        <img src="{{ asset('assets/img/vcard23/user-female-circle.png') }}" alt="User 2" />
      </div>
      <div class="avatar avatar3">
        <img src="{{ asset('assets/img/vcard23/user-group-man-man.png') }}" alt="User 3" />
      </div>

      <!-- Central icon -->
      <div class="center-icon">
        <img src="{{ asset('assets/img/vcard23/teamwork.png') }}" alt="Teamwork" />
      </div>

      <div class="avatar avatar4">
        <img src="{{ asset('assets/img/vcard23/user-female.png') }}" alt="User 2" />
      </div>

      <div class="graph2 graph">
        <svg viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">

          <!-- Axis -->
          <line x1="50" y1="350" x2="550" y2="350" stroke="#333" stroke-width="2" />
          <line x1="50" y1="50" x2="50" y2="350" stroke="#333" stroke-width="2" />

          <!-- Bars -->
          <g fill="#665d1e">
            <rect class="bars" x="90" y="200" width="40" height="150" />
            <rect class="bars" x="170" y="120" width="40" height="230" />
            <rect class="bars" x="250" y="160" width="40" height="190" />
            <rect class="bars" x="330" y="80" width="40" height="270" />
            <rect class="bars" x="410" y="140" width="40" height="210" />
          </g>

          <!-- Line chart -->
          <path class="line-path" d="M100 250 L190 170 L270 200 L350 130 L430 180" fill="none" stroke="#665d1e"
            stroke-width="3" />

          <!-- Dots -->
          <g fill="white">
            <circle class="dot" cx="100" cy="250" r="6" />
            <circle class="dot" cx="190" cy="170" r="6" />
            <circle class="dot" cx="270" cy="200" r="6" />
            <circle class="dot" cx="350" cy="130" r="6" />
            <circle class="dot" cx="430" cy="180" r="6" />
          </g>
        </svg>
      </div>
    </div>
  </div>

  <div class="container p-0">
    <div class="vcard-twentythree  bg-light main-content  w-100 mx-auto content-blur allSection collapse show">
      <div class="vcard-one__product py-3 mt-0">
        <div class="d-flex align-items-cenrter justify-content-between px-4 mb-4"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div>
            <h4 class="product-head mb-0">{{ __('messages.vcard.products') }}</h4>
          </div>
          <div class="product-btn">
            <a class="back-btn text-decoration-none  text-light p-0" href="{{ $vcardUrl }}"
              role="button">{{ __('messages.common.back') }}</a>
          </div>
        </div>
        <div class="container">
          <div class="product-slider">
            @foreach ($vcard->products as $product)
              <div class="">
                <div class="product-card card mb-4">
                  <div class="product-img card-img">
                    <a @if ($product->product_url) href="{{ $product->product_url }}" @endif target="_blank"
                      class="text-decoration-none fs-6 d-flex justify-content-center align-items-center">
                      <div
                        class=" {{ $product->media->count() < 2 ? 'd-flex justify-content-center' : '' }} product-img-slider overflow-hidden">
                        @foreach ($product->media as $media)
                          <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}"
                            class="text-center mt-5 p-2 object-fit-contain rounded-2" height="208px" loading="lazy">
                        @endforeach
                      </div>
                    </a>
                  </div>
                  <div class="card-body p-0">
                    <div class="product-desc d-flex justify-content-between align-items-center py-2 flex-column gap-2"
                      @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                      <div>
                        <h3 class="text-black fs-18 fw-5 mb-2 me-2">{{ $product->name }}</h3>
                        <p class="fs-14 text-dark mb-0">{{ $product->description }}</p>
                      </div>
                      <div class="product-amount  fw-bold fs-18">
                        @if ($product->currency_id && $product->price)
                          <span
                            class="fs-18 fw-6  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                        @elseif($product->price)
                          <span
                            class="fs-18 fw-6  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                        @endif
                      </div>
                    </div>
                    @if (!empty($product->price))
                      <div class="text-center mb-2">
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
  <script src="{{ asset('messages.js?$mixID') }}"></script>
  <script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
  <script src="{{ mix('assets/js/custom/custom.js') }}"></script>
  <script src="{{ mix('assets/js/vcards/vcard-view.js') }}"></script>
  <script src="{{ mix('assets/js/lightbox.js') }}"></script>
</body>

</html>

