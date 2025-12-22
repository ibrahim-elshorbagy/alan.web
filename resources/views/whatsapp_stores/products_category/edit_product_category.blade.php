<div class="modal fade" id="editProductCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.whatsapp_stores.edit_product_category') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductCategoryForm">
                    <input type="hidden" value="{{ $whatsappStore->id }}" name="whatsappStoreId">
                    <input type="hidden" name="productCategoryId" id="editProductCategoryId">
                    <div class="form-group">
                        <label class="form-label required">{{ __('messages.common.name') . ':' }}</label>
                        <input type="text" class="form-control" name="name"
                            placeholder="{{ __('messages.whatsapp_stores.category_placeholder') }}" id="editProductCategoryName" required>
                    </div>
                    <div class="mb-3 mt-5" io-image-input="true">
                        <label for="editProductCategoryPreview" class="form-label required">{{ __('messages.vcard.image') . ':' }}</label>
                    <span data-bs-toggle="tooltip" data-placement="top"
                        data-bs-original-title="{{ __('messages.tooltip.app_logo') }}">
                        <i class="fas fa-question-circle ml-1 general-question-mark"></i>
                    </span>
                        <div class="d-block">
                            <div class="image-picker">
                                <div class="image previewImage" id="editProductCategoryPreview">
                                </div>
                                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                    data-placement="top" data-bs-original-title="{{ __('messages.tooltip.image') }}">
                                    <label>
                                        <i class="fa-solid fa-pen"></i>
                                        <input type="file" id="image" name="image"
                                            class="image-upload file-validation d-none crop-image-input" data-crop-width="100" data-crop-height="100" data-preview-id="editProductCategoryPreview" accept="image/*" />
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="editProductCategorySave" class="btn btn-primary m-0">{{ __('crud.save') }}
                </button>
                </form>
                <button class="btn btn-secondary my-0 ms-5 me-0"
                    data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
            </div>
        </div>
    </div>
</div>
