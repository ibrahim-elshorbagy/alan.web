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
  <link rel="stylesheet" href="{{ asset('assets/css/vcard38.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}">
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
  <div class="vcard38-bg-effect position-fixed w-100 h-100 top-0 start-0">
    <div id="vcard38Tsparticles"></div>
    <div class="vcard-38-bg-img">
    </div>
  </div>
  <div class="main-content position-relative @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
    <div class="banner-section">
      <div class="@if ($vcard->cover_type == 2) yt-main-img @endif banner-img">
        @php
          $coverClass = $vcard->cover_image_type == 0 ? 'object-fit-cover w-100 h-100' : 'object-fit-cover w-100 h-100';
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
          <div class="youtube-link-38">
            <iframe
              src="https://www.youtube.com/embed/{{ YoutubeID($vcard->youtube_link) }}?autoplay=1&mute=0&loop=1&playlist={{ YoutubeID($vcard->youtube_link) }}&controls=0&modestbranding=1&showinfo=0&rel=0"
              class="cover-video {{ $coverClass }}" id="cover-video" frameborder="0"
              allow="autoplay; encrypted-media" allowfullscreen>
            </iframe>
          </div>
        @endif
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
    {{-- Language --}}
    <div
      class="d-flex justify-content-end position-absolute top-0  mx-3 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') start-0 end-auto @else end-0 @endif">
      @if ($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
        <div class="language pt-3">
          <ul class="text-decoration-none ps-0">
            <li class="dropdown1 dropdown lang-list fw-6">
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
    <div class="top-img">
      <img src="{{ asset('assets/img/vcard38/profile-top-img.png') }}" alt="img" class="w-100 h-100" />
    </div>
    <!-- profile-section -->
    <div class="profile-section @if ($vcard->cover_type == 2)  @endif"
      @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
      <div class="profile px-30">
        <div class="user-img">
          <img src="{{ $vcard->profile_url }}" alt="img" class="w-100 h-100 object-fit-cover" />
        </div>
        <div class="profile-desc text-center">
          <h1>
            {{ ucwords($vcard->first_name . ' ' . $vcard->last_name) }}
            @if ($vcard->is_verified)
              <i class="verification-icon bi-patch-check-fill text-primary"></i>
            @endif
          </h1>
          <p class="text-decoration-underline mb-1 fw-5 fs-16">
            {{ ucwords($vcard->company) }}</p>
          <p class="text-gray-200 mb-0 fw-5 fs-14">{{ ucwords($vcard->occupation) }}</p>
          <p class="text-gray-200 mb-0 fw-5 fs-14">{{ ucwords($vcard->job_title) }}</p>
        </div>
      </div>
      <div class="description pt-40 px-30 text-center">
        {!! $vcard->description !!}
      </div>
      {{-- social-media --}}
      @if (checkFeature('social_links') && getSocialLink($vcard))
        <div class="social-media-section pt-40 px-30 position-relative"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div class="vector-1 bg-vector">
            <img src="{{ asset('assets/img/vcard38/vector1.png') }}" alt="img" />
          </div>
          <div class="d-flex flex-wrap justify-content-center social-icons-container">
            @foreach (getSocialLink($vcard) as $value)
              <span
                class="social-icon d-flex justify-content-center align-items-center social-bg-style text-decoration-none">
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
        <div class="contact-section position-relative pt-60 px-30">
          <div class="vector-2 bg-vector">
            <img src="{{ asset('assets/img/vcard38/vector2.png') }}" alt="img" />
          </div>
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
            <h2>{{ __('messages.dynamic_vcard.contact') }}</h2>
            <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
          </div>
          <div class="row row-gap-30" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            @if ($vcard->email)
              <div class="col-sm-6">
                <div class="contact-box">
                  <div class="contact-icon">
                    <img src="{{ asset('assets/img/vcard38/mail.png') }}" alt="img" />
                  </div>
                  <a href="mailto:{{ $vcard->email }}">{{ $vcard->email }}</a>
                </div>
              </div>
            @endif
            @if ($vcard->alternative_email)
              <div class="col-sm-6">
                <div class="contact-box">
                  <div class="contact-icon">
                    <img src="{{ asset('assets/img/vcard38/mail.png') }}" alt="img" />
                  </div>
                  <a href="mailto:{{ $vcard->alternative_email }}">{{ $vcard->alternative_email }}</a>
                </div>
              </div>
            @endif
            @if ($vcard->phone)
              <div class="col-sm-6">
                <div class="contact-box">
                  <div class="contact-icon">
                    <img src="{{ asset('assets/img/vcard38/phone.png') }}" alt="img" />
                  </div>
                  <a
                    href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}">+{{ $vcard->region_code }}{{ $vcard->phone }}</a>
                </div>
              </div>
            @endif
            @if ($vcard->alternative_phone)
              <div class="col-sm-6">
                <div class="contact-box">
                  <div class="contact-icon">
                    <img src="{{ asset('assets/img/vcard38/phone.png') }}" alt="img" />
                  </div>
                  <a
                    href="tel:+{{ $vcard->region_code }}{{ $vcard->alternative_phone }}">+{{ $vcard->region_code }}{{ $vcard->alternative_phone }}</a>
                </div>
              </div>
            @endif
            @if ($vcard->dob)
              <div class="col-sm-6">
                <div class="contact-box">
                  <div class="contact-icon">
                    <img src="{{ asset('assets/img/vcard38/dob.png') }}" alt="img" />
                  </div>
                  <p>{{ $vcard->dob }}</p>
                </div>
              </div>
            @endif
            @if ($vcard->location)
              <div class="col-sm-6">
                <div class="contact-box">
                  <div class="contact-icon">
                    <img src="{{ asset('assets/img/vcard38/location.png') }}" alt="img" />
                  </div>
                  <p>{!! ucwords($vcard->location) !!}</p>
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
        <div class="gallery-section position-relative pt-60 px-20">
          <div class="vector-3 bg-vector">
            <img src="{{ asset('assets/img/vcard38/vector3.png') }}" alt="img" />
          </div>
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
            <h2>{{ __('messages.plan.gallery') }}</h2>
            <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
          </div>
          <div class="position-relative">
            <div class="gallery-slider">
              @foreach ($vcard->gallery as $file)
                @php
                  $infoPath = pathinfo(public_path($file->gallery_image));
                  $extension = $infoPath['extension'];
                @endphp
                <div>
                  <div class="gallery-img">
                    <div class="position-absolute expand-more">
                      <i class="fas fa-expand text-white"></i>
                    </div>
                    @if ($file->type == App\Models\Gallery::TYPE_IMAGE)
                      <a href="{{ $file->gallery_image }}" data-lightbox="gallery-images">
                        <img src="{{ $file->gallery_image }}" alt="img"
                          class="w-100 h-100 object-fit-cover" /></a>
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
        <div class="service-section position-relative pt-60">
          <div class="vector-4 bg-vector">
            <img src="{{ asset('assets/img/vcard38/vector4.png') }}" alt="img" />
          </div>
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
            <h2>{{ __('messages.vcard.our_service') }}</h2>
            <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
          </div>
          @if ($vcard->services_slider_view)
            <div class="px-20">
              <div class="service-cards" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                <div class="service-slider">
                  @foreach ($vcard->services as $service)
                    <div>
                      <div class="service-card cards">
                        <div class="service-img">
                          <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                            class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                            target="{{ $service->service_url ? '_blank' : '' }}">
                            <img src="{{ $service->service_icon }}" alt="img"
                              class="w-100 h-100 object-fit-cover" />
                          </a>
                        </div>
                        <div class="card-content">
                          <h5 class="card-title mb-2 text-center" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                            {{ ucwords($service->name) }}</h5>
                          <p class="mb-0 description-text text-center {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}"
                            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                            {!! \Illuminate\Support\Str::limit($service->description, 170, '...') !!}
                          </p>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          @else
            <div class="px-30">
              <div class="row row-gap-30 mb-4" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                @foreach ($vcard->services as $service)
                  <div class="col-sm-6">
                    <div class="service-card h-100">
                      <div class="service-img">
                        <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                          class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                          target="{{ $service->service_url ? '_blank' : '' }}">
                          <img src="{{ $service->service_icon }}" alt="img"
                            class="w-100 h-100 object-fit-cover" />
                        </a>
                      </div>
                      <div class="card-content text-center">
                        <h5 class="fs-20 text-primary mb-2" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                          {{ ucwords($service->name) }}
                        </h5>
                        <p class="fs-14 text-black {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}"
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
        <div class="appointment-section position-relative">
          <div class="vector-5 bg-vector">
            <img src="{{ asset('assets/img/vcard38/vector5.png') }}" alt="img" />
          </div>
          <div class="appointment">
            <div class="title d-flex align-items-center gap-20 justify-content-center">
              <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
              <h2>{{ __('messages.make_appointments') }}</h2>
              <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
            </div>

            <div class="pt-3 pt-sm-5 pb-4 position-relative" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
              <div class="date-input position-relative">
                <div class="input-group-date d-flex align-items-center position-relative">
                  <input type="date" name="date" class="date appoint-input w-100"
                    placeholder="{{ __('messages.form.pick_date') }}" id='pickUpDate' />

                  <div class="calender-icon">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M3.75 4.25H4.1875V4.6875C4.1875 5.99619 5.25254 7.0625 6.5625 7.0625H8.4375C9.74746 7.0625 10.8125 5.99619 10.8125 4.6875V4.25H19.1875V4.6875C19.1875 5.99636 20.2536 7.0625 21.5625 7.0625H23.4375C24.7464 7.0625 25.8125 5.99636 25.8125 4.6875V4.25H26.25C28.0448 4.25 29.5 5.7052 29.5 7.5V26.25C29.5 28.0448 28.0448 29.5 26.25 29.5H3.75C1.9552 29.5 0.5 28.0448 0.5 26.25V7.5C0.5 5.7052 1.9552 4.25 3.75 4.25ZM3.75 8.875C2.44004 8.875 1.375 9.94131 1.375 11.25V26.25C1.375 27.5608 2.44036 28.625 3.75 28.625H26.25C27.5607 28.625 28.625 27.5607 28.625 26.25V11.25C28.625 9.94146 27.561 8.875 26.25 8.875H3.75ZM6.5625 21.125H8.4375C8.67956 21.125 8.875 21.3204 8.875 21.5625V23.4375C8.875 23.6796 8.67956 23.875 8.4375 23.875H6.5625C6.32044 23.875 6.125 23.6796 6.125 23.4375V21.5625C6.125 21.3204 6.32044 21.125 6.5625 21.125ZM14.0625 21.125H15.9375C16.1796 21.125 16.375 21.3204 16.375 21.5625V23.4375C16.375 23.6796 16.1796 23.875 15.9375 23.875H14.0625C13.8204 23.875 13.625 23.6796 13.625 23.4375V21.5625C13.625 21.3204 13.8204 21.125 14.0625 21.125ZM21.5625 21.125H23.4375C23.6796 21.125 23.875 21.3204 23.875 21.5625V23.4375C23.875 23.6796 23.6796 23.875 23.4375 23.875H21.5625C21.3204 23.875 21.125 23.6796 21.125 23.4375V21.5625C21.125 21.3204 21.3204 21.125 21.5625 21.125ZM6.5625 13.625H8.4375C8.67956 13.625 8.875 13.8204 8.875 14.0625V15.9375C8.875 16.1796 8.67956 16.375 8.4375 16.375H6.5625C6.32044 16.375 6.125 16.1796 6.125 15.9375V14.0625C6.125 13.8204 6.32044 13.625 6.5625 13.625ZM14.0625 13.625H15.9375C16.1796 13.625 16.375 13.8204 16.375 14.0625V15.9375C16.375 16.1796 16.1796 16.375 15.9375 16.375H14.0625C13.8204 16.375 13.625 16.1796 13.625 15.9375V14.0625C13.625 13.8204 13.8204 13.625 14.0625 13.625ZM21.5625 13.625H23.4375C23.6796 13.625 23.875 13.8204 23.875 14.0625V15.9375C23.875 16.1796 23.6796 16.375 23.4375 16.375H21.5625C21.3204 16.375 21.125 16.1796 21.125 15.9375V14.0625C21.125 13.8204 21.3204 13.625 21.5625 13.625ZM6.5625 0.5H8.4375C8.67956 0.5 8.875 0.695439 8.875 0.9375V4.6875C8.875 4.92956 8.67956 5.125 8.4375 5.125H6.5625C6.32044 5.125 6.125 4.92956 6.125 4.6875V0.9375C6.125 0.695439 6.32044 0.5 6.5625 0.5ZM21.5625 0.5H23.4375C23.6796 0.5 23.875 0.695439 23.875 0.9375V4.6875C23.875 4.92956 23.6796 5.125 23.4375 5.125H21.5625C21.3204 5.125 21.125 4.92956 21.125 4.6875V0.9375C21.125 0.695439 21.3204 0.5 21.5625 0.5Z"
                        fill="#716659" stroke="#716659" />
                    </svg>
                  </div>
                </div>
                <div>
                  <div class="container-fluid px-sm-1 px-0 pt-1">
                    <div id="slotData" class="row time-select">

                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button class="btn btn-primary fs-18 fw-6 appointment-btn mx-auto appointmentAdd d-none">
                    {{ __('messages.make_appointments') }}
                  </button>
                </div>

              </div>
            </div>
          </div>
        </div>
        @include('vcardTemplates.appointment')
      @endif
    @endif
    {{-- video --}}
    {{-- qrcode --}}
    @if (isset($vcard['show_qr_code']) && $vcard['show_qr_code'] == 1)
      <div class="qr-code-section text-white">
        <div class="qr-code">
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/line-white-left.png') }}" alt="img" />
            <h2 class="text-white">{{ __('messages.vcard.qr_code') }}</h2>
            <img src="{{ asset('assets/img/vcard38/line-white-right.png') }}" alt="img" />
          </div>
          <div
            class="d-flex gap-20 align-items-center flex-column flex-sm-row text-center @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-sm-end @else text-sm-start @endif"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <div class="qr-code-img text-center" id="qr-code-thirtyeight">
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
            <div>
              <h5>{{ __('messages.vcard.scan_to_contact') }}</h5>
              <p>{{ __('messages.vcard.qr_section_desc') }}</p>
            </div>
          </div>
        </div>
      </div>
    @endif
    {{-- insta feed --}}
    @if ((isset($managesection) && $managesection['insta_embed']) || empty($managesection))
      @if (checkFeature('insta_embed') && $vcard->instagramEmbed->count())
        <div class="pt-60 position-relative">
          <div class="vcard38-vector-1">
            <img src="{{ asset('assets/img/vcard38/vcard38-vector-1.png') }}" alt="images" />
          </div>
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
            <h2>{{ __('messages.feature.insta_embed') }}</h2>
            <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
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
                    <rect width="36" height="3" x="6" y="15" fill="currentColor" class="color000 svgShape">
                    </rect>
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
        <div class="pt-5">
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
            <h2>{{ __('messages.feature.linkedin_embed') }}</h2>
            <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
          </div>

          <div class="linkedin-feed px-30">
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
    {{-- iframe --}}
    @if ((isset($managesection) && $managesection['iframe']) || empty($managesection))
      @if (checkFeature('iframes') && $vcard->iframes->count())
        <div class="iframe-section pt-60 px-20 position-relative">
          <div class="vcard38-vector-2">
            <img src="{{ asset('assets/img/vcard38/vcard38-vector-2.png') }}" alt="images" />
          </div>
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
            <h2>{{ __('messages.vcard.iframe') }}</h2>
            <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
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
    {{-- product --}}
    @if ((isset($managesection) && $managesection['products']) || empty($managesection))
      @if (checkFeature('products') && $vcard->products->count())
        <div class="product-section position-relative pt-60 px-20">
          <div class="vector-6 bg-vector">
            <img src="{{ asset('assets/img/vcard38/vector6.png') }}" alt="img" />
          </div>
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
            <h2>{{ __('messages.plan.products') }}</h2>
            <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
          </div>
          <div class="product-cards">
            <div class="product-slider">
              @foreach ($vcard->products as $product)
                <div>
                  <div class="product-card">
                    <a @if ($product->product_url) href="{{ $product->product_url }}" @endif target="_blank"
                      class="text-decoration-none fs-6 position-relative d-block h-100">
                      <div class="product-img card-img">
                        <img src="{{ $product->product_icon }}" alt="img"
                          class="w-100 h-100 object-fit-cover" />
                      </div>
                      <div class="product-desc card-body">
                        <h5 class="product-title text-black mb-3 fw-5 text-center"
                          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                          {{ $product->name }}</h5>
                        <p class="product-amount mb-0 text-center"
                          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') style="direction: rtl; text-align: right; display: block;" @endif>
                          @if ($product->currency_id && $product->price)
                            <span>{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                          @elseif($product->price)
                            <span>{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                          @endif
                        </p>
                      </div>
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="mt-4 text-center">
              <a class="view-more d-inline-flex gap-2 fs-16 fw-5 align-items-center"
                href="{{ $vcardProductUrl }}">{{ __('messages.analytics.view_more') }} <i
                  class="fa-solid fa-arrow-right right-arrow-animation"></i></a>
            </div>
          </div>
        </div>
      @endif
    @endif
    {{-- blog --}}
    @if ((isset($managesection) && $managesection['blogs']) || empty($managesection))
      @if (checkFeature('blog') && $vcard->blogs->count())
        <div class="blog-section position-relative pt-60 px-20">
          <div class="vector-7 bg-vector">
            <img src="{{ asset('assets/img/vcard38/vector7.png') }}" alt="img" />
          </div>
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
            <h2>{{ __('messages.feature.blog') }}</h2>
            <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
          </div>
          <div class="blog-slider @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') blog-rtl @endif">
            @foreach ($vcard->blogs as $index => $blog)
              <?php
              $vcardBlogUrl = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/blog/{$blog->id}" : route('vcard.show-blog', [$vcard->url_alias, $blog->id]);
              ?>
              <div>
                <div class="blog-card cards card-img">
                  <a href="{{ $vcardBlogUrl }}" class="d-block blog-img card-img">
                    <img src="{{ $blog->blog_icon }}" alt="img" class="w-100 h-100 object-fit-cover" />
                  </a>

                  <div class="card-body w-100" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <a href="{{ $vcardBlogUrl }}">
                      <h2
                        class="fw-7 text-primary blog-head mb-2 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-end @else text-start @endif">
                        {{ $blog->title }}
                      </h2>
                      <p
                        class="text-black blog-desc mb-2 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') text-end @else text-start @endif">
                        {{ Illuminate\Support\Str::words(str_replace('&nbsp;', ' ', strip_tags($blog->description)), 100, '...') }}
                      </p>
                    </a>
                    <div class="d-flex align-items-center justify-content-end">
                      <a href="{{ $vcardBlogUrl }}"
                        class="px-3 py-2 fs-14 d-inline-flex align-items-center btn btn-primary justify-content-end gap-2"
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
    {{-- testimonial --}}
    @if ((isset($managesection) && $managesection['testimonials']) || empty($managesection))
      @if (checkFeature('testimonials') && $vcard->testimonials->count())
        <div class="testimonial-section pt-60 px-20 position-relative">
          <div class="quote-img">
            <img src="{{ asset('assets/img/vcard38/quote.png') }}" alt="img" />
          </div>
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
            <h2>{{ __('messages.plan.testimonials') }}</h2>
            <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
          </div>
          <div class="position-relative">
            <div class="testimonial-slider">
              @foreach ($vcard->testimonials as $testimonial)
                <div>
                  <div class="testimonial-card">
                    <p class="{{ \Illuminate\Support\Str::length($testimonial->description) > 80 ? 'more' : '' }}"
                      @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                      {!! $testimonial->description !!}
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex gap-10 align-items-center">
                        <div class="user-img rounded-circle overflow-hidden">
                          <img src="{{ $testimonial->image_url }}" alt="img"
                            class="w-100 h-100 object-fit-cover" />
                        </div>
                        <h5 @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>{{ ucwords($testimonial->name) }}
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="navigation d-flex align-items-center">
              <button class="testinomial-prev">
                <svg width="22" height="16" viewBox="0 0 22 16" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.81911 15.3844C9.54049 15.6505 9.16266 15.8 8.7687 15.8C8.37473 15.8 7.9969 15.6505 7.71828 15.3844L1.03246 8.99527C0.753931 8.72902 0.597462 8.36796 0.597462 7.99148C0.597462 7.615 0.753931 7.25393 1.03246 6.98768L7.71828 0.598602C7.99849 0.339975 8.37379 0.196869 8.76335 0.200104C9.1529 0.203339 9.52555 0.352655 9.80101 0.615897C10.0765 0.879139 10.2327 1.23524 10.2361 1.60751C10.2395 1.97977 10.0898 2.33842 9.81911 2.60619L5.79722 6.57168L19.9117 6.57168C20.3058 6.57168 20.6837 6.72127 20.9623 6.98753C21.2409 7.25379 21.3975 7.61492 21.3975 7.99148C21.3975 8.36803 21.2409 8.72916 20.9623 8.99542C20.6837 9.26169 20.3058 9.41127 19.9117 9.41127L5.79722 9.41127L9.81911 13.3768C10.0976 13.643 10.2541 14.0041 10.2541 14.3806C10.2541 14.757 10.0976 15.1181 9.81911 15.3844Z"
                    fill="#716659" />
                </svg>
              </button>
              <button class="testinomial-next">
                <svg width="22" height="16" viewBox="0 0 22 16" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M12.1774 0.615404C12.456 0.349233 12.8338 0.199707 13.2278 0.199707C13.6218 0.199707 13.9997 0.349233 14.2783 0.615404L20.9645 7.00448C21.243 7.27073 21.3995 7.6318 21.3995 8.00828C21.3995 8.38476 21.243 8.74582 20.9645 9.01207L14.2783 15.4011C13.9981 15.6598 13.6228 15.8029 13.2332 15.7996C12.8436 15.7964 12.4709 15.6471 12.1955 15.3839C11.92 15.1206 11.7637 14.7645 11.7603 14.3922C11.7569 14.02 11.9067 13.6613 12.1774 13.3936L16.1995 9.42807H2.08421C1.69014 9.42807 1.31222 9.27849 1.03357 9.01222C0.75493 8.74596 0.598389 8.38483 0.598389 8.00828C0.598389 7.63172 0.75493 7.27059 1.03357 7.00433C1.31222 6.73807 1.69014 6.58848 2.08421 6.58848H16.1995L12.1774 2.62299C11.8988 2.35674 11.7423 1.99568 11.7423 1.6192C11.7423 1.24272 11.8988 0.881655 12.1774 0.615404Z"
                    fill="#716659" />
                </svg>
              </button>
            </div>
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
        <div class="business-hour-section position-relative pt-60 px-30">
          <div class="vector-8 bg-vector">
            <img src="{{ asset('assets/img/vcard38/vector8.png') }}" alt="img" />
          </div>
          <div class="title d-flex align-items-center gap-20 justify-content-center">
            <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
            <h2>{{ __('messages.business.business_hours') }}</h2>
            <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
          </div>
          <div class="row row-gap-30 justify-content-center" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            @foreach ($businessDaysTime as $key => $dayTime)
              <div class="col-sm-6">
                <div class="contact-box">
                  <div class="contact-icon calender-icon">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M3.75 4.25H4.1875V4.6875C4.1875 5.99619 5.25254 7.0625 6.5625 7.0625H8.4375C9.74746 7.0625 10.8125 5.99619 10.8125 4.6875V4.25H19.1875V4.6875C19.1875 5.99636 20.2536 7.0625 21.5625 7.0625H23.4375C24.7464 7.0625 25.8125 5.99636 25.8125 4.6875V4.25H26.25C28.0448 4.25 29.5 5.7052 29.5 7.5V26.25C29.5 28.0448 28.0448 29.5 26.25 29.5H3.75C1.9552 29.5 0.5 28.0448 0.5 26.25V7.5C0.5 5.7052 1.9552 4.25 3.75 4.25ZM3.75 8.875C2.44004 8.875 1.375 9.94131 1.375 11.25V26.25C1.375 27.5608 2.44036 28.625 3.75 28.625H26.25C27.5607 28.625 28.625 27.5607 28.625 26.25V11.25C28.625 9.94146 27.561 8.875 26.25 8.875H3.75ZM6.5625 21.125H8.4375C8.67956 21.125 8.875 21.3204 8.875 21.5625V23.4375C8.875 23.6796 8.67956 23.875 8.4375 23.875H6.5625C6.32044 23.875 6.125 23.6796 6.125 23.4375V21.5625C6.125 21.3204 6.32044 21.125 6.5625 21.125ZM14.0625 21.125H15.9375C16.1796 21.125 16.375 21.3204 16.375 21.5625V23.4375C16.375 23.6796 16.1796 23.875 15.9375 23.875H14.0625C13.8204 23.875 13.625 23.6796 13.625 23.4375V21.5625C13.625 21.3204 13.8204 21.125 14.0625 21.125ZM21.5625 21.125H23.4375C23.6796 21.125 23.875 21.3204 23.875 21.5625V23.4375C23.875 23.6796 23.6796 23.875 23.4375 23.875H21.5625C21.3204 23.875 21.125 23.6796 21.125 23.4375V21.5625C21.125 21.3204 21.3204 21.125 21.5625 21.125ZM6.5625 13.625H8.4375C8.67956 13.625 8.875 13.8204 8.875 14.0625V15.9375C8.875 16.1796 8.67956 16.375 8.4375 16.375H6.5625C6.32044 16.375 6.125 16.1796 6.125 15.9375V14.0625C6.125 13.8204 6.32044 13.625 6.5625 13.625ZM14.0625 13.625H15.9375C16.1796 13.625 16.375 13.8204 16.375 14.0625V15.9375C16.375 16.1796 16.1796 16.375 15.9375 16.375H14.0625C13.8204 16.375 13.625 16.1796 13.625 15.9375V14.0625C13.625 13.8204 13.8204 13.625 14.0625 13.625ZM21.5625 13.625H23.4375C23.6796 13.625 23.875 13.8204 23.875 14.0625V15.9375C23.875 16.1796 23.6796 16.375 23.4375 16.375H21.5625C21.3204 16.375 21.125 16.1796 21.125 15.9375V14.0625C21.125 13.8204 21.3204 13.625 21.5625 13.625ZM6.5625 0.5H8.4375C8.67956 0.5 8.875 0.695439 8.875 0.9375V4.6875C8.875 4.92956 8.67956 5.125 8.4375 5.125H6.5625C6.32044 5.125 6.125 4.92956 6.125 4.6875V0.9375C6.125 0.695439 6.32044 0.5 6.5625 0.5ZM21.5625 0.5H23.4375C23.6796 0.5 23.875 0.695439 23.875 0.9375V4.6875C23.875 4.92956 23.6796 5.125 23.4375 5.125H21.5625C21.3204 5.125 21.125 4.92956 21.125 4.6875V0.9375C21.125 0.695439 21.3204 0.5 21.5625 0.5Z"
                        fill="white" stroke="white" />
                    </svg>
                  </div>
                  <p>
                    <span>{{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}:</span>
                    <span>{{ $dayTime ?? __('messages.common.closed') }}</span>
                  </p>
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
      <div class="contact-us position-relative">
        <div class="title d-flex align-items-center gap-20 justify-content-center">
          <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
          <h2 class="text-white">{{ __('messages.dynamic_vcard.contact_us') }}</h2>
          <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
        </div>
        <div @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <form action="" id="enquiryForm" enctype="multipart/form-data">
            @csrf
            <div class="row gap-10 column-gap-0 mb-30">
              <div id="enquiryError" class="alert alert-danger d-none"></div>
              <div class="col-12">
                <input type="text" placeholder="{{ __('messages.form.your_name') }}" name="name"
                  class="w-100 form-control" />
              </div>
              <div class="col-12">
                <input type="text" placeholder="{{ __('messages.form.your_email') }}" name="email"
                  class="w-100 form-control" />
              </div>
              <div class="col-12">
                <input type="number" placeholder="{{ __('messages.form.phone') }}" name="phone"
                  onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,&quot;&quot;)"
                  class="w-100 form-control" />
              </div>
              <div class="col-12">
                <textarea name="message" id="" rows="3" placeholder="{{ __('messages.form.type_message') }}"
                  class="w-100 form-control"></textarea>
              </div>
              @if (isset($inquiry) && $inquiry == 1)
                <div class="mb-3">
                  <div class="wrapper-file-input">
                    <div class="input-box" id="fileInputTrigger">
                      <h4> <i class="fa-solid fa-upload me-2"></i>{{ __('messages.choose_file') }}
                      </h4> <input type="file" id="attachment" name="attachment" hidden multiple />
                    </div> <small class="text-white">{{ __('messages.file_supported') }}</small>
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
                <div class="col-12 mb-3">
                  <div class="d-flex gap-2">
                    <input type="checkbox" name="terms_condition" class="form-check-input terms-condition"
                      id="termConditionCheckbox" placeholder>
                    <label class="form-check-label" for="privacyPolicyCheckbox">
                      <span class="text-gray-300 fs-14">{{ __('messages.vcard.agree_to_our') }}</span>
                      <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                        target="_blank"
                        class="text-decoration-none fs-14 fw-5 text-white text-decoration-underline">{!! __('messages.vcard.term_and_condition') !!}</a>
                      <span class="text-gray-300">&</span>
                      <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                        target="_blank"
                        class="text-decoration-none fs-14 fw-5 text-white text-decoration-underline">{{ __('messages.vcard.privacy_policy') }}</a>
                    </label>
                  </div>
                </div>
              @endif
            </div>
            <div class="message btn-send-message">
              <button class="contact-btn send-btn btn btn-primary-btn fw-6"
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

    {{-- create your vcard --}}
    @if ($currentSubs && $currentSubs->plan->planFeature->affiliation && $vcard->enable_affiliation)
      <div class="create-vcard-section pt-60  position-relative">
        <div class="vcard38-vector-3">
          <img src="{{ asset('assets/img/vcard38/vcard38-vector-3.png') }}" alt="images" />
        </div>
        <div class="title d-flex align-items-center gap-20 justify-content-center">
          <img src="{{ asset('assets/img/vcard38/left-ling-img.png') }}" alt="img" />
          <h2 class="left-bg">{{ __('messages.create_vcard') }}</h2>
          <img src="{{ asset('assets/img/vcard38/right-line-img.png') }}" alt="img" />
        </div>
        <div class="vcard-link-main px-30" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div class="vcard-link-card card">
            <div class="d-flex align-items-center justify-content-center gap-3">
              <a href="{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}"
                class="text-primary fs-16 fw-5">{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}</a>
              <i class="icon fa-solid fa-arrow-up-right-from-square text-secondary"></i>
            </div>
          </div>
        </div>
      </div>
    @endif
    {{-- map --}}
    @if ((isset($managesection) && $managesection['map']) || empty($managesection))
      @if ($vcard->location_url && isset($url[5]))
        <div class="map-location px-30 position-relative" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div class="vector-9 bg-vector">
            <img src="{{ asset('assets/img/vcard38/vector9.png') }}" alt="img" />
          </div>
          <div class="map-card">
            <div class="location text-white d-flex align-items-center">
              <svg width="24" height="26" viewBox="0 0 24 26" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M12 0C7.43147 0 3.62109 3.68012 3.62109 8.37891C3.62109 10.1665 4.15826 11.7605 5.18917 13.2542L11.3588 22.8813C11.6581 23.3493 12.3425 23.3484 12.6412 22.8813L18.8376 13.2215C19.8463 11.7955 20.3789 10.1211 20.3789 8.37891C20.3789 3.75878 16.6201 0 12 0ZM12 12.1875C9.90004 12.1875 8.19141 10.4789 8.19141 8.37891C8.19141 6.27895 9.90004 4.57031 12 4.57031C14.1 4.57031 15.8086 6.27895 15.8086 8.37891C15.8086 10.4789 14.1 12.1875 12 12.1875Z"
                  fill="white" />
                <path
                  d="M17.9548 17.5039L14.1193 23.5005C13.1264 25.0484 10.868 25.0433 9.87998 23.502L6.03818 17.5055C2.65798 18.287 0.574219 19.7187 0.574219 21.4296C0.574219 24.3983 6.46119 25.9999 12 25.9999C17.5388 25.9999 23.4258 24.3983 23.4258 21.4296C23.4258 19.7175 21.3391 18.285 17.9548 17.5039Z"
                  fill="white" />
              </svg>

              <p>{!! ucwords($vcard->location) !!}</p>
            </div>
            <div class="map overflow-hidden">
              @if ($vcard->location_url && isset($url[5]))
                <iframe width="100%" height="300px"
                  src='https://maps.google.de/maps?q={{ $url[5] }}/&output=embed' frameborder="0"
                  scrolling="no" marginheight="0" marginwidth="0" style="border-radius: 10px"></iframe>
              @endif
            </div>
          </div>
        </div>
      @endif
      @if ($vcard->location_type == 1 && !empty($vcard->location_embed_tag))
        <div class="map-location px-30 position-relative" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div class="vector-9 bg-vector">
            <img src="{{ asset('assets/img/vcard38/vector9.png') }}" alt="img" />
          </div>
          <div class="map-card">
            <div class="location text-white d-flex align-items-center">
              <svg width="24" height="26" viewBox="0 0 24 26" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M12 0C7.43147 0 3.62109 3.68012 3.62109 8.37891C3.62109 10.1665 4.15826 11.7605 5.18917 13.2542L11.3588 22.8813C11.6581 23.3493 12.3425 23.3484 12.6412 22.8813L18.8376 13.2215C19.8463 11.7955 20.3789 10.1211 20.3789 8.37891C20.3789 3.75878 16.6201 0 12 0ZM12 12.1875C9.90004 12.1875 8.19141 10.4789 8.19141 8.37891C8.19141 6.27895 9.90004 4.57031 12 4.57031C14.1 4.57031 15.8086 6.27895 15.8086 8.37891C15.8086 10.4789 14.1 12.1875 12 12.1875Z"
                  fill="white" />
                <path
                  d="M17.9548 17.5039L14.1193 23.5005C13.1264 25.0484 10.868 25.0433 9.87998 23.502L6.03818 17.5055C2.65798 18.287 0.574219 19.7187 0.574219 21.4296C0.574219 24.3983 6.46119 25.9999 12 25.9999C17.5388 25.9999 23.4258 24.3983 23.4258 21.4296C23.4258 19.7175 21.3391 18.285 17.9548 17.5039Z"
                  fill="white" />
              </svg>

              <p>{!! ucwords($vcard->location) !!}</p>
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
    <div class="bottom-img">
      <img src="{{ asset('assets/img/vcard38/bottom-img.png') }}" alt="img" class="w-100 h-100" />
    </div>
    {{-- sticky buttons --}}
    <div class="position-relative">
      <div class="sticky-btn btn-section @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
        <div class="fixed-btn-section">
          <div class="architect-bars-btn bars-btn @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') vcard-bars-btn-left @endif">
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
                      class="vcard38-sticky-btn vcard38-btn-group d-flex justify-content-center align-items-center rounded-0 text-decoration-none py-1 rounded-pill justify-content share-wp-btn">
                      <i class="fa-solid fa-paper-plane"></i> </a>
                  </div>
                </div>
              @endif
              @if (empty($vcard->hide_stickybar))
                <div class="{{ isset($vcard->whatsapp_share) ? 'vcard38-btn-group' : 'stickyIcon' }}">
                  <button type="button" class="vcard38-btn-group vcard38-share vcard38-sticky-btn mb-3"><i
                      class="fas fa-share-alt fs-4 pt-1"></i></button>
                  @if (!empty($vcard->enable_download_qr_code))
                    <a type="button"
                      class="vcard38-btn-group vcard38-sticky-btn d-flex justify-content-center no-hover align-items-center text-decoration-none px-2 mb-3 py-2"
                      id="qr-code-btn" download="qr_code.png"><i class="fa-solid fa-qrcode fs-4"></i></a>
                  @endif
                </div>
              @endif
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
              class="text-center text-decoration-none text-black fw-5" target="_blank">
              <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
            </a>
          @else
            <div class="text-center">
              <small class="text-black fw-5">{{ __('messages.made_by') }}
                {{ $setting['app_name'] }}</small>
            </div>
          @endif
        @endif
      @else
        @if ($vcard->made_by)
          <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
            class="text-center text-decoration-none text-black fw-5" target="_blank">
            <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
          </a>
        @else
          <div class="text-center">
            <small class="text-black fw-5">{{ __('messages.made_by') }}
              {{ $setting['app_name'] }}</small>
          </div>
        @endif
      @endif
      @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
        <div>
          <a class="text-decoration-none text-black fw-5 cursor-pointer terms-policies-btn"
            href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"><small>{!! __('messages.vcard.term_policy') !!}</small></a>
        </div>
      @endif
    </div>

    {{-- add to contact --}}
    @if ($vcard->enable_contact)
      <div class="w-100 d-flex justify-content-center sticky-vcard-div" style="bottom: 60px">
        <div class="">
          @if ($contactRequest == 1)
            <a href="{{ Auth::check() ? route('add-contact', $vcard->id) : 'javascript:void(0);' }}"
              class="add-contact-btn d-flex justify-content-center ms-0 align-items-center text-decoration-none justify-content-center {{ Auth::check() ? 'auth-contact-btn' : 'ask-contact-detail-form' }}"
              data-action="{{ Auth::check() ? route('contact-request.store') : 'show-modal' }}" type="submit">
              <svg class="svg-inline--fa fa-address-book" aria-hidden="true" focusable="false" data-prefix="fas"
                data-icon="address-book" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                data-fa-i2svg="">
                <path fill="currentColor"
                  d="M384 0H96C60.65 0 32 28.65 32 64v384c0 35.35 28.65 64 64 64h288c35.35 0 64-28.65 64-64V64C448 28.65 419.3 0 384 0zM240 128c35.35 0 64 28.65 64 64s-28.65 64-64 64c-35.34 0-64-28.65-64-64S204.7 128 240 128zM336 384h-192C135.2 384 128 376.8 128 368C128 323.8 163.8 288 208 288h64c44.18 0 80 35.82 80 80C352 376.8 344.8 384 336 384zM496 64H480v96h16C504.8 160 512 152.8 512 144v-64C512 71.16 504.8 64 496 64zM496 192H480v96h16C504.8 288 512 280.8 512 272v-64C512 199.2 504.8 192 496 192zM496 320H480v96h16c8.836 0 16-7.164 16-16v-64C512 327.2 504.8 320 496 320z">
                </path>
              </svg>
              {{ __('messages.setting.add_contact') }}
            </a>
          @else
            <a href="{{ route('add-contact', $vcard->id) }}"
              class="add-contact-btn d-flex justify-content-center ms-0 align-items-center text-decoration-none justify-content-center"
              type="submit">
              <svg class="svg-inline--fa fa-address-book" aria-hidden="true" focusable="false" data-prefix="fas"
                data-icon="address-book" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                data-fa-i2svg="">
                <path fill="currentColor"
                  d="M384 0H96C60.65 0 32 28.65 32 64v384c0 35.35 28.65 64 64 64h288c35.35 0 64-28.65 64-64V64C448 28.65 419.3 0 384 0zM240 128c35.35 0 64 28.65 64 64s-28.65 64-64 64c-35.34 0-64-28.65-64-64S204.7 128 240 128zM336 384h-192C135.2 384 128 376.8 128 368C128 323.8 163.8 288 208 288h64c44.18 0 80 35.82 80 80C352 376.8 344.8 384 336 384zM496 64H480v96h16C504.8 160 512 152.8 512 144v-64C512 71.16 504.8 64 496 64zM496 192H480v96h16C504.8 288 512 280.8 512 272v-64C512 199.2 504.8 192 496 192zM496 320H480v96h16c8.836 0 16-7.164 16-16v-64C512 327.2 504.8 320 496 320z">
                </path>
              </svg>
              {{ __('messages.setting.add_contact') }}
            </a>
          @endif
        </div>
      </div>
      @include('vcardTemplates.contact-request')
    @endif

    {{-- share modal code --}}
    <div id="vcard38-shareModel" class="modal fade" role="dialog">
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
                <div class="col-2 mb-3">
                  <i class="fab fa-facebook fa-2x" style="color: #1B95E0"></i>

                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_facebook') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
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
                <div class="col-2 mb-3">

                  <span class="fa-2x"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                      <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                      <path
                        d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                    </svg></span>

                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_twitter') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
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
                <div class="col-2 mb-3">
                  <i class="fab fa-linkedin fa-2x" style="color: #1B95E0"></i>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_linkedin') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
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
                <div class="col-2 mb-3">
                  <i class="fas fa-envelope fa-2x" style="color: #191a19  "></i>
                </div>
                <div class="col-9 p-1 mb-3">
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
                <div class="col-2 mb-3">
                  <i class="fab fa-pinterest fa-2x" style="color: #bd081c"></i>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_pinterest') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
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
                <div class="col-2 mb-3">
                  <i class="fab fa-reddit fa-2x" style="color: #ff4500"></i>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_reddit') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
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
                <div class="col-2 mb-3">
                  <i class="fab fa-whatsapp fa-2x" style="color: limegreen"></i>
                </div>
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_whatsapp') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
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
                <div class="col-2 mb-3">
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
                <div class="col-9 p-1 mb-3">
                  <p class="align-items-center text-dark fw-bolder">
                    {{ __('messages.social.Share_on_snapchat') }}</p>
                </div>
                <div class="col-1 p-1 mb-3">
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
      arrows: true,
      infinite: true,
      dots: true,
      slidesToShow: 1,
      autoplay: true,
      prevArrow: $('.testinomial-prev'),
      nextArrow: $('.testinomial-next'),
      responsive: [{
        breakpoint: 575,
        settings: {
          dots: false,
        },
      }, ],
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
      rtl: isRtl,
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
  let userlanguage = "{{ getLanguage($vcard->default_language) }}";
  let isRtl = "{{ getLocalLanguage() == 'ar' || getLocalLanguage() == 'fa' ? 'true' : 'false' }}" === "true";
</script>
<script>
  const qrCodeThirtysix = document.getElementById("qr-code-thirtyeight");
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

</html>
