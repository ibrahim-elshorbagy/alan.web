<html lang="en">

<head>
    <link>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>{{ $vacrdTemplate->name }} | {{ getAppName() }}</title>
    <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    {{-- css link --}}
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 1)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard1.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 2)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard2.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 3)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard3.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 4)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard4.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 5)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard5.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 6)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard6.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 7)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard7.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 8)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard8.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 9)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard9.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 10)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard10.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 15)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard15.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 14)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard14.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 12)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard12.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 13)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard13.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 16)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard16.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 17)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard17.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 21)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard21.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 25)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard25.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 22)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard22.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 20)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard20.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 18)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard18.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 19)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard19.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 26)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard26.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 28)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard28.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 31)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard31.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 32)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard32.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 34)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard34.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 33)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard33.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 35)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard35.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 36)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard36.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 37)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard37.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 30)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard30.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 24)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard24.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 23)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard23.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 29)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard29.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 27)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard27.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 38)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard38.css') }}">
    @elseif($privacyPolicy->vcard->template_id == 65)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard39.css') }}">
    @endif
    @endif
    @if (isset($termCondition))
    @if ($termCondition->vcard->template_id == 1)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard1.css') }}">
    @elseif($termCondition->vcard->template_id == 2)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard2.css') }}">
    @elseif($termCondition->vcard->template_id == 3)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard3.css') }}">
    @elseif($termCondition->vcard->template_id == 4)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard4.css') }}">
    @elseif($termCondition->vcard->template_id == 5)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard5.css') }}">
    @elseif($termCondition->vcard->template_id == 6)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard6.css') }}">
    @elseif($termCondition->vcard->template_id == 7)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard7.css') }}">
    @elseif($termCondition->vcard->template_id == 8)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard8.css') }}">
    @elseif($termCondition->vcard->template_id == 9)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard9.css') }}">
    @elseif($termCondition->vcard->template_id == 10)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard10.css') }}">
    @elseif($termCondition->vcard->template_id == 12)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard12.css') }}">
    @elseif($termCondition->vcard->template_id == 15)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard15.css') }}">
    @elseif($termCondition->vcard->template_id == 13)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard13.css') }}">
    @elseif($termCondition->vcard->template_id == 14)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard14.css') }}">
    @elseif($termCondition->vcard->template_id == 16)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard16.css') }}">
    @elseif($termCondition->vcard->template_id == 17)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard17.css') }}">
    @elseif($termCondition->vcard->template_id == 21)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard21.css') }}">
    @elseif($termCondition->vcard->template_id == 25)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard25.css') }}">
    @elseif($termCondition->vcard->template_id == 22)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard22.css') }}">
    @elseif($termCondition->vcard->template_id == 20)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard20.css') }}">
    @elseif($termCondition->vcard->template_id == 18)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard18.css') }}">
    @elseif($termCondition->vcard->template_id == 19)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard19.css') }}">
    @elseif($termCondition->vcard->template_id == 26)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard26.css') }}">
    @elseif($termCondition->vcard->template_id == 28)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard28.css') }}">
    @elseif($termCondition->vcard->template_id == 31)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard31.css') }}">
    @elseif($termCondition->vcard->template_id == 32)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard32.css') }}">
    @elseif($termCondition->vcard->template_id == 34)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard34.css') }}">
    @elseif($termCondition->vcard->template_id == 33)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard33.css') }}">
    @elseif($termCondition->vcard->template_id == 35)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard35.css') }}">
    @elseif($termCondition->vcard->template_id == 36)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard36.css') }}">
    @elseif($termCondition->vcard->template_id == 37)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard37.css') }}">
    @elseif($termCondition->vcard->template_id == 30)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard30.css') }}">
    @elseif($termCondition->vcard->template_id == 24)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard24.css') }}">
    @elseif($termCondition->vcard->template_id == 23)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard23.css') }}">
    @elseif($termCondition->vcard->template_id == 29)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard29.css') }}">
    @elseif($termCondition->vcard->template_id == 27)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard27.css') }}">
    @elseif($termCondition->vcard->template_id == 38)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard38.css') }}">
    @elseif($termCondition->vcard->template_id == 65)
    <link rel="stylesheet" href="{{ asset('assets/css/vcard39.css') }}">
    @endif
    @endif
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 22)
    <style>
     :root {
            --primary-color: {{ $dynamicVcard->primary_color ?? '#358ef4' }};
            --primary-light: color-mix(in srgb, var(--primary-color), white 80%);
            --secondary-color: color-mix(in srgb, var(--primary-color), black 40%);
            --primary-100: color-mix(in srgb, var(--primary-color), white 85%);
            --green-100: {{ $dynamicVcard->back_seconds_color ?? '#d6e2f5' }};
            --label-color: {{ $dynamicVcard->text_label_color ?? '#ffffff' }};
            --green: {{ $dynamicVcard->back_color ?? '#0f2f3a' }};
            --black: {{ $dynamicVcard->button_text_color ?? '#2d2624' }};
            --gray-100: {{ $dynamicVcard->text_description_color ?? '#9facb0' }};
            --white: {{ $dynamicVcard->cards_back ?? '#ffffff' }};
            --light: {{ $dynamicVcard->cards_back ?? '#ffffff' }};
            --light-100: {{ $dynamicVcard->social_icon_color ?? '#ffffff' }};
        }
        .bg-primary-light {
            background-color:var( --primary-light);
        }
    </style>
    @endif
    @endif
    {{--
    <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}"> --}}
    {{-- slick slider --}}
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">

    {{-- google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 1)
            vcard-one-body
    @elseif($privacyPolicy->vcard->template_id == 2)
            vcard-two-body
    @elseif($privacyPolicy->vcard->template_id == 3)
            vcard-three-body
    @elseif($privacyPolicy->vcard->template_id == 4)
            vcard-four-body
    @elseif($privacyPolicy->vcard->template_id == 5)
            vcard-five-body
    @elseif($privacyPolicy->vcard->template_id == 6)
            vcard-six-body
    @elseif($privacyPolicy->vcard->template_id == 7)
            vcard-seven-body
    @elseif($privacyPolicy->vcard->template_id == 8)
            vcard-eight-body
    @elseif($privacyPolicy->vcard->template_id == 9)
            vcard-nine-body
    @elseif($privacyPolicy->vcard->template_id == 10)
            vcard-ten-body
    @elseif($privacyPolicy->vcard->template_id == 12)
            vcard-twelve-body
    @elseif($privacyPolicy->vcard->template_id == 13)
            vcard-thirteen-body
    @elseif($privacyPolicy->vcard->template_id == 14)
            vcard-fourteen-body
    @elseif($privacyPolicy->vcard->template_id == 15)
            vcard-fifteen-body
    @elseif($privacyPolicy->vcard->template_id == 16)
            vcard-sixteen-body
    @elseif($privacyPolicy->vcard->template_id == 17)
            vcard-seventeen-body
    @elseif($privacyPolicy->vcard->template_id == 18)
            vcard-eighteen-body
    @elseif($privacyPolicy->vcard->template_id == 19)
            vcard-nineteen-body
    @elseif($privacyPolicy->vcard->template_id == 20)
            vcard-twenty-body
    @elseif($privacyPolicy->vcard->template_id == 21)
            vcard-twentyone-body
    @elseif($privacyPolicy->vcard->template_id == 22)
            vcard-twentytwo-body bg-primary-light
    @elseif($privacyPolicy->vcard->template_id == 23)
            vcard-twentythree-body
    @elseif($privacyPolicy->vcard->template_id == 24)
            vcard-twentyfour-body
    @elseif($privacyPolicy->vcard->template_id == 25)
            vcard-twentyfive-body
    @elseif($privacyPolicy->vcard->template_id == 26)
            vcard-twentysix-body
    @elseif($privacyPolicy->vcard->template_id == 27)
            vcard-twentyseven-body
    @elseif($privacyPolicy->vcard->template_id == 28)
            vcard-twentyeight-body
    @elseif($privacyPolicy->vcard->template_id == 29)
            vcard-twentynine-body
    @elseif($privacyPolicy->vcard->template_id == 30)
            vcard-thirty-body
    @elseif($privacyPolicy->vcard->template_id == 31)
            vcard-thirtyone-body
    @elseif($privacyPolicy->vcard->template_id == 32)
            vcard-thirtytwo-body
    @elseif($privacyPolicy->vcard->template_id == 33)
            vcard-thirtythree-body
    @elseif($privacyPolicy->vcard->template_id == 34)
            vcard-thirtyfour-body
    @elseif($privacyPolicy->vcard->template_id == 35)
            vcard-thirtyfive-body
    @elseif($privacyPolicy->vcard->template_id == 36)
            vcard-thirtysix-body
    @elseif($privacyPolicy->vcard->template_id == 37)
            vcard-thirtyseven-body
    @elseif($privacyPolicy->vcard->template_id == 38)
            vcard-thirtyeight-body
    @elseif($privacyPolicy->vcard->template_id == 65)
            vcard-thirtynine-body
    @endif
    @endif
    ">
    <div class="w-100 h-100 position-fixed top-0
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 1)
            vcard-one-effect
    @elseif($privacyPolicy->vcard->template_id == 2)
            vcard-two-effect
    @elseif($privacyPolicy->vcard->template_id == 3)
            vcard-three-effect
    @elseif($privacyPolicy->vcard->template_id == 4)
            vcard-four-effect
    @elseif($privacyPolicy->vcard->template_id == 5)
            vcard-five-effect
    @elseif($privacyPolicy->vcard->template_id == 6)
            vcard-six-effect
    @elseif($privacyPolicy->vcard->template_id == 7)
            vcard-seven-effect
    @elseif($privacyPolicy->vcard->template_id == 8)
            vcard-eight-effect
    @elseif($privacyPolicy->vcard->template_id == 9)
            vcard-nine-effect
    @elseif($privacyPolicy->vcard->template_id == 10)
            vcard-ten-effect
    @elseif($privacyPolicy->vcard->template_id == 12)
            vcard-twelve-effect
    @elseif($privacyPolicy->vcard->template_id == 13)
            vcard-thirteen-effect
    @elseif($privacyPolicy->vcard->template_id == 14)
            vcard-fourteen-effect
    @elseif($privacyPolicy->vcard->template_id == 15)
            vcard-fifteen-effect
    @elseif($privacyPolicy->vcard->template_id == 16)
            vcard-sixteen-effect
    @elseif($privacyPolicy->vcard->template_id == 17)
            vcard-seventeen-effect
    @elseif($privacyPolicy->vcard->template_id == 18)
            vcard-eighteen-effect
    @elseif($privacyPolicy->vcard->template_id == 19)
            vcard-nineteen-effect
    @elseif($privacyPolicy->vcard->template_id == 20)
            vcard-twenty-effect
    @elseif($privacyPolicy->vcard->template_id == 21)
            vcard-twentyone-effect
    @elseif($privacyPolicy->vcard->template_id == 22)
            vcard-twentytwo-effect
    @elseif($privacyPolicy->vcard->template_id == 23)
            vcard-twentythree-effect
    @elseif($privacyPolicy->vcard->template_id == 24)
            vcard-twentyfour-effect
    @elseif($privacyPolicy->vcard->template_id == 25)
            vcard-twentyfive-effect
    @elseif($privacyPolicy->vcard->template_id == 26)
            vcard-twentysix-effect
    @elseif($privacyPolicy->vcard->template_id == 27)
            vcard-twentyseven-effect
    @elseif($privacyPolicy->vcard->template_id == 28)
            vcard-twentyeight-effect
    @elseif($privacyPolicy->vcard->template_id == 29)
            vcard-twentynine-effect
    @elseif($privacyPolicy->vcard->template_id == 30)
            vcard-thirty-effect
    @elseif($privacyPolicy->vcard->template_id == 31)
            vcard-thirtyone-effect
    @elseif($privacyPolicy->vcard->template_id == 32)
            vcard-thirtytwo-effect
    @elseif($privacyPolicy->vcard->template_id == 33)
            vcard-thirtythree-effect
    @elseif($privacyPolicy->vcard->template_id == 34)
            vcard-thirtyfour-effect
    @elseif($privacyPolicy->vcard->template_id == 35)
            vcard-thirtyfive-effect
    @elseif($privacyPolicy->vcard->template_id == 36)
            vcard-thirtysix-effect
    @elseif($privacyPolicy->vcard->template_id == 37)
            vcard-thirtyseven-effect
    @elseif($privacyPolicy->vcard->template_id == 38)
            vcard-thirtyeight-effect
    @elseif($privacyPolicy->vcard->template_id == 65)
            vcard-thirtynine-effect
    @endif
    @endif
    ">
        @if (isset($privacyPolicy))
        @if ($privacyPolicy->vcard->template_id == 12)
        <div class="top-animation">
            @for ($i = 0; $i < 10; $i++) <span></span>
                @endfor
        </div>
        <div class="bottom-animation">
            @for ($i = 0; $i < 10; $i++) <span></span>
                @endfor
        </div>
        @endif
        @endif
        @if (isset($privacyPolicy))
        @if ($privacyPolicy->vcard->template_id == 14)
        <div class="bg-vectors">
            <div class="fireworks">
                @for ($i = 0; $i < 600; $i++) <div class="line">
                    <div class="spark">
                        <div class="fire"></div>
                    </div>
            </div>
            @endfor
        </div>
    </div>
    @endif
    @endif
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 29)
    <div>
        @for ($i = 0; $i < 20; $i++) <div class="snowflake">
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
    @endif
    @endif

    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 16)

        <div class="trianglesContainer"></div>

    @endif
    @endif

    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 35)
       <div class="position-fixed top-0 w-100 h-100 start-0 estate-bg-animation">
            <div class="fog-layer">
                <img src="{{ asset('assets/img/vcard35/bg-effect-gif1.gif') }}" class="object-fit-contain w-100 h-100" />
            </div>
            <div class="fog-layer-right">
                <img src="{{ asset('assets/img/vcard35/bg-effect-gif2.gif') }}" class="object-fit-contain w-100 h-100" />
            </div>

        </div>
    @endif
    @endif

    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 30)
         <div class="vcard30-background-animation">
                <div class="image">
                        <div class="bg-img"></div>
                </div>
                <div class="position-relative w-100 h-100">
                        <div class="car">
                                <img src="{{ asset('assets/img/vcard30/car-img.png') }}" width="140px" height="100%">
                                <div class="wheel">
                                        <img src="{{ asset('assets/img/vcard30/wheel.png') }}" class="back-wheel">
                                        <img src="{{ asset('assets/img/vcard30/wheel.png') }}" class="front-wheel">
                                </div>
                        </div>
                </div>
        </div>
    @endif
    @endif

    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 33)
    <div class="vcard33-bg-animation">
        <div class="ag-spotlight-moving_spotlight ag-spotlight-moving_spotlight-right"></div>
        <div class="ag-spotlight-moving_spotlight ag-spotlight-moving_spotlight-right1"></div>
        <div class="ag-spotlight-moving_spotlight ag-spotlight-moving_spotlight-right2"></div>
        <div class="ag-spotlight-moving_spotlight ag-spotlight-moving_spotlight-left"></div>
        <div class="ag-spotlight-moving_spotlight ag-spotlight-moving_spotlight-left1"></div>
        <div class="ag-spotlight-moving_spotlight ag-spotlight-moving_spotlight-left2"></div>
        <div>
        <div id="particles-js"></div>
        </div>
