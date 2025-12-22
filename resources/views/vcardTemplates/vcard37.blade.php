<!DOCTYPE html>
<html lang="en">

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
    <!-- BOOTSTRAP LINK CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ getVcardFavicon($vcard) }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vcard37.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}">
    @if ($vcard->font_family || $vcard->font_size || $vcard->custom_css)
        <style>
            @if (checkFeature('custom-fonts'))
                @if ($vcard->font_family)
                    body {
                        font-family: {
                                {
                                $vcard->font_family
                            }
                        }

                        ;
                    }

                @endif
                @if ($vcard->font_size)
                    div>h4 {
                        font-size: {
                                {
                                $vcard->font_size
                            }
                        }

                        px !important;
                    }

                @endif
            @endif
            @if (isset(checkFeature('advanced')->custom_css))
                    {
                    ! ! $vcard->custom_css ! !
                }

            @endif
        </style>
    @endif
</head>

<body>
    @if (checkFeature('password'))
        @include('vcards.password')
    @endif
    <div class="main-section position-relative mx-auto overflow-hidden  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
        <div class="@if ($vcard->cover_type == 2) yt-main-img @endif main-img w-100 position-relative">
            {{-- <img src="{{ asset('assets/img/vcard37/main.png') }}" class="h-100 w-100 object-fit-cover"
                alt="images" /> --}}
            @php
                $coverClass =
                    $vcard->cover_image_type == 0 ? 'object-fit-cover w-100 h-100' : 'object-fit-cover w-100 h-100';
            @endphp
            @if ($vcard->cover_type == 0)
                <img src="{{ $vcard->cover_url }}" class="{{ $coverClass }}" loading="lazy" />
            @elseif($vcard->cover_type == 1)
                @if (strpos($vcard->cover_url, '.mp4') !== false ||
                        strpos($vcard->cover_url, '.mov') !== false ||
                        strpos($vcard->cover_url, '.avi') !== false)
                    <video class="cover-video {{ $coverClass }}" loop autoplay playsinline alt="background video"
                        id="cover-video">
                        <source src="{{ $vcard->cover_url }}" type="video/mp4">
                    </video>
                @endif
            @elseif ($vcard->cover_type == 2)
                <div class="youtube-link-37">
                    <iframe
                        src="https://www.youtube.com/embed/{{ YoutubeID($vcard->youtube_link) }}?autoplay=1&mute=0&loop=1&playlist={{ YoutubeID($vcard->youtube_link) }}&controls=0&modestbranding=1&showinfo=0&rel=0"
                        class="cover-video {{ $coverClass }}" id="cover-video" frameborder="0"
                        allow="autoplay; encrypted-media" allowfullscreen>
                    </iframe>
                </div>
            @endif
        </div>
        <!-- introduction-section -->
        <div class="introduction-section pt-50 px-30 position-relative  @if ($vcard->cover_type == 2) main-banner-video @endif"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <div
                class="position-absolute main-vector-3 d-none d-sm-block  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-start @endif">
                <img src="{{ asset('assets/img/vcard37/main-vector-2.png') }}" alt="images" class="w-100" />
            </div>
            <div
                class="position-absolute main-vector d-block d-sm-none  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-start @endif">
                <img src="{{ asset('assets/img/vcard37/vector-main-1.png') }}" alt="images" class="w-100" />
            </div>
            <div
                class="position-absolute main-vector-2 d-block d-sm-none  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-start @endif">
                <img src="{{ asset('assets/img/vcard37/vector-main-1.png') }}" alt="images" class="w-100" />
            </div>
            <div class="card-wrapper">
                <div class="d-block d-sm-flex gap-30 align-items-center">
                    <div class="intro-box mb-3 mb-sm-0">
                        {{-- <div class="position-absolute intro-vector-1">
                            <img src="{{ asset('assets/img/vcard37/intro-vector-1.png') }}" alt="images"
                                class="h-100 w-100 object-fit-cover" />
                        </div> --}}
                        <div class="intro-img w-100 h-100">
                            <img src="{{ $vcard->profile_url }}" alt="image" class="h-100 w-100 object-fit-cover" />
                        </div>
                        {{-- <div class="position-absolute intro-vector-2">
                            <img src="{{ asset('assets/img/vcard37/intro-vector-2.png') }}" alt="images"
                                class="h-100 w-100 object-fit-cover" />
                        </div> --}}
                    </div>
                    <div class="text-sm-start text-center pt-1">
                        <p
                            class="fw-6 text-teal-green fs-26 mb-1 text-center text-sm-start lh-12 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
                            {{ ucwords($vcard->first_name . ' ' . $vcard->last_name) }} {{-- @if ($vcard->is_verified)
                            --}}
                            <i class="verification-icon bi-patch-check-fill"></i>
                            {{-- @endif --}}
                        </p>
                        <p
                            class="text-black fs-16 fw-6 mb-2 company-name position-relative text-center text-sm-start @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
                            {{ ucwords($vcard->company) }}</p>
                        <p
                            class="text-gray fs-14 fw-6 vcard-name text-center text-sm-start lh-12 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
                            {{ ucwords($vcard->occupation) }}</p>
                        <p
                            class="text-gray fs-14 fw-6 vcard-name text-center text-sm-start lh-12 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
                            {{ ucwords($vcard->job_title) }}</p>

                    </div>
                </div>
            </div>
        </div>
        {{-- Pwa support --}}
        @if (isset($enable_pwa) && $enable_pwa == 1 && !isiOSDevice())
            <div class="mt-0">
                <div class="pwa-support d-flex align-items-center justify-content-center"
                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
                    <div>
                        <h1 class="pwa-heading">{{ __('messages.pwa.add_to_home_screen') }}</h1>
                        <p class="pwa-text text-dark">{{ __('messages.pwa.pwa_description') }} </p>
                        <div class="text-end d-flex gap-2 align-items-center">
                            <button id="installPwaBtn"
                                class="pwa-install-button text-white w-50 mb-1 btn">{{ __('messages.pwa.install') }}
                            </button>
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
                <div class="@if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
                    <div class="support-banner banner-section w-100">

                        <button type="button" class="border-0 bg-transparent text-start banner-close"><i
                                class="fa-solid fa-xmark"></i></button>
                        <div class="">
                            <h1 class="text-center support_heading">{{ $banners->title }}</h1>
                            <p class="text-center support_text text-dark">{{ $banners->description }} </p>
                            <div class="text-center">
                                <a href="{{ $banners->url }}" class="act-now text-white" target="_blank"
                                    data-turbo="false">{{ $banners->banner_button }} </a>
                            </div>
                        </div>
                    </div>
            @endif
        @endif
        {{-- language --}}
        <div
            class="d-flex justify-content-end position-absolute top-0  mx-3 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') start-0 end-auto @else end-0 @endif">
            @if ($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
                <div class="language pt-3">
                    <ul class="text-decoration-none ps-0">
                        <li class="dropdown1 dropdown lang-list fw-6">
                            <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown"
                                role="button" aria-haspopup="true" aria-expanded="false">
                                {{ strtoupper(getLanguageIsoCode($vcard->default_language)) }}</a>
                            <ul class="dropdown-menu lang-hover-list top-100 mt-0">
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
        <div class="fs-14 fw-medium text-gray-300 mb-0 text-center pt-50 px-30px"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <p class="fs-14 fw-medium text-gray mb-0 text-center">{!! $vcard->description !!}</p>
        </div>
        <!-- social-section -->
        <div class="social-section pt-30 px-30px">
            @if (checkFeature('social_links') && getSocialLinkIcon($vcard))
                <div class="d-flex gap-16 flex-wrap justify-content-center align-items-center">
                    @foreach (getSocialLinkIcon($vcard) as $social)
                        <a href="{{ $social['url'] }}" target="_blank"
                            class="text-decoration-none d-flex justify-content-center align-items-center social-box">
                            {!! $social['icon'] !!}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
        {{-- custom link section --}}
        @if (checkFeature('custom-links') && $customLink->isNotEmpty())
            <div class="custom-link-section pt-30">
                <div class="custom-link d-flex flex-wrap justify-content-center pt-1 w-100 ">
                    @foreach ($customLink as $value)
                        @if ($value->show_as_button == 1)
                            <a href="{{ $value->link }}" @if ($value->open_new_tab == 1) target="_blank" @endif
                                style="
                            @if ($value->button_color) background-color: {{ $value->button_color }}; @endif
                            @if ($value->button_type === 'rounded') border-radius: 20px; @endif
                            @if ($value->button_type === 'square') border-radius: 0px; @endif"
                                class="m-2 d-flex justify-content-center align-items-center text-decoration-none link-text
                            font-primary btn mt-2">
                                {{ $value->link_name }}
                            </a>
                        @else
                            <a href="{{ $value->link }}" @if ($value->open_new_tab == 1) target="_blank" @endif
                                class="m-2 d-flex justify-content-center align-items-center text-decoration-none link-text
                            text-black mt-2">
                                {{ $value->link_name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        <!-- personal-details -->
        @if (
            !empty($vcard->email) ||
                !empty(
                    $vcard->alternative_email ||
                        !empty($vcard->phone) ||
                        !empty($vcard->alternative_phone) ||
                        !empty($vcard->dob) ||
                        !empty($vcard->location)
                ))
            <div class="personal-details pt-50 px-30px bg-white position-relative"
                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                <div class="section-heading text-center mb-30px px-30px">
                    <p class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                        {{ __('Contact') }}</p>
                </div>
                <div class="position-absolute personal-vector-1 text-end">
                    <img src="{{ asset('assets/img/vcard37/personal-vector-1.png') }}" alt="images"
                        class="w-100" />
                </div>
                {{-- <div class="position-absolute personal-vector-2 text-end">
                    <img src="{{ asset('assets/img/vcard37/personal-vector-2.png') }}" alt="images" class="w-100" />
                </div> --}}
                <div class="row position-relative row-gap-16px">
                    @if ($vcard->email)
                        <div class="col-sm-6">
                            <a href="mailto:{{ $vcard->email }}" class="text-decoration-none contact-box">
                                <div class="box-1">
                                    <div class="icon1 d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18"
                                            viewBox="0 0 22 18" fill="none">
                                            <g clip-path="url(#clip0_5893_1974)">
                                                <path
                                                    d="M11.0203 0.666245C13.7793 0.666245 16.5328 0.660688 19.2917 0.671803C19.6526 0.671803 20.019 0.710705 20.3687 0.788508C20.996 0.933001 21.429 1.33313 21.701 1.9111C21.9397 2.41683 21.862 2.6947 21.3957 2.98924C20.7906 3.3727 20.18 3.75061 19.5749 4.13407C16.9325 5.81796 14.29 7.49074 11.6587 9.18575C11.1813 9.49697 10.8038 9.48585 10.3264 9.18019C7.12333 7.11839 3.90359 5.08438 0.689394 3.03926C0.622778 2.9948 0.550612 2.9559 0.489548 2.91144C0.173124 2.6947 0.11206 2.52242 0.223086 2.16119C0.495099 1.272 1.17236 0.755164 2.16604 0.69959C2.56573 0.67736 2.96542 0.67736 3.35956 0.671803C5.91315 0.671803 8.46674 0.671803 11.0203 0.666245C11.0203 0.671803 11.0203 0.666245 11.0203 0.666245Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M10.9736 17.3333C8.17024 17.3333 5.37239 17.3389 2.56899 17.3278C2.21926 17.3278 1.85843 17.2889 1.5198 17.1944C0.836991 16.9999 0.415094 16.5164 0.209696 15.8439C0.104222 15.4938 0.165286 15.3216 0.481709 15.1215C3.06861 13.4932 5.65551 11.8648 8.24241 10.2365C8.51442 10.0642 8.80309 10.0642 9.0751 10.2254C9.56361 10.5144 10.041 10.8145 10.5184 11.1201C10.9126 11.3758 11.0791 11.3813 11.4622 11.1313C11.9673 10.8034 12.478 10.4866 12.9832 10.1587C13.2552 9.98088 13.4995 10.0365 13.7493 10.1976C14.5764 10.7311 15.4036 11.2591 16.2363 11.787C17.9349 12.8652 19.6392 13.9322 21.3379 15.0103C21.8597 15.3382 21.943 15.6105 21.6876 16.1607C21.3379 16.9054 20.705 17.2222 19.9334 17.3167C19.7391 17.3389 19.5448 17.3389 19.3505 17.3389C16.5582 17.3333 13.7659 17.3333 10.9736 17.3333Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M0.205078 13.4709C0.205078 10.4811 0.205078 7.54118 0.205078 4.5513C2.54772 6.04624 4.85706 7.5134 7.20525 9.00834C4.86261 10.5033 2.55327 11.976 0.205078 13.4709Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M14.8105 9.00834C17.1476 7.51896 19.457 6.04624 21.7996 4.5513C21.7996 7.53007 21.7996 10.4644 21.7996 13.4598C19.4625 11.976 17.1532 10.5033 14.8105 9.00834Z"
                                                    fill="#2a9f2e" />
                                            </g>
                                            <defs>
                                                <clippath id="clip0_5893_1974">
                                                    <rect width="21.6667" height="16.6667" fill="white"
                                                        transform="translate(0.166016 0.666656)" />
                                                </clippath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div class="box1-content fs-14 fw-5 text-center lh-base text-black text-break">
                                        {{ $vcard->email }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($vcard->alternative_email)
                        <div class="col-sm-6">
                            <a href="mailto:{{ $vcard->alternative_email }}" class="text-decoration-none">
                                <div class="box-1">
                                    <div class="icon1 d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18"
                                            viewBox="0 0 22 18" fill="none">
                                            <g clip-path="url(#clip0_5893_1974)">
                                                <path
                                                    d="M11.0203 0.666245C13.7793 0.666245 16.5328 0.660688 19.2917 0.671803C19.6526 0.671803 20.019 0.710705 20.3687 0.788508C20.996 0.933001 21.429 1.33313 21.701 1.9111C21.9397 2.41683 21.862 2.6947 21.3957 2.98924C20.7906 3.3727 20.18 3.75061 19.5749 4.13407C16.9325 5.81796 14.29 7.49074 11.6587 9.18575C11.1813 9.49697 10.8038 9.48585 10.3264 9.18019C7.12333 7.11839 3.90359 5.08438 0.689394 3.03926C0.622778 2.9948 0.550612 2.9559 0.489548 2.91144C0.173124 2.6947 0.11206 2.52242 0.223086 2.16119C0.495099 1.272 1.17236 0.755164 2.16604 0.69959C2.56573 0.67736 2.96542 0.67736 3.35956 0.671803C5.91315 0.671803 8.46674 0.671803 11.0203 0.666245C11.0203 0.671803 11.0203 0.666245 11.0203 0.666245Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M10.9736 17.3333C8.17024 17.3333 5.37239 17.3389 2.56899 17.3278C2.21926 17.3278 1.85843 17.2889 1.5198 17.1944C0.836991 16.9999 0.415094 16.5164 0.209696 15.8439C0.104222 15.4938 0.165286 15.3216 0.481709 15.1215C3.06861 13.4932 5.65551 11.8648 8.24241 10.2365C8.51442 10.0642 8.80309 10.0642 9.0751 10.2254C9.56361 10.5144 10.041 10.8145 10.5184 11.1201C10.9126 11.3758 11.0791 11.3813 11.4622 11.1313C11.9673 10.8034 12.478 10.4866 12.9832 10.1587C13.2552 9.98088 13.4995 10.0365 13.7493 10.1976C14.5764 10.7311 15.4036 11.2591 16.2363 11.787C17.9349 12.8652 19.6392 13.9322 21.3379 15.0103C21.8597 15.3382 21.943 15.6105 21.6876 16.1607C21.3379 16.9054 20.705 17.2222 19.9334 17.3167C19.7391 17.3389 19.5448 17.3389 19.3505 17.3389C16.5582 17.3333 13.7659 17.3333 10.9736 17.3333Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M0.205078 13.4709C0.205078 10.4811 0.205078 7.54118 0.205078 4.5513C2.54772 6.04624 4.85706 7.5134 7.20525 9.00834C4.86261 10.5033 2.55327 11.976 0.205078 13.4709Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M14.8105 9.00834C17.1476 7.51896 19.457 6.04624 21.7996 4.5513C21.7996 7.53007 21.7996 10.4644 21.7996 13.4598C19.4625 11.976 17.1532 10.5033 14.8105 9.00834Z"
                                                    fill="#2a9f2e" />
                                            </g>
                                            <defs>
                                                <clippath id="clip0_5893_1974">
                                                    <rect width="21.6667" height="16.6667" fill="white"
                                                        transform="translate(0.166016 0.666656)" />
                                                </clippath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div class="box1-content fs-14 fw-5 text-center lh-base text-black text-break">
                                        {{ $vcard->alternative_email }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($vcard->phone)
                        <div class="col-sm-6">
                            <a href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}"
                                class="text-decoration-none">
                                <div class="box-1">
                                    <div class="icon1 d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 22 22" fill="none">
                                            <g clip-path="url(#clip0_5893_1968)">
                                                <path
                                                    d="M4.54095 9.54438C6.32071 12.958 8.84849 15.5472 12.1888 17.3248C12.3306 17.4021 12.666 17.3119 12.8078 17.1831C13.5687 16.4617 14.3167 15.7275 15.039 14.9675C15.4388 14.5424 15.8773 14.478 16.4318 14.581C17.7473 14.8129 19.0757 15.0448 20.404 15.1994C21.4616 15.3282 21.8356 15.676 21.8356 16.758C21.8356 17.9174 21.8356 19.0638 21.8356 20.2231C21.8356 21.4726 21.4358 21.8591 20.159 21.8333C11.0796 21.6787 2.95464 15.238 0.81377 6.4013C0.439762 4.84264 0.323691 3.20669 0.181825 1.5965C0.0915477 0.643272 0.620317 0.179538 1.57468 0.179538C2.83857 0.166656 4.10246 0.166656 5.36635 0.166656C6.29492 0.166656 6.68183 0.591746 6.7979 1.51921C6.97845 2.88465 7.22349 4.25009 7.48143 5.60265C7.5846 6.18231 7.48143 6.64605 7.05583 7.05825C6.20464 7.88267 5.37925 8.70709 4.54095 9.54438Z"
                                                    fill="#2a9f2e" />
                                            </g>
                                            <defs>
                                                <clippath id="clip0_5893_1968">
                                                    <rect width="21.6667" height="21.6667" fill="white"
                                                        transform="translate(0.166016 0.166656)" />
                                                </clippath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div class="box1-content fs-14 fw-5 text-center lh-base text-black">
                                        +{{ $vcard->region_code }}{{ $vcard->phone }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($vcard->alternative_phone)
                        <div class="col-sm-6">
                            <a href="tel:+{{ $vcard->region_code }}{{ $vcard->alternative_phone }}"
                                class="text-decoration-none">
                                <div class="box-1">
                                    <div class="icon1 d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 22 22" fill="none">
                                            <g clip-path="url(#clip0_5893_1968)">
                                                <path
                                                    d="M4.54095 9.54438C6.32071 12.958 8.84849 15.5472 12.1888 17.3248C12.3306 17.4021 12.666 17.3119 12.8078 17.1831C13.5687 16.4617 14.3167 15.7275 15.039 14.9675C15.4388 14.5424 15.8773 14.478 16.4318 14.581C17.7473 14.8129 19.0757 15.0448 20.404 15.1994C21.4616 15.3282 21.8356 15.676 21.8356 16.758C21.8356 17.9174 21.8356 19.0638 21.8356 20.2231C21.8356 21.4726 21.4358 21.8591 20.159 21.8333C11.0796 21.6787 2.95464 15.238 0.81377 6.4013C0.439762 4.84264 0.323691 3.20669 0.181825 1.5965C0.0915477 0.643272 0.620317 0.179538 1.57468 0.179538C2.83857 0.166656 4.10246 0.166656 5.36635 0.166656C6.29492 0.166656 6.68183 0.591746 6.7979 1.51921C6.97845 2.88465 7.22349 4.25009 7.48143 5.60265C7.5846 6.18231 7.48143 6.64605 7.05583 7.05825C6.20464 7.88267 5.37925 8.70709 4.54095 9.54438Z"
                                                    fill="#2a9f2e" />
                                            </g>
                                            <defs>
                                                <clippath id="clip0_5893_1968">
                                                    <rect width="21.6667" height="21.6667" fill="white"
                                                        transform="translate(0.166016 0.166656)" />
                                                </clippath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div class="box1-content fs-14 fw-5 text-center lh-base text-black">
                                        +{{ $vcard->region_code }}{{ $vcard->alternative_phone }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($vcard->dob)
                        <div class="col-sm-6">
                            <a href="#" class="text-decoration-none">
                                <div class="box-1">
                                    <div class="icon1 d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="22"
                                            viewBox="0 0 26 22" fill="none">
                                            <g clip-path="url(#clip0_5893_1958)">
                                                <path
                                                    d="M0.824791 21.8333C0.719793 21.6346 0.551797 21.4463 0.520297 21.237C0.467798 20.8604 0.520297 20.4733 0.499298 20.0967C0.488798 19.7514 0.635795 19.5736 0.992788 19.584C1.09779 19.584 1.20278 19.584 1.30778 19.584C9.10913 19.584 16.9 19.584 24.7013 19.5945C24.9638 19.5945 25.2263 19.6991 25.4888 19.7514C25.4888 20.4419 25.4888 21.1429 25.4888 21.8333C17.278 21.8333 9.04613 21.8333 0.824791 21.8333Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M13.0253 9.03838C15.8287 9.03838 18.6322 9.03838 21.4461 9.03838C23.0316 9.03838 23.8086 9.82302 23.8191 11.4132C23.8191 11.4342 23.8191 11.4446 23.8191 11.4655C24.0081 12.3862 23.5776 12.9093 22.7586 13.265C21.9291 13.6207 21.1311 13.6939 20.4066 13.0767C20.0497 12.7733 19.7557 12.4071 19.4617 12.041C19.0732 11.5702 18.7057 11.5597 18.3067 12.02C18.0442 12.3234 17.7817 12.6268 17.4877 12.8884C16.6582 13.6312 15.7447 13.7149 14.8103 13.1185C14.3903 12.8465 14.0123 12.5013 13.6448 12.156C13.1408 11.6852 12.9203 11.6852 12.4268 12.177C12.1433 12.4594 11.8493 12.7314 11.5238 12.9616C10.4213 13.7567 9.42387 13.7044 8.39489 12.8256C8.23739 12.6896 8.09039 12.5431 7.9539 12.3862C7.25041 11.5806 7.10341 11.5806 6.39993 12.4176C5.44445 13.5475 4.23697 13.7986 2.893 13.1918C2.36801 12.9511 2.16851 12.585 2.22101 12.041C2.25251 11.7794 2.28401 11.5179 2.25251 11.2668C2.07402 9.97995 3.11349 9.01745 4.45747 9.02792C7.30291 9.0593 10.1589 9.03838 13.0253 9.03838Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M23.6109 18.1717C16.5446 18.1717 9.50972 18.1717 2.44336 18.1717C2.44336 17.0732 2.44336 15.9747 2.44336 14.8343C4.19682 15.4202 5.72979 15.0435 6.98977 13.694C9.08973 15.7026 11.0217 15.4306 13.0481 13.6312C15.5576 15.8073 17.3636 15.3051 19.075 13.5998C19.6525 14.217 20.2825 14.782 21.1435 15.0017C21.994 15.2214 22.792 15.0435 23.6319 14.6878C23.6109 15.8596 23.6109 16.9895 23.6109 18.1717Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M11.5241 8.05495C11.5241 7.01922 11.5136 6.00442 11.5346 4.97915C11.5451 4.64437 11.7866 4.44559 12.1331 4.44559C12.7106 4.43513 13.2881 4.43513 13.8551 4.44559C14.2541 4.44559 14.485 4.67575 14.485 5.06284C14.506 6.04626 14.4955 7.04015 14.4955 8.05495C13.4981 8.05495 12.5321 8.05495 11.5241 8.05495Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M13.0162 0.166656C13.2682 0.626982 13.5621 1.15008 13.8456 1.68364C13.9716 1.92426 14.1396 2.16489 14.2131 2.42643C14.3706 3.00184 14.1186 3.62956 13.6671 3.88064C13.2157 4.13173 12.5227 4.0585 12.1552 3.72371C11.7667 3.35755 11.6407 2.6566 11.9137 2.14396C12.2707 1.45347 12.6592 0.783911 13.0162 0.166656Z"
                                                    fill="#2a9f2e" />
                                            </g>
                                            <defs>
                                                <clippath id="clip0_5893_1958">
                                                    <rect width="25" height="21.6667" fill="white"
                                                        transform="translate(0.5 0.166656)" />
                                                </clippath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div class="box1-content fs-14 fw-5 text-center lh-base text-black">
                                        {{ $vcard->dob }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($vcard->location)
                        <div class="col-sm-6">
                            <a href="#" class="text-decoration-none">
                                <div class="box-1">
                                    <div class="icon1 d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="26"
                                            viewBox="0 0 20 26" fill="none">
                                            <g clip-path="url(#clip0_5893_1951)">
                                                <path
                                                    d="M9.61002 21.005C9.28803 20.6277 8.97867 20.2698 8.67563 19.9086C7.04044 17.9416 5.49364 15.9069 4.15519 13.7175C3.55226 12.734 3.02508 11.7118 2.57367 10.6444C1.74345 8.67424 1.8855 6.73628 2.80096 4.85959C3.98473 2.43472 5.92612 0.990119 8.55251 0.58705C12.5931 -0.0320655 16.4317 2.86359 17.0915 6.95555C17.3061 8.29697 17.1009 9.55455 16.5864 10.7863C16.0119 12.16 15.27 13.4369 14.4619 14.6719C13.0193 16.8711 11.4062 18.9316 9.68894 20.9114C9.66999 20.934 9.6479 20.9598 9.61002 21.005ZM13.4076 7.58757C13.4107 5.45291 11.7061 3.71487 9.61317 3.71487C7.51711 3.71487 5.81563 5.44968 5.81563 7.58434C5.81563 9.719 7.51711 11.457 9.61002 11.457C11.7029 11.457 13.4044 9.72545 13.4076 7.58757Z"
                                                    fill="#2a9f2e" />
                                                <path
                                                    d="M6.65738 18.377C6.2912 18.4318 5.92818 18.4834 5.56831 18.5479C4.4824 18.7381 3.41858 19.0057 2.41474 19.4862C2.02331 19.6764 1.65081 19.8957 1.34461 20.215C0.852161 20.7309 0.852161 21.2597 1.35724 21.766C1.78655 22.1981 2.32004 22.4496 2.87247 22.6688C3.9426 23.088 5.06008 23.317 6.19334 23.4718C7.75592 23.6878 9.32797 23.7394 10.9032 23.662C12.6678 23.5749 14.4135 23.3492 16.096 22.7624C16.5948 22.5882 17.0809 22.3819 17.5102 22.0594C17.7028 21.9143 17.889 21.7466 18.0374 21.5564C18.3246 21.1888 18.3341 20.7792 18.0374 20.4213C17.8353 20.1763 17.586 19.9538 17.3208 19.7796C16.579 19.2927 15.7456 19.0154 14.8933 18.8155C14.1862 18.651 13.4696 18.5446 12.7562 18.4124C12.693 18.3995 12.6331 18.3899 12.5699 18.3802C12.6867 18.1287 12.7088 18.1222 12.9645 18.1416C14.0189 18.2254 15.0701 18.3415 16.1023 18.5769C16.6642 18.7026 17.2198 18.8542 17.728 19.1283C18.0468 19.2992 18.3625 19.4991 18.6245 19.7442C19.2969 20.3762 19.4169 21.2533 18.9875 22.0787C18.7571 22.5237 18.4193 22.8752 18.0342 23.1815C17.1945 23.849 16.238 24.2908 15.2342 24.6294C13.1224 25.342 10.9474 25.5774 8.73135 25.4807C7.02987 25.4033 5.36628 25.1227 3.75635 24.5359C2.76514 24.1747 1.82128 23.7233 1.01315 23.0139C0.659601 22.7043 0.359712 22.3432 0.170308 21.9014C-0.148521 21.1565 -0.00331158 20.3697 0.555429 19.7925C1.02262 19.3088 1.61293 19.0412 2.22849 18.8316C3.07134 18.5446 3.9426 18.3963 4.82017 18.2867C5.3063 18.2254 5.79244 18.1899 6.28173 18.1383C6.51848 18.1158 6.53742 18.1287 6.65738 18.377Z"
                                                    fill="#2a9f2e" />
                                            </g>
                                            <defs>
                                                <clippath id="clip0_5893_1951">
                                                    <rect width="19.2308" height="25" fill="white"
                                                        transform="translate(0 0.5)" />
                                                </clippath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div class="box1-content fs-14 fw-5 text-center lh-base text-black">
                                        {!! ucwords($vcard->location) !!}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        <div class="overflow-hidden">
            <!-- gallery-section -->
            @if ((isset($managesection) && $managesection['galleries']) || empty($managesection))
                @if (checkFeature('gallery') && $vcard->gallery->count())
                    <div class="gallery-section pt-50 px-20px position-relative">
                        <div class="position-absolute vector-75 gallery-vector-1">
                            <img src="{{ asset('assets/img/vcard37/gallery-vector-1.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        {{-- <div class="position-absolute vector-75 gallery-vector-3" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
                        <img src="{{ asset('assets/img/vcard37/gallery-vector-3.png') }}" alt="images" class="w-100" />
                    </div>
                    <div class="position-absolute vector-75 gallery-vector-2 text-end" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
                        <img src="{{ asset('assets/img/vcard37/gallery-vector-2.png') }}" alt="images" class="w-100" />
                    </div>
                    <div class="position-absolute vector-75 gallery-vector-4 text-end" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
                        <img src="{{ asset('assets/img/vcard37/gallery-vector-4.png') }}" alt="images" class="w-100" />
                    </div> --}}
                        <div class="section-heading text-center mb-30px">
                            <p
                                class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                                {{ __('messages.plan.gallery') }}</p>
                        </div>
                        <div class="gallery-slider">
                            @foreach ($vcard->gallery as $file)
                                @php
                                    $infoPath = pathinfo(public_path($file->gallery_image));
                                    $extension = $infoPath['extension'];
                                @endphp
                                <div>
                                    <div
                                        class="gallery-box h-100 w-100 d-flex align-items-end mx-auto overflow-hidden">
                                        <div class="expand-icon pe-none">
                                            <i class="fas fa-expand"></i>
                                        </div>
                                        <div class="gallery-img">
                                            @if ($file->type == App\Models\Gallery::TYPE_IMAGE)
                                                <a href="{{ $file->gallery_image }}"
                                                    data-lightbox="gallery-images"><img
                                                        src="{{ $file->gallery_image }}" alt="profile"
                                                        class="w-100 h-100 object-fit-contain" loading="lazy" /></a>
                                            @elseif($file->type == App\Models\Gallery::TYPE_FILE)
                                                <a id="file_url" href="{{ $file->gallery_image }}"
                                                    class="gallery-link gallery-file-link" target="_blank"
                                                    loading="lazy">
                                                    <div class="gallery-item gallery-file-item"
                                                        @if ($extension == 'pdf') style="background-image: url({{ asset('assets/images/pdf-icon.png') }})"> @endif
                                                        @if ($extension == 'xls') style="background-image: url({{ asset('assets/images/xls.png') }})"> @endif
                                                        @if ($extension == 'csv') style="background-image: url({{ asset('assets/images/csv-file.png') }})"> @endif
                                                        @if ($extension == 'xlsx') style="background-image: url({{ asset('assets/images/xlsx.png') }})"> @endif
                                                        </div>
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
                                                    class="w-100" height="315">
                                                </iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            <!-- service-section -->
            @if ((isset($managesection) && $managesection['services']) || empty($managesection))
                @if (checkFeature('services') && $vcard->services->count())
                    <div class="service-section pt-50  position-relative">
                        <div class="position-absolute vector-75 service-vector-1 text-end">
                            <img src="{{ asset('assets/img/vcard37/service-vector-1.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        {{--  <div class="position-absolute vector-75 service-vector-2 text-end" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
                        <img src="{{ asset('assets/img/vcard37/service-vector-2.png') }}" alt="images" class="w-100" />
                    </div> --}}
                        <div class="section-heading text-center mb-30px">
                            <p
                                class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                                {{ __('messages.vcard.our_service') }}</p>
                        </div>
                        @if ($vcard->services_slider_view)
                            <div class="px-20px">
                                <div class="service-slider">
                                    @foreach ($vcard->services as $service)
                                        <div>
                                            <div class="service-box bg-white w-100 mx-auto">
                                                <div class="service-img h-100 w-100 mb-10px">
                                                    <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                                                        class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                                                        target="{{ $service->service_url ? '_blank' : '' }}">
                                                        <img src="{{ $service->service_icon }}" alt="branding"
                                                            loading="lazy" class="h-100 w-100 object-fit-cover" />
                                                    </a>
                                                </div>
                                                <div class="service-content"
                                                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                                    <h6 class="card-title fw-bold text-black text-center">
                                                        {{ ucwords($service->name) }}
                                                    </h6>
                                                    <p
                                                        class="mb-0 text-gray description-text text-center  {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}">
                                                        {!! \Illuminate\Support\Str::limit($service->description, 170, '...') !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="px-30px">
                                <div class="row services-grid-view row-gap-20px">
                                    @foreach ($vcard->services as $service)
                                        <div class="col-sm-6" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                            <div class="service-box bg-white w-100 mx-auto h-100 d-flex flex-column">
                                                <div class="service-img h-100 w-100 mb-10px">
                                                    <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                                                        class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                                                        target="{{ $service->service_url ? '_blank' : '' }}">
                                                        <img src="{{ $service->service_icon }}" alt="branding"
                                                            loading="lazy" class="h-100 w-100 object-fit-cover" />
                                                    </a>
                                                </div>
                                                <div class="service-content flex-grow-1"
                                                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                                    <h6 class="card-title fw-bold text-black text-center">
                                                        {{ ucwords($service->name) }}
                                                    </h6>
                                                    <p
                                                        class="mb-0 text-gray description-text text-center  {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}">
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
            <!-- appointment-section -->
            @if ((isset($managesection) && $managesection['appointments']) || empty($managesection))
                @if (checkFeature('appointments') && $vcard->appointmentHours->count())
                    <div class="appointment-section pt-50 px-30px"
                        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                        <div class="position-absolute vector-75 appointment-vector-1 text-start">
                            <img src="{{ asset('assets/img/vcard37/appointment-vector-1.png') }}" alt="images"
                                class="w-100" />
                        </div>
                        <div class="section-heading text-center mb-30px px-30px">
                            <p
                                class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                                {{ __('messages.make_appointments') }}</p>
                        </div>
                        <div class="appointment-bg position-relative appointment">
                            <div class="overlay"></div>
                            <div class="position-relative">
                                <div class="input-group-date d-flex align-items-center position-relative">
                                    <input type="text" name="date"
                                        class="date appoint-input appointment-input form-control p-0 fw-5 fs-14 lh-sm text-black bg-transparent border-0 rounded-0"
                                        placeholder="{{ __('messages.form.pick_date') }}" id='pickUpDate' />
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0 p-0 rounded-0 bg-transparent ms-1" id>
                                            <img src="{{ asset('assets/img/vcard37/calender.svg') }}"
                                                alt="image" />
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="container px-sm-1 px-0">
                                        <div id="slotData" class="row">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button
                                        class="btn btn-primary fs-18 fw-6 appointment-btn mx-auto appointmentAdd d-none">
                                        {{ __('messages.make_appointments') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('vcardTemplates.appointment')
                @endif
            @endif
        </div>
        <!-- product-section -->
        @if ((isset($managesection) && $managesection['products']) || empty($managesection))
            @if (checkFeature('products') && $vcard->products->count())
                <div class="product-section px-20px position-relative pt-50">
                    <div class="position-absolute vector-75 product-vector-1 text-end">
                        <img src="{{ asset('assets/img/vcard37/product-vector-1.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    {{--  <div class="position-absolute vector-75 product-vector-2" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <img src="{{ asset('assets/img/vcard37/product-vector-2.png') }}" alt="images" class="w-100" />
                </div> --}}
                    <div class="section-heading text-center mb-30px px-30px">
                        <p
                            class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                            {{ __('messages.plan.products') }}</p>
                    </div>
                    <div class="product-slider">
                        @foreach ($vcard->products as $product)
                            <div>
                                <div class="product-box w-100 mx-auto">
                                    <a @if ($product->product_url) href="{{ $product->product_url }}" @endif
                                        target="_blank"
                                        class="text-decoration-none fs-6 position-relative d-block h-100">
                                        <div class="product-img h-100 w-100 mb-10px">
                                            <img src="{{ $product->product_icon }}" alt="product"
                                                class="h-100 w-100 object-fit-cover" />
                                        </div>
                                        <div class="product-content"
                                            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                            <div
                                                class="d-flex align-items-center gap-2 justify-content-center flex-column">
                                                <p class="fw-6 text-black mb-0 product-name text-center">
                                                    {{ $product->name }}
                                                </p>

                                                @if ($product->currency_id && $product->price)
                                                    <p class="mb-0 text-center product-amount">
                                                        {{ currencyFormat($product->price, 2, $product->currency->currency_code) }}
                                                    </p>
                                                @elseif($product->price)
                                                    <p class="mb-0 text-center product-amount">
                                                        {{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 mt-sm-5 text-center">
                        <a class="fs-6 text product-view-more view-more btn btn-primary d-inline-flex gap-2 align-items-center"
                            href="{{ $vcardProductUrl }}">{{ __('messages.analytics.view_more') }} <i
                                class="fa-solid fa-arrow-right right-arrow-animation"></i></a>
                    </div>
                </div>
            @endif
        @endif
        <!-- testimonial-section -->
        @if ((isset($managesection) && $managesection['testimonials']) || empty($managesection))
            @if (checkFeature('testimonials') && $vcard->testimonials->count())
                <div class="testimonial-section px-20px pt-50 position-relative">
                    <div class="position-absolute vector-75 testimonial-vector-1">
                        <img src="{{ asset('assets/img/vcard37/testimonial-vector-1.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    <div class="section-heading text-center mb-30px">
                        <p
                            class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                            {{ __('messages.plan.testimonials') }}</p>
                    </div>
                    <div class="testimonial-slider">
                        @foreach ($vcard->testimonials as $testimonial)
                            <div>
                                <div class="testimonial-box position-relative">
                                    <div class="quote-img top-img">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                            viewBox="0 0 40 40" fill="none">
                                            <circle cx="20" cy="20" r="19.5" fill="white"
                                                stroke="#cee7d5" />
                                            <path
                                                d="M16.334 11.9475C16.5284 12.3933 16.7545 12.8375 16.9668 13.26C14.8601 14.2477 13.4053 15.8015 12.999 18.1292L12.9277 18.5364L13.3154 18.6829C13.6459 18.8073 13.9924 18.9188 14.2793 19.0198C14.5796 19.1255 14.8462 19.23 15.0879 19.3586V19.3577C16.4942 20.1068 17.3428 21.1934 17.6006 22.6321L17.6445 22.9241C17.8199 24.3824 17.3715 25.5643 16.5791 26.427C15.8287 27.2439 14.7521 27.7926 13.5615 27.9915L13.3213 28.0256C10.9504 28.3242 8.65229 27.1495 7.78613 24.679L7.70703 24.4358C7.13908 22.556 7.28334 20.6931 7.99414 18.8674L8.14355 18.5032C9.65351 15.0031 12.4124 12.8625 16.334 11.9475Z"
                                                fill="#cee7d5" stroke="#cee7d5" />
                                            <path
                                                d="M30.7148 11.9507C30.9159 12.3917 31.1338 12.8313 31.3447 13.2593C29.2365 14.2442 27.7883 15.8089 27.3613 18.1958L27.2764 18.6675L27.7432 18.772L28.1924 18.8735H28.1943C29.2773 19.1707 30.1303 19.638 30.7568 20.2671C31.3026 20.8152 31.695 21.5043 31.9121 22.355L31.9941 22.729C32.4649 25.2666 30.7324 27.5421 27.9727 27.9907L27.7031 28.0288C25.1062 28.3316 22.8147 26.9289 22.0645 24.3677L21.9961 24.1157C21.4635 21.9521 21.7955 19.8851 22.7959 17.8979L23.0049 17.5015C24.6379 14.5349 27.2469 12.7396 30.7148 11.9507Z"
                                                fill="#cee7d5" stroke="#cee7d5" />
                                        </svg>
                                    </div>
                                    <div class="quote-img bottom-img">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                            viewBox="0 0 40 40" fill="none">
                                            <circle cx="20" cy="20" r="19.5"
                                                transform="rotate(-180 20 20)" fill="white" stroke="#cee7d5" />
                                            <path
                                                d="M23.666 28.0525C23.4716 27.6067 23.2455 27.1625 23.0332 26.74C25.1399 25.7523 26.5947 24.1985 27.001 21.8708L27.0723 21.4636L26.6846 21.3171C26.3541 21.1927 26.0076 21.0812 25.7207 20.9802C25.4204 20.8745 25.1538 20.77 24.9121 20.6414V20.6423C23.5058 19.8932 22.6572 18.8066 22.3994 17.3679L22.3555 17.0759C22.1801 15.6176 22.6285 14.4357 23.4209 13.573C24.1713 12.7561 25.2479 12.2074 26.4385 12.0085L26.6787 11.9744C29.0496 11.6758 31.3477 12.8505 32.2139 15.321L32.293 15.5642C32.8609 17.444 32.7167 19.3069 32.0059 21.1326L31.8564 21.4968C30.3465 24.9969 27.5876 27.1375 23.666 28.0525Z"
                                                fill="#cee7d5" stroke="#cee7d5" />
                                            <path
                                                d="M9.28516 28.0493C9.08408 27.6083 8.86622 27.1687 8.65527 26.7407C10.7635 25.7558 12.2117 24.1911 12.6387 21.8042L12.7236 21.3325L12.2568 21.228L11.8076 21.1265H11.8057C10.7227 20.8293 9.86973 20.362 9.24316 19.7329C8.69738 19.1848 8.30499 18.4957 8.08789 17.645L8.00586 17.271C7.5351 14.7334 9.26758 12.4579 12.0273 12.0093L12.2969 11.9712C14.8938 11.6684 17.1853 13.0711 17.9355 15.6323L18.0039 15.8843C18.5365 18.0479 18.2045 20.1149 17.2041 22.1021L16.9951 22.4985C15.3621 25.4651 12.7531 27.2604 9.28516 28.0493Z"
                                                fill="#cee7d5" stroke="#cee7d5" />
                                        </svg>
                                    </div>

                                    <div>
                                        <p
                                            class="text-gray fw-medium lh-base mb-3 text-center testiimonial-desc {{ \Illuminate\Support\Str::length($testimonial->description) > 80 ? 'more' : '' }}">
                                            "{!! $testimonial->description !!}"
                                        </p>
                                        <div class="d-flex justify-content-center align-items-center gap-3">
                                            <div
                                                class=" testimonial-box-img d-flex justify-content-center align-items-center">
                                                <img src="{{ $testimonial->image_url }}" alt="image"
                                                    class="h-100 w-100 object-fit-cover" />

                                            </div>
                                            <p
                                                class="fw-6 mb-0 text-black-100 lh-12 text-center text-sm-start testimonial-title @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
                                                {{ ucwords($testimonial->name) }}</p>
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
                <div class="px-20px position-relative pt-50">
                    <div class="position-absolute vector-75 insta-feed-vector-1 text-end"
                        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
                        <img src="{{ asset('assets/img/vcard37/insta-feed-vector-1.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    <div class="section-heading text-center mb-30px px-30px mb-3">
                        <p
                            class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                            {{ __('messages.feature.insta_embed') }}</p>
                    </div>
                    <nav>
                        <div class="row insta-toggle">
                            <div class="nav nav-tabs border-0 px-0" id="nav-tab" role="tablist">
                                <button
                                    class="d-flex align-items-center justify-content-center py-2 active postbtn instagram-btn  border-0  mr-0"
                                    id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                                    role="tab" aria-controls="nav-home" aria-selected="true">
                                    <svg aria-label="Posts" class="svg-post-icon x1lliihq x1n2onr6 x173jzuc"
                                        fill="currentColor" height="24" role="img" viewBox="0 0 24 24"
                                        width="24">
                                        <title>Posts</title>
                                        <rect fill="none" height="18" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            width="18" x="3" y="3"></rect>
                                        <line fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" x1="9.015" x2="9.015"
                                            y1="3" y2="21">
                                        </line>
                                        <line fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" x1="14.985" x2="14.985"
                                            y1="3" y2="21">
                                        </line>
                                        <line fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" x1="21" x2="3"
                                            y1="9.015" y2="9.015">
                                        </line>
                                        <line fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" x1="21" x2="3"
                                            y1="14.985" y2="14.985">
                                        </line>
                                    </svg>
                                </button>
                                <button
                                    class="d-flex align-items-center justify-content-center py-2 instagram-btn reelsbtn  border-0 text-dark mr-0"
                                    id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                                    <svg class="svg-reels-icon" viewBox="0 0 48 48" width="27" height="27">
                                        <path
                                            d="m33,6H15c-.16,0-.31,0-.46.01-.7401.04-1.46.17-2.14.38-3.7,1.11-6.4,4.55-6.4,8.61v18c0,4.96,4.04,9,9,9h18c4.96,0,9-4.04,9-9V15c0-4.96-4.04-9-9-9Zm7,27c0,3.86-3.14,7-7,7H15c-3.86,0-7-3.14-7-7V15c0-3.37,2.39-6.19,5.57-6.85.46-.1.94-.15,1.43-.15h18c3.86,0,7,3.14,7,7v18Z"
                                            fill="currentColor" class="color000 svgShape not-active-svg"></path>
                                        <path
                                            d="M21 16h-2.2l-.66-1-4.57-6.85-.76-1.15h2.39l.66 1 4.67 7 .3.45c.11.17.17.36.17.55zM34 16h-2.2l-.66-1-4.67-7-.66-1h2.39l.66 1 4.67 7 .3.45c.11.17.17.36.17.55z"
                                            fill="currentColor" class="color000 svgShape not-active-svg"></path>
                                        <rect width="36" height="3" x="6" y="15" fill="currentColor"
                                            class="color000 svgShape"></rect>
                                        <path
                                            d="m20,35c-.1753,0-.3506-.0459-.5073-.1382-.3052-.1797-.4927-.5073-.4927-.8618v-10c0-.3545.1875-.6821.4927-.8618.3066-.1797.6831-.1846.9932-.0122l9,5c.3174.1763.5142.5107.5142.874s-.1968.6978-.5142.874l-9,5c-.1514.084-.3188.126-.4858.126Zm1-9.3003v6.6006l5.9409-3.3003-5.9409-3.3003Z"
                                            fill="currentColor" class="color000 svgShape not-active-svg"></path>
                                        <path
                                            d="m6,33c0,4.96,4.04,9,9,9h18c4.96,0,9-4.04,9-9v-16H6v16Zm13-9c0-.35.19-.68.49-.86.31-.18.69-.19,1-.01l9,5c.31.17.51.51.51.87s-.2.7-.51.87l-9,5c-.16.09-.3199.13-.49.13-.18,0-.35-.05-.51-.14-.3-.18-.49-.51-.49-.86v-10Zm23-9c0-4.96-4.04-9-9-9h-5.47l6,9h8.47Zm-10.86,0l-6.01-9h-10.13c-.16,0-.31,0-.46.01l5.99,8.99h10.61ZM12.4,6.39c-3.7,1.11-6.4,4.55-6.4,8.61h12.14l-5.74-8.61Z"
                                            fill="currentColor" class="color000 svgShape active-svg"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </nav>
                </div>
                <div id="postContent" class="insta-feed px-30px">
                    <div class="row overflow-hidden mt-3 row-gap-20px" loading="lazy">
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
                <div class="d-none insta-feed px-20px" id="reelContent">
                    <div class="row overflow-hidden mt-3 row-gap-20px">
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
            @endif
        @endif
        {{-- Linkedin --}}
        @if ((isset($managesection) && $managesection['linkedin_embed']) || empty($managesection))
            @if (checkFeature('linkedin_embed') && $vcard->linkedinEmbed->count())
                <div class="px-20px position-relative pt-50">
                    <div class="section-heading text-center mb-30px px-30px mb-3">
                        <p
                            class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                            {{ __('messages.feature.linkedin_embed') }}
                        </p>
                    </div>

                    <div class="linkedin-feed">
                        <div class="row overflow-hidden m-0 mt-2 loading="lazy"">
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
        <!-- blog-section -->
        @if ((isset($managesection) && $managesection['blogs']) || empty($managesection))
            @if (checkFeature('blog') && $vcard->blogs->count())
                <div class="blog-section px-20px pt-50 mb-40 position-relative">
                    <div class="position-absolute vector-75 blog-vector-1">
                        <img src="{{ asset('assets/img/vcard37/blog-vector-1.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    <div class="section-heading text-center mb-30px">
                        <p
                            class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                            {{ __('messages.feature.blog') }}
                        </p>
                    </div>
                    <div class="position-relative">
                        <div
                            class="align-items-center justify-content-center gap-20 position-absolute arrow-slide-all d-none d-sm-flex start-0 mx-auto end-0 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') end-0 start-auto justify-content-end @endif">
                            <button class="prev arrow-slide d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10"
                                    viewBox="0 0 12 10" fill="none">
                                    <path
                                        d="M5.32018 9.26017C5.15944 9.41373 4.94146 9.5 4.71417 9.5C4.48689 9.5 4.26891 9.41373 4.10816 9.26017L0.250963 5.57417C0.090271 5.42056 0 5.21225 0 4.99505C0 4.77786 0.090271 4.56955 0.250963 4.41594L4.10816 0.729935C4.26983 0.580727 4.48635 0.498165 4.71109 0.500031C4.93583 0.501898 5.15082 0.588042 5.30974 0.739912C5.46867 0.891783 5.55881 1.09723 5.56076 1.312C5.56272 1.52676 5.47632 1.73367 5.32018 1.88816L2.99986 4.17594L11.1428 4.17594C11.3702 4.17594 11.5882 4.26224 11.7489 4.41585C11.9097 4.56947 12 4.77781 12 4.99505C12 5.2123 11.9097 5.42064 11.7489 5.57425C11.5882 5.72787 11.3702 5.81417 11.1428 5.81417L2.99986 5.81417L5.32018 8.10195C5.48088 8.25556 5.57115 8.46386 5.57115 8.68106C5.57115 8.89826 5.48088 9.10657 5.32018 9.26017Z"
                                        fill="currentColor" />
                                </svg>
                            </button>
                            <button class="next arrow-slide d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10"
                                    viewBox="0 0 12 10" fill="none">
                                    <path
                                        d="M6.67982 0.739825C6.84056 0.586265 7.05854 0.5 7.28583 0.5C7.51311 0.5 7.73109 0.586265 7.89184 0.739825L11.749 4.42583C11.9097 4.57944 12 4.78775 12 5.00495C12 5.22214 11.9097 5.43045 11.749 5.58406L7.89184 9.27007C7.73017 9.41927 7.51365 9.50183 7.28891 9.49997C7.06417 9.4981 6.84918 9.41196 6.69026 9.26009C6.53133 9.10822 6.44119 8.90277 6.43924 8.688C6.43728 8.47324 6.52368 8.26633 6.67982 8.11184L9.00014 5.82406H0.857156C0.629824 5.82406 0.411803 5.73776 0.251055 5.58415C0.0903073 5.43053 0 5.22219 0 5.00495C0 4.7877 0.0903073 4.57936 0.251055 4.42575C0.411803 4.27213 0.629824 4.18583 0.857156 4.18583H9.00014L6.67982 1.89805C6.51912 1.74444 6.42885 1.53614 6.42885 1.31894C6.42885 1.10174 6.51912 0.893431 6.67982 0.739825Z"
                                        fill="currentColor" />
                                </svg>
                            </button>
                        </div>
                        <div class="blog-slider">
                            @foreach ($vcard->blogs as $blog)
                                <?php
                                $vcardBlogUrl = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/blog/{$blog->id}" : route('vcard.show-blog', [$vcard->url_alias, $blog->id]);
                                ?>
                                <div>
                                    <div class="blog-box">

                                        <div class="blog-img-box mx-auto">
                                            <div class="blog-img position-relative w-100 h-100 mx-auto">
                                                <a href="{{ $vcardBlogUrl }}">
                                                    <img src="{{ $blog->blog_icon }}" alt="images"
                                                        class="h-100 w-100 object-fit-cover" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="blog-content" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                            <h2 class="blog-title fw-6 text-black mb-2">
                                                {{ $blog->title }}</h2>
                                            <p class="blog-desc text-black mb-1">
                                                {{ Illuminate\Support\Str::words(str_replace('&nbsp;', ' ', strip_tags($blog->description)), 100, '...') }}
                                            </p>
                                            <div
                                                class=" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') ms-0 text-start @else ms-auto text-end @endif">
                                                <a href="{{ $vcardBlogUrl }}"
                                                    class="d-inline-flex fs-14 fw-5 gap-2 align-items-center justify-content-end ms-auto text-primary">
                                                    <span
                                                        class=" text-decoration-underline">{{ __('messages.vcard_11.read_more') }}</span>
                                                    <i class="fa-solid fa-arrow-right-long"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif
        <!-- business-section -->
        @if ((isset($managesection) && $managesection['business_hours']) || empty($managesection))
            @if ($vcard->businessHours->count())
                @php
                    $todayWeekName = strtolower(\Carbon\Carbon::now()->rawFormat('D'));
                @endphp
                <div class="business-section px-30px pt-50 position-relative"
                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <div class="position-absolute vector-75 business-vector text-end">
                        <img src="{{ asset('assets/img/vcard37/business-vector.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    <div class="section-heading text-center mb-30px px-30px">
                        <p
                            class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                            {{ __('messages.business.business_hours') }}</p>
                    </div>
                    <div class="business-box row row-gap-20px justify-content-center">
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
                                <div class="business-box1 d-flex align-items-center gap-2">
                                    <div
                                        class="time-icons d-flex justify-content-center align-items-center text-teal-green"">
                                        <svg xmlns=" http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                    </div>
                                    <div class="business-hour w-100">
                                        <div class="fs-14 lh-normal fw-6 text-gray text-center">
                                            {{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) . ' ' }}
                                        </div>
                                        <div class="fs-14 fw-6 text-black text-center">
                                            {{ $dayTime ?? __('messages.common.closed') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
        <!-- qr-section -->
        @if (isset($vcard['show_qr_code']) && $vcard['show_qr_code'] == 1)
            <div class="qr-code-section position-relative pt-50 px-30">
                <div class="position-absolute vector-75 qr-vector-1">
                    <img src="{{ asset('assets/img/vcard37/qr-vector-1.png') }}" alt="images" class="w-100" />
                </div>
                <div class="section-heading text-center mb-30px px-30px">
                    <p class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                        {{ __('messages.vcard.qr_code') }}</p>
                </div>
                <div class="qr-code mx-auto  position-relative">

                    <div class="d-flex flex-sm-row flex-column gap-3 align-items-center"
                        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                        <div class="qr-code-img text-center" id="qr-code-thirtyseven">
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
                        <div class="text-sm-start text-center">
                            <h5 class="fw-6">{{ __('messages.vcard.scan_to_contact') }}</h5>
                            <p class="desc text-gray mb-0 fw-5">{{ __('messages.vcard.qr_section_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- iframe --}}
        @if ((isset($managesection) && $managesection['iframe']) || empty($managesection))
            @if (checkFeature('iframes') && $vcard->iframes->count())
                <div class="iframe-section pt-50 px-20px position-relative">
                    <div class="position-absolute vector-75 iframe-vector-1 text-end">
                        <img src="{{ asset('assets/img/vcard37/iframe-vector-1.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    <div class="section-heading text-center mb-30px px-30px">
                        <p
                            class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                            {{ __('messages.vcard.iframe') }}</p>
                    </div>
                    <div class="iframe-slider">
                        @foreach ($vcard->iframes as $iframe)
                            <div class="slide">
                                <div class="iframe-card">
                                    <iframe src="{{ $iframe->url }}" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen width="100%" height="350">
                                    </iframe>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
        @php
            $currentSubs = $vcard
                ->subscriptions()
                ->where('status', \App\Models\Subscription::ACTIVE)
                ->latest()
                ->first();
        @endphp
        <!-- contact-us-section -->
        @if ($currentSubs && $currentSubs->plan->planFeature->enquiry_form && $vcard->enable_enquiry_form)
            <div class="contact-us-section px-30px pt-50 position-relative"
                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
                <div class="position-absolute vector-75 contact-vector-1 text-start">
                    <img src="{{ asset('assets/img/vcard37/contact-vector-1.png') }}" alt="images"
                        class="w-100" />
                </div>
                {{-- <div class="position-absolute vector-75 contact-vector-2 text-end" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
                    <img src="{{ asset('assets/img/vcard37/contact-vector-2.png') }}" alt="images" class="w-100" />
                </div> --}}
                <div class="section-heading text-center mb-30px">
                    <p class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                        {{ __('messages.contact_us.inquries') }}</p>
                </div>
                <div class="contact-form">
                    <form action="" id="enquiryForm" enctype="multipart/form-data">
                        @csrf
                        <div id="enquiryError" class="alert alert-danger d-none"></div>
                        <div class="mb-15px">
                            <input type="text" class="form-control text-gray fs-16 fw-5" name="name"
                                placeholder="{{ __('messages.form.your_name') }}" />
                        </div>
                        <div class="mb-15px">
                            <input type="email" class="form-control text-gray fs-16 fw-5" name="email"
                                placeholder="{{ __('messages.form.your_email') }}" />
                        </div>
                        <div class="mb-15px">
                            <input type="tel"
                                class="form-control text-gray fs-16 fw-5  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-end @endif"
                                name="phone" placeholder="{{ __('messages.form.phone') }}"
                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,&quot;&quot;)" />
                        </div>
                        <div class="mb-15px">
                            <textarea class="form-control text-gray fs-16 fw-5" name="message"
                                placeholder="{{ __('messages.form.type_message') }}" rows="3"></textarea>
                        </div>
                        @if (isset($inquiry) && $inquiry == 1)
                            <div class="mb-3">
                                <div class="wrapper-file-input">
                                    <div class="input-box" id="fileInputTrigger">
                                        <h4> <i class="fa-solid fa-upload me-2"></i>{{ __('messages.choose_file') }}
                                        </h4> <input type="file" id="attachment" name="attachment" hidden
                                            multiple />
                                    </div> <small class="text-gray">{{ __('messages.file_supported') }}</small>
                                </div>
                                <div class="wrapper-file-section">
                                    <div class="selected-files" id="selectedFilesSection" style="display: none;">
                                        <h5 class="text-black">{{ __('messages.selected_files') }}</h5>
                                        <ul class="file-list" id="fileList"></ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                            <div class="col-12 mb-4">
                                <div class="d-flex gap-1">
                                    <input type="checkbox" name="terms_condition"
                                        class="form-check-input terms-condition" id="termConditionCheckbox"
                                        placeholder>&nbsp;
                                    <label class="form-check-label" for="privacyPolicyCheckbox">
                                        <span class="text-black fs-14">{{ __('messages.vcard.agree_to_our') }}</span>
                                        <a href="{{ $vcardPrivacyAndTerm }}" target="_blank"
                                            class="text-decoration-none link-info fs-14 fw-5 text-teal-green">{!! __('messages.vcard.term_and_condition') !!}</a>
                                        <span class="text-black">&</span>
                                        <a href="{{ $vcardPrivacyAndTerm }}" target="_blank"
                                            class="text-decoration-none link-info fs-14 fw-5 text-teal-green">{{ __('messages.vcard.privacy_policy') }}</a>
                                    </label>
                                </div>
                            </div>
                        @endif
                        <div class="text-center">
                            <button class="contact-btn send-btn btn btn-primary fw-6"
                                type="submit">{{ __('messages.contact_us.send_message') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        {{-- newslatter modal --}}
        @if ((isset($managesection) && $managesection['news_latter_popup']) || empty($managesection))
            <div class="modal fade" id="newsLatterModal" tabindex="-1" aria-labelledby="newsLatterModalLabel"
                aria-hidden="true">
                <div class="modal-dialog news-modal modal-dialog-centered">
                    <div class="modal-content animate-bottom" id="newsLatter-content">
                        <div class="newsmodal-header px-0 position-relative">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="closeNewsLatterModal"></button>
                        </div>
                        <div class="modal-body">
                            <h3 class="content text-start mb-2">
                                {{ __('messages.vcard.subscribe_newslatter') }}</h3>
                            <p class="modal-desc text-start">
                                {{ __('messages.vcard.update_directly') }}</p>
                            <form action="" method="post" id="newsLatterForm">
                                @csrf
                                <input type="hidden" name="vcard_id" value="{{ $vcard->id }}">
                                <div
                                    class="mb-1 mt-3 d-flex gap-1 justify-content-center align-items-center email-input">
                                    <div class="w-100">
                                        <input type="email" class="form-control email-input w-100"
                                            placeholder="{{ __('messages.form.enter_your_email') }}"
                                            aria-label="Email" name="email" id="emailSubscription"
                                            aria-describedby="button-addon2">
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
        <!-- Create Your vCard -->
        @if ($currentSubs && $currentSubs->plan->planFeature->affiliation && $vcard->enable_affiliation)
            <div class="z-1 your-vcard-section px-30px pt-50 position-relative">
                <div class="position-absolute vector-75 your-vcard-vector-1">
                    <img src="{{ asset('assets/img/vcard37/your-vcrad-vector-1.png') }}" alt="images"
                        class="w-100" />
                </div>
                <div class="section-heading text-center mb-30px">
                    <p class="text-black text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                        {{ __('messages.create_vcard') }}</p>
                </div>
                <div class="your-vacrd-bg position-relative" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
                    <div
                        class="input-group v-card-input bg-transparent w-100 d-flex justify-content-center gap-20 align-items-center flex-nowrap position-relative mx-auto z-1">
                        <a class="text-black fs-14 lh-base text-wrap fw-6 text-decoration-none"
                            href="{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}">
                            {{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}
                        </a>
                        <div class="input-group-append">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M14.3965 7.95047H13.2665C13.0325 7.95047 12.8428 8.14019 12.8428 8.37421V13.5261C12.8428 13.7996 12.6203 14.0221 12.3468 14.0221H2.47324C2.19984 14.0221 1.97746 13.7996 1.97746 13.5261V3.65272C1.97746 3.37921 2.19984 3.15666 2.47324 3.15666H7.88893C8.12295 3.15666 8.31267 2.96693 8.31267 2.73292V1.60294C8.31267 1.36892 8.12295 1.1792 7.88893 1.1792H2.47324C1.10947 1.1792 0 2.28884 0 3.65272V13.5262C0 14.89 1.10952 15.9996 2.47324 15.9996H12.3467C13.7106 15.9996 14.8202 14.89 14.8202 13.5262V8.37427C14.8203 8.14019 14.6305 7.95047 14.3965 7.95047Z"
                                    fill="black" />
                                <path
                                    d="M15.5764 0.000488281H11.0818C10.8477 0.000488281 10.658 0.190211 10.658 0.424229V1.55421C10.658 1.78822 10.8477 1.97795 11.0818 1.97795H12.6244L6.81943 7.7828C6.65394 7.94829 6.65394 8.21655 6.81943 8.38209L7.61843 9.18115C7.69793 9.26064 7.80567 9.30528 7.9181 9.30528C8.03048 9.30528 8.13828 9.26064 8.21772 9.18115L14.0227 3.37618V4.91877C14.0227 5.15278 14.2124 5.34251 14.4464 5.34251H15.5764C15.8104 5.34251 16.0001 5.15278 16.0001 4.91877V0.424229C16.0001 0.190211 15.8104 0.000488281 15.5764 0.000488281Z"
                                    fill="black" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- map --}}
        @if ((isset($managesection) && $managesection['map']) || empty($managesection))
            @if ($vcard->location_type == 0 && ($vcard->location_url && isset($url[5])))
                <div class="px-30 pt-50 position-relative">
                    <div class="position-absolute vector-75 map-vector-1">
                        <img src="{{ asset('assets/img/vcard37/map-vector-1.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    <div class="map-border-main">
                        <div class="d-flex gap-2 mt-1 mb-3 align-items-center"
                            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                            <div class="location-map-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="21"
                                    viewBox="0 0 16 21" fill="none">
                                    <g clip-path="url(#clip0_94_705)">
                                        <path
                                            d="M8.00262 16.8233C7.41576 16.1353 6.86625 15.5103 6.33274 14.8643C4.97228 13.2046 3.67585 11.4977 2.66751 9.60168C2.25138 8.81912 1.87258 8.01554 1.74454 7.13319C1.56848 5.9147 1.85124 4.76975 2.4221 3.69307C3.61716 1.45042 6.05531 0.184663 8.67485 0.431512C11.1503 0.662604 13.3164 2.45357 14.0473 4.82752C14.5115 6.35063 14.2554 7.7687 13.5565 9.1605C12.6282 10.9935 11.4384 12.6531 10.158 14.255C9.46978 15.1059 8.74954 15.9357 8.00262 16.8233ZM11.145 6.06702C11.129 4.31281 9.7152 2.94202 7.94394 2.96302C6.2367 2.98403 4.8229 4.39685 4.84424 6.06702C4.86558 7.80546 6.26871 9.16575 8.03464 9.1605C9.73654 9.15 11.161 7.73193 11.145 6.06702Z"
                                            fill="#2a9f2e" />
                                        <path
                                            d="M5.50584 14.6857C5.02034 14.7698 4.52418 14.838 4.04401 14.9378C3.1904 15.1164 2.34745 15.3422 1.60053 15.8044C1.37646 15.941 1.17372 16.1196 1.003 16.3139C0.757586 16.5975 0.757586 16.9441 1.003 17.2277C1.18439 17.4326 1.40847 17.6217 1.64855 17.7635C2.46482 18.2362 3.37179 18.4672 4.29476 18.6196C7.12237 19.0922 9.94465 19.0922 12.7349 18.378C13.3271 18.2256 13.8873 17.9315 14.4582 17.7004C14.5062 17.6794 14.5489 17.6427 14.5915 17.6112C15.3598 17.0807 15.3705 16.4819 14.6075 15.9357C13.898 15.4263 13.0657 15.1847 12.2227 14.9956C11.6519 14.8696 11.0757 14.7803 10.4088 14.6542C10.5422 14.5807 10.6169 14.4914 10.6916 14.4967C12.068 14.5964 13.4445 14.7015 14.7196 15.274C15.029 15.4105 15.3224 15.6206 15.5625 15.8569C16.0427 16.3244 16.1227 16.9809 15.8186 17.5744C15.6052 17.9998 15.2744 18.3254 14.8903 18.6038C13.8019 19.3811 12.5589 19.796 11.2624 20.0534C8.54685 20.5943 5.85262 20.4998 3.21174 19.6385C2.36345 19.3601 1.54718 19.0082 0.880293 18.4042C0.592197 18.1469 0.330777 17.8265 0.154718 17.4851C-0.160053 16.8601 0.0213404 16.1983 0.554852 15.7309C1.09903 15.2582 1.76059 15.0166 2.45415 14.8906C3.37179 14.7225 4.3001 14.6227 5.22307 14.5019C5.31911 14.4914 5.42581 14.5544 5.53251 14.5859C5.52184 14.6227 5.51117 14.6542 5.50584 14.6857Z"
                                            fill="#2a9f2e" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_94_705">
                                            <rect width="16" height="20" fill="white"
                                                transform="translate(0 0.399994)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <p class="fw-6 fs-14 mb-0 text-break">{!! ucwords($vcard->location) !!}</p>
                        </div>
                        <iframe width="100%" height="300px"
                            src='https://maps.google.de/maps?q={{ $url[5] }}/&output=embed' frameborder="0"
                            scrolling="no" marginheight="0" marginwidth="0" style="border-radius: 10px;"></iframe>

                    </div>
                </div>
            @endif
            @if ($vcard->location_type == 1 && !empty($vcard->location_embed_tag))
                <div class="px-30 pt-50 position-relative">
                    <div class="position-absolute vector-75 map-vector-1">
                        <img src="{{ asset('assets/img/vcard37/map-vector-1.png') }}" alt="images"
                            class="w-100" />
                    </div>
                    <div class="map-border-main">
                        <div class="d-flex gap-2 mt-1 mb-3 align-items-center"
                            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                            <div class="location-map-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="21"
                                    viewBox="0 0 16 21" fill="none">
                                    <g clip-path="url(#clip0_94_705)">
                                        <path
                                            d="M8.00262 16.8233C7.41576 16.1353 6.86625 15.5103 6.33274 14.8643C4.97228 13.2046 3.67585 11.4977 2.66751 9.60168C2.25138 8.81912 1.87258 8.01554 1.74454 7.13319C1.56848 5.9147 1.85124 4.76975 2.4221 3.69307C3.61716 1.45042 6.05531 0.184663 8.67485 0.431512C11.1503 0.662604 13.3164 2.45357 14.0473 4.82752C14.5115 6.35063 14.2554 7.7687 13.5565 9.1605C12.6282 10.9935 11.4384 12.6531 10.158 14.255C9.46978 15.1059 8.74954 15.9357 8.00262 16.8233ZM11.145 6.06702C11.129 4.31281 9.7152 2.94202 7.94394 2.96302C6.2367 2.98403 4.8229 4.39685 4.84424 6.06702C4.86558 7.80546 6.26871 9.16575 8.03464 9.1605C9.73654 9.15 11.161 7.73193 11.145 6.06702Z"
                                            fill="#2a9f2e" />
                                        <path
                                            d="M5.50584 14.6857C5.02034 14.7698 4.52418 14.838 4.04401 14.9378C3.1904 15.1164 2.34745 15.3422 1.60053 15.8044C1.37646 15.941 1.17372 16.1196 1.003 16.3139C0.757586 16.5975 0.757586 16.9441 1.003 17.2277C1.18439 17.4326 1.40847 17.6217 1.64855 17.7635C2.46482 18.2362 3.37179 18.4672 4.29476 18.6196C7.12237 19.0922 9.94465 19.0922 12.7349 18.378C13.3271 18.2256 13.8873 17.9315 14.4582 17.7004C14.5062 17.6794 14.5489 17.6427 14.5915 17.6112C15.3598 17.0807 15.3705 16.4819 14.6075 15.9357C13.898 15.4263 13.0657 15.1847 12.2227 14.9956C11.6519 14.8696 11.0757 14.7803 10.4088 14.6542C10.5422 14.5807 10.6169 14.4914 10.6916 14.4967C12.068 14.5964 13.4445 14.7015 14.7196 15.274C15.029 15.4105 15.3224 15.6206 15.5625 15.8569C16.0427 16.3244 16.1227 16.9809 15.8186 17.5744C15.6052 17.9998 15.2744 18.3254 14.8903 18.6038C13.8019 19.3811 12.5589 19.796 11.2624 20.0534C8.54685 20.5943 5.85262 20.4998 3.21174 19.6385C2.36345 19.3601 1.54718 19.0082 0.880293 18.4042C0.592197 18.1469 0.330777 17.8265 0.154718 17.4851C-0.160053 16.8601 0.0213404 16.1983 0.554852 15.7309C1.09903 15.2582 1.76059 15.0166 2.45415 14.8906C3.37179 14.7225 4.3001 14.6227 5.22307 14.5019C5.31911 14.4914 5.42581 14.5544 5.53251 14.5859C5.52184 14.6227 5.51117 14.6542 5.50584 14.6857Z"
                                            fill="#2a9f2e" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_94_705">
                                            <rect width="16" height="20" fill="white"
                                                transform="translate(0 0.399994)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <p class="fw-6 fs-14 mb-0 text-break">{!! ucwords($vcard->location) !!}</p>
                        </div>
                        <div class="embed-responsive embed-responsive-16by9 rounded overflow-hidden justify-content-center d-flex mt-4"
                            style="height: 300px;">
                            {!! $vcard->location_embed_tag ?? '' !!}
                        </div>
                    </div>
                </div>
            @endif
        @endif
        <!-- add-section -->
        @if ($vcard->enable_contact)
            <div class="add-section">
                <img src="{{ asset('assets/img/vcard37/bottom-bg.png') }}" alt="images" class="w-100 h-100" />
            </div>
            <div class="addcard text-center">
                @if ($contactRequest == 1)
                    <a href="{{ Auth::check() ? route('add-contact', $vcard->id) : 'javascript:void(0);' }}"
                        class="z-2 btn btn-primary text-white fw-6 fs-16 lh-base add-btn d-flex gap-2 align-items-center position-fixed start-0 end-0 mx-auto add-contact-btn {{ Auth::check() ? 'auth-contact-btn' : 'ask-contact-detail-form' }}"
                        data-action="{{ Auth::check() ? route('contact-request.store') : 'show-modal' }}"
                        type="submit"><i class="fas fa-download fa-address-book"></i>
                        &nbsp;{{ __('messages.setting.add_contact') }}</a>
                @else
                    <a href="{{ route('add-contact', $vcard->id) }}"
                        class="z-2 btn btn-primary text-white fw-6 fs-16 lh-base add-btn d-flex gap-2 align-items-center position-fixed start-0 end-0 mx-auto"
                        type="submit"><i class="fas fa-download fa-address-book"></i>
                        &nbsp;{{ __('messages.setting.add_contact') }}</a>
                @endif
            </div>
            @include('vcardTemplates.contact-request')
        @endif
        {{-- made by --}}
        <div class="d-flex justify-content-evenly z-3 w-100 bottom-0 py-1 made-by-section"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
            @if (checkFeature('advanced'))
                @if (checkFeature('advanced')->hide_branding && $vcard->branding == 0)
                    @if ($vcard->made_by)
                        <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                            class="text-center text-decoration-none text-white fw-6 fs-14" target="_blank">
                            <small class="text-black">{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
                        </a>
                    @else
                        <div class="text-center">
                            <small class="text-black">{{ __('messages.made_by') }}
                                {{ $setting['app_name'] }}</small>
                        </div>
                    @endif
                @endif
            @else
                @if ($vcard->made_by)
                    <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                        class="text-center text-decoration-none text-black" target="_blank">
                        <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
                    </a>
                @else
                    <div class="text-center">
                        <small class="text-black">{{ __('messages.made_by') }}
                            {{ $setting['app_name'] }}</small>
                    </div>
                @endif
            @endif
            @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                <div>
                    <a class="text-decoration-none text-white cursor-pointer terms-policies-btn fw-6 fs-14"
                        href="{{ $vcardPrivacyAndTerm }}"><small
                            class="text-black">{!! __('messages.vcard.term_policy') !!}</small></a>
                </div>
            @endif
        </div>

        {{-- sticky buttons --}}
        <div class="btn-section cursor-pointer @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
            <div class="fixed-btn-section">
                <div
                    class="bars-btn flower-garden-bars-btn @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') vcard-bars-btn-left @endif">
                    {{-- <img src="{{ asset('assets/img/vcard30/sticky.png') }}" /> --}}
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.4134 0.540771H22.489C23.572 0.540771 24.4601 1.42891 24.4601 2.51188V9.5875C24.4601 10.6776 23.5731 11.5586 22.489 11.5586H15.4134C14.3222 11.5586 13.4423 10.6787 13.4423 9.5875V2.51188C13.4423 1.42783 14.3233 0.540771 15.4134 0.540771Z"
                            stroke="#ffffff" />
                        <path
                            d="M2.97143 0.5H8.74589C10.1129 0.5 11.2173 1.6122 11.2173 2.97143V8.74589C11.2173 10.1139 10.1139 11.2173 8.74589 11.2173H2.97143C1.6122 11.2173 0.5 10.1129 0.5 8.74589V2.97143C0.5 1.61328 1.61328 0.5 2.97143 0.5Z"
                            stroke="#ffffff" />
                        <path
                            d="M2.97143 13.783H8.74589C10.1139 13.783 11.2173 14.8863 11.2173 16.2544V22.0289C11.2173 23.3881 10.1129 24.5003 8.74589 24.5003H2.97143C1.61328 24.5003 0.5 23.387 0.5 22.0289V16.2544C0.5 14.8874 1.6122 13.783 2.97143 13.783Z"
                            stroke="#ffffff" />
                        <path
                            d="M16.2537 13.783H22.0282C23.3874 13.783 24.4996 14.8874 24.4996 16.2544V22.0289C24.4996 23.387 23.3863 24.5003 22.0282 24.5003H16.2537C14.8867 24.5003 13.7823 23.3881 13.7823 22.0289V16.2544C13.7823 14.8863 14.8856 13.783 16.2537 13.783Z"
                            stroke="#ffffff" />
                    </svg>
                </div>
                <div class="sub-btn d-none">
                    <div class="sub-btn-div @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') sub-btn-div-left @endif">
                        @if ($vcard->whatsapp_share)
                            <div class="icon-search-container mb-3" data-ic-class="search-trigger">
                                <div class="wp-btn">
                                    <i class="fab text-light  fa-whatsapp fa-2x" id="wpIcon"></i>
                                </div>
                                <input type="number" class="search-input" id="wpNumber"
                                    data-ic-class="search-input"
                                    placeholder="{{ __('messages.setting.wp_number') }}" />
                                <div class="share-wp-btn-div">
                                    <a href="javascript:void(0)"
                                        class="vcard37-sticky-btn vcard37-btn-group d-flex justify-content-center text-primary align-items-center rounded-0 text-decoration-none py-1 rounded-pill justify-content share-wp-btn">
                                        <i class="fa-solid fa-paper-plane"></i> </a>
                                </div>
                            </div>
                        @endif
                        @if (empty($vcard->hide_stickybar))
                            <div class="{{ isset($vcard->whatsapp_share) ? 'vcard37-btn-group' : 'stickyIcon' }}">
                                <button type="button"
                                    class="vcard37-btn-group vcard37-share vcard37-sticky-btn mb-3 px-2 py-1"><i
                                        class="fas fa-share-alt fs-4 pt-1"></i></button>
                                @if (!empty($vcard->enable_download_qr_code))
                                    <a type="button"
                                        class="vcard37-btn-group vcard37-sticky-btn d-flex justify-content-center  align-items-center  px-2 mb-3 py-2"
                                        id="qr-code-btn" download="qr_code.png"><i
                                            class="fa-solid fa-qrcode fs-4 text-primary"></i></a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- share modal code --}}
        <div id="vcard37-shareModel" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <div class="">
                        <div class="row align-items-center mt-3">
                            <div class="col-10 text-center">
                                <h5 class="modal-title pl-50">
                                    {{ __('messages.vcard.share_my_vcard') }}</h5>
                            </div>
                            <div class="col-2 p-0 text-center">
                                <button type="button" aria-label="Close"
                                    class="btn btn-sm btn-icon btn-active-color-danger border-none p-0"
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
                        <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}"
                            target="_blank" class="text-decoration-none share" title="Linkedin">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-linkedin fa-2x" style="color: #1B95E0"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_linkedin') }}</p>
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
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                            stroke-linejoin="round">
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
                                                height="514.23"></rect>
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
                            <div class="input-group">
                                <input type="text" class="form-control"
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
    </div>
    <!-- bootstrap script  -->
    {{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
    @include('vcardTemplates.template.templates')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/front-third-party.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
    <script>
        $("#myID").flatpickr();
        @if (isset(checkFeature('advanced')->custom_js) && $vcard->custom_js)
            {!! $vcard->custom_js !!}
        @endif
        //    let social = document.querySelector(".social");
        //     let closeBtn = document.querySelector(".btn1");
        //     closeBtn.addEventListener("click", () => {
        //         social.classList.toggle("close");
        //     });
        $(".testimonial-slider").slick({
            slidesToShow: 1,
            infinite: true,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 1000,
            arrows: false,
            dots: true,
        });
        $(".gallery-slider").slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 1000,
            arrows: false,
        });
        $(".service-slider").slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 2,
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
        $(".product-slider").slick({
            slidesToShow: 2,
            infinite: true,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1000,
            arrows: false,
            dots: false,
            responsive: [{
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                },
            }, ],
        });
        $(".blog-slider").slick({
            slidesToShow: 1,
            infinite: true,
            slidesToScroll: 1,
            // autoplay: true,
            // autoplaySpeed: 1000,
            arrows: true,
            prevArrow: $('.prev'),
            nextArrow: $('.next'),
            dots: false,
            responsive: [{
                breakpoint: 575,
                settings: {
                    dots: true,
                    arrows: false,
                },
            }, ],
        });
        $(".iframe-slider").slick({
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
                    centerPadding: "0",

                },
            }, ],
        });
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
        const qrCodeThirtyfive = document.getElementById("qr-code-thirtyseven");
        const svg = qrCodeThirtyfive.querySelector("svg");
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
