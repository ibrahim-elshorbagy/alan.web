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
        <p><b>We regret to inform you that your custom domain request has been rejected</b>.</p>
        <p><b>Domain Name : </b> {{ $domain_name }}</p>
        <p><b>Rejection Note : </b> {{ $rejection_note }}</p>
        <p>{{ getAppName() }}</p>
    </div>


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getAppName() }}.</h6>
        @endcomponent
    @endslot
@endcomponent
