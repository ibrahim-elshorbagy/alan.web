@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" style="height:auto!important;width:auto!important;object-fit:cover"
                alt="{{ getAppName() }}">
        @endcomponent
    @endslot
    @if (!empty($content))
        {!! $content !!}
    @else
        <div>
            <h2>{{ __('messages.mail.hello') }}</h2>
            <p>{{ __('messages.mail.received_invite_form') }} {{ $input['username'] }}.</p>
            {{ __('messages.mail.please_click_to_register') }}
            <br>
            <a href="{{ $input['referralUrl'] }}">{{ $input['referralUrl'] }}</a>
            <p></p>
            <p>{{ __('messages.mail.thanks_regard') }}</p>
            <p>{{ getAppName() }}</p>
        </div>
    @endif
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getAppName() }}.</h6>
        @endcomponent
    @endslot
@endcomponent
