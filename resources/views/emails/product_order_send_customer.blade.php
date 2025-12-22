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
        <h2>{{ __('messages.mail.hello') }} {{ $data['customer_name'] ?? '' }}</h2>
        <p>{{ __('messages.mail.your_product_order_confirmed') }}</p>
        <p><b>{{ __('messages.vcard.product_name') }} : </b> {{ $data['product_name'] ?? '' }}</p>
        <p><b>{{ __('messages.mail.product_price') }} : </b> {{ $data['product_price'] ?? '' }}</p>
        <p><b>{{ __('messages.setting.address') }} : </b> {{ $data['address'] ?? '' }}</p>
        <p><b>{{ __('messages.payment_type') }} : </b> {{ $data['payment_type'] ?? '' }}</p>
        <p><b>{{ __('messages.mail.ordered_confirm_date') }} : </b> {{ $data['order_date'] ?? '' }}</p>
        <p>{{ __('messages.mail.thanks_regard') }}<br>{{ getAppName() }}</p>
    @endif
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getAppName() }}.</h6>
        @endcomponent
    @endslot
@endcomponent
