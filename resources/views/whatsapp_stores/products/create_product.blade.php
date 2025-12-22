<div class="modal fade" id="addWpStoreProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.vcard.new_product') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="whatsappStoreProductForm">
                    <input type="hidden" value="{{ $whatsappStore->id }}" name="whatsapp_store_id">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.common.name') . ':' }}</label>
                                <input type="text"  class="form-control" name="name"
                                    placeholder="{{ __('messages.form.product') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('messages.whatsapp_stores.net_price') . ':' }}</label>
                                <input type="number" step="0.01" class="form-control" name="net_price"
                                    placeholder="{{ __('messages.whatsapp_stores.enter_net_price') }}">
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.whatsapp_stores.selling_price') . ':' }}</label>
                                <input type="number" step="0.01" class="form-control" name="selling_price"
                                    placeholder="{{ __('messages.whatsapp_stores.enter_selling_price') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-6">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.whatsapp_stores.category') . ':' }}</label>
                                <select name="category_id" class="form-control wpStoreCategory" required
                                    data-control="select2" data-dropdown-parent="#addWpStoreProductModal">
                                    <option value="0">{{ __('messages.whatsapp_stores.select_category') }}</option>
                                    @foreach ($productsCategories as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-5">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.setting.currency') . ':' }}</label>
                                <select name="currency_id" class="form-control wpStoreCurrency" required
                                    data-control="select2" data-dropdown-parent="#addWpStoreProductModal">
                                    <option value="0">{{ __('messages.setting.select_currency') }}</option>
                                    @foreach (getCurrencies() as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-5">
                            <div class="form-group">
                                <label class="form-label required">{{ __('messages.whatsapp_stores.total_stock') . ':' }}</label>
                                <input type="number" class="form-control product-total-stock" name="total_stock"
                                    placeholder="{{ __('messages.whatsapp_stores.enter_total_stock') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-5">
                            <div class="form-group">
                                <label class="form-label">{{ __('messages.whatsapp_stores.available_stock') . ':' }}</label>
                                <input type="number" class="form-control product-avilable-stock" name="available_stock"
                                    placeholder="{{ __('messages.whatsapp_stores.enter_available_stock') }}">
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <div class="form-group">
                                <label for="description" class="form-label required">
                                    {{ __('messages.vcard.description') }}:
                                </label>
                                <div id="wpStoreProductDescriptionQuill" class="editor-height" style="height: 150px"></div>
                                <input type="hidden" name="description" id="wpStoreProductDescriptionData">
                            </div>
                        </div>
                        <div class="mt-5 col-lg-12">
                            <div class="mb-3" io-image-input="true">
                                <input type="hidden" id="wpProductDefaultImage" value="{{ asset('images/wp-product.png') }}">
                                <label for="productPreview"
                                    class="form-label required">{{ __('messages.whatsapp_stores.product_images') . ':' }}</label>
                                <span data-bs-toggle="tooltip" data-placement="top"
                                    data-bs-original-title="{{ __('messages.tooltip.wp_product_img') }}">
                                    <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                                </span>
                                <div class="d-flex align-items-start flex-wrap gap-4 mt-2" id="imageContainer">
                                    <div class="d-block image-picker-wrapper">
                                        <div class="image-picker">

                                            <div class="image previewImage" id="wpStoreProductPreview">
                                            </div>

                                            <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                data-bs-toggle="tooltip" data-placement="top"
                                                data-bs-original-title="{{ __('messages.tooltip.change_product_image') }}">
                                                <label>
                                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                    <input type="file"  name="images[]"
                                                        class="image-upload file-validation d-none crop-image-input" data-crop-width="280" data-crop-height="230" accept="image/*" data-preview-id="createWpStoreProductPreview"
                                                        multiple />
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="wpStoreProductSave" class="btn btn-primary m-0">{{ __('crud.save') }}
                </button>
                </form>
                <button class="btn btn-secondary my-0 ms-5 me-0"
                    data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
            </div>
        </div>
    </div>
</div>
