<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:image" content="{{ $blog->blog_image }}" />
    @if ($blog['seo_description'])
        <meta name="description" content="{{ $blog['seo_description'] }}">
    @endif
    @if ($blog['seo_keyword'])
        <meta name="keywords" content="{{ $blog['seo_keyword'] }}">
    @endif
    @if ($blog['seo_title'])
        <title>{{ $blog['seo_title'] }} | {{ getAppName() }}</title>
    @else
        <title> {{ __('messages.blog.blogs') }} | {{ getAppName() }}</title>
    @endif
    @if (!empty(getAppLogo()))
        <meta property="og:image" content="{{ getAppLogo() }}" />
    @endif
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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
    <script src="{{ asset('messages.js?$mixID') }}"></script>
    <script src="{{ mix('assets/js/front-third-party.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/third-party.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('assets/js/slider/js/slick.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/helpers.js') }}" defer></script>
    <script src="{{ mix('assets/js/custom/custom.js') }}" defer></script>

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
            $('html, body').animate({
                scrollTop: $('html').offset().top,
            });
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
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .article-content p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .article-content h2 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-top: 2.5rem;
            margin-bottom: 1.25rem;
            color: #3c476d;
        }

        .article-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #3c476d;
        }

        .article-content ul,
        .article-content ol {
            margin-bottom: 1.5rem;
            padding-left: 1.25rem;
        }

        .article-content ul {
            list-style-type: disc;
        }

        .article-content ol {
            list-style-type: decimal;
        }

        .article-content li {
            margin-bottom: 0.5rem;
        }

        .article-content a {
            color: #00bad4;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .article-content a:hover {
            color: #007c8c;
        }

        .article-content blockquote {
            border-left: 4px solid #00cfeb;
            padding-left: 1rem;
            font-style: italic;
            margin: 1.5rem 0;
            color: #5a6aa3;
        }

        .article-content img {
            border-radius: 0.5rem;
            margin: 2rem 0;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-primary-50/50 to-secondary-50/50 min-h-screen">
    <!-- Navigation -->
    @include('front.layouts.header3')
    <!-- Blog Header -->
    <header class="py-20 bg-gradient-to-br from-secondary-900 to-secondary-800 text-white relative overflow-hidden"
        @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-accent-500/10 rounded-full filter blur-3xl"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex items-center space-x-3 mb-6 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') space-x-reverse @endif">
                <a href="{{ route('fornt-blog') }}"
                    class="text-white/80 hover:text-white flex items-center transition-colors">
                    <i class='bx bx-arrow-back mr-1 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-1 mr-0 @endif'></i> {{ __('messages.theme3.back_to_blog') }}
                </a>
                <span class="text-white/30">•</span>
                <span class="text-primary-400">{{ $blog->created_at->diffForHumans() }}</span>
                <span class="text-white/30">•</span>
                <span class="text-white/80">{{ $blog->created_at->format('F d, Y') }}</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-6">{{ $blog->title }}</h1>
        </div>
    </header>

    <!-- Featured Image -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 mb-12 relative z-20">
        <img src="{{ isset($blog->blog_image) ? $blog->blog_image : asset('front/images/about-1.png') }}"
            alt="About" class="w-100 h-100 object-fit-cover" />
    </div>

    <!-- Article Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="bg-white rounded-xl shadow-md p-8 md:p-12">
            <div class="prose prose-lg max-w-none article-content">
                {!! $blog->description !!}
            </div>
        </div>
        <!-- CTA -->
        <div
            class="mt-16 bg-gradient-to-r from-primary-600 to-accent-600 rounded-2xl p-8 md:p-12 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full filter blur-3xl -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full filter blur-3xl -ml-32 -mb-32">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center">
                <div class="md:w-2/3 mb-6 md:mb-0">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ __('messages.theme3.ready_to_transform') }}
                    </h2>
                    <p class="text-white/90 mb-0 md:pr-6">{{ __('messages.theme3.create_your_digital_business_card') }}
                    </p>
                </div>
                <div class="md:w-1/3 flex-shrink-0 flex justify-center md:justify-end">
                    <a href="{{ route('register') }}"
                        class="px-6 py-3 bg-white text-primary-600 font-medium rounded-lg hover:bg-gray-100 transition-colors shadow-lg inline-flex items-center">
                        {{ __('messages.theme3.get_started_free') }} <i class='bx bx-right-arrow-alt ml-1.5'></i>
                    </a>
                </div>
            </div>
        </div>
    </main>
    @include('front.layouts.footer3')
</body>
</html>