</div>
    @endif
    @endif
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 17)
    <div class="vcard17-bg-effect position-fixed top-0 start-0 w-100 h-100">
        <video class="vcard17-bg-video w-100 h-100 object-fit-cover" autoplay muted loop>
            <source src="{{ asset('assets/img/vcard17/vcard17-bg-video.mp4') }}" type="video/mp4">
        </video>
    </div>
    @endif
    @endif
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 19)
        <div class="bg-animation d-flex align-items-center">
            <div class="w-50 h-100 position-relative">
                <div class="vector-13 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector13.png') }}" alt="images" />
                </div>
                <div class="vector-1 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector24.png') }}" alt="images" />
                </div>
                <div class="vector-2 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector2.png') }}" alt="images" />
                </div>
                <div class="vector-12 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector12.png') }}" alt="images" />
                </div>
                <div class="vector-14 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector14.png') }}" alt="images" />
                </div>
                <div class="vector-16 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector16.png') }}" alt="images" />
                </div>
                <div class="fashion-text">
                    <img src=" {{ asset('assets/img/vcard19/fashion.png') }}" alt="images" class="w-100" />
                </div>
            </div>
            <div class="w-50 h-100 position-relative">
                <div class="vector-4 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector15.png') }}" alt="images" />
                </div>
                <div class="vector-5 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector8.png') }}" alt="images" />
                </div>
                <div class="vector-6 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector4.png') }}" alt="images" />
                </div>
                <div class="vector-11 vector">
                    <div class="position-relative">
                        <img src=" {{ asset('assets/img/vcard19/vector-11.png') }}" alt="images" />
                        <div class="position-absolute sub-img">
                            <img src="{{ asset('assets/img/vcard19/vector-11(2).png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="vector-9 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector9.png') }}" alt="images" />
                </div>
                <div class="vector-15 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector5.png') }}" alt="images" />
                </div>
                <div class="beauty-text">
                    <img src=" {{ asset('assets/img/vcard19/beauty.png') }}" alt="images" class="w-100" />
                </div>
                <div class="vector-10 vector">
                    <img src=" {{ asset('assets/img/vcard19/vector10.png') }}" alt="images" />
                </div>
            </div>
        </div>
