<!-- Footer -->
<!-- Subscribe Section -->
<section class="py-16 bg-gradient-to-br from-primary-600 to-accent-600 text-white"
    @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">{{ __('messages.Subscribe_Our_Newsletter') }}</h2>
            <p class="text-lg opacity-90 mb-8">
                {{ __('messages.Receive_latest_news_update_and_many_other_things_every_week') }}
            <form action="{{ route('email.sub') }}" method="post" id="addEmail">
                @csrf
                <div class="email flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    <input type="email" name="email"
                        class="flex-grow px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-white text-gray-800"
                        placeholder="{{ __('messages.front.enter_your_email') }}" required>
                    <div class=" subscribe-btn text-sm-end text-center mt-sm-0 mt-4">
                        <button type="submit"
                            class="px-6 py-3 bg-white text-primary-600 font-medium rounded-lg text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium">{{ __('messages.subscribe') }}</button>
                    </div>
                </div>
            </form>
            <p class="text-sm opacity-80 mt-4">{{ __('messages.theme3.we_respect_privacy') }}</p>
        </div>
    </div>
</section>
<footer class="bg-secondary-900 text-white py-8" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="flex items-center mb-6 md:mb-0">
                <div
                    class=" flex items-center justify-center text-white shadow-md mr-2 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 mr-0 @endif">
                    <img src="{{ getLogoUrl() }}" alt="company-logo" class="w-7 h-7" />
                </div>
                <span
                    class="text-xl font-bold bg-gradient-to-r from-primary-400 via-accent-400 to-teal-400 bg-clip-text text-transparent">
                    {{ getAppName() }}</span>
            </div>
            <div class="flex gap-y-2 gap-x-4 flex-wrap @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') space-x-reverse @endif">
                @if (isset($setting['website_link']) && !empty($setting['website_link']))
                    <a class="w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['website_link'] }}"><i class="fas fa-globe"></i></a>
                @endif
                @if (isset($setting['twitter_link']) && !empty($setting['twitter_link']))
                    <a class="twitter w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['twitter_link'] }}">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="19px"
                            height="19px">
                            <path fill="white"
                                d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                        </svg>
                    </a>
                @endif
                @if (isset($setting['facebook_link']) && !empty($setting['facebook_link']))
                    <a class="facebook w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['facebook_link'] }}"><i class="fab fa-facebook-square"></i></a>
                @endif
                @if (isset($setting['instagram_link']) && !empty($setting['instagram_link']))
                    <a class="instagram w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['instagram_link'] }}"><i class="fab fa-instagram"></i></a>
                @endif
                @if (isset($setting['youtube_link']) && !empty($setting['youtube_link']))
                    <a class="youtube w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['youtube_link'] }}"><i class="fab fa-youtube"></i></a>
                @endif
                @if (isset($setting['tumbir_link']) && !empty($setting['tumbir_link']))
                    <a class="tumblr w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['tumbir_link'] }}"><i class="fab fa-tumblr-square"></i></a>
                @endif
                @if (isset($setting['reddit_link']) && !empty($setting['reddit_link']))
                    <a class="reddit w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['reddit_link'] }}"><i class="fab fa-reddit-alien"></i></a>
                @endif
                @if (isset($setting['linkedin_link']) && !empty($setting['linkedin_link']))
                    <a class="linkedin w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['linkedin_link'] }}"><i class="fab fa-linkedin"></i></a>
                @endif
                @if (isset($setting['whatsapp_link']) && !empty($setting['whatsapp_link']))
                    <a class="whatsapp w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['whatsapp_link'] }}"><i class="fab fa-whatsapp"></i></a>
                @endif
                @if (isset($setting['pinterest_link']) && !empty($setting['pinterest_link']))
                    <a class="pinterest w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['pinterest_link'] }}"><i class="fab fa-pinterest"></i></a>
                @endif
                @if (isset($setting['tiktok_link']) && !empty($setting['tiktok_link']))
                    <a class="tiktok w-8 h-8 rounded-full bg-secondary-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-secondary-700 transition-colors"
                        href="{{ $setting['tiktok_link'] }}"><i class="fab fa-tiktok"></i></a>
                @endif
            </div>
        </div>

        {{-- Custom Pages Section --}}
        @if(isset($customPageAll) && $customPageAll && count($customPageAll) > 0)
            <div class="pt-4 mb-4">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-1 @if (checkFrontLanguageSession() == 'ar') text-right @else text-left @endif">
                    @foreach($customPageAll as $page)
                        <div class="flex">
                            <a href="{{ route('fornt-custom-page-show', $page->slug) }}" class="text-gray-400 hover:text-white transition-colors text-sm py-1 px-2 rounded">
                                {{ $page->title }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif


        <div class="border-t border-gray-800 pt-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-xs mb-4 md:mb-0">&copy; {{ \Carbon\Carbon::now()->year }}
                    {{ getAppName() }}. {{ __('messages.theme3.all_rights_reserved') }}</p>
                <div class="flex space-x-6">
                    <a href="{{ route('terms.conditions') }}"
                        class="text-gray-400 hover:text-white text-xs transition duration-150 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ms-4 @endif">{{ __('messages.vcard.term_condition') }}</a>
                    <a href="{{ route('privacy.policy') }}"
                        class="text-gray-400 hover:text-white text-xs transition duration-150">{{ __('messages.vcard.privacy_policy') }}</a>
                    <a href="{{ route('refund.cancellation.policy') }}"
                        class="text-gray-400 hover:text-white text-xs transition duration-150">{{ __('messages.vcard.refund_cancellation_policy') }}</a>
                    <a href="{{ route('shipping.delivery.policy') }}"
                        class="text-gray-400 hover:text-white text-xs transition duration-150">{{ __('messages.vcard.shipping_delivery_policy') }}</a>
                    <a href="{{ route('imprint.policy') }}"
                        class="text-gray-400 hover:text-white text-xs transition duration-150">{{ __('messages.vcard.imprint_policy') }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!--support banner -->
@if (isset($setting['banner_enable']) && $setting['banner_enable'] == 1)
    <section
        class="flex justify-center"
        @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="banner-section banner-cookie d-none flex justify-center py-16 bg-gradient-to-br from-primary-600 to-accent-600 text-white rounded-2xl p-10 max-w-7xl mx-auto text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class=" mx-auto text-center">
                <h2 class="text-3xl font-bold mb-4">{{ $setting['banner_title'] }}</h2>
                <p class="text-lg opacity-90 mb-8 front-banner-des">
                    {{ $setting['banner_description'] }}
                <div class="text-center pt-2">
                    <a href="{{ $setting['banner_url'] }}"
                        class="px-6 py-3 bg-white text-primary-600 font-medium rounded-lg text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium act-now "
                        target="blank" data-turbo="false">{{ $setting['banner_button'] }}</a>
                    <p class="text-sm opacity-80 mt-4">{{ __('messages.theme3.we_respect_privacy') }}</p>
                </div>
            </div>
        </div>
        <div class="main-banner close-btn bg-transparent">
            <button type="button" class="border-0 bg-transparent disbale-cookie"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>
        </div>
    </section>
@endif
