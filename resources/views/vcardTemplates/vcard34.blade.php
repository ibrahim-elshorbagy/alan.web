<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @if (checkFeature('seo') && $vcard->site_title && $vcard->home_title)
        <title>{{ $vcard->home_title }} | {{ $vcard->site_title }}</title>
    @else
        <title>{{ $vcard->name }} | {{ getAppName() }}</title>
    @endif

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('pwa/1.json') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ getVcardFavicon($vcard) }}" type="image/png">

    {{-- css link --}}
    <link rel="stylesheet" href="{{ asset('assets/css/vcard34.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}">
    {{-- google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if (checkFeature('custom-fonts') && $vcard->font_family)
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family={{ urlencode($vcard->font_family) }}:wght@400;500;600;700&display=swap{{ in_array($vcard->font_family, ['Tajawal', 'Cairo', 'Amiri', 'Noto Sans Arabic', 'Noto Naskh Arabic', 'Noto Kufi Arabic', 'Scheherazade', 'Lateef', 'Harmattan', 'Reem Kufi', 'Jomhuria', 'Mada', 'Lemonada', 'Zain']) ? '&subset=arabic' : '' }}">
    @endif
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    @if ($vcard->font_family || $vcard->font_size || $vcard->custom_css)
        <style>
            @if (checkFeature('custom-fonts'))
                @if ($vcard->font_family)
                    body {
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
        @if (checkFeature('password'))
            @include('vcards.password')
        @endif
        <div
            class="main-section mx-auto w-100 overflow-hidden position-relative @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
            {{-- Pwa support --}}
            @if (isset($enable_pwa) && $enable_pwa == 1 && !isiOSDevice())
                <div class="mt-0">
                    <div class="pwa-support d-flex align-items-center justify-content-center"
                        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                        <div>
                            <h1 class="text-white pwa-heading">{{ __('messages.pwa.add_to_home_screen') }}</h1>
                            <p class="pwa-text text-gray-100">{{ __('messages.pwa.pwa_description') }} </p>
                            <div class="text-end d-flex gap-2" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                <button id="installPwaBtn"
                                    class="pwa-install-button w-50 mb-1 btn">{{ __('messages.pwa.install') }} </button>
                                <button
                                    class="pwa-cancel-button w-50 pwa-close btn btn-secondary mb-1">{{ __('messages.common.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- support banner --}}
            @if ((isset($managesection) && $managesection['banner']) || empty($managesection))
                @if (isset($banners->title))
                    <div class="support-banner d-flex align-items-center justify-content-center">
                        <button type="button" class="text-start banner-close"><i
                                class="fa-solid fa-xmark text-white"></i></button>
                        <div class="">
                            <h1 class="text-center text-white support_heading">{{ $banners->title }}</h1>
                            <p class="text-center text-gray-100 support_text">{{ $banners->description }} </p>
                            <div class="text-center mt-3">
                                <a href="{{ $banners->url }}" class="act-now text-white" target="blank"
                                    data-turbo="false">{{ $banners->banner_button }}</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- banner img --}}
            <div class="overflow-hidden">
                <div class="banner-img @if ($vcard->cover_type == 2) h-auto @endif">
                    @php
                        $coverClass =
                            $vcard->cover_image_type == 0
                                ? 'object-fit-cover w-100 h-100'
                                : 'object-fit-cover w-100 h-100';
                    @endphp
                    @if ($vcard->cover_type == 0)
                        <img src="{{ $vcard->cover_url }}" class="{{ $coverClass }}" loading="lazy" />
                    @elseif($vcard->cover_type == 1)
                        @if (strpos($vcard->cover_url, '.mp4') !== false ||
                                strpos($vcard->cover_url, '.mov') !== false ||
                                strpos($vcard->cover_url, '.avi') !== false)
                            <video class="cover-video {{ $coverClass }}" loop autoplay playsinline
                                alt="background video" id="cover-video">
                                <source src="{{ $vcard->cover_url }}" type="video/mp4">
                            </video>
                        @endif
                    @elseif ($vcard->cover_type == 2)
                        <div class="youtube-link-34">
                            <iframe
                                src="https://www.youtube.com/embed/{{ YoutubeID($vcard->youtube_link) }}?autoplay=1&mute=0&loop=1&playlist={{ YoutubeID($vcard->youtube_link) }}&controls=0&modestbranding=1&showinfo=0&rel=0"
                                class="cover-video {{ $coverClass }}" id="cover-video" frameborder="0"
                                allow="autoplay; encrypted-media" allowfullscreen>
                            </iframe>
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-end position-absolute top-0 end-0 mx-3 language-btn">
                    @if ($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
                        <div class="language pt-3">
                            <ul class="text-decoration-none ps-0">
                                <li class="dropdown1 dropdown lang-list">
                                    <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="false">
                                        {{ strtoupper(getLanguageIsoCode($vcard->default_language)) }}
                                    </a>
                                    <ul class="dropdown-menu top-dropdown lang-hover-list top-100 mt-0">
                                        @foreach (getAllLanguageWithFullData() as $language)
                                            <li
                                                class="{{ getLanguageIsoCode($vcard->default_language) == $language->iso_code ? 'active' : '' }}">
                                                <a href="javascript:void(0)" id="languageName"
                                                    data-name="{{ $language->iso_code }}">
                                                    @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                                        @foreach (\App\Models\User::FLAG as $imageKey => $imageValue)
                                                            @if ($imageKey == $language->iso_code)
                                                                <img src="{{ asset($imageValue) }}" class="me-1" />
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @if (count($language->media) != 0)
                                                            <img src="{{ $language->image_url }}" class="me-1" />
                                                        @else
                                                            <i class="fa fa-flag fa-xl me-3 text-danger"
                                                                aria-hidden="true"></i>
                                                        @endif
                                                    @endif
                                                    {{ strtoupper($language->iso_code) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="overlay"></div>
            <!-- Profile Section -->
            <div class="profile-section pt-50 px-30 position-relative">
                <div
                    class="position-absolute top-0 h-100 main-bg-img @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') start-0 @else end-0 @endif">
                    <img src="{{ asset('assets/img/vcard34/main-bg-img.png') }}" alt="image"
                        class="w-100 h-100 object-fit-cover" />
                </div>
                <div class="profile-card bg-transparent d-flex gap-3 gap-sm-5 flex-sm-row flex-column align-items-center"
                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <div class="circle d-flex justify-content-center align-items-center position-relative">
                        <div class="profile-img position-relative rounded-circle">
                            <img src="{{ $vcard->profile_url }}" alt="images"
                                class="h-100 w-100 object-fit-cover rounded-circle" />
                        </div>
                    </div>
                    <div
                        class="profile-desc p-0 text-center @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @else text-sm-start @endif">
                        <h1 class="fs-28 fw-6 text-white mb-0">
                            {{ ucwords($vcard->first_name . ' ' . $vcard->last_name) }}
                            @if ($vcard->is_verified)
                                <i class="verification-icon bi-patch-check-fill"></i>
                            @endif
                        </h1>
                        <p
                            class="fs-16 fw-5 lh-base text-primary mb-1 photo-title text-uppercase text-decoration-underline">
                            {{ ucwords($vcard->company) }}</p>
                        <p class="fs-14 fw-light lh-base text-gray-100 mb-0">
                            {{ ucwords($vcard->occupation) }}</p>
                        <p class="fs-14 fw-light lh-base text-gray-100 mb-0">
                            {{ ucwords($vcard->job_title) }}</p>

                    </div>
                </div>
            </div>
            <div class="fs-14 text-gray-100 profile-desc pt-50 px-30 text-center">
                {!! $vcard->description !!}
            </div>
            {{-- social-media --}}
            @if (checkFeature('social_links') && isset($vcard->socialLink) && getSocialLink($vcard))
                <div class="social-media pt-50 px-30 position-relative">
                    <div class="position-absolute vector-1 vector-all">
                        <img src="{{ asset('assets/img/vcard34/bg-vector-1.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    <div class="social-icons d-flex flex-wrap justify-content-center position-relative">
                        @if (checkFeature('social_links') && getSocialLinkIcon($vcard))
                            @foreach (getSocialLinkIcon($vcard) as $key => $social)
                                <a href="{{ $social['url'] }}" target="_blank" class="">
                                    {!! $social['icon'] !!}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
            {{-- custom link section --}}
            @if (checkFeature('custom-links') && $customLink->isNotEmpty())
                <div class="custom-link-section">
                    <div class="custom-link d-flex flex-wrap justify-content-center gap-2 px-30 pt-30 w-100">
                        @foreach ($customLink as $value)
                            @if ($value->show_as_button == 1)
                                <a href="{{ $value->link }}"
                                    @if ($value->open_new_tab == 1) target="_blank" @endif
                                    style="
                        @if ($value->button_color) background-color: {{ $value->button_color }}; @endif
                        @if ($value->button_type === 'rounded') border-radius: 20px; @endif
                        @if ($value->button_type === 'square') border-radius: 0px; @endif"
                                    class="d-flex justify-content-center align-items-center text-decoration-none link-text
                        font-primary btn">
                                    {{ $value->link_name }}
                                </a>
                            @else
                                <a href="{{ $value->link }}"
                                    @if ($value->open_new_tab == 1) target="_blank" @endif
                                    class="d-flex justify-content-center align-items-center text-decoration-none link-text
                        text-black">
                                    {{ $value->link_name }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            {{-- contact section --}}
            @if ((isset($managesection) && $managesection['contact_list']) || empty($managesection))
                @if (
                    !empty($vcard->email) ||
                        !empty(
                            $vcard->alternative_email ||
                                !empty($vcard->phone) ||
                                !empty($vcard->alternative_phone) ||
                                !empty($vcard->dob) ||
                                !empty($vcard->location)
                        ))
                    <div class="personal-section position-relative pt-50 px-30 overflow-hidden">
                        <div class="position-absolute vector-2 vector-all text-end">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-2.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                            {{ __('messages.contact_us.contact') }}
                        </p>
                        <div class="personal-details position-relative">
                            <div class="row row-gap-20px" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                @if ($vcard->email)
                                    <div class="col-sm-6">
                                        <div class="details-item">
                                            <div class="details-icon d-flex justify-content-center align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="13"
                                                    viewBox="0 0 18 13" fill="none">
                                                    <path
                                                        d="M9.01754 0.400994C11.2584 0.400994 13.4948 0.396994 15.7357 0.404993C16.0287 0.404993 16.3263 0.43299 16.6104 0.488984C17.1199 0.592973 17.4716 0.880942 17.6925 1.2969C17.8864 1.66086 17.8232 1.86084 17.4445 2.07281C16.953 2.34878 16.4571 2.62075 15.9656 2.89672C13.8194 4.10859 11.6732 5.31246 9.53606 6.53233C9.1483 6.75631 8.8417 6.74831 8.45394 6.52833C5.85236 5.04449 3.23726 3.58065 0.626658 2.10881C0.572552 2.07681 0.513938 2.04882 0.464341 2.01682C0.207339 1.86084 0.157742 1.73685 0.247918 1.47688C0.46885 0.836947 1.01892 0.464987 1.826 0.424991C2.15063 0.408993 2.47527 0.408993 2.79539 0.404993C4.86944 0.404993 6.94349 0.404993 9.01754 0.400994Z"
                                                        fill="#ffffff" />
                                                    <path
                                                        d="M8.98044 12.396C6.7035 12.396 4.43106 12.4 2.15411 12.392C1.87006 12.392 1.57698 12.364 1.30195 12.296C0.747364 12.156 0.404695 11.8081 0.237869 11.3241C0.152202 11.0721 0.201799 10.9481 0.4588 10.8042C2.5599 9.63229 4.66101 8.46042 6.76211 7.28854C6.98304 7.16456 7.2175 7.16456 7.43843 7.28054C7.83521 7.48852 8.22296 7.7045 8.61072 7.92447C8.93085 8.10845 9.06611 8.11245 9.37722 7.93247C9.78752 7.6965 10.2023 7.46852 10.6126 7.23255C10.8336 7.10456 11.0319 7.14456 11.2348 7.26055C11.9067 7.6445 12.5785 8.02446 13.2548 8.40442C14.6345 9.18034 16.0187 9.94826 17.3984 10.7242C17.8222 10.9601 17.8898 11.1561 17.6824 11.5521C17.3984 12.088 16.8844 12.316 16.2577 12.384C16.0998 12.4 15.942 12.4 15.7842 12.4C13.5163 12.396 11.2484 12.396 8.98044 12.396Z"
                                                        fill="#ffffff" />
                                                    <path
                                                        d="M0.23359 9.61629C0.23359 7.46453 0.23359 5.34876 0.23359 3.19699C2.13631 4.27287 4.01197 5.32876 5.91919 6.40464C4.01648 7.48052 2.14081 8.54041 0.23359 9.61629Z"
                                                        fill="#ffffff" />
                                                    <path
                                                        d="M12.096 6.40464C13.9942 5.33276 15.8699 4.27287 17.7726 3.19699C17.7726 5.34076 17.7726 7.45253 17.7726 9.6083C15.8744 8.54041 13.9987 7.48053 12.096 6.40464Z"
                                                        fill="#ffffff" />
                                                </svg>
                                            </div>
                                            <div class="detail-content">
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <div class="text-center position-relative z-2">
                                                    <a href="mailto:{{ $vcard->email }}"
                                                        class="fs-14 fw-5 lh-base text-white mb-0 text-break">
                                                        {{ $vcard->email }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($vcard->alternative_email)
                                    <div class="col-sm-6">
                                        <div class="details-item">
                                            <div class="details-icon d-flex justify-content-center align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="13"
                                                    viewBox="0 0 18 13" fill="none">
                                                    <path
                                                        d="M9.01754 0.400994C11.2584 0.400994 13.4948 0.396994 15.7357 0.404993C16.0287 0.404993 16.3263 0.43299 16.6104 0.488984C17.1199 0.592973 17.4716 0.880942 17.6925 1.2969C17.8864 1.66086 17.8232 1.86084 17.4445 2.07281C16.953 2.34878 16.4571 2.62075 15.9656 2.89672C13.8194 4.10859 11.6732 5.31246 9.53606 6.53233C9.1483 6.75631 8.8417 6.74831 8.45394 6.52833C5.85236 5.04449 3.23726 3.58065 0.626658 2.10881C0.572552 2.07681 0.513938 2.04882 0.464341 2.01682C0.207339 1.86084 0.157742 1.73685 0.247918 1.47688C0.46885 0.836947 1.01892 0.464987 1.826 0.424991C2.15063 0.408993 2.47527 0.408993 2.79539 0.404993C4.86944 0.404993 6.94349 0.404993 9.01754 0.400994Z"
                                                        fill="#ffffff" />
                                                    <path
                                                        d="M8.98044 12.396C6.7035 12.396 4.43106 12.4 2.15411 12.392C1.87006 12.392 1.57698 12.364 1.30195 12.296C0.747364 12.156 0.404695 11.8081 0.237869 11.3241C0.152202 11.0721 0.201799 10.9481 0.4588 10.8042C2.5599 9.63229 4.66101 8.46042 6.76211 7.28854C6.98304 7.16456 7.2175 7.16456 7.43843 7.28054C7.83521 7.48852 8.22296 7.7045 8.61072 7.92447C8.93085 8.10845 9.06611 8.11245 9.37722 7.93247C9.78752 7.6965 10.2023 7.46852 10.6126 7.23255C10.8336 7.10456 11.0319 7.14456 11.2348 7.26055C11.9067 7.6445 12.5785 8.02446 13.2548 8.40442C14.6345 9.18034 16.0187 9.94826 17.3984 10.7242C17.8222 10.9601 17.8898 11.1561 17.6824 11.5521C17.3984 12.088 16.8844 12.316 16.2577 12.384C16.0998 12.4 15.942 12.4 15.7842 12.4C13.5163 12.396 11.2484 12.396 8.98044 12.396Z"
                                                        fill="#ffffff" />
                                                    <path
                                                        d="M0.23359 9.61629C0.23359 7.46453 0.23359 5.34876 0.23359 3.19699C2.13631 4.27287 4.01197 5.32876 5.91919 6.40464C4.01648 7.48052 2.14081 8.54041 0.23359 9.61629Z"
                                                        fill="#ffffff" />
                                                    <path
                                                        d="M12.096 6.40464C13.9942 5.33276 15.8699 4.27287 17.7726 3.19699C17.7726 5.34076 17.7726 7.45253 17.7726 9.6083C15.8744 8.54041 13.9987 7.48053 12.096 6.40464Z"
                                                        fill="#ffffff" />
                                                </svg>
                                            </div>
                                            <div class="detail-content">
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <div class="text-center position-relative z-2">
                                                    <a href="mailto:{{ $vcard->alternative_email }}"
                                                        class="fs-14 fw-5 lh-base text-white mb-0 text-break">
                                                        {{ $vcard->alternative_email }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($vcard->phone)
                                    <div class="col-sm-6">
                                        <div class="details-item">
                                            <div class="details-icon d-flex justify-content-center align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <path
                                                        d="M3.2303 6.92509C4.54459 9.4459 6.41125 11.3579 8.87792 12.6706C8.98268 12.7277 9.2303 12.6611 9.33506 12.566C9.89697 12.0333 10.4494 11.4911 10.9827 10.9298C11.2779 10.6159 11.6017 10.5684 12.0113 10.6445C12.9827 10.8157 13.9636 10.9869 14.9446 11.1011C15.7255 11.1962 16.0017 11.453 16.0017 12.2521C16.0017 13.1082 16.0017 13.9548 16.0017 14.8109C16.0017 15.7336 15.7065 16.019 14.7636 16C8.05887 15.8858 2.05887 11.1296 0.477921 4.60404C0.20173 3.45303 0.116016 2.24495 0.0112543 1.05589C-0.0554124 0.351962 0.335064 0.00951249 1.03983 0.00951249C1.97316 0 2.90649 0 3.83983 0C4.52554 0 4.81125 0.313912 4.89697 0.998811C5.0303 2.00713 5.21125 3.01546 5.40173 4.01427C5.47792 4.44233 5.40173 4.78478 5.08745 5.08918C4.45887 5.69798 3.84935 6.30678 3.2303 6.92509Z"
                                                        fill="#ffffff" />
                                                </svg>
                                            </div>
                                            <div class="detail-content">
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <div class="text-center position-relative z-2">
                                                    <a href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}"
                                                        class="fs-14 fw-5 lh-base text-white mb-0">
                                                        {{ $vcard->region_code }}{{ $vcard->phone }}
                                                    </a>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                @endif
                                @if ($vcard->alternative_phone)
                                    <div class="col-sm-6">
                                        <div class="details-item">
                                            <div class="details-icon d-flex justify-content-center align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <path
                                                        d="M3.2303 6.92509C4.54459 9.4459 6.41125 11.3579 8.87792 12.6706C8.98268 12.7277 9.2303 12.6611 9.33506 12.566C9.89697 12.0333 10.4494 11.4911 10.9827 10.9298C11.2779 10.6159 11.6017 10.5684 12.0113 10.6445C12.9827 10.8157 13.9636 10.9869 14.9446 11.1011C15.7255 11.1962 16.0017 11.453 16.0017 12.2521C16.0017 13.1082 16.0017 13.9548 16.0017 14.8109C16.0017 15.7336 15.7065 16.019 14.7636 16C8.05887 15.8858 2.05887 11.1296 0.477921 4.60404C0.20173 3.45303 0.116016 2.24495 0.0112543 1.05589C-0.0554124 0.351962 0.335064 0.00951249 1.03983 0.00951249C1.97316 0 2.90649 0 3.83983 0C4.52554 0 4.81125 0.313912 4.89697 0.998811C5.0303 2.00713 5.21125 3.01546 5.40173 4.01427C5.47792 4.44233 5.40173 4.78478 5.08745 5.08918C4.45887 5.69798 3.84935 6.30678 3.2303 6.92509Z"
                                                        fill="#ffffff" />
                                                </svg>
                                            </div>
                                            <div class="detail-content">
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <div class="text-center position-relative z-2">
                                                    <a href="tel:+{{ $vcard->region_code }}{{ $vcard->alternative_phone }}"
                                                        class="fs-14 fw-5 lh-base text-white mb-0">
                                                        {{ $vcard->region_code }}{{ $vcard->alternative_phone }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($vcard->dob)
                                    <div class="col-sm-6">
                                        <div class="details-item">
                                            <div class="details-icon d-flex justify-content-center align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16"
                                                    viewBox="0 0 20 16" fill="none">
                                                    <g clip-path="url(#clip0_4330_5418)">
                                                        <path
                                                            d="M0.650877 16C0.570239 15.8532 0.441217 15.7141 0.417026 15.5596C0.376707 15.2815 0.417026 14.9956 0.400898 14.7175C0.392834 14.4626 0.505728 14.3312 0.779899 14.3389C0.860537 14.3389 0.941175 14.3389 1.02181 14.3389C7.01325 14.3389 12.9966 14.3389 18.988 14.3467C19.1896 14.3467 19.3912 14.4239 19.5928 14.4626C19.5928 14.9725 19.5928 15.4901 19.5928 16C13.2869 16 6.96486 16 0.650877 16Z"
                                                            fill="#ffffff" />
                                                        <path
                                                            d="M10.0207 6.55143C12.1738 6.55143 14.3268 6.55143 16.4879 6.55143C17.7056 6.55143 18.3023 7.13086 18.3104 8.30517C18.3104 8.32062 18.3104 8.32835 18.3104 8.3438C18.4555 9.02366 18.1249 9.40995 17.4959 9.67263C16.8589 9.9353 16.246 9.98938 15.6896 9.53356C15.4154 9.30952 15.1896 9.03912 14.9639 8.76871C14.6655 8.42106 14.3833 8.41333 14.0768 8.75326C13.8752 8.97731 13.6736 9.20136 13.4479 9.3945C12.8108 9.94303 12.1093 10.0048 11.3916 9.56447C11.069 9.3636 10.7787 9.10865 10.4965 8.8537C10.1094 8.50604 9.94009 8.50604 9.56109 8.86915C9.34336 9.07774 9.11757 9.27861 8.8676 9.44858C8.02089 10.0357 7.25483 9.99711 6.46457 9.34815C6.34361 9.24771 6.23072 9.13955 6.12589 9.02366C5.58561 8.42878 5.47272 8.42878 4.93244 9.04684C4.19863 9.88122 3.27129 10.0666 2.23912 9.61855C1.83593 9.44085 1.68272 9.17045 1.72303 8.76871C1.74723 8.57557 1.77142 8.38243 1.74723 8.19701C1.61014 7.24674 2.40846 6.53598 3.44063 6.5437C5.62593 6.56688 7.8193 6.55143 10.0207 6.55143Z"
                                                            fill="#ffffff" />
                                                        <path
                                                            d="M18.1493 13.296C12.7223 13.296 7.31954 13.296 1.89258 13.296C1.89258 12.4848 1.89258 11.6736 1.89258 10.8315C3.23924 11.2641 4.41656 10.986 5.38422 9.98939C6.99699 11.4727 8.48073 11.2719 10.0371 9.94304C11.9643 11.55 13.3513 11.1792 14.6657 9.91986C15.1092 10.3757 15.593 10.7929 16.2543 10.9551C16.9074 11.1174 17.5203 10.986 18.1654 10.7233C18.1493 11.5886 18.1493 12.423 18.1493 13.296Z"
                                                            fill="#ffffff" />
                                                        <path
                                                            d="M8.86725 5.82522C8.86725 5.06038 8.85919 4.31098 8.87531 3.55386C8.88338 3.30664 9.06885 3.15985 9.33495 3.15985C9.77846 3.15212 10.222 3.15212 10.6574 3.15985C10.9638 3.15985 11.1413 3.32981 11.1413 3.61566C11.1574 4.34188 11.1493 5.07583 11.1493 5.82522C10.3833 5.82522 9.64138 5.82522 8.86725 5.82522Z"
                                                            fill="#ffffff" />
                                                        <path
                                                            d="M10.0116 0C10.2052 0.339932 10.431 0.726219 10.6487 1.12023C10.7455 1.29792 10.8745 1.47562 10.9309 1.66876C11.0519 2.09367 10.8583 2.55722 10.5116 2.74264C10.1649 2.92805 9.63264 2.87397 9.35041 2.62675C9.05205 2.35635 8.95528 1.83873 9.16494 1.46016C9.43911 0.950265 9.73747 0.455818 10.0116 0Z"
                                                            fill="#ffffff" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_4330_5418">
                                                            <rect width="19.2" height="16" fill="white"
                                                                transform="translate(0.400391)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <div class="detail-content">
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <div class="text-center position-relative z-2">
                                                    <p class="fs-14 fw-5 lh-base text-white mb-0">
                                                        {{ $vcard->dob }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($vcard->location)
                                    <div class="col-sm-6">
                                        <div class="details-item">
                                            <div class="details-icon d-flex justify-content-center align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20"
                                                    viewBox="0 0 16 20" fill="none">
                                                    <g clip-path="url(#clip0_4330_5429)">
                                                        <path
                                                            d="M7.99577 16.1478C7.75467 15.8581 7.52302 15.5832 7.2961 15.3058C6.07168 13.7952 4.91343 12.2325 3.9112 10.551C3.45972 9.79569 3.06498 9.01065 2.72696 8.19094C2.10529 6.67782 2.21166 5.18947 2.89715 3.74817C3.78356 1.88587 5.23727 0.776417 7.20392 0.46686C10.2295 -0.00862098 13.1039 2.21524 13.5979 5.35787C13.7586 6.38808 13.605 7.3539 13.2197 8.29991C12.7895 9.35488 12.234 10.3356 11.6289 11.284C10.5486 12.973 9.34075 14.5554 8.05487 16.076C8.04069 16.0933 8.02414 16.1131 7.99577 16.1478ZM10.8394 5.84326C10.8417 4.20384 9.56531 2.86903 7.99814 2.86903C6.4286 2.86903 5.15454 4.20136 5.15454 5.84078C5.15454 7.4802 6.4286 8.81501 7.99577 8.81501C9.56295 8.81501 10.837 7.48515 10.8394 5.84326Z"
                                                            fill="#ffffff" />
                                                        <path
                                                            d="M5.78681 14.1295C5.51261 14.1716 5.24078 14.2113 4.97131 14.2608C4.15818 14.4069 3.36159 14.6124 2.60992 14.9814C2.31681 15.1275 2.03789 15.2959 1.80861 15.5411C1.43986 15.9373 1.43986 16.3435 1.81806 16.7323C2.13953 17.0641 2.53901 17.2573 2.95266 17.4257C3.75398 17.7476 4.59075 17.9235 5.43934 18.0423C6.6094 18.2083 7.78654 18.2479 8.96606 18.1885C10.2874 18.1216 11.5946 17.9482 12.8544 17.4975C13.2279 17.3638 13.5919 17.2053 13.9134 16.9576C14.0576 16.8462 14.1971 16.7174 14.3081 16.5713C14.5232 16.289 14.5303 15.9745 14.3081 15.6996C14.1569 15.5114 13.9701 15.3405 13.7716 15.2068C13.2161 14.8328 12.5921 14.6199 11.9538 14.4663C11.4244 14.34 10.8878 14.2583 10.3536 14.1568C10.3063 14.1469 10.2614 14.1394 10.2141 14.132C10.3016 13.9388 10.3181 13.9339 10.5096 13.9487C11.2991 14.0131 12.0862 14.1023 12.8592 14.2831C13.2799 14.3797 13.6959 14.496 14.0765 14.7065C14.3152 14.8378 14.5516 14.9913 14.7478 15.1796C15.2513 15.6649 15.3411 16.3385 15.0196 16.9725C14.8471 17.3143 14.5942 17.5842 14.3058 17.8195C13.677 18.3321 12.9608 18.6714 12.2091 18.9314C10.6278 19.4787 8.99915 19.6595 7.3398 19.5852C6.06573 19.5257 4.82003 19.3103 3.61452 18.8596C2.8723 18.5822 2.16553 18.2355 1.56041 17.6907C1.29567 17.4529 1.07111 17.1756 0.929289 16.8363C0.69055 16.2642 0.799283 15.66 1.21767 15.2167C1.5675 14.8452 2.00953 14.6397 2.47046 14.4787C3.10158 14.2583 3.75398 14.1444 4.4111 14.0602C4.77512 14.0131 5.13914 13.9859 5.50552 13.9463C5.6828 13.9289 5.69698 13.9388 5.78681 14.1295Z"
                                                            fill="#ffffff" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_4330_5429">
                                                            <rect width="14.4" height="19.2" fill="white"
                                                                transform="translate(0.800781 0.400024)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <div class="detail-content">
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <span class="animated-border"></span>
                                                <div class="text-center position-relative z-2">
                                                    <p class="fs-14 fw-5 lh-base text-white mb-0">
                                                        {!! ucwords($vcard->location) !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- gallery --}}
            @if ((isset($managesection) && $managesection['galleries']) || empty($managesection))
                @if (checkFeature('gallery') && $vcard->gallery->count())
                    <div class="gallery-section pt-50 px-20 position-relative">
                        <div class="position-absolute vector-3 vector-all">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-3.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <div>
                            <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                                {{ __('messages.plan.gallery') }}
                            </p>
                            <div class="gallery-slider position-relative">
                                @foreach ($vcard->gallery as $file)
                                    @php
                                        $infoPath = pathinfo(public_path($file->gallery_image));
                                        $extension = $infoPath['extension'];
                                    @endphp
                                    <div>
                                        <div class="gallery-img mx-auto w-100">
                                            <div class="expand-icon pe-none">
                                                <i class="fas fa-expand text-primary"></i>
                                            </div>
                                            @if ($file->type == App\Models\Gallery::TYPE_IMAGE)
                                                <a href="{{ $file->gallery_image }}"
                                                    data-lightbox="gallery-images"><img
                                                        src="{{ $file->gallery_image }}" alt="profile"
                                                        class="w-100 h-100 object-fit-contain" loading="lazy" /></a>
                                            @elseif($file->type == App\Models\Gallery::TYPE_FILE)
                                                <a id="file_url" href="{{ $file->gallery_image }}"
                                                    class="gallery-link gallery-file-link" target="_blank"
                                                    loading="lazy">
                                                    <img class="gallery-item gallery-file-item"
                                                        @if ($extension == 'pdf') style="background-image: url({{ asset('assets/images/pdf-icon.png') }})"> @endif
                                                        @if ($extension == 'xls') style="background-image: url({{ asset('assets/images/xls.png') }})"> @endif
                                                        @if ($extension == 'csv') style="background-image: url({{ asset('assets/images/csv-file.png') }})"> @endif
                                                        @if ($extension == 'xlsx') style="background-image: url({{ asset('assets/images/xlsx.png') }})"> @endif
                                                        </img>
                                                </a>
                                            @elseif($file->type == App\Models\Gallery::TYPE_VIDEO)
                                                <video width="100%" height="100%" class="object-fit-contain"
                                                    controls>
                                                    <source src="{{ $file->gallery_image }}">
                                                </video>
                                            @elseif($file->type == App\Models\Gallery::TYPE_AUDIO)
                                                <div class="audio-container mt-2">
                                                    <img src="{{ asset('assets/img/music.jpeg') }}" alt="Album Cover"
                                                        class="audio-image">
                                                    <audio controls src="{{ $file->gallery_image }}"
                                                        class="audio-control">
                                                        Your browser does not support the <code>audio</code> element.
                                                    </audio>
                                                </div>
                                            @else
                                                <iframe
                                                    src="https://www.youtube.com/embed/{{ YoutubeID($file->link) }}"
                                                    class="w-100 h-100">
                                                </iframe>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- our service --}}
            @if ((isset($managesection) && $managesection['services']) || empty($managesection))
                @if (checkFeature('services') && $vcard->services->count())
                    <div class="our-services-section pt-50 position-relative">
                        <div class="position-absolute vector-4 vector-all text-end">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-4.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                            {{ __('messages.vcard.our_service') }}
                        </p>
                        @if ($vcard->services_slider_view)
                            <div class="px-20">
                                <div class="services-slider-view">
                                    @foreach ($vcard->services as $service)
                                        <div>
                                            <div class="service-card h-100">
                                                <div class="clip-img">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="49" viewBox="0 0 20 49" fill="none">
                                                        <path
                                                            d="M5.09042 13.5243L3.45197 13.5243L3.45197 26.0779L5.06511 26.0779L5.09042 13.5243Z"
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
                                                <div class="card-img d-flex justify-content-center align-items-center">
                                                    <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                                                        class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                                                        target="{{ $service->service_url ? '_blank' : '' }}">
                                                        <img src="{{ $service->service_icon }}" alt="branding"
                                                            loading="lazy" class="h-100 w-100 object-fit-cover" />
                                                    </a>
                                                </div>
                                                <div class="card-body text-center">
                                                    <h3 class="card-title fw-6 text-white text-center mb-10">
                                                        {{ ucwords($service->name) }}
                                                    </h3>
                                                    <p
                                                        class="mb-0 text-gray-100 description-text {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}">
                                                        {!! \Illuminate\Support\Str::limit($service->description, 170, '...') !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="px-30">
                                <div class="row services-card row-gap-24px">
                                    @foreach ($vcard->services as $service)
                                        <div class="col-sm-6">
                                            <div class="service-card h-100 flex-column d-flex">
                                                <div class="clip-img">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="49" viewBox="0 0 20 49" fill="none">
                                                        <path
                                                            d="M5.09042 13.5243L3.45197 13.5243L3.45197 26.0779L5.06511 26.0779L5.09042 13.5243Z"
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
                                                <div class="card-img d-flex justify-content-center align-items-center">
                                                    <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                                                        class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                                                        target="{{ $service->service_url ? '_blank' : '' }}">
                                                        <img src="{{ $service->service_icon }}" alt="branding"
                                                            loading="lazy" class="h-100 w-100 object-fit-cover" />
                                                    </a>
                                                </div>
                                                <div class="card-body text-center">
                                                    <h3 class="card-title fw-6 text-white mb-10">
                                                        {{ ucwords($service->name) }}
                                                    </h3>
                                                    <p
                                                        class="mb-0 fs-14 text-gray-100 description-text {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}">
                                                        {!! \Illuminate\Support\Str::limit($service->description, 170, '...') !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
            {{-- Make an Appointment --}}
            @if ((isset($managesection) && $managesection['appointments']) || empty($managesection))
                @if (checkFeature('appointments') && $vcard->appointmentHours->count())
                    <div class="appointment-section pt-50 px-30 position-relative">
                        <div class="position-absolute vector-5 vector-all">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-5.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px ">
                            {{ __('messages.make_appointments') }}
                        </p>
                        <div class="book-select">
                            <span class="animated-border"></span>
                            <span class="animated-border"></span>
                            <span class="animated-border"></span>
                            <span class="animated-border"></span>
                            <div>
                                <div class="position-relative">
                                    {{ Form::text('date', null, [
                                        'class' =>
                                            'date form-control appointment-input ' .
                                            (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian'
                                                ? 'text-end'
                                                : 'text-start'),
                                        'placeholder' => __('messages.form.pick_date'),
                                        'id' => 'pickUpDate',
                                    ]) }}
                                    <span class="calendar-icon"><svg width="20" height="20"
                                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.25 9.375V10.625C6.25 10.9705 5.97047 11.25 5.625 11.25H4.375C4.02953 11.25 3.75 10.9705 3.75 10.625V9.375C3.75 9.02953 4.02953 8.75 4.375 8.75H5.625C5.97047 8.75 6.25 9.02953 6.25 9.375ZM5.625 13.75H4.375C4.02953 13.75 3.75 14.0295 3.75 14.375V15.625C3.75 15.9705 4.02953 16.25 4.375 16.25H5.625C5.97047 16.25 6.25 15.9705 6.25 15.625V14.375C6.25 14.0295 5.97047 13.75 5.625 13.75ZM10.625 8.75H9.375C9.02953 8.75 8.75 9.02953 8.75 9.375V10.625C8.75 10.9705 9.02953 11.25 9.375 11.25H10.625C10.9705 11.25 11.25 10.9705 11.25 10.625V9.375C11.25 9.02953 10.9705 8.75 10.625 8.75ZM10.625 13.75H9.375C9.02953 13.75 8.75 14.0295 8.75 14.375V15.625C8.75 15.9705 9.02953 16.25 9.375 16.25H10.625C10.9705 16.25 11.25 15.9705 11.25 15.625V14.375C11.25 14.0295 10.9705 13.75 10.625 13.75ZM15.625 8.75H14.375C14.0295 8.75 13.75 9.02953 13.75 9.375V10.625C13.75 10.9705 14.0295 11.25 14.375 11.25H15.625C15.9705 11.25 16.25 10.9705 16.25 10.625V9.375C16.25 9.02953 15.9705 8.75 15.625 8.75ZM15.625 13.75H14.375C14.0295 13.75 13.75 14.0295 13.75 14.375V15.625C13.75 15.9705 14.0295 16.25 14.375 16.25H15.625C15.9705 16.25 16.25 15.9705 16.25 15.625V14.375C16.25 14.0295 15.9705 13.75 15.625 13.75ZM4.375 3.75H5.625C5.97047 3.75 6.25 3.47047 6.25 3.125V0.625C6.25 0.279531 5.97047 0 5.625 0H4.375C4.02953 0 3.75 0.279531 3.75 0.625V3.125C3.75 3.47047 4.02953 3.75 4.375 3.75ZM20 5V17.5C20 18.8806 18.8806 20 17.5 20H2.5C1.11937 20 0 18.8806 0 17.5V5C0 3.61937 1.11937 2.5 2.5 2.5H3.125V3.125C3.125 3.81348 3.6859 4.375 4.375 4.375H5.625C6.3141 4.375 6.875 3.81348 6.875 3.125V2.5H13.125V3.125C13.125 3.81348 13.6865 4.375 14.375 4.375H15.625C16.3135 4.375 16.875 3.81348 16.875 3.125V2.5H17.5C18.8806 2.5 20 3.61937 20 5ZM18.75 7.5C18.75 6.81152 18.1897 6.25 17.5 6.25H2.5C1.8109 6.25 1.25 6.81152 1.25 7.5V17.5C1.25 18.1897 1.8109 18.75 2.5 18.75H17.5C18.1897 18.75 18.75 18.1897 18.75 17.5V7.5ZM14.375 3.75H15.625C15.9705 3.75 16.25 3.47047 16.25 3.125V0.625C16.25 0.279531 15.9705 0 15.625 0H14.375C14.0295 0 13.75 0.279531 13.75 0.625V3.125C13.75 3.47047 14.0295 3.75 14.375 3.75Z"
                                                fill="#171510" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div id="slotData" class="row">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="appointmentAdd btn btn-primary time-btn mt-3 d-none">
                                    {{ __('messages.make_appointments') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    @include('vcardTemplates.appointment')
                @endif
            @endif
            {{-- Products Section --}}
            @if ((isset($managesection) && $managesection['products']) || empty($managesection))
                @if (checkFeature('products') && $vcard->products->count())
                    <div class="product-section pt-50 px-20 position-relative">
                        <div class="position-absolute vector-6 vector-all text-end">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-6.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                            {{ __('messages.plan.products') }}
                        </p>
                        <div class="product-slider">
                            @foreach ($vcard->products as $product)
                                <div>
                                    <div class="product-card">
                                        <div class="clip-img">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="49"
                                                viewBox="0 0 20 49" fill="none">
                                                <path
                                                    d="M5.09042 13.5243L3.45197 13.5243L3.45197 26.0779L5.06511 26.0779L5.09042 13.5243Z"
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
                                        <a @if ($product->product_url) href="{{ $product->product_url }}" @endif
                                            target="_blank" class="text-decoration-none position-relative">
                                            <div class="product-img">
                                                <img src="{{ $product->product_icon }}" alt="image"
                                                    class="w-100 h-100 object-fit-cover" />
                                            </div>
                                        </a>
                                        <div class="product-desc p-3">
                                            <h2 class="text-white text-center mb-1 product-title">
                                                {{ $product->name }}
                                            </h2>
                                            <p class="product-amount text-primary text-center fw-6 mb-0">
                                                @if ($product->currency_id && $product->price)
                                                    <span
                                                        class="fw-6 text-primary">{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                                                @elseif($product->price)
                                                    <span
                                                        class="fw-6 text-primary">{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                        <div class="mt-5  d-flex justify-content-center">
                            <a class="btn btn-primary view-more"
                                href="{{ $vcardProductUrl }}">{{ __('messages.analytics.view_more') }}
                                <i class="fa-solid fa-arrow-right-long right-arrow-animation"></i>
                            </a>

                        </div>
                    </div>
                @endif
            @endif
            {{-- Testimonial Section --}}
            @if ((isset($managesection) && $managesection['testimonials']) || empty($managesection))
                @if (checkFeature('testimonials') && $vcard->testimonials->count())
                    <div class="testimonial-section pt-50 px-20 position-relative overflow-hidden">
                        <div class="position-absolute vector-7 vector-all">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-7.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                            {{ __('messages.plan.testimonials') }}
                        </p>
                        <div class="testimonial-slider">
                            @foreach ($vcard->testimonials as $testimonial)
                                <div class="position-relative">
                                    <div class="testimonial-card">
                                        <div class="test position-relative z-2">
                                            <div
                                                class="img-bg mb-3 mx-auto d-flex justify-content-center align-items-center">
                                                <div class="test-img rounded-circle">
                                                    <img src="{{ $testimonial->image_url }}" alt="images"
                                                        class="h-100 w-100 object-fit-cover rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="test-content">
                                                <h2
                                                    class="fw-semibold text-white text-decoration-underline  mb-3 text-center">
                                                    {{ ucwords($testimonial->name) }}
                                                </h2>
                                                <p
                                                    class="lh-sm text-gray-100 mb-0 text-center {{ \Illuminate\Support\Str::length($testimonial->description) > 80 ? 'more' : '' }}">
                                                    " {!! $testimonial->description !!}"
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- insta feed --}}
            @if ((isset($managesection) && $managesection['insta_embed']) || empty($managesection))
                @if (checkFeature('insta_embed') && $vcard->instagramEmbed->count())
                    <div class="pt-50 px-30 position-relative">
                        <div class="position-absolute vector-8 vector-all text-end">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-8.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <div class="position-relative">
                            <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                                {{ __('messages.feature.insta_embed') }}
                            </p>

                            <nav>
                                <div class="row insta-toggle">
                                    <div class="nav nav-tabs border-0 px-0" id="nav-tab" role="tablist">
                                        <button
                                            class="d-flex align-items-center justify-content-center active postbtn instagram-btn  border-0 text-dark"
                                            id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                                            type="button" role="tab" aria-controls="nav-home"
                                            aria-selected="true">
                                            <svg aria-label="Posts" class="svg-post-icon x1lliihq x1n2onr6 x173jzuc"
                                                fill="currentColor" height="24" role="img"
                                                viewBox="0 0 24 24" width="24">
                                                <title>Posts</title>
                                                <rect fill="none" height="18" stroke="currentColor"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    width="18" x="3" y="3"></rect>
                                                <line fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" x1="9.015"
                                                    x2="9.015" y1="3" y2="21">
                                                </line>
                                                <line fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" x1="14.985"
                                                    x2="14.985" y1="3" y2="21">
                                                </line>
                                                <line fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" x1="21"
                                                    x2="3" y1="9.015" y2="9.015">
                                                </line>
                                                <line fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" x1="21"
                                                    x2="3" y1="14.985" y2="14.985">
                                                </line>
                                            </svg>
                                        </button>
                                        <button
                                            class="d-flex align-items-center justify-content-center instagram-btn reelsbtn  border-0 text-dark mr-0"
                                            id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                                            type="button" role="tab" aria-controls="nav-profile"
                                            aria-selected="false">
                                            <svg class="svg-reels-icon" viewBox="0 0 48 48" width="27"
                                                height="27">
                                                <path
                                                    d="m33,6H15c-.16,0-.31,0-.46.01-.7401.04-1.46.17-2.14.38-3.7,1.11-6.4,4.55-6.4,8.61v18c0,4.96,4.04,9,9,9h18c4.96,0,9-4.04,9-9V15c0-4.96-4.04-9-9-9Zm7,27c0,3.86-3.14,7-7,7H15c-3.86,0-7-3.14-7-7V15c0-3.37,2.39-6.19,5.57-6.85.46-.1.94-.15,1.43-.15h18c3.86,0,7,3.14,7,7v18Z"
                                                    fill="currentColor" class="color000 svgShape not-active-svg">
                                                </path>
                                                <path
                                                    d="M21 16h-2.2l-.66-1-4.57-6.85-.76-1.15h2.39l.66 1 4.67 7 .3.45c.11.17.17.36.17.55zM34 16h-2.2l-.66-1-4.67-7-.66-1h2.39l.66 1 4.67 7 .3.45c.11.17.17.36.17.55z"
                                                    fill="currentColor" class="color000 svgShape not-active-svg">
                                                </path>
                                                <rect width="36" height="3" x="6" y="15" fill="currentColor"
                                                    class="color000 svgShape"></rect>
                                                <path
                                                    d="m20,35c-.1753,0-.3506-.0459-.5073-.1382-.3052-.1797-.4927-.5073-.4927-.8618v-10c0-.3545.1875-.6821.4927-.8618.3066-.1797.6831-.1846.9932-.0122l9,5c.3174.1763.5142.5107.5142.874s-.1968.6978-.5142.874l-9,5c-.1514.084-.3188.126-.4858.126Zm1-9.3003v6.6006l5.9409-3.3003-5.9409-3.3003Z"
                                                    fill="currentColor" class="color000 svgShape not-active-svg">
                                                </path>
                                                <path
                                                    d="m6,33c0,4.96,4.04,9,9,9h18c4.96,0,9-4.04,9-9v-16H6v16Zm13-9c0-.35.19-.68.49-.86.31-.18.69-.19,1-.01l9,5c.31.17.51.51.51.87s-.2.7-.51.87l-9,5c-.16.09-.3199.13-.49.13-.18,0-.35-.05-.51-.14-.3-.18-.49-.51-.49-.86v-10Zm23-9c0-4.96-4.04-9-9-9h-5.47l6,9h8.47Zm-10.86,0l-6.01-9h-10.13c-.16,0-.31,0-.46.01l5.99,8.99h10.61ZM12.4,6.39c-3.7,1.11-6.4,4.55-6.4,8.61h12.14l-5.74-8.61Z"
                                                    fill="currentColor" class="color000 svgShape active-svg"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        <div id="postContent" class="insta-feed">
                            <div class="row overflow-hidden mt-2 row-gap-20px" loading="lazy">
                                <!-- "Post" content -->
                                @foreach ($vcard->InstagramEmbed as $InstagramEmbed)
                                    @if ($InstagramEmbed->type == 0)
                                        <div class="col-12 col-sm-6 insta-feed-iframe">
                                            {!! $InstagramEmbed->embedtag !!}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="d-none insta-feed" id="reelContent">
                            <div class="row overflow-hidden mt-2 row-gap-20px">
                                <!-- "Reel" content -->
                                @foreach ($vcard->InstagramEmbed as $InstagramEmbed)
                                    @if ($InstagramEmbed->type == 1)
                                        <div class="col-12 col-sm-6 insta-feed-iframe">
                                            {!! $InstagramEmbed->embedtag !!}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- Linkedin --}}
            @if ((isset($managesection) && $managesection['linkedin_embed']) || empty($managesection))
                @if (checkFeature('linkedin_embed') && $vcard->linkedinEmbed->count())
                    <div class="pt-50 px-30 position-relative">
                        <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                            {{ __('messages.feature.linkedin_embed') }}
                        </p>

                        <div class="linkedin-feed">
                            <div class="row overflow-hidden mt-2 row-gap-20px" loading="lazy">
                                <!-- "Post" content -->
                                @foreach ($vcard->LinkedinEmbed as $LinkedinEmbed)
                                    @if ($LinkedinEmbed->type == 0)
                                        <div class="col-12 col-sm-6 linkedin-feed-iframe">
                                            {!! $LinkedinEmbed->embedtag !!}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- Blog Section --}}
            @if ((isset($managesection) && $managesection['blogs']) || empty($managesection))
                @if (checkFeature('blog') && $vcard->blogs->count())
                    <div class="blog-section position-relative pt-50 px-20">
                        <div class="position-absolute vector-9 vector-all">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-9.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                            {{ __('messages.feature.blog') }}
                        </p>
                        <div class="blog-slider position-relative">
                            @foreach ($vcard->blogs as $blog)
                                <?php
                                $vcardBlogUrl = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/blog/{$blog->id}" : route('vcard.show-blog', [$vcard->url_alias, $blog->id]);
                                ?>
                                <div>
                                    <div class="blog-card mx-auto position-relative">

                                        <div class="blog-img">
                                            <a href="{{ $vcardBlogUrl }}">
                                                <img src="{{ $blog->blog_icon }}" alt="images"
                                                    class="h-100 w-100 object-fit-cover" />
                                            </a>
                                        </div>
                                        <div class="blog-test" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                            <h2 class="fw-6 text-white mb-1 blog-title">
                                                {{ $blog->title }}
                                            </h2>
                                            <p class="fs-14 text-gray-100  mb-0 blog-content">
                                                {{ Illuminate\Support\Str::words(strip_tags($blog->description), 100, '...') }}
                                            </p>
                                            <div class="d-flex align-items-center justify-content-end mt-1"
                                                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                                <a href="{{ $vcardBlogUrl }}"
                                                    class="text-primary d-inline-flex align-items-center justify-content-end gap-2 text-decoration-underline">
                                                    {{ __('messages.vcard_11.read_more') }}
                                                    <svg class="svg-inline--fa fa-arrow-right-long  text-decoration-none"
                                                        aria-hidden="true" focusable="false" data-prefix="fas"
                                                        data-icon="arrow-right-long" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                        data-fa-i2svg="">
                                                        <path fill="currentColor"
                                                            d="M502.6 278.6l-128 128c-12.51 12.51-32.76 12.49-45.25 0c-12.5-12.5-12.5-32.75 0-45.25L402.8 288H32C14.31 288 0 273.7 0 255.1S14.31 224 32 224h370.8l-73.38-73.38c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l128 128C515.1 245.9 515.1 266.1 502.6 278.6z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- Business Hours Section --}}
            @if ((isset($managesection) && $managesection['business_hours']) || empty($managesection))
                @if ($vcard->businessHours->count())
                    @php
                        $todayWeekName = strtolower(\Carbon\Carbon::now()->rawFormat('D'));
                    @endphp
                    <div class="business-hour position-relative pt-50 px-30"
                        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                        <div class="position-absolute vector-10 vector-all text-end">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-10.png') }}" alt="images"
                                class="w-100" />
                        </div>

                        <p
                            class="section-heading text-white fs-24 lh-base fw-semibold mx-auto business-title text-center position-relative mb-40px">
                            {{ __('messages.business.business_hours') }}
                        </p>

                        <div class="time-table row justify-content-center row-gap-20px">
                            @php
                                $weekFormat = $vcard->week_format ?? 1;

                                if ($weekFormat == 2) {
                                    $businessDaysTime = collect($businessDaysTime)
                                        ->sortKeysUsing(function ($a, $b) {
                                            if ($a == 7) {
                                                return -1;
                                            } // Sunday first
                                            if ($b == 7) {
                                                return 1;
                                            }
                                            return $a <=> $b;
                                        })
                                        ->toArray();
                                }
                            @endphp
                            @foreach ($businessDaysTime as $key => $dayTime)
                                <div class="col-sm-6">
                                    <div
                                        class="time-table-hour  d-flex flex-column align-items-center justify-content-center">
                                        <span class="time-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="none" stroke="#ffffff" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3">
                                                </path>
                                                <path d="M16 3v4"></path>
                                                <path d="M8 3v4"></path>
                                                <path d="M4 11h10"></path>
                                                <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                <path d="M18 16.5v1.5l.5 .5"></path>
                                            </svg>
                                        </span>
                                        <div class="time-details w-100">
                                            <span class="animated-border"></span>
                                            <span class="animated-border"></span>
                                            <span class="animated-border"></span>
                                            <span class="animated-border"></span>
                                            <div>
                                                <p class="fs-14 lh-base mb-0 text-gray-100 text-center">
                                                    {{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}:
                                                </p>
                                                <p class="fw-5 mb-0 text-white text-center">
                                                    {{ $dayTime ?? __('messages.common.closed') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- Qr code Section --}}
            @if (isset($vcard['show_qr_code']) && $vcard['show_qr_code'] == 1)
                <div class="qr-section pt-50 px-30 position-relative">
                    <div class="position-absolute vector-11 vector-all">
                        <img src="{{ asset('assets/img/vcard34/bg-vector-11.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                        {{ __('messages.vcard.qr_code') }}
                    </p>
                    <div class="qr-code-wrapper d-flex justify-content-center align-items-center m-0 flex-column flex-sm-row gap-4"
                        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                        <div class="img-bg d-flex justify-content-center align-items-center">
                            <div class="qr-img d-flex justify-content-center align-items-center"
                                id="qr-code-thirtyfour">
                                @if (isset($customQrCode['applySetting']) && $customQrCode['applySetting'] == 1)
                                    {!! QrCode::color(
                                        $qrcodeColor['qrcodeColor']->red(),
                                        $qrcodeColor['qrcodeColor']->green(),
                                        $qrcodeColor['qrcodeColor']->blue(),
                                    )->backgroundColor(
                                            $qrcodeColor['background_color']->red(),
                                            $qrcodeColor['background_color']->green(),
                                            $qrcodeColor['background_color']->blue(),
                                        )->style($customQrCode['style'])->eye($customQrCode['eye_style'])->size(130)->format('svg')->generate(Request::url()) !!}
                                @else
                                    {!! QrCode::size(130)->format('svg')->generate(Request::url()) !!}
                                @endif
                            </div>
                        </div>

                        <div
                            class="text-center @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @else text-sm-start @endif">
                            <h5 class="fw-6 text-white">{{ __('messages.vcard.scan_to_contact') }}</h5>
                            <p class="fs-14 text-gray-100 mb-0">{{ __('messages.vcard.qr_section_desc') }}</p>
                        </div>

                    </div>
                </div>
            @endif
            {{-- iframe --}}
            @if ((isset($managesection) && $managesection['iframe']) || empty($managesection))
                @if (checkFeature('iframes') && $vcard->iframes->count())
                    <div class="iframe-section pt-50 px-20 position-relative">
                        <div class="position-absolute vector-12 vector-all text-end">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-12.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                            {{ __('messages.vcard.iframe') }}
                        </p>
                        <div class="iframe-slider">
                            @foreach ($vcard->iframes as $iframe)
                                <div>
                                    <div class="iframe-card">
                                        <iframe src="{{ $iframe->url }}" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen width="100%" height="100%">
                                        </iframe>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- Contact Us Section --}}
            @php
                $currentSubs = $vcard
                    ->subscriptions()
                    ->where('status', \App\Models\Subscription::ACTIVE)
                    ->latest()
                    ->first();
            @endphp
            @if ($currentSubs && $currentSubs->plan->planFeature->enquiry_form && $vcard->enable_enquiry_form)
                <div class="contact-section pt-50 px-30 position-relative"
                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <div class="position-absolute vector-13 vector-all">
                        <img src="{{ asset('assets/img/vcard34/bg-vector-13.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    <p class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px">
                        {{ __('messages.contact_us.inquries') }}
                    </p>
                    <div class="contact-form">
                        <span class="animated-border"></span>
                        <span class="animated-border"></span>
                        <span class="animated-border"></span>
                        <span class="animated-border"></span>
                        <form action="" id="enquiryForm" enctype="multipart/form-data">
                            @csrf
                            <div id="enquiryError" class="alert alert-danger d-none"></div>
                            <div class="mb-20px">
                                <input type="text" class="form-control fs-16 lh-base"
                                    placeholder="{{ __('messages.form.your_name') }}" name="name" />
                            </div>
                            <div class="mb-20px">
                                <input type="tel"
                                    class="form-control fs-16 lh-base @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-end @endif"
                                    placeholder="{{ __('messages.form.phone') }}" name="phone"
                                    onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,&quot;&quot;)" />
                            </div>
                            <div class="mb-20px">
                                <input type="email" class="form-control fs-16 lh-base"
                                    placeholder="{{ __('messages.form.your_email') }}" name="email" />
                            </div>
                            <div class="mb-20px">
                                <textarea rows="3" placeholder="{{ __('messages.form.type_message') }}" name="message" rows="4"
                                    class="w-100 border-top-0 border-start-0 border-end-0"></textarea>
                            </div>
                            @if (isset($inquiry) && $inquiry == 1)
                                <div class="mb-3 mt-3">
                                    <div class="wrapper-file-input">
                                        <div class="input-box" id="fileInputTrigger">
                                            <h4> <i
                                                    class="fa-solid fa-upload me-2"></i>{{ __('messages.choose_file') }}
                                            </h4> <input type="file" id="attachment" name="attachment" hidden
                                                multiple />
                                        </div>
                                        <small class="text-gray-100">{{ __('messages.file_supported') }}</small>
                                    </div>
                                    <div class="wrapper-file-section">
                                        <div class="selected-files" id="selectedFilesSection" style="display: none;">
                                            <h5>{{ __('messages.selected_files') }}</h5>
                                            <ul class="file-list" id="fileList"></ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                                <div class="col-12 mb-4">
                                    <div class="d-flex gap-2">
                                        <input type="checkbox" name="terms_condition"
                                            class="form-check-input terms-condition" id="termConditionCheckbox"
                                            placeholder>&nbsp;
                                        <label class="form-check-label fs-14" for="privacyPolicyCheckbox">
                                            <span class="text-white">{{ __('messages.vcard.agree_to_our') }}</span>
                                            <a href="{{ $vcardPrivacyAndTerm }}" target="_blank"
                                                class="text-decoration-none link-info fs-14 text-primary text-decoration-underline fw-6">{!! __('messages.vcard.term_and_condition') !!}</a>
                                            <span class="text-white">&</span>
                                            <a href="{{ $vcardPrivacyAndTerm }}" target="_blank"
                                                class="text-decoration-none link-info fs-14 text-primary text-decoration-underline fw-6">{{ __('messages.vcard.privacy_policy') }}</a>
                                        </label>
                                    </div>
                                </div>
                            @endif
                            <div class="text-center">
                                <button class="btn btn-primary send-btn contact-btn" type="submit">
                                    {{ __('messages.contact_us.send_message') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            {{-- create your vcard --}}
            @if ($currentSubs && $currentSubs->plan->planFeature->affiliation && $vcard->enable_affiliation)
                <div class="v-card-section">
                    <div class="position-relative pt-50 px-30">
                        <div class="position-absolute vector-14 vector-all text-end">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-14.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <p
                            class="section-heading text-white fs-24 lh-base fw-semibold mx-auto mb-40px position-relative z-2">
                            {{ __('messages.create_vcard') }}
                        </p>
                        <div class="d-flex justify-content-center align-items-center position-relative z-1"
                            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                            <div
                                class="input-group v-card-input d-flex justify-content-center align-items-center flex-nowrap position-relative z-2 gap-3">
                                <div class="text-primary fs-16 lh-base text-break fw-medium">
                                    <a href="{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}"
                                        class="text-white link-text fw-normal ">{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}</a>
                                </div>
                                <div class="input-group-append">
                                    <i class="icon fa-solid fa-arrow-up-right-from-square text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- map --}}
            @if ((isset($managesection) && $managesection['map']) || empty($managesection))
                @if ($vcard->location_url && isset($url[5]))
                    <div class="map-section pt-50 px-30 position-relative">
                        <div class="position-absolute vector-15 vector-all">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-15.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <div class="map-content">
                            <div class="content">
                                <div class="d-flex gap-2 align-items-center p-2"
                                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                    <div class="location-icon d-flex justify-content-center align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20"
                                            viewBox="0 0 16 20" fill="none">
                                            <g clip-path="url(#clip0_4330_5429)">
                                                <path
                                                    d="M7.99577 16.1478C7.75467 15.8581 7.52302 15.5832 7.2961 15.3058C6.07168 13.7952 4.91343 12.2325 3.9112 10.551C3.45972 9.79569 3.06498 9.01065 2.72696 8.19094C2.10529 6.67782 2.21166 5.18947 2.89715 3.74817C3.78356 1.88587 5.23727 0.776417 7.20392 0.46686C10.2295 -0.00862098 13.1039 2.21524 13.5979 5.35787C13.7586 6.38808 13.605 7.3539 13.2197 8.29991C12.7895 9.35488 12.234 10.3356 11.6289 11.284C10.5486 12.973 9.34075 14.5554 8.05487 16.076C8.04069 16.0933 8.02414 16.1131 7.99577 16.1478ZM10.8394 5.84326C10.8417 4.20384 9.56531 2.86903 7.99814 2.86903C6.4286 2.86903 5.15454 4.20136 5.15454 5.84078C5.15454 7.4802 6.4286 8.81501 7.99577 8.81501C9.56295 8.81501 10.837 7.48515 10.8394 5.84326Z"
                                                    fill="#ffffff" />
                                                <path
                                                    d="M5.78681 14.1295C5.51261 14.1716 5.24078 14.2113 4.97131 14.2608C4.15818 14.4069 3.36159 14.6124 2.60992 14.9814C2.31681 15.1275 2.03789 15.2959 1.80861 15.5411C1.43986 15.9373 1.43986 16.3435 1.81806 16.7323C2.13953 17.0641 2.53901 17.2573 2.95266 17.4257C3.75398 17.7476 4.59075 17.9235 5.43934 18.0423C6.6094 18.2083 7.78654 18.2479 8.96606 18.1885C10.2874 18.1216 11.5946 17.9482 12.8544 17.4975C13.2279 17.3638 13.5919 17.2053 13.9134 16.9576C14.0576 16.8462 14.1971 16.7174 14.3081 16.5713C14.5232 16.289 14.5303 15.9745 14.3081 15.6996C14.1569 15.5114 13.9701 15.3405 13.7716 15.2068C13.2161 14.8328 12.5921 14.6199 11.9538 14.4663C11.4244 14.34 10.8878 14.2583 10.3536 14.1568C10.3063 14.1469 10.2614 14.1394 10.2141 14.132C10.3016 13.9388 10.3181 13.9339 10.5096 13.9487C11.2991 14.0131 12.0862 14.1023 12.8592 14.2831C13.2799 14.3797 13.6959 14.496 14.0765 14.7065C14.3152 14.8378 14.5516 14.9913 14.7478 15.1796C15.2513 15.6649 15.3411 16.3385 15.0196 16.9725C14.8471 17.3143 14.5942 17.5842 14.3058 17.8195C13.677 18.3321 12.9608 18.6714 12.2091 18.9314C10.6278 19.4787 8.99915 19.6595 7.3398 19.5852C6.06573 19.5257 4.82003 19.3103 3.61452 18.8596C2.8723 18.5822 2.16553 18.2355 1.56041 17.6907C1.29567 17.4529 1.07111 17.1756 0.929289 16.8363C0.69055 16.2642 0.799283 15.66 1.21767 15.2167C1.5675 14.8452 2.00953 14.6397 2.47046 14.4787C3.10158 14.2583 3.75398 14.1444 4.4111 14.0602C4.77512 14.0131 5.13914 13.9859 5.50552 13.9463C5.6828 13.9289 5.69698 13.9388 5.78681 14.1295Z"
                                                    fill="#ffffff" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_4330_5429">
                                                    <rect width="14.4" height="19.2" fill="white"
                                                        transform="translate(0.800781 0.400024)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <p class="text-white mb-0">{!! ucwords($vcard->location) !!}</p>
                                </div>
                            </div>

                            <iframe width="100%" height="300px" class="d-block"
                                src='https://maps.google.de/maps?q={{ $url[5] }}/&output=embed'
                                frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                style="border-radius:0 0 5px 5px;"></iframe>
                        </div>
                    </div>
                @endif
                @if ($vcard->location_type == 1 && !empty($vcard->location_embed_tag))
                    <div class="map-section pt-50 px-30 position-relative">
                        <div class="position-absolute vector-15 vector-all">
                            <img src="{{ asset('assets/img/vcard34/bg-vector-15.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <div class="map-content">
                            <div class="content">
                                <div class="d-flex gap-2 align-items-center p-2"
                                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                    <div class="location-icon d-flex justify-content-center align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20"
                                            viewBox="0 0 16 20" fill="none">
                                            <g clip-path="url(#clip0_4330_5429)">
                                                <path
                                                    d="M7.99577 16.1478C7.75467 15.8581 7.52302 15.5832 7.2961 15.3058C6.07168 13.7952 4.91343 12.2325 3.9112 10.551C3.45972 9.79569 3.06498 9.01065 2.72696 8.19094C2.10529 6.67782 2.21166 5.18947 2.89715 3.74817C3.78356 1.88587 5.23727 0.776417 7.20392 0.46686C10.2295 -0.00862098 13.1039 2.21524 13.5979 5.35787C13.7586 6.38808 13.605 7.3539 13.2197 8.29991C12.7895 9.35488 12.234 10.3356 11.6289 11.284C10.5486 12.973 9.34075 14.5554 8.05487 16.076C8.04069 16.0933 8.02414 16.1131 7.99577 16.1478ZM10.8394 5.84326C10.8417 4.20384 9.56531 2.86903 7.99814 2.86903C6.4286 2.86903 5.15454 4.20136 5.15454 5.84078C5.15454 7.4802 6.4286 8.81501 7.99577 8.81501C9.56295 8.81501 10.837 7.48515 10.8394 5.84326Z"
                                                    fill="#ffffff" />
                                                <path
                                                    d="M5.78681 14.1295C5.51261 14.1716 5.24078 14.2113 4.97131 14.2608C4.15818 14.4069 3.36159 14.6124 2.60992 14.9814C2.31681 15.1275 2.03789 15.2959 1.80861 15.5411C1.43986 15.9373 1.43986 16.3435 1.81806 16.7323C2.13953 17.0641 2.53901 17.2573 2.95266 17.4257C3.75398 17.7476 4.59075 17.9235 5.43934 18.0423C6.6094 18.2083 7.78654 18.2479 8.96606 18.1885C10.2874 18.1216 11.5946 17.9482 12.8544 17.4975C13.2279 17.3638 13.5919 17.2053 13.9134 16.9576C14.0576 16.8462 14.1971 16.7174 14.3081 16.5713C14.5232 16.289 14.5303 15.9745 14.3081 15.6996C14.1569 15.5114 13.9701 15.3405 13.7716 15.2068C13.2161 14.8328 12.5921 14.6199 11.9538 14.4663C11.4244 14.34 10.8878 14.2583 10.3536 14.1568C10.3063 14.1469 10.2614 14.1394 10.2141 14.132C10.3016 13.9388 10.3181 13.9339 10.5096 13.9487C11.2991 14.0131 12.0862 14.1023 12.8592 14.2831C13.2799 14.3797 13.6959 14.496 14.0765 14.7065C14.3152 14.8378 14.5516 14.9913 14.7478 15.1796C15.2513 15.6649 15.3411 16.3385 15.0196 16.9725C14.8471 17.3143 14.5942 17.5842 14.3058 17.8195C13.677 18.3321 12.9608 18.6714 12.2091 18.9314C10.6278 19.4787 8.99915 19.6595 7.3398 19.5852C6.06573 19.5257 4.82003 19.3103 3.61452 18.8596C2.8723 18.5822 2.16553 18.2355 1.56041 17.6907C1.29567 17.4529 1.07111 17.1756 0.929289 16.8363C0.69055 16.2642 0.799283 15.66 1.21767 15.2167C1.5675 14.8452 2.00953 14.6397 2.47046 14.4787C3.10158 14.2583 3.75398 14.1444 4.4111 14.0602C4.77512 14.0131 5.13914 13.9859 5.50552 13.9463C5.6828 13.9289 5.69698 13.9388 5.78681 14.1295Z"
                                                    fill="#ffffff" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_4330_5429">
                                                    <rect width="14.4" height="19.2" fill="white"
                                                        transform="translate(0.800781 0.400024)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <p class="text-white mb-0">{!! ucwords($vcard->location) !!}</p>
                                </div>
                            </div>

                            <div class="embed-responsive embed-responsive-16by9 rounded overflow-hidden"
                                style="height: 300px;">
                                {!! $vcard->location_embed_tag ?? '' !!}
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- add to contact --}}
            @if ($vcard->enable_contact)
                <div class="add-to-contact-section">
                    <div class="text-center d-flex align-items-center justify-content-center"
                        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                        @if ($contactRequest == 1)
                            <a href="{{ Auth::check() ? route('add-contact', $vcard->id) : 'javascript:void(0);' }}"
                                class="add-contact-btn btn btn-primary {{ Auth::check() ? 'auth-contact-btn' : 'ask-contact-detail-form' }}"
                                data-action="{{ Auth::check() ? route('contact-request.store') : 'show-modal' }}">
                                <i class="fas fa-download fa-address-book fs-4"></i>
                                &nbsp;{{ __('messages.setting.add_contact') }}</a>
                        @else
                            <a href="{{ route('add-contact', $vcard->id) }}"
                                class="add-contact-btn btn btn-primary"><i
                                    class="fas fa-download fa-address-book"></i>
                                &nbsp;{{ __('messages.setting.add_contact') }}</a>
                        @endif
                    </div>
                </div>
                @include('vcardTemplates.contact-request')
            @endif
            {{-- made by --}}
            <div class="d-flex justify-content-evenly py-2">
                @if (checkFeature('advanced'))
                    @if (checkFeature('advanced')->hide_branding && $vcard->branding == 0)
                        @if ($vcard->made_by)
                            <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                                class="text-center text-decoration-none text-primary fw-6" target="_blank">
                                <small class="text-primary fw-6">{{ __('messages.made_by') }}
                                    {{ $vcard->made_by }}</small>
                            </a>
                        @else
                            <div class="text-center">
                                <small class="text-primary fw-6">{{ __('messages.made_by') }}
                                    {{ $setting['app_name'] }}</small>
                            </div>
                        @endif
                    @endif
                @else
                    @if ($vcard->made_by)
                        <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                            class="text-center text-decoration-none text-primary fw-6" target="_blank">
                            <small class="text-primary fw-6">{{ __('messages.made_by') }}
                                {{ $vcard->made_by }}</small>
                        </a>
                    @else
                        <div class="text-center">
                            <small class="text-primary fw-6">{{ __('messages.made_by') }}
                                {{ $setting['app_name'] }}</small>
                        </div>
                    @endif
                @endif
                @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                    <div>
                        <a class="text-decoration-none text-primary fw-6 cursor-pointer terms-policies-btn"
                            href="{{ $vcardPrivacyAndTerm }}"><small>{!! __('messages.vcard.term_policy') !!}</small></a>
                    </div>
                @endif
            </div>
            {{-- sticky buttons --}}
            <div class="btn-section cursor-pointer  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
                <div class="fixed-btn-section">
                    @if (empty($vcard->hide_stickybar))
                        <div class="bars-btn photographer-bars-btn">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.4135 0.540405H22.4891C23.5721 0.540405 24.4602 1.42855 24.4602 2.51152V9.58713C24.4602 10.6773 23.5732 11.5582 22.4891 11.5582H15.4135C14.3223 11.5582 13.4424 10.6783 13.4424 9.58713V2.51152C13.4424 1.42746 14.3234 0.540405 15.4135 0.540405Z"
                                    stroke="#ffffff" />
                                <path
                                    d="M2.97143 0.5H8.74589C10.1129 0.5 11.2173 1.6122 11.2173 2.97143V8.74589C11.2173 10.1139 10.1139 11.2173 8.74589 11.2173H2.97143C1.6122 11.2173 0.5 10.1129 0.5 8.74589V2.97143C0.5 1.61328 1.61328 0.5 2.97143 0.5Z"
                                    stroke="#ffffff" />
                                <path
                                    d="M2.97143 13.7828H8.74589C10.1139 13.7828 11.2173 14.8862 11.2173 16.2543V22.0287C11.2173 23.388 10.1129 24.5002 8.74589 24.5002H2.97143C1.61328 24.5002 0.5 23.3869 0.5 22.0287V16.2543C0.5 14.8873 1.6122 13.7828 2.97143 13.7828Z"
                                    stroke="#ffffff" />
                                <path
                                    d="M16.2537 13.7828H22.0281C23.3873 13.7828 24.4995 14.8873 24.4995 16.2543V22.0287C24.4995 23.3869 23.3863 24.5002 22.0281 24.5002H16.2537C14.8867 24.5002 13.7822 23.388 13.7822 22.0287V16.2543C13.7822 14.8862 14.8856 13.7828 16.2537 13.7828Z"
                                    stroke="#ffffff" />
                            </svg>
                        </div>
                    @endif
                    <div class="sub-btn d-none">
                        <div class="sub-btn-div @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') sub-btn-div-left @endif">
                            @if ($vcard->whatsapp_share)
                                <div class="icon-search-container mb-3" data-ic-class="search-trigger">
                                    <div class="wp-btn">
                                        <i class="fa-brands fa-whatsapp text-white fa-2x" id="wpIcon"></i>
                                    </div>
                                    <input type="number" class="search-input" id="wpNumber"
                                        data-ic-class="search-input"
                                        placeholder="{{ __('messages.setting.wp_number') }}" />
                                    <div class="share-wp-btn-div">
                                        <a href="javascript:void(0)"
                                            class="vcard34-sticky-btn vcard34-btn-group d-flex justify-content-center text-primary align-items-center rounded-0 text-decoration-none py-1 rounded-pill justify-content share-wp-btn">
                                            <i class="fa-solid fa-paper-plane"></i> </a>
                                    </div>
                                </div>
                            @endif
                            @if (empty($vcard->hide_stickybar))
                                <div
                                    class="{{ isset($vcard->whatsapp_share) ? 'vcard34-btn-group' : 'stickyIcon' }}">
                                    <button type="button"
                                        class="vcard34-btn-group vcard34-share vcard34-sticky-btn mb-3 px-2 py-1"><i
                                            class="fas fa-share-alt fs-4 pt-1"></i></button>
                                    @if (!empty($vcard->enable_download_qr_code))
                                        <a type="button"
                                            class="vcard34-btn-group vcard34-sticky-btn d-flex justify-content-center  align-items-center  px-2 mb-3"
                                            id="qr-code-btn" download="qr_code.png"><i
                                                class="fa-solid fa-qrcode fs-4 text-primary"></i></a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- newsLatter Modal --}}
    @if ((isset($managesection) && $managesection['news_latter_popup']) || empty($managesection))
        <div class="modal fade" id="newsLatterModal" tabindex="-1" aria-labelledby="newsLatterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog news-modal modal-dialog-centered">
                <div class="modal-content animate-bottom" id="newsLatter-content">
                    <div class="newsmodal-header px-0 position-relative">
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal"
                            aria-label="Close" id="closeNewsLatterModal"></button>
                    </div>
                    <div class="modal-body">
                        <h1 class="content text-start mb-2">{{ __('messages.vcard.subscribe_newslatter') }}</h1>
                        <h3 class="modal-desc text-start">{{ __('messages.vcard.update_directly') }}</h3>
                        <form action="" method="post" id="newsLatterForm"
                            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                            @csrf
                            <input type="hidden" name="vcard_id" value="{{ $vcard->id }}">
                            <div class="mb-1 mt-4 d-flex gap-1 justify-content-center align-items-center email-input">
                                <div class="w-100">
                                    <input type="email"
                                        class="form-control bg-gray-100 border-0 text-light email-input w-100"
                                        placeholder="{{ __('messages.form.enter_your_email') }}" name="email"
                                        id="emailSubscription" aria-label="Email" aria-describedby="button-addon2">
                                </div>
                                <button class="btn ms-1" type="submit"
                                    id="email-send">{{ __('messages.subscribe') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- share modal code --}}
    <div id="vcard34-shareModel" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                <div class="">
                    <div class="row align-items-center mt-3">
                        <div class="col-10 text-center">
                            <h5 class="modal-title pl-50">{{ __('messages.vcard.share_my_vcard') }}</h5>
                        </div>
                        <div class="col-2 p-0">
                            <button type="button" aria-label="Close"
                                class="btn btn-sm btn-icon btn-active-color-danger border-none share-modal-close-btn"
                                data-bs-dismiss="modal">
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                            fill="#000000">
                                            <rect fill="#000000" x="0" y="7" width="16" height="2"
                                                rx="1" />
                                            <rect fill="#000000" opacity="0.5"
                                                transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                x="0" y="7" width="16" height="2" rx="1" />
                                        </g>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                @php
                    $shareUrl = $vcardUrl;
                @endphp
                <div class="modal-body">
                    <a href="http://www.facebook.com/sharer.php?u={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Facebook">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-facebook fa-2x" style="color: #1B95E0"></i>

                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_facebook') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://twitter.com/share?url={{ $shareUrl }}&text={{ $vcard->name }}&hashtags=sharebuttons"
                        target="_blank" class="text-decoration-none share" title="Twitter">
                        <div class="row">
                            <div class="col-2">

                                <span class="fa-2x"><svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                        viewBox="0 0 512 512">
                                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                    </svg></span>

                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_twitter') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Linkedin">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-linkedin fa-2x" style="color: #1B95E0"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_linkedin') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="mailto:?Subject=&Body={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Email">
                        <div class="row">
                            <div class="col-2">
                                <i class="fas fa-envelope fa-2x" style="color: #191a19  "></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_email') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                    height="16px" viewBox="0 0 512.000000 512.000000"
                                    preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://pinterest.com/pin/create/link/?url={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Pinterest">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-pinterest fa-2x" style="color: #bd081c"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_pinterest') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                    height="16px" viewBox="0 0 512.000000 512.000000"
                                    preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://reddit.com/submit?url={{ $shareUrl }}&title={{ $vcard->name }}"
                        target="_blank" class="text-decoration-none share" title="Reddit">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-reddit fa-2x" style="color: #ff4500"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_reddit') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                    height="16px" viewBox="0 0 512.000000 512.000000"
                                    preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="https://wa.me/?text={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Whatsapp">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-whatsapp fa-2x" style="color: limegreen"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_whatsapp') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                    height="16px" viewBox="0 0 512.000000 512.000000"
                                    preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="https://www.snapchat.com/scan?attachmentUrl={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Snapchat">
                        <div class="row">
                            <div class="col-2">
                                <svg width="30px" height="30px" viewBox="147.353 39.286 514.631 514.631"
                                    version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
                                    fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                    </g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path style="fill:#FFFC00;"
                                            d="M147.553,423.021v0.023c0.308,11.424,0.403,22.914,2.33,34.268 c2.042,12.012,4.961,23.725,10.53,34.627c7.529,14.756,17.869,27.217,30.921,37.396c9.371,7.309,19.608,13.111,30.94,16.771 c16.524,5.33,33.571,7.373,50.867,7.473c10.791,0.068,21.575,0.338,32.37,0.293c78.395-0.33,156.792,0.566,235.189-0.484 c10.403-0.141,20.636-1.41,30.846-3.277c19.569-3.582,36.864-11.932,51.661-25.133c17.245-15.381,28.88-34.205,34.132-56.924 c3.437-14.85,4.297-29.916,4.444-45.035v-3.016c0-1.17-0.445-256.892-0.486-260.272c-0.115-9.285-0.799-18.5-2.54-27.636 c-2.117-11.133-5.108-21.981-10.439-32.053c-5.629-10.641-12.68-20.209-21.401-28.57c-13.359-12.81-28.775-21.869-46.722-26.661 c-16.21-4.327-32.747-5.285-49.405-5.27c-0.027-0.004-0.09-0.173-0.094-0.255H278.56c-0.005,0.086-0.008,0.172-0.014,0.255 c-9.454,0.173-18.922,0.102-28.328,1.268c-10.304,1.281-20.509,3.21-30.262,6.812c-15.362,5.682-28.709,14.532-40.11,26.347 c-12.917,13.386-22.022,28.867-26.853,46.894c-4.31,16.084-5.248,32.488-5.271,49.008">
                                        </path>
                                        <path style="fill:#FFFFFF;"
                                            d="M407.001,473.488c-1.068,0-2.087-0.039-2.862-0.076c-0.615,0.053-1.25,0.076-1.886,0.076 c-22.437,0-37.439-10.607-50.678-19.973c-9.489-6.703-18.438-13.031-28.922-14.775c-5.149-0.854-10.271-1.287-15.22-1.287 c-8.917,0-15.964,1.383-21.109,2.389c-3.166,0.617-5.896,1.148-8.006,1.148c-2.21,0-4.895-0.49-6.014-4.311 c-0.887-3.014-1.523-5.934-2.137-8.746c-1.536-7.027-2.65-11.316-5.281-11.723c-28.141-4.342-44.768-10.738-48.08-18.484 c-0.347-0.814-0.541-1.633-0.584-2.443c-0.129-2.309,1.501-4.334,3.777-4.711c22.348-3.68,42.219-15.492,59.064-35.119 c13.049-15.195,19.457-29.713,20.145-31.316c0.03-0.072,0.065-0.148,0.101-0.217c3.247-6.588,3.893-12.281,1.926-16.916 c-3.626-8.551-15.635-12.361-23.58-14.882c-1.976-0.625-3.845-1.217-5.334-1.808c-7.043-2.782-18.626-8.66-17.083-16.773 c1.124-5.916,8.949-10.036,15.273-10.036c1.756,0,3.312,0.308,4.622,0.923c7.146,3.348,13.575,5.045,19.104,5.045 c6.876,0,10.197-2.618,11-3.362c-0.198-3.668-0.44-7.546-0.674-11.214c0-0.004-0.005-0.048-0.005-0.048 c-1.614-25.675-3.627-57.627,4.546-75.95c24.462-54.847,76.339-59.112,91.651-59.112c0.408,0,6.674-0.062,6.674-0.062 c0.283-0.005,0.59-0.009,0.908-0.009c15.354,0,67.339,4.27,91.816,59.15c8.173,18.335,6.158,50.314,4.539,76.016l-0.076,1.23 c-0.222,3.49-0.427,6.793-0.6,9.995c0.756,0.696,3.795,3.096,9.978,3.339c5.271-0.202,11.328-1.891,17.998-5.014 c2.062-0.968,4.345-1.169,5.895-1.169c2.343,0,4.727,0.456,6.714,1.285l0.106,0.041c5.66,2.009,9.367,6.024,9.447,10.242 c0.071,3.932-2.851,9.809-17.223,15.485c-1.472,0.583-3.35,1.179-5.334,1.808c-7.952,2.524-19.951,6.332-23.577,14.878 c-1.97,4.635-1.322,10.326,1.926,16.912c0.036,0.072,0.067,0.145,0.102,0.221c1,2.344,25.205,57.535,79.209,66.432 c2.275,0.379,3.908,2.406,3.778,4.711c-0.048,0.828-0.248,1.656-0.598,2.465c-3.289,7.703-19.915,14.09-48.064,18.438 c-2.642,0.408-3.755,4.678-5.277,11.668c-0.63,2.887-1.271,5.717-2.146,8.691c-0.819,2.797-2.641,4.164-5.567,4.164h-0.441 c-1.905,0-4.604-0.346-8.008-1.012c-5.95-1.158-12.623-2.236-21.109-2.236c-4.948,0-10.069,0.434-15.224,1.287 c-10.473,1.744-19.421,8.062-28.893,14.758C444.443,462.88,429.436,473.488,407.001,473.488">
                                        </path>
                                        <path style="fill:#020202;"
                                            d="M408.336,124.235c14.455,0,64.231,3.883,87.688,56.472c7.724,17.317,5.744,48.686,4.156,73.885 c-0.248,3.999-0.494,7.875-0.694,11.576l-0.084,1.591l1.062,1.185c0.429,0.476,4.444,4.672,13.374,5.017l0.144,0.008l0.15-0.003 c5.904-0.225,12.554-2.059,19.776-5.442c1.064-0.498,2.48-0.741,3.978-0.741c1.707,0,3.521,0.321,5.017,0.951l0.226,0.09 c3.787,1.327,6.464,3.829,6.505,6.093c0.022,1.28-0.935,5.891-14.359,11.194c-1.312,0.518-3.039,1.069-5.041,1.7 c-8.736,2.774-21.934,6.96-26.376,17.427c-2.501,5.896-1.816,12.854,2.034,20.678c1.584,3.697,26.52,59.865,82.631,69.111 c-0.011,0.266-0.079,0.557-0.229,0.9c-0.951,2.24-6.996,9.979-44.612,15.783c-5.886,0.902-7.328,7.5-9,15.17 c-0.604,2.746-1.218,5.518-2.062,8.381c-0.258,0.865-0.306,0.914-1.233,0.914c-0.128,0-0.278,0-0.442,0 c-1.668,0-4.2-0.346-7.135-0.922c-5.345-1.041-12.647-2.318-21.982-2.318c-5.21,0-10.577,0.453-15.962,1.352 c-11.511,1.914-20.872,8.535-30.786,15.543c-13.314,9.408-27.075,19.143-48.071,19.143c-0.917,0-1.812-0.031-2.709-0.076 l-0.236-0.01l-0.237,0.018c-0.515,0.045-1.034,0.068-1.564,0.068c-20.993,0-34.76-9.732-48.068-19.143 c-9.916-7.008-19.282-13.629-30.791-15.543c-5.38-0.896-10.752-1.352-15.959-1.352c-9.333,0-16.644,1.428-21.978,2.471 c-2.935,0.574-5.476,1.066-7.139,1.066c-1.362,0-1.388-0.08-1.676-1.064c-0.844-2.865-1.461-5.703-2.062-8.445 c-1.676-7.678-3.119-14.312-9.002-15.215c-37.613-5.809-43.659-13.561-44.613-15.795c-0.149-0.352-0.216-0.652-0.231-0.918 c56.11-9.238,81.041-65.408,82.63-69.119c3.857-7.818,4.541-14.775,2.032-20.678c-4.442-10.461-17.638-14.653-26.368-17.422 c-2.007-0.635-3.735-1.187-5.048-1.705c-11.336-4.479-14.823-8.991-14.305-11.725c0.601-3.153,6.067-6.359,10.837-6.359 c1.072,0,2.012,0.173,2.707,0.498c7.747,3.631,14.819,5.472,21.022,5.472c9.751,0,14.091-4.537,14.557-5.055l1.057-1.182 l-0.085-1.583c-0.197-3.699-0.44-7.574-0.696-11.565c-1.583-25.205-3.563-56.553,4.158-73.871 c23.37-52.396,72.903-56.435,87.525-56.435c0.36,0,6.717-0.065,6.717-0.065C407.744,124.239,408.033,124.235,408.336,124.235 M408.336,115.197h-0.017c-0.333,0-0.646,0-0.944,0.004c-2.376,0.024-6.282,0.062-6.633,0.066c-8.566,0-25.705,1.21-44.115,9.336 c-10.526,4.643-19.994,10.921-28.14,18.66c-9.712,9.221-17.624,20.59-23.512,33.796c-8.623,19.336-6.576,51.905-4.932,78.078 l0.006,0.041c0.176,2.803,0.361,5.73,0.53,8.582c-1.265,0.581-3.316,1.194-6.339,1.194c-4.864,0-10.648-1.555-17.187-4.619 c-1.924-0.896-4.12-1.349-6.543-1.349c-3.893,0-7.997,1.146-11.557,3.239c-4.479,2.63-7.373,6.347-8.159,10.468 c-0.518,2.726-0.493,8.114,5.492,13.578c3.292,3.008,8.128,5.782,14.37,8.249c1.638,0.645,3.582,1.261,5.641,1.914 c7.145,2.271,17.959,5.702,20.779,12.339c1.429,3.365,0.814,7.793-1.823,13.145c-0.069,0.146-0.138,0.289-0.201,0.439 c-0.659,1.539-6.807,15.465-19.418,30.152c-7.166,8.352-15.059,15.332-23.447,20.752c-10.238,6.617-21.316,10.943-32.923,12.855 c-4.558,0.748-7.813,4.809-7.559,9.424c0.078,1.33,0.39,2.656,0.931,3.939c0.004,0.008,0.009,0.016,0.013,0.023 c1.843,4.311,6.116,7.973,13.063,11.203c8.489,3.943,21.185,7.26,37.732,9.855c0.836,1.59,1.704,5.586,2.305,8.322 c0.629,2.908,1.285,5.898,2.22,9.074c1.009,3.441,3.626,7.553,10.349,7.553c2.548,0,5.478-0.574,8.871-1.232 c4.969-0.975,11.764-2.305,20.245-2.305c4.702,0,9.575,0.414,14.48,1.229c9.455,1.574,17.606,7.332,27.037,14 c13.804,9.758,29.429,20.803,53.302,20.803c0.651,0,1.304-0.021,1.949-0.066c0.789,0.037,1.767,0.066,2.799,0.066 c23.88,0,39.501-11.049,53.29-20.799l0.022-0.02c9.433-6.66,17.575-12.41,27.027-13.984c4.903-0.814,9.775-1.229,14.479-1.229 c8.102,0,14.517,1.033,20.245,2.15c3.738,0.736,6.643,1.09,8.872,1.09l0.218,0.004h0.226c4.917,0,8.53-2.699,9.909-7.422 c0.916-3.109,1.57-6.029,2.215-8.986c0.562-2.564,1.46-6.674,2.296-8.281c16.558-2.6,29.249-5.91,37.739-9.852 c6.931-3.215,11.199-6.873,13.053-11.166c0.556-1.287,0.881-2.621,0.954-3.979c0.261-4.607-2.999-8.676-7.56-9.424 c-51.585-8.502-74.824-61.506-75.785-63.758c-0.062-0.148-0.132-0.295-0.205-0.438c-2.637-5.354-3.246-9.777-1.816-13.148 c2.814-6.631,13.621-10.062,20.771-12.332c2.07-0.652,4.021-1.272,5.646-1.914c7.039-2.78,12.07-5.796,15.389-9.221 c3.964-4.083,4.736-7.995,4.688-10.555c-0.121-6.194-4.856-11.698-12.388-14.393c-2.544-1.052-5.445-1.607-8.399-1.607 c-2.011,0-4.989,0.276-7.808,1.592c-6.035,2.824-11.441,4.368-16.082,4.588c-2.468-0.125-4.199-0.66-5.32-1.171 c0.141-2.416,0.297-4.898,0.458-7.486l0.067-1.108c1.653-26.19,3.707-58.784-4.92-78.134c-5.913-13.253-13.853-24.651-23.604-33.892 c-8.178-7.744-17.678-14.021-28.242-18.661C434.052,116.402,416.914,115.197,408.336,115.197">
                                        </path>
                                        <rect x="147.553" y="39.443" style="fill:none;" width="514.231"
                                            height="514.23">
                                        </rect>
                                    </g>
                                </svg>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_snapchat') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                    height="16px" viewBox="0 0 512.000000 512.000000"
                                    preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <div class="col-12 justify-content-between social-link-modal">
                        <div class="input-group send-vcard">
                            <input type="text" class="form-control border-0 rounded-0"
                                placeholder="{{ request()->fullUrl() }}" disabled>
                            <span id="vcardUrlCopy{{ $vcard->id }}" class="d-none" target="_blank">
                                {{ $vcardUrl }} </span>
                            <button class="copy-vcard-clipboard btn btn-dark" title="Copy Link"
                                data-id="{{ $vcard->id }}">
                                <i class="fa-regular fa-copy fa-2x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-center">

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script>
    @if (isset(checkFeature('advanced')->custom_js) && $vcard->custom_js)
        {!! $vcard->custom_js !!}
    @endif
</script>
@include('vcardTemplates.template.templates')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
@if (checkFeature('seo') && $vcard->google_analytics)
    {!! $vcard->google_analytics !!}
@endif
@php
    $setting = \App\Models\UserSetting::where('user_id', $vcard->tenant->user->id)
        ->where('key', 'stripe_key')
        ->first();
@endphp
<script>
    $(document).ready(function() {
        $("#month-input").datepicker({
            dateFormat: "dd/mm/yy",
        });
    });
</script>
<script>
    let stripe = ''
    @if (!empty($setting) && !empty($setting->value))
        stripe = Stripe('{{ $setting->value }}');
    @endif
    $(".product-slider").slick({
        dots: false,
        infinite: true,
        arrows: false,
        speed: 300,
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1000,
        responsive: [{
            breakpoint: 575,
            settings: {
                slidesToShow: 1,
            },
        }, ],
    });
    $(".iframe-slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
        speed: 300,
        infinite: true,
        autoplaySpeed: 5000,
        autoplay: true,
        responsive: [{
                breakpoint: 575,
                settings: {
                    centerPadding: "125px",
                    dots: true,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    centerPadding: "0",
                    dots: true,
                },
            },
        ],
    });
    $(".testimonial-slider").slick({
        slidesToShow: 1,
        infinite: true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1000,
        arrows: false,
        dots: true,
    });
    $(".blog-slider").slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 1000,
        arrows: false,
        responsive: [{
            breakpoint: 575,
            settings: {

                slidesToShow: 1,
            },
        }, ],
    });
    $(".gallery-slider").slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1000,
        arrows: false,
    });
    @if ($vcard->services_slider_view)
        $('.services-slider-view').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 2,
            autoplay: true,
            slidesToScroll: 1,
            arrows: false,
            responsive: [{
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                },
            }, ],
        });
    @endif
