@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" style="height:auto!important;width:auto!important;object-fit:cover" alt="{{ getAppName() }}">
        @endcomponent
    @endslot


    {{-- Body --}}
    <div>
        <h2>{{ __('messages.mail.hello') }} <b>{{ $toName }}</b></h2>
        <p><b>Your custom domain request has been approved </b>.</p>
        <p><b>Domain Name : </b> {{ $domain_name }}</p>
        <p><b>You are eligible to use custom domain now !!!</p>
        <p><b>To use custom domain you can simply share URL like "https://your-domain/{url-alias}"</p>
        <p>{{ getAppName() }}</p>
    </div>


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getAppName() }}.</h6>
        @endcomponent
    @endslot
@endcomponent
