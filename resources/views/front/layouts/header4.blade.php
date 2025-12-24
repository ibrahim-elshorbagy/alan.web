<!-- Navigation -->
<nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm z-50 border-b border-gray-100"
     x-data="{ mobileMenuOpen: false }"
     @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <div class="text-2xl font-bold text-blue-600 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ getLogoUrl() }}" alt="company-logo" class="w-100 h-100 mr-2 object-contain" />
                        <span class="text-2xl font-bold text-blue-600">
                            {{ getAppSlogan() }}
                        </span>
                    </a>
                </div>
            </div>

            <div class="hidden lg:block">
                <div class="ml-10 flex items-baseline space-x-6">
                    <a href="{{ asset('') . '#features' }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">{{ __('messages.plan.features') }}</a>
                    <a href="{{ asset('') . '#pricing' }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">{{ __('messages.theme3.pricing') }}</a>
                    <a href="{{ route('fornt-blog') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">{{ __('messages.blog.blogs') }}</a>
                    <a href="{{ asset('') . '#faq' }}" class="@if ($faqs === null) hidden @endif text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">{{ __('messages.faqs.faqs') }}</a>
                    <a href="{{ asset('') . '#about' }}" class="@if ($faqs === null) hidden @endif text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">{{ __('messages.theme3.about') }}</a>
                    <a href="{{ asset('') . '#contact' }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">{{ __('messages.vcard.contact') }}</a>

                    <!-- Language Dropdown -->
                    <div class="dropdown relative">
                        <a class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors flex items-center dropdown-toggle"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('messages.language') }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        <ul class="dropdown-menu absolute top-full  w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 max-h-100 overflow-y-auto" aria-labelledby="dropdownMenuLink">
                            @foreach (getAllLanguageWithFullData() as $key => $language)
                                <li class="languageSelection {{ checkFrontLanguageSession() == $key ? 'active' : '' }}"
                                    data-prefix-value="{{ $language->iso_code }}">
                                    <a href="javascript:void(0)"
                                        class="dropdown-item flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ checkFrontLanguageSession() == $key ? 'bg-blue-50 text-blue-600' : '' }}">
                                        @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                            @foreach (\App\Models\User::FLAG as $imageKey => $imageValue)
                                                @if ($imageKey == $language->iso_code)
                                                    <img src="{{ asset($imageValue) }}" class="w-4 h-4 mr-2 rounded-sm" alt="{{ $language->name }} Language" />
                                                @endif
                                            @endforeach
                                        @else
                                            @if (count($language->media) != 0)
                                                <img src="{{ $language->image_url }}" class="w-4 h-4 mr-2 rounded-sm" alt="{{ $language->name }} Language" />
                                            @else
                                                <i class="fa fa-flag w-4 h-4 mr-2 text-red-500" aria-hidden="true"></i>
                                            @endif
                                        @endif
                                        <span>{{ $language->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-4 rtl:space-x-reverse rtl:space-x-4">
                @if (empty(getLogInUser()))
                    <button class="hidden lg:block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors" onclick="window.location.href='{{ route('login') }}'">
                        {{ __('auth.sign_in') }}
                    </button>
                    <button class="hidden lg:block border border-blue-600 text-blue-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-600 hover:text-white transition-colors" onclick="window.location.href='{{ route('register') }}'">
                        {{ __('auth.register') }}
                    </button>
                @else
                    @if (getLogInUser()->hasrole('admin'))
                        <button class="hidden lg:block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors" onclick="window.location.href='{{ route('admin.dashboard') }}'">
                            {{ __('messages.dashboard') }}
                        </button>
                    @endif
                    @if (getLogInUser()->hasrole('super_admin'))
                        <button class="hidden lg:block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors" onclick="window.location.href='{{ route('sadmin.dashboard') }}'">
                            {{ __('messages.dashboard') }}
                        </button>
                    @endif
                @endif

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600">
                        <svg x-show="!mobileMenuOpen" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                        <svg x-show="mobileMenuOpen" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="lg:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-100">
                <a href="{{ asset('') . '#features' }}" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors">{{ __('messages.plan.features') }}</a>
                <a href="{{ asset('') . '#pricing' }}" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors">{{ __('messages.theme3.pricing') }}</a>
                <a href="{{ route('fornt-blog') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors">{{ __('messages.blog.blogs') }}</a>
                <a href="{{ asset('') . '#faq' }}" @click="mobileMenuOpen = false" class="@if ($faqs === null) hidden @endif block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors">{{ __('messages.faqs.faqs') }}</a>
                <a href="{{ asset('') . '#about' }}" @click="mobileMenuOpen = false" class="@if ($faqs === null) hidden @endif block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors">{{ __('messages.theme3.about') }}</a>
                <a href="{{ asset('') . '#contact' }}" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors">{{ __('messages.vcard.contact') }}</a>

                <!-- Mobile Language Dropdown -->
                <div class="dropdown relative">
                    <a class="dropdown-toggle w-full flex justify-between items-center px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('messages.language') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <ul class="dropdown-menu w-full bg-white border border-gray-200 rounded-md shadow-lg z-50 max-h-48 overflow-y-auto">
                        @foreach (getAllLanguageWithFullData() as $key => $language)
                            <li class="languageSelection {{ checkFrontLanguageSession() == $key ? 'active' : '' }}"
                                data-prefix-value="{{ $language->iso_code }}">
                                <a href="javascript:void(0)" class="dropdown-item flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 {{ checkFrontLanguageSession() == $key ? 'bg-blue-50 text-blue-600' : '' }}">
                                    @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                        @foreach (\App\Models\User::FLAG as $imageKey => $imageValue)
                                            @if ($imageKey == $language->iso_code)
                                                <img src="{{ asset($imageValue) }}" class="w-4 h-4 mr-2 rounded-sm" alt="{{ $language->name }} Language" />
                                            @endif
                                        @endforeach
                                    @else
                                        @if (count($language->media) != 0)
                                            <img src="{{ $language->image_url }}" class="w-4 h-4 mr-2 rounded-sm" alt="{{ $language->name }} Language" />
                                        @else
                                            <i class="fa fa-flag w-4 h-4 mr-2 text-red-500" aria-hidden="true"></i>
                                        @endif
                                    @endif
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="pt-4 pb-2 border-t border-gray-200">
                    @if (empty(getLogInUser()))
                        <button @click="mobileMenuOpen = false; window.location.href='{{ route('login') }}'" class="block w-full text-left px-3 py-2 text-base font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors mb-2">{{ __('auth.sign_in') }}</button>
                        <button @click="mobileMenuOpen = false; window.location.href='{{ route('register') }}'" class="block w-full text-left px-3 py-2 text-base font-medium border border-blue-600 text-blue-600 rounded-md hover:bg-blue-600 hover:text-white transition-colors">{{ __('auth.register') }}</button>
                    @else
                        @if (getLogInUser()->hasrole('admin') || getLogInUser()->hasrole('user'))
                            <button @click="mobileMenuOpen = false; window.location.href='{{ route('admin.dashboard') }}'" class="block w-full text-left px-3 py-2 text-base font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors mb-2">{{ __('messages.dashboard') }}</button>
                        @endif
                        @if (getLogInUser()->hasrole('super_admin'))
                            <button @click="mobileMenuOpen = false; window.location.href='{{ route('sadmin.dashboard') }}'" class="block w-full text-left px-3 py-2 text-base font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors mb-2">{{ __('messages.dashboard') }}</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
