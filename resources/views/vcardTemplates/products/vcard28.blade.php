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
  <link rel="stylesheet" href="{{ mix('assets/css/vcard28.css') }}">
  {{-- google font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
  @if (checkFeature('custom-fonts') && $vcard->font_family)
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family={{ $vcard->font_family }}">
  @endif
  {{-- @if ($vcard->font_family || $vcard->font_size || $vcard->custom_css)
        <style>
            @if (checkFeature('custom-fonts'))
                @if ($vcard->font_family)
                    body, body *, button, h1, h2, h3, h4, h5, h6, p, div, span, a, input, textarea, select, label, li, ul, ol, table, th, td, blockquote, strong, b, em, i {
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
     @endif --}}
</head>

<body>

  <div class="container p-0">

    <div class="vcard-twentyeight bg-white main-content  w-100 mx-auto content-blur allSection collapse show">
      <div class="vcard-one__product py-3 mt-0">
        <div class="d-flex justify-content-between gap-2 align-items-center px-30 mb-3"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div>
            <h4 class="product-heading mb-0">{{ __('messages.vcard.products') }}</h4>
          </div>
          <div>
            <a class="back-btn text-decoration-none d-block text-white" href="{{ $vcardUrl }}"
              role="button">{{ __('messages.common.back') }}</a>
          </div>
        </div>
        <div class="product-slider">
          @foreach ($vcard->products as $product)
            <div class="px-30">
              <div class="product-card card mb-10">
                <div class="product-img card-img">
                  <a @if ($product->product_url) href="{{ $product->product_url }}" @endif target="_blank"
                    class="text-decoration-none fs-6 d-block w-100 h-100">
                    <div
                      class=" {{ $product->media->count() < 2 ? 'd-block' : '' }} product-img-slider-28 overflow-hidden">
                      @foreach ($product->media as $media)
                        <div>
                          <div class="product-img-height h-100 text-center w-100 mx-auto">
                            <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}"
                              class=" object-fit-contain h-100 w-100" loading="lazy">
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </a>
                </div>
                <div class=" card-body p-0">
                  <div class="product-desc d-flex justify-content-between align-items-center mb-3"
                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <h3 class="text-black fs-18 fw-5 mb-0 me-2">{{ $product->name }}</h3>
                    <div class="product-amount text-primary fw-bold fs-18">
                      @if ($product->currency_id && $product->price)
                        <span
                          class="fs-18 fw-6 text-primary  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                      @elseif($product->price)
                        <span
                          class="fs-18 fw-6 text-purple  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                      @endif
                    </div>
                  </div>
                  <p class="fs-14 text-dark mb-0">{{ $product->description }}</p>
                  @if (!empty($product->price))
                    <div class="mt-3 text-center">
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
  <div class="vcard-twentyeight-effect position-fixed w-100 h-100 top-0 start-0">
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
    $('.product-img-slider-28').slick({
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
    const svgShapes = [`<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 20 20" fill="none">
            <path d="M11.4025 1.14664C9.16811 3.38346 8.84891 7.21802 11.0833 7.21802C13.1581 7.21802 16.1906 1.14664 14.5946 0.188004C13.7966 -0.291315 12.3601 0.188004 11.4025 1.14664Z" fill="#6549C2" fill-opacity="0.5"/>
            <path d="M4.22028 1.94551C2.14546 3.86278 3.10307 7.21802 5.49709 7.21802C6.7739 7.21802 7.89111 5.78006 7.89111 4.02256C7.89111 0.827097 6.1355 -0.131541 4.22028 1.94551Z" fill="#6549C2" fill-opacity="0.5"/>
            <path d="M15.3924 5.7804C12.2004 7.69768 11.7216 10.4138 14.9136 10.4138C17.6269 10.4138 21.2977 6.25972 19.5421 5.14131C18.7441 4.66199 16.9885 4.98154 15.3924 5.7804Z" fill="#6549C2" fill-opacity="0.5"/>
            <path d="M1.02843 9.9343C-0.886789 11.8516 -0.0887816 13.4493 3.10325 14.4079C4.85886 14.8873 6.29528 16.485 6.29528 17.7632C6.29528 19.0414 7.41249 20 8.6893 20C10.2853 20 11.0833 18.2425 11.0833 14.4079C11.0833 9.29521 10.6045 8.81589 6.61448 8.81589C4.06086 8.81589 1.50723 9.29521 1.02843 9.9343Z" fill="#6549C2" fill-opacity="0.5"/>
            <path d="M12.6794 14.5677C12.6794 16.0057 13.7967 16.8045 15.3927 16.485C19.3827 15.6861 19.8615 12.0113 16.0311 12.0113C14.1159 12.0113 12.6794 12.97 12.6794 14.5677Z" fill="#6549C2" fill-opacity="0.5"/>
          </svg>`,
      `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 15 16" fill="none">
            <path d="M2.29995 2.67613C-3.40345 8.468 2.29995 17.1558 10.6649 15.0321C14.4672 14.0668 15.4178 12.7154 14.8474 8.66107C14.4672 5.76513 13.5166 3.25531 12.376 2.86919C8.95392 1.90388 5.15165 5.76513 6.29233 9.04719C7.05279 10.7848 8.57369 11.557 9.71437 10.7848C11.2353 10.0125 11.0452 9.04719 9.33415 7.88882C7.2429 6.53738 7.43301 6.15125 10.0946 6.15125C14.2771 6.15125 14.2771 11.1709 10.2847 12.7154C7.2429 13.8738 1.91973 10.9778 1.91973 7.88882C1.91973 7.11657 3.25052 4.99288 4.96154 3.44838C6.48245 1.71081 7.2429 0.359375 6.29233 0.359375C5.34177 0.359375 3.63075 1.32469 2.29995 2.67613Z" fill="#6549C2" fill-opacity="0.5"/>
          </svg>`,
      `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="18" viewBox="0 0 14 18" fill="none">
            <path d="M4.9 1.23025C2.1 1.57369 0 2.26056 0 2.77571C0 4.49288 9.275 17.2 10.5 17.2C11.9 17.2 14 8.78581 14 3.29086C14 1.40197 12.95 0.199952 11.9 0.199952C10.675 0.371669 7.525 0.88682 4.9 1.23025ZM11.55 6.21005C11.025 7.75551 10.5 10.1595 10.5 11.705C10.5 13.9373 9.625 13.5939 7 10.3313C2.45 4.6646 2.625 3.46258 8.05 3.46258C11.55 3.46258 12.425 4.14945 11.55 6.21005Z" fill="#6549C2" fill-opacity="0.5"/>
        </svg>`,
      `<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 20 20" fill="none">
            <path d="M11.4025 1.14664C9.16811 3.38346 8.84891 7.21802 11.0833 7.21802C13.1581 7.21802 16.1906 1.14664 14.5946 0.188004C13.7966 -0.291315 12.3601 0.188004 11.4025 1.14664Z" fill="#6549C2" fill-opacity="0.5"/>
            <path d="M4.22028 1.94551C2.14546 3.86278 3.10307 7.21802 5.49709 7.21802C6.7739 7.21802 7.89111 5.78006 7.89111 4.02256C7.89111 0.827097 6.1355 -0.131541 4.22028 1.94551Z" fill="#6549C2" fill-opacity="0.5"/>
            <path d="M15.3924 5.7804C12.2004 7.69768 11.7216 10.4138 14.9136 10.4138C17.6269 10.4138 21.2977 6.25972 19.5421 5.14131C18.7441 4.66199 16.9885 4.98154 15.3924 5.7804Z" fill="#6549C2" fill-opacity="0.5"/>
            <path d="M1.02843 9.9343C-0.886789 11.8516 -0.0887816 13.4493 3.10325 14.4079C4.85886 14.8873 6.29528 16.485 6.29528 17.7632C6.29528 19.0414 7.41249 20 8.6893 20C10.2853 20 11.0833 18.2425 11.0833 14.4079C11.0833 9.29521 10.6045 8.81589 6.61448 8.81589C4.06086 8.81589 1.50723 9.29521 1.02843 9.9343Z" fill="#6549C2" fill-opacity="0.5"/>
            <path d="M12.6794 14.5677C12.6794 16.0057 13.7967 16.8045 15.3927 16.485C19.3827 15.6861 19.8615 12.0113 16.0311 12.0113C14.1159 12.0113 12.6794 12.97 12.6794 14.5677Z" fill="#6549C2" fill-opacity="0.5"/>
          </svg>`
    ];

    const container = document.querySelector('.vcard-twentyeight-effect');
    const particles = [];
    const size = 110; // in px
    const count = 60;

    function isOverlapping(x, y, others) {
      return others.some(p => {
        return Math.abs(p.x - x) < size && Math.abs(p.y - y) < size;
      });
    }

    for (let i = 0; i < count; i++) {
      const particle = document.createElement('div');
      particle.className = 'particle-vcard28';
      particle.innerHTML = svgShapes[i % svgShapes.length];
      container.appendChild(particle);

      let x, y, tries = 0;
      do {
        x = Math.random() * (container.clientWidth - size);
        y = Math.random() * (container.clientHeight - size);
        tries++;
        if (tries > 1000) break;
      } while (isOverlapping(x, y, particles));

      const speedX = (Math.random() - 0.5) * 1.2;
      const speedY = (Math.random() - 0.5) * 1.2;

      particles.push({
        el: particle,
        x,
        y,
        speedX,
        speedY
      });
    }

    function animate() {
      for (let i = 0; i < particles.length; i++) {
        const p = particles[i];

        p.x += p.speedX;
        p.y += p.speedY;

        if (p.x < 0 || p.x > container.clientWidth - size) p.speedX *= -1;
        if (p.y < 0 || p.y > container.clientHeight - size) p.speedY *= -1;

        for (let j = 0; j < particles.length; j++) {
          if (i === j) continue;
          const other = particles[j];
          if (Math.abs(p.x - other.x) < size && Math.abs(p.y - other.y) < size) {
            p.speedX *= -1;
            p.speedY *= -1;
            break;
          }
        }

        p.el.style.transform = `translate(${p.x}px, ${p.y}px)`;
      }

      requestAnimationFrame(animate);
    }

    animate();
  </script>
</body>

</html>

