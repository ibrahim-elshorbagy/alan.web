<div class="modal fade common-modal-card" id="addNfcModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog " style="max-width: none !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">{{ __('messages.nfc.new_nfc_card') }}</h3>
        <button type="button" class="modal-close p-0 border-0 bg-transparent" data-bs-dismiss="modal"
          aria-label="Close">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
              <g id="Menu / Close_MD">
                <path id="Vector" d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke="#000000" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"></path>
              </g>
            </g>
          </svg>
        </button>
      </div>
      {{ Form::open(['id' => 'addNfcForm', 'files' => 'true']) }}
      <div class="modal-body pt-0">
        <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none" role="alert"
          id="NfcValidationErrorsBox">
          <i class="fa-solid fa-face-frown me-5"></i>
        </div>
        <div class="mb-3">
          {{ Form::label('name', __('messages.common.name') . ':', ['class' => 'form-label required']) }}
          {{ Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('messages.common.name'), 'id' => 'Name', 'autofocus']) }}
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            {{ Form::label('price', __('messages.common.price') . ':', ['class' => 'form-label required']) }}
            {{ Form::number('price', null, ['class' => 'form-control', 'required', 'step' => '0.01', 'min' => '0', 'placeholder' => __('messages.form.price')]) }}
          </div>
          <div class="col-md-6 mb-3">
            {{ Form::label('sales_price', __('messages.common.sales_price') . ':', ['class' => 'form-label']) }}
            {{ Form::number('sales_price', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0', 'placeholder' => __('messages.common.sales_price')]) }}
          </div>
        </div>

        <div>
          <div class="col-sm-12 mb-2">
            {{ Form::label('description', __('messages.common.description') . ':', ['class' => 'form-label required']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('messages.form.short_description'), 'rows' => '5', 'required']) }}
          </div>
        </div>

        <div class="mb-3">
          <div class="form-check">
            {{ Form::checkbox('apply_coordinates', 1, false, ['class' => 'form-check-input', 'id' => 'applyCoordinates']) }}
            {{ Form::label('applyCoordinates', __('messages.redirect_links.apply_coordinates'), ['class' => 'form-check-label']) }}
            <span data-bs-toggle="tooltip" data-placement="top"
              data-bs-original-title="{{ __('messages.redirect_links.qr_position_hint') }}">
              <i class="fas fa-question-circle ml-1 general-question-mark"></i>
            </span>
          </div>
        </div>

        <div id="coordinatesFields" style="display: none;">
          <div class="row mb-3">
            <div class="col-md-3">
              {{ Form::label('qr_x_position', __('messages.redirect_links.qr_x_position') . ':', ['class' => 'form-label']) }}
              {{ Form::number('qr_x_position', null, ['class' => 'form-control qr-position-input', 'placeholder' => 'X', 'id' => 'qrXPosition']) }}
            </div>
            <div class="col-md-3">
              {{ Form::label('qr_y_position', __('messages.redirect_links.qr_y_position') . ':', ['class' => 'form-label']) }}
              {{ Form::number('qr_y_position', null, ['class' => 'form-control qr-position-input', 'placeholder' => 'Y', 'id' => 'qrYPosition']) }}
            </div>
            <div class="col-md-3">
              {{ Form::label('qr_size', __('messages.redirect_links.qr_size') . ':', ['class' => 'form-label']) }}
              {{ Form::number('qr_size', 100, ['class' => 'form-control qr-position-input', 'placeholder' => '100', 'id' => 'qrSize']) }}
            </div>
            <div class="col-md-3">
              {{ Form::label('qr_position_side', __('messages.redirect_links.qr_position_side') . ':', ['class' => 'form-label']) }}
              {{ Form::select('qr_position_side', ['front' => __('messages.redirect_links.qr_front'), 'back' => __('messages.redirect_links.qr_back')], 'front', ['class' => 'form-select qr-position-input', 'id' => 'qrPositionSide']) }}
            </div>
          </div>

          <div class="row" id="dimensionFields">
            <div class="row size-fields">
              <div class="col-md-6 mb-3">
                {{ Form::label('image_width', 'Image Width (mm):', ['class' => 'form-label']) }}
                {{ Form::number('image_width', null, ['class' => 'form-control', 'placeholder' => 'Width in mm', 'id' => 'imageWidth', 'step' => '0.01']) }}
              </div>
              <div class="col-md-6 mb-3">
                {{ Form::label('image_height', 'Image Height (mm):', ['class' => 'form-label']) }}
                {{ Form::number('image_height', null, ['class' => 'form-control', 'placeholder' => 'Height in mm', 'id' => 'imageHeight', 'step' => '0.01']) }}
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 mb-3">
                {{ Form::label('text_font_size', 'Text Font Size:', ['class' => 'form-label']) }}
                {{ Form::number('text_font_size', 14, ['class' => 'form-control', 'id' => 'textFontSize', 'min' => '8', 'max' => '72']) }}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <label class="form-label">Live Preview:</label>
              <div class="qr-preview-container"
                style="border: 2px solid #ddd; border-radius: 8px; padding: 10px; background: #f8f9fa; position: relative; overflow: auto;max-height: 600px; ">
                <canvas id="qrPreviewCanvas" style="max-width: 100%; display: block; margin: 0 auto;"></canvas>
                <div id="qrPreviewPlaceholder" style="text-align: center; padding: 50px; color: #999;">
                  <i class="fas fa-image fa-3x mb-3"></i>
                  <p>Upload an image to see QR position preview</p>
                </div>
              </div>
            </div>
          </div>
        </div>




        <div class="mb-3">
          <h5 class="mb-3">Print Settings</h5>

          <div class="row mb-3">
            <div class="col-md-12">
              {{ Form::label('print_format', 'Print Format:', ['class' => 'form-label']) }}
              {{ Form::select('print_format', ['fixed' => 'Fixed Width/Height', 'a5' => 'A5 Format'], 'fixed', ['class' => 'form-select', 'id' => 'printFormat']) }}
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="form-check">
                {{ Form::hidden('print_front_image', 0) }}
                {{ Form::checkbox('print_front_image', 1, true, ['class' => 'form-check-input', 'id' => 'printFrontImage']) }}
                {{ Form::label('printFrontImage', 'Print Front Image', ['class' => 'form-check-label']) }}
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-check">
                {{ Form::hidden('print_back_image', 0) }}
                {{ Form::checkbox('print_back_image', 1, true, ['class' => 'form-check-input', 'id' => 'printBackImage']) }}
                {{ Form::label('printBackImage', 'Print Back Image', ['class' => 'form-check-label']) }}
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-check">
                {{ Form::hidden('print_only_qr', 0) }}
                {{ Form::checkbox('print_only_qr', 1, false, ['class' => 'form-check-input', 'id' => 'printOnlyQr']) }}
                {{ Form::label('printOnlyQr', 'Print Only QR Code', ['class' => 'form-check-label']) }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-12 mt-4 d-flex">
          <div class="mb-3" io-image-input="true">
            <label for="nfcImgId" class="form-label required">{{ __('messages.nfc.nfc_image') . ' : ' }}</label>
            <span data-bs-toggle="tooltip" data-placement="top"
              data-bs-original-title="{{ __('messages.tooltip.nfc_img') }}">
              <i class="fas fa-question-circle ml-1 general-question-mark"></i>
            </span>
            <div class="d-block">
              <div class="image-picker">
                <div class="image previewImage" id="nfcPreview"
                  style="background-image: url('{{ asset('assets/img/nfc/card_default.png') }}')"></div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                  data-placement="top" data-bs-original-title="{{ __('messages.tooltip.image') }}">
                  <label>
                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                    <input type="file" id="nfc_img" name="nfc_img" class="image-upload file-validation d-none"
                      accept="image/*" /> </label>
                </span>
              </div>
              <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
            </div>
            <input type="hidden" id="defaultNfcImgUrl" value="{{ asset('assets/img/nfc/card_default.png') }}" />
          </div>
          <div class="mb-3" io-image-input="true">
            <label for="nfcImgId" class="form-label required">{{ __('messages.nfc.nfc_back_image') . ' : ' }}</label>
            <span data-bs-toggle="tooltip" data-placement="top"
              data-bs-original-title="{{ __('messages.tooltip.nfc_img') }}">
              <i class="fas fa-question-circle ml-1 general-question-mark"></i>
            </span>
            <div class="d-block">
              <div class="image-picker">
                <div class="image previewImage" id="nfcPreview"
                  style="background-image: url('{{ asset('assets/img/nfc/card_default.png') }}')"></div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                  data-placement="top" data-bs-original-title="{{ __('messages.tooltip.change_back_image') }}">
                  <label>
                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                    <input type="file" id="nfc_back_img" name="nfc_back_img"
                      class="image-upload file-validation d-none" accept="image/*" /> </label>
                </span>
              </div>
              <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
            </div>
            <input type="hidden" id="defaultNfcImgUrl" value="{{ asset('assets/img/nfc/card_default.png') }}" />
          </div>
        </div>

      </div>
      <div class="modal-footer pt-0 justify-content-start">
        {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary m-0', 'id' => 'btnSave']) }}
        <button type="button" class="btn discard-btn my-0 ms-3 me-0"
          data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
