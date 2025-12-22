<div class="modal fade" id="wpStoreShowProductModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.whatsapp_stores.order_details') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.common.name') . ':' }}
                        </label>
                        <p id="wpStoreProductName" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.whatsapp_stores.category') . ':' }}
                        </label>
                        <p id="wpStoreProductCategory" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.whatsapp_stores.net_price') . ':' }}
                        </label>
                        <p id="wpStoreProductNetPrice" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.whatsapp_stores.selling_price') . ':' }}
                        </label>
                        <p id="wpStoreProductSellingPrice" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-12 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.common.description') . ':' }}
                        </label>
                        <p id="wpStoreProductDescription" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-12 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.whatsapp_stores.product_images') }}:
                        </label>
                        <div id="showProductImages" class="d-flex flex-wrap"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
