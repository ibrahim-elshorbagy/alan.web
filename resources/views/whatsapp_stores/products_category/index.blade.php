<div class="overflow-auto">
    <div class="table-striped w-100">
            <livewire:product-categories-table :whatsapp-store-id="$whatsappStore->id" lazy>
    </div>
    @include('whatsapp_stores.products_category.add_product_category')
    @include('whatsapp_stores.products_category.edit_product_category')
    @include('whatsapp_stores.products_category.show_product_category')
</div>