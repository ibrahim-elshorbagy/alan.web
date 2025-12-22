<div class="overflow-auto">
    <div class="table-striped w-100">
            <livewire:whatsapp-store-product-table :whatsapp-store-id="$whatsappStore->id" lazy>
    </div>
    @include('whatsapp_stores.products.create_product')
    @include('whatsapp_stores.products.edit_product')
    @include('whatsapp_stores.products.show_product')
</div>