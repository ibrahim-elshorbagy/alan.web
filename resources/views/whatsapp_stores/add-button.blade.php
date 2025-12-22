
@if (checkTotalWhatsappStore())
    <a href="{{ route('whatsapp.stores', ['part' => 'basics']) }}" class="btn btn-primary ms-auto">
        {{ __('messages.whatsapp_stores.new') }}
    </a>
@endif