</script>
<script>
    let isEdit = false
    let password = "{{ isset(checkFeature('advanced')->password) && !empty($vcard->password) }}"
    let passwordUrl = "{{ route('vcard.password', $vcard->id) }}";
    let enquiryUrl = "{{ route('enquiry.store', ['vcard' => $vcard->id, 'alias' => $vcard->url_alias]) }}";
    let appointmentUrl = "{{ route('appointment.store', ['vcard' => $vcard->id, 'alias' => $vcard->url_alias]) }}";
    let slotUrl = "{{ route('appointment-session-time', $vcard->url_alias) }}";
    let appUrl = "{{ config('app.url') }}";
    let vcardId = {{ $vcard->id }};
    let vcardAlias = "{{ $vcard->url_alias }}";
    let languageChange = "{{ url('language') }}";
    let paypalUrl = "{{ route('paypal.init') }}"
    let lang = "{{ checkLanguageSession($vcard->url_alias) }}";
    let userDateFormate = "{{ getSuperAdminSettingValue('datetime_method') ?? 1 }}";
    let userlanguage = "{{ getLanguage($vcard->default_language) }}"
</script>
<script>
    const qrCodeThirtyfour = document.getElementById("qr-code-thirtyfour");
    const svg = qrCodeThirtyfour.querySelector("svg");
    const blob = new Blob([svg.outerHTML], {
        type: 'image/svg+xml'
    });
    const url = URL.createObjectURL(blob);
    const image = document.createElement('img');
    image.src = url;
    image.addEventListener('load', () => {
        const canvas = document.createElement('canvas');
        canvas.width = canvas.height = {{ $vcard->qr_code_download_size }};
        const context = canvas.getContext('2d');
        context.drawImage(image, 0, 0, canvas.width, canvas.height);
        const link = document.getElementById('qr-code-btn');
        link.href = canvas.toDataURL();
        URL.revokeObjectURL(url);
    });
</script>
@routes
<script src="{{ asset('messages.js?$mixID') }}"></script>
<script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>
<script src="{{ mix('assets/js/vcards/vcard-view.js') }}"></script>
<script src="{{ mix('assets/js/lightbox.js') }}"></script>
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if ("serviceWorker" in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register("/sw.js").then(
            (registration) => {
                console.log("Service worker registration succeeded:", registration);
            },
            (error) => {
                console.error(`Service worker registration failed: ${error}`);
            },
        );
    } else {
        console.error("Service workers are not supported.");
    }
</script>
<script>
    let deferredPrompt = null;
    window.addEventListener("beforeinstallprompt", (event) => {
        /* event.preventDefault(); */
        deferredPrompt = event;
        document.getElementById("installPwaBtn").style.display = "block";
    });
    document.getElementById("installPwaBtn").addEventListener("click", async () => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            await deferredPrompt.userChoice;
            deferredPrompt = null;
        }
    });
</script>

</html>
