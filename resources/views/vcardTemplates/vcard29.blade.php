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
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/slick-theme.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/custom.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
  <link rel="stylesheet" href="{{ mix('assets/css/vcard29.css') }}">
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
  <div>
    @for ($i = 0; $i < 20; $i++)
      <div class="snowflake">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="19" viewBox="0 0 22 19" fill="none">
          <path
            d="M2.4375 0C4.0875 0 5.7375 0 7.4375 0C7.4375 0.403333 7.4375 0.806667 7.4375 1.22222C7.85 1.22222 8.2625 1.22222 8.6875 1.22222C8.6875 1.62556 8.6875 2.02889 8.6875 2.44444C9.1 2.44444 9.5125 2.44444 9.9375 2.44444C9.9375 2.84778 9.9375 3.25111 9.9375 3.66667C10.35 3.66667 10.7625 3.66667 11.1875 3.66667C11.1875 3.26333 11.1875 2.86 11.1875 2.44444C11.6 2.44444 12.0125 2.44444 12.4375 2.44444C12.4375 2.04111 12.4375 1.63778 12.4375 1.22222C12.85 1.22222 13.2625 1.22222 13.6875 1.22222C13.6875 0.818889 13.6875 0.415556 13.6875 0C15.3375 0 16.9875 0 18.6875 0C18.6875 0.403333 18.6875 0.806667 18.6875 1.22222C19.1 1.22222 19.5125 1.22222 19.9375 1.22222C19.9375 1.62556 19.9375 2.02889 19.9375 2.44444C20.3294 2.44444 20.7212 2.44444 21.125 2.44444C21.125 4.86444 21.125 7.28445 21.125 9.77778C20.7331 9.77778 20.3413 9.77778 19.9375 9.77778C19.9375 10.5844 19.9375 11.3911 19.9375 12.2222C19.525 12.2222 19.1125 12.2222 18.6875 12.2222C18.6875 12.6256 18.6875 13.0289 18.6875 13.4444C18.275 13.4444 17.8625 13.4444 17.4375 13.4444C17.4375 13.8478 17.4375 14.2511 17.4375 14.6667C17.025 14.6667 16.6125 14.6667 16.1875 14.6667C16.1875 15.07 16.1875 15.4733 16.1875 15.8889C15.775 15.8889 15.3625 15.8889 14.9375 15.8889C14.9375 16.2922 14.9375 16.6956 14.9375 17.1111C14.1125 17.1111 13.2875 17.1111 12.4375 17.1111C12.4375 17.5144 12.4375 17.9178 12.4375 18.3333C11.2 18.3333 9.9625 18.3333 8.6875 18.3333C8.6875 17.93 8.6875 17.5267 8.6875 17.1111C7.8625 17.1111 7.0375 17.1111 6.1875 17.1111C6.1875 16.7078 6.1875 16.3044 6.1875 15.8889C5.775 15.8889 5.3625 15.8889 4.9375 15.8889C4.9375 15.4856 4.9375 15.0822 4.9375 14.6667C4.525 14.6667 4.1125 14.6667 3.6875 14.6667C3.6875 14.2633 3.6875 13.86 3.6875 13.4444C3.275 13.4444 2.8625 13.4444 2.4375 13.4444C2.4375 12.6378 2.4375 11.8311 2.4375 11C2.025 11 1.6125 11 1.1875 11C1.1875 10.1933 1.1875 9.38667 1.1875 8.55556C0.795625 8.55556 0.40375 8.55556 0 8.55556C0 6.53889 0 4.52222 0 2.44444C0.391875 2.44444 0.78375 2.44444 1.1875 2.44444C1.1875 2.04111 1.1875 1.63778 1.1875 1.22222C1.6 1.22222 2.0125 1.22222 2.4375 1.22222C2.4375 0.818889 2.4375 0.415556 2.4375 0Z"
            fill="#FF9496" />
          <path
            d="M15 1.28345C15.8044 1.28345 16.6087 1.28345 17.4375 1.28345C17.5 2.26122 17.5 2.26122 17.4375 2.38345C17.491 2.38297 17.491 2.38297 17.5455 2.38248C17.7061 2.38121 17.8667 2.38041 18.0273 2.37963C18.0835 2.37912 18.1396 2.3786 18.1974 2.37808C18.2508 2.37788 18.3041 2.37768 18.3591 2.37748C18.4086 2.37716 18.458 2.37684 18.5089 2.37651C18.625 2.38345 18.625 2.38345 18.6875 2.44456C18.6875 2.84789 18.6875 3.25122 18.6875 3.66678C17.45 3.66678 16.2125 3.66678 14.9375 3.66678C14.9375 2.44456 14.9375 2.44456 15 2.20011C15 1.89761 15 1.59511 15 1.28345Z"
            fill="#F7A8AA" />
          <path
            d="M15.0625 1.22217C16.6712 1.22217 18.28 1.22217 19.9375 1.22217C19.9375 2.02883 19.9375 2.8355 19.9375 3.66661C19.525 3.66661 19.1125 3.66661 18.6875 3.66661C18.6669 3.26328 18.6463 2.85995 18.625 2.44439C18.2331 2.42422 17.8413 2.40406 17.4375 2.38328C17.4375 2.02028 17.4375 1.65728 17.4375 1.28328C17.3394 1.2884 17.2412 1.29352 17.1401 1.2988C16.4416 1.33276 15.759 1.36121 15.0625 1.28328C15.0625 1.26311 15.0625 1.24295 15.0625 1.22217Z"
            fill="#FF868A" />
          <path
            d="M11.1875 2.44458C11.6 2.44458 12.0125 2.44458 12.4375 2.44458C12.4375 3.25125 12.4375 4.05791 12.4375 4.88902C11.6125 4.88902 10.7875 4.88902 9.9375 4.88902C9.9375 4.48569 9.9375 4.08236 9.9375 3.6668C10.35 3.6668 10.7625 3.6668 11.1875 3.6668C11.1875 3.26347 11.1875 2.86014 11.1875 2.44458Z"
            fill="#FF868A" />
          <path
            d="M18.6875 3.66675C19.1 3.66675 19.5125 3.66675 19.9375 3.66675C19.9375 4.47341 19.9375 5.28008 19.9375 6.11119C19.525 6.11119 19.1125 6.11119 18.6875 6.11119C18.6875 5.30453 18.6875 4.49786 18.6875 3.66675Z"
            fill="#FF868A" />
          <path
            d="M16.1875 2.44458C17.0125 2.44458 17.8375 2.44458 18.6875 2.44458C18.6875 2.84791 18.6875 3.25125 18.6875 3.6668C17.8625 3.6668 17.0375 3.6668 16.1875 3.6668C16.1875 3.26347 16.1875 2.86014 16.1875 2.44458Z"
            fill="#FDEAF2" />
          <path
            d="M18.6875 9.77783C19.1 9.77783 19.5125 9.77783 19.9375 9.77783C19.9375 10.1812 19.9375 10.5845 19.9375 11.0001C19.525 11.0001 19.1125 11.0001 18.6875 11.0001C18.6875 10.5967 18.6875 10.1934 18.6875 9.77783Z"
            fill="#F28F92" />
          <path
            d="M9.9375 4.88892C10.35 4.88892 10.7625 4.88892 11.1875 4.88892C11.1875 5.29225 11.1875 5.69558 11.1875 6.11114C10.775 6.11114 10.3625 6.11114 9.9375 6.11114C9.9375 5.7078 9.9375 5.30447 9.9375 4.88892Z"
            fill="#FF868A" />
          <path
            d="M18.6875 3.66675C19.1 3.66675 19.5125 3.66675 19.9375 3.66675C19.9375 4.07008 19.9375 4.47341 19.9375 4.88897C19.525 4.88897 19.1125 4.88897 18.6875 4.88897C18.6875 4.48564 18.6875 4.0823 18.6875 3.66675Z"
            fill="#FDC2C4" />
          <path
            d="M17.4375 3.66675C17.85 3.66675 18.2625 3.66675 18.6875 3.66675C18.6875 4.07008 18.6875 4.47341 18.6875 4.88897C18.275 4.88897 17.8625 4.88897 17.4375 4.88897C17.4375 4.48564 17.4375 4.0823 17.4375 3.66675Z"
            fill="#F7A8AA" />
          <path
            d="M18.6875 2.44458C19.1 2.44458 19.5125 2.44458 19.9375 2.44458C19.9375 2.84791 19.9375 3.25125 19.9375 3.6668C19.525 3.6668 19.1125 3.6668 18.6875 3.6668C18.6875 3.26347 18.6875 2.86014 18.6875 2.44458Z"
            fill="#FF868A" />
          <path
            d="M16.1875 2.44458C16.6 2.44458 17.0125 2.44458 17.4375 2.44458C17.4375 2.84791 17.4375 3.25125 17.4375 3.6668C17.025 3.6668 16.6125 3.6668 16.1875 3.6668C16.1875 3.26347 16.1875 2.86014 16.1875 2.44458Z"
            fill="#FDC2C4" />
          <path
            d="M19.9375 2.44458C20.3294 2.44458 20.7212 2.44458 21.125 2.44458C21.125 4.86458 21.125 7.28458 21.125 9.77791C20.7331 9.77791 20.3413 9.77791 19.9375 9.77791C19.9375 7.35791 19.9375 4.93791 19.9375 2.44458Z"
            fill="#C82D4D" />
          <path
            d="M0 2.44458C0.391875 2.44458 0.78375 2.44458 1.1875 2.44458C1.1875 4.46125 1.1875 6.47791 1.1875 8.55569C0.795625 8.55569 0.40375 8.55569 0 8.55569C0 6.53902 0 4.52236 0 2.44458Z"
            fill="#C82D4D" />
          <path
            d="M18.6875 9.77783C19.1 9.77783 19.5125 9.77783 19.9375 9.77783C19.9375 10.5845 19.9375 11.3912 19.9375 12.2223C19.525 12.2223 19.1125 12.2223 18.6875 12.2223C18.6875 12.6256 18.6875 13.0289 18.6875 13.4445C18.275 13.4445 17.8625 13.4445 17.4375 13.4445C17.4375 13.8478 17.4375 14.2512 17.4375 14.6667C17.025 14.6667 16.6125 14.6667 16.1875 14.6667C16.1875 14.2432 16.1875 13.8197 16.1875 13.3834C16.6 13.3834 17.0125 13.3834 17.4375 13.3834C17.4375 12.9801 17.4375 12.5767 17.4375 12.1612C17.85 12.1612 18.2625 12.1612 18.6875 12.1612C18.6875 11.3747 18.6875 10.5882 18.6875 9.77783Z"
            fill="#C82D4D" />
          <path
            d="M13.6875 0C15.3375 0 16.9875 0 18.6875 0C18.6875 0.403333 18.6875 0.806667 18.6875 1.22222C17.0375 1.22222 15.3875 1.22222 13.6875 1.22222C13.6875 0.818889 13.6875 0.415556 13.6875 0Z"
            fill="#C82D4D" />
          <path
            d="M2.4375 0C4.0875 0 5.7375 0 7.4375 0C7.4375 0.403333 7.4375 0.806667 7.4375 1.22222C5.7875 1.22222 4.1375 1.22222 2.4375 1.22222C2.4375 0.818889 2.4375 0.415556 2.4375 0Z"
            fill="#C82D4D" />
          <path
            d="M8.6875 17.1111C9.925 17.1111 11.1625 17.1111 12.4375 17.1111C12.4375 17.5144 12.4375 17.9178 12.4375 18.3333C11.2 18.3333 9.9625 18.3333 8.6875 18.3333C8.6875 17.93 8.6875 17.5266 8.6875 17.1111Z"
            fill="#C82D4D" />
          <path
            d="M12.4375 15.8889C13.2625 15.8889 14.0875 15.8889 14.9375 15.8889C14.9375 16.2922 14.9375 16.6956 14.9375 17.1111C14.1125 17.1111 13.2875 17.1111 12.4375 17.1111C12.4375 16.7078 12.4375 16.3045 12.4375 15.8889Z"
            fill="#C82D4D" />
          <path
            d="M6.1875 15.8889C7.0125 15.8889 7.8375 15.8889 8.6875 15.8889C8.6875 16.2922 8.6875 16.6956 8.6875 17.1111C7.8625 17.1111 7.0375 17.1111 6.1875 17.1111C6.1875 16.7078 6.1875 16.3045 6.1875 15.8889Z"
            fill="#C82D4D" />
          <path
            d="M2.4375 11C2.85 11 3.2625 11 3.6875 11C3.6875 11.8067 3.6875 12.6133 3.6875 13.4444C3.275 13.4444 2.8625 13.4444 2.4375 13.4444C2.4375 12.6378 2.4375 11.8311 2.4375 11Z"
            fill="#C82D4D" />
          <path
            d="M1.1875 8.55566C1.6 8.55566 2.0125 8.55566 2.4375 8.55566C2.4375 9.36233 2.4375 10.169 2.4375 11.0001C2.025 11.0001 1.6125 11.0001 1.1875 11.0001C1.1875 10.1934 1.1875 9.38678 1.1875 8.55566Z"
            fill="#C82D4D" />
          <path
            d="M14.9375 14.6667C15.35 14.6667 15.7625 14.6667 16.1875 14.6667C16.1875 15.0701 16.1875 15.4734 16.1875 15.889C15.775 15.889 15.3625 15.889 14.9375 15.889C14.9375 15.4856 14.9375 15.0823 14.9375 14.6667Z"
            fill="#C82D4D" />
          <path
            d="M4.9375 14.6667C5.35 14.6667 5.7625 14.6667 6.1875 14.6667C6.1875 15.0701 6.1875 15.4734 6.1875 15.889C5.775 15.889 5.3625 15.889 4.9375 15.889C4.9375 15.4856 4.9375 15.0823 4.9375 14.6667Z"
            fill="#C82D4D" />
          <path
            d="M3.6875 13.4446C4.1 13.4446 4.5125 13.4446 4.9375 13.4446C4.9375 13.8479 4.9375 14.2512 4.9375 14.6668C4.525 14.6668 4.1125 14.6668 3.6875 14.6668C3.6875 14.2635 3.6875 13.8601 3.6875 13.4446Z"
            fill="#C82D4D" />
          <path
            d="M9.9375 3.66675C10.35 3.66675 10.7625 3.66675 11.1875 3.66675C11.1875 4.07008 11.1875 4.47341 11.1875 4.88897C10.775 4.88897 10.3625 4.88897 9.9375 4.88897C9.9375 4.48564 9.9375 4.0823 9.9375 3.66675Z"
            fill="#C82D4D" />
          <path
            d="M11.1875 2.44458C11.6 2.44458 12.0125 2.44458 12.4375 2.44458C12.4375 2.84791 12.4375 3.25125 12.4375 3.6668C12.025 3.6668 11.6125 3.6668 11.1875 3.6668C11.1875 3.26347 11.1875 2.86014 11.1875 2.44458Z"
            fill="#C82D4D" />
          <path
            d="M8.6875 2.44458C9.1 2.44458 9.5125 2.44458 9.9375 2.44458C9.9375 2.84791 9.9375 3.25125 9.9375 3.6668C9.525 3.6668 9.1125 3.6668 8.6875 3.6668C8.6875 3.26347 8.6875 2.86014 8.6875 2.44458Z"
            fill="#C82D4D" />
          <path
            d="M18.6875 1.22217C19.1 1.22217 19.5125 1.22217 19.9375 1.22217C19.9375 1.6255 19.9375 2.02883 19.9375 2.44439C19.525 2.44439 19.1125 2.44439 18.6875 2.44439C18.6875 2.04106 18.6875 1.63772 18.6875 1.22217Z"
            fill="#C82D4D" />
          <path
            d="M12.4375 1.22217C12.85 1.22217 13.2625 1.22217 13.6875 1.22217C13.6875 1.6255 13.6875 2.02883 13.6875 2.44439C13.275 2.44439 12.8625 2.44439 12.4375 2.44439C12.4375 2.04106 12.4375 1.63772 12.4375 1.22217Z"
            fill="#C82D4D" />
          <path
            d="M7.4375 1.22217C7.85 1.22217 8.2625 1.22217 8.6875 1.22217C8.6875 1.6255 8.6875 2.02883 8.6875 2.44439C8.275 2.44439 7.8625 2.44439 7.4375 2.44439C7.4375 2.04106 7.4375 1.63772 7.4375 1.22217Z"
            fill="#C82D4D" />
          <path
            d="M1.1875 1.22217C1.6 1.22217 2.0125 1.22217 2.4375 1.22217C2.4375 1.6255 2.4375 2.02883 2.4375 2.44439C2.025 2.44439 1.6125 2.44439 1.1875 2.44439C1.1875 2.04106 1.1875 1.63772 1.1875 1.22217Z"
            fill="#C82D4D" />
        </svg>
      </div>
    @endfor
  </div>
  <div class="container p-0 position-relative z-index-2">
    @if (checkFeature('password'))
      @include('vcards.password')
    @endif
    <div class="main-content mx-auto w-100 overflow-hidden bg-green @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
      {{-- Pwa support --}}
      @if (isset($enable_pwa) && $enable_pwa == 1 && !isiOSDevice())
        <div class="mt-0">
          <div class="pwa-support d-flex align-items-center justify-content-center">
            <div>
              <h1 class="text-start pwa-heading">{{ __('messages.pwa.add_to_home_screen') }}</h1>
              <p class="text-start pwa-text text-dark">{{ __('messages.pwa.pwa_description') }} </p>
              <div class="text-end d-flex">
                <button id="installPwaBtn" class="pwa-install-button w-50 mb-1 btn">{{ __('messages.pwa.install') }}
                </button>
                <button
                  class="pwa-cancel-button w-50 ms-2 pwa-close btn btn-secondary mb-1">{{ __('messages.common.cancel') }}</button>
              </div>
            </div>
          </div>
        </div>
      @endif
      {{-- support banner --}}
      @if ((isset($managesection) && $managesection['banner']) || empty($managesection))
        @if (isset($banners->title))
          <div class="support-banner d-flex align-items-center justify-content-center">
            <button type="button" class="text-start banner-close"><i class="fa-solid fa-xmark"></i></button>
            <div class="">
              <h1 class="text-center support_heading">{{ $banners->title }}</h1>
              <p class="text-center text-dark support_text">{{ $banners->description }} </p>
              <div class="text-center mt-3">
                <a href="{{ $banners->url }}" class="act-now" target="_blank"
                  data-turbo="false">{{ $banners->banner_button }}</a>
              </div>
            </div>
          </div>
        @endif
      @endif
      <div class="banner-section position-relative">
        <div class="d-flex justify-content-end position-absolute top-0 end-0 mx-3 language-btn">
          @if ($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
            <div class="language pt-3">
              <ul class="text-decoration-none ps-0">
                <li class="dropdown1 dropdown lang-list">
                  <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown" role="button"
                    aria-haspopup="true" aria-expanded="false">
                    {{ strtoupper(getLanguageIsoCode($vcard->default_language)) }}
                  </a>
                  <ul class="dropdown-menu top-dropdown lang-hover-list top-100 mt-0">
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
          @elseif ($vcard->cover_type == 2)
            <div class="youtube-link-29">
              <iframe
                src="https://www.youtube.com/embed/{{ YoutubeID($vcard->youtube_link) }}?autoplay=1&mute=0&loop=1&playlist={{ YoutubeID($vcard->youtube_link) }}&controls=0&modestbranding=1&showinfo=0&rel=0"
                class="cover-video {{ $coverClass }}" frameborder="0" allow="autoplay; encrypted-media"
                allowfullscreen>
              </iframe>
            </div>
          @endif
        </div>


        <div class="overlay @if ($vcard->cover_type == 2) d-none @endif"></div>
      </div>
      {{-- profile section --}}
      <div class="main-section">
        <div class="profile-section  pt-40 pb-40 px-30 position-relative">
          <div class="profile-bg">
            <img src="{{ asset('assets/img/vcard29/profile-bg.png') }}" alt="images" class="h-100" />
          </div>
          <div
            class="card d-flex flex-column justify-content-center align-items-center gap-3 gap-sm-4 position-relative">
            <div class="card-img @if ($vcard->cover_type == 2) profile-top-margin @endif">
              <img src="{{ $vcard->profile_url }}" class="w-100 h-100 object-fit-cover" />
            </div>
            <div class="card-body p-0 text-center">
              <div class="profile-name @if ($vcard->cover_type == 2) margin-55 @endif">
                <h2 class="mb-0 fs-28">
                  {{ ucwords($vcard->first_name . ' ' . $vcard->last_name) }}
                  @if ($vcard->is_verified)
                    <i class="verification-icon bi-patch-check-fill text-blue"></i>
                  @endif
                </h2>
                <p class="fs-16 fw-5 text-primary text-decoration-underline mb-0">
                  {{ ucwords($vcard->company) }}</p>
                <p class="fs-14 text-gray-200 mb-0">{{ ucwords($vcard->occupation) }}</p>
                <p class="fs-14 text-gray-200 mb-0">{{ ucwords($vcard->job_title) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="main-section">
        <div class="profile-desc-section pt-50 pb-50 position-relative">
          <div class="profile-desc-bg img-1 vector-all">
            <img src="{{ asset('assets/img/vcard29/profile-desc-bg-1.png') }}" alt="images" class="h-100" />
          </div>
          <div class="profile-desc-bg img-2 vector-all text-end">
            <img src="{{ asset('assets/img/vcard29/profile-desc-bg-2.png') }}" alt="images" class="h-100" />
          </div>
          <div class="profile-desc px-30 fs-14 text-center">
            {!! $vcard->description !!}
          </div>
          {{-- social icons --}}
          @if (checkFeature('social_links') && getSocialLink($vcard))
            <div class="social-media-section px-30 pt-30">
              <div class="d-flex flex-wrap justify-content-center social-icons">
                {{-- <div
                                class="d-flex justify-content-center text-decoration-none flex-wrap text-primary bg-gray-100 rounded-pill">
                                --}}
                @foreach (getSocialLink($vcard) as $value)
                  <span class="social-icon d-flex justify-content-center align-items-center">
                    {!! $value !!}
                  </span>
                @endforeach
                {{--
                            </div> --}}
                {{-- <a href="" class="social-icon d-flex justify-content-center align-items-center">
                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.9704 25.4998C14.9704 22.5882 14.9704 19.6825 14.9704 16.7413C15.9436 16.7413 16.8934 16.7413 17.8667 16.7413C18.0543 15.5188 18.2361 14.3257 18.4237 13.0973C17.2628 13.0973 16.1254 13.0973 15.0114 13.0973C15.0114 12.0992 14.941 11.1365 15.029 10.1857C15.1052 9.35292 15.797 8.83319 16.6706 8.78594C17.1866 8.75641 17.7084 8.76823 18.2243 8.76823C18.3299 8.76823 18.4354 8.76823 18.5527 8.76823C18.5527 7.71696 18.5527 6.70113 18.5527 5.66168C17.2335 5.50222 15.9319 5.28961 14.6127 5.53175C12.6779 5.89202 11.3353 7.28583 11.1359 9.27023C11.0245 10.4042 11.0714 11.5499 11.048 12.6898C11.048 12.8138 11.048 12.9378 11.048 13.0973C9.97505 13.0973 8.93729 13.0973 7.88781 13.0973C7.88781 14.3257 7.88781 15.5188 7.88781 16.7413C8.94315 16.7413 9.97505 16.7413 11.0245 16.7413C11.0245 19.6766 11.0245 22.5823 11.0245 25.4939C6.61553 25.0097 0.969417 20.8873 0.529689 13.9064C0.0723718 6.71885 5.53673 0.877845 12.3203 0.51758C19.6432 0.127786 25.4652 6.00423 25.5062 13.0028C25.5414 19.9423 20.1826 24.8502 14.9704 25.4998Z"
                                        fill="white" />
                                </svg>
                            </a> --}}
              </div>
            </div>
          @endif
          {{-- custom link section --}}

          @if (checkFeature('custom-links') && $customLink->isNotEmpty())
            <div class="custom-link-section pt-40 position-relative">
              <div class="custom-link d-flex flex-wrap justify-content-center gap-2 w-100">
                @foreach ($customLink as $value)
                  @if ($value->show_as_button == 1)
                    <a href="{{ $value->link }}" @if ($value->open_new_tab == 1) target="_blank" @endif
                      style="
                                @if ($value->button_color) background-color: {{ $value->button_color }}; @endif
                                @if ($value->button_type === 'rounded') border-radius: 20px; @endif
                                @if ($value->button_type === 'square') border-radius: 0px; @endif"
                      class="d-flex justify-content-center position-relative align-items-center text-decoration-none
                                link-text
                                text-white font-primary btn">
                      {{ $value->link_name }}
                    </a>
                  @else
                    <a href="{{ $value->link }}" @if ($value->open_new_tab == 1) target="_blank" @endif
                      class="d-flex justify-content-center position-relative align-items-center text-decoration-none
                                link-text
                                text-white">
                      {{ $value->link_name }}
                    </a>
                  @endif
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>
      {{-- End custom link section --}}
      {{-- contact section --}}
      @php
        $hasContactData =
            $vcard->email ||
            $vcard->alternative_email ||
            $vcard->phone ||
            $vcard->alternative_phone ||
            $vcard->dob ||
            $vcard->location;
      @endphp
      @if (((isset($managesection) && $managesection['contact_list']) || empty($managesection)) && $hasContactData)
        <div class="main-section">
          <div class="contact-section pt-40 pb-40 px-30">
            <div class="contact-bg vector-all">
              <img src="{{ asset('assets/img/vcard29/contact-bg.png') }}" alt="bg-vector" />
            </div>
            <div class="section-heading">
              <h2 class="mb-0">{{ __('messages.contact_us.contact') }}</h2>
            </div>
            @if (getLanguage($vcard->default_language) != 'Arabic' && getLanguage($vcard->default_language) != 'Persian')
              <div class="row row-gap-20px">
                @if ($vcard->email)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/email.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <a href="mailto:{{ $vcard->email }}" class="text-primary fw-5 fs-14">{{ $vcard->email }}</a>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($vcard->alternative_email)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/email.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <a href="mailto:{{ $vcard->alternative_email }}"
                          class="text-primary fw-5 fs-14">{{ $vcard->alternative_email }}</a>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($vcard->phone)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/phone.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <a href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}" class="text-primary fw-5 fs-14"
                          dir="ltr">+{{ $vcard->region_code }}{{ $vcard->phone }}</a>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($vcard->alternative_phone)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/phone.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <a href="tel:+{{ $vcard->alternative_region_code }}{{ $vcard->alternative_phone }}"
                          class="text-primary fw-5 fs-14"
                          dir="ltr">+{{ $vcard->alternative_region_code }}{{ $vcard->alternative_phone }}</a>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($vcard->dob)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/dob.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <p class="mb-0 text-primary fw-5 fs-14"> {{ $vcard->dob }}</p>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($vcard->location)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/location.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <p class="mb-0 text-primary fw-5 fs-14"> {!! ucwords($vcard->location) !!}</p>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
            @endif
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian')
              <div class="row row-gap-20px" dir="rtl">
                @if ($vcard->email)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/email.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <a href="mailto:{{ $vcard->email }}" class="text-primary fw-5 fs-14">{{ $vcard->email }}</a>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($vcard->alternative_email)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/email.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <a href="mailto:{{ $vcard->alternative_email }}"
                          class="text-primary fw-5 fs-14">{{ $vcard->alternative_email }}</a>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($vcard->phone)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/phone.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <a href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}" class="text-primary fw-5 fs-14"
                          dir="ltr">+{{ $vcard->region_code }}{{ $vcard->phone }}</a>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($vcard->alternative_phone)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/phone.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <a href="tel:+{{ $vcard->alternative_region_code }}{{ $vcard->alternative_phone }}"
                          class="text-primary fw-5 fs-14"
                          dir="ltr">+{{ $vcard->alternative_region_code }}{{ $vcard->alternative_phone }}</a>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($vcard->dob)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/dob.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <p class="mb-0 text-primary fw-5 fs-14"> {{ $vcard->dob }}</p>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($vcard->location)
                  <div class="col-sm-6">
                    <div class="contact-box d-flex align-items-center">
                      <div class="contact-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/vcard29/location.svg') }}" />
                      </div>
                      <div class="contact-desc">
                        <p class="mb-0 text-primary fw-5 fs-14"> {!! ucwords($vcard->location) !!}</p>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
            @endif
          </div>
        </div>
      @endif
      {{-- our service --}}
      @if ((isset($managesection) && $managesection['services']) || empty($managesection))
        @if (checkFeature('services') && $vcard->services->count())
          <div class="main-section">
            <div class="our-services-section pt-40 pb-40">
              <div class="services-bg text-end vector-all">
                <img src="{{ asset('assets/img/vcard29/services-bg.png') }}" alt="bg-vector" />
              </div>
              <div class="section-heading">
                <h2 class="mb-0">{{ __('messages.vcard.our_service') }}</h2>
              </div>
              <div class="services">
                @if ($vcard->services_slider_view)
                  <div class="px-20">
                    <div class="services-slider-view row-gap-20px">
                      @foreach ($vcard->services as $service)
                        <div class="col-sm-6">
                          <div class="service-card text-start h-100">
                            <div class="card-img">
                              <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                                class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                                target="{{ $service->service_url ? '_blank' : '' }}">
                                <img src="{{ $service->service_icon }}" alt="branding" loading="lazy"
                                  class="h-100 w-100" />
                              </a>
                            </div>
                            <div class="card-body text-center">
                              <h3 class="card-title text-center mb-2"
                                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                {{ ucwords($service->name) }}
                              </h3>
                              <p class="mb-0 text-gray-200 {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}"
                                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
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
                    <div class="row row-gap-20px">
                      @foreach ($vcard->services as $service)
                        <div class="col-sm-6">
                          <div class="service-card text-start h-100 d-flex flex-column">
                            <div class="card-img">
                              <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                                class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                                target="{{ $service->service_url ? '_blank' : '' }}">
                                <img src="{{ $service->service_icon }}" alt="branding" loading="lazy"
                                  class="h-100 w-100" />
                              </a>
                            </div>
                            <div class="card-body text-center">
                              <h3 class="card-title text-primary text-center mb-2"
                                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                                {{ ucwords($service->name) }}
                              </h3>
                              <p class="mb-0 text-center text-gray-200 {{ \Illuminate\Support\Str::length($service->description) > 170 ? 'more' : '' }}"
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
            </div>
          </div>
        @endif
      @endif
      {{-- make appointment --}}
      @if ((isset($managesection) && $managesection['appointments']) || empty($managesection))
        @if (checkFeature('appointments') && $vcard->appointmentHours->count())
          <div class="main-section">
            <div class="appointment-section pt-40 pb-40 px-30">
              <div class="appointment-bg vector-all">
                <img src="{{ asset('assets/img/vcard29/appointment-bg.png') }}" alt="bg-vector" />
              </div>
              <div class="section-heading">
                <h2 class="mb-0">{{ __('messages.make_appointments') }}</h2>
              </div>
              <div class="appointment">
                <div class="row">
                  <div class="col-12">
                    <div class="position-relative">
                      {{ Form::text('date', null, [
                          'class' => 'date appoint-input form-control
                                                                                                                                                                                                                    appointment-input text-start',
                          'placeholder' => __('messages.form.pick_date'),
                          'id' => 'pickUpDate',
                      ]) }}
                    </div>
                  </div>
                </div>
                <div>
                  <div id="slotData" class="row ">
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="appoint-btn appointmentAdd btn btn-primary d-none">
                    {{ __('messages.make_appointments') }}
                  </button>
                </div>
              </div>
            </div>
          </div>
          @include('vcardTemplates.appointment')
        @endif
      @endif
      {{-- gallery --}}
      @if ((isset($managesection) && $managesection['galleries']) || empty($managesection))
        @if (checkFeature('gallery') && $vcard->gallery->count())
          <div class="main-section">
            <div class="gallery-section pt-40 pb-40 px-20">
              <div class="gallery-bg text-end vector-all">
                <img src="{{ asset('assets/img/vcard29/gallery-bg.png') }}" alt="bg-vector" />
              </div>
              <div class="section-heading">
                <h2 class="mb-0">{{ __('messages.plan.gallery') }}</h2>
              </div>
              <div class="gallery-slider">
                @foreach ($vcard->gallery as $file)
                  @php
                    $infoPath = pathinfo(public_path($file->gallery_image));
                    $extension = $infoPath['extension'];
                  @endphp
                  <div>
                    <div class="gallery-img">
                      <div class="expand-icon pe-none">
                        <i class="fas fa-expand text-primary"></i>
                      </div>
                      @if ($file->type == App\Models\Gallery::TYPE_IMAGE)
                        <a href="{{ $file->gallery_image }}" data-lightbox="gallery-images h1"><img
                            src="{{ $file->gallery_image }}" alt="profile" class="w-100 h-100"
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
                        <iframe src="https://www.youtube.com/embed/{{ YoutubeID($file->link) }}"
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
      {{-- product --}}
      @if ((isset($managesection) && $managesection['products']) || empty($managesection))
        @if (checkFeature('products') && $vcard->products->count())
          <div class="main-section">
            <div class="product-section pt-40 pb-40 px-20">
              <div class="product-bg vector-all">
                <img src="{{ asset('assets/img/vcard29/product-bg.png') }}" alt="bg-vector" />
              </div>
              <div class="section-heading">
                <h2 class="mb-0">{{ __('messages.plan.products') }}</h2>
              </div>
              <div class="product-slider">
                @foreach ($vcard->products as $product)
                  <div>
                    <div class="product-card card">
                      <div class="product-img card-img">
                        <a @if ($product->product_url) href="{{ $product->product_url }}" @endif
                          target="_blank" class="text-decoration-none fs-6 object-fit-cover"><img
                            src="{{ $product->product_icon }}" class="w-100 h-100 object-fit-contain"
                            loading="lazy"></a>
                      </div>
                      <div class="product-desc card-body">
                        <div class="d-flex justify-content-between align-items-center flex-column gap-1">
                          <h3 class="text-center mb-2 card-title" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                            {{ $product->name }}</h3>
                          <p class="amount mb-0 text-primary text-center">
                            @if ($product->currency_id && $product->price)
                              <span class="fw-6 text-primary"
                                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') style="direction: rtl; text-align: right; display: block;" @endif>{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                            @elseif($product->price)
                              <span class="fw-6 text-primary"
                                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') style="direction: rtl; text-align: right; display: block;" @endif>{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                            @endif
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="text-center">
                <a class="text-center view-more d-inline-flex gap-2 align-items-center"
                  href="{{ $vcardProductUrl }}">{{ __('messages.analytics.view_more') }}
                  <i class="fa-solid fa-arrow-right right-arrow-animation"></i></a>
              </div>
            </div>
          </div>
        @endif
      @endif
      {{-- testimonial --}}
      @if ((isset($managesection) && $managesection['testimonials']) || empty($managesection))
        @if (checkFeature('testimonials') && $vcard->testimonials->count())
          <div class="main-section">
            <div class="testimonial-section pt-40 pb-40 px-20">
              <div class="testimonial-bg-vector text-end vector-all">
                <img src="{{ asset('assets/img/vcard29/testimonial-bg-vector.png') }}" alt="bg-vector" />
              </div>
              <div class="section-heading">
                <h2 class="mb-0">{{ __('messages.plan.testimonials') }}</h2>
              </div>
              <div class="testimonial-slider">
                @foreach ($vcard->testimonials as $testimonial)
                  <div>
                    <div class="testimonial-card card">
                      <div class="testimonial-bg">
                        <img src="{{ asset('assets/img/vcard29/testimonial-bg.png') }}" alt="bg-img"
                          class="w-100" />
                      </div>
                      <div class="card-img testimonial-profile-img mb-20">
                        <img src="{{ $testimonial->image_url }}" class="w-100 h-100 object-fit-cover" />
                      </div>
                      <div class="card-body p-0 text-center">
                        <h3 class="text-primary mb-3 text-decoration-underline"
                          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                          {{ ucwords($testimonial->name) }}</h3>
                        <p class="desc mb-0 {{ \Illuminate\Support\Str::length($testimonial->description) > 80 ? 'more' : '' }}"
                          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                          "{!! $testimonial->description !!}"
                        </p>

                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        @endif
      @endif
      {{-- insta feed --}}
      @if ((isset($managesection) && $managesection['insta_embed']) || empty($managesection))
        @if (checkFeature('insta_embed') && $vcard->instagramEmbed->count())
          <div class="main-section">
            <div class="insta-feed-section position-relative pt-40 pb-40 px-30">
              <div class="insta-feed-bg vector-all">
                <img src="{{ asset('assets/img/vcard29/insta-feed-bg.png') }}" alt="bg-vector" />
              </div>
              <div>
                <div class="section-heading">
                  <h2 class="mb-0">{{ __('messages.feature.insta_embed') }}</h2>
                </div>
                <nav>
                  <div class="row insta-toggle">
                    <div class="nav nav-tabs border-0 px-0" id="nav-tab" role="tablist">
                      <button
                        class="d-flex align-items-center justify-content-center py-2 active postbtn instagram-btn  border-0 text-dark"
                        id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                        role="tab" aria-controls="nav-home" aria-selected="true">
                        <svg aria-label="Posts" class="svg-post-icon x1lliihq x1n2onr6 x173jzuc stroke-none"
                          fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
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
                            fill="currentColor" class="color000 svgShape active-svg">
                          </path>
                        </svg>
                      </button>
                    </div>
                  </div>
                </nav>
              </div>
              <div id="postContent" class="insta-feed">
                <div class="row overflow-hidden mt-3" loading="lazy">
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
                <div class="row overflow-hidden mt-3">
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
          </div>
        @endif
      @endif
      {{-- Linkedin --}}
      @if ((isset($managesection) && $managesection['linkedin_embed']) || empty($managesection))
        @if (checkFeature('linkedin_embed') && $vcard->linkedinEmbed->count())
          <div class="main-section">
            <div class="insta-feed-section position-relative pt-40 pb-40 px-30">
              <div class="section-heading">
                <h2 class="mb-0">{{ __('messages.feature.linkedin_embed') }}</h2>
              </div>

              <div class="linkedin-feed">
                <div class="row overflow-hidden mt-2 loading="lazy"">
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
          </div>
        @endif
      @endif
      {{-- blog --}}
      @if ((isset($managesection) && $managesection['blogs']) || empty($managesection))
        @if (checkFeature('blog') && $vcard->blogs->count())
          <div class="main-section">
            <div class="blog-section pt-40 pb-40 px-20">
              <div class="blog-bg text-end vector-all">
                <img src="{{ asset('assets/img/vcard29/blog-bg.png') }}" alt="bg-vector" />
              </div>
              <div class="section-heading">
                <h2 class="mb-0">{{ __('messages.feature.blog') }}</h2>
              </div>
              <div class="blog-slider">
                @foreach ($vcard->blogs as $blog)
                  <?php
                  $vcardBlogUrl = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/blog/{$blog->id}" : route('vcard.show-blog', [$vcard->url_alias, $blog->id]);
                  ?>
                  <div>
                    <div class="blog-card card">
                      <div class="card-img">
                        <a href="{{ $vcardBlogUrl }}">
                          <img src="{{ $blog->blog_icon }}" class="w-100 h-100 object-fit-contain"
                            loading="lazy" />
                        </a>
                      </div>
                      <div class="card-body text-start">
                        <h2 class="card-title fw-5 mb-2">{{ $blog->title }}</h2>
                        <p class="text-gray-200 blog-desc mb-1">
                          {{ Illuminate\Support\Str::words(str_replace('&nbsp;', ' ', strip_tags($blog->description)), 100, '...') }}
                        </p>
                        <div class="d-flex align-items-center justify-content-end"
                          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                          <a href="{{ $vcardBlogUrl }}"
                            class="text-primary d-inline-flex align-items-center justify-content-end gap-2"
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
          </div>
        @endif
      @endif
      {{-- buisness hours --}}
      @if ((isset($managesection) && $managesection['business_hours']) || empty($managesection))
        @if ($vcard->businessHours->count())
          @php
            $todayWeekName = strtolower(\Carbon\Carbon::now()->rawFormat('D'));
          @endphp
          <div class="main-section">
            <div class="business-hour-section pt-40 pb-40 px-30">
              <div class="business-hour-bg vector-all">
                <img src="{{ asset('assets/img/vcard29/business-hour-bg.png') }}" alt="bg-vector" />
              </div>
              <div class="section-heading">
                <h2 class="mb-0">{{ __('messages.business.business_hours') }}</h2>
              </div>
              <div class="business-hour-card row justify-content-center row-gap-20px"
                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                @foreach ($businessDaysTime as $key => $dayTime)
                  <div class="col-sm-6">
                    <div class="business-hour">

                      <div class="d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="37" viewBox="0 0 40 37"
                          fill="none">
                          <path
                            d="M11.3955 0.5H11.3965C14.6723 0.500093 17.5747 1.92962 19.5752 4.16211L19.9473 4.57715L20.3193 4.16309C22.3207 1.93773 25.2238 0.500019 28.499 0.5C34.5317 0.5 39.3955 5.25805 39.3955 11.1055C39.3953 18.3575 34.5491 24.4782 29.5918 28.8311C27.1237 30.9982 24.6532 32.7051 22.7988 33.8701C21.8721 34.4523 21.1002 34.8982 20.5615 35.1982C20.2982 35.3449 20.0901 35.4557 19.9473 35.5312C19.8045 35.4557 19.5969 35.3447 19.334 35.1982C18.7953 34.8982 18.0234 34.4523 17.0967 33.8701C15.2422 32.7051 12.7719 30.9983 10.3037 28.8311C5.34639 24.4782 0.500175 18.3576 0.5 11.1055C0.5 5.44006 5.06495 0.790156 10.834 0.512695L11.3955 0.5Z"
                            fill="#fbd4d5" stroke="#C82D4D" />
                          <g clip-path="url(#clip0_8355_996)">
                            <path
                              d="M18.6253 24.2499H14.5003C14.0141 24.2499 13.5478 24.0568 13.204 23.7129C12.8601 23.3691 12.667 22.9028 12.667 22.4166V11.4166C12.667 10.9304 12.8601 10.464 13.204 10.1202C13.5478 9.77641 14.0141 9.58325 14.5003 9.58325H25.5003C25.9866 9.58325 26.4529 9.77641 26.7967 10.1202C27.1405 10.464 27.3337 10.9304 27.3337 11.4166V14.1666"
                              stroke="#C82D4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M23.667 7.75V11.4167" stroke="#C82D4D" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round" />
                            <path d="M16.333 7.75V11.4167" stroke="#C82D4D" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round" />
                            <path d="M12.667 15.0833H21.8337" stroke="#C82D4D" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round" />
                            <path
                              d="M21.833 21.4999C21.833 22.4724 22.2193 23.405 22.9069 24.0926C23.5946 24.7803 24.5272 25.1666 25.4997 25.1666C26.4721 25.1666 27.4048 24.7803 28.0924 24.0926C28.78 23.405 29.1663 22.4724 29.1663 21.4999C29.1663 20.5275 28.78 19.5948 28.0924 18.9072C27.4048 18.2196 26.4721 17.8333 25.4997 17.8333C24.5272 17.8333 23.5946 18.2196 22.9069 18.9072C22.2193 19.5948 21.833 20.5275 21.833 21.4999Z"
                              stroke="#C82D4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M25.5 20.125V21.5L25.9583 21.9583" stroke="#C82D4D" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round" />
                          </g>
                          <defs>
                            <clipPath id="clip0_8355_996">
                              <rect width="22" height="22" fill="white" transform="translate(9 5)" />
                            </clipPath>
                          </defs>
                        </svg>
                        <div>
                          <div class="text-gray-200">
                            {{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}
                          </div>
                          <div>
                            {{ $dayTime ?? __('messages.common.closed') }}
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
      {{-- qr code --}}
      @if (isset($vcard['show_qr_code']) && $vcard['show_qr_code'] == 1)
        <div class="main-section">
          <div class="qr-code-section pt-40 pb-40 px-30">
            <div class="qr-code-bg text-end vector-all">
              <img src="{{ asset('assets/img/vcard29/qr-code-bg.png') }}" alt="bg-vector" />
            </div>
            <div class="section-heading">
              <h2 class="mb-0">{{ __('messages.vcard.qr_code') }}</h2>
            </div>

            <div class="qr-code mx-auto  position-relative">

              <div class="d-flex flex-sm-row flex-column gap-3 align-items-center"
                @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                <div class="qr-code-img" id="qr-code-twentynine">
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
                  <p class="fs-14 text-gray-200 mb-0">{{ __('messages.vcard.qr_section_desc') }}
                </div>

              </div>

            </div>
          </div>
        </div>
      @endif
      {{-- iframe --}}
      @if ((isset($managesection) && $managesection['iframe']) || empty($managesection))
        @if (checkFeature('iframes') && $vcard->iframes->count())
          <div class="main-section">
            <div class="iframe-section pt-40 pb-40 px-20">
              <div class="iframe-bg vector-all">
                <img src="{{ asset('assets/img/vcard29/iframe-bg.png') }}" alt="bg-vector" />
              </div>
              <div class="section-heading text-center">
                <h2>{{ __('messages.vcard.iframe') }}</h2>
              </div>
              <div class="iframe-slider">
                @foreach ($vcard->iframes as $iframe)
                  <div>
                    <div class="iframe-card">
                      <div class="overlay">
                        <iframe src="{{ $iframe->url }}" frameborder="0"
                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                          allowfullscreen width="100%" height="360">
                        </iframe>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        @endif
      @endif
      {{-- inquiry --}}
      @php
        $currentSubs = $vcard->subscriptions()->where('status', \App\Models\Subscription::ACTIVE)->latest()->first();
      @endphp
      @if ($currentSubs && $currentSubs->plan->planFeature->enquiry_form && $vcard->enable_enquiry_form)
        <div class="main-section">
          <div class="contact-us-section pt-40 pb-40 px-30">
            <div class="contact-us-bg text-end vector-all">
              <img src="{{ asset('assets/img/vcard29/contact-us-bg.png') }}" alt="bg-vector" />
            </div>
            <div class="section-heading">
              <h2 class="mb-0">{{ __('messages.contact_us.inquries') }}</h2>
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
                      <input type="tel" class="form-control" placeholder="{{ __('messages.form.phone') }}"
                        name="phone"
                        onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,&quot;&quot;)" />
                    </div>
                    <div class="col-12">
                      <input type="email" class="form-control" placeholder="{{ __('messages.form.your_email') }}"
                        name="email" />
                    </div>
                    <div class="col-12 mb-3">
                      <textarea class="form-control h-100" placeholder="{{ __('messages.form.type_message') }}" rows="3"
                        name="message"></textarea>
                    </div>
                    @if (isset($inquiry) && $inquiry == 1)
                      <div class="mb-3">
                        <div class="wrapper-file-input">
                          <div class="input-box" id="fileInputTrigger">
                            <h4> <i class="fa-solid fa-upload mx-2"></i>{{ __('messages.choose_file') }}
                            </h4> <input type="file" id="attachment" name="attachment" hidden multiple />
                          </div> <small class="text-primary">{{ __('messages.file_supported') }}</small>
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
                          <input type="checkbox" name="terms_condition" class="form-check-input terms-condition"
                            id="termConditionCheckbox" placeholder>&nbsp;
                          <label class="form-check-label" for="privacyPolicyCheckbox">
                            <span class="fs-14 fw-5">{{ __('messages.vcard.agree_to_our') }}</span>
                            <a href="{{ $vcardPrivacyAndTerm }}" target="_blank"
                              class="text-decoration-none link-info text-primary fs-14 fw-5">{!! __('messages.vcard.term_and_condition') !!}</a>
                            <span class="text-black">&</span>
                            <a href="{{ $vcardPrivacyAndTerm }}" target="_blank"
                              class="text-decoration-none link-info text-primary fs-14 fw-5">{{ __('messages.vcard.privacy_policy') }}</a>
                          </label>
                        </div>
                      </div>
                    @endif
                    <div class="col-12 text-center">
                      <button class="send-btn btn btn-primary contact-btn" type="submit">
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
                  <div class="row">
                    <div id="enquiryError" class="alert alert-danger d-none"></div>
                    <div class="col-12">
                      <input type="text" class="form-control text-start"
                        placeholder="{{ __('messages.form.your_name') }}" name="name" />
                    </div>
                    <div class="col-12">
                      <input type="tel" class="form-control text-start"
                        placeholder="{{ __('messages.form.phone') }}" name="phone"
                        onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,&quot;&quot;)" />
                    </div>
                    <div class="col-12">
                      <input type="email" class="form-control text-start"
                        placeholder="{{ __('messages.form.your_email') }}" name="email" />
                    </div>
                    <div class="col-12 mb-3">
                      <textarea class="form-control text-start h-100" placeholder="{{ __('messages.form.type_message') }}" rows="3"
                        name="message"></textarea>
                    </div>
                    @if (isset($inquiry) && $inquiry == 1)
                      <div class="mb-3">
                        <div class="wrapper-file-input">
                          <div class="input-box" id="fileInputTrigger">
                            <h4> <i class="fa-solid fa-upload ms-2"></i>{{ __('messages.choose_file') }}
                            </h4> <input type="file" id="attachment" name="attachment" hidden multiple />
                          </div> <small class="text-primary">{{ __('messages.file_supported') }}</small>
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
                          <input type="checkbox" name="terms_condition" class="form-check-input terms-condition"
                            id="termConditionCheckbox" placeholder>&nbsp;
                          <label class="form-check-label" for="privacyPolicyCheckbox">
                            <span class="fs-14 fw-5">{{ __('messages.vcard.agree_to_our') }}</span>
                            <a href="{{ $vcardPrivacyAndTerm }}" target="_blank"
                              class="text-decoration-none link-info text-primary fs-14 fw-5">{!! __('messages.vcard.term_and_condition') !!}</a>
                            <span class="text-black">&</span>
                            <a href="{{ $vcardPrivacyAndTerm }}" target="_blank"
                              class="text-decoration-none link-info text-primary fs-14 fw-5">{{ __('messages.vcard.privacy_policy') }}</a>
                          </label>
                        </div>
                      </div>
                    @endif
                    <div class="col-12 text-center">
                      <button class="send-btn btn btn-primary" type="submit">
                        {{ __('messages.contact_us.send_message') }}
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            @endif
          </div>
        </div>
      @endif
      {{-- map --}}
      @if ((isset($managesection) && $managesection['map']) || empty($managesection))
        @if ($vcard->location_type == 0 && ($vcard->location_url && isset($url[5])))
          <div class="main-section">
            <div class="map-section pt-40 pb-40 px-30">
              <div class="map-bg vector-all">
                <img src="{{ asset('assets/img/vcard29/map-bg.png') }}" alt="bg-vector" />
              </div>
              <div class="map-content">
                <div class="d-flex gap-2 align-items-center px-3 py-2"
                  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                  <div class="location-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/vcard29/location.svg') }}" />
                  </div>
                  <p class="text-dark mb-0">{!! ucwords($vcard->location) !!}</p>
                </div>
                <iframe width="100%" height="300px" class="d-block"
                  src='https://maps.google.de/maps?q={{ $url[5] }}/&output=embed' frameborder="0"
                  scrolling="no" marginheight="0" marginwidth="0" style="border-radius:0 0 15px 15px;"></iframe>
              </div>
            </div>
          </div>
        @endif
        @if ($vcard->location_type == 1 && !empty($vcard->location_embed_tag))
          <div class="main-section">
            <div class="map-section pt-40 pb-40 px-30">
              <div class="map-bg vector-all">
                <img src="{{ asset('assets/img/vcard29/map-bg.png') }}" alt="bg-vector" />
              </div>
              <div class="map-content">
                <div class="d-flex gap-2 align-items-center px-3 py-2"
                  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                  <div class="location-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/vcard29/location.svg') }}" />
                  </div>
                  <p class="text-dark mb-0">{!! ucwords($vcard->location) !!}</p>
                </div>
                <div
                  class="embed-responsive embed-responsive-16by9 rounded overflow-hidden d-flex justify-content-center"
                  style="height: 300px;">
                  {!! $vcard->location_embed_tag ?? '' !!}
                </div>
              </div>
            </div>
          </div>
        @endif
      @endif
      {{-- craete your vcard --}}
      <div class="main-section">
        @if ($currentSubs && $currentSubs->plan->planFeature->affiliation && $vcard->enable_affiliation)
          <div class="create-vcard-section px-30  pt-40 pb-40">
            <div class="create-vcard-bg text-end vector-all">
              <img src="{{ asset('assets/img/vcard29/create-vcard-bg.png') }}" alt="bg-vector" />
            </div>
            <div class="content">
              <div class="section-heading">
                <h2 class="mb-0">{{ __('messages.create_vcard') }}</h2>
              </div>
              <div class="vcard-link-card card">
                <div class="d-flex align-items-center justify-content-center gap-3"
                  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                  <a href="{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}"
                    class="text-primary link-text fw-5">{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}</a>
                  <i class="icon fa-solid fa-arrow-up-right-from-square text-primary"></i>
                </div>
              </div>
            </div>
          </div>
        @endif
        {{-- made by --}}
        <div class="d-flex justify-content-evenly made-by-section p-2">
          @if (checkFeature('advanced'))
            @if (checkFeature('advanced')->hide_branding && $vcard->branding == 0)
              @if ($vcard->made_by)
                <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                  class="text-center text-decoration-none text-dark" target="_blank">
                  <span class="text-dark fw-5 fs-14">{{ __('messages.made_by') }}
                    {{ $vcard->made_by }}</span>
                </a>
              @else
                <div class="text-center">
                  <span class="text-dark fw-5 fs-14">{{ __('messages.made_by') }}
                    {{ $setting['app_name'] }}</span>
                </div>
              @endif
            @endif
          @else
            @if ($vcard->made_by)
              <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                class="text-center text-decoration-none text-dark" target="_blank">
                <span class="text-dark fw-5 fs-14">{{ __('messages.made_by') }}
                  {{ $vcard->made_by }}</span>
              </a>
            @else
              <div class="text-center">
                <span class="text-dark fw-5 fs-14">{{ __('messages.made_by') }}
                  {{ $setting['app_name'] }}</span>
              </div>
            @endif
          @endif
          @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
            <div>
              <a class="text-decoration-none text-dark fw-5 fs-14 cursor-pointer terms-policies-btn"
                href="{{ $vcardPrivacyAndTerm }}"><span>{!! __('messages.vcard.term_policy') !!}</span></a>
            </div>
          @endif
        </div>
      </div>
      {{-- add to contact --}}
      @if ($vcard->enable_contact)
        <div class="add-to-contact-section">
          <div class="text-center d-flex align-items-center justify-content-center"
            @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            @if ($contactRequest == 1)
              <a href="{{ Auth::check() ? route('add-contact', $vcard->id) : 'javascript:void(0);' }}"
                class="add-contact-btn btn-primary {{ Auth::check() ? 'auth-contact-btn' : 'ask-contact-detail-form' }}"
                data-action="{{ Auth::check() ? route('contact-request.store') : 'show-modal' }}">
                <i class="fas fa-download fa-address-book"></i>
                &nbsp;{{ __('messages.setting.add_contact') }}</a>
            @else
              <a href="{{ route('add-contact', $vcard->id) }}" class="add-contact-btn btn-primary"><i
                  class="fas fa-download fa-address-book"></i>
                &nbsp;{{ __('messages.setting.add_contact') }}</a>
            @endif
          </div>
        </div>
        @include('vcardTemplates.contact-request')
      @endif

      {{-- sticky buttons --}}
      <div class="btn-section cursor-pointer  @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') rtl @endif">
        <div class="fixed-btn-section">
          @if (empty($vcard->hide_stickybar))
            <div
              class="bars-btn marriage-bars-btn social-media-bars-btn @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') vcard-bars-btn-left @endif">
              <img src="{{ asset('assets/img/vcard29/sticky.svg') }}" loading="lazy">
            </div>
          @endif
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
                      class="vcard29-sticky-btn vcard29-btn-group d-flex justify-content-center text-primary align-items-center rounded-0 text-decoration-none py-1 rounded-pill justify-content share-wp-btn">
                      <i class="fa-solid fa-paper-plane"></i> </a>
                  </div>
                </div>
              @endif
              @if (empty($vcard->hide_stickybar))
                <div class="{{ isset($vcard->whatsapp_share) ? 'vcard29-btn-group' : 'stickyIcon' }}">
                  <button type="button" class="vcard29-btn-group vcard29-share vcard29-sticky-btn mb-3 px-2 py-1"><i
                      class="fas fa-share-alt fs-4 pt-1"></i></button>
                  @if (!empty($vcard->enable_download_qr_code))
                    <a type="button"
                      class="vcard29-btn-group vcard29-sticky-btn d-flex justify-content-center  align-items-center  px-2 mb-3 py-2"
                      id="qr-code-btn" download="qr_code.png"><i
                        class="fa-solid fa-qrcode fs-4 text-primary"></i></a>
                  @endif
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      {{-- newslatter modal --}}
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
                <h3 class="content text-start p-lg-0">
                  {{ __('messages.vcard.subscribe_newslatter') }}</h3>
                <p class="modal-desc text-start">{{ __('messages.vcard.update_directly') }}</p>
                <form action="" method="post" id="newsLatterForm">
                  @csrf
                  <input type="hidden" name="vcard_id" value="{{ $vcard->id }}">
                  <div class="mb-2 mt-2 d-flex gap-1 justify-content-center align-items-center email-input">
                    <div class="w-100">
                      <input type="email" class="form-control bg-dark border-0 text-light email-input w-100"
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
    </div>
  </div>
  {{-- share modal code --}}
  <div id="vcard29-shareModel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
        <div class="">
          <div class="row align-items-center mt-3">
            <div class="col-10 text-center">
              <h5 class="modal-title pl-50">{{ __('messages.vcard.share_my_vcard') }}</h5>
            </div>

            <button type="button" aria-label="Close" class="btn btn-sm btn-icon btn-active-color-danger border-none"
              data-bs-dismiss="modal">
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

                <span class="fa-2x"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
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
                    <rect x="147.553" y="39.443" style="fill:none;" width="514.231" height="514.23">
                    </rect>
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
              <button class="copy-vcard-clipboard btn btn-dark" title="Copy Link" data-id="{{ $vcard->id }}">
                <i class="fa-regular fa-copy fa-2x"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
