@extends(homePageLayout())
@section('title')
    {{ __('messages.blog.blogs') }}
@endsection
<link rel="stylesheet" href="{{ mix('assets/css/blogs/blogs1.css') }}">
@section('content')
    <!-- start hero section -->
    <section class="hero-section pt-100 pb-60" style="background-size:auto;height:400px;" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="container pt-60 mt-5">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fs-40 text-white"> {{ __('messages.blog.blogs') }} </h2>
                </div>
            </div>
        </div>
    </section>
    <!-- end hero section -->
    <!--start Blog-section -->
    <div class="container w-75 my-5" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        @livewire('front-blog-list')
    </div>
    <!-- end Blog-section -->
@endsection
