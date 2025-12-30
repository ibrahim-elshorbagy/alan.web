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
  <link rel="stylesheet" href="{{ mix('assets/css/vcard27.css') }}">
  {{-- google font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
  @if (checkFeature('custom-fonts') && $vcard->font_family)
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family={{ $vcard->font_family }}">
  @endif
  {{-- @if ($vcard->font_family || $vcard->font_size || $vcard->custom_css)
        <style>
            @if (checkFeature('custom-fonts'))
                @if ($vcard->font_family)
                    body, body *, button, h1, h2, h3, h4, h5, h6, p, div, span, a, input, textarea, select, label, li, ul, ol, table, th, td, blockquote, strong, b, em, i {
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
    @endif --}}
</head>

<body>
  <div class="vcard-tewntyseven position-fixed top-0 left-0 right-0 bottom-0 w-100 h-100">
    <div class="bg-animation position-absolute top-0 h-50 w-100">
      <div class="bg-shape vector-img1">
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 288 288">
          <linearGradient id="PSgrad_0" x1="70.711%" x2="0%" y1="70.711%" y2="0%">
            <stop offset="0%" stop-color="rgb(95,54,152)" stop-opacity="1"></stop>
            <stop offset="100%" stop-color="rgb(247,109,138)" stop-opacity="1"></stop>
          </linearGradient>
          <path class="path path1">
            <animate repeatCount="indefinite" attributeName="d" dur="5s"
              values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	">
            </animate>
          </path>
        </svg>
        <div class="position-absolute start-50 top-50 translate-middle">
          <img src="{{ asset('assets/img/vcard27/vector1.svg') }}" alt="bg-img" />
        </div>
      </div>
      <div class="bg-shape vector-img2">
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 288 288">
          <linearGradient id="PSgrad_0" x1="70.711%" x2="0%" y1="70.711%" y2="0%">
            <stop offset="0%" stop-color="rgb(95,54,152)" stop-opacity="1"></stop>
            <stop offset="100%" stop-color="rgb(247,109,138)" stop-opacity="1"></stop>
          </linearGradient>
          <path class="path path1">
            <animate repeatCount="indefinite" attributeName="d" dur="5s"
              values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	">
            </animate>
          </path>
        </svg>
        <div class="position-absolute start-50 top-50 translate-middle">
          <img src="{{ asset('assets/img/vcard27/vector2.png') }}" alt="bg-img" />
        </div>
      </div>
      <div class="bg-shape vector-img3">
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 288 288">
          <linearGradient id="PSgrad_0" x1="70.711%" x2="0%" y1="70.711%" y2="0%">
            <stop offset="0%" stop-color="rgb(95,54,152)" stop-opacity="1"></stop>
            <stop offset="100%" stop-color="rgb(247,109,138)" stop-opacity="1"></stop>
          </linearGradient>
          <path class="path path1">
            <animate repeatCount="indefinite" attributeName="d" dur="5s"
              values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	">
            </animate>
          </path>
        </svg>
        <div class="position-absolute start-50 top-50 translate-middle">
          <img src="{{ asset('assets/img/vcard27/heart-img.png') }}" alt="bg-img" />
        </div>
      </div>
      <div class="bg-shape vector-img4">
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 288 288">
          <linearGradient id="PSgrad_0" x1="70.711%" x2="0%" y1="70.711%" y2="0%">
            <stop offset="0%" stop-color="rgb(95,54,152)" stop-opacity="1"></stop>
            <stop offset="100%" stop-color="rgb(247,109,138)" stop-opacity="1"></stop>
          </linearGradient>
          <path class="path path1">
            <animate repeatCount="indefinite" attributeName="d" dur="5s"
              values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	">
            </animate>
          </path>
        </svg>
        <div class="position-absolute start-50 top-50 translate-middle">
          <img src="{{ asset('assets/img/vcard27/vector5.png') }}" alt="bg-img" />
        </div>
      </div>
      <div class="bg-shape vector-img5">
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 288 288">
          <linearGradient id="PSgrad_0" x1="70.711%" x2="0%" y1="70.711%" y2="0%">
            <stop offset="0%" stop-color="rgb(95,54,152)" stop-opacity="1"></stop>
            <stop offset="100%" stop-color="rgb(247,109,138)" stop-opacity="1"></stop>
          </linearGradient>
          <path class="path path1">
            <animate repeatCount="indefinite" attributeName="d" dur="5s"
              values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	">
            </animate>
          </path>
        </svg>
        <div class="position-absolute start-50 top-50 translate-middle">
          <img src="{{ asset('assets/img/vcard27/vector6.png') }}" alt="bg-img" />
        </div>
      </div>
      <div class="bg-shape vector-img6">
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 288 288">
          <linearGradient id="PSgrad_0" x1="70.711%" x2="0%" y1="70.711%" y2="0%">
            <stop offset="0%" stop-color="rgb(95,54,152)" stop-opacity="1"></stop>
            <stop offset="100%" stop-color="rgb(247,109,138)" stop-opacity="1"></stop>
          </linearGradient>
          <path class="path path1">
            <animate repeatCount="indefinite" attributeName="d" dur="5s"
              values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	">
            </animate>
          </path>
        </svg>
        <div class="position-absolute start-50 top-50 translate-middle">
          <img src="{{ asset('assets/img/vcard27/vector7.png') }}" alt="cat-img" />
        </div>
      </div>
      <div class="cat-img bg-vector-img">
        <img src="{{ asset('assets/img/vcard27/cat-img.png') }}" alt="cat-img" />
      </div>
      <div class="frog-img bg-vector-img">
        <img src="{{ asset('assets/img/vcard27/vector3.png') }}" alt="cat-img" />
      </div>
      <div class="rabbit-img bg-vector-img">
        <img src="{{ asset('assets/img/vcard27/vector4.png') }}" alt="cat-img" />
      </div>
      <div class="bag-img bg-vector-img">
        <img src="{{ asset('assets/img/vcard27/vector-bag.png') }}" alt="cat-img" />
      </div>
    </div>
  </div>
  <div class="container p-0">
    <div class="vcard-twentyseven main-content w-100 mx-auto content-blur allSection collapse show">
      <div class="vcard-one__product py-3 mt-0">
        <div class="d-flex align-items-center gap-3 px-30 mb-5 justify-content-between"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div>
            <h4 class="product-heading mb-0">{{ __('messages.vcard.products') }}</h4>
          </div>
          <div class="text-center">
            <a class="back-btn text-decoration-none d-block text-white" href="{{ $vcardUrl }}"
              role="button">{{ __('messages.common.back') }}</a>
          </div>
        </div>
        <div class="px-30">
          <div class="product-slider">
            @foreach ($vcard->products as $product)
              <div>
                <div class="product-card card mb-3">
                  <div class="product-img card-img">
                    <a @if ($product->product_url) href="{{ $product->product_url }}" @endif target="_blank"
                      class="text-decoration-none fs-6">
                      <div
                        class=" {{ $product->media->count() < 2 ? 'd-flex justify-content-center' : '' }} product-img-slider overflow-hidden">
                        @foreach ($product->media as $media)
                          <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}"
                            class="text-center object-fit-contain w-100" height="208px" loading="lazy">
                        @endforeach
                      </div>
                    </a>
                  </div>
                  <div class="card-body card-margin p-3">
                    <div class="product-desc d-flex flex-column gap-2"
                      @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                      <h3 class="text-black fs-18 fw-5 mb-0 me-2">{{ $product->name }}</h3>

                      <p class="fs-14 text-dark mb-0">{{ $product->description }}</p>
                      <div class="product-amount text-primary fw-bold fs-18">
                        @if ($product->currency_id && $product->price)
                          <span
                            class="fs-18 fw-6 text-primary  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                        @elseif($product->price)
                          <span
                            class="fs-18 fw-6 text-primary  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                        @endif
                      </div>
                      @if (!empty($product->price))
                        <div class="text-center">
                          <button class="buy-product"
                            data-id="{{ $product->id }}">{{ __('messages.subscription.buy_now') }}</button>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
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
      // autoplay: true,/
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
  <script src="{{ asset('messages.js?$mixID') }}"></script>
  <script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
  <script src="{{ mix('assets/js/custom/custom.js') }}"></script>
  <script src="{{ mix('assets/js/vcards/vcard-view.js') }}"></script>
  <script src="{{ mix('assets/js/lightbox.js') }}"></script>
</body>

</html>