@include('vcardTemplates.template.templates')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
@if (checkFeature('seo') && $vcard->google_analytics)
  {!! $vcard->google_analytics !!}
@endif
@if (isset(checkFeature('advanced')->custom_js) && $vcard->custom_js)
  {!! $vcard->custom_js !!}
@endif
@php
  $setting = \App\Models\UserSetting::where('user_id', $vcard->tenant->user->id)
      ->where('key', 'stripe_key')
      ->first();
@endphp
<script>
  let stripe = ''
  @if (!empty($setting) && !empty($setting->value))
    stripe = Stripe('{{ $setting->value }}');
  @endif
  $().ready(function() {
    $(".gallery-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      dots: true,
      speed: 300,
      infinite: true,
      autoplaySpeed: 5000,
      /* autoplay: true, */
      responsive: [{
          breakpoint: 768,
          settings: {
            centerPadding: "125px",
          },
        },
        {
          breakpoint: 575,
          settings: {
            centerPadding: "0",
          },
        },
      ],
    });
    $(".product-slider").slick({
      arrows: false,
      infinite: true,
      dots: false,
      slidesToShow: 2,
      slidesToScroll: 1,
      /* autoplay: true, */
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
      autoplay: false,
      responsive: [{
        breakpoint: 575,
        settings: {
          arrows: false,
          dots: true,
        },
      }, ],
    });
    $(".blog-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      dots: true,
      speed: 300,
      infinite: true,
      autoplay: true,
    });
    @if ($vcard->services_slider_view)
      $('.services-slider-view').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 2,
        autoplay: false,
        slidesToScroll: 1,
        arrows: false,
        responsive: [{
          breakpoint: 500,
          settings: {
            slidesToShow: 1,
          },
        }, ],
      });
    @endif
    $(".iframe-slider").slick({
      arrows: false,
      infinite: true,
      dots: true,
      slidesToShow: 1,
      autoplay: true,
      responsive: [{
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          arrows: false,
        },
      }, ],
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
  const qrCodeTwentynine = document.getElementById("qr-code-twentynine");
  const svg = qrCodeTwentynine.querySelector("svg");
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
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>

</html>

