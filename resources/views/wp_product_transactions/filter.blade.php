<div>
    <div class="dropdown d-flex align-items-center" wire:ignore>
        <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow " type="button"
            id="dropdownMenuWpProductOrderFilter" data-bs-auto-close="outside" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class='fas fa-filter'></i>
        </button>
        <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuWpProductOrderFilter">
            <div class="text-start border-bottom py-4 px-7">
                <h3 class="text-gray-900 mb-0">{{ __('messages.common.filter') }}</h3>
            </div>
            <div class="p-5">
                @php
                    $stores = \App\Models\WhatsappStore::where('tenant_id', getLogInTenantId())
                        ->pluck('store_name', 'id')
                        ->toArray();
                @endphp
                <div class="mb-5">
                    <label for="exampleInputSelect2" class="form-label">{{ __('messages.whatsapp_stores.store_name') }}</label>
                    {{ Form::select('store', $stores, null, [
                        'class' => 'form-control form-select',
                        'data-control' => 'select2',
                        'placeholder' => __('messages.whatsapp_stores.select_store_name'),
                        'id' => 'wpProductOrderFilter',
                        'wire:ignore',
                    ]) }}
                </div>
                <div class="d-flex justify-content-end">
                    <button type="reset" id="wpProductOrderResetFilter" class="btn btn-secondary">
                        {{ __('messages.common.reset') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