@endif
@endif

    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 25)

    @endif
    @endif

    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 26)
    <div class="bg-image-animation2">
        <div class="icon-1 img-animate">
            <img src="{{ asset('assets/img/vcard26/setting-icon1.png') }}" alt="bg-vector" loading="lazy">
        </div>
        <div class="icon-2 img-animate">
            <img src="{{ asset('assets/img/vcard26/setting-icon1.png') }}" alt="bg-vector" loading="lazy">
        </div>
        <div class="icon-3 img-animate">
            <img src="{{ asset('assets/img/vcard26/setting-icon2.svg') }}" alt="bg-vector" loading="lazy">
        </div>
        <div class="icon-4">
            <img src="{{ asset('assets/img/vcard26/arrow-img.png') }}" alt="bg-vector" loading="lazy">
        </div>
        <div class="icon-5 cloud-animate">
            <img src="{{ asset('assets/img/vcard26/cloud1.png') }}" alt="bg-vector" class="position-relative" loading="lazy">
        </div>
          <div class="icon-6 img-animate">
            <img src="{{ asset('assets/img/vcard26/setting-icon2.svg') }}" alt="bg-vector" loading="lazy">
        </div>
         <div class="icon-7 cloud-animate">
            <img src="{{ asset('assets/img/vcard26/cloud1.png') }}" alt="bg-vector" class="position-relative" loading="lazy">
        </div>
         <div class="icon-8 img-animate">
            <img src="{{ asset('assets/img/vcard26/setting-icon2.svg') }}" alt="bg-vector" loading="lazy">
        </div>
    </div>
    @endif
    @endif

    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 34)
    @php
    $animations = [
    ['top' => '5%', 'left' => '2%', 'size' => '40px', 'animation' => 'zoomOut 5s ease-in-out infinite'],
    ['top' => '25%', 'left' => '2%', 'size' => '70px', 'animation' => 'zoomIn'],
    ['top' => '45%', 'left' => '2%', 'size' => '50px', 'animation' => 'zoomOut'],
    ['top' => '65%', 'left' => '2%', 'size' => '80px', 'animation' => 'zoomIn'],
    ['top' => '85%', 'left' => '2%', 'size' => '60px', 'animation' => 'zoomOut'],
    ['top' => '10%', 'left' => '14%', 'size' => '70px','animation' => 'zoomIn'],
    ['top' => '30%', 'left' => '14%', 'size' => '40px','animation' => 'zoomOut'],
    ['top' => '50%', 'left' => '14%', 'size' => '80px','animation' => 'zoomIn'],
    ['top' => '70%', 'left' => '14%', 'size' => '50px','animation' => 'zoomOut'],
    ['top' => '90%', 'left' => '14%', 'size' => '70px','animation' => 'zoomIn'],
    ['top' => '5%', 'left' => '25%', 'size' => '40px','animation' => 'zoomOut'],
    ['top' => '25%', 'left' => '25%', 'size' => '70px','animation' => 'zoomIn'],
    ['top' => '45%', 'left' => '25%', 'size' => '50px','animation' => 'zoomOut'],
    ['top' => '65%', 'left' => '25%', 'size' => '80px','animation' => 'zoomIn'],
    ['top' => '85%', 'left' => '25%', 'size' => '60px','animation' => 'zoomOut'],
    ['top' => '5%', 'left' => '71%', 'size' => '40px','animation' => 'zoomIn'],
    ['top' => '25%', 'left' => '71%', 'size' => '70px','animation' => 'zoomOut'],
    ['top' => '45%', 'left' => '71%', 'size' => '50px','animation' => 'zoomIn'],
    ['top' => '65%', 'left' => '71%', 'size' => '80px','animation' => 'zoomOut'],
    ['top' => '85%', 'left' => '71%', 'size' => '60px','animation' => 'zoomIn'],
    ['top' => '10%', 'left' => '82%', 'size' => '70px','animation' => 'zoomOut'],
    ['top' => '30%', 'left' => '82%', 'size' => '40px','animation' => 'zoomIn'],
    ['top' => '50%', 'left' => '82%', 'size' => '80px','animation' => 'zoomOut'],
    ['top' => '70%', 'left' => '82%', 'size' => '50px','animation' => 'zoomIn'],
    ['top' => '90%', 'left' => '82%', 'size' => '70px','animation' => 'zoomOut'],
    ['top' => '5%', 'left' => '94%', 'size' => '40px','animation' => 'zoomIn'],
    ['top' => '25%', 'left' => '94%', 'size' => '70px','animation' => 'zoomOut'],
    ['top' => '45%', 'left' => '94%', 'size' => '50px','animation' => 'zoomIn'],
    ['top' => '65%', 'left' => '94%', 'size' => '80px','animation' => 'zoomOut'],
    ['top' => '85%', 'left' => '94%', 'size' => '60px','animation' => 'zoomIn'],
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
    @endif
    @endif
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 32)
    <div class="vcard-thirtytwo-effect-bg position-fixed w-100 h-100 top-0 start-0 d-flex">
    </div>
    @endif
    @endif
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 31)
    <div class="bg-effect-vcard31 position-fixed top-0 start-0 w-100 h-100">
    </div>
    @endif
    @endif

    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 27)
    <div class="vcard-tewntyseven position-fixed top-0 left-0 right-0 bottom-0 w-100 h-100">
        <div class="bg-animation position-absolute top-0 h-50 w-100">
            <div class="bg-shape vector-img1">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 288 288">
                    <linearGradient id="PSgrad_0" x1="70.711%" x2="0%" y1="70.711%" y2="0%">
                        <stop offset="0%" stop-color="rgb(95,54,152)" stop-opacity="1"></stop>
                        <stop offset="100%" stop-color="rgb(247,109,138)" stop-opacity="1"></stop>
                    </linearGradient>
                    <path class="path path1">
                        <animate repeatCount="indefinite" attributeName="d" dur="5s" values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	"></animate>
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
                        <animate repeatCount="indefinite" attributeName="d" dur="5s" values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	"></animate>
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
                        <animate repeatCount="indefinite" attributeName="d" dur="5s" values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	"></animate>
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
                        <animate repeatCount="indefinite" attributeName="d" dur="5s" values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	"></animate>
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
                        <animate repeatCount="indefinite" attributeName="d" dur="5s" values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	"></animate>
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
                        <animate repeatCount="indefinite" attributeName="d" dur="5s" values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32c-8-21.9,0.7-54.6,20.7-67.1c19.5-12.3,32.8,5.5,67.7-3.4C145.2,62,145,49.9,173,43.4 c12-2.8,41.4-9.6,60.2,6.6c19,16.4,16.7,47.5,16,57.7c-1.7,22.8-10.3,25.5-9.4,46.4c1,22.5,11.2,25.8,9.1,42.6 c-2.2,17.6-16.3,37.5-33.5,40.8c-22,4.1-29.4-22.4-54.9-22.6c-31-0.2-40.8,39-68.3,35.7c-17.3-2-32.2-19.8-37.3-34.8 C48.9,198.6,57.8,191,51,171.3z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7c4.8-15,13.1-17.8,30.1-36.7C91,68.8,83.5,56.7,103.4,45 c22.2-13.1,51.1-9.5,69.6-1.6c18.1,7.8,15.7,15.3,43.3,33.2c28.8,18.8,37.2,14.3,46.7,27.9c15.6,22.3,6.4,53.3,4.4,60.2 c-3.3,11.2-7.1,23.9-18.5,32c-16.3,11.5-29.5,0.7-48.6,11c-16.2,8.7-12.6,19.7-28.2,33.2c-22.7,19.7-63.8,25.7-79.9,9.7 c-15.2-15.1,0.3-41.7-16.6-54.9C63,186,49.7,196.7,37.5,186z	"></animate>
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
    @endif
    @endif

@if ($privacyPolicy)
@if($privacyPolicy->vcard->template_id == 23)
     <div class="vcardtwentythree-bg-animation d-flex align-items-end">
       <div class="bg-animation w-100 position-relative h-100 opacity-50">
            <div class="chats">Business Consulting</div>
            <div class="d-flex gap-3 chat-right">
                <span class="chat">Results</span>
                <span class="chat">Success</span>
                <span class="chat">Team</span>
            </div>
            <div class="bg-icon-images">
                <div class="icon icon1">
                    <img src=" {{ asset('assets/img/vcard23/commercial.png') }}" />
                </div>
                <div class="icon icon2 rounded-0 bg-transparent">
                    <div class="chats position-static">Business Consulting</div>
                </div>
                <div class="icon icon3">
                    <img src="{{ asset('assets/img/vcard23/line-chart.png') }}" />
                </div>
                <div class="icon icon4">
                    <img src="{{ asset('assets/img/vcard23/idea.png') }}" />
                </div>
            </div>
            <div class="graph1 graph">
                 <svg viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">

                    <!-- Axis -->
                    <line x1="50" y1="350" x2="550" y2="350" stroke="#333" stroke-width="2"/>
                    <line x1="50" y1="50" x2="50" y2="350" stroke="#333" stroke-width="2"/>

                    <!-- Bars -->
                    <g fill="#665d1e">
                    <rect class="bars" x="90" y="200" width="40" height="150"/>
                    <rect class="bars" x="170" y="120" width="40" height="230"/>
                    <rect class="bars" x="250" y="160" width="40" height="190"/>
                    <rect class="bars" x="330" y="80" width="40" height="270"/>
                    <rect class="bars" x="410" y="140" width="40" height="210"/>
                    </g>

                    <!-- Line chart -->
                    <path class="line-path" d="M100 250 L190 170 L270 200 L350 130 L430 180"
                        fill="none" stroke="#665d1e" stroke-width="3"/>

                    <!-- Dots -->
                    <g fill="white">
                    <circle class="dot" cx="100" cy="250" r="6"/>
                    <circle class="dot" cx="190" cy="170" r="6"/>
                    <circle class="dot" cx="270" cy="200" r="6"/>
                    <circle class="dot" cx="350" cy="130" r="6"/>
                    <circle class="dot" cx="430" cy="180" r="6"/>
                    </g>
                </svg>
            </div>
            <div class="float-icon gear">
                <img src="{{ asset('assets/img/vcard23/gear.png') }}" alt="gear">
            </div>
            <!-- Floating avatars -->
            <div class="avatar avatar1">
                <img src="{{ asset('assets/img/vcard23/user-male-circle.png') }}" alt="User 1"/>
            </div>
            <div class="avatar avatar2">
                <img src="{{ asset('assets/img/vcard23/user-female-circle.png') }}" alt="User 2"/>
            </div>
            <div class="avatar avatar3">
                <img src="{{ asset('assets/img/vcard23/user-group-man-man.png') }}" alt="User 3"/>
            </div>

            <!-- Central icon -->
            <div class="center-icon">
                <img src="{{ asset('assets/img/vcard23/teamwork.png') }}" alt="Teamwork"/>
            </div>

            <div class="avatar avatar4">
                <img src="{{ asset('assets/img/vcard23/user-female.png') }}" alt="User 2"/>
            </div>

            <div class="graph2 graph">
                <svg viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">

                    <!-- Axis -->
                    <line x1="50" y1="350" x2="550" y2="350" stroke="#333" stroke-width="2"/>
                    <line x1="50" y1="50" x2="50" y2="350" stroke="#333" stroke-width="2"/>

                    <!-- Bars -->
                    <g fill="#665d1e">
                    <rect class="bars" x="90" y="200" width="40" height="150"/>
                    <rect class="bars" x="170" y="120" width="40" height="230"/>
                    <rect class="bars" x="250" y="160" width="40" height="190"/>
                    <rect class="bars" x="330" y="80" width="40" height="270"/>
                    <rect class="bars" x="410" y="140" width="40" height="210"/>
                    </g>

                    <!-- Line chart -->
                    <path class="line-path" d="M100 250 L190 170 L270 200 L350 130 L430 180"
                        fill="none" stroke="#665d1e" stroke-width="3"/>

                    <!-- Dots -->
                    <g fill="white">
                    <circle class="dot" cx="100" cy="250" r="6"/>
                    <circle class="dot" cx="190" cy="170" r="6"/>
                    <circle class="dot" cx="270" cy="200" r="6"/>
                    <circle class="dot" cx="350" cy="130" r="6"/>
                    <circle class="dot" cx="430" cy="180" r="6"/>
                    </g>
                </svg>
            </div>
        </div>
    </div>
