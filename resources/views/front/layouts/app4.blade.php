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
    <!-- Boxicons for modern icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    {{-- bootstrap --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/new_home/bootstrap.min.css') }}"> --}}
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

    {{-- @if (!empty($metas['google_analytics']))
        <!--google analytics code-->
        {!! $metas['google_analytics'] !!}
    @endif --}}
    @routes
    <script>
        $(document).ready(function() {
            if (window.location.hash) {
                // There's a hash, scroll to it
                setTimeout(function() {
                    var target = $(window.location.hash);
                    if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top
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
<script>
    function togglePricing(type) {
        const monthlyBtn = document.getElementById('monthlyBtn');
        const yearlyBtn = document.getElementById('yearlyBtn');
        const unlimitedBtn = document.getElementById('unlimitedBtn');

        // Reset all buttons
        monthlyBtn.className = 'px-6 py-2 rounded-md font-medium transition-all text-gray-600';
        yearlyBtn.className = 'px-6 py-2 rounded-md font-medium transition-all text-gray-600';
        unlimitedBtn.className = 'px-6 py-2 rounded-md font-medium transition-all text-gray-600';

        // Hide all plan sections
        document.getElementById('monthly-plans').style.display = 'none';
        document.getElementById('yearly-plans').style.display = 'none';
        document.getElementById('unlimited-plans').style.display = 'none';

        if (type === 'monthly') {
            monthlyBtn.className = 'px-6 py-2 rounded-md font-medium transition-all bg-blue-600 text-white shadow-md';
            document.getElementById('monthly-plans').style.display = 'grid';
        } else if (type === 'yearly') {
            yearlyBtn.className = 'px-6 py-2 rounded-md font-medium transition-all bg-blue-600 text-white shadow-md';
            document.getElementById('yearly-plans').style.display = 'grid';
        } else if (type === 'unlimited') {
            unlimitedBtn.className = 'px-6 py-2 rounded-md font-medium transition-all bg-blue-600 text-white shadow-md';
            document.getElementById('unlimited-plans').style.display = 'grid';
        }

        // Reinitialize Feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    // Handle custom plan dropdown changes
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.customSelect').forEach(function(select) {
            select.addEventListener('change', function() {
                const planId = this.dataset.planId;
                const selectedOption = this.options[this.selectedIndex];
                const newPrice = selectedOption.dataset.price;
                const currency = selectedOption.dataset.currency;
                const vcardCount = selectedOption.dataset.vcards;

                // Update price display
                const priceElement = document.querySelector('.custom-price-' + planId);
                if (priceElement) {
                    const currencySymbol = currency === 'USD' ? '$' : currency;
                    priceElement.textContent = currencySymbol + newPrice;
                }

                // Update vCard count display
                const vcardElement = document.querySelector('.vcard-count-' + planId);
                if (vcardElement) {
                    vcardElement.textContent = '{{ __("messages.plan.no_of_vcard_templates") }}' + ': ' + vcardCount;
                }
            });
        });
    });
</script>




    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; overflow-x: hidden }
        .fade-in { opacity: 0; transform: translateY(20px); transition: all 0.6s ease; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }
        .floating { animation: floating 3s ease-in-out infinite; }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .animation-delay-1000 {
            animation-delay: 1s;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .dropdown-menu {
            display: none;
        }

        .dropdown.show .dropdown-menu,
        .dropdown-menu.show {
            display: block;
        }

        nav {
            z-index: 9999 !important;
        }

        .dropdown-menu {
            position: absolute !important;
            z-index: 1050 !important;
        }
    </style>
    <style>
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
    </style>
    <style>
        .pagination .page-link {
            padding: 8px 24px;
        }

        div > p.text-sm.text-gray-700.leading-5 {
            display: none !important;
        }
    </style>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <style>
        .feature-slider .slide-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: white;
            border: none;
            padding: 10px;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            cursor: pointer;
            color: #212a48;
        }

        .feature-slider .prev-arrow,
        .feature-slider .next-arrow {
            background-color: #7638f9;
            color: white;
        }

        .feature-slider .slide-arrow:hover {
            transform: translateY(-50%) scale(1.05);
        }

        .feature-slider .prev-arrow {
            left: -30px;
        }
        .feature-slider .next-arrow {
            right: -30px;
        }

        @media (max-width: 1024px) {
            .feature-slider .prev-arrow {
                left: -23px;
            }
            .feature-slider .next-arrow {
                right: -23px;
            }
        }

        @media (max-width: 768px) {
            .feature-slider .prev-arrow {
                left: -23px;
            }
            .feature-slider .next-arrow {
                right: -23px;
            }
        }

        @media (max-width: 640px) {
            .feature-slider .slide-arrow {
                padding: 6px;
            }
        }
    </style>
</head>
<body class="bg-white">
    @include('front.layouts.header4')
    @yield('content')
    <!-- Footer -->
    @include('front.layouts.footer4')

    <script>
        // Initialize Feather Icons
        feather.replace();

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Fade in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    </script>
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
    {{-- <script>
        $('.center-slider').slick({
            autoplay: true,
            autoplaySpeed: 1000,
            slidesToShow: 5,
            slidesToScroll: 1,
            centerMode: true,
            arrows: true,
            dots: true,
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
    </script> --}}
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
            prevArrow: '<button class="theme-4-arrow slide-arrow prev-arrow" aria-label="prev-btn"><i class="fa-solid fa-chevron-left"></i></button>',
            nextArrow: '<button class="theme-4-arrow slide-arrow next-arrow" aria-label="next-btn"><i class="fa-solid fa-chevron-right"></i></button>',
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
