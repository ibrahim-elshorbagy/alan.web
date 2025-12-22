@extends('front.layouts.app4')
@section('title')
{{ __('messages.blog.blogs') }}
@endsection
@section('content')
    <!-- Blog Header -->
    <section class="pt-20 pb-16 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="absolute top-0 left-0 w-64 h-64 bg-blue-100 rounded-full filter blur-3xl opacity-30 -ml-12 -mt-12"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-purple-100 rounded-full filter blur-3xl opacity-30 -mr-12 -mb-12"></div>

            <div class="max-w-4xl mx-auto text-center" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-gray-900 leading-tight">
                    {{ __('messages.blog.blogs') }}
                </h1>
            </div>
        </div>
    </section>

    <!-- Blog Listings -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('blog-list4')
        </div>
    </section>
@endsection