@endif
@endif

@if (isset($privacyPolicy))
@if ($privacyPolicy->vcard->template_id == 21)
<div class="bg-effect-vcard21 position-fixed w-100 h-100 top-0 start-0">
    <div class="bg"></div>
</div>
@endif
@endif
@if (isset($privacyPolicy))
@if ($privacyPolicy->vcard->template_id == 18)
<div class="position-fixed w-100 h-100 top-0 start-0 bg-effect-vcard18">
    <div class="background-vcard18-bg-effect"></div>

    </div>
@endif
@endif
@if (isset($privacyPolicy))
@if($privacyPolicy->vcard->template_id == 20)
<div class="bg-effect-vcard20 position-fixed top-0 start-0 w-100 h-100">
    <div class="bg-main w-50 h-100 position-absolute top-0 start-0">
        <img src="{{ asset('assets/img/vcard20/bg-effect-vcard20.png') }}" loading="lazy" class="w-100 h-100 object-fit-cover" />
    </div>
    <div class="bg-main w-50 h-100 position-absolute top-0 end-0">
        <img src="{{ asset('assets/img/vcard20/bg-effect-vcard20.png') }}" loading="lazy" class="w-100 h-100 object-fit-cover" />
    </div>
</div>

@endif
@endif
@if (isset($privacyPolicy))
@if ($privacyPolicy->vcard->template_id == 36)
<div class="position-fixed top-0 start-0 w-100 h-100 vcard-thirtysix-effect">
    <div class="bg-effect-vcard36-1">
    </div>
</div>
@endif
@endif
@if (isset($privacyPolicy))
@if ($privacyPolicy->vcard->template_id == 38)
<div class="vcard38-bg-effect position-fixed w-100 h-100 top-0 start-0">
    <div id="vcard38Tsparticles"></div>
        <div class="vcard-38-bg-img">
        </div>
</div>
@endif
@endif
</div>

    <div class="container">
        <div class="
        @if (isset($privacyPolicy)) @if ($privacyPolicy->vcard->template_id == 1)
            main-content mx-auto content-blur vcard-one
@elseif($privacyPolicy->vcard->template_id == 2)
            main-content mx-auto content-blur vcard-two
@elseif($privacyPolicy->vcard->template_id == 3)
            main-content mx-auto content-blur vcard-three
@elseif($privacyPolicy->vcard->template_id == 4)
            main-content mx-auto content-blur vcard
@elseif($privacyPolicy->vcard->template_id == 5)
            main-section  main-section-vcard5 mx-auto
@elseif($privacyPolicy->vcard->template_id == 6)
            main-section-vcard6  main-section d-flex justify-content-center
@elseif($privacyPolicy->vcard->template_id == 7)
            main-section-vcard7 main-section d-flex justify-content-center
@elseif($privacyPolicy->vcard->template_id == 8)
            main-content mx-auto content-blur vcard-eight
@elseif($privacyPolicy->vcard->template_id == 9)
            vcard-nine main-content w-100 mx-auto content-blur terms-policies-section
@elseif($privacyPolicy->vcard->template_id == 10)
            vcard-ten main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 12)
            vcard-twelve main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 15)
            vcard-fifteen main-content w-100  mx-auto
@elseif($privacyPolicy->vcard->template_id == 16)
            vcard-sixteen main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 17)
            vcard-seventeen main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 14)
            vcard-fourteen main-content w-100 mx-auto pt-5
@elseif($privacyPolicy->vcard->template_id == 13)
            main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 18)
            vcard-eighteen main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 19)
            vcard-nineteen main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 20)
            vcard-twenty main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 22)
            vcard22-main main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 21)
           vcard-twentyone main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 26)
            vcard-twentysix main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 28)
            vcard-twentyeight main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 31)
            vcard-thirtyone main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 32)
            vcard-thirtytwo main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 34)
            vcard-thirtyfour main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 36)
            vcard-thirtysix main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 33)
            vcard-thirtythree main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 35)
            vcard-thirtyfive main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 37)
            vcard-thirtyseven main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 30)
            vcard-thirty main-content w-100 mx-auto text-dark
@elseif($privacyPolicy->vcard->template_id == 24)
            vcard-twentyfour main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 23)
            vcard-twentythree main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 25)
            vcard-twentyfive main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 29)
            vcard-twentynine main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 27)
            vcard-twentyseven main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 38)
            vcard-thirtyeight main-content w-100 mx-auto
@elseif($privacyPolicy->vcard->template_id == 65)
            vcard-thirtynine main-content w-100 mx-auto @endif
            @endif
@if (isset($termCondition)) @if ($termCondition->vcard->template_id == 1)
            main-content mx-auto content-blur vcard-one
@elseif($termCondition->vcard->template_id == 2)
            main-content mx-auto content-blur vcard-two
@elseif($termCondition->vcard->template_id == 3)
            main-content mx-auto content-blur vcard-three
@elseif($termCondition->vcard->template_id == 4)
            main-content mx-auto content-blur vcard
@elseif($termCondition->vcard->template_id == 5)
            main-section  main-section-vcard5 mx-auto
@elseif($termCondition->vcard->template_id == 6)
            main-section-vcard6  main-section d-flex justify-content-center
@elseif($termCondition->vcard->template_id == 7)
            main-section-vcard7 main-section d-flex justify-content-center
@elseif($termCondition->vcard->template_id == 8)
            main-content mx-auto content-blur vcard-eight
@elseif($termCondition->vcard->template_id == 9)
            vcard-nine main-content w-100 mx-auto content-blur terms-policies-section
@elseif($termCondition->vcard->template_id == 10)
            vcard-ten main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 12)
            vcard-twelve main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 15)
            vcard-fifteen main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 14)
            vcard-fourteen main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 13)
            main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 16)
            vcard-sixteen main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 17)
            vcard-seventeen main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 21)
            vcard-twentyone main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 25)
            vcard-twentyfive main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 22)
vcard22-main main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 20)
            vcard-twenty main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 18)
            vcard-eighteen main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 19)
            vcard-nineteen main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 26)
vcard-twentysix main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 28)
vcard-twentysix main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 31)
vcard-thirtyone main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 32)
vcard-thirtytwo main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 34)
vcard-thirtyfour main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 36)
vcard-thirtysix main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 33)
vcard-thirtythree main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 35)
vcard-thirtyfive main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 37)
vcard-thirtyseven main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 30)
vcard-thirty main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 24)
vcard-twentyfour main-content w-100 mx-auto

@elseif($termCondition->vcard->template_id == 23)
            vcard-twentythree main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 29)
            vcard-twentynine main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 27)
            vcard-twentyseven main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 38)
            vcard-thirtyeight main-content w-100 mx-auto
@elseif($termCondition->vcard->template_id == 65)
            vcard-thirtynine main-content w-100 mx-auto @endif
    @endif
            ">
            <div class="
          @if (isset($privacyPolicy)) @if ($privacyPolicy->vcard->template_id == 1)
                 vcard-one__contact h-100
@elseif($privacyPolicy->vcard->template_id == 2)
                py-5 vcard-two__contact
@elseif($privacyPolicy->vcard->template_id == 3)
                py-5 vcard-three__contact
@elseif($privacyPolicy->vcard->template_id == 4)
                py-5 vcard__contact-us
@elseif($privacyPolicy->vcard->template_id == 5)
                main-bg vcard-five__contact py-5
@elseif($privacyPolicy->vcard->template_id == 6)
                main-bg vcard-six__contact py-5
@elseif($privacyPolicy->vcard->template_id == 7)
                main-bg vcard-seven__contact py-5
@elseif($privacyPolicy->vcard->template_id == 8)
                py-5 vcard-eight__contact
@elseif($privacyPolicy->vcard->template_id == 9)
                main-bg vcard-nine__contact py-5
@elseif($privacyPolicy->vcard->template_id == 10)
                vcard-ten__contact py-5
@elseif($privacyPolicy->vcard->template_id == 13)
                vcard-ten__contact py-5 @endif
        @endif
        @if (isset($termCondition)) @if ($termCondition->vcard->template_id == 1)
                 vcard-one__contact h-100
@elseif($termCondition->vcard->template_id == 2)
                py-5 vcard-two__contact
@elseif($termCondition->vcard->template_id == 3)
                py-5 vcard-three__contact
@elseif($termCondition->vcard->template_id == 4)
                py-5 vcard__contact-us
@elseif($termCondition->vcard->template_id == 5)
                main-bg vcard-five__contact py-5
@elseif($termCondition->vcard->template_id == 6)
                main-bg vcard-six__contact py-5
@elseif($termCondition->vcard->template_id == 7)
                main-bg vcard-seven__contact py-5
@elseif($termCondition->vcard->template_id == 8)
                py-5 vcard-eight__contact
@elseif($termCondition->vcard->template_id == 9)
                main-bg vcard-nine__contact py-5
@elseif($termCondition->vcard->template_id == 10)
                vcard-ten__contact py-5
@elseif($termCondition->vcard->template_id == 13)
                vcard-ten__contact py-5
@elseif($termCondition->vcard->template_id == 18)
                vcard-ten__contact py-5 @endif
        @endif">

                @if (!empty($privacyPolicy->privacy_policy))
                <div class="container">
                    <h4 class="text-center py-4 heading-title
        @if ($privacyPolicy->vcard->template_id == 1) vcard-one-heading
