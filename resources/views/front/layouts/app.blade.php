<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
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
    @yield('title') | {{ getAppName() }}
    <meta name="description" content="">
    <meta name="keywords" content="">
  @endif

  @if (!empty(getAppLogo()))
    <meta property="og:image" content="{{ getAppLogo() }}" />
  @endif

  <style>
    @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa')
      .accordion-button::after {
        margin-right: auto !important;
        margin-left: 0 !important;
      }
    @endif
    .article-content img {
      max-width: 100%;
      border-radius: 0.5rem;
      margin: 2rem 0;
    }

    .article-content iframe {
      border-radius: 0.5rem;
      margin: 2rem 0;
      max-width: 100%;
      height: auto;
    }
  </style>

  {{--    <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png"> --}}

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="{{ mix('assets/css/public.css') }}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
  {{--    <link href="{{ asset('assets/css/front-custom.css') }}" rel="stylesheet" type="text/css"> --}}
  <link href="{{ asset('assets/css/front/front-custom.css') }}" rel="stylesheet" type="text/css">

  <script src="{{ mix('assets/js/front-third-party.js') }}"></script>
  <script src="{{ asset('messages.js?$mixID') }}"></script>

  <style>
    .back-to-top {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #007bff;
      color: white;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      font-size: 20px;
      z-index: 1000;
      transition: opacity 0.3s;
    }

    .back-to-top:hover {
      background-color: #0056b3;
    }
  </style>

  @php
    $langSession = Session::get('languageName');
    $frontLanguage = !isset($langSession) ? getSuperAdminSettingValue('default_language') : $langSession;
  @endphp
  <script>
    let frontLanguage = "{{ $frontLanguage }}"
    Lang.setLocale(frontLanguage)
  </script>
  <script src="{{ mix('assets/js/front-pages.js') }}"></script>

  @if (!empty($setting['custom_css']))
    <style>
      {!! $setting['custom_css'] !!}
    </style>
  @endif

  {!! getSuperAdminSettingValue('extra_js_front') !!}
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
  <!--google analytics code-->
  @if (!empty($metas['google_analytics']))
    {!! $metas['google_analytics'] !!}
  @endif
  @livewireStyles()
  <link rel="stylesheet" type="text/css"
    href="{{ asset('vendor/rappasoft/livewire-tables/css/laravel-livewire-tables.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('vendor/rappasoft/livewire-tables/css/laravel-livewire-tables-thirdparty.min.css') }}">
</head>

<body data-bs-offset="71">
  @livewireScripts()
  <script src="{{ asset('vendor/rappasoft/livewire-tables/js/laravel-livewire-tables.min.js') }}"></script>
  <script src="{{ asset('vendor/rappasoft/livewire-tables/js/laravel-livewire-tables-thirdparty.min.js') }}"></script>
  <!-- start header section -->
  @include('front.layouts.header')
  @yield('content')
  @include('front.layouts.footer')

  <!-- Back to Top Button -->
  <a href="#" id="back-to-top" class="back-to-top" style="display: none;">
    <i class="fas fa-arrow-up"></i>
  </a>

  <script>
    // Back to Top functionality
    window.addEventListener('scroll', function() {
      const backToTop = document.getElementById('back-to-top');
      if (backToTop) {
        if (window.pageYOffset > 300) {
          backToTop.style.display = 'flex';
        } else {
          backToTop.style.display = 'none';
        }
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      const backToTop = document.getElementById('back-to-top');
      if (backToTop) {
        backToTop.addEventListener('click', function(e) {
          e.preventDefault();
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        });
      }
    });
  </script>

</body>

</html>
