<div class="modal fade" id="addProductCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">{{ __('messages.whatsapp_stores.new_product_category') }}</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="whatsappStoreProductCategoryForm">
          <input type="hidden" value="{{ $whatsappStore->id }}" name="whatsappStoreId">
          <div class="form-group">
            <label class="form-label required">{{ __('messages.common.name') . ':' }}</label>
            <input type="text" class="form-control" name="name"
              placeholder="{{ __('messages.whatsapp_stores.category_placeholder') }}" required>
          </div>
          <div class="mb-3 mt-5" io-image-input="true">
            <label for="productCategoryPreview"
              class="form-label required">{{ __('messages.vcard.image') . ':' }}</label>
            <span data-bs-toggle="tooltip" data-placement="top"
              data-bs-original-title="{{ __('messages.tooltip.app_logo') }}">
              <i class="fas fa-question-circle ml-1 general-question-mark"></i>
            </span>
            <div class="d-block">
              <div class="image-picker">
                <input type="hidden" id="categoryDefaultImage" value="{{ asset('images/category.png') }}">
                <div class="image previewImage" id="productCategoryPreview"
                  style="background-image: url({{ asset('images/category.png') }})">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                  data-placement="top" data-bs-original-title="{{ __('messages.tooltip.image') }}">
                  <label>
                    <i class="fa-solid fa-pen"></i>
                    <input type="file" id="image" name="image" class="image-upload d-none" accept="image/*" />
                  </label>
                </span>
              </div>
              <div data-image-paste data-input-id="image" data-preview-id="productCategoryPreview"
                data-select-text="{{ __('messages.select_image') }}"
                data-clipboard-text="{{ __('messages.paste_from_clipboard') }}"
                data-no-image-text="{{ __('messages.no_image_in_clipboard') }}"
                data-success-text="{{ __('messages.image_pasted_successfully') }}"
                data-invalid-text="{{ __('messages.invalid_image_type') }}"
                data-too-large-text="{{ __('messages.image_too_large') }}"
                data-default-image="{{ asset('images/category.png') }}">
              </div>
            </div>
          </div>
          <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="productCategorySave" class="btn btn-primary m-0">{{ __('crud.save') }}
        </button>
        </form>
        <button class="btn btn-secondary my-0 ms-5 me-0"
          data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
      </div>
    </div>
  </div>
</div>