@elseif($privacyPolicy->vcard->template_id == 2)
                            vcard-two-heading
@elseif($privacyPolicy->vcard->template_id == 3)
                            vcard-three-heading
@elseif($privacyPolicy->vcard->template_id == 4)
                            vcard__heading
@elseif($privacyPolicy->vcard->template_id == 5)
                            contact-heading
@elseif($privacyPolicy->vcard->template_id == 6)
                            vcard-six-heading
@elseif($privacyPolicy->vcard->template_id == 7)
                            vcard-seven-heading
@elseif($privacyPolicy->vcard->template_id == 8)
                            vcard-eight-heading
@elseif($privacyPolicy->vcard->template_id == 9)
                            heading-right
@elseif($privacyPolicy->vcard->template_id == 10)
                            vcard-ten-heading
@elseif($privacyPolicy->vcard->template_id == 12)
                            vcard-twelve-heading
@elseif($privacyPolicy->vcard->template_id == 13)
                            vcard-thirteen-heading
@elseif($privacyPolicy->vcard->template_id == 14)
vcard-fourteen-heading
@elseif($privacyPolicy->vcard->template_id == 15)
                            vcard-fifteen-heading
@elseif($privacyPolicy->vcard->template_id == 13)
                            vcard-thirteen-heading
@elseif($privacyPolicy->vcard->template_id == 16)
                            vcard-sixteen-heading pt-5
@elseif($privacyPolicy->vcard->template_id == 17)
                            vcard-seventeen-heading
@elseif($privacyPolicy->vcard->template_id == 21)
                            vcard-twentyone-heading
@elseif($privacyPolicy->vcard->template_id == 25)
                            vcard-twentyfive-heading
@elseif($privacyPolicy->vcard->template_id == 22)
                            vcard-twentytwo-heading
@elseif($privacyPolicy->vcard->template_id == 20)
                            vcard-twenty-heading
@elseif($privacyPolicy->vcard->template_id == 18)
                            vcard-eighteen-heading
@elseif($privacyPolicy->vcard->template_id == 24)
vcard-twentyfour-heading
@elseif($privacyPolicy->vcard->template_id == 19)
vcard-nineteen-heading
@elseif($privacyPolicy->vcard->template_id == 26)
                            vcard-twentysix-heading
@elseif($privacyPolicy->vcard->template_id == 28)
                            vcard-twentyeight-heading
@elseif($privacyPolicy->vcard->template_id == 31)
                            vcard-thirtyone-heading
@elseif($privacyPolicy->vcard->template_id == 32)
                            vcard-thirtytwo-heading
@elseif($privacyPolicy->vcard->template_id == 34)
                            vcard-thirtyfour-heading
@elseif($privacyPolicy->vcard->template_id == 36)
                            vcard-thirtysix-heading
@elseif($privacyPolicy->vcard->template_id == 33)
                            vcard-thirtythree-heading
@elseif($privacyPolicy->vcard->template_id == 35)
                            vcard-thirtyfive-heading
@elseif($privacyPolicy->vcard->template_id == 37)
                            vcard-thirtyseven-heading
@elseif($privacyPolicy->vcard->template_id == 30)
                            vcard-thirty-heading
@elseif($privacyPolicy->vcard->template_id == 23)
                            vcard-twentythree-heading
@elseif($privacyPolicy->vcard->template_id == 29)
                            vcard-twentynine-heading
@elseif($privacyPolicy->vcard->template_id == 27)
                            vcard-twentyseven-heading
@elseif($privacyPolicy->vcard->template_id == 38)
                            vcard-thirtyeight-heading
@elseif($privacyPolicy->vcard->template_id == 65)
                            vcard-thirtynine-heading @endif">
                        {{ __('messages.vcard.privacy_policy') }}</h4>
                    <div class="card px-sm-3 px-2 py-md-5 py-3 m-3 card-back">
                        <div class="px-3">
                            {!! $privacyPolicy->privacy_policy !!}
                        </div>
                    </div>
                </div>
                @endif
                @if (!empty($termCondition->term_condition))
                <div class="container">
                    <h4 class="text-center py-4 heading-title
                    @if (isset($privacyPolicy)) @if ($privacyPolicy->vcard->template_id == 1)
                            vcard-one-heading
@elseif($privacyPolicy->vcard->template_id == 2)
                            vcard-two-heading
@elseif($privacyPolicy->vcard->template_id == 3)
                            vcard-three-heading
@elseif($privacyPolicy->vcard->template_id == 4)
                            vcard__heading
@elseif($privacyPolicy->vcard->template_id == 5)
                            contact-heading
@elseif($privacyPolicy->vcard->template_id == 6)
                            vcard-six-heading
@elseif($privacyPolicy->vcard->template_id == 7)
                            vcard-seven-heading
@elseif($privacyPolicy->vcard->template_id == 8)
                            vcard-eight-heading
@elseif($privacyPolicy->vcard->template_id == 9)
                            heading-left
@elseif($privacyPolicy->vcard->template_id == 10)
                            vcard-ten-heading
@elseif($privacyPolicy->vcard->template_id == 12)
                            vcard-twelve-heading
@elseif($privacyPolicy->vcard->template_id == 13)
vcard-thirteen-heading
@elseif($termCondition->vcard->template_id == 14)
vcard-fourteen-heading
@elseif($privacyPolicy->vcard->template_id == 15)
                         vcard-fifteen-heading
@elseif($privacyPolicy->vcard->template_id == 13)
                            vcard-thirteen-heading
@elseif($privacyPolicy->vcard->template_id == 16)
                            vcard-sixteen-heading
@elseif($privacyPolicy->vcard->template_id == 17)
                            vcard-seventeen-heading
@elseif($privacyPolicy->vcard->template_id == 21)
                             vcard-twentyone-heading
@elseif($privacyPolicy->vcard->template_id == 25)
                             vcard-twentyfive-heading
@elseif($privacyPolicy->vcard->template_id == 22)
                            vcard-twentytwo-heading
@elseif($privacyPolicy->vcard->template_id == 20)
                            vcard-twenty-heading
@elseif($privacyPolicy->vcard->template_id == 18)
                            vcard-eighteen-heading
@elseif($privacyPolicy->vcard->template_id == 19)
                            vcard-nineteen-heading
@elseif($privacyPolicy->vcard->template_id == 26)
                            vcard-twentysix-heading
@elseif($privacyPolicy->vcard->template_id == 28)
                            vcard-twentyeight-heading
@elseif($privacyPolicy->vcard->template_id == 31)
                            vcard-thirtyone-heading
@elseif($privacyPolicy->vcard->template_id == 32)
                            vcard-thirtytwo-heading
@elseif($privacyPolicy->vcard->template_id == 34)
                            vcard-thirtyfour-heading
@elseif($privacyPolicy->vcard->template_id == 36)
                            vcard-thirtysix-heading
@elseif($privacyPolicy->vcard->template_id == 33)
                            vcard-thirtythree-heading
@elseif($privacyPolicy->vcard->template_id == 35)
                            vcard-thirtyfive-heading
@elseif($privacyPolicy->vcard->template_id == 37)
                            vcard-thirtyseven-heading
@elseif($privacyPolicy->vcard->template_id == 30)
                            vcard-thirty-heading
@elseif($privacyPolicy->vcard->template_id == 24)
vcard-twentyfour-heading
 @elseif($privacyPolicy->vcard->template_id == 23)
                        vcard-twentythree-heading
 @elseif($privacyPolicy->vcard->template_id == 29)
                        vcard-twentynine-heading
 @elseif($privacyPolicy->vcard->template_id == 27)
                        vcard-twentyseven-heading
@elseif($privacyPolicy->vcard->template_id == 38)
                        vcard-thirtyeight-heading
@elseif($privacyPolicy->vcard->template_id == 65)
                        vcard-thirtynine-heading @endif
                    @endif

                    @if (isset($termCondition)) @if ($termCondition->vcard->template_id == 1)
                            vcard-one-heading
@elseif($termCondition->vcard->template_id == 2)
                            vcard-two-heading
@elseif($termCondition->vcard->template_id == 3)
                            vcard-three-heading
@elseif($termCondition->vcard->template_id == 4)
                            vcard__heading
@elseif($termCondition->vcard->template_id == 5)
                            contact-heading
@elseif($termCondition->vcard->template_id == 6)
                            vcard-six-heading
@elseif($termCondition->vcard->template_id == 7)
                            vcard-seven-heading
@elseif($termCondition->vcard->template_id == 8)
                            vcard-eight-heading
@elseif($termCondition->vcard->template_id == 9)
                            heading-left
@elseif($termCondition->vcard->template_id == 10)
                            vcard-ten-heading
@elseif($termCondition->vcard->template_id == 12)
vcard-twelve-heading
@elseif($termCondition->vcard->template_id == 13)
vcard-thirteen-heading
@elseif($termCondition->vcard->template_id == 14)
vcard-fourteen-heading
@elseif($termCondition->vcard->template_id == 15)
                            vcard-fifteen-heading
@elseif($termCondition->vcard->template_id == 13)
                            vcard-thirteen-heading
@elseif($termCondition->vcard->template_id == 16)
                            vcard-sixteen-heading
@elseif($termCondition->vcard->template_id == 17)
                            vcard-seventeen-heading
@elseif($termCondition->vcard->template_id == 21)
                             vcard-twentyone-heading
@elseif($termCondition->vcard->template_id == 25)
                             vcard-twentyfive-heading
@elseif($termCondition->vcard->template_id == 22)
                            vcard-twentytwo-heading
@elseif($termCondition->vcard->template_id == 20)
                            vcard-twenty-heading
@elseif($termCondition->vcard->template_id == 18)
                            vcard-eighteen-heading
@elseif($termCondition->vcard->template_id == 19)
                            vcard-nineteen-heading
@elseif($termCondition->vcard->template_id == 26)
                            vcard-twentysix-heading
