<header class='d-flex align-items-center justify-content-between flex-grow-1 header px-3 px-xl-0'>
    <button type="button" class="btn px-0 aside-menu-container__aside-menubar d-block d-xl-none sidebar-btn sidemenu-btn">
        <i class="fa-solid fa-bars fs-1"></i>
    </button>
    <nav class="navbar navbar-expand-xl navbar-light top-navbar d-xl-flex d-block px-3 px-xl-0 py-4 py-xl-0 {{ !getLogInUser()->theme_mode ? 'bg-white' : '' }}"id="nav-header">
        <div class="container-fluid pe-0">
            <div class="navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 {{ !Request::is(
                        'sadmin/front-cms*',
                        'sadmin/email-subscription*',
                        'sadmin/features*',
                        'sadmin/about-us*',
                        'sadmin/frontTestimonial*',
                        'sadmin/inquiries*',
                        'sadmin/frontFaqs*',
                        'sadmin/theme-configuration*',
                        'sadmin/banner*',
                        'sadmin/app-download*',
                        'sadmin/front-slider*',
                        'sadmin/what-drives-us*',
                        'sadmin/our-mission*',
                    )
                        ? ''
                        : 'front-cms-ul' }}">
                    @include('layouts.sub_menu')
                </ul>
            </div>
        </div>
    </nav>
    <ul class="nav align-items-center flex-nowrap">
        <li class="nav-item px-3 mt-1">
            <div class="dropdown dashboard-language-theme-icons">
                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset(\App\Models\User::FLAG[getCurrentLanguageName()]) }}" class="me-2"
                            style="width: 18px; height: 20px;" />
                {{getLanguageByKey(getCurrentLanguageName())}}
                </a>
                <ul class="dropdown-menu lang-drop-menu p-2" aria-labelledby="dropdownMenuLink">
                    @foreach (getAllLanguageWithFullData() as $key => $language)
                        <li class="adminLanguageSelection {{ checkFrontLanguageSession() == $key ? 'active' : '' }}"
                            data-prefix-value="{{ $language->iso_code }}">
                            <a href="javascript:void(0)"
                                class="nav-link d-flex align-items-center dropdown-item  dashboard-dropdown {{ checkFrontLanguageSession() == $key ? 'active' : '' }}">
                                @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                    @foreach (\App\Models\User::FLAG as $imageKey => $imageValue)
                                        @if ($imageKey == $language->iso_code)
                                            <img src="{{ asset($imageValue) }}" class="me-2"
                                                style="width: 18px; height: 20px;" />
                                        @endif
                                    @endforeach
                                @else
                                    @if (count($language->media) != 0)
                                        <img src="{{ $language->image_url }}" class="me-2"
                                        style="width: 18px; height: 20px;" />
                                    @else
                                        <i class="fa fa-flag fa-xl me-3 text-danger" aria-hidden="true"></i>
                                    @endif
                                @endif
                                {{ $language->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </li>
        @if(getLogInUser()->theme_mode)
            <li class="px-xxl-3 px-2">
                <a data-turbo="false" href="{{ route('mode.theme') }}" class="dashboard-theme-icons" title="{{__('messages.tooltip.light_mode')}}">
                    <i class="fa-solid fa-sun fs-2"></i>
                </a>
            </li>
        @else
            <li class="px-xxl-3 px-2">
                <a data-turbo="false" href="{{ route('mode.theme') }}" class="dashboard-theme-icons" title="{{__('messages.tooltip.dark_mode')}}">
                    <i class="fa-solid fa-moon fs-2"></i>
                </a>
            </li>
        @endif

        @role(\App\Models\Role::ROLE_ADMIN)
        @if(!empty(getCurrentSubscription()) && getCurrentSubscription()->plan->is_trial)
            <li class="px-xxl-3 px-2">
                <span class="text-primary">
                    {{ __('messages.subscription.trial_plan') }}
                </span>
            </li>
        @endif
        @endrole

        @impersonating
        <li class="px-xxl-3 px-2">
            <span class="text-primary">
                <a data-turbo="false" data-turbo-eval="false" class="dashboard-theme-icons" href="{{ route('impersonate.leave') }}" >
                    <i class="fas fa-user-check fs-2"></i>
                </a>
            </span>
        </li>
        @endImpersonating

        <li class="px-xxl-3 px-2">
            <div class="dropdown d-flex align-items-center py-4">
                <div class="image image-circle image-mini">
                    <img src="{{ getLogInUser()->profile_image }}"
                         class="img-fluid" alt="profile image">
                </div>
                <button class="btn dropdown-toggle ps-2 pe-0" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    {!! getLogInUser()->full_name !!}
                </button>
                <div class="dropdown-menu py-4 my-2" aria-labelledby="dropdownMenuButton1" data-bs-auto-close="outside" style="z-index: 999999">
                    <div class="text-center border-bottom pb-5">
                        <div class="image image-circle image-tiny mb-5">
                            <img src="{{ getLogInUser()->profile_image }}" class="img-fluid" alt="profile image">
                        </div>
                        <h3 class="text-gray-900">{{ getLogInUser()->full_name }}</h3>
                        <h4 class="mb-0 fw-400 fs-6">{{ getLogInUser()->email }}</h4>
                    </div>
                    <ul class="pt-4">
                        <li class="px-4">
                            <a class="dropdown-item  dashboard-dropdown" href="{{ route('profile.setting') }}">
                            <span class="dropdown-icon me-2">
                                <i class="fa-solid fa-user icon-color-gray"></i>
                            </span>
                                {{ __('messages.user.account_setting') }}
                            </a>
                        </li>
                        @role(\App\Models\Role::ROLE_ADMIN)
                            <li class="px-4">
                                <a class="dropdown-item  dashboard-dropdown" href="{{ route('subscription.index') }}">
                                    <span class="dropdown-icon me-2">
                                        <i class="fa-solid fa-money-bill icon-color-gray"></i>
                                    </span>
                                    {{ __('messages.subscription.manage_subscription') }}</a>
                            </li>
                        @endrole
                        @if((is_impersonating() === false))
                            <li class="px-4">
                                <a class="dropdown-item  dashboard-dropdown" id="changePassword" href="javascript:void(0)">
                                    <span class="dropdown-icon me-2">
                                        <i class="fa-solid fa-lock icon-color-gray"></i>
                                    </span>
                                    {{ __('messages.user.change_password') }}
                                </a>
                            </li>
                        @endif
                        @role(\App\Models\Role::ROLE_ADMIN)
                            <li class="px-4">
                                <a class="dropdown-item  dashboard-dropdown"
                                    @if (Auth()->user()->enable_two_factor_authentication == 1) id="ManageTwoFactorAuthenticationModel" @else id="TwoFactorAuthentication" @endif
                                    href="javascript:void(0)">
                                    <span class="dropdown-icon me-2">
                                        <i class="fa-solid fa-key icon-color-gray"></i>
                                    </span>
                                    {{ __('messages.two_factor_auth.twofactor_authentication') }}
                                </a>
                            </li>
                        @endrole
                        <li class="px-4">
                            <a class="dropdown-item  dashboard-dropdown" id="changeLanguage" href="javascript:void(0)">
                               <span class="dropdown-icon me-2">
                                   <i class="fa-solid fa-globe icon-color-gray"></i>
                               </span>
                                {{ __('messages.user.change_language') }}
                            </a>
                        </li>
                        @role(\App\Models\Role::ROLE_ADMIN)
                        <li class="px-4">
                            <a class="dropdown-item  dashboard-dropdown" href="{{ route('delete-account') }}">
                                <span class="dropdown-icon me-2">
                                    <i class="fa-solid fa-trash icon-color-gray"></i>
                                </span>
                                {{ __('messages.user.delete_my_account') }}</a>
                        </li>
                        @endrole
                        <li class="px-4">
                            <a class="dropdown-item  dashboard-dropdown text-gray-900 d-flex justify-content-start" href="javascript:void(0)">
                                <span class="dropdown-icon me-2">
                                    <i class="fa-solid fa-right-from-bracket icon-color-gray"></i>
                                </span>
                                <form id="logout-form" action="{{ route('logout')}}" method="post">
                                    @csrf
                                </form>
                                <span onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                                    {{ __('messages.sign_out') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <button type="button" class="btn px-0 d-block d-xl-none header-btn pb-2">
                <i class="fa-solid fa-bars fs-1"></i>
            </button>
        </li>
    </ul>
</header>
<div class="bg-overlay" id="nav-overly"></div>
