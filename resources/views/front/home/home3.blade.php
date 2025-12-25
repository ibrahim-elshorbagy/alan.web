@extends('front.layouts.app3')
@section('title')
  {{ getAppName() }}
@endsection
@section('content')
  <!-- Hero Section -->
  <section class="pt-20 pb-24 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div
        class="flex flex-col md:flex-row items-center md:space-x-12 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') md:flex-row-reverse @endif">
        <!-- Left side: Text content -->
        <div class="md:w-1/2 mb-10 md:mb-0" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
          <div
            class="inline-flex items-center px-3 py-1.5 rounded-full bg-primary-100 text-primary-700 mb-5 text-sm font-medium">
            <i class='bx bx-badge-check mr-1.5 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ms-2 @endif'></i>
            {{ __('messages.theme3.new_templates_available') }}
          </div>
          <h1
            class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 bg-gradient-to-r from-primary-600 via-accent-500 to-teal-500 bg-clip-text text-transparent leading-tight lh-base">
            {{ $setting['home_page_title'] }}</h1>
          <p class="text-lg text-secondary-600 leading-relaxed mb-8">
            {{ $setting['sub_text'] ?? '' }}</p>
          <div class="bg-gradient-to-r from-blue-500 to-pink-500 p-[2px] rounded-md shadow-md w-full max-w-xl mx-auto">
            <div class="flex items-center bg-white rounded-md overflow-hidden w-full">
              <input id="search-alias-input" type="text" placeholder="{{ __('messages.vcard.search_vcard_alias') }}"
                class="flex-1 px-4 py-2.5 text-sm text-gray-700 bg-transparent focus:outline-none @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') text-left @endif"
                required>
              <button id="search-alias-btn" type="submit"
                class="px-6 py-2.5 text-sm text-white font-medium bg-gradient-to-r from-sky-500 to-pink-500 hover:from-sky-600 hover:to-pink-600 transition-all duration-300 rounded-md flex items-center justify-center gap-2 relative overflow-hidden">
                <!-- Loader Icon -->
                <svg id="loader-icon" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                  </circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span id="check-text">{{ __('messages.vcard.check_availability') }}</span>
              </button>
            </div>
          </div>
          <div id="search-alias-error"
            class="text-danger ms-1 d-none @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') text-left -mt-8 @else mt-1 @endif">
            {{ __('messages.vcard.already_alias_url') }}
          </div>
          <div id="search-alias-success"
            class="text-success ms-1 d-none @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') text-left -mt-8 @else mt-1 @endif">
            {{ __('messages.vcard.url_alias_available') }}
          </div>
          {{-- <div
                        class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 @if (checkFrontLanguageSession() == 'ar') sm:space-x-reverse @endif ">
                        <a href="{{ route('register') }}"
                            class="px-6 py-3.5 text-center rounded-full text-white bg-gradient-to-r from-primary-600 to-teal-500 hover:from-primary-700 hover:to-teal-600 shadow-lg transition-all duration-300 font-medium hover:shadow-primary-200/50 hover:-translate-y-0.5">{{ __('messages.theme3.get_started_free') }}</a>
                    </div> --}}
          <div
            class="flex items-center space-x-4 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') space-x-reverse mt-2 @else mt-10 @endif">
            <div class="flex -space-x-2">
              @foreach ($latestUsers as $user)
                <img class="w-10 h-10 rounded-full border-2 border-white" src="{{ $user->profile_image }}" alt="User">
              @endforeach
            </div>
            <div class="text-sm text-secondary-600">
              <span class="font-semibold">{{ $totalUser - 1 }}+</span>
              {{ __('messages.theme3.proffessionals_have_joined') }}
            </div>
          </div>
        </div>

        <!-- Right side: Digital Card Slider -->
        <div class="md:w-1/2 relative">
          <!-- Slider Container -->
          <div class="slider-container w-full md:h-[520px] relative">
            <div class="slider-track flex">
              <!-- Card Template 1: Profile Cover Card -->
              <div class="slider-item">
                <img class="w-full h-full object-cover object-center rounded-[10px]"
                  src="{{ !empty($frontSlider[0]['front_slider_img_url']) ? $frontSlider[0]['front_slider_img_url'] : asset('front/images/front_slider_1.png') }}"
                  alt="interface-img">
              </div>

              <!-- Card Template 2: QR Code Card -->
              <div class="slider-item">
                <img class="w-full h-full object-cover object-center rounded-[10px]"
                  src="{{ !empty($frontSlider[1]['front_slider_img_url']) ? $frontSlider[1]['front_slider_img_url'] : asset('front/images/front_slider_2.png') }}"
                  alt="interface-img">
              </div>

              <div class="slider-item">
                <img class="w-full h-full object-cover object-center rounded-[10px]"
                  src="{{ !empty($frontSlider[2]['front_slider_img_url']) ? $frontSlider[2]['front_slider_img_url'] : asset('front/images/front_slider_3.png') }}"
                  alt="interface-img">
              </div>

              <div class="slider-item">
                <img class="w-full h-full object-cover object-center rounded-[10px]"
                  src="{{ !empty($frontSlider[3]['front_slider_img_url']) ? $frontSlider[3]['front_slider_img_url'] : asset('front/images/front_slider_4.png') }}"
                  alt="interface-img">
              </div>

              <div class="slider-item">
                <img class="w-full h-full object-cover object-center rounded-[10px]"
                  src="{{ !empty($frontSlider[4]['front_slider_img_url']) ? $frontSlider[4]['front_slider_img_url'] : asset('front/images/front_slider_5.png') }}"
                  alt="interface-img">
              </div>
            </div>

            <!-- Slider controls -->
            <div class="absolute top-1/2 -translate-y-1/2 left-1 z-10">
              <button
                class="slider-prev w-10 h-10 rounded-full bg-blue shadow-lg flex items-center justify-center hover:bg-gray-50 transition-all">
                <i class='bx bx-chevron-left text-2xl text-white'></i>
              </button>
            </div>
            <div class="absolute top-1/2 -translate-y-1/2 right-1 z-10">
              <button
                class="slider-next w-10 h-10 rounded-full bg-blue shadow-lg flex items-center justify-center hover:bg-gray-50 transition-all">
                <i class='bx bx-chevron-right text-2xl text-white'></i>
              </button>
            </div>

            <!-- Slider dots -->
            <div class="absolute -bottom-6 left-0 right-0 flex justify-center space-x-2 z-10">
              <button class="slider-dot w-3 h-3 rounded-full bg-primary-600"></button>
              <button class="slider-dot w-3 h-3 rounded-full bg-secondary-300"></button>
              <button class="slider-dot w-3 h-3 rounded-full bg-secondary-300"></button>
            </div>
          </div>

          <!-- Decorative elements -->
          <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-primary-100 rounded-full filter blur-3xl opacity-50">
          </div>
          <div class="absolute -top-10 -left-10 w-48 h-48 bg-accent-100 rounded-full filter blur-3xl opacity-50">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end hero section -->
  <div class="vcard-template-section position-relative overflow-hidden">
    {{-- vcard slider --}}
    <section class="vcard-section py-10 pb-20" id="">
      <div class="container w-100">
        <div class="text-center mb-16">
          <h2
            class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-primary-600 via-accent-500 to-teal-500 bg-clip-text text-transparent mb-4">
            {{ __('messages.vcards_templates') }}</h2>
        </div>
        <div class="center-slider">
          <div>
            <div class="vcard-card">
              <img src="{{ asset('assets/img/templates/home/vcard33.png') }}" class="w-100 vcard-img" alt="vcard-img">
            </div>
          </div>
          <div>
            <div class="vcard-card">
              <img src="{{ asset('assets/img/templates/home/vcard32.png') }}" class="img-fluid vcard-img"
                alt="vcard-img">
            </div>
          </div>
          <div>
            <div class="vcard-card">
              <img src="{{ asset('assets/img/templates/home/vcard31.png') }}" class="w-100 vcard-img " alt="vcard-img">
            </div>
          </div>
          <div>
            <div class="vcard-card">
              <img src="{{ asset('assets/img/templates/home/vcard30.png') }}" class="w-100 vcard-img" alt="vcard-img">
            </div>
          </div>
          <div>
            <div class="vcard-card">
              <img src="{{ asset('assets/img/templates/home/vcard29.png') }}" class="w-100 vcard-img" alt="vcard-img">
            </div>
          </div>
          <div>
            <div class="vcard-card">
              <img src="{{ asset('assets/img/templates/home/vcard28.png') }}" class="w-100 vcard-img" alt="vcard-img">
            </div>
          </div>
          <div>
            <div class="vcard-card">
              <img src="{{ asset('assets/img/templates/home/vcard27.png') }}" class="w-100 vcard-img" alt="vcard-img">
            </div>
          </div>

        </div>
        <div class="col-12 text-center mt-5">
          <a href="{{ route('vcard-templates') }}"
            class="ml-2 px-6 py-2.5 rounded-full text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium"
            role="button" data-turbo="false">{{ __('messages.common.see_more') }}</a>
        </div>
      </div>
    </section>
  </div>

  <!-- Features/Services Section -->
  <section id="features" class="py-20 bg-white position-relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-primary-100 rounded-full filter blur-3xl opacity-20 -ml-12 -mt-12">
    </div>
    <div class="absolute bottom-0 right-0 w-64 h-64 bg-accent-100 rounded-full filter blur-3xl opacity-20 -mr-12 -mb-12">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="text-center mb-16" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div
          class="inline-flex items-center px-3 py-1.5 rounded-full bg-primary-100 text-primary-700 mb-5 text-sm font-medium">
          <i class='bx bx-star mr-1.5 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') mr-0 ml-1.5 @endif'></i>
          {{ __('messages.theme3.premium_features') }}
        </div>
        <h2
          class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-primary-600 via-accent-500 to-teal-500 bg-clip-text text-transparent mb-4">
          {{ __('messages.theme3.service_we_offer') }}</h2>
        <p class="text-lg text-secondary-600 max-w-3xl mx-auto">
          {{ __('messages.theme3.proffessional_identity_in_one_platform') }}</p>
      </div>

      <div class=" gap-8">
        <div class="feature-slider">
          @foreach ($features as $feature)
            <div
              class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100 transition-all duration-300 group feature-min-height"
              @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
              <div
                class="w-16 h-16 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-gradient-to-br group-hover:from-primary-200 group-hover:to-primary-300 transition-all duration-300 shadow-sm group-hover:shadow-md">
                <img src="{{ $feature->profile_image }}" class="w-100 h-100 object-fit-cover" alt="feature-img">
              </div>
              <h3 class="text-xl font-semibold text-secondary-800 mb-3">{{ $feature->name }}</h3>
              <p class="text-secondary-600">{!! $feature->description !!}</p>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  @if (!$testimonials->isEmpty())
    <section id="testimonials" class="overflow-hidden py-20 pb-10 pt-0 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
          <div
            class="inline-flex items-center px-3 py-1.5 rounded-full bg-accent-100 text-accent-700 mb-5 text-sm font-medium">
            <i class='bx bx-message-alt-detail mr-1.5 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') mr-0 ml-1.5 @endif'></i>
            {{ __('messages.theme3.client_success_stories') }}
          </div>
          <h2
            class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-primary-600 via-accent-500 to-teal-500 bg-clip-text text-transparent mb-4">
            {{ __('messages.theme3.what_our_clients_say') }}</h2>
          <p class="text-lg text-secondary-600 max-w-3xl mx-auto">
            {{ __('messages.theme3.use_vcards_to_enhance_your_network') }}</p>
        </div>

        <div class="gap-8">
          <!-- Testimonial 1 -->
          <div class="testimonial-slider">
            @foreach ($testimonials as $testimonial)
              <div
                class="bg-gradient-to-br from-white to-gray-50 p-8 rounded-xl !shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 flex flex-col testimonial-min-height"
                @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                <div class="flex-grow">
                  <div class="flex text-amber-400 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                  </div>
                  <p class="text-secondary-600 italic mb-6">{!! $testimonial->description !!}</p>
                </div>
                <div class="flex items-center mt-4">
                  <div
                    class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-700 rounded-full flex items-center justify-center text-white font-bold">
                    <img src="{{ $testimonial->testimonial_url }}" alt="profile-img"
                      class="w-100 h-100 object-fit-cover rounded-full">
                  </div>
                  <div class="ml-4 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') mr-4 @endif">
                    <h4 class="text-lg font-semibold text-secondary-800">{{ $testimonial->name }}</h4>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>
  @endif

  <!-- Pricing Section -->
  <section id="pricing"
    class="overflow-hidden pricing-plan-section py-20 bg-gradient-to-br from-primary-50 via-white to-teal-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div
          class="inline-flex items-center px-3 py-1.5 rounded-full bg-primary-100 text-primary-700 mb-5 text-sm font-medium">
          <i class='bx bx-purchase-tag mr-1.5 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') mr-0 ml-1.5 @endif'></i>
          {{ __('messages.theme3.flexible_plans') }}
        </div>
        <h2
          class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-primary-600 via-accent-500 to-teal-500 bg-clip-text text-transparent mb-4">
          {{ __('messages.theme3.choose_your_plan') }}</h2>
        <p class="text-lg text-secondary-600 max-w-3xl mx-auto">
          {{ __('messages.theme3.select_the_plan_that_fits_your_needs') }}</p>
      </div>

      <div class="gap-8 mb-8">
        <div class="pricing-slider">
          @foreach ($plans as $plan)
            <div>
              <div>
                <div
                  class="bg-white rounded-2xl shadow-xl relative border-2 center-border-main overflow-hidden transition-all duration-300 hover:shadow-2xl  transform  z-10"
                  @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                  @if ($plan->trial_days > 0)
                    <div class="absolute top-0 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') left-0 @else right-0 @endif">
                      <div
                        class="bg-primary-500 text-white px-4 py-1 text-sm font-bold tracking-wider transform
                                    @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') -translate-x-[30%] translate-y-[40%] -rotate-45 @else translate-x-[30%] translate-y-[40%] rotate-45 @endif">
                        {{ __('messages.subscription.trial_plan') }}
                      </div>
                    </div>
                  @endif
                  <div class="p-8">
                    <h3 class="text-2xl font-bold text-secondary-800 mb-4"
                      @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>{!! $plan->name !!}
                    </h3>
                    @if ($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                      <h2 class="price text-center fw-5 mb-30" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                        @php
                          $formattedPrice = str_replace(
                              '.00',
                              '',
                              currencyFormat(
                                  $plan->planCustomFields[0]->custom_vcard_price,
                                  2,
                                  $plan->currency->currency_code,
                              ),
                          );
                        @endphp
                        @if (getSuperAdminSettingValue('currency_after_amount') == 0)
                          <span class="text-4xl font-extrabold text-primary-600">
                            {{ $plan->currency->currency_icon }}
                          </span>
                          <span class="custom-price-{{ $plan->id }} text-4xl font-extrabold text-primary-600">
                            {{ $formattedPrice }}
                          </span>
                        @else
                          <span class="custom-price-{{ $plan->id }} text-4xl font-extrabold text-primary-600">
                            {{ $formattedPrice }}
                          </span>
                          <span class="text-4xl font-extrabold text-primary-600">
                            {{ $plan->currency->currency_icon }}
                          </span>
                        @endif
                        @if ($plan->frequency == 1)
                          <span
                            class="text-secondary-500 ml-2 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-0 mr-2 @endif">/{{ __('messages.plan.monthly') }}</span>
                        @elseif($plan->frequency == 2)
                          <span
                            class="text-secondary-500 ml-2 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-0 mr-2 @endif">/{{ __('messages.plan.yearly') }}</span>
                        @endif
                      </h2>
                    @else
                      <div class="flex items-baseline mb-1" id="price_{{ $plan->id }}">
                        <span class="text-4xl font-extrabold text-primary-600">
                          @if ($plan->custom_select == 0)
                            {{ str_replace('.00', '', currencyFormat($plan->price, 2, $plan->currency->currency_code)) }}
                          @endif
                        </span>
                        @if ($plan->frequency == 1)
                          <span
                            class="text-secondary-500 ml-2 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-0 mr-2 @endif">/{{ __('messages.plan.monthly') }}</span>
                        @elseif($plan->frequency == 2)
                          <span
                            class="text-secondary-500 ml-2 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-0 mr-2 @endif">/{{ __('messages.plan.yearly') }}</span>
                        @endif
                      </div>
                    @endif
                    <div
                      class="d-flex justify-content-center align-items-center my-3 {{ getLoggedInUserRoleId() != getSuperAdminRoleId() ? 'mb-4 mt-4' : 'ms-2' }}"
                      @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
                      @if ($plan->custom_select == 1 && $plan->planCustomFields->isNotEmpty())
                        {{-- <label
                                 class="fs-18 mb-3 text-gray-100">{{ __('messages.plan.custom_no_of_vcards') }}</label> --}}
                        <select id="vcardNumber-{{ $plan->id }}" class="form-select customSelect me-2 w-full"
                          data-plan-id="{{ $plan->id }}"
                          style="{{ getLoggedInUserRoleId() != getSuperAdminRoleId() ? 'width:30% !important; padding: 10px 30px' : 'width:100% !important; padding: 10px 30px' }}">
                          @foreach ($plan->planCustomFields as $customField)
                            @php
                              $formattedPrice = $customField->custom_vcard_price;
                            @endphp
                            <option value="{{ $customField->id }}" data-price="{{ $formattedPrice }}"
                              data-currency="{{ $plan->currency->currency_code }}">
                              {{ $customField->custom_vcard_number }} </option>
                          @endforeach
                        </select>
                      @endif
                      <div class="text-center">
                        @if (getLoggedInUserRoleId() != getSuperAdminRoleId())
                          @if (getLogInUser() && getLoggedInUserRoleId() != getSuperAdminRoleId())
                            <div class="mx-auto">
                              @if (
                                  !empty(getCurrentSubscription()) &&
                                      $plan->id == getCurrentSubscription()->plan_id &&
                                      !getCurrentSubscription()->isExpired())
                                @if ($plan->price != 0)
                                  <button type="button"
                                    class="px-6 py-2.5 rounded-full text-white bg-gradient-to-r from-yellow-400 via-emerald-500 to-cyan-500
                                                                        shadow-lg transition-all duration-300 hover:shadow-emerald-700/30 hover:scale-105 font-medium
                                                                        mx-auto w-100 d-block cursor-default text-sm"
                                    data-id="{{ $plan->id }}" data-turbo="false">
                                    {{ __('messages.subscription.currently_active') }}</button>
                                @else
                                  <button type="button"
                                    class="ml-2 px-6 py-2.5 rounded-full text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium  mx-auto d-block cursor-remove-plan"
                                    data-turbo="false">
                                    {{ __('messages.subscription.renew_free_plan') }}
                                  </button>
                                @endif
                              @else
                                @if (
                                    !empty(getCurrentSubscription()) &&
                                        !getCurrentSubscription()->isExpired() &&
                                        ($plan->price == 0 || $plan->price != 0))
                                  @if ($plan->hasZeroPlan->count() == 0)
                                    <a href="{{ $plan->price != 0 ? route('choose.payment.type', $plan->id) : 'javascript:void(0)' }}"
                                      class="ml-2 px-6 py-2.5 rounded-full text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium mx-auto w-100 {{ $plan->price == 0 ? 'freePayment' : '' }}"
                                      data-id="{{ $plan->id }}" id="planId{{ $plan->id }}"
                                      data-plan-price="{{ $plan->price }}" data-turbo="false">
                                      {{ __('messages.subscription.switch_plan') }}</a>
                                  @else
                                    <button type="button"
                                      class="ml-2 px-6 py-2.5 rounded-full text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium mx-auto d-block cursor-remove-plan"
                                      data-turbo="false">
                                      {{ __('messages.subscription.renew_free_plan') }}
                                    </button>
                                  @endif
                                @else
                                  @if ($plan->hasZeroPlan->count() == 0)
                                    <a href="{{ $plan->price != 0 ? route('choose.payment.type', $plan->id) : 'javascript:void(0)' }}"
                                      class="ml-2 px-6 py-2.5 rounded-full text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium mx-auto w-100 {{ $plan->price == 0 ? 'freePayment' : '' }}"
                                      data-id="{{ $plan->id }}" id="planId{{ $plan->id }}"
                                      data-plan-price="{{ $plan->price }}" data-turbo="false">
                                      {{ __('messages.subscription.choose_plan') }}</a>
                                  @else
                                    <button type="button"
                                      class="ml-2 px-6 py-2.5 rounded-full text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium mx-auto d-block cursor-remove-plan"
                                      data-turbo="false">
                                      {{ __('messages.subscription.renew_free_plan') }}
                                    </button>
                                  @endif
                                @endif
                              @endif
                            </div>
                          @else
                            <div class="mx-auto">
                              @if ($plan->hasZeroPlan->count() == 0)
                                <a href="{{ $plan->price != 0 ? route('choose.payment.type', $plan->id) : 'javascript:void(0)' }}"
                                  class="ml-2 px-6 py-2.5 rounded-full text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium mx-auto w-100 {{ $plan->price == 0 ? 'freePayment' : '' }}"
                                  data-id="{{ $plan->id }}" data-plan-price="{{ $plan->price }}"
                                  id="planId{{ $plan->id }}" data-turbo="false">
                                  {{ __('messages.subscription.choose_plan') }}</a>
                              @else
                                <button type="button"
                                  class="ml-2 px-6 py-2.5 rounded-full text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 shadow-lg transition-all duration-300 hover:shadow-primary-900/30 hover:scale-105 font-medium mx-auto d-block cursor-remove-plan"
                                  data-turbo="false">
                                  {{ __('messages.subscription.renew_free_plan') }}
                                </button>
                              @endif
                            </div>
                          @endif
                        @endif
                      </div>
                    </div>
                    <ul class="space-y-1 mb-2 text-sm leading-tight">
                      @if ($plan->trial_days > 0)
                        <li class="active-check py-0"
                          @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') style="text-align: right !important" @endif>

                          @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa')
                            <span>{{ __('messages.subscription.trial_plan') . ' (' . $plan->trial_days . ' ' . __('messages.plan.days') . ')' }}</span>
                            <i
                              class='bx bx-check-circle text-xl text-primary-500 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 @else mr-2 @endif mt-0.5'></i>
                          @else
                            <i
                              class='bx bx-check-circle text-xl text-primary-500 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 @else mr-2 @endif mt-0.5'></i>
                            <span>{{ __('messages.subscription.trial_plan') . ' (' . $plan->trial_days . ' ' . __('messages.plan.days') . ')' }}</span>
                          @endif
                        </li>
                      @endif
                      @if ($plan->custom_select == 0 && $plan->planCustomFields->isEmpty())
                        <li class="active-check py-0"
                          @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') style="text-align: right !important" @endif>
                          @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa')
                            <span>{{ __('messages.plan.no_of_vcards') }}
                              : {{ $plan->no_of_vcards }}</span>
                            <i
                              class='bx bx-check-circle text-xl text-primary-500 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 @else mr-2 @endif mt-0.5'></i>
                          @else
                            <i
                              class='bx bx-check-circle text-xl text-primary-500 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 @else mr-2 @endif mt-0.5'></i>
                            <span>{{ __('messages.plan.no_of_vcards') }}
                              : {{ $plan->no_of_vcards }}</span>
                          @endif
                        </li>
                      @endif
                      <li class="active-check py-0"
                        @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') style="text-align: right !important" @endif>
                        @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa')
                          <span>{{ __('messages.plan.storage_limit') }}:
                            {{ $plan->storage_limit }} {{ __('messages.mb') }}</span>
                          <i
                            class='bx bx-check-circle text-xl text-primary-500 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 @else mr-2 @endif mt-0.5'></i>
                        @else
                          <i
                            class='bx bx-check-circle text-xl text-primary-500 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 @else mr-2 @endif mt-0.5'></i>
                          <span>{{ __('messages.plan.storage_limit') }}:
                            {{ $plan->storage_limit }} {{ __('messages.mb') }}</span>
                        @endif
                      </li>
                      @php
                        $skipCount = $plan->custom_select == 0 && $plan->planCustomFields->isEmpty() ? 9 : 10;
                      @endphp
                      @foreach (collect(getPlanFeature($plan))->take($skipCount) as $feature => $value)
                        <li class="{{ $value == 1 ? 'active-check' : 'unactive-check' }} py-0"
                          @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') style="text-align: right !important" @endif>
                          @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa')
                            <span>{{ __('messages.feature.' . $feature) }}</span>
                            <i
                              class='bx text-xl {{ $value == 1 ? 'text-primary-500 bx-check-circle' : 'text-secondary-400 bx-x-circle' }} @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 @else mr-2 @endif mt-0.5'></i>
                          @else
                            <i
                              class='bx text-xl {{ $value == 1 ? 'text-primary-500 bx-check-circle' : 'text-secondary-400 bx-x-circle' }} @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 @else mr-2 @endif mt-0.5'></i>
                            <span>{{ __('messages.feature.' . $feature) }}</span>
                          @endif
                        </li>
                      @endforeach
                    </ul>

                    <!-- Accordion for more features -->
                    <div class="mb-4 border-t border-gray-100 pt-2">
                      <button
                        class="accordion-toggle flex justify-between items-center w-full text-left text-sm text-primary-700 font-medium @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir='rtl' @endif">
                        <span>{{ __('messages.theme3.view_more_features') }}</span>
                        <i class='bx bx-chevron-down text-lg transition-transform duration-200'></i>
                      </button>
                      <div class="accordion-content hidden pt-2">
                        <ul class="space-y-1 text-sm leading-tight">
                          @foreach (collect(getPlanFeature($plan))->skip($skipCount) as $feature => $value)
                            <li class="{{ $value == 1 ? 'active-check' : 'unactive-check' }} py-0"
                              @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') style="text-align: right !important" @endif>
                              @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa')
                                {{ __('messages.feature.' . $feature) }}
                                <i
                                  class='bx text-xl {{ $value == 1 ? 'text-primary-500 bx-check-circle' : 'text-secondary-400 bx-x-circle' }} @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 @else mr-2 @endif mt-0.5'></i>
                              @else
                                <i
                                  class='bx text-xl {{ $value == 1 ? 'text-primary-500 bx-check-circle' : 'text-secondary-400 bx-x-circle' }} @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-2 @else mr-2 @endif mt-0.5'></i>
                                {{ __('messages.feature.' . $feature) }}
                              @endif
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    </div>
                    {{-- <a href="#"
                                class="w-full inline-block px-6 py-3.5 text-center rounded-full text-white bg-gradient-to-r from-primary-600 to-accent-600 hover:from-primary-700 hover:to-accent-700 shadow-lg transition-all duration-300 font-medium">Start
                                7-Day Trial</a> --}}
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="bg-white p-6 mt-5 rounded-xl shadow-md border border-gray-100 max-w-3xl mx-auto"
        @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
        <div class="flex items-start">
          <div class="flex-shrink-0">
            <i
              class='bx bx-info-circle text-2xl text-primary-500 mr-4 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-4 mr-0 @endif'></i>
          </div>
          <div>
            <h4 class="text-lg font-semibold text-secondary-800 mb-2">
              {{ __('messages.theme3.looking_for_custom_solutions') }}</h4>
            <p class="text-secondary-600 mb-4">{{ __('messages.theme3.need_solution') }}</p>
            <a href="#contact" class="text-primary-600 font-medium hover:text-primary-700 inline-flex items-center">
              {{ __('messages.theme3.contact_our_team') }} <i class='bx bx-right-arrow-alt ml-1'></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Us Section -->
  <section id="about" class="py-20 bg-primary-50 relative overflow-hidden"
    @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
    <!-- Decorative elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-primary-100 rounded-full filter blur-3xl opacity-30 -ml-48 -mt-48">
    </div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent-100 rounded-full filter blur-3xl opacity-30 -mr-48 -mb-48">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="text-center mb-16">
        <div
          class="inline-flex items-center px-3 py-1.5 rounded-full bg-primary-100 text-primary-700 mb-5 text-sm font-medium">
          <i class='bx bx-bulb mr-1.5 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-1.5 mr-0 @endif'></i>
          {{ __('messages.theme3.our_mission') }}
        </div>
        <h2
          class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-primary-600 via-accent-500 to-teal-500 bg-clip-text text-transparent mb-4">
          {{ __('messages.theme3.about_vcards') }}</h2>
        <p class="text-lg text-secondary-600 max-w-3xl mx-auto">{{ __('messages.theme3.professional_network') }}
        </p>
      </div>

      <h3 class="text-2xl font-bold text-center text-secondary-800 mb-8">
        {{ __('messages.theme3.why_choose_vcards') }}</h3>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 mb-16">
        <!-- Value Proposition 1 -->
        <div
          class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1 group">
          <div class="aspect-w-16 aspect-h-9 relative">
            <img class="w-full h-80 object-cover object-center"
              src="{{ isset($aboutUS[0]['about_url']) ? $aboutUS[0]['about_url'] : asset('front/images/about-1.png') }}"
              alt="interface-img">
            <div
              class="absolute inset-0 bg-gradient-to-tr from-primary-500/80 to-primary-700/80 opacity-90 flex items-center justify-center">
              <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                <i class='bx bx-book-open text-3xl text-white'></i>
              </div>
            </div>
          </div>
          <div class="p-6">
            <h4 class="text-xl font-bold text-secondary-800 mb-3"> {{ $aboutUS[0]['title'] }}</h4>
            <p class="text-secondary-600 mb-4">{!! nl2br(e($aboutUS[0]['description'])) !!}
            </p>
          </div>
        </div>

        <!-- Value Proposition 2 -->
        <div
          class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1 group">
          <div class="aspect-w-16 aspect-h-9 relative">
            <img class="w-full h-80 object-cover object-center"
              src="{{ isset($aboutUS[1]['about_url']) ? $aboutUS[1]['about_url'] : asset('front/images/about-2.png') }}"
              alt="interface img" />
            <div
              class="absolute inset-0 bg-gradient-to-tr from-accent-500/80 to-accent-700/80 opacity-90 flex items-center justify-center">
              <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                <i class='bx bx-check-shield text-3xl text-white'></i>
              </div>
            </div>
          </div>
          <div class="p-6">
            <h4 class="text-xl font-bold text-secondary-800 mb-3"> {{ $aboutUS[1]['title'] }}</h4>
            <p class="text-secondary-600 mb-4"> {!! nl2br(e($aboutUS[1]['description'])) !!}
            </p>
          </div>
        </div>

        <!-- Value Proposition 3 -->
        <div
          class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1 group">
          <div class="aspect-w-16 aspect-h-9 relative">
            <img class="w-full h-80 object-cover object-center"
              src="{{ isset($aboutUS[2]['about_url']) ? $aboutUS[2]['about_url'] : asset('front/images/about-3.png') }}"
              alt="interface img" />
            <div
              class="absolute inset-0 bg-gradient-to-tr from-teal-500/80 to-teal-700/80 opacity-90 flex items-center justify-center">
              <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                <i class='bx bx-line-chart text-3xl text-white'></i>
              </div>
            </div>
          </div>
          <div class="p-6">
            <h4 class="text-xl font-bold text-secondary-800 mb-3"> {{ $aboutUS[2]['title'] }}</h4>
            <p class="text-secondary-600 mb-4">{!! nl2br(e($aboutUS[2]['description'])) !!}</p>
          </div>
        </div>
      </div>

      <div class="text-center mb-16">
        <div
          class="inline-flex items-center px-3 py-1.5 rounded-full bg-primary-100 text-primary-700 mb-5 text-sm font-medium">
          <i class='bx bx-bulb mr-1.5 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-1.5 mr-0 @endif'></i>
          {{ __('messages.theme3.our_values') }}
        </div>
        <h3 class="text-2xl font-bold text-secondary-800 mb-4">{{ __('messages.theme3.what_drives_us') }}
        </h3>
        <p class="text-lg text-secondary-600 max-w-3xl mx-auto mb-8">
          {{ __('messages.theme3.innovation_and_excellence') }}</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
              @if (!empty($whatDrivesUS[0]['what_drive_us_url']))
                <img src="{{ $whatDrivesUS[0]['what_drive_us_url'] }}"
                  class="w-100 h-100 object-fit-cover rounded-full" alt="feature-img">
              @else
                <i class='bx bx-bulb text-2xl text-primary-600'></i>
              @endif
            </div>
            <h4 class="text-lg font-bold text-secondary-800 mb-2">{{ $whatDrivesUS[0]['title'] }}
            </h4>
            <p class="text-secondary-600 text-sm">{!! nl2br(e($whatDrivesUS[0]['description'])) !!}</p>
          </div>

          <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-4">
              @if (!empty($whatDrivesUS[1]['what_drive_us_url']))
                <img src="{{ $whatDrivesUS[1]['what_drive_us_url'] }}"
                  class="w-100 h-100 object-fit-cover rounded-full" alt="feature-img">
              @else
                <i class='bx bx-user-voice text-2xl text-accent-600'></i>
              @endif
            </div>
            <h4 class="text-lg font-bold text-secondary-800 mb-2">{{ $whatDrivesUS[1]['title'] }}
            </h4>
            <p class="text-secondary-600 text-sm">{!! nl2br(e($whatDrivesUS[1]['description'])) !!}</p>
          </div>

          <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">

              @if (!empty($whatDrivesUS[2]['what_drive_us_url']))
                <img src="{{ $whatDrivesUS[2]['what_drive_us_url'] }}"
                  class="w-100 h-100 object-fit-cover rounded-full" alt="feature-img">
              @else
                <i class='bx bx-shield-quarter text-2xl text-teal-600'></i>
              @endif

            </div>
            <h4 class="text-lg font-bold text-secondary-800 mb-2">{{ $whatDrivesUS[2]['title'] }}
            </h4>
            <p class="text-secondary-600 text-sm">{!! nl2br(e($whatDrivesUS[2]['description'])) !!}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16">
        <div class="grid grid-cols-1 md:grid-cols-2">
          <div class="p-8 md:p-12 flex flex-col justify-center">
            <h3 class="text-2xl md:text-3xl font-bold text-secondary-800 mb-4">
              {{ $setting['our_mission_title'] }}</h3>
            <p class="text-lg text-secondary-600 mb-6">{{ $setting['our_mission_description1'] }}
            </p>
            <div class="grid grid-cols-2 gap-6 mb-6">
              <div class="bg-primary-50 p-4 rounded-lg">
                <div class="text-primary-600 font-bold text-2xl mb-1">{{ $activeUser - 1 }}+</div>
                <div class="text-secondary-600 text-sm">{{ __('messages.theme3.acvitive_users') }}
                </div>
              </div>
              <div class="bg-accent-50 p-4 rounded-lg">
                <div class="text-accent-600 font-bold text-2xl mb-1">{{ $toalVcards - 1 }}+</div>
                <div class="text-secondary-600 text-sm">{{ __('messages.theme3.generated_vcards') }}
                </div>
              </div>
            </div>
          </div>
          <div
            class="bg-gradient-to-br from-primary-600 to-accent-600 md:h-auto flex items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 bg-pattern opacity-10"></div>
            <div class="relative p-8 md:p-12 text-white text-center">
              <i class='bx bx-quote-left text-5xl text-white/30 mb-4'></i>
              <p class="text-lg md:text-xl italic mb-6">{{ $setting['our_mission_description2'] }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="py-20 bg-secondary-50 relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-100 rounded-full filter blur-3xl opacity-20 -mr-48 -mt-48">
    </div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent-100 rounded-full filter blur-3xl opacity-20 -ml-48 -mb-48">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10"
      @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
      <div class="text-center mb-16">
        <h2
          class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-primary-600 via-accent-500 to-teal-500 bg-clip-text text-transparent mb-4">
          {{ __('messages.theme3.frequently_asked_questions') }}</h2>
        <p class="text-lg text-secondary-600 max-w-3xl mx-auto">
          {{ __('messages.theme3.find_answers_to_the_most_common_questions') }}</p>
      </div>

      <div class="max-w-4xl mx-auto mb-16">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          @foreach ($faq as $faqs)
            <div class="border-b border-gray-100 last:border-b-0">
              <button class="flex justify-between items-center w-full px-6 py-3 lg:py-5 text-left"
                onclick="toggleFAQ(this)">
                <span class="font-semibold text-secondary-800">{{ $faqs->title }}</span>
                <i class='bx bx-chevron-down text-xl text-secondary-500 transition-transform duration-200'></i>
              </button>
              <div class="hidden px-6 pb-5">
                <p class="text-secondary-600">{!! $faqs->description !!}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="text-center">
        <p class="text-lg text-secondary-600 mb-6">{{ __('messages.theme3.still_have_questions') }}</p>
        <a href="#contact"
          class="px-6 py-3 rounded-full text-white bg-gradient-to-r from-primary-600 to-accent-600 hover:from-primary-700 hover:to-accent-700 shadow-lg transition-all duration-300 font-medium inline-block hover:-translate-y-0.5 hover:shadow-primary-300/50">
          {{ __('messages.theme3.contact_our_support_team') }}
        </a>
      </div>
    </div>

    <!-- Add JavaScript for FAQ toggle -->
    <script>
      function toggleFAQ(button) {
        // Toggle active state for the button
        button.classList.toggle('active');

        // Find the content div (next sibling after the button)
        const content = button.nextElementSibling;

        // Toggle visibility
        if (content.classList.contains('hidden')) {
          content.classList.remove('hidden');
          button.querySelector('i').style.transform = 'rotate(180deg)';
        } else {
          content.classList.add('hidden');
          button.querySelector('i').style.transform = 'rotate(0)';
        }
      }
    </script>
  </section>

  <!-- Contact Us Section -->
  <section id="contact" class="py-12 bg-white relative" @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') dir="rtl" @endif>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="text-center mb-10">
        <div
          class="inline-flex items-center px-3 py-1.5 rounded-full bg-primary-100 text-primary-700 mb-4 text-sm font-medium">
          <i class='bx bx-envelope mr-1.5 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') mr-0 ml-1.5 @endif'></i>
          {{ __('messages.vcard_11.get_in_touch') }}
        </div>
        <h2
          class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-primary-600 via-accent-500 to-teal-500 bg-clip-text text-transparent mb-2">
          {{ __('messages.dynamic_vcard.contact_us') }}</h2>
        <p class="text-secondary-600 max-w-xl mx-auto text-sm">
          {{ __('messages.theme3.learn_more_about_what_we_offer') }}</p>
      </div>

      <div
        class="bg-gradient-to-br from-primary-50 to-accent-50 rounded-xl shadow-md p-6 md:p-8 relative overflow-hidden">
        <!-- Decorative elements -->
        <div
          class="absolute top-0 left-0 w-32 h-32 bg-primary-100 rounded-full filter blur-3xl opacity-20 -ml-16 -mt-16">
        </div>
        <div
          class="absolute bottom-0 right-0 w-32 h-32 bg-accent-100 rounded-full filter blur-3xl opacity-20 -mr-16 -mb-16">
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6 md:gap-10">
          <!-- Contact Information -->
          <div class="md:w-1/3 space-y-4">
            <div class="bg-white rounded-lg p-4 shadow-sm">
              <div class="flex items-center space-x-3">
                <div
                  class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-3 @endif">
                  <i class='bx bx-envelope text-xl'></i>
                </div>
                <div>
                  <h4 class="font-medium text-secondary-800 text-sm">{{ __('messages.common.email') }}
                  </h4>
                  <p class="text-sm text-primary-600">{{ $setting['email'] }}</p>
                </div>
              </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm">
              <div class="flex items-center space-x-3">
                <div
                  class="w-10 h-10 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-3 @endif">
                  <i class='bx bx-phone text-xl'></i>
                </div>
                <div>
                  <h4 class="font-medium text-secondary-800 text-sm">{{ __('messages.common.phone') }}
                  </h4>
                  <p class="text-sm text-accent-600">
                    {{ '+' . $setting['prefix_code'] . ' ' . $setting['phone'] }}</p>
                </div>
              </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-sm">
              <div class="flex items-center space-x-3">
                <div
                  class="min-w-40px w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 @if (checkFrontLanguageSession() == 'ar' || checkFrontLanguageSession() == 'fa') ml-3 @endif">
                  <i class='bx bx-map-pin text-xl'></i>
                </div>
                <div>
                  <h4 class="font-medium text-secondary-800 text-sm">{{ __('messages.theme3.office') }}
                  </h4>
                  <p class="text-sm text-teal-600">{{ $setting['address'] }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Contact Form -->
          <div class="md:w-2/3 bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-lg font-semibold text-secondary-800 mb-4">{{ __('messages.theme3.send_a_msg') }}
            </h3>
            <form class="space-y-4 contact-form" id="myForm">
              @csrf
              <div id="contactError" class="alert alert-danger d-none"></div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <input type="text" name="name" id="name"
                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="{{ __('messages.theme3.your_name') }}" required>
                </div>
                <div>
                  <input type="email" name="email" id="email"
                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="{{ __('messages.theme3.email_address') }}" required>
                </div>
              </div>

              <div>
                <input type="text" id="subject" name="subject"
                  class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500"
                  placeholder="{{ __('messages.common.subject') }}" required>
              </div>

              <div>
                <textarea name="message" id="message" rows="3"
                  class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500"
                  placeholder="{{ __('messages.theme3.your_msg') }}"required></textarea>
              </div>

              <div class="flex items-center justify-center">
                <button type="submit"
                  class="px-5 py-2 rounded-lg text-white bg-gradient-to-r from-primary-600 to-accent-600 hover:from-primary-700 hover:to-accent-700 shadow-sm transition-all duration-200 font-medium text-sm flex items-center">
                  <i class='bx bx-paper-plane mr-1.5'></i> {{ __('messages.contact_us.send_message') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
