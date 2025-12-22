<div class="modal fade" id="showProductModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.vcard.product_details') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{__('messages.common.name').':'}}
                        </label>
                        <p id="showName" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div id="settings" data-value="{{ getSuperAdminSettingValue('hide_decimal_values') }}">
                    <div class="col-sm-12 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{__('messages.common.price').':'}}
                        </label>
                        <p id="showPrice" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-12 mb-5">
                        <label class="form-label fs-6 text-gray-700">
                            {{__('messages.common.description').':'}}
                        </label>
                        <p id="showDesc" class="text-gray-600 fw-bold mb-0"></p>
                    </div>
                    <div class="col-sm-12 mb-5">
                        <div class="mb-3" io-image-input="true">
                            <label class="form-label fs-6 text-gray-700 mb-3">
                                {{__('messages.vcard.product_icon').':'}}
                            </label>
                            <div class="d-flex gap-3 align-items-start flex-wrap" id="productImagesContainer">
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
