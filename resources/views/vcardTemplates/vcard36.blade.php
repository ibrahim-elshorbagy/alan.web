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
    <meta name="description" content="{{ $vcard->description }}">
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
  {{-- <title>Real Estate</title> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Bootstrap CSS -->
  <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="icon" href="{{ getVcardFavicon($vcard) }}" type="image/png">
  <link rel="stylesheet" type="text/css" href="{{ asset('front/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slider/css/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/new_vcard/slick-theme.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/new_vcard/custom.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-vcard.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lightbox.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vcard36.css') }}">
  {{-- google Font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
          em { 
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
  <div class="position-fixed top-0 start-0 w-100 h-100 vcard-thirtysix-effect">
    <div class="bg-effect-vcard36-1">
    </div>
  </div>
  <div class="container p-0">
    @if (checkFeature('password'))
      @include('vcards.password')
    @endif
    <div
      class="main-content mx-auto w-100 position-relative overflow-hidden bg-white @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
      <div class="banner-section position-relative @if ($vcard->cover_type == 2) banner-yt-section @endif">
        <div class="banner-img @if ($vcard->cover_type == 2) h-auto @endif">
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
          @endif
        </div>
        @if ($vcard->cover_type == 2)
          <div class="youtube-link-36">
            <iframe
              src="https://www.youtube.com/embed/{{ YoutubeID($vcard->youtube_link) }}?autoplay=1&mute=0&loop=1&playlist={{ YoutubeID($vcard->youtube_link) }}&controls=0&modestbranding=1&showinfo=0&rel=0"
              class="cover-video {{ $coverClass }}" frameborder="0" allow="autoplay; encrypted-media"
              allowfullscreen>
            </iframe>
          </div>
        @endif
      </div>
      {{-- Pwa support --}}
      @if (isset($enable_pwa) && $enable_pwa == 1)
        <div class="mt-0">
          <div class="pwa-support d-flex align-items-center justify-content-center"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <div>
              <h1 class="pwa-heading">{{ __('messages.pwa.add_to_home_screen') }}</h1>
              <p class="pwa-text text-primary">{{ __('messages.pwa.pwa_description') }} </p>
              <div class="text-end d-flex gap-2 align-items-center">
                <button id="installPwaBtn" class="pwa-install-button w-50 mb-1 btn">{{ __('messages.pwa.install') }}
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
            <div class="support-banner banner-modal-section w-100 overflow-hidden">

              <button type="button" class="border-0 bg-transparent text-start banner-close"><i
                  class="fa-solid fa-xmark"></i></button>
              <div class="">
                <h1 class="text-center support_heading">{{ $banners->title }}</h1>
                <p class="text-center support_text text-primary">{{ $banners->description }} </p>
                <div class="text-center">
                  <a href="{{ $banners->url }}" class="act-now btn btn-secondary" target="_blank"
                    data-turbo="false">{{ $banners->banner_button }} </a>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endif
      {{-- language --}}
      <div
        class="d-flex justify-content-end position-absolute top-0  mx-3 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') start-0 end-auto @else end-0 @endif">
        @if ($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
          <div class="language pt-3 lang-button">
            <ul class="text-decoration-none ps-0">
              <li class="dropdown1 dropdown lang-list">
                <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown" role="button"
                  aria-haspopup="true" aria-expanded="false">
                  {{ strtoupper(getLanguageIsoCode($vcard->default_language)) }}</a>
                <ul class="dropdown-menu lang-hover-list top-100 mt-0">
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
      {{-- profile section --}}
      <div class="profile-section @if ($vcard->cover_type == 2)  @endif"
        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
        <div class=" position-relative">
          <div
            class="position-absolute top-0 profile-img-2 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') start-0 @else end-0 @endif">
            <img src="{{ asset('assets/img/vcard36/vcard36-profile-img-1.png') }}" class="w-100" />
          </div>
          <div class="card d-flex flex-sm-row align-items-center pt-3 px-30 gap-3 gap-sm-4">
            <div class="card-img">
              <img src="{{ $vcard->profile_url }}" class="object-fit-cover" />
            </div>
            <div
              class="card-body p-0 text-center @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @else text-sm-start @endif">
              <div class="profile-name mb-0">
                <h2 class="text-secondary mb-0 fw-5 fs-24">
                  {{ ucwords($vcard->first_name . ' ' . $vcard->last_name) }}
                  @if ($vcard->is_verified)
                    <i class="verification-icon bi-patch-check-fill text-primary"></i>
                  @endif
                </h2>
                <p class="text-primary text-decoration-underline mb-1 fw-5 fs-16">{{ ucwords($vcard->company) }}</p>
                <p class="text-gray-200 mb-0 fw-5 fs-14">{{ ucwords($vcard->occupation) }}</p>
                <p class="text-gray-200 mb-0 fw-5 fs-14">{{ ucwords($vcard->job_title) }}</p>

              </div>
            </div>
          </div>
        </div>
        <div class=" fs-14 text-center pt-3 px-30 profile-desc" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <p class="text-primary  mb-0">
            {!! $vcard->description !!}
          </p>
        </div>
        {{-- social-media --}}
        @if (checkFeature('social_links') && getSocialLink($vcard))
          <div class="social-media-section pt-40 px-30 position-relative"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>

            <div class="d-flex flex-wrap justify-content-center gap-2 gap-sm-3">
              @foreach (getSocialLink($vcard) as $value)
                <span class="social-icon d-flex justify-content-center align-items-center">
                  {!! $value !!}
                </span>
              @endforeach
            </div>

          </div>
        @endif
      </div>
      {{-- custom link section --}}

      @if (checkFeature('custom-links') && $customLink->isNotEmpty())
        <div class="custom-link-section">
          <div class="custom-link d-flex flex-wrap justify-content-center pt-40 w-100 gap-3">
            @foreach ($customLink as $value)
              @if ($value->show_as_button == 1)
                <a href="{{ $value->link }}" @if ($value->open_new_tab == 1) target="_blank" @endif
                  style="
                        @if ($value->button_color) background-color: {{ $value->button_color }}; @endif
                        @if ($value->button_type === 'rounded') border-radius: 20px; @endif
                        @if ($value->button_type === 'square') border-radius: 0px; @endif"
                  class="d-flex justify-content-center align-items-center text-decoration-none link-text
                        font-primary btn">
                  {{ $value->link_name }}
                </a>
              @else
                <a href="{{ $value->link }}" @if ($value->open_new_tab == 1) target="_blank" @endif
                  class="d-flex justify-content-center align-items-center text-decoration-none link-text
                        text-primary">
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
          <div class="contact-section pt-50 px-30 position-relative"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <div class="position-absolute vector-all vector-2 text-end">
              <img src="{{ asset('assets/img/vcard36/vector-bg-1.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="position-absolute vector-all shape-1">
              <img src="{{ asset('assets/img/vcard36/shape-2-vcard36.png') }}"
                class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="section-heading">
              <h2 class="left-bg">{{ __('messages.dynamic_vcard.contact') }}</h2>
            </div>
            <div class="row row-gap-20px">
              @if ($vcard->email)
                <div class="col-sm-6">
                  <div class="contact-box">
                    <div class="contact-icon d-flex justify-content-center align-items-center">
                      <img src="{{ asset('assets/img/vcard36/email.svg') }}" />
                    </div>
                    <div class="contact-desc text-center">
                      <a href="mailto:{{ $vcard->email }}">{{ $vcard->email }}</a>
                    </div>
                  </div>
                </div>
              @endif
              @if ($vcard->alternative_email)
                <div class="col-sm-6">
                  <div class="contact-box">
                    <div class="contact-icon d-flex justify-content-center align-items-center">
                      <img src="{{ asset('assets/img/vcard36/email.svg') }}" />
                    </div>
                    <div class="contact-desc text-center">
                      <a href="mailto:{{ $vcard->alternative_email }}">{{ $vcard->alternative_email }}</a>
                    </div>
                  </div>
                </div>
              @endif
              @if ($vcard->phone)
                <div class="col-sm-6">
                  <div class="contact-box">
                    <div class="contact-icon d-flex justify-content-center align-items-center">
                      <img src="{{ asset('assets/img/vcard36/phone.svg') }}" />
                    </div>
                    <div class="contact-desc text-center">
                      <a
                        href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}">+{{ $vcard->region_code }}{{ $vcard->phone }}</a>
                    </div>
                  </div>
                </div>
              @endif
              @if ($vcard->alternative_phone)
                <div class="col-sm-6">
                  <div class="contact-box">
                    <div class="contact-icon d-flex justify-content-center align-items-center">
                      <img src="{{ asset('assets/img/vcard36/phone.svg') }}" />
                    </div>
                    <div class="contact-desc text-center">
                      <a
                        href="tel:+{{ $vcard->alternative_region_code }}{{ $vcard->alternative_phone }}">+{{ $vcard->alternative_region_code }}{{ $vcard->alternative_phone }}</a>
                    </div>
                  </div>
                </div>
              @endif
              @if ($vcard->dob)
                <div class="col-sm-6">
                  <div class="contact-box">
                    <div class="contact-icon d-flex justify-content-center align-items-center">
                      <img src="{{ asset('assets/img/vcard36/dob.svg') }}" />
                    </div>
                    <div class="contact-desc text-center">
                      <p class="mb-0">{{ $vcard->dob }}</p>
                    </div>
                  </div>
                </div>
              @endif
              @if ($vcard->location)
                <div class="col-sm-6">
                  <div class="contact-box">
                    <div class="contact-icon d-flex justify-content-center align-items-center">
                      <img src="{{ asset('assets/img/vcard36/location.svg') }}" />
                    </div>
                    <div class="contact-desc text-center">
                      <p class="mb-0">{!! ucwords($vcard->location) !!}</p>
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>
        @endif
      @endif
      {{-- gallery --}}
      @if ((isset($managesection) && $managesection['galleries']) || empty($managesection))
        @if (checkFeature('gallery') && $vcard->gallery->count())
          <div class="gallery-section pt-50 px-20 position-relative">
            <div class="position-absolute vector-all vector-3">
              <img src="{{ asset('assets/img/vcard36/vector-bg-3.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="position-absolute vector-all shape-4 text-end">
              <img src="{{ asset('assets/img/vcard36/cloude-1-vcard36.png') }}" class="w-100" />
            </div>
            <div class="position-absolute vector-all vector-3 text-en">
              <img src="{{ asset('assets/img/vcard36/vector-bg-3.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="section-heading">
              <h2 class="right-bg">{{ __('messages.plan.gallery') }}</h2>
            </div>
            <div class="gallery-main-box mx-auto">
              <div class="gallery-slider">
                @foreach ($vcard->gallery as $file)
                  @php
                    $infoPath = pathinfo(public_path($file->gallery_image));
                    $extension = $infoPath['extension'];
                  @endphp
                  <div>
                    <div class="gallery-img">
                      <div class="expand-icon pe-none">
                        <i class="fas fa-expand text-white"></i>
                      </div>
                      @if ($file->type == App\Models\Gallery::TYPE_IMAGE)
                        <a href="{{ $file->gallery_image }}" data-lightbox="gallery-images"><img
                            src="{{ $file->gallery_image }}" alt="profile" class="w-100 h-100 object-fit-cover"
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
                        <video width="100%" height="100%" class="object-fit-cover" controls>
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
                @endforeach
              </div>
            </div>
          </div>
        @endif
      @endif
      {{-- our service --}}
      @if ((isset($managesection) && $managesection['services']) || empty($managesection))
        @if (checkFeature('services') && $vcard->services->count())
          <div class="our-services-section pt-50 px-20 position-relative">
            <div class="position-absolute vector-all vector-4 text-end">
              <img src="{{ asset('assets/img/vcard36/vector-bg-4.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="position-absolute vector-all shape-5">
              <img src="{{ asset('assets/img/vcard36/vcard36-section-heading-bg.png') }}"
                class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="section-heading">
              <h2 class="left-bg">{{ __('messages.vcard.our_service') }}</h2>
            </div>
            @if ($vcard->services_slider_view)
              <div class="services-slider-view">
                <div class="service-slider">
                  @foreach ($vcard->services as $service)
                    <div class="service-card">
                      <div class="card-img">
                        <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                          class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                          target="{{ $service->service_url ? '_blank' : '' }}">
                          <img src="{{ $service->service_icon }}" alt="branding" loading="lazy"
                            class="h-100 w-100 object-fit-cover" />
                        </a>
                      </div>
                      <div class="card-body w-100 text-center">
                        <h3 class="card-title text-secondary mb-1 text-center"
                          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                          {{ ucwords($service->name) }}
                        </h3>
                        <p class="mb-0 text-gray-300 description-text text-center {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}"
                          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                          {!! \Illuminate\Support\Str::limit($service->description, 170, '...') !!}
                        </p>
                        {{-- <p class="text-primary fs-20 mb-0 fw-5 text-end">$200</p> --}}
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @else
              <div class="px-2">
                <div class="row row-gap-20px">

                  @foreach ($vcard->services as $service)
                    <div class="col-sm-6" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                      <div class="service-card card h-100">
                        <div class="card-img">
                          <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                            class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                            target="{{ $service->service_url ? '_blank' : '' }}">
                            <img src="{{ $service->service_icon }}" alt="branding" loading="lazy"
                              class="h-100 w-100 object-fit-cover" />
                          </a>
                        </div>
                        <div class="card-body w-100 text-center">
                          <h3 class="card-title text-secondary mb-2"
                            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                            {{ ucwords($service->name) }}
                          </h3>
                          <p class="mb-0 text-gray-300 description-text {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}"
                            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
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
      {{-- make appointment --}}
      @if ((isset($managesection) && $managesection['appointments']) || empty($managesection))
        @if (checkFeature('appointments') && $vcard->appointmentHours->count())
          <div class="appointment-section pt-50 px-30 position-relative"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <div class="position-absolute vector-all vector-5">
              <img src="{{ asset('assets/img/vcard36/vector-bg-5.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="section-heading">
              <h2 class="right-bg">{{ __('messages.make_appointments') }}</h2>
            </div>
            <div class="appointment px-30 pt-40 pb-40">
              <div class="position-relative">
                <div class="row">
                  <div class="col-12">
                    {{ Form::text('date', null, [
                        'class' => 'date appoint-input form-control appointment-input',
                        'placeholder' => __('messages.form.pick_date'),
                        'id' => 'pickUpDate',
                    ]) }}
                    <span class="calendar-icon" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                      <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_102_145)">
                          <path
                            d="M14.25 1.5H13.5V0.75C13.5 0.551088 13.421 0.360322 13.2803 0.21967C13.1397 0.0790176 12.9489 0 12.75 0C12.5511 0 12.3603 0.0790176 12.2197 0.21967C12.079 0.360322 12 0.551088 12 0.75V1.5H6V0.75C6 0.551088 5.92098 0.360322 5.78033 0.21967C5.63968 0.0790176 5.44891 0 5.25 0C5.05109 0 4.86032 0.0790176 4.71967 0.21967C4.57902 0.360322 4.5 0.551088 4.5 0.75V1.5H3.75C2.7558 1.50119 1.80267 1.89666 1.09966 2.59966C0.396661 3.30267 0.00119089 4.2558 0 5.25L0 14.25C0.00119089 15.2442 0.396661 16.1973 1.09966 16.9003C1.80267 17.6033 2.7558 17.9988 3.75 18H14.25C15.2442 17.9988 16.1973 17.6033 16.9003 16.9003C17.6033 16.1973 17.9988 15.2442 18 14.25V5.25C17.9988 4.2558 17.6033 3.30267 16.9003 2.59966C16.1973 1.89666 15.2442 1.50119 14.25 1.5ZM1.5 5.25C1.5 4.65326 1.73705 4.08097 2.15901 3.65901C2.58097 3.23705 3.15326 3 3.75 3H14.25C14.8467 3 15.419 3.23705 15.841 3.65901C16.2629 4.08097 16.5 4.65326 16.5 5.25V6H1.5V5.25ZM14.25 16.5H3.75C3.15326 16.5 2.58097 16.2629 2.15901 15.841C1.73705 15.419 1.5 14.8467 1.5 14.25V7.5H16.5V14.25C16.5 14.8467 16.2629 15.419 15.841 15.841C15.419 16.2629 14.8467 16.5 14.25 16.5Z"
                            fill="#15243B" />
                          <path
                            d="M9 12.375C9.62132 12.375 10.125 11.8713 10.125 11.25C10.125 10.6287 9.62132 10.125 9 10.125C8.37868 10.125 7.875 10.6287 7.875 11.25C7.875 11.8713 8.37868 12.375 9 12.375Z"
                            fill="#15243B" />
                          <path
                            d="M5.25 12.375C5.87132 12.375 6.375 11.8713 6.375 11.25C6.375 10.6287 5.87132 10.125 5.25 10.125C4.62868 10.125 4.125 10.6287 4.125 11.25C4.125 11.8713 4.62868 12.375 5.25 12.375Z"
                            fill="#15243B" />
                          <path
                            d="M12.75 12.375C13.3713 12.375 13.875 11.8713 13.875 11.25C13.875 10.6287 13.3713 10.125 12.75 10.125C12.1287 10.125 11.625 10.6287 11.625 11.25C11.625 11.8713 12.1287 12.375 12.75 12.375Z"
                            fill="#15243B" />
                        </g>
                        <defs>
                          <clipPath id="clip0_102_145">
                            <rect width="18" height="18" fill="#ffc750" />
                          </clipPath>
                        </defs>
                      </svg>
                    </span>
                  </div>
                </div>
                <div class="col-12">
                  <div id="slotData" class="row">
                  </div>
                </div>
                <div class="mx-auto text-center all-btn">
                  <button class="btn btn-secondary appoint-btn appointmentAdd d-none">
                    {{ __('messages.make_appointments') }}
                  </button>
                </div>
              </div>
            </div>
          </div>
          @include('vcardTemplates.appointment')
        @endif
      @endif
      {{-- product --}}
      @if ((isset($managesection) && $managesection['products']) || empty($managesection))
        @if (checkFeature('products') && $vcard->products->count())
          <div class="product-section pt-50 px-20 position-relative">
            <div class="position-absolute vector-all vector-6 text-end">
              <img src="{{ asset('assets/img/vcard36/vector-bg-6.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="section-heading">
              <h2 class="left-bg">{{ __('messages.plan.products') }}</h2>
            </div>
            <div class="product-slider">
              @foreach ($vcard->products as $product)
                <div>
                  <div class="product-card card">
                    <a @if ($product->product_url) href="{{ $product->product_url }}" @endif target="_blank"
                      class="text-decoration-none fs-6 position-relative d-block h-100">
                      <div class="product-img card-img">
                        <img src="{{ $product->product_icon }}" class="w-100 h-100 object-fit-cover" />
                      </div>
                      <div class="product-desc card-body">
                        <h3 class=" product-title text-gray-200 mb-3 fw-5 text-center"
                          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                          {{ $product->name }}
                        </h3>
                        <p class="product-amount mb-0 text-center">
                          @if ($product->currency_id && $product->price)
                            <span
                              @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') style="direction: rtl; text-align: right; display: block;" @endif>{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                          @elseif($product->price)
                            <span
                              @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') style="direction: rtl; text-align: right; display: block;" @endif>{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                          @endif
                        </p>
                      </div>
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="mt-5 text-center">
              <a class="view-more d-inline-flex gap-2 align-items-center"
                href="{{ $vcardProductUrl }}">{{ __('messages.analytics.view_more') }} <i
                  class="fa-solid fa-arrow-right right-arrow-animation"></i></a>
            </div>
          </div>
        @endif
      @endif
      {{-- testimonials --}}
      @if ((isset($managesection) && $managesection['testimonials']) || empty($managesection))
        @if (checkFeature('testimonials') && $vcard->testimonials->count())
          <div class="testimonial-section pt-50 px-20 position-relative">
            <div class="position-absolute vector-all vector-7">
              <img src="{{ asset('assets/img/vcard36/vector-bg-7.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="position-absolute vector-all shape-2">
              <img src="{{ asset('assets/img/vcard36/shape-1-vcard36.png') }}"
                class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="section-heading">
              <h2 class="right-bg">{{ __('messages.plan.testimonials') }}</h2>
            </div>
            <div class="testimonial-slider">
              @foreach ($vcard->testimonials as $testimonial)
                <div>
                  <div class="testimonial-card card position-relative">
                    <div class="position-absolute quto-left">
                      <img src="{{ asset('assets/img/vcard36/quote-left.png') }}" alt="images" />
                    </div>
                    <div class="position-absolute quto-right">
                      <img src="{{ asset('assets/img/vcard36/quote-right.png') }}" alt="images" />
                    </div>
                    <div class="card-body p-0">
                      <p class="desc text-gray-200 mb-3 text-center {{ \Illuminate\Support\Str::length($testimonial->description) > 80 ? 'more' : '' }}"
                        @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                        "{!! $testimonial->description !!}"
                      </p>
                      <div class="d-flex align-items-center justify-content-center gap-3">
                        <div class="card-img testimonial-profile-img">
                          <img src="{{ $testimonial->image_url }}" class="w-100 h-100 object-fit-cover" />
                        </div>
                        <div>
                          <h3 class="text- fw-5 mb-0" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                            {{ ucwords($testimonial->name) }}</h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      @endif

      {{-- blog --}}
      @if ((isset($managesection) && $managesection['blogs']) || empty($managesection))
        @if (checkFeature('blog') && $vcard->blogs->count())
          <div class="blog-section pt-50 px-20 position-relative">
            <div class="position-absolute vector-all vector-8 text-end">
              <img src="{{ asset('assets/img/vcard36/vector-bg-8.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="section-heading">
              <h2 class="left-bg">{{ __('messages.feature.blog') }}</h2>
            </div>
            <div class="blog-slider  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') blog-rtl @endif">
              @foreach ($vcard->blogs as $index => $blog)
                <?php
                $vcardBlogUrl = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/blog/{$blog->id}" : route('vcard.show-blog', [$vcard->url_alias, $blog->id]);
                ?>
                <div>
                  <div class="blog-card d-flex flex-column align-items-center"
                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>

                    <a href="{{ $vcardBlogUrl }}" class="d-block blog-img card-img">
                      <img src="{{ $blog->blog_icon }}" class="w-100 h-100 object-fit-cover" />
                    </a>

                    <div class="card-body w-100">
                      <a href="{{ $vcardBlogUrl }}">
                        <h2 class="fw-5 text-secondary blog-head">
                          {{ $blog->title }}
                        </h2>
                        <p class="text-gray-300 blog-desc mb-1">
                          {{ Illuminate\Support\Str::words(str_replace('&nbsp;', ' ', strip_tags($blog->description)), 100, '...') }}
                        </p>
                      </a>
                      <div class="d-flex align-items-center justify-content-end">
                        <a href="{{ $vcardBlogUrl }}"
                          class="px-3 py-2 fs-14 d-inline-flex align-items-center btn btn-secondary justify-content-end gap-2"
                          tabindex="-1">
                          {{ __('messages.vcard_11.read_more') }}
                          <svg class="svg-inline--fa fa-arrow-right-long  text-decoration-none" aria-hidden="true"
                            focusable="false" data-prefix="fas" data-icon="arrow-right-long" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
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
      {{-- buisness hours --}}
      @if ((isset($managesection) && $managesection['business_hours']) || empty($managesection))
        @if ($vcard->businessHours->count())
          @php
            $todayWeekName = strtolower(\Carbon\Carbon::now()->rawFormat('D'));
          @endphp
          <div class="business-hour-section pt-50 px-30 position-relative"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <div class="position-absolute vector-all vector-9">
              <img src="{{ asset('assets/img/vcard36/vector-bg-9.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="section-heading">
              <h2 class="right-bg">{{ __('messages.business.business_hours') }}</h2>
            </div>
            @if (getLanguage($vcard->default_language) != 'Arabic' && getLanguage($vcard->default_language) != 'Persian')
              <div class="business-hour-card row row-gap-20px justify-content-center position-relative">
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
                    <div class="business-hour align-items-center">
                      <div class="time-icons d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                          class="icon icon-tabler icon-tabler-calendar-time text-white" width="24" height="24"
                          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                          stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none">
                          </path>
                          <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4">
                          </path>
                          <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                          <path d="M15 3v4"></path>
                          <path d="M7 3v4"></path>
                          <path d="M3 11h16"></path>
                          <path d="M18 16.496v1.504l1 1"></path>
                        </svg>
                      </div>
                      <div class="justify-content-center align-items-center flex-column d-flex">
                        <span
                          class="text-gray-300">{{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}:</span>
                        <span>{{ $dayTime ?? __('messages.common.closed') }}</span>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian')
              <div class="business-hour-card row justify-content-center position-relative" dir="rtl">
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
                  <div class="col-sm-6 mb-3 pe-sm-2">
                    <div class="business-hour align-items-center">
                      <div class="time-icons d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                          class="icon icon-tabler icon-tabler-calendar-time text-white" width="24" height="24"
                          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                          stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none">
                          </path>
                          <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4">
                          </path>
                          <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                          <path d="M15 3v4"></path>
                          <path d="M7 3v4"></path>
                          <path d="M3 11h16"></path>
                          <path d="M18 16.496v1.504l1 1"></path>
                        </svg>
                      </div>
                      <div class="justify-content-center align-items-center flex-column d-flex">
                        <span
                          class="text-gray-300">{{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}:</span>
                        <span>{{ $dayTime ?? __('messages.common.closed') }}</span>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        @endif
      @endif
      {{-- qrcode --}}
      @if (isset($vcard['show_qr_code']) && $vcard['show_qr_code'] == 1)
        <div class="qr-code-section pt-50 px-30 position-relative"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div class="position-absolute vector-all vector-10 text-end">
            <img src="{{ asset('assets/img/vcard36/vector-bg-10.png') }}" class="w-100 h-100 object-fit-cover" />
          </div>
          <div class="position-absolute vector-all shape-3">
            <img src="{{ asset('assets/img/vcard36/plane-vcard36.png') }}" class="w-100 h-100 object-fit-cover" />
          </div>
          <div class="section-heading">
            <h2 class="left-bg">{{ __('messages.vcard.qr_code') }}</h2>
          </div>

          <div class="qr-code mx-auto  position-relative">
            <div class="d-flex flex-sm-row flex-column gap-3 align-items-center"
              @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
              <div class="qr-code-img text-center" id="qr-code-thirtysix">
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
              <div class=" text-center @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @else text-sm-start @endif">
                <h5 class="fw-6 text-secondary">{{ __('messages.vcard.scan_to_contact') }}</h5>
                <p class="fs-14 text-gray-300 mb-0">{{ __('messages.vcard.qr_section_desc') }}</p>
              </div>

            </div>

          </div>
        </div>
      @endif
      {{-- insta feed --}}
      @if ((isset($managesection) && $managesection['insta_embed']) || empty($managesection))
        @if (checkFeature('insta_embed') && $vcard->instagramEmbed->count())
          <div class="pt-50 position-relative">
            <div class="position-absolute vector-all vector-11">
              <img src="{{ asset('assets/img/vcard36/vector-bg-11.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="section-heading px-30">
              <h2 class="right-bg">{{ __('messages.feature.insta_embed') }}</h2>
            </div>
            <nav class="px-30">
              <div class="row insta-toggle">
                <div class="nav nav-tabs border-0 pe-0" id="nav-tab" role="tablist">
                  <button
                    class="d-flex align-items-center justify-content-center py-2 active postbtn instagram-btn  border-0 text-primary"
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
                    class="d-flex align-items-center justify-content-center py-2 instagram-btn reelsbtn  border-0 text-primary mr-0"
                    id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                    role="tab" aria-controls="nav-profile" aria-selected="false">
                    <svg class="svg-reels-icon" viewBox="0 0 48 48" width="27" height="27">
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
          <div id="postContent" class="insta-feed px-30">
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
          <div class="d-none insta-feed px-30" id="reelContent">
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
          <div class="pt-50 position-relative">
            <div class="section-heading px-30">
              <h2 class="left-bg">{{ __('messages.feature.linkedin_embed') }}</h2>
            </div>

            <div class="linkedin-feed px-30">
              <div class="row overflow-hidden mt-3 row-gap-20px" loading="lazy">
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
      {{-- iframe --}}
      @if ((isset($managesection) && $managesection['iframe']) || empty($managesection))
        @if (checkFeature('iframes') && $vcard->iframes->count())
          <div class="iframe-section pt-50 px-20 position-relative">
            <div class="position-absolute vector-all vector-12 text-end">
              <img src="{{ asset('assets/img/vcard36/vector-bg-12.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="section-heading">
              <h2 class="right-bg">{{ __('messages.vcard.iframe') }}</h2>
            </div>
            <div class="iframe-slider">
              @foreach ($vcard->iframes as $iframe)
                <div class="slide">
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
      {{-- messages.contact_us.contact --}}
      @php
        $currentSubs = $vcard->subscriptions()->where('status', \App\Models\Subscription::ACTIVE)->latest()->first();
      @endphp
      @if ($currentSubs && $currentSubs->plan->planFeature->enquiry_form && $vcard->enable_enquiry_form)
        <div class="contact-us-section pt-50 px-30 position-relative"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div class="position-absolute vector-all vector-13">
            <img src="{{ asset('assets/img/vcard36/vector-bg-13.png') }}" class="w-100 h-100 object-fit-cover" />
          </div>
          <div class="section-heading">
            <h2 class="left-bg">{{ __('messages.dynamic_vcard.contact_us') }}</h2>
          </div>
          @if (getLanguage($vcard->default_language) != 'Arabic' && getLanguage($vcard->default_language) != 'Persian')
            <div class="contact-form">
              <form action="" id="enquiryForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div id="enquiryError" class="alert alert-danger d-none"></div>
                  <div class="col-12">
                    <input type="text" class="form-control" placeholder="{{ __('messages.form.your_name') }}"
                      name="name" />
                  </div>
                  <div class="col-12">
                    <input type="tel" class="form-control @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-end @endif"
                      placeholder="{{ __('messages.form.phone') }}" name="phone"
                      onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,&quot;&quot;)" />
                  </div>
                  <div class="col-12">
                    <input type="email" class="form-control" placeholder="{{ __('messages.form.your_email') }}"
                      name="email" />
                  </div>
                  <div class="col-12">
                    <textarea class="form-control mb-0 h-100" placeholder="{{ __('messages.form.type_message') }}" name="message"
                      rows="3"></textarea>
                  </div>
                  @if (isset($inquiry) && $inquiry == 1)
                    <div class="mb-3 mt-3">
                      <div class="wrapper-file-input">
                        <div class="input-box" id="fileInputTrigger">
                          <h4> <i class="fa-solid fa-upload mx-2"></i>{{ __('messages.choose_file') }}
                          </h4> <input type="file" id="attachment" name="attachment" hidden multiple />
                        </div> <small>{{ __('messages.file_supported') }}</small>
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
                    <div class="col-12 mb-4 mt-2">
                      <div class="d-flex gap-2">
                        <input type="checkbox" name="terms_condition" class="form-check-input terms-condition"
                          id="termConditionCheckbox" placeholder>&nbsp;
                        <label class="form-check-label" for="privacyPolicyCheckbox">
                          <span class="text-gray-300 fs-14">{{ __('messages.vcard.agree_to_our') }}</span>
                          <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                            target="_blank"
                            class="text-decoration-none link-info fs-14 fw-5 text-primary text-decoration-underline">{!! __('messages.vcard.term_and_condition') !!}</a>
                          <span class="text-gray-300">&</span>
                          <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                            target="_blank"
                            class="text-decoration-none link-info fs-14 fw-5 text-primary text-decoration-underline">{{ __('messages.vcard.privacy_policy') }}</a>
                        </label>
                      </div>
                    </div>
                  @endif
                  <div class="col-12 text-center">
                    <button class="btn btn-secondary" type="submit">
                      {{ __('messages.contact_us.send_message') }}
                    </button>
                  </div>
                </div>
              </form>
            </div>
          @endif
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian')
            <div class="contact-form" dir="rtl">
              <form action="" id="enquiryForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div id="enquiryError" class="alert alert-danger d-none"></div>
                  <div class="col-12">
                    <input type="text" class="form-control" placeholder="{{ __('messages.form.your_name') }}"
                      name="name" />
                  </div>
                  <div class="col-12">
                    <input type="tel" class="form-control @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-end @endif"
                      placeholder="{{ __('messages.form.phone') }}" name="phone"
                      onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,&quot;&quot;)" />
                  </div>
                  <div class="col-12">
                    <input type="email" class="form-control" placeholder="{{ __('messages.form.your_email') }}"
                      name="email" />
                  </div>
                  <div class="col-12 mb-3">
                    <textarea class="form-control mb-0 h-100" placeholder="{{ __('messages.form.type_message') }}" name="message"
                      rows="3"></textarea>
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
                          <h5>{{ __('messages.selected_files') }}</h5>
                          <ul class="file-list" id="fileList"></ul>
                        </div>
                      </div>
                    </div>
                  @endif
                  @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                    <div class="col-12 mb-4 mt-2">
                      <div class="d-flex gap-2">
                        <input type="checkbox" name="terms_condition" class="form-check-input terms-condition"
                          id="termConditionCheckbox" placeholder>&nbsp;
                        <label class="form-check-label" for="privacyPolicyCheckbox">
                          <span class="text-gray-300 fs-14">{{ __('messages.vcard.agree_to_our') }}</span>
                          <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                            target="_blank"
                            class="text-decoration-none link-info fs-14 fw-5 text-primary text-decoration-underline">{!! __('messages.vcard.term_and_condition') !!}</a>
                          <span class="text-gray-300">&</span>
                          <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                            target="_blank"
                            class="text-decoration-none link-info fs-14 fw-5 text-primary text-decoration-underline">{{ __('messages.vcard.privacy_policy') }}</a>
                        </label>
                      </div>
                    </div>
                  @endif
                  <div class="col-12 text-center">
                    <button class="btn btn-secondary" type="submit">
                      {{ __('messages.contact_us.send_message') }}
                    </button>
                  </div>
                </div>
              </form>
            </div>
          @endif
        </div>
      @endif
      {{-- create your vcard --}}
      @if ($currentSubs && $currentSubs->plan->planFeature->affiliation && $vcard->enable_affiliation)
        <div class="create-vcard-section pt-50  position-relative"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div class="position-absolute vector-all vector-14 text-end">
            <img src="{{ asset('assets/img/vcard36/vector-bg-14.png') }}" class="w-100 h-100 object-fit-cover" />
          </div>
          <div class="section-heading">
            <h2 class="right-bg">{{ __('messages.create_vcard') }}</h2>
          </div>
          <div class="vcard-link-main  px-20">
            <div class="vcard-link-card card">
              <div class="d-flex align-items-center justify-content-center gap-3">
                <a href="{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}"
                  class="text-secondary fw-5">{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}</a>
                <i class="icon fa-solid fa-arrow-up-right-from-square text-secondary"></i>
              </div>
            </div>
          </div>
        </div>
      @endif
      {{-- map --}}
      @if ((isset($managesection) && $managesection['map']) || empty($managesection))
        @if ($vcard->location_url && isset($url[5]))
          <div class="pt-50 px-30 position-relative">
            <div class="position-absolute vector-all vector-15">
              <img src="{{ asset('assets/img/vcard36/vector-bg-15.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="map-section">
              <div class="map-location d-flex gap-2 align-items-center"
                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                <div class="location-icon d-flex justify-content-center align-items-center">
                  <img src="{{ asset('assets/img/vcard36/location.svg') }}" />
                </div>
                <p class="text-primary mb-0">{!! ucwords($vcard->location) !!}</p>
              </div>
              <div>
                @if ($vcard->location_url && isset($url[5]))
                  <iframe width="100%" height="300px"
                    src='https://maps.google.de/maps?q={{ $url[5] }}/&output=embed' frameborder="0"
                    scrolling="no" marginheight="0" marginwidth="0" style="border-radius: 10px;"></iframe>
                @endif
              </div>
            </div>
          </div>
        @endif
        @if ($vcard->location_type == 1 && !empty($vcard->location_embed_tag))
          <div class="pt-50 px-30 position-relative">
            <div class="position-absolute vector-all vector-15">
              <img src="{{ asset('assets/img/vcard36/vector-bg-15.png') }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="map-section">
              <div class="map-location d-flex gap-2 align-items-center"
                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                <div class="location-icon d-flex justify-content-center align-items-center">
                  <img src="{{ asset('assets/img/vcard36/location.svg') }}" />
                </div>
                <p class="text-primary mb-0">{!! ucwords($vcard->location) !!}</p>
              </div>
              <div
                class="embed-responsive embed-responsive-16by9 rounded overflow-hidden justify-content-center d-flex mt-4"
                style="height: 300px;">
                {!! $vcard->location_embed_tag ?? '' !!}
              </div>
            </div>
          </div>
        @endif
      @endif
      {{-- bottom-img --}}
      <div class="vcard36-bottom-img mt-4">
      </div>
      {{-- add to contact --}}
      @if ($vcard->enable_contact)
        <div class="add-to-contact-section">
          <div class="text-center d-flex align-items-center justify-content-center"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            @if ($contactRequest == 1)
              <a href="{{ Auth::check() ? route('add-contact', $vcard->id) : 'javascript:void(0);' }}"
                class="add-contact-btn d-flex gap-2 align-items-center btn all-btn {{ Auth::check() ? 'auth-contact-btn' : 'ask-contact-detail-form' }}"
                data-action="{{ Auth::check() ? route('contact-request.store') : 'show-modal' }}">
                <i class="fas fa-download fa-address-book fs-4"></i>
                &nbsp;{{ __('messages.setting.add_contact') }}</a>
            @else
              <a href="{{ route('add-contact', $vcard->id) }}"
                class="add-contact-btn d-flex gap-2 align-items-center btn"><i
                  class="fas fa-download fa-address-book"></i>
                &nbsp;{{ __('messages.setting.add_contact') }}</a>
            @endif
          </div>
        </div>
        @include('vcardTemplates.contact-request')
      @endif

      {{-- sticky buttons --}}
      <div class="btn-section cursor-pointer @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
        <div class="fixed-btn-section">
          <div class="bars-btn travel-bars-btn">
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
                  <input type="number" class="search-input" id="wpNumber" data-ic-class="search-input"
                    placeholder="{{ __('messages.setting.wp_number') }}" />
                  <div class="share-wp-btn-div">
                    <a href="javascript:void(0)"
                      class="vcard36-sticky-btn vcard36-btn-group d-flex justify-content-center text-primary align-items-center rounded-0 text-decoration-none py-1 rounded-pill justify-content share-wp-btn">
                      <i class="fa-solid fa-paper-plane"></i> </a>
                  </div>
                </div>
              @endif
              @if (empty($vcard->hide_stickybar))
                <div class="{{ isset($vcard->whatsapp_share) ? 'vcard36-btn-group' : 'stickyIcon' }}">
                  <button type="button" class="vcard36-btn-group vcard36-share vcard36-sticky-btn mb-3"><i
                      class="fas fa-share-alt fs-4 pt-1"></i></button>
                  @if (!empty($vcard->enable_download_qr_code))
                    <a type="button"
                      class="vcard36-btn-group vcard36-sticky-btn d-flex justify-content-center  align-items-center  px-2 mb-3 py-2"
                      id="qr-code-btn" download="qr_code.png"><i
                        class="fa-solid fa-qrcode fs-4 text-primary"></i></a>
                  @endif
                </div>
              @endif
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
                <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"
                  id="closeNewsLatterModal"></button>
              </div>
              <div class="modal-body">
                <h1 class="content text-start mb-2">
                  {{ __('messages.vcard.subscribe_newslatter') }}
                </h1>
                <h3 class="modal-desc text-start">{{ __('messages.vcard.update_directly') }}</h3>
                <form action="" method="post" id="newsLatterForm"
                  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                  @csrf
                  <input type="hidden" name="vcard_id" value="{{ $vcard->id }}">
                  <div class="mb-1 mt-4 d-flex gap-1 justify-content-center align-items-center email-input">
                    <div class="w-100">
                      <input type="email" class="form-control border-0 text-light email-input w-100"
                        placeholder="{{ __('messages.form.enter_your_email') }}" name="email"
                        id="emailSubscription" aria-label="Email" aria-describedby="button-addon2">
                    </div>
                    <button class="btn ms-1" type="submit" id="email-send">{{ __('messages.subscribe') }}</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endif
      {{-- share modal code --}}
      <div id="vcard36-shareModel" class="modal fade" role="dialog">
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
                    <p class="align-items-center text-primary fw-bolder">
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
                        viewBox="0 0 512 512">
                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                          d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                      </svg></span>

                  </div>
                  <div class="col-9 p-1">
                    <p class="align-items-center text-primary fw-bolder">
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
                    <p class="align-items-center text-primary fw-bolder">
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
              <a href="mailto:?Subject=&Body={{ $shareUrl }}" target="_blank"
                class="text-decoration-none share" title="Email">
                <div class="row">
                  <div class="col-2">
                    <i class="fas fa-envelope fa-2x" style="color: #191a19  "></i>
                  </div>
                  <div class="col-9 p-1">
                    <p class="align-items-center text-primary fw-bolder">
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
                    <p class="align-items-center text-primary fw-bolder">
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
                    <p class="align-items-center text-primary fw-bolder">
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
                    <i class="fab fa-whatsapp text-primary fa-2x" style="color: limegreen !important"></i>
                  </div>
                  <div class="col-9 p-1">
                    <p class="align-items-center text-primary fw-bolder">
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
                    <p class="align-items-center text-primary fw-bolder">
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
      {{-- made by --}}
      <div class="d-flex justify-content-evenly w-100 py-2">
        @if (checkFeature('advanced'))
          @if (checkFeature('advanced')->hide_branding && $vcard->branding == 0)
            @if ($vcard->made_by)
              <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                class="text-center text-decoration-none text-primary fw-5" target="_blank">
                <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
              </a>
            @else
              <div class="text-center">
                <small class="text-primary fw-5">{{ __('messages.made_by') }}
                  {{ $setting['app_name'] }}</small>
              </div>
            @endif
          @endif
        @else
          @if ($vcard->made_by)
            <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
              class="text-center text-decoration-none text-primary fw-5" target="_blank">
              <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
            </a>
          @else
            <div class="text-center">
              <small class="text-primary fw-5">{{ __('messages.made_by') }}
                {{ $setting['app_name'] }}</small>
            </div>
          @endif
        @endif
        @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
          <div>
            <a class="text-decoration-none text-primary fw-5 cursor-pointer terms-policies-btn"
              href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"><small>{!! __('messages.vcard.term_policy') !!}</small></a>
          </div>
        @endif
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
  $().ready(function() {
    $(".gallery-slider").slick({
      arrows: false,
      infinite: true,
      dots: false,
      slidesToShow: 1,
      autoplay: true,
      dots: true,
    });
    $(".product-slider").slick({
      arrows: false,
      infinite: true,
      dots: false,
      slidesToShow: 2,
      slidesToScroll: 1,
      autoplay: true,
      responsive: [{
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
        },
      }, ],
    });
    $(".testimonial-slider").slick({
      arrows: false,
      infinite: true,
      dots: true,
      slidesToShow: 1,
      /* autoplay: true, */
    });
    $(".blog-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      dots: true,
      infinite: true,
      autoplay: true,
      prevArrow: '<button class="slide-arrow slick-prev prev-arrow" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif><i class="fa-solid fa-arrow-left"></i></button>',
      nextArrow: '<button class="slide-arrow slick-next next-arrow" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif><i class="fa-solid fa-arrow-right"></i></button>',
    });

    $(".service-slider").slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      arrows: false,
      dots: true,
      infinite: true,
      autoplay: true,
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
  const qrCodeThirtysix = document.getElementById("qr-code-thirtysix");
  const svg = qrCodeThirtysix.querySelector("svg");
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

