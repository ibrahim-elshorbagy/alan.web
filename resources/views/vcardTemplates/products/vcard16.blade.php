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
  <link rel="stylesheet" href="{{ mix('assets/css/vcard16.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
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
          em,
          {
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
  <div class="vcard-sixteen-effect">
    <div id="trianglesContainer"></div>
  </div>
  <div class="container p-0 product-details-page">
    <div class="vcard-sixteen main-content  w-100 mx-auto content-blur allSection collapse show">

      <div class="vcard-one__product py-3 mt-0">
        <div class="d-flex justify-content-between align-items-center gap-2 px-4 mb-4"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div>
            <h4 class="vcard-sixteen-heading">{{ __('messages.vcard.products') }}</h4>
          </div>
          <div>
            <a class="vcard-sixteen-btn text-decoration-none" href="{{ $vcardUrl }}"
              role="button">{{ __('messages.common.back') }}</a>
          </div>
        </div>
        <div class="container px-4">
          <div class="g-4 product-slider overflow-hidden">
            @foreach ($products as $product)
              <div class="d-flex justify-content-center mb-2">
                <a @if ($product->product_url) href="{{ $product->product_url }}" @endif target="_blank"
                  class="text-decoration-none fs-6">
                  <div class="card product-card w-100 h-100">
                    <div
                      class="product-profile {{ $product->media->count() < 2 ? 'd-flex justify-content-center' : '' }} product-img-slider">
                      @foreach ($product->media as $media)
                        <div>
                          <div class="product-card-img">
                            <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}"
                              class="text-center object-fit-contain" height="208px" loading="lazy">
                          </div>
                        </div>
                      @endforeach
                    </div>
                    <div class="product-desc card-body d-flex align-items-center justify-content-between px-0 pb-3"
                      @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                      <div class="product-title">
                        <h3 class="text-primary fs-18  mb-0">{{ $product->name }}</h3>
                        <p class="fs-14 text-gray-300 mb-0"> {{ $product->description }}
                        </p>
                      </div>
                      <div class="product-amount text-primary  fs-18">
                        @if ($product->currency_id && $product->price)
                          <span
                            class="text-dark product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                        @elseif($product->price)
                          <span
                            class="text-dark product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                        @endif
                      </div>
                    </div>
                </a>
                @if (!empty($product->price))
                  <div class="text-center">
                    <button class="send-btn btn-primary buy-product"
                      data-id="{{ $product->id }}">{{ __('messages.subscription.buy_now') }}</button>
                  </div>
                @endif
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

  <script>
    var
      axe = "X",
      numberOfSquare = 25,
      greyMinimum = 210,
      greyMaximum = 245,
      animMin = 2, // Animation durations (in seconds)
      animMax = 8;

    var $tc = $("#trianglesContainer");

    function createTriangles() {
      let w = $tc.width(),
        h = $tc.height(),
        dx;
      let $svg = $('<svg width="' + w + '" height="' + h + '" xmlns="http://www.w3.org/2000/svg">');


      $tc[0].innerHTML = "";

      if (axe = "X")
        dx = w / numberOfSquare;
      else
        dx = h / numberOfSquare;


      for (let i = 0; i < w / dx; i++) {
        for (let j = 0; j < h / dx; j++) {

          let c1 = rdmColor(greyMinimum, greyMaximum);
          let c2 = rdmColor(greyMinimum, greyMaximum);


          let d = [];
          // Middle of the current square, to make triangles from a square
          let middleX = (i * dx + dx / 2),
            middleY = (j * dx + dx / 2);


          d.push('M ' + i * dx + ' ' + j * dx + ' h ' + dx + ' L ' + middleX + ' ' + middleY);
          d.push('M ' + i * dx + ' ' + (j + 1) * dx + ' h ' + dx + ' L ' + middleX + ' ' + middleY);
          d.push('M ' + i * dx + ' ' + j * dx + ' v ' + dx + ' L ' + middleX + ' ' + middleY);
          d.push('M ' + (i + 1) * dx + ' ' + j * dx + ' v ' + dx + ' L ' + middleX + ' ' + middleY);

          d.forEach(function(val, i) {

            let a = '<animate attributeName="fill" repeatCount="indefinite" dur="' + rdmInt(animMin,
              animMax) + 's" values="' + c1 + ';' + c2 + ';' + c1 + '" />';

            $svg[0].innerHTML += ('<path d="' + val + '" fill="' + c1 + '" stroke="' + c1 + '">' + a +
              '</path>');
          });


          $tc.append($svg);
        }
      }

    }

    function rdmInt(min, max) {
      return Math.round(Math.random() * (max - min) + min)
    }

    function rdmColor(min, max) {
      let color = rdmInt(min, max);
      return 'rgb(' + color + ',' + color + ',' + color + ')';
    }

    window.onload = createTriangles();

    $(window).resize(createTriangles);
  </script>
</body>

</html>
