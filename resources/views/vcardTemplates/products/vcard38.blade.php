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
    <link rel="stylesheet" href="{{ mix('assets/css/vcard38.css') }}">
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
                    body {
                        font-family: {{ $vcard->font_family }};
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
    <div class="vcard38-bg-effect position-fixed w-100 h-100 top-0 start-0">
        <div id="vcard38Tsparticles"></div>
        <div class="vcard-38-bg-img">
        </div>
    </div>
    <div class="container p-0">
        <div class="main-content w-100 mx-auto collapse show">
            <div class="vcard-one__product py-3 mt-0 px-30">
                <div class="d-flex gap-2 justify-content-between align-items-center mb-6"
                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <div>
                        <h4 class="product-heading">{{ __('messages.vcard.products') }}</h4>
                    </div>
                    <div>
                        <a class="back-btn fs-16 text-decoration-none d-block" href="{{ $vcardUrl }}"
                            role="button">{{ __('messages.common.back') }}</a>
                    </div>
                </div>
                <div class="product-slider">
                    @foreach ($vcard->products as $product)
                        <div>
                            <div class="product-card card mb-5">
                                <div class="product-img card-img text-center">
                                    <a @if ($product->product_url) href="{{ $product->product_url }}" @endif
                                        target="_blank" class="text-decoration-none fs-6">
                                        <div
                                            class=" {{ $product->media->count() < 2 ? 'd-flex justify-content-center' : '' }} product-img-slider overflow-hidden">
                                            @foreach ($product->media as $media)
                                                <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}"
                                                    class="text-center object-fit-contain" height="208px"
                                                    loading="lazy">
                                            @endforeach
                                        </div>
                                    </a>
                                </div>
                                <div class="card-body p-3">
                                    <div class="product-desc">
                                        <h3 class="text-black fs-20 fw-5 mb-2">{{ $product->name }}</h3>
                                    </div>
                                    <p class="fs-14 text-gray-100 mb-2">{{ $product->description }}</p>
                                    <div class="product-amount fs-20 mb-3 fw-7 text-primary">
                                        @if ($product->currency_id && $product->price)
                                            <span
                                                class="fs-20  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                                        @elseif($product->price)
                                            <span
                                                class="fs-20  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                                        @endif
                                    </div>
                                    @if (!empty($product->price))
                                        <div class="text-center">
                                            <button class="buy-product fs-16"
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
            autoplay: false,
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
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>
    <script>
        tsParticles.load("vcard38Tsparticles", {
            fps_limit: 60,
            interactivity: {
                detect_on: "canvas",
                events: {
                    onclick: {
                        enable: false,
                        mode: "push"
                    },
                    onhover: {
                        enable: false,
                        mode: "repulse" // keep repulse but very short duration
                    },
                    resize: true
                },
                modes: {
                    bubble: {
                        distance: 400,
                        duration: 2,
                        opacity: 0.8,
                        size: 40,
                        speed: 3
                    },
                    push: {
                        particles_nb: 4
                    },
                    repulse: {
                        distance: 200,
                        duration: 0.1
                    } // shorter repulse
                }
            },
            particles: {
                color: {
                    value: "#716659"
                },
                line_linked: {
                    color: "#000000",
                    distance: 150,
                    enable: true,
                    opacity: 0.4,
                    warp: true,
                    width: 1
                },
                move: {
                    enable: true,
                    direction: "none",
                    random: false,
                    speed: 2,
                    straight: false,
                    out_mode: "out"
                },
                number: {
                    density: {
                        enable: true,
                        value_area: 800
                    },
                    value: 80
                },
                opacity: {
                    value: 0.5
                },
                shape: {
                    type: "circle"
                },
                size: {
                    random: true,
                    value: 5
                }
            },
            retina_detect: true
        });
    </script>
</body>

</html>
