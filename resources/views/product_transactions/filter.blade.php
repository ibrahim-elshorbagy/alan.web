<div class="d-flex align-items-center gap-2 ms-auto">
    <div class="dropdown d-flex align-items-center me-4 me-md-5" wire:ignore>
        <button
            class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0"
            type="button" id="dropdownMenuProduct" data-bs-auto-close="outside"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class='fas fa-filter'></i>
        </button>
        <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuProduct">
            <div class="text-start border-bottom py-4 px-7">
                <h3 class="text-gray-900 mb-0">{{__('messages.common.filter')}}</h3>
            </div>
            @php
            $productType = \App\Models\Product::PAYMENT_METHOD;
            $statusTypes = \App\Models\Product::STATUS_ARR;

            $filteredPaymentTypes = array_filter($productType, function($key) {
            if ($key === \App\Models\Product::SELECT_PAYMENT_GATEWAY) {
                return false;
            }

            if ($key === \App\Models\Product::MERCADOPAGO && !moduleExists('MercadoPago')) {
                return false;
            }
            return true;
            }, ARRAY_FILTER_USE_KEY);

            $combinedOptions = ['' => __('messages.payment_type')];

            foreach(getTranslatedData($statusTypes) as $key => $value) {
                $combinedOptions['status_' . $key] = $value;
            }

            foreach(getTranslatedData($filteredPaymentTypes) as $key => $value) {
                if($key != '') {
                    $combinedOptions[$key] = $value;
                }
            }
            @endphp
            <div class="p-5">
                <div class="mb-5">
                    <label for="exampleInputSelect2" class="form-label">{{__('messages.payment_type')}}</label>
                    {{ Form::select('type', $combinedOptions, null,['class' => 'form-control form-select','data-control'=>"select2" ,'id' => 'productPaymentType', 'wire:ignore']) }}
                </div>
                <div class="d-flex justify-content-end">
                    <button type="reset" id="productOrderResetFilter" class="btn btn-secondary">{{__('messages.common.reset')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
