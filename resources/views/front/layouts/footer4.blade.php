<!-- Newsletter Section -->
<section class="py-20 bg-blue-600" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">{{ __('messages.Subscribe_Our_Newsletter') }}</h2>
        <p class="text-xl text-blue-100 mb-8">{{ __('messages.Receive_latest_news_update_and_many_other_things_every_week') }}</p>

        <form action="{{ route('email.sub') }}" method="post" id="addEmail">
            @csrf
            <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" name="email" placeholder="{{ __('messages.front.enter_your_email') }}"
                       class="flex-1 px-4 rounded-lg border-0 focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-blue-600 text-gray-800" style="padding-top: 0.75rem;padding-bottom:0.75rem;" required>
                <button type="submit" class="bg-white text-blue-600 px-6 rounded-lg font-semibold hover:bg-gray-100 transition-colors" style="padding-top: 0.75rem;padding-bottom:0.75rem;">
                    {{ __('messages.subscribe') }}
                </button>
            </div>
        </form>

        <p class="text-sm text-blue-100 opacity-80 mt-4">{{ __('messages.theme3.we_respect_privacy') }}</p>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-8" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="flex items-center mb-6 md:mb-0">
                <div class="w-auto rounded-lg bg-gradient-to-br flex items-center justify-center text-white shadow-md mr-2 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 mr-0 @endif">
                    <img src="{{ getLogoUrl() }}" alt="company-logo" class="w-auto" />
                </div>
                <span class="text-2xl font-bold text-white bg-clip-text">
                    {{ getAppName() }}
                </span>
            </div>

            <div class="flex gap-y-2 gap-x-4 flex-wrap @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') space-x-reverse @endif">
                @if (isset($setting['website_link']) && !empty($setting['website_link']))
                    <a class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors" href="{{ $setting['website_link'] }}"><i class="fas fa-globe w-5 h-5"></i></a>
                @endif
                @if (isset($setting['twitter_link']) && !empty($setting['twitter_link']))
                    <a href="{{ $setting['twitter_link'] }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-twitter w-5 h-5"></i>
                    </a>
                @endif
                @if (isset($setting['linkedin_link']) && !empty($setting['linkedin_link']))
                    <a href="{{ $setting['linkedin_link'] }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-linkedin w-5 h-5"></i>
                    </a>
                @endif
                @if (isset($setting['instagram_link']) && !empty($setting['instagram_link']))
                    <a href="{{ $setting['instagram_link'] }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-instagram w-5 h-5"></i>
                    </a>
                @endif
                @if (isset($setting['facebook_link']) && !empty($setting['facebook_link']))
                    <a href="{{ $setting['facebook_link'] }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-facebook w-5 h-5"></i>
                    </a>
                @endif
                @if (isset($setting['youtube_link']) && !empty($setting['youtube_link']))
                    <a href="{{ $setting['youtube_link'] }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-youtube w-5 h-5"></i>
                    </a>
                @endif
                @if (isset($setting['whatsapp_link']) && !empty($setting['whatsapp_link']))
                    <a href="{{ $setting['whatsapp_link'] }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-whatsapp w-5 h-5"></i>
                    </a>
                @endif
                @if (isset($setting['tumbir_link']) && !empty($setting['tumbir_link']))
                    <a href="{{ $setting['tumbir_link'] }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-tumblr-square w-5 h-5"></i>
                    </a>
                @endif
                @if (isset($setting['reddit_link']) && !empty($setting['reddit_link']))
                    <a href="{{ $setting['reddit_link'] }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-reddit-alien w-5 h-5"></i>
                    </a>
                @endif
                @if (isset($setting['pinterest_link']) && !empty($setting['pinterest_link']))
                    <a href="{{ $setting['pinterest_link'] }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-pinterest w-5 h-5"></i>
                    </a>
                @endif
                @if (isset($setting['tiktok_link']) && !empty($setting['tiktok_link']))
                    <a href="{{ $setting['tiktok_link'] }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-tiktok w-5 h-5"></i>
                    </a>
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
        <div class="text-gray-400 mb-4 md:mb-0 text-center md:text-left">
            &copy; {{ \Carbon\Carbon::now()->year }} {{ getAppName() }}. {{ __('messages.theme3.all_rights_reserved') }}
        </div>
        <div class="flex flex-wrap justify-center md:justify-end gap-x-6 gap-y-2 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') md:space-x-reverse @endif">
            <a href="{{ route('privacy.policy') }}" class="text-gray-400 hover:text-white transition-colors text-sm">{{ __('messages.vcard.privacy_policy') }}</a>
            <a href="{{ route('terms.conditions') }}" class="text-gray-400 hover:text-white transition-colors text-sm">{{ __('messages.vcard.term_condition') }}</a>
            <a href="{{ route('refund.cancellation.policy') }}" class="text-gray-400 hover:text-white transition-colors text-sm">{{ __('messages.vcard.refund_cancellation_policy') }}</a>
            <a href="{{ route('shipping.delivery.policy') }}" class="text-gray-400 hover:text-white transition-colors text-sm">{{ __('messages.vcard.shipping_delivery_policy') }}</a>
            <a href="{{ route('imprint.policy') }}" class="text-gray-400 hover:text-white transition-colors text-sm">{{ __('messages.vcard.imprint_policy') }}</a>
        </div>
    </div>
</div>
    </div>
</footer>

<!-- Support Banner -->
@if (isset($setting['banner_enable']) && $setting['banner_enable'] == 1)
    <section class="flex justify-center" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="banner-section-theme4 banner-cookie-theme4 hidden flex justify-center py-4 md:py-6 lg:py-8 bg-gradient-to-br from-blue-600 to-purple-600 text-white rounded-lg md:rounded-xl p-4 md:p-6 max-w-full md:max-w-5xl mx-auto text-center">
            <div class="max-w-full md:max-w-5xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8">
                <div class="mx-auto text-center">
                    <h2 class="text-lg md:text-xl lg:text-2xl font-bold mb-2 md:mb-3">{{ $setting['banner_title'] }}</h2>
                    <p class="text-sm md:text-base opacity-90 mb-4 md:mb-6 front-banner-des">{{ $setting['banner_description'] }}</p>
                    <div class="text-center pt-1">
                        <a href="{{ $setting['banner_url'] }}"
                            class="px-4 md:px-5 py-1.5 md:py-2 bg-white text-blue-600 font-medium rounded-md md:rounded-lg hover:bg-gray-100 shadow-lg transition-all duration-300 hover:scale-105 act-now text-sm md:text-base"
                            target="_blank" data-turbo="false">{{ $setting['banner_button'] }}</a>
                        <p class="text-xs opacity-80 mt-2 md:mt-3">{{ __('messages.theme3.we_respect_privacy') }}</p>
                    </div>
                </div>
            </div>
            <div class="main-banner-theme4 close-btn bg-transparent">
                <button type="button" class="border-0 bg-transparent disbale-cookie text-white hover:text-gray-200">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    </section>
@endif
