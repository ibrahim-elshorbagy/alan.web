@extends('front.layouts.app4')
@section('title')
{{ $blog->title ?? __('messages.blog.blogs') }}
@endsection
@section('content')
    <!-- Blog Header -->
    <header class="pt-20 pb-16 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 relative overflow-hidden"
        @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="absolute top-0 left-0 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-30" style="margin-left:-3rem;margin-top:-3rem;"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-purple-100 rounded-full blur-3xl opacity-30" style="margin-right:-3rem;margin-bottom:-3rem;"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex justify-center">
                <div class="w-full lg:w-3/4 xl:w-2/3 mx-auto">
                    <!-- Breadcrumb Navigation -->
                    <div class="flex items-center gap-3 mb-8" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                        <a href="{{ route('fornt-blog') }}"
                            class="inline-flex items-center text-gray-600 hover:text-blue-600 transition-colors font-medium">
                            <i class='bx bx-arrow-back @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 mr-0 @else mr-2 @endif'></i>
                            {{ __('messages.theme3.back_to_blog') }}
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 mb-6">
                        <div class="inline-flex items-center px-3 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-medium">
                            <i class='bx bx-calendar @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 mr-0 @else mr-2 @endif'></i>
                            {{ $blog->created_at->format('F d, Y') }}
                        </div>
                        <div class="inline-flex items-center px-3 py-2 rounded-full bg-purple-100 text-purple-800 text-sm font-medium">
                            <i class='bx bx-time @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 mr-0 @else mr-2 @endif'></i>
                            {{ $blog->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <!-- Article Title -->
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-8">
                        {{ $blog->title }}
                    </h1>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4" style="margin-top: -2rem;">
        <div class="flex justify-center">
            <div class="w-full lg:w-3/4 xl:w-2/3 mx-auto">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden p-4 relative z-20">
                    <img src="{{ isset($blog->blog_image) ? $blog->blog_image : asset('front/images/about-1.png') }}"
                        alt="{{ $blog->title }}"
                        class="w-full h-96 md:h-[500px] object-cover rounded-xl" />
                </div>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-5">
        <div class="flex justify-center">
            <div class="w-full lg:w-3/4 xl:w-2/3 mx-auto" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                <!-- Main Content Card -->
                <article class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="p-8 md:p-12">
                        <div class="max-w-none text-gray-700">
                            {!! $blog->description !!}
                        </div>
                    </div>
                </article>

                <div class="mt-16 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-2xl p-8 md:p-12 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-white bg-opacity-10 rounded-full blur-3xl" style="margin-right:-6rem;margin-top:-6rem;"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white bg-opacity-10 rounded-full blur-3xl" style="margin-left:-6rem;margin-bottom:-6rem;"></div>
                    <div class="relative z-10 text-center md:text-left">
                        <div class="flex flex-col md:flex-row items-center md:justify-between">
                            <div class="md:w-2/3 mb-6 md:mb-0">
                                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                                    {{ __('messages.theme3.ready_to_transform') }}
                                </h2>
                                <p class="text-white text-opacity-90 text-lg leading-relaxed">
                                    {{ __('messages.theme3.create_your_digital_business_card') }}
                                </p>
                            </div>
                            <div class="md:w-1/3 flex-shrink-0 flex justify-center md:justify-end">
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    {{ __('messages.theme3.get_started_free') }}
                                    <i class='bx bx-right-arrow-alt @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') mr-2 ml-0 @else ml-2 @endif'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
