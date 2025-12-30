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
  <meta property="og:image" content="{{ $vcard->cover_url }}" />
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
  <link rel="stylesheet" href="{{ asset('assets/css/oldVcard/vcard37.css') }}">
  <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/slick-theme.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/custom.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}">
  @if (checkFeature('custom-fonts') && $vcard->font_family)
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family={{ urlencode($vcard->font_family) }}:wght@400;500;600;700&display=swap{{ in_array($vcard->font_family, ['Tajawal', 'Cairo', 'Amiri', 'Noto Sans Arabic', 'Noto Naskh Arabic', 'Noto Kufi Arabic', 'Scheherazade', 'Lateef', 'Harmattan', 'Reem Kufi', 'Jomhuria', 'Mada', 'Lemonada', 'Zain']) ? '&subset=arabic' : '' }}">
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
  @if (checkFeature('password'))
    @include('vcards.password')
  @endif

  <div class="main-section position-relative m-auto">
    <div class="@if ($vcard->cover_type == 2) yt-main-img @endif main-img h-100 w-100 position-relative">
      {{-- <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/main.png') }}" class="h-100 w-100 object-fit-cover"
                alt="images" /> --}}
      @php
        $coverClass = $vcard->cover_image_type == 0 ? 'object-fit-cover w-100 h-100' : 'object-fit-contain w-100 h-100';
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
            src="https://www.youtube.com/embed/{{ YoutubeID($vcard->youtube_link) }}?autoplay=1&mute=0&controls=0&loop=1&playlist={{ YoutubeID($vcard->youtube_link) }}"
            class="cover-video {{ $coverClass }}" id="cover-video" frameborder="0" allow="autoplay; encrypted-media"
            allowfullscreen>
          </iframe>
        </div>
      @endif
    </div>
    <!-- introduction-section -->
    <div class="introduction-section px-30px position-relative mb-20px"
      @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
      <div class="position-absolute vector-75 hero-vector-1 text-end">
        <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/hero-vector-1.png') }}" alt="images"
          class="w-100" />
      </div>
      <div class="position-absolute hero-vector-2">
        <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/hero-vector-2.png') }}" alt="images"
          class="w-100" />
      </div>
      <div class="position-absolute hero-vector-3">
        <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/hero-vector-3.png') }}" alt="images"
          class="w-100" />
      </div>
      <div class="position-absolute hero-vector-4">
        <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/hero-vector-4.png') }}" alt="images"
          class="w-100" />
      </div>
      <div class="d-block d-sm-flex align-items-start gap-30 @if ($vcard->cover_type == 2) profile-margin @endif">
        <div class="intro-box position-relative h-100 w-100 mx-auto mx-sm-0 mb-3 mb-sm-0">
          <div class="position-absolute intro-vector-1">
            <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/intro-vector-1.png') }}" alt="images"
              class="h-100 w-100 object-fit-cover" />
          </div>
          <div class="intro-img w-100 h-100">
            <img src="{{ $vcard->profile_url }}" alt="image" class="h-100 w-100 object-fit-cover" />
          </div>
          <div class="position-absolute intro-vector-2">
            <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/intro-vector-2.png') }}" alt="images"
              class="h-100 w-100 object-fit-cover" />
          </div>
        </div>
        <div class="@if ($vcard->cover_type == 2) pt-1 @else pt-5 @endif ">
          <p
            class="@if ($vcard->cover_type == 2) pt-2 @else pt-5 @endif fw-semibold text-teal-green fs-30 mb-5px text-center text-sm-start lh-12 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
            {{ ucwords($vcard->first_name . ' ' . $vcard->last_name) }} {{-- @if ($vcard->is_verified) --}}
            <i class="verification-icon bi-patch-check-fill"></i>
            {{-- @endif --}}
          </p>
          <p
            class="text-black fs-18 fw-semibold vcard-name text-center text-sm-start lh-12 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
            {{ ucwords($vcard->occupation) }}</p>
          <p
            class="text-black fs-18 fw-semibold vcard-name text-center text-sm-start lh-12 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
            {{ ucwords($vcard->job_title) }}</p>
          <p
            class="text-black fs-18 fw-semibold vcard-name text-center text-sm-start lh-12 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
            {{ ucwords($vcard->company) }}</p>
        </div>
      </div>
    </div>
    {{-- Pwa support --}}
    @if (isset($enable_pwa) && $enable_pwa == 1 && !isiOSDevice())
      <div class="mt-0">
        <div class="pwa-support d-flex align-items-center justify-content-center">
          <div>
            <h1 class="text-start pwa-heading">{{ __('messages.pwa.add_to_home_screen') }}</h1>
            <p class="text-start pwa-text text-dark">{{ __('messages.pwa.pwa_description') }} </p>
            <div class="text-end d-flex">
              <button id="installPwaBtn"
                class="pwa-install-button text-white w-50 mb-1 btn">{{ __('messages.pwa.install') }}
              </button>
              <button
                class= "pwa-cancel-button w-50 ms-2 pwa-close btn btn-secondary mb-1">{{ __('messages.common.cancel') }}</button>
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
      class="d-flex justify-content-end position-absolute top-0  me-3 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') start-0 end-auto @else end-0 @endif">
      @if ($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
        <div class="language pt-3 me-2">
          <ul class="text-decoration-none">
            <li class="dropdown1 dropdown lang-list">
              <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="false">
                {{ strtoupper(getLanguageIsoCode($vcard->default_language)) }}</a>
              <ul class="dropdown-menu start-0 lang-hover-list top-100 mt-0">
                @foreach (getAllLanguageWithFullData() as $language)
                  <li
                    class="{{ getLanguageIsoCode($vcard->default_language) == $language->iso_code ? 'active' : '' }}">
                    <a href="javascript:void(0)" id="languageName" data-name="{{ $language->iso_code }}">
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
                          <i class="fa fa-flag fa-xl me-3 text-danger" aria-hidden="true"></i>
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
    <!-- social-section -->
    <div class="social-section px-30px pb-30px">
      @if (checkFeature('social_links') && getSocialLinkIcon($vcard))
        <div class="d-flex gap-30 flex-wrap justify-content-center align-items-center mb-20px">
          @foreach (getSocialLinkIcon($vcard) as $social)
            <a href="{{ $social['url'] }}" target="_blank"
              class="text-decoration-none d-flex justify-content-center align-items-center social-box rounded-circle">
              {!! $social['icon'] !!}
            </a>
          @endforeach
        </div>
      @endif
      <div @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
        <p class="fs-14 fw-medium text-gray mb-0 text-center">{!! $vcard->description !!}</p>
      </div>
    </div>
    {{-- custom link section --}}
    <div class="custom-link-section">
      @if (checkFeature('custom-links'))
        <div class="custom-link d-flex flex-wrap justify-content-center pt-1 pb-30px w-100 ">
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
      @endif
    </div>
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
      <div class="personal-details bg-white position-relative" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
        <div class="position-absolute personal-vector-1">
          <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/personal-vector-1.png') }}" alt="images"
            class="w-100" />
        </div>
        <div class="position-absolute personal-vector-2 text-end">
          <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/personal-vector-2.png') }}" alt="images"
            class="w-100" />
        </div>
        <div class="row position-relative row-gap-3 row-gap-sm-0">
          @if ($vcard->email)
            <div class="col-sm-6">
              <a href="mailto:{{ $vcard->email }}" class="text-decoration-none">
                <div class="box-1 d-flex align-items-center gap-15">
                  <div class="icon1 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18"
                      fill="none">
                      <g clip-path="url(#clip0_5893_1974)">
                        <path
                          d="M11.0203 0.666245C13.7793 0.666245 16.5328 0.660688 19.2917 0.671803C19.6526 0.671803 20.019 0.710705 20.3687 0.788508C20.996 0.933001 21.429 1.33313 21.701 1.9111C21.9397 2.41683 21.862 2.6947 21.3957 2.98924C20.7906 3.3727 20.18 3.75061 19.5749 4.13407C16.9325 5.81796 14.29 7.49074 11.6587 9.18575C11.1813 9.49697 10.8038 9.48585 10.3264 9.18019C7.12333 7.11839 3.90359 5.08438 0.689394 3.03926C0.622778 2.9948 0.550612 2.9559 0.489548 2.91144C0.173124 2.6947 0.11206 2.52242 0.223086 2.16119C0.495099 1.272 1.17236 0.755164 2.16604 0.69959C2.56573 0.67736 2.96542 0.67736 3.35956 0.671803C5.91315 0.671803 8.46674 0.671803 11.0203 0.666245C11.0203 0.671803 11.0203 0.666245 11.0203 0.666245Z"
                          fill="#006769" />
                        <path
                          d="M10.9736 17.3333C8.17024 17.3333 5.37239 17.3389 2.56899 17.3278C2.21926 17.3278 1.85843 17.2889 1.5198 17.1944C0.836991 16.9999 0.415094 16.5164 0.209696 15.8439C0.104222 15.4938 0.165286 15.3216 0.481709 15.1215C3.06861 13.4932 5.65551 11.8648 8.24241 10.2365C8.51442 10.0642 8.80309 10.0642 9.0751 10.2254C9.56361 10.5144 10.041 10.8145 10.5184 11.1201C10.9126 11.3758 11.0791 11.3813 11.4622 11.1313C11.9673 10.8034 12.478 10.4866 12.9832 10.1587C13.2552 9.98088 13.4995 10.0365 13.7493 10.1976C14.5764 10.7311 15.4036 11.2591 16.2363 11.787C17.9349 12.8652 19.6392 13.9322 21.3379 15.0103C21.8597 15.3382 21.943 15.6105 21.6876 16.1607C21.3379 16.9054 20.705 17.2222 19.9334 17.3167C19.7391 17.3389 19.5448 17.3389 19.3505 17.3389C16.5582 17.3333 13.7659 17.3333 10.9736 17.3333Z"
                          fill="#006769" />
                        <path
                          d="M0.205078 13.4709C0.205078 10.4811 0.205078 7.54118 0.205078 4.5513C2.54772 6.04624 4.85706 7.5134 7.20525 9.00834C4.86261 10.5033 2.55327 11.976 0.205078 13.4709Z"
                          fill="#006769" />
                        <path
                          d="M14.8105 9.00834C17.1476 7.51896 19.457 6.04624 21.7996 4.5513C21.7996 7.53007 21.7996 10.4644 21.7996 13.4598C19.4625 11.976 17.1532 10.5033 14.8105 9.00834Z"
                          fill="#006769" />
                      </g>
                      <defs>
                        <clippath id="clip0_5893_1974">
                          <rect width="21.6667" height="16.6667" fill="white"
                            transform="translate(0.166016 0.666656)" />
                        </clippath>
                      </defs>
                    </svg>
                  </div>
                  <div class="box1-content fs-16 fw-medium lh-base text-black text-break">
                    {{ $vcard->email }}
                  </div>
                </div>
              </a>
            </div>
          @endif
          @if ($vcard->alternative_email)
            <div class="col-sm-6">
              <a href="mailto:{{ $vcard->alternative_email }}" class="text-decoration-none">
                <div class="box-1 d-flex align-items-center gap-15">
                  <div class="icon1 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18"
                      fill="none">
                      <g clip-path="url(#clip0_5893_1974)">
                        <path
                          d="M11.0203 0.666245C13.7793 0.666245 16.5328 0.660688 19.2917 0.671803C19.6526 0.671803 20.019 0.710705 20.3687 0.788508C20.996 0.933001 21.429 1.33313 21.701 1.9111C21.9397 2.41683 21.862 2.6947 21.3957 2.98924C20.7906 3.3727 20.18 3.75061 19.5749 4.13407C16.9325 5.81796 14.29 7.49074 11.6587 9.18575C11.1813 9.49697 10.8038 9.48585 10.3264 9.18019C7.12333 7.11839 3.90359 5.08438 0.689394 3.03926C0.622778 2.9948 0.550612 2.9559 0.489548 2.91144C0.173124 2.6947 0.11206 2.52242 0.223086 2.16119C0.495099 1.272 1.17236 0.755164 2.16604 0.69959C2.56573 0.67736 2.96542 0.67736 3.35956 0.671803C5.91315 0.671803 8.46674 0.671803 11.0203 0.666245C11.0203 0.671803 11.0203 0.666245 11.0203 0.666245Z"
                          fill="#006769" />
                        <path
                          d="M10.9736 17.3333C8.17024 17.3333 5.37239 17.3389 2.56899 17.3278C2.21926 17.3278 1.85843 17.2889 1.5198 17.1944C0.836991 16.9999 0.415094 16.5164 0.209696 15.8439C0.104222 15.4938 0.165286 15.3216 0.481709 15.1215C3.06861 13.4932 5.65551 11.8648 8.24241 10.2365C8.51442 10.0642 8.80309 10.0642 9.0751 10.2254C9.56361 10.5144 10.041 10.8145 10.5184 11.1201C10.9126 11.3758 11.0791 11.3813 11.4622 11.1313C11.9673 10.8034 12.478 10.4866 12.9832 10.1587C13.2552 9.98088 13.4995 10.0365 13.7493 10.1976C14.5764 10.7311 15.4036 11.2591 16.2363 11.787C17.9349 12.8652 19.6392 13.9322 21.3379 15.0103C21.8597 15.3382 21.943 15.6105 21.6876 16.1607C21.3379 16.9054 20.705 17.2222 19.9334 17.3167C19.7391 17.3389 19.5448 17.3389 19.3505 17.3389C16.5582 17.3333 13.7659 17.3333 10.9736 17.3333Z"
                          fill="#006769" />
                        <path
                          d="M0.205078 13.4709C0.205078 10.4811 0.205078 7.54118 0.205078 4.5513C2.54772 6.04624 4.85706 7.5134 7.20525 9.00834C4.86261 10.5033 2.55327 11.976 0.205078 13.4709Z"
                          fill="#006769" />
                        <path
                          d="M14.8105 9.00834C17.1476 7.51896 19.457 6.04624 21.7996 4.5513C21.7996 7.53007 21.7996 10.4644 21.7996 13.4598C19.4625 11.976 17.1532 10.5033 14.8105 9.00834Z"
                          fill="#006769" />
                      </g>
                      <defs>
                        <clippath id="clip0_5893_1974">
                          <rect width="21.6667" height="16.6667" fill="white"
                            transform="translate(0.166016 0.666656)" />
                        </clippath>
                      </defs>
                    </svg>
                  </div>
                  <div class="box1-content fs-16 fw-medium lh-base text-black text-break">
                    {{ $vcard->alternative_email }}
                  </div>
                </div>
              </a>
            </div>
          @endif
          @if ($vcard->phone)
            <div class="col-sm-6 mt-30px">
              <a href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}" class="text-decoration-none">
                <div class="box-1 d-flex align-items-center gap-15">
                  <div class="icon1 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                      fill="none">
                      <g clip-path="url(#clip0_5893_1968)">
                        <path
                          d="M4.54095 9.54438C6.32071 12.958 8.84849 15.5472 12.1888 17.3248C12.3306 17.4021 12.666 17.3119 12.8078 17.1831C13.5687 16.4617 14.3167 15.7275 15.039 14.9675C15.4388 14.5424 15.8773 14.478 16.4318 14.581C17.7473 14.8129 19.0757 15.0448 20.404 15.1994C21.4616 15.3282 21.8356 15.676 21.8356 16.758C21.8356 17.9174 21.8356 19.0638 21.8356 20.2231C21.8356 21.4726 21.4358 21.8591 20.159 21.8333C11.0796 21.6787 2.95464 15.238 0.81377 6.4013C0.439762 4.84264 0.323691 3.20669 0.181825 1.5965C0.0915477 0.643272 0.620317 0.179538 1.57468 0.179538C2.83857 0.166656 4.10246 0.166656 5.36635 0.166656C6.29492 0.166656 6.68183 0.591746 6.7979 1.51921C6.97845 2.88465 7.22349 4.25009 7.48143 5.60265C7.5846 6.18231 7.48143 6.64605 7.05583 7.05825C6.20464 7.88267 5.37925 8.70709 4.54095 9.54438Z"
                          fill="#006769" />
                      </g>
                      <defs>
                        <clippath id="clip0_5893_1968">
                          <rect width="21.6667" height="21.6667" fill="white"
                            transform="translate(0.166016 0.166656)" />
                        </clippath>
                      </defs>
                    </svg>
                  </div>
                  <div class="box1-content fs-16 fw-medium lh-base text-black">
                    +{{ $vcard->region_code }}{{ $vcard->phone }}
                  </div>
                </div>
              </a>
            </div>
          @endif
          @if ($vcard->alternative_phone)
            <div class="col-sm-6 mt-30px">
              <a href="tel:+{{ $vcard->region_code }}{{ $vcard->alternative_phone }}" class="text-decoration-none">
                <div class="box-1 d-flex align-items-center gap-15">
                  <div class="icon1 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                      fill="none">
                      <g clip-path="url(#clip0_5893_1968)">
                        <path
                          d="M4.54095 9.54438C6.32071 12.958 8.84849 15.5472 12.1888 17.3248C12.3306 17.4021 12.666 17.3119 12.8078 17.1831C13.5687 16.4617 14.3167 15.7275 15.039 14.9675C15.4388 14.5424 15.8773 14.478 16.4318 14.581C17.7473 14.8129 19.0757 15.0448 20.404 15.1994C21.4616 15.3282 21.8356 15.676 21.8356 16.758C21.8356 17.9174 21.8356 19.0638 21.8356 20.2231C21.8356 21.4726 21.4358 21.8591 20.159 21.8333C11.0796 21.6787 2.95464 15.238 0.81377 6.4013C0.439762 4.84264 0.323691 3.20669 0.181825 1.5965C0.0915477 0.643272 0.620317 0.179538 1.57468 0.179538C2.83857 0.166656 4.10246 0.166656 5.36635 0.166656C6.29492 0.166656 6.68183 0.591746 6.7979 1.51921C6.97845 2.88465 7.22349 4.25009 7.48143 5.60265C7.5846 6.18231 7.48143 6.64605 7.05583 7.05825C6.20464 7.88267 5.37925 8.70709 4.54095 9.54438Z"
                          fill="#006769" />
                      </g>
                      <defs>
                        <clippath id="clip0_5893_1968">
                          <rect width="21.6667" height="21.6667" fill="white"
                            transform="translate(0.166016 0.166656)" />
                        </clippath>
                      </defs>
                    </svg>
                  </div>
                  <div class="box1-content fs-16 fw-medium lh-base text-black">
                    +{{ $vcard->region_code }}{{ $vcard->alternative_phone }}
                  </div>
                </div>
              </a>
            </div>
          @endif
          @if ($vcard->dob)
            <div class="col-sm-6 mt-30px">
              <a href="#" class="text-decoration-none">
                <div class="box-1 d-flex align-items-center gap-15">
                  <div class="icon1 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="22" viewBox="0 0 26 22"
                      fill="none">
                      <g clip-path="url(#clip0_5893_1958)">
                        <path
                          d="M0.824791 21.8333C0.719793 21.6346 0.551797 21.4463 0.520297 21.237C0.467798 20.8604 0.520297 20.4733 0.499298 20.0967C0.488798 19.7514 0.635795 19.5736 0.992788 19.584C1.09779 19.584 1.20278 19.584 1.30778 19.584C9.10913 19.584 16.9 19.584 24.7013 19.5945C24.9638 19.5945 25.2263 19.6991 25.4888 19.7514C25.4888 20.4419 25.4888 21.1429 25.4888 21.8333C17.278 21.8333 9.04613 21.8333 0.824791 21.8333Z"
                          fill="#006769" />
                        <path
                          d="M13.0253 9.03838C15.8287 9.03838 18.6322 9.03838 21.4461 9.03838C23.0316 9.03838 23.8086 9.82302 23.8191 11.4132C23.8191 11.4342 23.8191 11.4446 23.8191 11.4655C24.0081 12.3862 23.5776 12.9093 22.7586 13.265C21.9291 13.6207 21.1311 13.6939 20.4066 13.0767C20.0497 12.7733 19.7557 12.4071 19.4617 12.041C19.0732 11.5702 18.7057 11.5597 18.3067 12.02C18.0442 12.3234 17.7817 12.6268 17.4877 12.8884C16.6582 13.6312 15.7447 13.7149 14.8103 13.1185C14.3903 12.8465 14.0123 12.5013 13.6448 12.156C13.1408 11.6852 12.9203 11.6852 12.4268 12.177C12.1433 12.4594 11.8493 12.7314 11.5238 12.9616C10.4213 13.7567 9.42387 13.7044 8.39489 12.8256C8.23739 12.6896 8.09039 12.5431 7.9539 12.3862C7.25041 11.5806 7.10341 11.5806 6.39993 12.4176C5.44445 13.5475 4.23697 13.7986 2.893 13.1918C2.36801 12.9511 2.16851 12.585 2.22101 12.041C2.25251 11.7794 2.28401 11.5179 2.25251 11.2668C2.07402 9.97995 3.11349 9.01745 4.45747 9.02792C7.30291 9.0593 10.1589 9.03838 13.0253 9.03838Z"
                          fill="#006769" />
                        <path
                          d="M23.6109 18.1717C16.5446 18.1717 9.50972 18.1717 2.44336 18.1717C2.44336 17.0732 2.44336 15.9747 2.44336 14.8343C4.19682 15.4202 5.72979 15.0435 6.98977 13.694C9.08973 15.7026 11.0217 15.4306 13.0481 13.6312C15.5576 15.8073 17.3636 15.3051 19.075 13.5998C19.6525 14.217 20.2825 14.782 21.1435 15.0017C21.994 15.2214 22.792 15.0435 23.6319 14.6878C23.6109 15.8596 23.6109 16.9895 23.6109 18.1717Z"
                          fill="#006769" />
                        <path
                          d="M11.5241 8.05495C11.5241 7.01922 11.5136 6.00442 11.5346 4.97915C11.5451 4.64437 11.7866 4.44559 12.1331 4.44559C12.7106 4.43513 13.2881 4.43513 13.8551 4.44559C14.2541 4.44559 14.485 4.67575 14.485 5.06284C14.506 6.04626 14.4955 7.04015 14.4955 8.05495C13.4981 8.05495 12.5321 8.05495 11.5241 8.05495Z"
                          fill="#006769" />
                        <path
                          d="M13.0162 0.166656C13.2682 0.626982 13.5621 1.15008 13.8456 1.68364C13.9716 1.92426 14.1396 2.16489 14.2131 2.42643C14.3706 3.00184 14.1186 3.62956 13.6671 3.88064C13.2157 4.13173 12.5227 4.0585 12.1552 3.72371C11.7667 3.35755 11.6407 2.6566 11.9137 2.14396C12.2707 1.45347 12.6592 0.783911 13.0162 0.166656Z"
                          fill="#006769" />
                      </g>
                      <defs>
                        <clippath id="clip0_5893_1958">
                          <rect width="25" height="21.6667" fill="white"
                            transform="translate(0.5 0.166656)" />
                        </clippath>
                      </defs>
                    </svg>
                  </div>
                  <div class="box1-content fs-16 fw-medium lh-base text-black">
                    {{ $vcard->dob }}
                  </div>
                </div>
              </a>
            </div>
          @endif
          @if ($vcard->location)
            <div class="col-sm-6 mt-30px">
              <a href="#" class="text-decoration-none">
                <div class="box-1 d-flex align-items-center gap-15">
                  <div class="icon1 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="26" viewBox="0 0 20 26"
                      fill="none">
                      <g clip-path="url(#clip0_5893_1951)">
                        <path
                          d="M9.61002 21.005C9.28803 20.6277 8.97867 20.2698 8.67563 19.9086C7.04044 17.9416 5.49364 15.9069 4.15519 13.7175C3.55226 12.734 3.02508 11.7118 2.57367 10.6444C1.74345 8.67424 1.8855 6.73628 2.80096 4.85959C3.98473 2.43472 5.92612 0.990119 8.55251 0.58705C12.5931 -0.0320655 16.4317 2.86359 17.0915 6.95555C17.3061 8.29697 17.1009 9.55455 16.5864 10.7863C16.0119 12.16 15.27 13.4369 14.4619 14.6719C13.0193 16.8711 11.4062 18.9316 9.68894 20.9114C9.66999 20.934 9.6479 20.9598 9.61002 21.005ZM13.4076 7.58757C13.4107 5.45291 11.7061 3.71487 9.61317 3.71487C7.51711 3.71487 5.81563 5.44968 5.81563 7.58434C5.81563 9.719 7.51711 11.457 9.61002 11.457C11.7029 11.457 13.4044 9.72545 13.4076 7.58757Z"
                          fill="#006769" />
                        <path
                          d="M6.65738 18.377C6.2912 18.4318 5.92818 18.4834 5.56831 18.5479C4.4824 18.7381 3.41858 19.0057 2.41474 19.4862C2.02331 19.6764 1.65081 19.8957 1.34461 20.215C0.852161 20.7309 0.852161 21.2597 1.35724 21.766C1.78655 22.1981 2.32004 22.4496 2.87247 22.6688C3.9426 23.088 5.06008 23.317 6.19334 23.4718C7.75592 23.6878 9.32797 23.7394 10.9032 23.662C12.6678 23.5749 14.4135 23.3492 16.096 22.7624C16.5948 22.5882 17.0809 22.3819 17.5102 22.0594C17.7028 21.9143 17.889 21.7466 18.0374 21.5564C18.3246 21.1888 18.3341 20.7792 18.0374 20.4213C17.8353 20.1763 17.586 19.9538 17.3208 19.7796C16.579 19.2927 15.7456 19.0154 14.8933 18.8155C14.1862 18.651 13.4696 18.5446 12.7562 18.4124C12.693 18.3995 12.6331 18.3899 12.5699 18.3802C12.6867 18.1287 12.7088 18.1222 12.9645 18.1416C14.0189 18.2254 15.0701 18.3415 16.1023 18.5769C16.6642 18.7026 17.2198 18.8542 17.728 19.1283C18.0468 19.2992 18.3625 19.4991 18.6245 19.7442C19.2969 20.3762 19.4169 21.2533 18.9875 22.0787C18.7571 22.5237 18.4193 22.8752 18.0342 23.1815C17.1945 23.849 16.238 24.2908 15.2342 24.6294C13.1224 25.342 10.9474 25.5774 8.73135 25.4807C7.02987 25.4033 5.36628 25.1227 3.75635 24.5359C2.76514 24.1747 1.82128 23.7233 1.01315 23.0139C0.659601 22.7043 0.359712 22.3432 0.170308 21.9014C-0.148521 21.1565 -0.00331158 20.3697 0.555429 19.7925C1.02262 19.3088 1.61293 19.0412 2.22849 18.8316C3.07134 18.5446 3.9426 18.3963 4.82017 18.2867C5.3063 18.2254 5.79244 18.1899 6.28173 18.1383C6.51848 18.1158 6.53742 18.1287 6.65738 18.377Z"
                          fill="#006769" />
                      </g>
                      <defs>
                        <clippath id="clip0_5893_1951">
                          <rect width="19.2308" height="25" fill="white" transform="translate(0 0.5)" />
                        </clippath>
                      </defs>
                    </svg>
                  </div>
                  <div class="box1-content fs-16 fw-medium lh-base text-black">
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
          <div class="gallery-section pb-60px position-relative  pt-60px">
            <div class="position-absolute vector-75 gallery-vector-1"
              @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
              <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/gallery-vector-1.png') }}" alt="images"
                class="w-100" />
            </div>
            <div class="position-absolute vector-75 gallery-vector-3"
              @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
              <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/gallery-vector-3.png') }}" alt="images"
                class="w-100" />
            </div>
            <div class="position-absolute vector-75 gallery-vector-2 text-end"
              @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
              <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/gallery-vector-2.png') }}" alt="images"
                class="w-100" />
            </div>
            <div class="position-absolute vector-75 gallery-vector-4 text-end"
              @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
              <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/gallery-vector-4.png') }}" alt="images"
                class="w-100" />
            </div>
            <div class="section-heading text-center mb-30px">
              <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                {{ __('messages.plan.gallery') }}</p>
            </div>
            <div class="gallery-slider">
              @foreach ($vcard->gallery as $file)
                @php
                  $infoPath = pathinfo(public_path($file->gallery_image));
                  $extension = $infoPath['extension'];
                @endphp
                <div>
                  <div class="gallery-box h-100 w-100 d-flex align-items-end mx-auto mx-sm-0 overflow-hidden">
                    <div class="gallery-img">
                      @if ($file->type == App\Models\Gallery::TYPE_IMAGE)
                        <a href="{{ $file->gallery_image }}" data-lightbox="gallery-images"><img
                            src="{{ $file->gallery_image }}" alt="profile" class="w-100 h-100 object-fit-contain"
                            loading="lazy" /></a>
                      @elseif($file->type == App\Models\Gallery::TYPE_FILE)
                        <a id="file_url" href="{{ $file->gallery_image }}" class="gallery-link gallery-file-link"
                          target="_blank" loading="lazy">
                          <div class="gallery-item gallery-file-item"
                            @if ($extension == 'pdf') style="background-image: url({{ asset('assets/images/pdf-icon.png') }})"> @endif
                            @if ($extension == 'xls') style="background-image: url({{ asset('assets/images/xls.png') }})"> @endif
                            @if ($extension == 'csv') style="background-image: url({{ asset('assets/images/csv-file.png') }})"> @endif
                            @if ($extension == 'xlsx') style="background-image: url({{ asset('assets/images/xlsx.png') }})"> @endif
                            </div>
                        </a>
                      @elseif($file->type == App\Models\Gallery::TYPE_VIDEO)
                        <video width="100%" height="100%" class="object-fit-contain" controls>
                          <source src="{{ $file->gallery_image }}">
                        </video>
                      @elseif($file->type == App\Models\Gallery::TYPE_AUDIO)
                        <div class="audio-container mt-2">
                          <img src="{{ asset('assets/img/music.jpeg') }}" alt="Album Cover" class="audio-image">
                          <audio controls src="{{ $file->gallery_image }}" class="audio-control">
                            Your browser does not support the <code>audio</code> element.
                          </audio>
                        </div>
                      @else
                        <iframe src="https://www.youtube.com/embed/{{ YoutubeID($file->link) }}" class="w-100"
                          height="315">
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
          <div class="service-section pb-60px position-relative">
            <div class="position-absolute vector-75 service-vector-1"
              @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
              <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/service-vector-1.png') }}" alt="images"
                class="w-100" />
            </div>
            <div class="position-absolute vector-75 service-vector-2 text-end"
              @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
              <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/service-vector-2.png') }}" alt="images"
                class="w-100" />
            </div>
            <div class="section-heading text-center mb-30px">
              <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                {{ __('messages.vcard.our_service') }}</p>
            </div>
            @if ($vcard->services_slider_view)
              <div class="service-slider">
                @foreach ($vcard->services as $service)
                  <div>
                    <div class="service-box bg-white w-100 mx-auto">
                      <div class="sevice-img h-100 w-100 mb-10px">
                        <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                          class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                          target="{{ $service->service_url ? '_blank' : '' }}">
                          <img src="{{ $service->service_icon }}" alt="branding" loading="lazy"
                            class="h-100 w-100 object-fit-cover" />
                        </a>
                      </div>
                      <div class="service-content" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                        <p class="mb-5px text-black">{{ ucwords($service->name) }}</p>
                        <h6
                          class="fs-12 mb-0 text-gray {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}">
                          {!! \Illuminate\Support\Str::limit($service->description, 170, '...') !!}
                        </h6>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <div class="row services-grid-view px-4">
                <div class="col-12 mb-4" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                  @foreach ($vcard->services as $service)
                    <div class="service-card card d-flex flex-row align-items-center mb-4">
                      <div class="card-img me-4">
                        <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                          class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                          target="{{ $service->service_url ? '_blank' : '' }}">
                          <img src="{{ $service->service_icon }}" alt="branding" loading="lazy"
                            class="h-100 w-100 object-fit-cover" />
                        </a>
                      </div>
                      <div class="card-body p-0 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') me-3 @endif">
                        <h3 class="card-title fs-18 text-black mb-1">
                          {{ ucwords($service->name) }}
                        </h3>
                        <p
                          class="mb-0 fs-14 text-gray-300 {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}">
                          {!! \Illuminate\Support\Str::limit($service->description, 170, '...') !!}
                        </p>
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
          <div class="appointment-section" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <div class="section-heading text-center mb-30px px-30px">
              <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
                {{ __('messages.make_appointments') }}</p>
            </div>
            <div class="appointment-bg position-relative appointment">
              <div class="overlay"></div>
              <div class="position-relative">
                <label class="fs-18 fw-semibold lh-12 text-white mb-10px">{{ __('messages.date') }}
                  :</label>
                <div class="input-group-date d-flex align-items-center position-relative bg-transparent mb-20px">
                  <input type="text" name="date"
                    class="date appoint-input appointment-input form-control p-0 fw-medium fs-14 lh-sm text-white bg-transparent border-0 rounded-0"
                    placeholder="{{ __('messages.form.pick_date') }}" id='pickUpDate' />
                  <div class="input-group-prepend">
                    <span class="input-group-text border-0 p-0 rounded-0 bg-transparent ms-1" id>
                      <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/calender.svg') }}" alt="image" />
                    </span>
                  </div>
                </div>
                <div class="mb-40px">
                  <label class="fs-18 fw-semibold lh-12 text-white mb-10px" id="hourSection"
                    style="display: none;">{{ __('messages.hour') }}:</label>
                  <div class="container px-sm-1 px-0">
                    <div class="row">
                      <div id="slotData" class="row">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button class="btn btn-primary fs-18 fw-semibold appointment-btn mx-auto appointmentAdd d-none">
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
        <div class="product-section px-30px position-relative pt-60px">
          <div class="position-absolute vector-75 product-vector-1"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/product-vector-1.png') }}" alt="images"
              class="w-100" />
          </div>
          <div class="position-absolute vector-75 product-vector-2"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/product-vector-2.png') }}" alt="images"
              class="w-100" />
          </div>
          <div class="section-heading text-center mb-30px px-30px">
            <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
              {{ __('messages.plan.products') }}</p>
          </div>
          <div class="product-slider">
            @foreach ($vcard->products as $product)
              <div>
                <div class="product-box w-100 mx-auto">
                  <a @if ($product->product_url) href="{{ $product->product_url }}" @endif target="_blank"
                    class="text-decoration-none fs-6 position-relative d-block h-100">
                    <div class="product-img h-100 w-100 mb-15px">
                      <img src="{{ $product->product_icon }}" alt="product"
                        class="h-100 w-100 object-fit-cover" />
                    </div>
                    <div class="product-content" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                      <div class="d-flex align-items-center gap-2 justify-content-between mb-2">
                        <p class="fs-18 fw-semibold text-black mb-0 w-75 product-name">
                          {{ $product->name }}
                        </p>

                        @if ($product->currency_id && $product->price)
                          <p class="fs-18 fw-semibold text-black mb-0">
                            {{ currencyFormat($product->price, 2, $product->currency->currency_code) }}
                          </p>
                        @elseif($product->price)
                          <p class="fs-18 fw-semibold text-black mb-0">
                            {{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}
                          </p>
                        @endif
                      </div>
                      <p class="text-gray fs-14 fw-medium mb-0 lh-12 product-desc">
                        {{ $product->description }}</p>
                    </div>
                  </a>
                </div>
              </div>
            @endforeach
          </div>
          <div class="me-5 mt-3 text-center view-more mb-5">
            <a class="fs-6 text text-decoration-underline product-view-more ms-5 text-teal-green"
              href="{{ $vcardProductUrl }}">{{ __('messages.analytics.view_more') }}</a>
          </div>
        </div>
      @endif
    @endif
    <!-- testimonial-section -->
    @if ((isset($managesection) && $managesection['testimonials']) || empty($managesection))
      @if (checkFeature('testimonials') && $vcard->testimonials->count())
        <div class="testimonial-section px-30px pt-60px position-relative">
          <div class="position-absolute vector-75 testimonial-vector-1 text-end"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
            <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/testimonial-vector.png') }}" alt="images"
              class="w-100" />
          </div>
          <div class="section-heading text-center mb-30px px-30px">
            <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
              {{ __('messages.plan.testimonials') }}</p>
          </div>
          <div class="testimonial-slider">
            @foreach ($vcard->testimonials as $testimonial)
              <div>
                <div class="testimonial-box bg-white">
                  <div class="d-block d-sm-flex gap-1 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') flex-row-reverse @endif">
                    <div class=" testimonial-box-img h-100 w-100 d-flex justify-content-center align-items-center">
                      <div class="position-relative testimonial-vector z-0">
                        <img src="{{ asset('/assets/img/oldVcardTemplate/vcard37/testimonial-vector-1.png') }}"
                          alt="images" class="w-100" />
                        <div class="testimonial-img position-absolute">
                          <img src="{{ $testimonial->image_url }}" alt="image"
                            class="h-100 w-100 object-fit-cover" />
                        </div>
                      </div>
                    </div>
                    <div class="ms-2">
                      <p
                        class="fs-14 text-gray fw-medium lh-base mb-20px text-center text-sm-start testiimonial-desc {{ \Illuminate\Support\Str::length($testimonial->description) > 80 ? 'more' : '' }} @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
                        {!! $testimonial->description !!}
                      </p>
                      <p
                        class="fs-18 fw-semibold mb-0 text-black-100 lh-12 text-center text-sm-start @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
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
        <div class="">
          <div class="section-heading text-center mb-30px px-30px mt-5 mb-5">
            <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
              {{ __('messages.feature.insta_embed') }}</p>
          </div>
          <nav>
            <div class="row insta-toggle">
              <div class="nav nav-tabs border-0 px-0" id="nav-tab" role="tablist">
                <button
                  class="d-flex align-items-center justify-content-center py-2 active postbtn instagram-btn  border-0  mr-0"
                  id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab"
                  aria-controls="nav-home" aria-selected="true">
                  <svg aria-label="Posts" class="svg-post-icon x1lliihq x1n2onr6 x173jzuc" fill="currentColor"
                    height="24" role="img" viewBox="0 0 24 24" width="24">
                    <title>Posts</title>
                    <rect fill="none" height="18" stroke="currentColor" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" width="18" x="3" y="3"></rect>
                    <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" x1="9.015" x2="9.015" y1="3" y2="21">
                    </line>
                    <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" x1="14.985" x2="14.985" y1="3" y2="21">
                    </line>
                    <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" x1="21" x2="3" y1="9.015" y2="9.015">
                    </line>
                    <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" x1="21" x2="3" y1="14.985" y2="14.985">
                    </line>
                  </svg>
                </button>
                <button
                  class="d-flex align-items-center justify-content-center py-2 instagram-btn reelsbtn  border-0 text-dark mr-0"
                  id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                  role="tab" aria-controls="nav-profile" aria-selected="false">
                  <svg class="svg-reels-icon" viewBox="0 0 48 48" width="27" height="27">
                    <path
                      d="m33,6H15c-.16,0-.31,0-.46.01-.7401.04-1.46.17-2.14.38-3.7,1.11-6.4,4.55-6.4,8.61v18c0,4.96,4.04,9,9,9h18c4.96,0,9-4.04,9-9V15c0-4.96-4.04-9-9-9Zm7,27c0,3.86-3.14,7-7,7H15c-3.86,0-7-3.14-7-7V15c0-3.37,2.39-6.19,5.57-6.85.46-.1.94-.15,1.43-.15h18c3.86,0,7,3.14,7,7v18Z"
                      fill="currentColor" class="color000 svgShape not-active-svg"></path>
                    <path
                      d="M21 16h-2.2l-.66-1-4.57-6.85-.76-1.15h2.39l.66 1 4.67 7 .3.45c.11.17.17.36.17.55zM34 16h-2.2l-.66-1-4.67-7-.66-1h2.39l.66 1 4.67 7 .3.45c.11.17.17.36.17.55z"
                      fill="currentColor" class="color000 svgShape not-active-svg"></path>
                    <rect width="36" height="3" x="6" y="15" fill="currentColor" class="color000 svgShape">
                    </rect>
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
        <div id="postContent" class="insta-feed">
          <div class="row overflow-hidden m-0 mt-2" loading="lazy">
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
          <div class="row overflow-hidden m-0 mt-2">
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
        <div class="pt-5">
          <div class="section-heading text-center mb-30px px-30px mt-5 mb-5">
            <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
              {{ __('messages.feature.linkedin_embed') }}</p>
          </div>

          <div class="linkedin-feed">
            <div class="row overflow-hidden m-0 mt-2" loading="lazy">
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
        <div class="blog-section px-30px pt-60px position-relative">
          <div class="position-absolute vector-75 blog-vector-1" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/blog-vector-1.png') }}" alt="images"
              class="w-100" />
          </div>
          <div class="position-absolute vector-75 blog-vector-2" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/blog-vector-2.png') }}" alt="images"
              class="w-100" />
          </div>
          <div class="section-heading text-center mb-30px px-30px">
            <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
              {{ __('messages.feature.blog') }}
            </p>
          </div>
          <div class="position-relative">
            <div
              class="align-tems-center gap-20 position-absolute arrow-slide-all d-none d-sm-flex start-0 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') end-0 start-auto justify-content-end @endif">
              <button class="prev arrow-slide d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"
                  fill="none">
                  <path
                    d="M5.32018 9.26017C5.15944 9.41373 4.94146 9.5 4.71417 9.5C4.48689 9.5 4.26891 9.41373 4.10816 9.26017L0.250963 5.57417C0.090271 5.42056 0 5.21225 0 4.99505C0 4.77786 0.090271 4.56955 0.250963 4.41594L4.10816 0.729935C4.26983 0.580727 4.48635 0.498165 4.71109 0.500031C4.93583 0.501898 5.15082 0.588042 5.30974 0.739912C5.46867 0.891783 5.55881 1.09723 5.56076 1.312C5.56272 1.52676 5.47632 1.73367 5.32018 1.88816L2.99986 4.17594L11.1428 4.17594C11.3702 4.17594 11.5882 4.26224 11.7489 4.41585C11.9097 4.56947 12 4.77781 12 4.99505C12 5.2123 11.9097 5.42064 11.7489 5.57425C11.5882 5.72787 11.3702 5.81417 11.1428 5.81417L2.99986 5.81417L5.32018 8.10195C5.48088 8.25556 5.57115 8.46386 5.57115 8.68106C5.57115 8.89826 5.48088 9.10657 5.32018 9.26017Z"
                    fill="currentColor" />
                </svg>
              </button>
              <button class="next arrow-slide d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"
                  fill="none">
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
                  <div
                    class="blog-box row align-items-center m-0 flex-column-reverse flex-sm-row @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') flex-sm-row-reverse @endif">
                    <div class="col-sm-6 p-0">
                      <div class="blog-content w-100 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') ms-auto @endif">
                        <p
                          class="blog-title fs-20 fw-semibold text-black mb-15px text-center text-sm-start @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
                          {{ $blog->title }}</p>
                        <p
                          class="blog-desc fs-14 fw-medium text-black mb-15px text-center text-sm-start @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @endif">
                          {{ Illuminate\Support\Str::words(strip_tags($blog->description), 100, '...') }}
                        </p>
                      </div>
                    </div>
                    <div class="col-sm-6 p-0 mb-2 mb-sm-0">
                      <div class="blog-img-box mx-auto">
                        <div class="blog-img position-relative w-100 h-100 mx-auto">
                          <a href="{{ $vcardBlogUrl }}">
                            <img src="{{ $blog->blog_icon }}" alt="images"
                              class="h-100 w-100 object-fit-cover" />
                          </a>
                        </div>
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
        <div class="business-section px-30px pt-60px position-relative"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div class="position-absolute vector-75 business-vector text-end"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/business-vector.png') }}" alt="images"
              class="w-100" />
          </div>
          <div class="section-heading text-center mb-30px px-30px">
            <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
              {{ __('messages.business.business_hours') }}</p>
          </div>
          <div class="business-box row">
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
              <div class="col-sm-6 mb-25px pe-sm-2">
                <div class="business-hour">
                  <span
                    class="fs-15 fw-semibold text-black mb-25px text-center texts-sm-start">{{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) . ' ' }}:</span>
                  <span
                    class="fs-15 fw-semibold text-black mb-25px text-center texts-sm-start">{{ $dayTime ?? __('messages.common.closed') }}</span>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @endif
    <!-- qr-section -->
    @if (isset($vcard['show_qr_code']) && $vcard['show_qr_code'] == 1)
      <div class="qr-section pt-60px position-relative">
        <div class="position-absolute vector-75 qr-vector" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/qr-vector.png') }}" alt="images"
            class="w-100" />
        </div>
        <div class="position-absolute vector-75 qr-vector-1 text-end"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/qr-vector-1.png') }}" alt="images"
            class="w-100" />
        </div>
        <div class="position-absolute vector-75 qr-vector-2 text-end"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/qr-vector-2.png') }}" alt="images"
            class="w-100" />
        </div>
        <div class="section-heading text-center mb-30px px-30px">
          <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
            {{ __('messages.vcard.qr_code') }}</p>
        </div>
        <div class="qr-bg">
          <div
            class="qr-code-section w-100 mx-auto  me-sm-0 text-center  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') ms-sm-0 me-sm-auto @else ms-sm-auto @endif">
            <div class="qr-img bg-white mx-auto h-100 w-100 mb-30px" id="qr-code-thirtyseven">
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
        </div>
      </div>
    @endif

    {{-- iframe --}}
    @if ((isset($managesection) && $managesection['iframe']) || empty($managesection))
      @if (checkFeature('iframes') && $vcard->iframes->count())
        <div class="blog-section pt-40 mb-3">
          <div class="section-heading text-center mb-30px px-30px">
            <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
              {{ __('messages.vcard.iframe') }}</p>
          </div>
          <div class="iframe-slider">
            @foreach ($vcard->iframes as $iframe)
              <div class="slide p-3">
                <div class="iframe-card">
                  <div class="overlay">
                    <iframe src="{{ $iframe->url }}" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowfullscreen width="100%" height="350">
                    </iframe>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @endif
    @php
      $currentSubs = $vcard->subscriptions()->where('status', \App\Models\Subscription::ACTIVE)->latest()->first();
    @endphp
    <!-- contact-us-section -->
    @if ($currentSubs && $currentSubs->plan->planFeature->enquiry_form && $vcard->enable_enquiry_form)
      <div class="contact-us-section px-30px pt-60px position-relative"
        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
        <div class="position-absolute vector-75 contact-vector-1"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
          <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/contact-vector-1.png') }}" alt="images"
            class="w-100" />
        </div>
        <div class="position-absolute vector-75 contact-vector-2 text-end"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
          <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/contact-vector-2.png') }}" alt="images"
            class="w-100" />
        </div>
        <div class="section-heading text-center mb-30px">
          <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
            {{ __('messages.contact_us.inquries') }}</p>
        </div>
        <form action="" id="enquiryForm" enctype="multipart/form-data">
          @csrf
          <div id="enquiryError" class="alert alert-danger d-none"></div>
          <div class="mb-15px">
            <input type="text" class="form-control text-gray fs-16 fw-semibold border-0" name="name"
              placeholder="{{ __('messages.form.your_name') }}" />
          </div>
          <div class="mb-15px">
            <input type="email" class="form-control text-gray fs-16 fw-semibold border-0" name="email"
              placeholder="{{ __('messages.form.your_email') }}" />
          </div>
          <div class="mb-15px">
            <input type="tel"
              class="form-control text-gray fs-16 fw-semibold border-0  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-end @endif"
              name="phone" placeholder="{{ __('messages.form.phone') }}"
              onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,&quot;&quot;)" />
          </div>
          <div class="mb-15px">
            <textarea class="form-control text-gray fs-16 fw-semibold border-0" name="message"
              placeholder="{{ __('messages.form.type_message') }}" rows="3"></textarea>
          </div>
          @if (isset($inquiry) && $inquiry == 1)
            <div class="mb-3">
              <div class="wrapper-file-input">
                <div class="input-box" id="fileInputTrigger">
                  <h4> <i class="fa-solid fa-upload mx-2"></i>{{ __('messages.choose_file') }}
                  </h4> <input type="file" id="attachment" name="attachment" hidden multiple />
                </div> <small>{{ __('messages.file_supported') }}</small>
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
              <input type="checkbox" name="terms_condition" class="form-check-input terms-condition"
                id="termConditionCheckbox" placeholder>&nbsp;
              <label class="form-check-label" for="privacyPolicyCheckbox">
                <span class="text-black">{{ __('messages.vcard.agree_to_our') }}</span>
                <a href="{{ $vcardPrivacyAndTerm }}" target="_blank"
                  class="text-decoration-none link-info fs-6">{!! __('messages.vcard.term_and_condition') !!}</a>
                <span class="text-black">&</span>
                <a href="{{ $vcardPrivacyAndTerm }}" target="_blank"
                  class="text-decoration-none link-info fs-6">{{ __('messages.vcard.privacy_policy') }}</a>
              </label>
            </div>
          @endif
          <div class="text-center">
            <button class="contact-btn fs-16 fw-semibold send-btn btn btn-primary lh-11"
              type="submit">{{ __('messages.contact_us.send_message') }}</button>
          </div>
        </form>
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
                <div class="mb-1 mt-3 d-flex gap-1 justify-content-center align-items-center email-input">
                  <div class="w-100">
                    <input type="email" class="form-control email-input w-100"
                      placeholder="{{ __('messages.form.enter_your_email') }}" aria-label="Email" name="email"
                      id="emailSubscription" aria-describedby="button-addon2">
                  </div>
                  <button class="btn ms-1" type="submit" id="email-send">{{ __('messages.subscribe') }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endif
    <!-- Create Your vCard -->
    @if ($currentSubs && $currentSubs->plan->planFeature->affiliation && $vcard->enable_affiliation)
      <div class="z-1 your-vcard-section px-30px pt-60px position-relative mb-4">
        <div class="position-absolute vector-75 your-vcard-vector-1"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
          <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/your-vcrad-vector-1.png') }}" alt="images"
            class="w-100" />
        </div>
        <div class="position-absolute vector-75 your-vcard-vector-2"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
          <img src="{{ asset('assets/img/oldVcardTemplate/vcard37/your-vcrad-vector-2.png') }}" alt="images"
            class="w-100" />
        </div>
        <div class="section-heading text-center mb-30px">
          <p class="text-teal-green text-center fs-26 fw-bold d-inline-block position-relative mb-0 lh-normal">
            {{ __('messages.create_vcard') }}</p>
        </div>
        <div class="your-vacrd-bg position-relative" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
          <div
            class="input-group v-card-input bg-transparent w-100 d-flex justify-content-center gap-20 align-items-center flex-nowrap position-relative mx-auto z-1">
            <a class="text-black fs-16 lh-base text-wrap fw-semibold text-decoration-none"
              href="{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}">
              {{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}
            </a>
            <div class="input-group-append">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                fill="none">
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
        <div class="m-2 mt-5">
          <iframe width="100%" height="300px"
            src='https://maps.google.de/maps?q={{ $url[5] }}/&output=embed' frameborder="0" scrolling="no"
            marginheight="0" marginwidth="0" style="border-radius: 10px;"></iframe>
        </div>
      @endif
      @if ($vcard->location_type == 1 && !empty($vcard->location_embed_tag))
        <div class="m-2 mt-0">
          <div class="embed-responsive embed-responsive-16by9 rounded overflow-hidden" style="height: 300px;">
            {!! $vcard->location_embed_tag ?? '' !!}
          </div>
        </div>
      @endif
    @endif
    <!-- add-section -->
    @if ($vcard->enable_contact)
      <div class="add-section">
        <div class="addcard text-center">
          @if ($contactRequest == 1)
            <a href="{{ Auth::check() ? route('add-contact', $vcard->id) : 'javascript:void(0);' }}"
              class="z-2 btn btn-primary text-white fw-semibold fs-16 lh-base add-btn position-fixed start-0 end-0 mx-auto add-contact-btn {{ Auth::check() ? 'auth-contact-btn' : 'ask-contact-detail-form' }}"
              data-action="{{ Auth::check() ? route('contact-request.store') : 'show-modal' }}" type="submit"><i
                class="fas fa-download fa-address-book"></i>
              &nbsp;{{ __('messages.setting.add_contact') }}</a>
          @else
            <a href="{{ route('add-contact', $vcard->id) }}"
              class="z-2 btn btn-primary text-white fw-semibold fs-16 lh-base add-btn position-fixed start-0 end-0 mx-auto"
              type="submit"><i class="fas fa-download fa-address-book"></i>
              &nbsp;{{ __('messages.setting.add_contact') }}</a>
          @endif
        </div>
      </div>
      @include('vcardTemplates.contact-request')
    @endif
    {{-- made by --}}
    <div class="d-flex justify-content-evenly position-absolute z-3 w-100 bottom-0"
      @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir='rtl' @endif>
      @if (checkFeature('advanced'))
        @if (checkFeature('advanced')->hide_branding && $vcard->branding == 0)
          @if ($vcard->made_by)
            <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
              class="text-center text-decoration-none text-white" target="_blank">
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
          <a class="text-decoration-none text-white cursor-pointer terms-policies-btn"
            href="{{ $vcardPrivacyAndTerm }}"><small class="text-black">{!! __('messages.vcard.term_policy') !!}</small></a>
        </div>
      @endif
    </div>

    {{-- sticky buttons --}}
    <div class="btn-section cursor-pointer @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
      <div class="fixed-btn-section">
        <div class="bars-btn flower-garden-bars-btn @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') vcard-bars-btn-left @endif">
          {{-- <img src="{{ asset('assets/img/oldVcardTemplate/vcard30/sticky.png') }}" /> --}}
          <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                <input type="number" class="search-input" id="wpNumber" data-ic-class="search-input"
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
                <button type="button" class="vcard37-btn-group vcard37-share vcard37-sticky-btn mb-3 px-2 py-1"><i
                    class="fas fa-share-alt fs-4 pt-1"></i></button>
                @if (!empty($vcard->enable_download_qr_code))
                  <a type="button"
                    class="vcard37-btn-group vcard37-sticky-btn d-flex justify-content-center  align-items-center  px-2 mb-3 py-2"
                    id="qr-code-btn" download="qr_code.png"><i class="fa-solid fa-qrcode fs-4 text-primary"></i></a>
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
                  class="btn btn-sm btn-icon btn-active-color-danger border-none p-0" data-bs-dismiss="modal">
                  <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                      version="1.1">
                      <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                        fill="#000000">
                        <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
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
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
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
                      viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
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
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
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
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
                      <path
                        d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                    </g>
                  </svg>
                </div>
              </div>
            </a>
            <a href="mailto:?Subject=&Body={{ $shareUrl }}" target="_blank" class="text-decoration-none share"
              title="Email">
              <div class="row">
                <div class="col-2">
                  <i class="fas fa-envelope fa-2x" style="color: #191a19  "></i>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_email') }}</p>
                </div>
                <div class="col-1 p-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
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
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
                      <path
                        d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                    </g>
                  </svg>
                </div>
              </div>
            </a>
            <a href="http://reddit.com/submit?url={{ $shareUrl }}&title={{ $vcard->name }}" target="_blank"
              class="text-decoration-none share" title="Reddit">
              <div class="row">
                <div class="col-2">
                  <i class="fab fa-reddit fa-2x" style="color: #ff4500"></i>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_reddit') }}</p>
                </div>
                <div class="col-1 p-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
                      <path
                        d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                    </g>
                  </svg>
                </div>
              </div>
            </a>
            <a href="https://wa.me/?text={{ $shareUrl }}" target="_blank" class="text-decoration-none share"
              title="Whatsapp">
              <div class="row">
                <div class="col-2">
                  <i class="fab fa-whatsapp fa-2x" style="color: limegreen"></i>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_whatsapp') }}</p>
                </div>
                <div class="col-1 p-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
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
                  <svg width="30px" height="30px" viewBox="147.353 39.286 514.631 514.631" version="1.1"
                    id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    xml:space="preserve" fill="#000000">
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
                      <rect x="147.553" y="39.443" style="fill:none;" width="514.231" height="514.23"></rect>
                    </g>
                  </svg>
                </div>
                <div class="col-9 p-1">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_snapchat') }}</p>
                </div>
                <div class="col-1 p-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0" height="16px"
                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                      stroke="none">
                      <path
                        d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                    </g>
                  </svg>
                </div>
              </div>
            </a>
            <div class="col-12 justify-content-between social-link-modal">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="{{ request()->fullUrl() }}" disabled>
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
      dots: false,
      responsive: [{
        breakpoint: 575,
        settings: {
          dots: true
        },
      }, ],
    });
    $(".gallery-slider").slick({
      dots: true,
      centerMode: true,
      centerPadding: "160px",
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
    $(".service-slider").slick({
      dots: true,
      centerMode: true,
      centerPadding: "164px",
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
          dots: true
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
  <script src="{{ asset('messages.js') }}"></script>
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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const dateInput = document.getElementById('pickUpDate');
      const hourSection = document.getElementById('hourSection');
      dateInput.addEventListener('change', function() {
        if (this.value) {
          hourSection.style.display = 'block';
        } else {
          hourSection.style.display = 'none';
        }
      });
    });
  </script>
</body>

</html>
