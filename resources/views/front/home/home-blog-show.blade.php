@extends(homePageLayout())
@section('title')
    {{ __('messages.blog.blogs') }}
@endsection
<link rel="stylesheet" href="{{ mix('assets/css/blogs/blogs1.css') }}">
<meta property="og:image" content="{{ $blog->blog_image }}" />
@section('content')
    <!-- start hero section -->
    <section class="hero-section pt-100 pb-60" style="background-size:auto;height:400px;"
        @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="container pt-60 mt-5">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fs-40 text-dark"> {{ __('messages.blog.blogs') }} </h2>
                    <div class="text-dark fs-18">
                        <span><i class="fas fa-calendar-alt icon-color-bs-purple"></i><span
                                class="ms-2">{{ $blog->created_at->format('F d, Y') }}</span></span> <span
                            class="text-black ms-4 me-4">|</span>
                        <span> <i class="fas fa-clock icon-color-bs-purple"></i> <span
                                class="ms-2">{{ $blog->created_at->diffForHumans() }}</span> </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end hero section -->

    <!--start Blogs-section -->
    <section class="about-section overflow-hidden padding-t-100px" id=""
        @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="container p-5 pb-0 pt-0">
            <div class="row pt-3 pt-lg-0 pb-0 justify-content-center">
                <div class="col-lg-8 align-items-center">
                    <div class="blog-detail-img w-100">
                        <img src="{{ isset($blog->blog_image) ? $blog->blog_image : asset('front/images/about-1.png') }}"
                            alt="About" class="w-100 object-fit-cover" style="max-height: 480px" />
                    </div>
                    <div class="mt-4 mt-lg-0">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="mt-99">
                                <p class="text-gray-600 fs-18 mb-0 mt-4">{!! $blog->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end Blogs-section -->
@endsection
