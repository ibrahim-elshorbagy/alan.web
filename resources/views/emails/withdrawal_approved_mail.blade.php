@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" style="height:auto!important;width:auto!important;object-fit:cover"
                alt="{{ getAppName() }}">
        @endcomponent
    @endslot


    {{-- Body --}}
    @if (!empty($content))
        {!! $content !!}
    @else
        <div>
            <h2>{{ __('messages.mail.hello') }} <b>{{ $toName }}</b></h2>
            <p><b>{{ __('messages.mail.withdrawal_request_amount') }} {{ currencyFormat($amount, 2) }} {{ __('messages.mail.is_approved') }}</b></p>
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
