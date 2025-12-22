@extends('front.layouts.app3')
@section('title')
{{ __('messages.blog.blogs') }}
@endsection
@section('content')
    <!-- Blog Header -->
    <section class="pt-12 pb-12 bg-gradient-to-br from-secondary-900 to-secondary-800 text-white" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1
                    class="text-4xl md:text-5xl font-bold mb-1 bg-gradient-to-r from-primary-400 via-accent-400 to-white bg-clip-text text-transparent blog-title">
                    {{ __('messages.blog.blogs') }}</h1>
            </div>
        </div>
        <!-- Decorative shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-accent-500/10 rounded-full filter blur-3xl"></div>
        </div>
    </section>

    <!-- Blog Listings -->
    <section class="py-16 bg-secondary-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('blog-list3')
        </div>
    </section>
@endsection