@elseif($termCondition->vcard->template_id == 28)
                            vcard-twentyeight-heading
@elseif($termCondition->vcard->template_id == 31)
                            vcard-thirtyone-heading
@elseif($termCondition->vcard->template_id == 32)
                            vcard-thirtytwo-heading
@elseif($termCondition->vcard->template_id == 34)
                            vcard-thirtyfour-heading
@elseif($termCondition->vcard->template_id == 36)
                            vcard-thirtysix-heading
@elseif($termCondition->vcard->template_id == 33)
                            vcard-thirtythree-heading
@elseif($termCondition->vcard->template_id == 35)
                            vcard-thirtyfive-heading
@elseif($termCondition->vcard->template_id == 37)
                            vcard-thirtyseven-heading
@elseif($termCondition->vcard->template_id == 30)
                            vcard-thirty-heading
@elseif($termCondition->vcard->template_id == 24)
                            vcard-twentyfour-heading
@elseif($termCondition->vcard->template_id == 23)
                            vcard-twentythree-heading
@elseif($termCondition->vcard->template_id == 29)
                            vcard-twentynine-heading
@elseif($termCondition->vcard->template_id == 27)
                            vcard-twentyseven-heading
@elseif($termCondition->vcard->template_id == 38)
                            vcard-thirtyeight-heading
@elseif($termCondition->vcard->template_id == 65)
                            vcard-thirtynine-heading @endif
                    @endif
                            ">
                        {!! __('messages.vcard.term_condition') !!}</h4>
                    <div class="card px-sm-3 px-2 py-md-5 py-3 m-3 card-back">
                        <div class="px-3 ">
                            {!! $termCondition->term_condition !!}
                        </div>
                    </div>
                </div>
                @endif
                <div class="text-center mt-5 pb-5">
                    <a href="{{ $vcardUrl }}" class="text-decoration-none px-4 cursor-pointer terms-policies-btn
             @if (isset($privacyPolicy)) @if ($privacyPolicy->vcard->template_id == 1)
                        vcard-one-btn
@elseif($privacyPolicy->vcard->template_id == 2)
                        vcard-two-btn
@elseif($privacyPolicy->vcard->template_id == 3)
                        vcard-three-btn
@elseif($privacyPolicy->vcard->template_id == 4)
                        vcard-four-btn
@elseif($privacyPolicy->vcard->template_id == 5)
                        vcard-five-btn
@elseif($privacyPolicy->vcard->template_id == 6)
                        vcard-six-btn
@elseif($privacyPolicy->vcard->template_id == 7)
                        vcard-seven-btn text-dark
@elseif($privacyPolicy->vcard->template_id == 8)
                        vcard-eight-btn
@elseif($privacyPolicy->vcard->template_id == 9)
                        vcard-nine-btn
@elseif($privacyPolicy->vcard->template_id == 10)
                        vcard-ten-btn
@elseif($privacyPolicy->vcard->template_id == 12)
                        vcard-twelve-btn
@elseif($privacyPolicy->vcard->template_id == 13)
vcard-thirteen-btn text-dark
@elseif($privacyPolicy->vcard->template_id == 14)
vcard-fourteen-btn
@elseif($privacyPolicy->vcard->template_id == 15)
                        vcard-fifteen-btn
@elseif($privacyPolicy->vcard->template_id == 13)
                        vcard-thirteen-btn text-dark
@elseif($privacyPolicy->vcard->template_id == 16)
                        vcard-sixteen-btn
@elseif($privacyPolicy->vcard->template_id == 17)
                        vcard-seventeen-btn text-white
@elseif($privacyPolicy->vcard->template_id == 21)
                       vcard-twentyone-btn
@elseif($privacyPolicy->vcard->template_id == 25)
                       vcard-twentyfive-btn
@elseif($privacyPolicy->vcard->template_id == 22)
                       vcard-twentytwo-btn" data-button-style="{{ isset($dynamicVcard) ? $dynamicVcard->button_style : 'default' }}
@elseif($privacyPolicy->vcard->template_id == 20)
                        vcard-twenty-btn text-white
@elseif($privacyPolicy->vcard->template_id == 18)
                        vcard-eighteen-btn
@elseif($privacyPolicy->vcard->template_id == 19)
                        vcard-nineteen-btn
@elseif($privacyPolicy->vcard->template_id == 26)
                        vcard-twentytsix-btn
@elseif($privacyPolicy->vcard->template_id == 28)
                        vcard-twentyteight-btn
@elseif($privacyPolicy->vcard->template_id == 31)
                        vcard-thirtyone-btn
@elseif($privacyPolicy->vcard->template_id == 32)
                        vcard-thirtytwo-btn
@elseif($privacyPolicy->vcard->template_id == 34)
                        vcard-thirtyfour-btn
@elseif($privacyPolicy->vcard->template_id == 36)
                        vcard-thirtysix-btn btn btn-secondary
@elseif($privacyPolicy->vcard->template_id == 33)
                        vcard-thirtythree-btn
@elseif($privacyPolicy->vcard->template_id == 35)
                        vcard-thirtyfive-btn
@elseif($privacyPolicy->vcard->template_id == 37)
                        vcard-thirtyseven-btn text-white
@elseif($privacyPolicy->vcard->template_id == 30)
                        vcard-thirty-btn
@elseif($privacyPolicy->vcard->template_id == 24)
                        vcard-twentyfour-btn
 @elseif($privacyPolicy->vcard->template_id == 23)
                        vcard-twentythree-btn
 @elseif($privacyPolicy->vcard->template_id == 29)
                        vcard-twentynine-btn
 @elseif($privacyPolicy->vcard->template_id == 27)
                        vcard-twentyseven-btn
@elseif($privacyPolicy->vcard->template_id == 38)
                        vcard-thirtyeight-btn
@elseif($privacyPolicy->vcard->template_id == 65)
                        vcard-thirtynine-btn @endif
                @endif
                @if (isset($termCondition)) @if ($termCondition->vcard->template_id == 1)
                        vcard-one-btn
@elseif($termCondition->vcard->template_id == 2)
                        vcard-two-btn
@elseif($termCondition->vcard->template_id == 3)
                        vcard-three-btn
@elseif($termCondition->vcard->template_id == 4)
                        vcard-four-btn
@elseif($termCondition->vcard->template_id == 5)
                        vcard-five-btn
@elseif($termCondition->vcard->template_id == 6)
                        vcard-six-btn
@elseif($termCondition->vcard->template_id == 7)
                        vcard-seven-btn text-dark
@elseif($termCondition->vcard->template_id == 8)
                        vcard-eight-btn
@elseif($termCondition->vcard->template_id == 9)
                        vcard-nine-btn
@elseif($termCondition->vcard->template_id == 10)
                        vcard-ten-btn
@elseif($termCondition->vcard->template_id == 12)
                        vcard-twelve-btn
@elseif($termCondition->vcard->template_id == 13)
vcard-thirteen-btn text-dark
@elseif($termCondition->vcard->template_id == 14)
vcard-fourteen-btn
@elseif($termCondition->vcard->template_id == 15)
vcard-fifteen-btn
@elseif($termCondition->vcard->template_id == 16)
vcard-sixteen-btn
@elseif($termCondition->vcard->template_id == 17)
vcard-seventeen-btn
@elseif($termCondition->vcard->template_id == 21)
vcard-twentyone-btn
@elseif($termCondition->vcard->template_id == 25)
vcard-twentyfive-btn
@elseif($termCondition->vcard->template_id == 22)
vcard-twentytwo-btn" data-button-style="{{ isset($dynamicVcard) ? $dynamicVcard->button_style : 'default' }}
@elseif($termCondition->vcard->template_id == 20)
vcard-twenty-btn
@elseif($termCondition->vcard->template_id == 18)
vcard-eighteen-btn
@elseif($termCondition->vcard->template_id == 19)
vcard-nineteen-btn
@elseif($termCondition->vcard->template_id == 26)
vcard-twentytsix-btn
@elseif($termCondition->vcard->template_id == 28)
vcard-twentyeight-btn
@elseif($termCondition->vcard->template_id == 31)
vcard-thirtyone-btn
@elseif($termCondition->vcard->template_id == 32)
vcard-thirtytwo-btn
@elseif($termCondition->vcard->template_id == 34)
vcard-thirtyfour-btn
@elseif($termCondition->vcard->template_id == 36)
vcard-thirtysix-btn btn btn-secondary
@elseif($termCondition->vcard->template_id == 33)
vcard-thirtythree-btn btn
@elseif($termCondition->vcard->template_id == 35)
vcard-thirtyfive-btn
@elseif($termCondition->vcard->template_id == 37)
vcard-thirtyseven-btn text-white
@elseif($termCondition->vcard->template_id == 30)
    vcard-thirty-btn
