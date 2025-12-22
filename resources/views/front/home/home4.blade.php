@extends('front.layouts.app4')
@section('title')
    {{ getAppName() }}
@endsection
@section('content')
        <!-- Hero Section -->
        <section id="frontHomeTab" class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 pt-16" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left side: Text content -->
                    <div class="space-y-8">
                        <div class="inline-flex items-center px-4 py-2 bg-blue-100 rounded-full text-blue-800 text-sm font-medium mb-4">
                            <span class="w-2 h-2 bg-blue-600 rounded-full @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ms-2 @else mr-2 @endif"></span>
                            {{ __('messages.theme3.new_templates_available') }}
                        </div>
                        <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                            @php
                                $words = explode(' ', $setting['home_page_title']);
                                $lastWord = array_pop($words);
                                $firstPart = implode(' ', $words);
                            @endphp
                            {{ $firstPart }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">{{ $lastWord }}</span>
                        </h1>
                        <p class="text-xl text-gray-600 leading-relaxed">
                            {{ $setting['sub_text'] ?? '' }}
                        </p>

                        <!-- Domain Checker - Your Original Dynamic Version -->
                        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100" x-data="{ checking: false }">
                          <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex flex-col md:flex-row w-full items-stretch gap-2 md:gap-0 flex-1 min-w-0">
                              <!-- Prefix -->
                              <span class="inline-flex items-center justify-start md:justify-center
                                           px-3 py-2 rounded-md md:rounded-l-lg md:rounded-r-none
                                           border border-gray-200 md:border-r-0 bg-gray-50 text-gray-700 text-sm
                                           whitespace-nowrap w-full md:w-auto">
                                {{ env('APP_DOMAIN') }}/
                              </span>

                              <!-- Input -->
                              <input id="search-alias-input-theme4" type="text"
                                     placeholder="{{ __('messages.vcard.search_vcard_url_alias') }}"
                                     class="w-full md:flex-1 min-w-0 rounded-md md:rounded-r-lg md:rounded-l-none
                                            border border-gray-200 px-3 py-2 text-sm
                                            focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                     required>
                            </div>

                            <button id="search-alias-btn-theme4" type="submit"
                                    class="px-6 py-2 sm:py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-medium
                                           flex items-center justify-center min-w-[140px] whitespace-nowrap shrink-0"
                                    @click="checking = true; setTimeout(() => checking = false, 1000)">
                              <!-- Default state -->
                              <span x-cloak x-show="!checking">{{ __('messages.vcard.check_availability') }}</span>
                              <!-- Loading state -->
                              <span x-cloak x-show="checking" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('messages.checking') }}
                              </span>
                            </button>
                          </div>

                          <!-- Error/Success Messages - Your Original -->
                          <div id="search-alias-error-theme4" class="text-red-600 ms-1 hidden @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') text-left mt-1 @else mt-1 @endif">
                            <div class="flex items-center">
                              <i data-feather="x-circle" class="w-4 h-4 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ms-2 @else mr-2 @endif"></i>
                              <span class="font-medium">{{ __('messages.vcard.already_alias_url') }}</span>
                            </div>
                          </div>
                          <div id="search-alias-success-theme4" class="text-green-600 ms-1 hidden @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') text-left mt-1 @else mt-1 @endif">
                            <div class="flex items-center">
                              <i data-feather="check-circle" class="w-4 h-4 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ms-2 @else mr-2 @endif"></i>
                              <span class="font-medium">{{ __('messages.vcard.url_alias_available') }}</span>
                            </div>
                              </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row">
                            <a href="{{ route('register') }}" class="btn bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                                <i data-feather="zap" class="w-5 h-5 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ms-2 @else mr-2 @endif"></i>
                                {{ __('messages.theme3.get_started_free') }}
                            </a>
                        </div>

                        <!-- Trust Indicators -->
                        <div class="flex items-center @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') space-x-reverse space-x-6 @else space-x-6 @endif text-sm text-gray-500">
                            <div class="flex items-center">
                                <div class="flex @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') space-x-reverse -space-x-2 ml-3 @else -space-x-2 mr-3 @endif">
                                    @foreach ($latestUsers as $user)
                                        @php
                                            $firstName = $user->first_name ?? '';
                                            $lastName = $user->last_name ?? '';
                                            $name = trim($firstName) ?: trim($lastName);
                                            $firstLetter = $name ? strtoupper(substr($name, 0, 1)) : 'U';
                                        @endphp
                                        <div class="w-8 h-8 rounded-full border-2 border-white bg-blue-600 text-white flex items-center justify-center font-semibold text-sm">
                                            {{ $firstLetter }}
                                        </div>
                                    @endforeach
                                </div>
                                <span><span class="font-semibold">{{ $totalUser }}+</span> {{ __('messages.theme3.proffessionals_have_joined') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right side: Digital Card Slider -->
                    <div class="flex justify-center lg:justify-end">
                        <div class="floating relative">
                            <img src="{{ isset($setting['home_page_banner']) ? $setting['home_page_banner'] : asset('aassets/img/new_home_page/hero-illustration.png') }}" alt="Digital vCard Illustration" class="w-full max-w-lg">
                            <!-- Floating elements around the main illustration -->
                            <div class="absolute top-10 -left-6 w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center animate-pulse">
                                <i data-feather="users" class="w-8 h-8 text-blue-600"></i>
                            </div>
                            <div class="absolute bottom-24 md:bottom-32 -right-2 sm:-right-4 md:-right-6 w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center animate-pulse animation-delay-1000">
                                <i data-feather="zap" class="w-7 h-7 text-purple-600"></i>
                            </div>
                            <div class="absolute top-1/2 -right-6 sm:-right-10 md:-right-10 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center animate-pulse animation-delay-2000">
                                <i data-feather="check" class="w-6 h-6 text-green-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- vCard Theme Slider Section -->
        <section id="themes" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3">{{ __('messages.vcards_templates') }}</h2>
                </div>

                <div x-data="{
                        currentSlide: 2,
                        themes: [
                            { id: 33, name: 'Musician Template', image: '{{ asset('assets/img/templates/home/vcard33.png') }}' },
                            { id: 32, name: 'Interior Designer', image: '{{ asset('assets/img/templates/home/vcard32.png') }}' },
                            { id: 31, name: 'Handyman Services', image: '{{ asset('assets/img/templates/home/vcard31.png') }}' },
                            { id: 30, name: 'Taxi Service', image: '{{ asset('assets/img/templates/home/vcard30.png') }}' },
                            { id: 29, name: 'Marriage Service', image: '{{ asset('assets/img/templates/home/vcard29.png') }}' },
                            { id: 28, name: 'Pet Clinic', image: '{{ asset('assets/img/templates/home/vcard28.png') }}' },
                            { id: 27, name: 'Pet Shop', image: '{{ asset('assets/img/templates/home/vcard27.png') }}' }
                        ],
                        nextSlide() {
                            this.currentSlide = (this.currentSlide + 1) % this.themes.length
                        },
                        prevSlide() {
                            this.currentSlide = this.currentSlide === 0 ? this.themes.length - 1 : this.currentSlide - 1
                        },
                        getVisibleThemes() {
                            const result = [];
                            for (let i = -2; i <= 2; i++) {
                                const index = (this.currentSlide + i + this.themes.length) % this.themes.length;
                                result.push({ ...this.themes[index], position: i });
                            }
                            return result;
                        }
                    }"
                    x-init="setInterval(() => nextSlide(), 5000)"
                    class="relative">

                    <div class="flex items-center justify-center h-[500px] relative sm:hidden">
                        <button @click="prevSlide()"
                                class="absolute left-2 z-20 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-xl hover:shadow-2xl transition-all hover:scale-110">
                            <i data-feather="chevron-left" class="w-5 h-5 text-gray-700"></i>
                        </button>

                        <div class="flex items-center justify-center gap-4 overflow-hidden px-16">
                            <template x-for="theme in getVisibleThemes()" :key="theme.id">
                                <div class="transition-all duration-700 ease-out flex-shrink-0"
                                     :class="{
                                         'transform scale-110 z-10': theme.position === 0,
                                         'transform scale-90 opacity-70': Math.abs(theme.position) === 1,
                                         'transform scale-75 opacity-40': Math.abs(theme.position) === 2
                                     }">
                                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-48 cursor-pointer"
                                         :class="theme.position === 0 ? 'shadow-2xl border-4 border-blue-500' : 'shadow-lg'"
                                         @click="currentSlide = themes.findIndex(t => t.id === theme.id)">

                                        <div class="w-48 h-72 overflow-hidden bg-gray-100">
                                            <img :src="theme.image"
                                                 :alt="theme.name"
                                                 class="w-full h-full object-cover object-top">
                                        </div>

                                        <div class="p-4 text-center h-16 flex items-center justify-center"
                                             :class="theme.position === 0 ? 'bg-blue-50' : ''">
                                            <h3 class="text-sm font-semibold text-gray-900 truncate" x-text="theme.name"></h3>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button @click="nextSlide()"
                                class="absolute right-2 z-20 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-xl hover:shadow-2xl transition-all hover:scale-110">
                            <i data-feather="chevron-right" class="w-5 h-5 text-gray-700"></i>
                        </button>
                    </div>

                    <div class="hidden sm:flex lg:hidden items-center justify-center h-[550px] relative">
                        <button @click="prevSlide()"
                                class="absolute left-4 z-20 bg-white rounded-full w-12 h-12 flex items-center justify-center shadow-xl hover:shadow-2xl transition-all hover:scale-110">
                            <i data-feather="chevron-left" class="w-6 h-6 text-gray-700"></i>
                        </button>

                        <div class="flex items-center justify-center gap-6 overflow-hidden px-20">
                            <template x-for="theme in getVisibleThemes()" :key="theme.id">
                                <div class="transition-all duration-700 ease-out flex-shrink-0"
                                     :class="{
                                         'transform scale-110 z-10': theme.position === 0,
                                         'transform scale-95 opacity-80': Math.abs(theme.position) === 1,
                                         'transform scale-80 opacity-50': Math.abs(theme.position) === 2
                                     }">
                                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-52 cursor-pointer"
                                         :class="theme.position === 0 ? 'shadow-2xl border-4 border-blue-500' : 'shadow-lg'"
                                         @click="currentSlide = themes.findIndex(t => t.id === theme.id)">

                                        <div class="w-52 h-80 overflow-hidden bg-gray-100">
                                            <img :src="theme.image"
                                                 :alt="theme.name"
                                                 class="w-full h-full object-cover object-top">
                                        </div>

                                        <div class="p-4 text-center"
                                             :class="theme.position === 0 ? 'bg-blue-50' : ''">
                                            <h3 class="text-base font-semibold text-gray-900" x-text="theme.name"></h3>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button @click="nextSlide()"
                                class="absolute right-4 z-20 bg-white rounded-full w-12 h-12 flex items-center justify-center shadow-xl hover:shadow-2xl transition-all hover:scale-110">
                            <i data-feather="chevron-right" class="w-6 h-6 text-gray-700"></i>
                        </button>
                    </div>

                    <div class="hidden lg:flex items-center justify-center min-h-[600px] xl:min-h-[550px]">
                        <button @click="prevSlide()"
                                class="absolute left-12 z-20 bg-white rounded-full p-3 shadow-xl hover:shadow-2xl transition-all hover:scale-110">
                            <i data-feather="chevron-left" class="w-6 h-6 text-gray-700"></i>
                        </button>

                        <div class="flex items-center justify-center space-x-4 overflow-visible px-0">
                            <template x-for="theme in getVisibleThemes()" :key="theme.id">
                                <div class="transition-all duration-700 ease-out flex-shrink-0"
                                     :class="{
                                         'transform scale-110 z-10': theme.position === 0,
                                         'transform scale-90 opacity-70': Math.abs(theme.position) === 1,
                                         'transform scale-75 opacity-40': Math.abs(theme.position) === 2
                                     }">
                                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-56"
                                         :class="theme.position === 0 ? 'shadow-2xl border-x-[4px] border-blue-500' : 'shadow-lg border-x-0'"
                                         @click="currentSlide = themes.findIndex(t => t.id === theme.id)">

                                        <div class="w-56 h-80 xl:h-96 overflow-hidden bg-gray-100">
                                            <img :src="theme.image"
                                                 :alt="theme.name"
                                                 class="w-full h-full object-cover object-top">
                                        </div>

                                        <div class="p-4 text-center"
                                             :class="theme.position === 0 ? 'bg-blue-50' : ''">
                                            <h3 class="text-lg font-semibold text-gray-900" x-text="theme.name"></h3>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button @click="nextSlide()"
                                class="absolute right-8 z-20 bg-white rounded-full p-3 shadow-xl hover:shadow-2xl transition-all hover:scale-110">
                            <i data-feather="chevron-right" class="w-6 h-6 text-gray-700"></i>
                        </button>
                    </div>

                    <!-- Dot Indicators -->
                    <div class="flex justify-center mt-6 sm:mt-8 space-x-2">
                        <template x-for="(theme, index) in themes" :key="index">
                            <button @click="currentSlide = index"
                                    :class="currentSlide === index ? 'bg-blue-600 w-5 sm:w-6' : 'bg-gray-300 w-2 sm:w-2.5'"
                                    class="h-2 sm:h-2.5 rounded-full transition-all duration-300 hover:bg-blue-500"></button>
                        </template>
                    </div>

                    <!-- View All Button -->
                    <div class="text-center mt-6 sm:mt-8">
                        <a href="{{ route('vcard-templates') }}"
                           class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl" style="padding-top: 0.75rem;padding-bottom: 0.75rem;">
                            {{ __('messages.common.see_more') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-white" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('messages.theme3.service_we_offer') }}</h2>
                    <p class="text-xl text-gray-600">{{ __('messages.theme3.proffessional_identity_in_one_platform') }}</p>
                </div>

                <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8 mb-12">
                    @php
                        $colorClasses = [
                            'blue' => 'bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-2xl border border-blue-100 hover:shadow-xl transition-all duration-300 card-hover',
                            'purple' => 'bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-2xl border border-purple-100 hover:shadow-xl transition-all duration-300 card-hover',
                            'green' => 'bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-2xl border border-green-100 hover:shadow-xl transition-all duration-300 card-hover',
                            'orange' => 'bg-gradient-to-br from-orange-50 to-orange-100 p-8 rounded-2xl border border-orange-100 hover:shadow-xl transition-all duration-300 card-hover',
                            'pink' => 'bg-gradient-to-br from-pink-50 to-pink-100 p-8 rounded-2xl border border-pink-100 hover:shadow-xl transition-all duration-300 card-hover',
                            'teal' => 'bg-gradient-to-br from-teal-50 to-teal-100 p-8 rounded-2xl border border-teal-100 hover:shadow-xl transition-all duration-300 card-hover'
                        ];

                        $iconColors = [
                            'blue' => 'bg-blue-600',
                            'purple' => 'bg-purple-600',
                            'green' => 'bg-green-600',
                            'orange' => 'bg-orange-600',
                            'pink' => 'bg-pink-600',
                            'teal' => 'bg-teal-600'
                        ];

                        $staticContent = [
                            'blue' => ['icon' => 'zap', 'text' => 'Instant updates', 'color' => 'text-blue-600'],
                            'purple' => ['icon' => 'trending-up', 'text' => 'Real-time insights', 'color' => 'text-purple-600'],
                            'green' => ['icon' => 'shield', 'text' => 'Professional branding', 'color' => 'text-green-600'],
                            'orange' => ['icon' => 'zap', 'text' => 'Contactless sharing', 'color' => 'text-orange-600'],
                            'pink' => ['icon' => 'link', 'text' => 'All-in-one platform', 'color' => 'text-pink-600'],
                            'teal' => ['icon' => 'target', 'text' => 'Convert visitors', 'color' => 'text-teal-600']
                        ];

                        $colors = ['blue', 'purple', 'green', 'orange', 'pink', 'teal'];
                    @endphp

                    @foreach ($features as $index => $feature)
                        @php
                            $color = $colors[$index % count($colors)];
                            $content = $staticContent[$color];
                        @endphp
                        <div class="group {{ $colorClasses[$color] }}" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                            <div class="w-16 h-16 {{ $iconColors[$color] }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                @if($feature->profile_image)
                                    <img src="{{ $feature->profile_image }}"
                                         class="w-8 h-8 object-cover rounded"
                                         alt="feature-img">
                                @else
                                    <i class='bx bx-star w-8 h-8 text-white'></i>
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $feature->name }}</h3>
                            <p class="text-gray-600 mb-4">{!! Str::limit($feature->description, 120, '...') !!}</p>
                            <div class="flex items-center text-sm {{ $content['color'] }} font-medium">
                                <i data-feather="{{ $content['icon'] }}" class="w-4 h-4 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ms-1 me-0 @else mr-1 @endif"></i>
                                {{ $content['text'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- Testimonials Section -->
        @if(!$testimonials->isEmpty())
        <section class="py-20 bg-gray-50" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('messages.theme3.what_our_clients_say') }}</h2>
                    <p class="text-xl text-gray-600">{{ __('messages.theme3.use_vcards_to_enhance_your_network') }}</p>
                </div>

                <div x-data="{
                        currentSlide: 0,
                        screenSize: 'desktop',
                        testimonials: [
                            @foreach($testimonials as $index => $testimonial)
                            {
                                id: {{ $testimonial->id }},
                                name: '{{ addslashes($testimonial->name) }}',
                                title: '{{ addslashes($testimonial->title ?? '') }}',
                                description: `{!! addslashes($testimonial->description) !!}`,
                                image: '{{ $testimonial->testimonial_url }}'
                            }@if(!$loop->last),@endif
                            @endforeach
                        ],
                        get totalSlides() {
                            return this.testimonials.length;
                        },
                        updateScreenSize() {
                            if (window.innerWidth < 768) {
                                this.screenSize = 'mobile';
                            } else if (window.innerWidth >= 768 && window.innerWidth < 1024) {
                                this.screenSize = 'tablet';
                            } else {
                                this.screenSize = 'desktop';
                            }
                        },
                        nextSlide() {
                            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                        },
                        prevSlide() {
                            this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
                        },
                        getVisibleTestimonials() {
                            const cardsToShow = this.screenSize === 'mobile' ? 1 :
                                            this.screenSize === 'tablet' ? 2 : 3;

                            const result = [];
                            for (let i = 0; i < cardsToShow; i++) {
                                const index = (this.currentSlide + i) % this.totalSlides;
                                result.push(this.testimonials[index]);
                            }
                            return result;
                        },
                        init() {
                            this.updateScreenSize();
                        }
                    }"
                    x-init="init()"
                    @resize.window.debounce.100ms="updateScreenSize()"
                    class="relative">

                    <!-- Mobile View (1 card) -->
                    <div class="block md:hidden">
                        <div class="relative">
                            <!-- Testimonial Card -->
                            <div class="w-full flex justify-center">
                                <template x-for="testimonial in getVisibleTestimonials()" :key="testimonial.id + '_mobile_' + currentSlide + '_' + screenSize">
                                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg hover:shadow-xl transition-shadow card-hover max-w-sm w-full mx-4">
                                        <div class="flex items-center mb-6">
                                            <img :src="testimonial.image" :alt="testimonial.name" class="w-12 h-12 sm:w-16 sm:h-16 rounded-full object-cover {{ checkFrontLanguageSession() == 'ar' ? 'ml-3 sm:ml-4' : 'mr-3 sm:mr-4' }} ring-4 ring-blue-100 flex-shrink-0">
                                            <div class="min-w-0 flex-1">
                                                <div class="font-semibold text-gray-900 text-sm sm:text-base truncate {{ checkFrontLanguageSession() == 'ar' ? 'ml-1 sm:ml-3' : 'mr-1 sm:mr-3' }}" x-text="testimonial.name" :title="testimonial.name"></div>
                                                <div class="text-xs sm:text-sm text-gray-600 truncate" x-text="testimonial.title" x-show="testimonial.title" :title="testimonial.title"></div>
                                            </div>
                                        </div>
                                        <div class="flex mb-4">
                                            <div class="flex text-yellow-400 space-x-1">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <blockquote class="text-gray-700 italic text-sm sm:text-base leading-relaxed" x-html="testimonial.description"></blockquote>
                                    </div>
                                </template>
                            </div>

                            <!-- Bottom Center Navigation -->
                            <div class="flex justify-center items-center mt-6 space-x-8">
                                <button @click="prevSlide()"
                                        class="bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:shadow-xl transition-all hover:scale-110 {{ checkFrontLanguageSession() == 'ar' ? 'rotate-180' : '' }}">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>

                                <button @click="nextSlide()"
                                        class="bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:shadow-xl transition-all hover:scale-110 {{ checkFrontLanguageSession() == 'ar' ? 'rotate-180' : '' }}">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tablet View (2 cards) -->
                    <div class="hidden md:block lg:hidden">
                        <div class="flex items-center justify-center relative">
                            <button @click="prevSlide()"
                                    class="absolute left-4 z-20 bg-white rounded-full p-3 shadow-xl hover:shadow-2xl transition-all hover:scale-110 {{ checkFrontLanguageSession() == 'ar' ? 'rotate-180' : '' }}">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>

                            <div class="grid grid-cols-2 gap-6 lg:gap-8 px-20 w-full">
                                <template x-for="testimonial in getVisibleTestimonials()" :key="testimonial.id + '_tablet_' + currentSlide + '_' + screenSize">
                                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow card-hover">
                                        <div class="flex items-center mb-6">
                                            <img :src="testimonial.image" :alt="testimonial.name" class="w-14 h-14 rounded-full object-cover {{ checkFrontLanguageSession() == 'ar' ? 'ml-3' : 'mr-3' }} ring-4 ring-blue-100 flex-shrink-0">
                                            <div class="min-w-0 flex-1">
                                                <div class="font-semibold text-gray-900 text-sm truncate {{ checkFrontLanguageSession() == 'ar' ? 'ml-2' : 'mr-2' }}" x-text="testimonial.name" :title="testimonial.name"></div>
                                                <div class="text-xs text-gray-600 truncate" x-text="testimonial.title" x-show="testimonial.title" :title="testimonial.title"></div>
                                            </div>
                                        </div>
                                        <div class="flex mb-4">
                                            <div class="flex text-yellow-400 space-x-1">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <blockquote class="text-gray-700 italic text-sm leading-relaxed" x-html="testimonial.description"></blockquote>
                                    </div>
                                </template>
                            </div>

                            <button @click="nextSlide()"
                                    class="absolute right-4 z-20 bg-white rounded-full p-3 shadow-xl hover:shadow-2xl transition-all hover:scale-110 {{ checkFrontLanguageSession() == 'ar' ? 'rotate-180' : '' }}">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Desktop View (3 cards) -->
                    <div class="hidden lg:block">
                        <div class="flex items-center justify-center relative">
                            <button @click="prevSlide()"
                                    class="absolute left-4 z-20 bg-white rounded-full p-3 shadow-xl hover:shadow-2xl transition-all hover:scale-110 {{ checkFrontLanguageSession() == 'ar' ? 'rotate-180' : '' }}">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>

                            <div class="grid grid-cols-3 gap-8 px-20 w-full">
                                <template x-for="testimonial in getVisibleTestimonials()" :key="testimonial.id + '_desktop_' + currentSlide + '_' + screenSize">
                                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow card-hover">
                                        <div class="flex items-center mb-6">
                                            <img :src="testimonial.image" :alt="testimonial.name" class="w-16 h-16 rounded-full object-cover {{ checkFrontLanguageSession() == 'ar' ? 'ml-4' : 'mr-4' }} ring-4 ring-blue-100 flex-shrink-0">
                                            <div class="min-w-0 flex-1">
                                                <div class="font-semibold text-gray-900 truncate {{ checkFrontLanguageSession() == 'ar' ? 'ml-3' : 'mr-3' }}" x-text="testimonial.name" :title="testimonial.name"></div>
                                                <div class="text-sm text-gray-600 truncate" x-text="testimonial.title" x-show="testimonial.title" :title="testimonial.title"></div>
                                            </div>
                                        </div>
                                        <div class="flex mb-4">
                                            <div class="flex text-yellow-400 space-x-1">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <blockquote class="text-gray-700 italic mb-4" x-html="testimonial.description"></blockquote>
                                    </div>
                                </template>
                            </div>

                            <button @click="nextSlide()"
                                    class="absolute right-4 z-20 bg-white rounded-full p-3 shadow-xl hover:shadow-2xl transition-all hover:scale-110 {{ checkFrontLanguageSession() == 'ar' ? 'rotate-180' : '' }}">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- Pricing Plans -->
        <section id="pricing" class="py-20 bg-white" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('messages.theme3.choose_your_plan') }}</h2>
                    <p class="text-xl text-gray-600 mb-8">{{ __('messages.theme3.select_the_plan_that_fits_your_needs') }}</p>

                    <!-- Month/Year/Unlimited Toggle -->
                    <div class="flex justify-center mb-8">
                        <div class="bg-gray-100 rounded-lg p-1 shadow-md inline-flex">
                            <button id="monthlyBtn" onclick="togglePricing('monthly')"
                                    class="px-6 py-2 rounded-md font-medium transition-all bg-blue-600 text-white shadow-md">
                                {{ __('messages.plan.monthly') }}
                            </button>
                            <button id="yearlyBtn" onclick="togglePricing('yearly')"
                                    class="px-6 py-2 rounded-md font-medium transition-all text-gray-600">
                                {{ __('messages.plan.yearly') }}
                            </button>
                            <button id="unlimitedBtn" onclick="togglePricing('unlimited')"
                                    class="px-6 py-2 rounded-md font-medium transition-all text-gray-600">
                                {{ __('messages.plan.unlimited') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div x-data="{
                    expandedPlan: null,
                    togglePlan(plan) {
                        this.expandedPlan = this.expandedPlan === plan ? null : plan;
                    }
                }">

                    @php
                    function arrangeWithPopularInMiddle($plansCollection) {
                        if($plansCollection->count() < 3) {
                            return $plansCollection;
                        }

                        $plansWithCounts = $plansCollection->map(function($plan) {
                            $plan->subscription_count = $plan->subscriptions()->count();
                            return $plan;
                        });

                        $maxPurchases = $plansWithCounts->max('subscription_count');

                        if ($maxPurchases > 0) {
                            $sortedPlans = $plansWithCounts->sortByDesc('subscription_count');
                        } else {
                            $sortedPlans = $plansWithCounts->sortBy('price');
                        }

                        return collect([
                            $sortedPlans->skip(1)->first(),
                            $sortedPlans->first(),
                            $sortedPlans->skip(2)->first()
                        ])->filter()->values();
                    }

                    // Get and arrange plans
                    $monthlyPlansRaw = $plans->where('frequency', 1)->sortByDesc('created_at')->take(3);
                    $yearlyPlansRaw = $plans->where('frequency', 2)->sortByDesc('created_at')->take(3);
                    $unlimitedPlansRaw = $plans->where('frequency', 3)->sortByDesc('created_at')->take(3);

                    $monthlyPlans = arrangeWithPopularInMiddle($monthlyPlansRaw);
                    $yearlyPlans = arrangeWithPopularInMiddle($yearlyPlansRaw);
                    $unlimitedPlans = arrangeWithPopularInMiddle($unlimitedPlansRaw);
                    @endphp

                    <!-- Monthly Plans -->
                    <div id="monthly-plans" class="grid lg:grid-cols-3 gap-8">
                        @foreach($monthlyPlans as $index => $plan)
                            <div class="bg-white rounded-2xl border-2 {{ $index == 1 ? 'border-blue-600 shadow-xl relative transform scale-105' : 'border-gray-200 hover:border-gray-300 transition-colors shadow-lg hover:shadow-xl' }} relative">

                                <!-- Most Popular Badge for middle plan -->
                                @if($index == 1)
                                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-medium shadow-lg">
                                            {{ __('messages.theme3.most_popular') }}
                                        </span>
                                    </div>
                                @endif

                                <div class="p-8">
                                    <div class="text-center mb-8">
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{!! $plan->name !!}</h3>

                                        <div class="mb-4">
                                            @if($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                                                <span class="text-5xl font-bold text-gray-900 custom-price-{{ $plan->id }}">
                                                    {{ $plan->currency->currency_icon }}{{ $plan->planCustomFields->first()->custom_vcard_price }}
                                                </span>
                                                <span class="text-lg text-gray-600">/{{ __('messages.plan.monthly') }}</span>
                                            @else
                                                <span class="text-5xl font-bold text-gray-900">
                                                    {{ $plan->currency->currency_icon }}{{ $plan->price }}
                                                </span>
                                                <span class="text-lg text-gray-600">/{{ __('messages.plan.monthly') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Custom vCard Selection -->
                                    @if($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                                        <div class="mb-6">
                                            <select id="vcardNumber-{{ $plan->id }}" class="w-full p-3 border border-gray-300 rounded-lg customSelect" data-plan-id="{{ $plan->id }}" data-type="monthly">
                                                @foreach($plan->planCustomFields as $customField)
                                                    <option value="{{ $customField->id }}"
                                                            data-price="{{ $customField->custom_vcard_price }}"
                                                            data-currency="{{ $plan->currency->currency_code }}"
                                                            data-vcards="{{ $customField->custom_vcard_number }}">
                                                        {{ $customField->custom_vcard_number }} {{ __('messages.vcards') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <!-- Plan Features -->
                                    <ul class="space-y-4 mb-8">
                                        <li class="flex items-center">
                                            <i data-feather="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                            <span class="text-gray-700">
                                                @if($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                                                    <span class="vcard-count-{{ $plan->id }}">{{ __('messages.plan.no_of_vcard_templates') . ':' }} {{ $plan->planCustomFields->first()->custom_vcard_number }}</span>
                                                @else
                                                    {{ __('messages.plan.no_of_vcard_templates') . ':' }} {{ $plan->no_of_vcards }}
                                                @endif
                                            </span>
                                        </li>

                                        <li class="flex items-center">
                                            <i data-feather="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                            <span class="text-gray-700">{{ __('messages.plan.storage_limit') . ':' }} {{ $plan->storage_limit }} {{ __('messages.mb') }}</span>
                                        </li>

                                        @php
                                            $features = getPlanFeature($plan);
                                            $skipCount = 4;
                                            $mainFeatures = collect($features)->take($skipCount);
                                        @endphp

                                        @foreach($mainFeatures as $feature => $value)
                                            <li class="flex items-center">
                                                <i data-feather="{{ $value ? 'check' : 'x' }}" class="w-5 h-5 {{ $value ? 'text-green-500' : 'text-red-500' }} mr-3"></i>
                                                <span class="text-gray-700">{{ __('messages.feature.' . $feature) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <!-- Expandable Features -->
                                    @if(collect($features)->count() > $skipCount)
                                        <div x-show="expandedPlan === '{{ $plan->id }}'" x-transition class="mb-6">
                                            <div class="border-t pt-4">
                                                <h4 class="font-semibold text-gray-900 mb-3">{{ __('messages.theme3.additional_features') }}:</h4>
                                                <ul class="space-y-2 text-sm text-gray-600">
                                                    @foreach(collect($features)->skip($skipCount) as $feature => $value)
                                                        <li class="flex items-center">
                                                            <i data-feather="{{ $value ? 'check' : 'x' }}" class="w-4 h-4 {{ $value ? 'text-green-500' : 'text-red-500' }} mr-2"></i>
                                                            {{ __('messages.feature.' . $feature) }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        <button @click="togglePlan('{{ $plan->id }}')"
                                                class="w-full {{ $index == 2 ? 'text-purple-600 hover:text-purple-800' : 'text-blue-600 hover:text-blue-800' }} text-sm font-medium mb-4 transition-colors">
                                            <span x-text="expandedPlan === '{{ $plan->id }}' ? '{{ __('messages.show_less') }}' : '{{ __('messages.theme3.view_more_features') }}'"></span>
                                            <i :data-feather="expandedPlan === '{{ $plan->id }}' ? 'chevron-up' : 'chevron-down'" class="w-4 h-4 inline ml-1"></i>
                                        </button>
                                    @endif

                                    <!-- CTA Button -->
                                    <div class="text-center">
                                        @if($index == 0)
                                            <a href="{{ route('register') }}" class="block w-full bg-gray-100 text-gray-800 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @elseif($index == 1)
                                            <a href="{{ route('register') }}" class="block w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @elseif($index == 2)
                                            <a href="{{ route('register') }}" class="block w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all shadow-lg hover:shadow-xl">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @else
                                            <a href="{{ route('register') }}" class="block w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Yearly Plans -->
                    <div id="yearly-plans" class="grid lg:grid-cols-3 gap-8" style="display: none;">
                        @foreach($yearlyPlans as $index => $plan)
                            <div class="bg-white rounded-2xl border-2 {{ $index == 1 ? 'border-blue-600 shadow-xl relative transform scale-105' : 'border-gray-200 hover:border-gray-300 transition-colors shadow-lg hover:shadow-xl' }} relative">

                                @if($index == 1)
                                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-medium shadow-lg">
                                            {{ __('messages.theme3.most_popular') }}
                                        </span>
                                    </div>
                                @endif

                                <div class="p-8">
                                    <div class="text-center mb-8">
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{!! $plan->name !!}</h3>

                                        <div class="mb-4">
                                            @if($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                                                <span class="text-5xl font-bold text-gray-900 custom-price-{{ $plan->id }}">
                                                    {{ $plan->currency->currency_icon }}{{ $plan->planCustomFields->first()->custom_vcard_price }}
                                                </span>
                                                <span class="text-lg text-gray-600">/{{ __('messages.plan.yearly') }}</span>
                                            @else
                                                <span class="text-5xl font-bold text-gray-900">
                                                    {{ $plan->currency->currency_icon }}{{ $plan->price }}
                                                </span>
                                                <span class="text-lg text-gray-600">/{{ __('messages.plan.yearly') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Custom vCard Selection -->
                                    @if($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                                        <div class="mb-6">
                                            <select id="vcardNumber-{{ $plan->id }}" class="w-full p-3 border border-gray-300 rounded-lg customSelect" data-plan-id="{{ $plan->id }}" data-type="yearly">
                                                @foreach($plan->planCustomFields as $customField)
                                                    <option value="{{ $customField->id }}"
                                                            data-price="{{ $customField->custom_vcard_price }}"
                                                            data-currency="{{ $plan->currency->currency_code }}"
                                                            data-vcards="{{ $customField->custom_vcard_number }}">
                                                        {{ $customField->custom_vcard_number }} {{ __('messages.vcards') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <!-- Plan Features -->
                                    <ul class="space-y-4 mb-8">
                                        <li class="flex items-center">
                                            <i data-feather="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                            <span class="text-gray-700">
                                                @if($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                                                    <span class="vcard-count-{{ $plan->id }}">{{ __('messages.plan.no_of_vcard_templates') . ':' }} {{ $plan->planCustomFields->first()->custom_vcard_number }}</span>
                                                @else
                                                    {{ __('messages.plan.no_of_vcard_templates') . ':' }} {{ $plan->no_of_vcards }}
                                                @endif
                                            </span>
                                        </li>

                                        <li class="flex items-center">
                                            <i data-feather="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                            <span class="text-gray-700">{{ __('messages.plan.storage_limit') . ':' }} {{ $plan->storage_limit }} {{ __('messages.mb') }}</span>
                                        </li>

                                        @php
                                            $features = getPlanFeature($plan);
                                            $skipCount = 4;
                                            $mainFeatures = collect($features)->take($skipCount);
                                        @endphp

                                        @foreach($mainFeatures as $feature => $value)
                                            <li class="flex items-center">
                                                <i data-feather="{{ $value ? 'check' : 'x' }}" class="w-5 h-5 {{ $value ? 'text-green-500' : 'text-red-500' }} mr-3"></i>
                                                <span class="text-gray-700">{{ __('messages.feature.' . $feature) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <!-- Expandable Features -->
                                    @if(collect($features)->count() > $skipCount)
                                        <div x-show="expandedPlan === '{{ $plan->id }}'" x-transition class="mb-6">
                                            <div class="border-t pt-4">
                                                <h4 class="font-semibold text-gray-900 mb-3">{{ __('messages.theme3.additional_features') }}:</h4>
                                                <ul class="space-y-2 text-sm text-gray-600">
                                                    @foreach(collect($features)->skip($skipCount) as $feature => $value)
                                                        <li class="flex items-center">
                                                            <i data-feather="{{ $value ? 'check' : 'x' }}" class="w-4 h-4 {{ $value ? 'text-green-500' : 'text-red-500' }} mr-2"></i>
                                                            {{ __('messages.feature.' . $feature) }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        <button @click="togglePlan('{{ $plan->id }}')"
                                                class="w-full {{ $index == 2 ? 'text-purple-600 hover:text-purple-800' : 'text-blue-600 hover:text-blue-800' }} text-sm font-medium mb-4 transition-colors">
                                            <span x-text="expandedPlan === '{{ $plan->id }}' ? '{{ __('messages.show_less') }}' : '{{ __('messages.theme3.view_more_features') }}'"></span>
                                            <i :data-feather="expandedPlan === '{{ $plan->id }}' ? 'chevron-up' : 'chevron-down'" class="w-4 h-4 inline ml-1"></i>
                                        </button>
                                    @endif

                                    <!-- CTA Button -->
                                    <div class="text-center">
                                        @if($index == 0)
                                            <a href="{{ route('register') }}" class="block w-full bg-gray-100 text-gray-800 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @elseif($index == 1)
                                            <a href="{{ route('register') }}" class="block w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @elseif($index == 2)
                                            <a href="{{ route('register') }}" class="block w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all shadow-lg hover:shadow-xl">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @else
                                            <a href="{{ route('register') }}" class="block w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Unlimited Plans -->
                    <div id="unlimited-plans" class="grid lg:grid-cols-3 gap-8" style="display: none;">
                        @foreach($unlimitedPlans as $index => $plan)
                            <div class="bg-white rounded-2xl border-2 {{ $index == 1 ? 'border-blue-600 shadow-xl relative transform scale-105' : 'border-gray-200 hover:border-gray-300 transition-colors shadow-lg hover:shadow-xl' }} relative">

                                @if($index == 1)
                                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-medium shadow-lg">
                                            {{ __('messages.theme3.most_popular') }}
                                        </span>
                                    </div>
                                @endif

                                <div class="p-8">
                                    <div class="text-center mb-8">
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{!! $plan->name !!}</h3>

                                        <div class="mb-4">
                                            @if($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                                                <span class="text-5xl font-bold text-gray-900 custom-price-{{ $plan->id }}">
                                                    {{ $plan->currency->currency_icon }}{{ $plan->planCustomFields->first()->custom_vcard_price }}
                                                </span>
                                            @else
                                                <span class="text-5xl font-bold text-gray-900">
                                                    {{ $plan->currency->currency_icon }}{{ $plan->price }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Custom vCard Selection -->
                                    @if($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                                        <div class="mb-6">
                                            <select id="vcardNumber-{{ $plan->id }}" class="w-full p-3 border border-gray-300 rounded-lg customSelect" data-plan-id="{{ $plan->id }}" data-type="unlimited">
                                                @foreach($plan->planCustomFields as $customField)
                                                    <option value="{{ $customField->id }}"
                                                            data-price="{{ $customField->custom_vcard_price }}"
                                                            data-currency="{{ $plan->currency->currency_code }}"
                                                            data-vcards="{{ $customField->custom_vcard_number }}">
                                                        {{ $customField->custom_vcard_number }} {{ __('messages.vcards') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <!-- Plan Features -->
                                    <ul class="space-y-4 mb-8">
                                        <li class="flex items-center">
                                            <i data-feather="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                            <span class="text-gray-700">
                                                @if($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                                                    <span class="vcard-count-{{ $plan->id }}">{{ __('messages.plan.no_of_vcard_templates') . ':' }} {{ $plan->planCustomFields->first()->custom_vcard_number }}</span>
                                                @else
                                                    {{ __('messages.plan.no_of_vcard_templates') . ':' }} {{ $plan->no_of_vcards }}
                                                @endif
                                            </span>
                                        </li>

                                        <li class="flex items-center">
                                            <i data-feather="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                            <span class="text-gray-700">{{ __('messages.plan.storage_limit') . ':' }} {{ $plan->storage_limit }} {{ __('messages.mb') }}</span>
                                        </li>

                                        @php
                                            $features = getPlanFeature($plan);
                                            $skipCount = 4;
                                            $mainFeatures = collect($features)->take($skipCount);
                                        @endphp

                                        @foreach($mainFeatures as $feature => $value)
                                            <li class="flex items-center">
                                                <i data-feather="{{ $value ? 'check' : 'x' }}" class="w-5 h-5 {{ $value ? 'text-green-500' : 'text-red-500' }} mr-3"></i>
                                                <span class="text-gray-700">{{ __('messages.feature.' . $feature) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <!-- Expandable Features -->
                                    @if(collect($features)->count() > $skipCount)
                                        <div x-show="expandedPlan === '{{ $plan->id }}'" x-transition class="mb-6">
                                            <div class="border-t pt-4">
                                                <h4 class="font-semibold text-gray-900 mb-3">{{ __('messages.theme3.additional_features') }}:</h4>
                                                <ul class="space-y-2 text-sm text-gray-600">
                                                    @foreach(collect($features)->skip($skipCount) as $feature => $value)
                                                        <li class="flex items-center">
                                                            <i data-feather="{{ $value ? 'check' : 'x' }}" class="w-4 h-4 {{ $value ? 'text-green-500' : 'text-red-500' }} mr-2"></i>
                                                            {{ __('messages.feature.' . $feature) }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        <button @click="togglePlan('{{ $plan->id }}')"
                                                class="w-full {{ $index == 2 ? 'text-purple-600 hover:text-purple-800' : 'text-blue-600 hover:text-blue-800' }} text-sm font-medium mb-4 transition-colors">
                                            <span x-text="expandedPlan === '{{ $plan->id }}' ? '{{ __('messages.show_less') }}' : '{{ __('messages.theme3.view_more_features') }}'"></span>
                                            <i :data-feather="expandedPlan === '{{ $plan->id }}' ? 'chevron-up' : 'chevron-down'" class="w-4 h-4 inline ml-1"></i>
                                        </button>
                                    @endif

                                    <!-- CTA Button -->
                                    <div class="text-center">
                                        @if($index == 0)
                                            <a href="{{ route('register') }}" class="block w-full bg-gray-100 text-gray-800 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @elseif($index == 1)
                                            <a href="{{ route('register') }}" class="block w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @elseif($index == 2)
                                            <a href="{{ route('register') }}" class="block w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all shadow-lg hover:shadow-xl">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @else
                                            <a href="{{ route('register') }}" class="block w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                                                {{ __('messages.theme3.get_started_free') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Custom Solutions Info -->
                <div class="bg-white p-6 mt-10 rounded-xl shadow-md border border-gray-100 max-w-3xl mx-auto" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class='bx bx-info-circle text-2xl text-blue-500 mr-4 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-4 mr-0 @endif'></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">
                                {{ __('messages.theme3.looking_for_custom_solutions') }}
                            </h4>
                            <p class="text-gray-600 mb-4">{{ __('messages.theme3.need_solution') }}</p>
                            <a href="#contact" class="text-blue-600 font-medium hover:text-blue-700 inline-flex items-center">
                                {{ __('messages.theme3.contact_our_team') }} <i class='bx bx-right-arrow-alt ml-1'></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- About Us -->
        <section id="about" class="py-20 bg-gray-50" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('messages.theme3.about_vcards') }}</h2>
                    <p class="text-xl text-gray-600">{{ __('messages.theme3.professional_network') }}</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 mb-16">
                    @foreach(collect($aboutUS)->take(3) as $about)
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden card-hover">
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $about['about_url'] ?? asset('front/images/about-' . ($loop->index + 1) . '.png') }}"
                                     alt="{{ $about['title'] }}"
                                     class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                            </div>
                            <div class="p-8">
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $about['title'] }}</h3>
                                <p class="text-gray-600 mb-4">{!! nl2br(e($about['description'])) !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-12 text-white text-center">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

                        <div>
                            @php $val = max($activeUser - 1, 0); @endphp
                            <div class="text-3xl font-bold mb-2">{{ $val == 0 ? 0 : $val.'+' }}</div>
                            <div class="text-blue-100">{{ __('messages.theme3.acvitive_users') }}</div>
                        </div>

                        <div>
                            @php $val = max($toalVcards - 1, 0); @endphp
                            <div class="text-3xl font-bold mb-2">{{ $val == 0 ? 0 : $val.'+' }}</div>
                            <div class="text-blue-100">{{ __('messages.theme3.generated_vcards') }}</div>
                        </div>

                        <div>
                            @php $val = max($totalwhatsappStores - 1, 0); @endphp
                            <div class="text-3xl font-bold mb-2">{{ $val == 0 ? 0 : $val.'+' }}</div>
                            <div class="text-blue-100">{{ __('messages.theme3.generated_whatsapp_stores') }}</div>
                        </div>

                        <div>
                            @php $val = max($totalCountries - 1, 0); @endphp
                            <div class="text-3xl font-bold mb-2">{{ $val == 0 ? 0 : $val.'+' }}</div>
                            <div class="text-blue-100">{{ __('messages.analytics.countries') }}</div>
                        </div>

                    </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-20 bg-white" id="faq">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('messages.theme3.frequently_asked_questions') }}</h2>
                    <p class="text-xl text-gray-600">{{ __('messages.theme3.find_answers_to_the_most_common_questions') }}</p>
                    <div class="mt-8 inline-flex items-center px-4 py-2 bg-blue-100 rounded-full text-blue-800 text-sm font-medium">
                        <i data-feather="help-circle" class="w-4 h-4 mr-2"></i>
                        {{ __('messages.theme3.still_have_questions') }} <a href="#contact" class="ml-1 underline hover:no-underline">{{ __('messages.theme3.contact_our_support_team') }}</a>
                    </div>
                </div>

                <!-- Alpine.js FAQ Accordion -->
                <div x-data="{ activeAccordion: -1 }" class="space-y-3">
                    @foreach ($faq as $index => $faqs)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                            <button @click="activeAccordion = activeAccordion === {{ $index }} ? -1 : {{ $index }}"
                                    class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 rounded-2xl transition-colors">
                                <span class="text-lg font-semibold text-gray-900 pr-4" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>{{ $faqs->title }}</span>
                                <div class="flex-shrink-0">
                                    <i data-feather="chevron-down" :class="activeAccordion === {{ $index }} ? 'rotate-180' : ''" class="w-5 h-5 text-blue-600 transition-transform"></i>
                                </div>
                            </button>
                            <div x-show="activeAccordion === {{ $index }}"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="px-8 pb-6">
                                <div class="border-t pt-4">
                                    <div class="text-gray-600" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>{!! $faqs->description !!}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Contact Us Section -->
        <section id="contact" class="py-20 bg-gray-50" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                    <div
                        class="inline-flex items-center px-3 py-1.5 rounded-full bg-cyan-100 text-cyan-700 mb-4 text-sm font-medium">
                        <i class='bx bx-envelope mr-1.5 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') mr-0 ml-1.5 @endif'></i>
                        {{ __('messages.vcard_11.get_in_touch') }}
                    </div>

                    <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('messages.dynamic_vcard.contact_us') }}</h2>
                    <p class="text-xl text-gray-600">{{ __('messages.theme3.learn_more_about_what_we_offer') }}</p>
                </div>

                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Contact Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.theme3.send_a_msg') }}</h3>
                            <form class="space-y-6 contact-form" id="myForm">
                                @csrf
                                <div id="contactError" class="alert alert-danger d-none"></div>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('messages.theme3.your_name') }} *</label>
                                        <input type="text" id="name" name="name" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                               placeholder="{{ __('messages.theme3.your_name') }}">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('messages.theme3.email_address') }} *</label>
                                        <input type="email" id="email" name="email" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                               placeholder="{{ __('messages.theme3.email_address') }}">
                                    </div>
                                </div>

                                <div>
                                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('messages.common.subject') }} *</label>
                                    <input type="text" id="subject" name="subject" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                           placeholder="{{ __('messages.common.subject') }}">
                                </div>

                                <div>
                                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('messages.theme3.your_msg') }} *</label>
                                    <textarea id="message" name="message" rows="6" required
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                              placeholder="{{ __('messages.theme3.your_msg') }}"></textarea>
                                </div>

                                <button type="submit"
                                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                                    <i data-feather="send" class="w-5 h-5 mr-2 inline"></i>
                                    {{ __('messages.contact_us.send_message') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-6">
                        <!-- Contact Methods -->
                        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                            <div class="space-y-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <i class='bx bx-envelope text-xl text-blue-600'></i>
                                        </div>
                                    </div>
                                    <div class="@if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') mr-4 @else ml-4 @endif">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ __('messages.common.email') }}</h4>
                                        <p class="text-gray-600 mb-1">{{ $setting['email'] }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                            <i class="bx bx-phone text-xl text-green-600"></i>
                                        </div>
                                    </div>
                                    <div class="@if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') mr-4 @else ml-4 @endif">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ __('messages.common.phone') }}</h4>
                                        <p class="text-gray-600 mb-1">{{ '+' . $setting['prefix_code'] . ' ' . $setting['phone'] }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                            <i class="bx bx-map-pin text-xl text-red-600"></i>
                                        </div>
                                    </div>
                                    <div class="@if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') mr-4 @else ml-4 @endif">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ __('messages.theme3.office') }}</h4>
                                        <p class="text-gray-600 mb-2">{{ $setting['address'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
