<!-- Navigation -->
<nav class="sticky top-0 z-50 bg-secondary-900 border-b border-secondary-800 shadow-md"
    @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex-shrink-0 flex items-center">
                <div class="flex items-center space-x-3">
                    <div
                        class="h-[70px] w-[70px] rounded-lg flex items-center justify-center text-white shadow-lg overflow-hidden">
                        <img src="{{ getLogoUrl() }}" alt="company-logo" class="h-[70px] w-[70px] object-contain" />
                    </div>
                    <span
                        class="hidden sm:block text-2xl font-extrabold bg-gradient-to-r from-primary-400 via-accent-400 to-white bg-clip-text text-transparent @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') me-2 @endif">
                        {{ getAppSlogan() }}</span>
                </div>
            </div>
            <div id="mobileMenu"
                class="mobile-menu hidden lg:flex flex-col lg:flex-row items-start lg:items-center absolute lg:relative">
                <a href="{{ asset('') . '#features' }}"
                    class="text-gray-300 hover:text-white ms-2 px-2 py-2 text-sm font-medium transition-all duration-150 lg:hover:bg-secondary-800 rounded-md">
                    {{ __('messages.plan.features') }}</a>
                <a href="{{ asset('') . '#pricing' }}"
                    class="text-gray-300 hover:text-white ms-2 px-2 xl:px-3 py-2 text-sm font-medium transition-all duration-150 lg:hover:bg-secondary-800 rounded-md">{{ __('messages.theme3.pricing') }}</a>
                <a href="{{ route('fornt-blog') }}"
                    class="text-gray-300 hover:text-white ms-2 px-2 xl:px-3 py-2 text-sm font-medium transition-all duration-150 lg:hover:bg-secondary-800 rounded-md">{{ __('messages.blog.blogs') }}</a>
                <a href="{{ asset('') . '#faq' }}"
                    class="@if ($faqs === null) d-none @endif text-gray-300 hover:text-white ms-2 px-2 xl:px-3 py-2 text-sm font-medium transition-all duration-150 lg:hover:bg-secondary-800 rounded-md">{{ __('messages.faqs.faqs') }}</a>
                <a href="{{ asset('') . '#about' }}"
                    class="text-gray-300 hover:text-white ms-2 px-2 xl:px-3 py-2 text-sm font-medium transition-all duration-150 lg:hover:bg-secondary-800 rounded-md">{{ __('messages.theme3.about') }}</a>
                <a href="{{ asset('') . '#contact' }}"
                    class="text-gray-300 hover:text-white ms-2 px-2 xl:px-3 py-2 text-sm font-medium transition-all duration-150 lg:hover:bg-secondary-800 rounded-md">{{ __('messages.vcard.contact') }}</a>
                <a>
                    <div class="dropdown">
                        <a class="btn dropdown-toggle text-gray-300 hover:text-white px-3 xl:px-4 py-2 text-sm font-medium transition-all duration-150 lg:hover:bg-secondary-800 rounded-md"
                            href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ __('messages.language') }}</a>
                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                            @foreach (getAllLanguageWithFullData() as $key => $language)
                                <li class="languageSelection {{ checkFrontLanguageSession() == $key ? 'active' : '' }}"
                                    data-prefix-value="{{ $language->iso_code }}">
                                    <a href="javascript:void(0)"
                                        class="text-black ms-0 ps-2 nav-link d-flex align-items-center dropdown-item {{ checkFrontLanguageSession() == $key ? 'active' : '' }}">
                                        @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                            @foreach (\App\Models\User::FLAG as $imageKey => $imageValue)
                                                @if ($imageKey == $language->iso_code)
                                                    <img src="{{ asset($imageValue) }}" class="me-1 h-5 w-5" alt="{{ $language->name }} Language" />
                                                @endif
                                            @endforeach
                                        @else
                                            @if (count($language->media) != 0)
                                                <img src="{{ $language->image_url }}" class="me-1" alt="{{ $language->name }} Language" />
                                            @else
                                                <i class="fa fa-flag fa-xl me-3 text-danger" aria-hidden="true"></i>
                                            @endif
                                        @endif
                                        <span> {{ $language->name }} </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="h-6 w-0.5 bg-secondary-700 mx-2 hidden lg:block"></div>
                    @if (empty(getLogInUser()))
                        <a href="{{ route('login') }}"
                            class="ml-2 px-6 py-2.5 rounded-[4px] text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium">
                            {{ __('auth.sign_in') }}</a>
                    @else
                        @if (getLogInUser()->hasrole('admin') || getLogInUser()->hasrole('user'))
                            <a href="{{ route('admin.dashboard') }}"
                                class="ml-2 px-6 py-2.5 rounded-[4px] text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium">
                                {{ __('messages.dashboard') }}</a>
                        @endif
                        @if (getLogInUser()->hasrole('super_admin'))
                            <a href="{{ route('sadmin.dashboard') }}"
                                class="ml-2 px-6 py-2.5 rounded-[4px] text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium">
                                {{ __('messages.dashboard') }}</a>
                        @endif
                    @endif
            </div>
            <!-- Mobile menu button -->
            <div class="flex lg:hidden items-center justify-center">
                <button type="button" id="menuToggleButton"
                    class="inline-flex items-center lg:hidden justify-center p-2 rounded-full text-gray-400 hover:text-white hover:bg-secondary-800 focus:outline-none"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">{{ __('messages.theme3.open_main_menu') }}</span>
                    <!-- Icon for menu -->
                    <i class='bx bx-menu text-2xl'></i>
                </button>
            </div>
        </div>
    </div>
</nav>
