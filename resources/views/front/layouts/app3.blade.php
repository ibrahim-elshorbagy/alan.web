<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">
    @if (!empty($metas))
        @if ($metas['meta_description'])
            <meta name="description" content="{{ $metas['meta_description'] }}">
        @endif
        @if ($metas['meta_keyword'])
            <meta name="keywords" content="{{ $metas['meta_keyword'] }}">
        @endif
        @if ($metas['home_title'] && $metas['site_title'])
            <title>{{ $metas['home_title'] }} | {{ $metas['site_title'] }}</title>
        @else
            <title>@yield('title') | {{ getAppName() }}</title>
        @endif
    @else
        <title>@yield('title') | {{ getAppName() }}</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
    @endif
    @if (!empty(getAppLogo()))
        <meta property="og:image" content="{{ getAppLogo() }}" />
    @endif
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Boxicons for modern icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/css/new_home/bootstrap.min.css') }}">
    {{-- css links --}}
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/new_home/slick.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/new_home/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/new_home/layout.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/new_home/custom.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/new_home/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
    @livewireStyles()
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendor/rappasoft/livewire-tables/css/laravel-livewire-tables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendor/rappasoft/livewire-tables/css/laravel-livewire-tables-thirdparty.min.css') }}">
    <script src="{{ asset('messages.js?$mixID') }}"></script>
    <script src="{{ mix('assets/js/front-third-party.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/third-party.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('assets/js/slider/js/slick.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/helpers.js') }}" defer></script>
    <script src="{{ mix('assets/js/custom/custom.js') }}" defer></script>
    @livewireScripts()
    <script src="{{ asset('vendor/rappasoft/livewire-tables/js/laravel-livewire-tables.min.js') }}"></script>
    <script src="{{ asset('vendor/rappasoft/livewire-tables/js/laravel-livewire-tables-thirdparty.min.js') }}"></script>
    @php
        $langSession = Session::get('languageName');
        $frontLanguage = !isset($langSession) ? getSuperAdminSettingValue('default_language') : $langSession;
    @endphp

    <script>
        let frontLanguage = "{{ $frontLanguage }}"
        Lang.setLocale(frontLanguage)
    </script>
    <script src="{{ mix('assets/js/front-pages.js') }}" defer></script>

    @if (!empty($setting['custom_css']))
    <style>
            {!! $setting['custom_css'] !!}
    </style>
    @endif

    {!! getSuperAdminSettingValue('extra_js_front') !!}

    <!--google analytics code-->
    @if (!empty($metas['google_analytics']))
        {!! $metas['google_analytics'] !!}
    @endif

    @routes
    <script>
        $(document).ready(function() {
            if (window.location.hash) {
                // There's a hash, scroll to it
                setTimeout(function() {
                    var target = $(window.location.hash);
                    if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                }
                }, 500);
            } else {
                // No hash, scroll to top
                $('html, body').animate({
                    scrollTop: $('html').offset().top,
                });
            }
        });
    </script>
    <script data-turbo-eval="false">
        window.getLoggedInUserLang = "{{ getCurrentLanguageName() }}"
        let lang = "{{ Illuminate\Support\Facades\Auth::user()->language ?? 'en' }}"
    </script>
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f2fcfe',
                            100: '#e6fafd',
                            200: '#bff3fa',
                            300: '#99ebf7',
                            400: '#4dddf1',
                            500: '#00cfeb',
                            600: '#00bad4',
                            700: '#009bb0',
                            800: '#007c8c',
                            900: '#006573',
                        },
                        secondary: {
                            50: '#f8f9fb',
                            100: '#f1f3f7',
                            200: '#dde1ec',
                            300: '#c8cfe1',
                            400: '#9eaacb',
                            500: '#7586b5',
                            600: '#5a6aa3',
                            700: '#4a5786',
                            800: '#3c476d',
                            900: '#212a48',
                        },
                        accent: {
                            50: '#fef2fa',
                            100: '#fde5f6',
                            200: '#fbccea',
                            300: '#f8b2de',
                            400: '#f479c6',
                            500: '#f040af',
                            600: '#d83a9e',
                            700: '#b33083',
                            800: '#8f2669',
                            900: '#691c4e',
                        },
                        teal: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    },
                    fontFamily: {
                        'sans': ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'slide-left': 'slide-left 15s linear infinite',
                        'slide-right': 'slide-right 15s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            },
                        },
                        'slide-left': {
                            '0%': {
                                transform: 'translateX(100%)'
                            },
                            '100%': {
                                transform: 'translateX(-100%)'
                            },
                        },
                        'slide-right': {
                            '0%': {
                                transform: 'translateX(-100%)'
                            },
                            '100%': {
                                transform: 'translateX(100%)'
                            },
                        },
                    },
                    boxShadow: {
                        'card': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)',
                        'card-hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)',
                        'glass': '0 0 20px rgba(255, 255, 255, 0.2)',
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* For slider animation */
        .slider-container {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .slider-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slider-item {
            flex: 0 0 100%;
            text-align: center;

            img {
                max-height: 520 !important;
                max-width: 448px !important;
                min-width: 448px !important;
                min-height: 520 !important;
                margin: 0 auto !important;
            }
        }

        /* Hide scrollbar */
        ::-webkit-scrollbar {
            display: none;
        }

        /* Glass morphism */
        .glass {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Card rotation on hover */
        .card-rotate:hover {
            transform: rotateY(10deg) rotateX(5deg);
            transition: transform 0.5s ease-in-out;
        }

        .feature-slider .slick-slide {
            padding: 0 15px;
            margin-bottom: 32px;
        }

        .feature-slider .prev-arrow {
            top: 40%;
            left: -10px;
            z-index: 1;
        }

        .feature-slider .next-arrow {
            top: 40%;
            left: auto;
            right: -10px;
            z-index: 1;
        }

        .testimonial-slider .slick-slide {
            padding: 0 15px;
            margin-bottom: 32px;
        }

        .testimonial-slider .prev-arrow {
            top: 38%;
            left: -10px;
            z-index: 1;
        }

        .testimonial-slider .next-arrow {
            top: 38%;
            left: auto;
            right: -10px;
            z-index: 1;
        }

        .pricing-slider .slick-slide {
            padding: 0 15px;
        }

        .pricing-slider .slick-slide.slick-center .center-border-main {
            border: 2px solid #00cfeb;
        }

        .pagination .page-link {
            background-color: white;
            color: grey;
            padding: 8px 24px;
            border-left: 1px solid #dee2e6 !important;
            border-top: 1px solid #dee2e6 !important;
            border-bottom: 1px solid #dee2e6 !important;
        }

        .pagination button {
            border-radius: 0px;
            border-color: lightgray;
        }

        .pagination button.page-item {
            background-color: white;

        }

        .pagination .page-item:first-child .page-link {
            background-color: white;
            color: grey;
            border: none;
            font-size: 16px;
            border-top-left-radius: 8px !important;
            border-bottom-left-radius: 8px !important;
            width: 66px;
        }

        .pagination .page-item:last-child .page-link {
            background-color: white;
            color: grey;
            border: none;
            font-size: 16px;
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
            border-right: 1px solid #dee2e6 !important;
            width: 66px;
        }

        .pagination .page-item.active .page-link {
            background-color: #00bad4 !important;
            color: white !important;
            border-right: none !important;
        }

        .active.page-link:hover {
            z-index: auto !important;
            color: #808080 !important;
            background-color: transparent !important;
        }

        .page-link:hover {
            z-index: auto !important;
            color: #808080 !important;
            background-color: transparent !important;
            border-color: #d3d3d3 !important;
        }

        .page-link:focus {
            z-index: 3;
            color: #808080 !important;
            background-color: transparent !important;
            outline: 0;
            box-shadow: none
        }

        p.small.text-muted {
            display: none;
        }

        .front-banner-des {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
        }

        .min-w-40px {
            min-width: 40px;
        }

        @media (max-width: 1024px) {
            .mobile-menu {
                margin: 0 20px;
                left: 0;
                top: 81px;
                width: -webkit-fill-available;
                background: white;
                padding-bottom: 18px;

                a {
                    color: #212a48 !important;
                }
            }
        }

        .bg-blue {
            background-color: #7638f9 var(--tw-gradient-to-position);
        }

        .slider-prev:hover {
            background-color: #7638f9 !important;
        }

        .slider-next:hover {
            background-color: #7638f9 !important;
        }

        .blog-title {
            line-height: 1.5 !important;
            font-size: 3rem !important
        }

        .check-url-ar {
            position: relative !important;
            transform: translateY(-120%) !important;
        }

        .theme-3-arrow {
            background-color: #7638f9 !important;
            color: white !important;
        }

        .fw-600 {
            font-weight: 600 !important;
        }

        .feature-min-height {
            min-height: 341px !important;
        }

        .testimonial-min-height {
            min-height: 350px !important;
        }


        @media (min-width: 768PX) {
            .testimonial-min-height {
                min-height: 374px !important;
            }

            .feature-min-height {
                min-height: 390px !important;
            }
        }

        @media (min-width: 1024px) {
            .feature-min-height {
                min-height: 414px !important;
            }

            .testimonial-min-height {
                min-height: 398px !important;
            }
        }

        @media (min-width: 1440px) {
            .feature-min-height {
                min-height: 342px !important;
            }

            .testimonial-min-height {
                min-height: 350px !important;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-primary-50/50 to-secondary-50/50 min-h-screen">
    <!-- Navigation -->
    @include('front.layouts.header3')
    @yield('content')
    <!-- Footer -->
    @include('front.layouts.footer3')
    <script>
        document.getElementById('menuToggleButton').addEventListener('click', function() {
            var menu = document.getElementById('mobileMenu');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.classList.add('flex');
            } else {
                menu.classList.remove('flex');
                menu.classList.add('hidden');
            }
        });
    </script>
    <script>
        // Slider functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sliderTrack = document.querySelector('.slider-track');
            const sliderItems = document.querySelectorAll('.slider-item');
            const sliderDots = document.querySelectorAll('.slider-dot');
            const prevButton = document.querySelector('.slider-prev');
            const nextButton = document.querySelector('.slider-next');
            let currentIndex = 0;
            const itemCount = sliderItems.length;

            // Initialize
            updateSlider();

            // Previous button
            if (prevButton) {
                prevButton.addEventListener('click', function() {
                    currentIndex = (currentIndex - 1 + itemCount) % itemCount;
                    updateSlider();
                });
            }

            // Next button
            if (nextButton) {
                nextButton.addEventListener('click', function() {
                    currentIndex = (currentIndex + 1) % itemCount;
                    updateSlider();
                });
            }

            // Dots
            if (sliderDots) {
                sliderDots.forEach((dot, index) => {
                    dot.addEventListener('click', function() {
                        currentIndex = index;
                        updateSlider();
                    });
                });
            }

            // Auto slider
            setInterval(function() {
                currentIndex = (currentIndex + 1) % itemCount;
                updateSlider();
            }, 5000);

            // Update slider position and active dot
            function updateSlider() {
                if (sliderTrack) {
                    sliderTrack.style.transform = `translateX(-${currentIndex * 100}%)`;
                }

                if (sliderDots) {
                    sliderDots.forEach((dot, index) => {
                        if (index === currentIndex) {
                            dot.classList.remove('bg-secondary-300');
                            dot.classList.add('bg-primary-600');
                        } else {
                            dot.classList.remove('bg-primary-600');
                            dot.classList.add('bg-secondary-300');
                        }
                    });
                }
            }

            // Accordion functionality for pricing section
            const accordionToggles = document.querySelectorAll('.accordion-toggle');

            accordionToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    // Get the content associated with this toggle
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('i');

                    // Toggle visibility
                    content.classList.toggle('hidden');

                    // Rotate icon
                    if (content.classList.contains('hidden')) {
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        icon.style.transform = 'rotate(-180deg)';
                    }
                });
            });
        });
    </script>
    <script>
        $('.center-slider').slick({
            autoplay: true,
            autoplaySpeed: 1000,
            slidesToShow: 5,
            slidesToScroll: 1,
            centerMode: true,
            arrows: true,
            dots: false,
            speed: 300,
            centerPadding: '20px',
            infinite: true,
            autoplaySpeed: 5000,
            prevArrow: '<button class="slide-arrow prev-arrow" aria-label="prev-btn"><i class="fa-solid fa-arrow-left"></i></button>',
            nextArrow: '<button class="slide-arrow next-arrow" aria-label="next-btn"><i class="fa-solid fa-arrow-right"></i></button>',
            responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                    },
                },

            ],
            autoplay: true
        });
    </script>
    <script>
        $(".pricing-slider").slick({
            autoplay: true,
            autoplaySpeed: 5000,
            dots: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            centerPadding: '0px',
            centerMode: true,
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        centerMode: true,
                    },
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 1.7,
                        centerMode: true,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    },
                },
            ],
        });
    </script>
    <script>
        $(".feature-slider").slick({
            autoplay: true,
            autoplaySpeed: 1000,
            speed: 600,
            draggable: true,
            infinite: true,
            dots: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            prevArrow: '<button class="theme-3-arrow slide-arrow prev-arrow" aria-label="prev-btn"><i class="fa-solid fa-chevron-left"></i></button>',
            nextArrow: '<button class="theme-3-arrow slide-arrow next-arrow" aria-label="next-btn"><i class="fa-solid fa-chevron-right"></i></button>',
            responsive: [{
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                    },
                },
            ],
        });
    </script>
    <script>
        $(".testimonial-slider").slick({
            autoplay: true,
            autoplaySpeed: 1000,
            speed: 600,
            draggable: true,
            infinite: true,
            dots: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            prevArrow: '<button class="theme-3-arrow slide-arrow prev-arrow" aria-label="prev-btn"><i class="fa-solid fa-chevron-left"></i></button>',
            nextArrow: '<button class="theme-3-arrow slide-arrow next-arrow" aria-label="prev-btn"><i class="fa-solid fa-chevron-right"></i></button>',
            responsive: [{
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                    },
                },
            ],
        });
    </script>
</body>

</html>