@elseif($termCondition->vcard->template_id == 23)
vcard-twentythree-btn
@elseif($termCondition->vcard->template_id == 29)
vcard-twentynine-btn
@elseif($termCondition->vcard->template_id == 24)
vcard-twentyfour-btn
@elseif($termCondition->vcard->template_id == 27)
vcard-twentyseven-btn
@elseif($termCondition->vcard->template_id == 38)
vcard-thirtyeight-btn
@elseif($termCondition->vcard->template_id == 65)
vcard-thirtynine-btn @endif
                @endif
                        ">{{ __('messages.common.back') }}
                        @if (isset($termCondition))
                        @if ($termCondition->vcard->template_id == 33)
                        <div class="wave"></div>
                        @endif
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('backend/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var primaryColor = @json($dynamicVcard->primary_color ?? null);
            var backColor = @json($dynamicVcard->back_color ?? null);
            var backSecondColor = @json($dynamicVcard->back_seconds_color ?? null);
            var buttonTextColor = @json($dynamicVcard->button_text_color ?? null);
            var textDescriptionColor = @json($dynamicVcard->text_label_color ?? null);
            var textLabelColor = @json($dynamicVcard->text_description_color ?? null);
            var cardsBackColor = @json($dynamicVcard->cards_back ?? null);

            document.documentElement.style.setProperty('--primary-color', primaryColor);
            document.documentElement.style.setProperty('--green-100', backColor);
            document.documentElement.style.setProperty('--green', backSecondColor);
            document.documentElement.style.setProperty('--black', buttonTextColor);
            document.documentElement.style.setProperty('--gray-100', textDescriptionColor);
            document.documentElement.style.setProperty('--white', textLabelColor);
            document.documentElement.style.setProperty('--light', cardsBackColor);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            var buttonStyle = @json($dynamicVcard->button_style ?? null);
            applyButtonStyle(buttonStyle);
        });

        function applyButtonStyle(buttonStyle) {
            const buttons = document.querySelectorAll('.vcard-twentytwo-btn');
            if (buttonStyle === 'default' || !buttonStyle) {
                buttonStyle = '1';
            }
            buttons.forEach(button => {
                button.classList.add(`dynamic-btn-${buttonStyle}`);
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const targets = document.querySelectorAll(".vcard-thirteen-effect");

        if (!tsParticles || targets.length === 0) return;

        targets.forEach((el) => {
          tsParticles.load(el, {
            fpsLimit: 60,
            particles: {
              number: {
                value: 60,
                density: {
                  enable: true,
                  area: 800
                }
              },
              color: { value: "#c9ecec" },
              shape: {
                type: "circle",
                stroke: { width: 0, color: "#000000" },
                polygon: { sides: 5 },
                image: {
                  src: "https://cdn.matteobruni.it/images/particles/github.svg",
                  width: 100,
                  height: 100
                }
              },
              opacity: {
                value: 1,
                animation: { enable: false }
              },
              size: {
                value: 7,
                random: { enable: true, minimumValue: 2 },
                animation: { enable: false }
              },
              lineLinked: {
                enable: false
              },
              move: {
                collisions: true,
                enable: true,
                speed: 0.5,
                out_mode: "bounce"
              }
            },
            interactivity: {
              detect_on: "canvas",
              events: {
                onClick: { enable: true, mode: "push" },
                resize: true
              },
              modes: {
                push: { particles_nb: 4 }
              }
            },
            detectRetina: true
          });
        });
      });
    </script>
    @if (isset($privacyPolicy))
    @if($privacyPolicy->vcard->template_id == 28)
    <script>
        const svgShapes = [ `<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 20 20" fill="none">
        <path d="M11.4025 1.14664C9.16811 3.38346 8.84891 7.21802 11.0833 7.21802C13.1581 7.21802 16.1906 1.14664 14.5946 0.188004C13.7966 -0.291315 12.3601 0.188004 11.4025 1.14664Z" fill="#6549C2" fill-opacity="0.5"/>
        <path d="M4.22028 1.94551C2.14546 3.86278 3.10307 7.21802 5.49709 7.21802C6.7739 7.21802 7.89111 5.78006 7.89111 4.02256C7.89111 0.827097 6.1355 -0.131541 4.22028 1.94551Z" fill="#6549C2" fill-opacity="0.5"/>
        <path d="M15.3924 5.7804C12.2004 7.69768 11.7216 10.4138 14.9136 10.4138C17.6269 10.4138 21.2977 6.25972 19.5421 5.14131C18.7441 4.66199 16.9885 4.98154 15.3924 5.7804Z" fill="#6549C2" fill-opacity="0.5"/>
        <path d="M1.02843 9.9343C-0.886789 11.8516 -0.0887816 13.4493 3.10325 14.4079C4.85886 14.8873 6.29528 16.485 6.29528 17.7632C6.29528 19.0414 7.41249 20 8.6893 20C10.2853 20 11.0833 18.2425 11.0833 14.4079C11.0833 9.29521 10.6045 8.81589 6.61448 8.81589C4.06086 8.81589 1.50723 9.29521 1.02843 9.9343Z" fill="#6549C2" fill-opacity="0.5"/>
        <path d="M12.6794 14.5677C12.6794 16.0057 13.7967 16.8045 15.3927 16.485C19.3827 15.6861 19.8615 12.0113 16.0311 12.0113C14.1159 12.0113 12.6794 12.97 12.6794 14.5677Z" fill="#6549C2" fill-opacity="0.5"/>
      </svg>`,
      `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 15 16" fill="none">
        <path d="M2.29995 2.67613C-3.40345 8.468 2.29995 17.1558 10.6649 15.0321C14.4672 14.0668 15.4178 12.7154 14.8474 8.66107C14.4672 5.76513 13.5166 3.25531 12.376 2.86919C8.95392 1.90388 5.15165 5.76513 6.29233 9.04719C7.05279 10.7848 8.57369 11.557 9.71437 10.7848C11.2353 10.0125 11.0452 9.04719 9.33415 7.88882C7.2429 6.53738 7.43301 6.15125 10.0946 6.15125C14.2771 6.15125 14.2771 11.1709 10.2847 12.7154C7.2429 13.8738 1.91973 10.9778 1.91973 7.88882C1.91973 7.11657 3.25052 4.99288 4.96154 3.44838C6.48245 1.71081 7.2429 0.359375 6.29233 0.359375C5.34177 0.359375 3.63075 1.32469 2.29995 2.67613Z" fill="#6549C2" fill-opacity="0.5"/>
      </svg>`,
    `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="18" viewBox="0 0 14 18" fill="none">
        <path d="M4.9 1.23025C2.1 1.57369 0 2.26056 0 2.77571C0 4.49288 9.275 17.2 10.5 17.2C11.9 17.2 14 8.78581 14 3.29086C14 1.40197 12.95 0.199952 11.9 0.199952C10.675 0.371669 7.525 0.88682 4.9 1.23025ZM11.55 6.21005C11.025 7.75551 10.5 10.1595 10.5 11.705C10.5 13.9373 9.625 13.5939 7 10.3313C2.45 4.6646 2.625 3.46258 8.05 3.46258C11.55 3.46258 12.425 4.14945 11.55 6.21005Z" fill="#6549C2" fill-opacity="0.5"/>
    </svg>`,
    `<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 20 20" fill="none">
        <path d="M11.4025 1.14664C9.16811 3.38346 8.84891 7.21802 11.0833 7.21802C13.1581 7.21802 16.1906 1.14664 14.5946 0.188004C13.7966 -0.291315 12.3601 0.188004 11.4025 1.14664Z" fill="#6549C2" fill-opacity="0.5"/>
        <path d="M4.22028 1.94551C2.14546 3.86278 3.10307 7.21802 5.49709 7.21802C6.7739 7.21802 7.89111 5.78006 7.89111 4.02256C7.89111 0.827097 6.1355 -0.131541 4.22028 1.94551Z" fill="#6549C2" fill-opacity="0.5"/>
        <path d="M15.3924 5.7804C12.2004 7.69768 11.7216 10.4138 14.9136 10.4138C17.6269 10.4138 21.2977 6.25972 19.5421 5.14131C18.7441 4.66199 16.9885 4.98154 15.3924 5.7804Z" fill="#6549C2" fill-opacity="0.5"/>
        <path d="M1.02843 9.9343C-0.886789 11.8516 -0.0887816 13.4493 3.10325 14.4079C4.85886 14.8873 6.29528 16.485 6.29528 17.7632C6.29528 19.0414 7.41249 20 8.6893 20C10.2853 20 11.0833 18.2425 11.0833 14.4079C11.0833 9.29521 10.6045 8.81589 6.61448 8.81589C4.06086 8.81589 1.50723 9.29521 1.02843 9.9343Z" fill="#6549C2" fill-opacity="0.5"/>
        <path d="M12.6794 14.5677C12.6794 16.0057 13.7967 16.8045 15.3927 16.485C19.3827 15.6861 19.8615 12.0113 16.0311 12.0113C14.1159 12.0113 12.6794 12.97 12.6794 14.5677Z" fill="#6549C2" fill-opacity="0.5"/>
      </svg>`];

        const container = document.querySelector('.vcard-twentyeight-effect');
        const particles = [];
        const size = 110; // in px
        const count = 60;

        function isOverlapping(x, y, others) {
          return others.some(p => {
            return Math.abs(p.x - x) < size && Math.abs(p.y - y) < size;
          });
        }

        for (let i = 0; i < count; i++) {
          const particle = document.createElement('div');
          particle.className = 'particle-vcard28';
          particle.innerHTML = svgShapes[i % svgShapes.length];
          container.appendChild(particle);

          let x, y, tries = 0;
          do {
            x = Math.random() * (container.clientWidth - size);
            y = Math.random() * (container.clientHeight - size);
            tries++;
            if (tries > 1000) break;
          } while (isOverlapping(x, y, particles));

          const speedX = (Math.random() - 0.5) * 1.2;
          const speedY = (Math.random() - 0.5) * 1.2;

          particles.push({ el: particle, x, y, speedX, speedY });
        }

        function animate() {
          for (let i = 0; i < particles.length; i++) {
            const p = particles[i];

            p.x += p.speedX;
            p.y += p.speedY;

            if (p.x < 0 || p.x > container.clientWidth - size) p.speedX *= -1;
            if (p.y < 0 || p.y > container.clientHeight - size) p.speedY *= -1;

            for (let j = 0; j < particles.length; j++) {
              if (i === j) continue;
              const other = particles[j];
              if (Math.abs(p.x - other.x) < size && Math.abs(p.y - other.y) < size) {
                p.speedX *= -1;
                p.speedY *= -1;
                break;
              }
            }

            p.el.style.transform = `translate(${p.x}px, ${p.y}px)`;
          }

          requestAnimationFrame(animate);
        }

        animate();
    </script>
    @endif
    @endif
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 37)
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
                return [
                    { transform: 'rotate(-47deg)', left: '50%', marginLeft: `-${this.size / 4}px`, top: '0' },
                    { transform: 'rotate(15deg)', left: '100%', marginLeft: `-${this.size * 0.39}px`, top: `${this.size * 0.175}px` },
                    { transform: 'rotate(93deg)', left: '100%', marginLeft: `-${this.size * 0.51}px`, top: `${this.size * 0.58}px` },
                    { transform: 'rotate(175deg)', left: '0%', marginLeft: `${this.size * 0.05}px`, top: `${this.size * 0.58}px` },
                    { transform: 'rotate(250deg)', left: '0%', marginLeft: `-${this.size * 0.08}px`, top: `${this.size * 0.175}px` }
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
                    new Flower({ top, left });
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
    @endIf
    @endif
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 24)
    <script>
        'use strict';
        var app = {
          chars: 'abcdefghijklmnopqrstuvwxyz0123456789±×÷=≠≈√∞πΣ∑ΔΩ∫∇∂≤≥≡⊕⊗∩∪∅∃∀∈∉→←↔⇌∴∵'.split(''),
          colors: ['#423f8d', '#1cbbb4', '#ed078b', '#f7941e'],

          init: function () {
            app.container = document.createElement('div');
            app.container.className = 'animation-container';
            document.body.appendChild(app.container);
            setInterval(app.add, 100);
          },

          add: function () {
            var element = document.createElement('span');
            app.container.appendChild(element);
            app.animate(element);
          },

          animate: function (element) {
            var character = app.chars[Math.floor(Math.random() * app.chars.length)];
            var duration = Math.random() * 10 + 10;
            var offset = Math.random() * 100;
            var size = Math.floor(Math.random() * 26) + 10;
            var color = app.colors[Math.floor(Math.random() * app.colors.length)];
            element.style.left = offset + 'vw';
            element.style.fontSize = size + 'px';
            element.style.animationDuration = duration + 's';
            element.style.color = color;
            var inner = document.createElement('span');
            inner.className = 'char';
            inner.textContent = character;

            element.appendChild(inner);

            setTimeout(function () {
              if (element && element.parentNode) {
                element.parentNode.removeChild(element);
              }
            }, duration * 1000);
          }
        };

        document.addEventListener('DOMContentLoaded', app.init);
      </script>
    @endif
    @endif
    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 18)
    <script>
      window.onload = function () {
           tsParticles.load("background", {
        fullScreen: { enable: true, zIndex: -1 },
        particles: {
          number: { value: 70 },
          color: {
            value: [
              "rgba(54,153,186,0.3)",
              "rgba(54,153,186,0.1)",
              "rgba(246,153,4,0.3)",
              "rgba(246,153,4,0.1)"
            ]
          },
          shape: {
            type: ["circle", "polygon"]
          },
          opacity: {
            value: 0.3,
            random: true
          },
          size: {
            value: { min: 7, max: 13 }
          },
          move: {
            enable: true,
            speed: .3,
            direction: "none",
            outModes: "out"
          }
        },
        interactivity: {
          events: {
            onHover: { enable: false, mode: "repulse" },
            onClick: { enable: false, mode: "push" }
          },
          modes: {
            repulse: { distance: 100 },
            push: { quantity: 4 }
          }
        }
      });
      };
    </script>
    @endif
    @endif

    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 16)
        <script>
            var axe = "X",
                numberOfSquare = 25,
                greyMinimum = 210,
                greyMaximum = 245,
                animMin = 2, // Animation durations (in seconds)
                animMax = 8;

            // Select the container
            var tc = document.querySelector(".trianglesContainer");

            function createTriangles() {
                let w = tc.offsetWidth,
                    h = tc.offsetHeight,
                    dx;

                // Clear previous SVG
                tc.innerHTML = "";

                // Decide square size
                dx = (axe === "X") ? (w / numberOfSquare) : (h / numberOfSquare);

                // Create SVG
                let svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svg.setAttribute("width", w);
                svg.setAttribute("height", h);

                // Loop through squares
                for (let i = 0; i < w / dx; i++) {
                    for (let j = 0; j < h / dx; j++) {

                        let c1 = rdmColor(greyMinimum, greyMaximum);
                        let c2 = rdmColor(greyMinimum, greyMaximum);

                        let middleX = (i * dx + dx / 2),
                            middleY = (j * dx + dx / 2);

                        let paths = [
                            `M ${i*dx} ${j*dx} h ${dx} L ${middleX} ${middleY}`,
                            `M ${i*dx} ${(j+1)*dx} h ${dx} L ${middleX} ${middleY}`,
                            `M ${i*dx} ${j*dx} v ${dx} L ${middleX} ${middleY}`,
                            `M ${(i+1)*dx} ${j*dx} v ${dx} L ${middleX} ${middleY}`
                        ];

                        paths.forEach(pathData => {
                            let path = document.createElementNS("http://www.w3.org/2000/svg", "path");
                            path.setAttribute("d", pathData);
                            path.setAttribute("fill", c1);
                            path.setAttribute("stroke", c1);

                            let animate = document.createElementNS("http://www.w3.org/2000/svg", "animate");
                            animate.setAttribute("attributeName", "fill");
                            animate.setAttribute("values", `${c1};${c2};${c1}`);
                            animate.setAttribute("dur", `${rdmInt(animMin, animMax)}s`);
                            animate.setAttribute("repeatCount", "indefinite");

                            path.appendChild(animate);
                            svg.appendChild(path);
                        });
                    }
                }

                tc.appendChild(svg);
            }

            function rdmInt(min, max) {
                return Math.round(Math.random() * (max - min) + min);
            }

            function rdmColor(min, max) {
                let color = rdmInt(min, max);
                return `rgb(${color},${color},${color})`;
            }

            // Call on load and resize
            window.onload = createTriangles;
            window.addEventListener("resize", createTriangles);
        </script>
    @endif
    @endif

    @if (isset($privacyPolicy))
    @if ($privacyPolicy->vcard->template_id == 33)
    <script>
        tsParticles.load("vcardthirty-effect-bg", {
        background: {
            color: "transparent"
        },
        fpsLimit: 60,
        particles: {
            number: { value: 40 },
            color: {
            value: ["#ffffff", "#ffb347", "#3db2ff", "#29ffbf"]
            },
            shape: {
            type: "character",
            character: [
                { value: "🎵" }, { value: "🎶" }, { value: "🎤" }, { value: "🎧" },
                { value: "🎹" }, { value: "🎼" }
            ]
            },
            opacity: {
            value: 1,
            animation: {
                enable: true,
                speed: 1,
                minimumValue: 0.3,
                sync: false
            }
            },
            size: {
            value: { min: 12, max: 28 },
            animation: {
                enable: true,
                speed: 4,
                minimumValue: 8,
                sync: false
            }
            },
            rotate: {
            value: { min: 0, max: 360 },
            direction: "random",
            animation: {
                enable: true,
                speed: 8,
                sync: false
            }
            },
            move: {
            enable: true,
            speed: 2,
            direction: "top",
            straight: false,
            outModes: { default: "out" }
            }
        },
        detectRetina: true
        });
    </script>
    @endif
    @endif

