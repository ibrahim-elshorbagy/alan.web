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
    <link rel="stylesheet" href="{{ mix('assets/css/vcard37.css') }}">
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
    <div class="container p-0">
        <div class="vcard-thirtyseven main-content w-100 mx-auto content-blur allSection collapse show">
            <div class="vcard-one__product py-3 mt-0 px-30px">
                <div class="d-flex gap-2 justify-content-between align-items-center mb-6"
                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <div>
                        <h4 class="product-heading">{{ __('messages.vcard.products') }}</h4>
                    </div>
                    <div>
                        <a class="back-btn text-decoration-none d-block" href="{{ $vcardUrl }}"
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
                                    <div class="product-desc d-flex justify-content-between align-items-center mt-5"
                                        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                        <h3 class="text-black fs-18 fw-5 mb-0 me-2">{{ $product->name }}</h3>
                                        <div class="product-amount text-teal-green fs-18">
                                            @if ($product->currency_id && $product->price)
                                                <span
                                                    class="fs-18 fw-semibold text-teal-green  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                                            @elseif($product->price)
                                                <span
                                                    class="fs-18 fw-semibold text-teal-green  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="fs-14 text-black mb-0 p-5">{{ $product->description }}</p>
                                    @if (!empty($product->price))
                                        <div class="text-center">
                                            <button class="buy-product text-white"
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

    <script>
        function randNum(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        class Flower {
            constructor(opts) {
                this.left = opts.left;
                this.top = opts.top;
                this.size = randNum(10, 20);
                this.drawFlower();
            }

            spinFlower(el) {
                let r = 0;
                const spd = Math.random() * (0.3 - 0.01) + 0.01; // reduced spin speed
                const spin = () => {
                    r = (r + spd) % 360;
                    el.style.transform = `rotate(${r}deg)`;
                    requestAnimationFrame(spin);
                };
                spin();
            }

            fall(el) {
                const maxRight = this.left + randNum(20, 50);
                const maxLeft = this.left - randNum(20, 50);
                let direction = ['left', 'right'][randNum(0, 1)];

                const fall = () => {
                    if (this.left <= maxLeft) {
                        direction = 'right';
                    }
                    if (this.left >= maxRight) {
                        direction = 'left';
                    }
                    this.left += direction === 'left' ? -0.5 : 0.5; // slow horizontal
                    this.top += 0.6; // slow fall
                    el.style.top = this.top + 'px';
                    el.style.left = this.left + 'px';
                    requestAnimationFrame(fall);
                };
                fall();
            }

            fadeOut(el) {
                el.style.opacity = 1;
                const fade = () => {
                    if ((el.style.opacity -= 0.0025) < 0) {
                        el.parentNode && el.parentNode.removeChild(el);
                    } else {
                        requestAnimationFrame(fade);
                    }
                };
                fade();
            }

            get petal() {
                const petal = document.createElement('div');
                petal.style.userSelect = 'none';
                petal.style.position = 'absolute';
                petal.style.background = 'radial-gradient(white 10%, #cee7d5 50%, #2a9f2e 70%)';
                petal.style.backgroundSize = this.size + 'px';
                petal.style.backgroundPosition = `-${this.size / 2}px 0`;
                petal.style.width = petal.style.height = this.size / 2 + 'px';
                petal.style.borderTopLeftRadius = petal.style.borderBottomRightRadius = (42.5 * this.size) / 100 + 'px';
                return petal;
            }

            get petal_styles() {
                return [{
                        transform: 'rotate(-47deg)',
                        left: '50%',
                        marginLeft: `-${this.size / 4}px`,
                        top: '0'
                    },
                    {
                        transform: 'rotate(15deg)',
                        left: '100%',
                        marginLeft: `-${this.size * 0.39}px`,
                        top: `${this.size * 0.175}px`
                    },
                    {
                        transform: 'rotate(93deg)',
                        left: '100%',
                        marginLeft: `-${this.size * 0.51}px`,
                        top: `${this.size * 0.58}px`
                    },
                    {
                        transform: 'rotate(175deg)',
                        left: '0%',
                        marginLeft: `${this.size * 0.05}px`,
                        top: `${this.size * 0.58}px`
                    },
                    {
                        transform: 'rotate(250deg)',
                        left: '0%',
                        marginLeft: `-${this.size * 0.08}px`,
                        top: `${this.size * 0.175}px`
                    }
                ];
            }

            get flower() {
                const flower = document.createElement('div');
                flower.className = 'flower';
                flower.style.userSelect = 'none';
                flower.style.position = 'fixed';
                flower.style.left = this.left + 'px';
                flower.style.top = this.top + 'px';
                flower.style.width = this.size + 'px';
                flower.style.height = this.size + 'px';
                flower.style.pointerEvents = 'none';

                // Set a random width and height for SVG
                const svgSize = randNum(15, 40); // Customize size range here

                // SVG content as string
                const svgHTML = `
    <svg width="${svgSize}" height="${svgSize}" viewBox="0 0 50 51" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M25 0.5C27.9407 0.5 29.5598 2.52017 30.4678 4.69238C30.9194 5.77303 31.179 6.86066 31.3252 7.68164C31.398 8.09083 31.4419 8.43139 31.4678 8.66797C31.4807 8.78586 31.4891 8.87779 31.4941 8.93945C31.4967 8.97021 31.499 8.99374 31.5 9.00879C31.5005 9.01631 31.5008 9.02203 31.501 9.02539V9.0293L31.5664 10.1602L32.3574 9.34961L32.3721 9.33496C32.3829 9.32406 32.4004 9.30714 32.4229 9.28516C32.468 9.24099 32.5363 9.17502 32.625 9.09277C32.8026 8.92821 33.063 8.69616 33.3896 8.43164C34.0453 7.90074 34.9596 7.24582 36.0039 6.73145C37.0513 6.21562 38.2009 5.85515 39.3379 5.87988C40.4588 5.90434 41.5952 6.30225 42.6465 7.35352C44.7082 9.41519 44.3087 12.1415 43.2598 14.5156C42.7415 15.6886 42.082 16.7294 41.5488 17.4795C41.283 17.8535 41.0503 18.1533 40.8848 18.3584C40.8021 18.4608 40.736 18.5393 40.6914 18.5918C40.6694 18.6178 40.6527 18.6376 40.6416 18.6504C40.636 18.6568 40.6315 18.6621 40.6289 18.665L40.626 18.668L39.833 19.5625L41.0264 19.499H41.0303C41.0336 19.4989 41.0395 19.4984 41.0469 19.498C41.0619 19.4974 41.0848 19.497 41.1152 19.4961C41.1769 19.4943 41.2695 19.4924 41.3877 19.4922C41.6242 19.4918 41.9643 19.498 42.373 19.5254C43.1935 19.5803 44.2776 19.7187 45.3535 20.0488C46.4325 20.3799 47.471 20.8942 48.2354 21.6787C48.9877 22.451 49.5 23.5105 49.5 25C49.5 26.4902 48.9872 27.5862 48.2266 28.4092C47.4558 29.2431 46.4108 29.8173 45.3301 30.209C44.252 30.5997 43.1663 30.7979 42.3457 30.8984C41.9367 30.9485 41.5959 30.9745 41.3594 30.9873C41.2414 30.9937 41.1495 30.9964 41.0879 30.998C41.0571 30.9989 41.0336 30.9998 41.0186 31H40.998L39.8398 31.0029L40.6367 31.8428V31.8438L40.6396 31.8467L40.6982 31.9102C40.7401 31.9564 40.8021 32.0264 40.8799 32.1172C41.0359 32.2993 41.2559 32.5665 41.5059 32.9014C42.0072 33.573 42.6235 34.5087 43.0996 35.5752C44.0567 37.7192 44.3972 40.2513 42.3242 42.3242C41.2675 43.3809 40.1454 43.7971 39.0537 43.8486C37.9474 43.9009 36.8392 43.5795 35.835 43.1045C34.833 42.6305 33.9613 42.0156 33.3369 41.5156C33.0259 41.2666 32.7787 41.048 32.6104 40.8926C32.5263 40.815 32.4616 40.7536 32.4189 40.7119C32.3976 40.6911 32.3813 40.6753 32.3711 40.665C32.366 40.6599 32.3626 40.6556 32.3604 40.6533L32.3574 40.6504L31.5664 39.8389L31.501 40.9707V40.9746C31.5008 40.978 31.5005 40.9837 31.5 40.9912C31.499 41.0063 31.4967 41.0298 31.4941 41.0605C31.4891 41.1222 31.4807 41.2141 31.4678 41.332C31.4419 41.5686 31.398 41.9092 31.3252 42.3184C31.179 43.1393 30.9194 44.227 30.4678 45.3076C29.5598 47.4798 27.9407 49.5 25 49.5C22.0593 49.5 20.4402 47.4798 19.5322 45.3076C19.0806 44.227 18.821 43.1393 18.6748 42.3184C18.602 41.9092 18.5581 41.5686 18.5322 41.332C18.5193 41.2141 18.5109 41.1222 18.5059 41.0605C18.5033 41.0298 18.501 41.0063 18.5 40.9912C18.4995 40.9837 18.4992 40.978 18.499 40.9746V40.9707L18.4336 39.8389L17.6416 40.6504V40.6514C17.6412 40.6518 17.6405 40.6524 17.6396 40.6533C17.6374 40.6556 17.634 40.6599 17.6289 40.665C17.6187 40.6753 17.6024 40.6911 17.5811 40.7119C17.5384 40.7536 17.4737 40.815 17.3896 40.8926C17.2213 41.048 16.9741 41.2666 16.6631 41.5156C16.0387 42.0156 15.167 42.6305 14.165 43.1045C13.1608 43.5795 12.0526 43.9009 10.9463 43.8486C9.85463 43.7971 8.7325 43.3809 7.67578 42.3242C5.60283 40.2513 5.94327 37.7192 6.90039 35.5752C7.3765 34.5087 7.99283 33.573 8.49414 32.9014C8.74406 32.5665 8.96412 32.2993 9.12012 32.1172C9.1979 32.0264 9.25992 31.9564 9.30176 31.9102L9.36035 31.8467L9.36328 31.8438L9.3623 31.8428L10.1602 31.0029L9.00098 31H8.98145C8.96641 30.9998 8.94294 30.9989 8.91211 30.998C8.85051 30.9964 8.75856 30.9937 8.64062 30.9873C8.40411 30.9745 8.06332 30.9485 7.6543 30.8984C6.83371 30.7979 5.74803 30.5997 4.66992 30.209C3.58921 29.8173 2.54418 29.2431 1.77344 28.4092C1.01283 27.5862 0.5 26.4902 0.5 25C0.5 23.5105 1.0123 22.451 1.76465 21.6787C2.52903 20.8942 3.56748 20.3799 4.64648 20.0488C5.72243 19.7187 6.80648 19.5803 7.62695 19.5254C8.03568 19.498 8.37583 19.4918 8.6123 19.4922C8.73047 19.4924 8.82309 19.4943 8.88477 19.4961C8.91516 19.497 8.93813 19.4974 8.95312 19.498C8.96054 19.4984 8.96635 19.4989 8.96973 19.499H8.97363L10.1621 19.5625L9.375 18.6689L9.37207 18.666C9.36973 18.6633 9.36623 18.659 9.36133 18.6533C9.35086 18.6412 9.33454 18.6217 9.31348 18.5967C9.27136 18.5467 9.20896 18.4718 9.13086 18.374C8.97439 18.1781 8.75441 17.8916 8.50391 17.5332C8.0014 16.8142 7.38231 15.8146 6.9043 14.6836C5.94015 12.4022 5.60484 9.74672 7.67578 7.67578C8.7325 6.61906 9.85463 6.20294 10.9463 6.15137C12.0526 6.09913 13.1608 6.42049 14.165 6.89551C15.167 7.36946 16.0387 7.98435 16.6631 8.48438C16.9741 8.73344 17.2213 8.952 17.3896 9.10742C17.4737 9.18497 17.5384 9.24643 17.5811 9.28809C17.6024 9.30891 17.6187 9.32472 17.6289 9.33496C17.634 9.34008 17.6374 9.3444 17.6396 9.34668L17.6416 9.34863L18.4336 10.1611L18.499 9.0293V9.02539C18.4992 9.02203 18.4995 9.01631 18.5 9.00879C18.501 8.99374 18.5033 8.97021 18.5059 8.93945C18.5109 8.87779 18.5193 8.78586 18.5322 8.66797C18.5581 8.43139 18.602 8.09083 18.6748 7.68164C18.821 6.86066 19.0806 5.77303 19.5322 4.69238C20.4402 2.52017 22.0593 0.5 25 0.5Z" fill="#CEE7D5" stroke="#2a9f2e"/>
    </svg>
  `;

                flower.innerHTML = svgHTML;

                this.fadeOut(flower);
                this.spinFlower(flower);
                this.fall(flower);
                return flower;
            }

            drawFlower() {
                document.body.appendChild(this.flower);
            }
        }

        let flowerInterval;

        function startFlowerInterval() {
            flowerInterval = setInterval(() => {
                const amt = randNum(3, 6); // slightly fewer per batch
                for (let i = 0; i < amt; i++) {
                    const top = randNum(0, window.innerHeight / 2);
                    const left = randNum(0, window.innerWidth);
                    new Flower({
                        top,
                        left
                    });
                }
            }, 2000); // spawn every 2 seconds (slower)
        }

        function stopFlowerInterval() {
            clearInterval(flowerInterval);
        }

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopFlowerInterval();
            } else {
                startFlowerInterval();
            }
        });

        window.addEventListener('beforeunload', () => {
            document.querySelectorAll('.flower').forEach(f => f.remove());
        });

        startFlowerInterval();
    </script>
</body>

</html>
