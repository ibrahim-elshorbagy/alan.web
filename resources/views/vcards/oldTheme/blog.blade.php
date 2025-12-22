<html lang="en">

<head>
    <link>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>{{ $blog->vcard->name }} | {{ getAppName() }}</title>

    {{-- css link --}}
    <link rel="stylesheet" href="{{ asset('assets/css/oldVcard/vcard1.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/oldVcard/blog.css') }}">

    {{-- font-awesome --}}
    <link href="{{ asset('backend/css/all.min.css') }}" rel="stylesheet">

    {{-- google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <div class="container h-100">
        {{-- @dd(getLanguage($blog->vcard)== 'Arabic') --}}
        <div
            class="vcard-one main-content w-100 h-auto mx-auto
    @if ($blog->vcard->template_id == 1) vcard-one-bg
    @elseif($blog->vcard->template_id == 2)
            vcard-two-bg
    @elseif($blog->vcard->template_id == 3)
            vcard-three-bg
    @elseif($blog->vcard->template_id == 4)
            vcard-four-bg
    @elseif($blog->vcard->template_id == 5)
            vcard-five-bg
    @elseif($blog->vcard->template_id == 6)
            vcard-six-bg
    @elseif($blog->vcard->template_id == 7)
            vcard-seven-bg h-auto
    @elseif($blog->vcard->template_id == 8)
            vcard-eight-bg h-auto
    @elseif($blog->vcard->template_id == 9)
            vcard-nine-bg
    @elseif($blog->vcard->template_id == 10)
            vcard-ten-bg
    @elseif($blog->vcard->template_id == 40)
           vcard-thirteen-bg
    @elseif($blog->vcard->template_id == 41)
           vcard-fourteen-bg
    @elseif($blog->vcard->template_id == 39)
            vcard-twelve-bg
    @elseif($blog->vcard->template_id == 42)
            vcard-fifteen-bg
    @elseif($blog->vcard->template_id == 43)
            vcard-sixteen-bg
    @elseif($blog->vcard->template_id == 44)
            vcard-seventeen-bg
    @elseif($blog->vcard->template_id == 48)
            vcard-twentyone-bg
    @elseif($blog->vcard->template_id == 52)
            vcard-twentyfive-bg
    @elseif($blog->vcard->template_id == 49)
            vcard-twentytwo-bg h-auto
    @elseif($blog->vcard->template_id == 47)
            vcard-twenty-bg
    @elseif($blog->vcard->template_id == 45)
    vcard-eighteen-bg
    @elseif($blog->vcard->template_id == 46)
            vcard-nineteen-bg
    @elseif($blog->vcard->template_id == 53)
            vcard-twentysix-bg h-auto
    @elseif($blog->vcard->template_id == 55)
            vcard-twentyeight-bg h-auto
    @elseif($blog->vcard->template_id == 57)
            vcard-thirty-bg h-auto
    @elseif($blog->vcard->template_id == 56)
            vcard-twentynine-bg h-auto
    @elseif($blog->vcard->template_id == 50)
            vcard-twentythree-bg h-auto
    @elseif($blog->vcard->template_id == 51)
            vcard-twentyfour-bg h-auto
    @elseif($blog->vcard->template_id == 58)
            vcard-thirtyone-bg h-auto
    @elseif($blog->vcard->template_id == 59)
            vcard-thirtytwo-bg h-auto
    @elseif($blog->vcard->template_id == 61)
            vcard-thirtyfour-bg h-auto
    @elseif($blog->vcard->template_id == 60)
            vcard-thirtythree-bg h-auto
    @elseif($blog->vcard->template_id == 62)
            vcard-thirtyfive-bg h-auto
    @elseif($blog->vcard->template_id == 63)
            vcard-thirtysix-bg h-auto
    @elseif($blog->vcard->template_id == 64)
            vcard-thirtyseven-bg h-auto
    @elseif($blog->vcard->template_id == 54)
            vcard-twentyseven-bg h-auto @endif">
            <div class="vcard-one-main-section p-3">
                <div class="d-flex justify-content-between align-items-center py-3"
                    @if (getLanguage($blog->vcard) == 'Arabic') dir="rtl" @endif>
                    <h2
                        class="blog-title
             @if ($blog->vcard->template_id == 1) vcard-one-title
            @elseif($blog->vcard->template_id == 2)
                        vcard-two-title
@elseif($blog->vcard->template_id == 3)
                        vcard-three-title
@elseif($blog->vcard->template_id == 4)
                        vcard-four-title
@elseif($blog->vcard->template_id == 5)
                        vcard-five-title
@elseif($blog->vcard->template_id == 6)
                        vcard-six-title
@elseif($blog->vcard->template_id == 7)
                        vcard-seven-title
@elseif($blog->vcard->template_id == 8)
                        vcard-eight-title
@elseif($blog->vcard->template_id == 9)
                        vcard-nine-title
@elseif($blog->vcard->template_id == 10)
                        vcard-ten-title
@elseif($blog->vcard->template_id == 40)
                   vcard-thirteen-title
@elseif($blog->vcard->template_id == 41)
                   vcard-fourteen-title
@elseif($blog->vcard->template_id == 39)
                    vcard-twelve-title
@elseif($blog->vcard->template_id == 42)
                        vcard-fifteen-title
@elseif($blog->vcard->template_id == 44)
                vcard-seventeen-title text-dark
@elseif($blog->vcard->template_id == 43)
                        vcard-sixteen-title
@elseif($blog->vcard->template_id == 48)
                        vcard-twentyone-title
@elseif($blog->vcard->template_id == 51)
                        vcard-twentyfour-title
@elseif($blog->vcard->template_id == 52)
                        vcard-twentyfive-title
@elseif($blog->vcard->template_id == 49)
                        vcard-twentytwo-title
@elseif($blog->vcard->template_id == 47)
vcard-twenty-title
@elseif($blog->vcard->template_id == 45)
                        vcard-eighteen-title
@elseif($blog->vcard->template_id == 46)
                        vcard-nineteen-title
@elseif($blog->vcard->template_id == 53)
                        vcard-twentysix-title
@elseif($blog->vcard->template_id == 55)
                        vcard-twentyeight-title
@elseif($blog->vcard->template_id == 57)
                        vcard-thirty-title
@elseif($blog->vcard->template_id == 56)
                        vcard-twentynine-title
@elseif($blog->vcard->template_id == 50)
                        vcard-twentythree-title
@elseif($blog->vcard->template_id == 58)
                        vcard-thirtyone-title
@elseif($blog->vcard->template_id == 59)
                        vcard-thirtytwo-title
@elseif($blog->vcard->template_id == 61)
                        vcard-thirtyfour-title
@elseif($blog->vcard->template_id == 60)
                        vcard-thirtythree-title
@elseif($blog->vcard->template_id == 62)
                        vcard-thirtyfive-title
@elseif($blog->vcard->template_id == 63)
                        vcard-thirtysix-title
@elseif($blog->vcard->template_id == 64)
                        vcard-thirtyseven-title
@elseif($blog->vcard->template_id == 54)
                        vcard-twentyseven-title @endif">
                        {{ $blog->title }}</h2>
                    <div class="blog-hover-btn">
                        <a class="btn
                    @if ($blog->vcard->template_id == 1) vcard-one-back
                    @elseif($blog->vcard->template_id == 2)
                            vcard-two-back
                    @elseif($blog->vcard->template_id == 3)
                            vcard-three-back
                    @elseif($blog->vcard->template_id == 4)
                            vcard-four-back
                    @elseif($blog->vcard->template_id == 5)
                            vcard-five-back
                    @elseif($blog->vcard->template_id == 6)
                            vcard-six-back
                    @elseif($blog->vcard->template_id == 7)
                            vcard-seven-back
                    @elseif($blog->vcard->template_id == 8)
                            vcard-eight-back
                    @elseif($blog->vcard->template_id == 9)
                            vcard-nine-back
                    @elseif($blog->vcard->template_id == 10)
                            vcard-ten-back
                    @elseif($blog->vcard->template_id == 40)
                            vcard-thirteen-back
                    @elseif($blog->vcard->template_id == 41)
                            vcard-fourteen-back
                    @elseif($blog->vcard->template_id == 39)
                            vcard-twelve-back
                    @elseif($blog->vcard->template_id == 42)
                            vcard-fifteen-back
                    @elseif($blog->vcard->template_id == 44)
                            vcard-seventeen-back
                    @elseif($blog->vcard->template_id == 43)
                            vcard-sixteen-back
                    @elseif($blog->vcard->template_id == 48)
                            vcard-twentyone-back
                    @elseif($blog->vcard->template_id == 51)
                            vcard-twentyfour-back
                    @elseif($blog->vcard->template_id == 52)
                            vcard-twentyfive-back
                    @elseif($blog->vcard->template_id == 49)
                            vcard-twentytwo-back" data-button-style="{{ isset($dynamicVcard) ? $dynamicVcard->button_style : 'default' }}
                    @elseif($blog->vcard->template_id == 47)
                            vcard-twenty-back
                    @elseif($blog->vcard->template_id == 45)
                            vcard-eighteen-back
                    @elseif($blog->vcard->template_id == 46)
                            vcard-nineteen-back
                    @elseif($blog->vcard->template_id == 53)
                            vcard-twentysix-back
                    @elseif($blog->vcard->template_id == 55)
                            vcard-twentyeight-back
                    @elseif($blog->vcard->template_id == 57)
                            vcard-thirty-back
                    @elseif($blog->vcard->template_id == 56)
                            vcard-twentynine-back
                    @elseif($blog->vcard->template_id == 50)
                            vcard-twentythree-back
                    @elseif($blog->vcard->template_id == 58)
                            vcard-thirtyone-back
                    @elseif($blog->vcard->template_id == 59)
                            vcard-thirtytwo-back
                    @elseif($blog->vcard->template_id == 61)
                            vcard-thirtyfour-back
                    @elseif($blog->vcard->template_id == 63)
                            vcard-thirtysix-back
                    @elseif($blog->vcard->template_id == 60)
                            vcard-thirtythree-back
                    @elseif($blog->vcard->template_id == 62)
                            vcard-thirtyfive-back
                    @elseif($blog->vcard->template_id == 64)
                            vcard-thirtyseven-back text-white
                    @elseif($blog->vcard->template_id == 54)
                            vcard-twentyseven-back @endif"
                            href="{{ url()->previous() }}" role="button">
                            {{ __('messages.common.back') }}
                        </a>
                    </div>
                </div>

                <div
                    class="img-bx
            @if ($blog->vcard->template_id == 1) vcard-one-img-bx
            @elseif($blog->vcard->template_id == 2)
                    vcard-two-img-bx
            @elseif($blog->vcard->template_id == 3)
                    vcard-three-img-bx
            @elseif($blog->vcard->template_id == 4)
                    vcard-four-img-bx
            @elseif($blog->vcard->template_id == 5)
                    vcard-five-img-bx
            @elseif($blog->vcard->template_id == 6)
                    vcard-six-img-bx
            @elseif($blog->vcard->template_id == 7)
                    vcard-seven-img-bx
            @elseif($blog->vcard->template_id == 8)
                    vcard-eight-img-bx
            @elseif($blog->vcard->template_id == 9)
                    vcard-nine-img-bx
            @elseif($blog->vcard->template_id == 10)
                    vcard-ten-img-bx
            @elseif($blog->vcard->template_id == 40)
                    vcard-thirteen-img-bx
            @elseif($blog->vcard->template_id == 41)
                    vcard-fourteen-img-bx
            @elseif($blog->vcard->template_id == 39)
                    vcard-twelve-img-bx
            @elseif($blog->vcard->template_id == 40)
                    vcard-thirteen-img-bx
            @elseif($blog->vcard->template_id == 42)
                    vcard-fifteen-img-bx
            @elseif($blog->vcard->template_id == 44)
                    vcard-seventeen-img-bx
            @elseif($blog->vcard->template_id == 43)
                     vcard-sixteen-img-bx
            @elseif($blog->vcard->template_id == 48)
                     vcard-twentyone-img-bx
            @elseif($blog->vcard->template_id == 51)
                     vcard-twentyfour-img-bx
            @elseif($blog->vcard->template_id == 52)
                     vcard-twentyfive-img-bx
            @elseif($blog->vcard->template_id == 49)
                     vcard-twentytwo-img-bx
            @elseif($blog->vcard->template_id == 45)
                     vcard-eighteen-img-bx
            @elseif($blog->vcard->template_id == 46)
                     vcard-nineteen-img-bx
            @elseif($blog->vcard->template_id == 47)
                    vcard-twenty-img-bx
            @elseif($blog->vcard->template_id == 53)
                    vcard-twentysix-img-bx
            @elseif($blog->vcard->template_id == 55)
                    vcard-twentyeight-img-bx
            @elseif($blog->vcard->template_id == 57)
                    vcard-thirty-img-bx
            @elseif($blog->vcard->template_id == 56)
                    vcard-twentynine-img-bx
            @elseif($blog->vcard->template_id == 50)
                    vcard-twentythree-img-bx
            @elseif($blog->vcard->template_id == 58)
                    vcard-thirtyone-img-bx
            @elseif($blog->vcard->template_id == 59)
                    vcard-thirtytwo-img-bx
            @elseif($blog->vcard->template_id == 61)
                    vcard-thirtyfour-img-bx
            @elseif($blog->vcard->template_id == 61)
                    vcard-thirtysix-img-bx
            @elseif($blog->vcard->template_id == 60)
                    vcard-thirtythree-img-bx
            @elseif($blog->vcard->template_id == 62)
                    vcard-thirtyfive-img-bx
            @elseif($blog->vcard->template_id == 64)
                    vcard-thirtyseven-img-bx
            @elseif($blog->vcard->template_id == 54)
                    vcard-twentyseven-img-bx @endif">
                    <img src="{{ $blog->blog_icon }}" />
                </div>
                <div class="details mt-4">
                    <p class="fw-light">{!! $blog->description !!}</p>
                    <div class="blog-hover-btn-mobile fw-light">
                        <a class="btn float-end
                    @if ($blog->vcard->template_id == 1) vcard-one-back
                    @elseif($blog->vcard->template_id == 2)
                            vcard-two-back
                    @elseif($blog->vcard->template_id == 3)
                            vcard-three-back
                    @elseif($blog->vcard->template_id == 4)
                            vcard-four-back
                    @elseif($blog->vcard->template_id == 5)
                            vcard-five-back
                    @elseif($blog->vcard->template_id == 6)
                            vcard-six-back
                    @elseif($blog->vcard->template_id == 7)
                            vcard-seven-back
                    @elseif($blog->vcard->template_id == 8)
                            vcard-eight-back
                    @elseif($blog->vcard->template_id == 9)
                            vcard-nine-back
                    @elseif($blog->vcard->template_id == 10)
                            vcard-ten-back
                    @elseif($blog->vcard->template_id == 40)
                            vcard-thirteen-back
                    @elseif($blog->vcard->template_id == 41)
                            vcard-fourteen-back
                    @elseif($blog->vcard->template_id == 39)
                            vcard-twelve-back
                    @elseif($blog->vcard->template_id == 42)
                            vcard-fifteen-back
                    @elseif($blog->vcard->template_id == 44)
                            vcard-seventeen-back
                    @elseif($blog->vcard->template_id == 43)
                            vcard-sixteen-back
                    @elseif($blog->vcard->template_id == 48)
                            vcard-twentyone-back
                    @elseif($blog->vcard->template_id == 51)
                            vcard-twentyfour-back
                    @elseif($blog->vcard->template_id == 52)
                            vcard-twentyfive-back
                    @elseif($blog->vcard->template_id == 49)
                    vcard-twentytwo-back" data-button-style="{{ isset($dynamicVcard) ? $dynamicVcard->button_style : 'default' }}
                    @elseif($blog->vcard->template_id == 47)
                            vcard-twenty-back
                    @elseif($blog->vcard->template_id == 45)
                            vcard-eighteen-back
                    @elseif($blog->vcard->template_id == 46)
                            vcard-nineteen-back
                    @elseif($blog->vcard->template_id == 53)
                            vcard-twentysix-back
                    @elseif($blog->vcard->template_id == 55)
                            vcard-twentyeight-back
                    @elseif($blog->vcard->template_id == 57)
                            vcard-thirty-back
                    @elseif($blog->vcard->template_id == 56)
                            vcard-twentynine-back
                    @elseif($blog->vcard->template_id == 50)
                            vcard-twentythree-back
                    @elseif($blog->vcard->template_id == 58)
                            vcard-thirtyone-back
                    @elseif($blog->vcard->template_id == 59)
                            vcard-thirtytwo-back
                    @elseif($blog->vcard->template_id == 61)
                            vcard-thirtyfour-back
                    @elseif($blog->vcard->template_id == 61)
                            vcard-thirtysix-back
                    @elseif($blog->vcard->template_id == 60)
                            vcard-thirtythree-back
                    @elseif($blog->vcard->template_id == 62)
                            vcard-thirtyfive-back
                    @elseif($blog->vcard->template_id == 64)
                            vcard-thirtyseven-back text-white
                    @elseif($blog->vcard->template_id == 54)
                            vcard-twentyseven-back @endif"
                            href="{{ url()->previous() }}" role="button">
                            {{ __('messages.common.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

            document.documentElement.style.setProperty('--primary-color', primaryColor);
            document.documentElement.style.setProperty('--green-100', backColor);
            document.documentElement.style.setProperty('--green', backSecondColor);
            document.documentElement.style.setProperty('--black', buttonTextColor);
            document.documentElement.style.setProperty('--gray-100', textDescriptionColor);
            document.documentElement.style.setProperty('--white', textLabelColor);

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            var buttonStyle = @json($dynamicVcard->button_style ?? null);
            applyButtonStyle(buttonStyle);
        });

        function applyButtonStyle(buttonStyle) {
            const buttons = document.querySelectorAll('.vcard-twentytwo-back');
            if (buttonStyle === 'default' || !buttonStyle) {
                buttonStyle = '1';
            }
            buttons.forEach(button => {
                button.classList.add(`dynamic-btn-${buttonStyle}`);
            });
        }
    </script>
</body>

</html>
