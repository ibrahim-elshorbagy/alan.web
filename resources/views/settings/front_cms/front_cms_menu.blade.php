<div class="me-5">
    <ul class="d-flex nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap flex-column setting-tab" id="myTab"
        role="tablist">
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/front-cms*') ? 'active' : '' }}"
                href="{{ route('setting.front.cms') }}">
                {{ __('messages.front_cms.front_cms') }}</a>
        </li>
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/advanced*') ? 'active' : '' }}"
                href="{{ route('setting.advanced') }}">
                {{ __('messages.vcard.advanced') }}</a>
        </li>
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/email-subscription*') ? 'active' : '' }}"
                href="{{ route('email.sub.index') }}">
                {{ __('messages.subscriber') }}</a>
        </li>
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/features*') ? 'active' : '' }}"
                href="{{ route('features.index') }}">
                {{ __('messages.plan.features') }}</a>
        </li>
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/about-us*') ? 'active' : '' }}"
                href="{{ route('aboutUs.index') }}">
                {{ __('messages.about_us.about_us') }}</a>
        </li>
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/frontTestimonial*') ? 'active' : '' }}"
                href="{{ route('frontTestimonials.index') }}">
                {{ __('messages.vcard.testimonials') }}</a>
        </li>
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/frontFaqs*') ? 'active' : '' }}"
                href="{{ route('frontFaqs.index') }}">
                {{ __('messages.faqs.faqs') }}</a>
        </li>
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/inquiries*') ? 'active' : '' }}"
                href="{{ route('contact.contactus') }}">
                {{ __('messages.contact_us.inquries') }}</a>
        </li>
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/theme-configuration*') ? 'active' : '' }}"
                href="{{ route('themeConfiguration') }}">
                {{ __('messages.vcard.theme_config') }}</a>
        </li>
        <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/banner*') ? 'active' : '' }}"
                href="{{ route('banner') }}">
                {{ __('messages.front_cms.banner_title') }}</a>
        </li>
        {{-- <li class=" nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/app-download*') ? 'active' : '' }}"
                href="{{ route('appDownload') }}">
                {{ __('messages.download_app_url') }}</a>
        </li> --}}
        <li class="nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/front-slider*') ? 'active' : '' }}"
                href="{{ route('front-slider.index') }}">
                {{ __('messages.front_slider') }}</a>
        </li>
        <li class="nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/what-drives-us*') ? 'active' : '' }}"
                href="{{ route('what-drives-us.index') }}">
                {{ __('messages.theme3.what_drives_us') }}</a>
        </li>
        <li class="nav-item position-relative">
            <a class="nav-link me-0 p-0 {{ Request::is('sadmin/our-mission*') ? 'active' : '' }}"
            href="{{ route('our-mission.index') }}">{{ __('messages.theme3.our_mission') }}</a>
        </li>
        </li>

    </ul>
</div>
