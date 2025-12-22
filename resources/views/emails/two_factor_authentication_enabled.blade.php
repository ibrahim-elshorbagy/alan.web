@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" style="height:auto!important;width:auto!important;object-fit:cover"
                alt="{{ getAppName() }}">
        @endcomponent
    @endslot
    <h2>{{ __('Dear') }} {{ $user['full_name'] }}<br>
    </h2>
    <p>{{__('messages.mail.2fa_enable_for_your_account')}}</p>
    <p><b>{{ __('Secret Key:') }} </b> {{ $secrect_key }}</p>
    <p>{{__('messages.mail.store_key_securely')}}</p>
    <p>{{__('messages.mail.contact_support_team')}}</p>
    <p>{{ __('messages.mail.thanks_regard') }}</p>
    <p>{{ getAppName() }}</p>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getAppName() }}.</h6>
        @endcomponent
    @endslot
@endcomponent
