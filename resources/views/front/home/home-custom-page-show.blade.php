@extends(homePageLayout())
@section('title')
    @if ($customPage['seo_title'])
        <title>{{ $customPage['seo_title'] }} | {{ getAppName() }}</title>
    @else
        <title> {{ $customPage['title'] }} | {{ getAppName() }}</title>
    @endif
@endsection
<link rel="stylesheet" href="{{ mix('assets/css/blogs/blogs1.css') }}">
@section('content')
    <!-- start hero section -->

    <!-- end hero section -->

    <!--start Custom Page-section -->
    <section class="hero-section pt-100 pb-60" id=""
    @if (checkFrontLanguageSession() == 'ar') dir="rtl" @endif >
    <div class="about-section overflow-hidden pt-100 pb-60">
        <div class="container p-5 pb-0 pt-0">
            <div class="row pt-60 mt-5 pb-0 justify-content-center">
                <div class="col-lg-8 align-items-center">
                    <div class="mt-4 mt-lg-0">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="mt-99 w-100 article-content ql-editor">
                                {!! $customPage->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- end Custom Page-section -->
@endsection
