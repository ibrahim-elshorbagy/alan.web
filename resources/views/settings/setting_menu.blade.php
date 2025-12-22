<div class="me-5">
    <ul class="d-flex nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap flex-column setting-tab" id="myTab"
        role="tablist">
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ isset($sectionName) && $sectionName == 'general' ? 'active' : '' }}"
                href="{{ route('setting.index', ['section' => 'general']) }}">
                <i class="fas fa-cogs icon-color-bs-orange"></i>&nbsp;
                {{ __('messages.setting.general') }}</a>
        </li>

        <li class=" nav-item position-relative" role="presentation">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ isset($sectionName) && $sectionName == 'terms-conditions' ? 'active' : '' }}"
                href="{{ route('setting.index', ['section' => 'terms-conditions']) }}"><i
                    class="fa-solid fa-clipboard-list icon-color-bs-red"></i> &nbsp;{!! __('messages.vcard.term_condition') !!}</a>
        </li>

        {{-- <li class=" nav-item position-relative" role="presentation">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ (isset($sectionName) && $sectionName == 'manual_payment_guide') ? 'active' : '' }}"
               href="{{ route('setting.index',['section' => 'manual_payment_guide']) }}"><i class="fa-solid fa-receipt"></i> &nbsp;{{__('messages.vcard.manual_payment_guide') }}</a>
        </li> --}}

        <li class=" nav-item position-relative" role="presentation">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ isset($sectionName) && $sectionName == 'google_analytics' ? 'active' : '' }}"
                href="{{ route('setting.index', ['section' => 'google_analytics']) }}"><i
                    class="fa-brands fa-google icon-color-bs-green"></i>
                &nbsp;{{ __('messages.vcard.google_config') }}</a>
        </li>

        <li class=" nav-item position-relative" role="presentation">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ isset($sectionName) && $sectionName == 'payment_method' ? 'active' : '' }}"
                href="{{ route('setting.index', ['section' => 'payment_method']) }}" data-turbo="false"><i
                    class="fa-solid fa-money-bill-1-wave icon-color-bs-yellow"></i>
                &nbsp;{{ __('messages.vcard.payment_config') }}</a>
        </li>

        <li class=" nav-item position-relative" role="presentation">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ isset($sectionName) && $sectionName == 'home_page_settings' ? 'active' : '' }}"
                href="{{ route('setting.index', ['section' => 'home_page_settings']) }}" data-turbo="false"><i
                    class="fa-solid fa-house icon-color-bs-purple"></i>
                &nbsp;{{ __('messages.vcard.homepage_settings') }}</a>
        </li>

        <li class=" nav-item position-relative" role="presentation">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ isset($sectionName) && $sectionName == 'recaptcha_settings' ? 'active' : '' }}"
                href="{{ route('setting.index', ['section' => 'recaptcha_settings']) }}" data-turbo="false">
                <i class="fa-brands fa-google-plus-g icon-color-gray"></i>
                &nbsp;{{ __('messages.setting.google_recaptcha') }}</a>
        </li>

        <li class=" nav-item position-relative" role="presentation">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ isset($sectionName) && $sectionName == 'social_settings' ? 'active' : '' }}"
                href="{{ route('setting.index', ['section' => 'social_settings']) }}" data-turbo="false">
                <i class="fa-solid fa-earth-americas icon-color-bs-peach"></i>
                &nbsp;{{ __('messages.setting.social_settings') }}</a>
        </li>

        <li class=" nav-item position-relative" role="presentation">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ isset($sectionName) && $sectionName == 'mail_settings' ? 'active' : '' }}"
                href="{{ route('setting.index', ['section' => 'mail_settings']) }}" data-turbo="false"><i
                    class="fa-solid fa-envelope icon-color-bs-blue"></i>
                &nbsp;{{ __('messages.vcard.mail_settings') }}</a>
        </li>
        @php
            $sectionName = $sectionName ?? request()->get('section', 'general');
        @endphp
        <li class=" nav-item position-relative" role="presentation">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ isset($sectionName) && $sectionName == 'custom_domain' || $sectionName == 'custom_domain_guide' ? 'active' : '' }}"
                href="{{ route('setting.index', ['section' => 'custom_domain']) }}" data-turbo="false"><i
                class="fa-solid fa-globe icon-color-bs-blue"></i>
                &nbsp;{{ __('messages.custom_domain.custom_domain') }}</a>
          </li>

        <li class=" nav-item position-relative" role="presentation">
            <a class="nav-link me-0 p-0 gap-2 align-items-center {{ isset($sectionName) && $sectionName == 'theme_color' ? 'active' : '' }}"
                href="{{ route('setting.index', ['section' => 'theme_color']) }}" data-turbo="false"><i class="fa-solid fa-palette icon-color-bs-pink"></i>
                &nbsp;{{ __('messages.setting.theme_color') }}</a>
        </li>

        @if (moduleExists('SlackIntegration'))
            <li class="nav-item position-relative" role="presentation">
                <a class="nav-link me-0 p-0 gap-2 align-items-center {{ request()->get('section') !== null && request()->get('section') == 'SlackIntegration' ? 'active' : '' }}"
                    href="{{ route('slack_integration.index', ['section' => 'SlackIntegration']) }}" data-turbo="false">
                    <i class="fa-brands fa-slack icon-color-gray"></i>
                    &nbsp;{{ __('slackintegration::messages.slack_integration') }}
                </a>
            </li>
        @endif
    </ul>
</div>
