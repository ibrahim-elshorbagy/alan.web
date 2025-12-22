<div class="modal fade" id="showProductCategoryModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.whatsapp_stores.category_details') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.common.name') . ':' }}
                        </label>
                        <p id="wpStoreCategoryName" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.whatsapp_stores.product_count') . ':' }}
                        </label>
                        <p id="wpStoreCategoryProductCount" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-12 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{ __('messages.vcard.image') }}:
                        </label>
                        <div id="showProductCategoryImage" class="d-flex flex-wrap"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