@if (isset($privacyPolicy))
@if ($privacyPolicy->vcard->template_id == 33)
<script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>
<script>
    particlesJS("particles-js", {
    particles: {
        number: {
        value: 100,
        density: {
            enable: true,
            value_area: 631.3280775270874
        }
        },
        color: {
        value: "#34137c"
        },
        shape: {
        type: "circle",
        stroke: {
            width: 0,
            color: "#000000"
        },
        polygon: {
            nb_sides: 5
        },
        image: {
            src: "img/github.svg",
            width: 100,
            height: 100
        }
        },
        opacity: {
        value: 0.75,
        random: true,
        anim: {
            enable: false,
            speed: 1,
            opacity_min: 0.1,
            sync: false
        }
        },
        size: {
        value: 3.5,
        random: true,
        anim: {
            enable: false,
            speed: 40,
            size_min: 0.1,
            sync: false
        }
        },
        line_linked: {
        enable: false,
        distance: 500,
        color: "#ffffff",
        opacity: 0.1,
        width: 2
        },
        move: {
        enable: true,
        speed: 0.5,
        direction: "random",
        random: false,
        straight: false,
        out_mode: "out",
        bounce: false,
        attract: {
            enable: false,
            rotateX: 600,
            rotateY: 1200
        }
        }
    },
    interactivity: {
        detect_on: "canvas",
        events: {
        onhover: {
            enable: false,
            mode: "bubble"
        },
        onclick: {
            enable: true,
            mode: "repulse"
        },
        resize: true
        },
        modes: {
        grab: {
            distance: 400,
            line_linked: {
            opacity: 0.5
            }
        },
        bubble: {
            distance: 400,
            size: 4,
            duration: 0.3,
            opacity: 1,
            speed: 3
        },
        repulse: {
            distance: 200,
            duration: 0.4
        },
        push: {
            particles_nb: 4
        },
        remove: {
            particles_nb: 2
        }
        }
    },
    retina_detect: true
    });
</script>
@endif
@endif
@if (isset($privacyPolicy))
@if ($privacyPolicy->vcard->template_id == 38)
<script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>
<script>
tsParticles.load("vcard38Tsparticles", {
  fps_limit: 60,
  interactivity: {
    detect_on: "canvas",
    events: {
      onclick: { enable: false, mode: "push" },
      onhover: {
        enable: false,
        mode: "repulse" // keep repulse but very short duration
      },
      resize: true
    },
    modes: {
      bubble: { distance: 400, duration: 2, opacity: 0.8, size: 40, speed: 3 },
      push: { particles_nb: 4 },
      repulse: { distance: 200, duration: 0.1 } // shorter repulse
    }
  },
  particles: {
    color: { value: "#716659" },
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
    number: { density: { enable: true, value_area: 800 }, value: 80 },
    opacity: { value: 0.5 },
    shape: { type: "circle" },
    size: { random: true, value: 5 }
  },
  retina_detect: true
});
</script>
@endif
@endif
</body>

</html>
