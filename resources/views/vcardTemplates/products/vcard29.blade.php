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
  <link rel="stylesheet" href="{{ mix('assets/css/vcard29.css') }}">
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
  <div class="container p-0">
    <div class="vcard-twentynine main-content  w-100 mx-auto content-blur allSection collapse show">
      <div class="vcard-one__product py-3 mt-0 px-30">
        <div class="d-flex align-items-center gap-3 justify-content-between mb-5"
          @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
          <div>
            <h4 class="product-heading text-primary mb-0">{{ __('messages.vcard.products') }}</h4>
          </div>
          <div class="text-center">
            <a class="back-btn text-decoration-none d-block" href="{{ $vcardUrl }}"
              role="button">{{ __('messages.common.back') }}</a>
          </div>
        </div>
        <div class="product-slider">
          @foreach ($vcard->products as $product)
            <div>
              <div class="product-card card mb-6 overflow-hidden">
                <div class="product-img card-img  mt-3">
                  <a @if ($product->product_url) href="{{ $product->product_url }}" @endif target="_blank"
                    class="text-decoration-none fs-6">
                    <div
                      class=" {{ $product->media->count() < 2 ? 'd-flex justify-content-center' : '' }} product-img-slider overflow-hidden">
                      @foreach ($product->media as $media)
                        <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}"
                          class="text-center object-fit-contain" height="208px" loading="lazy">
                      @endforeach
                    </div>
                  </a>
                </div>
                <div class="card-body p-4">
                  <div class="product-desc d-flex justify-content-between align-items-center"
                    @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
                    <h3 class="text-black fs-18 fw-5 mb-0 me-2">{{ $product->name }}</h3>
                    <div class="product-amount text-primary fw-bold fs-18 mb-3">
                      @if ($product->currency_id && $product->price)
                        <span
                          class="fs-18 fw-6 text-primary  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, $product->currency->currency_code) }}</span>
                      @elseif($product->price)
                        <span
                          class="fs-18 fw-6 text-primary  product-price-{{ $product->id }}">{{ currencyFormat($product->price, 2, getUserCurrencyIcon($vcard->user->id)) }}</span>
                      @endif
                    </div>
                  </div>
                  <p class="fs-14 text-dark mb-2">{{ $product->description }}</p>
                  @if (!empty($product->price))
                    <div class="text-center">
                      <button class="buy-product"
                        data-id="{{ $product->id }}">{{ __('messages.subscription.buy_now') }}</button>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
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
      autoplay: true,
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

