<div>
    <div class="dropdown d-flex align-items-center me-4 me-md-5" wire:ignore>
        <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button"
            id="dropdownMenuProductOrderStatus" data-bs-auto-close="outside" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class='fas fa-filter'></i>
        </button>
        <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuProductOrderStatus">
            <div class="text-start border-bottom py-4 px-7">
                <h3 class="text-gray-900 mb-0">{{ __('messages.common.filter') }}</h3>
            </div>
            <div class="p-5">
                @php
                    $status = [
                        '' => 'Select Status',
                        \App\Models\WpOrder::PENDING => 'Pending',
                        \App\Models\WpOrder::DISPATCHED => 'Dispatched',
                        \App\Models\WpOrder::DELIVERED => 'Delivered',
                        \App\Models\WpOrder::CANCELLED => 'Cancelled',
                    ];
                @endphp
                <div class="mb-5">
                    <label for="exampleInputSelect2" class="form-label">{{ __('messages.common.status') }}</label>
                    {{ Form::select('type', getTranslatedData($status), null, ['class' => 'form-control form-select', 'data-control' => 'select2', 'id' => 'productOrderStatus', 'wire:ignore']) }}
                </div>
                <div class="d-flex justify-content-end">
                    <button type="reset" id="productOrderResetFilter" class="btn btn-secondary">
                        {{ __('messages.common.reset') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

