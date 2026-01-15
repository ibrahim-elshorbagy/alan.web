<div class="modal fade common-modal-card" id="editNfcModal" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">{{ __('messages.nfc.edit_nfc_card') }}</h2>
        <button type="button" class="modal-close bg-transparent p-0 border-0" data-bs-dismiss="modal"
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
      <div class="modal-body pt-0">
        {!! Form::open(['id' => 'editNfcForm', 'files' => 'true']) !!}
        <div class="row">
          <div class="col-sm-12 mb-3">
            {{ Form::hidden('nfc_id', null, ['id' => 'nfcId']) }}
            {{ Form::label('name', __('messages.common.name') . ':', ['class' => 'form-label required']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'editNfcTitle', 'required', 'placeholder' => __('messages.form.enter_name'), 'maxlength' => '50']) }}
          </div>

          <div class="col-sm-12 mb-3">
            {{ Form::label('price', __('messages.common.price') . ':', ['class' => 'form-label required']) }}
            {{ Form::number('price', null, ['class' => 'form-control', 'id' => 'editNfcPrice', 'required', 'step' => '0.01', 'min' => '0', 'placeholder' => __('messages.form.price')]) }}
          </div>

          <div class="col-sm-12 mb-3">
            {{ Form::label('description', __('messages.common.description') . ':', ['class' => 'form-label required']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'id' => 'editNfcDescription', 'placeholder' => __('messages.form.short_description'), 'rows' => '5', 'required']) }}
          </div>

          <div class="col-sm-12 mb-3">
            <div class="form-check">
              {{ Form::checkbox('apply_coordinates', 1, null, ['class' => 'form-check-input', 'id' => 'editApplyCoordinates']) }}
              {{ Form::label('editApplyCoordinates', __('messages.redirect_links.apply_coordinates'), ['class' => 'form-check-label']) }}
              <span data-bs-toggle="tooltip" data-placement="top"
                data-bs-original-title="{{ __('messages.redirect_links.qr_position_hint') }}">
                <i class="fas fa-question-circle ml-1 general-question-mark"></i>
              </span>
            </div>
          </div>

          <div id="editCoordinatesFields" style="display: none;">
            <div class="row">
              <div class="col-md-6 mb-3">
                {{ Form::label('qr_x_position', __('messages.redirect_links.qr_x_position') . ':', ['class' => 'form-label']) }}
                {{ Form::number('qr_x_position', null, ['class' => 'form-control', 'placeholder' => 'X', 'id' => 'editQrXPosition']) }}
              </div>
              <div class="col-md-6 mb-3">
                {{ Form::label('qr_y_position', __('messages.redirect_links.qr_y_position') . ':', ['class' => 'form-label']) }}
                {{ Form::number('qr_y_position', null, ['class' => 'form-control', 'placeholder' => 'Y', 'id' => 'editQrYPosition']) }}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                {{ Form::label('qr_size', __('messages.redirect_links.qr_size') . ':', ['class' => 'form-label']) }}
                {{ Form::number('qr_size', null, ['class' => 'form-control', 'placeholder' => '100', 'id' => 'editQrSize']) }}
              </div>
              <div class="col-md-6 mb-3">
                {{ Form::label('qr_position_side', __('messages.redirect_links.qr_position_side') . ':', ['class' => 'form-label']) }}
                {{ Form::select('qr_position_side', ['front' => __('messages.redirect_links.qr_front'), 'back' => __('messages.redirect_links.qr_back')], null, ['class' => 'form-select', 'id' => 'editQrPositionSide']) }}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              {{ Form::label('image_width', 'Image Width (mm):', ['class' => 'form-label']) }}
              {{ Form::number('image_width', null, ['class' => 'form-control', 'placeholder' => 'Width in mm', 'id' => 'editImageWidth']) }}
            </div>
            <div class="col-md-6 mb-3">
              {{ Form::label('image_height', 'Image Height (mm):', ['class' => 'form-label']) }}
              {{ Form::number('image_height', null, ['class' => 'form-control', 'placeholder' => 'Height in mm', 'id' => 'editImageHeight']) }}
            </div>
          </div>

          <div class="col-sm-12 mb-3 d-flex">
            <div class="mb-3" io-image-input="true">
              <label for="NfcImgId" class="form-label required">{{ __('messages.nfc.nfc_image') . ' : ' }}
              </label>
              <span data-bs-toggle="tooltip" data-placement="top"
                data-bs-original-title="{{ __('messages.tooltip.nfc_img') }}">
                <i class="fas fa-question-circle ml-1 general-question-mark"></i>
              </span>
              <div class="d-block">
                <div class="image-picker">
                  <div class="image previewImage" id="editNfcPreview"
                    style="background-image: url('{{ asset('assets/img/nfc/card_default.png') }}')">
                  </div>
                  <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                    data-placement="top" data-bs-original-title="{{ __('messages.tooltip.image') }}">
                    <label>
                      <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                      <input type="file" id="editNfcImg" name="nfc_img" class="image-upload file-validation d-none"
                        accept="image/*" /> </label>
                  </span>
                </div>
                <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
              </div>
            </div>
            <div class="mb-3" io-image-input="true">
              <label for="NfcImgId" class="form-label required">{{ __('messages.nfc.nfc_back_image') . ' : ' }}
              </label>
              <span data-bs-toggle="tooltip" data-placement="top"
                data-bs-original-title="{{ __('messages.tooltip.nfc_img') }}">
                <i class="fas fa-question-circle ml-1 general-question-mark"></i>
              </span>
              <div class="d-block">
                <div class="image-picker">
                  <div class="image previewImage" id="editNfcBackPreview"
                    style="background-image: url('{{ asset('assets/img/nfc/card_default.png') }}')">
                  </div>
                  <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                    data-placement="top" data-bs-original-title="{{ __('messages.tooltip.change_back_image') }}">
                    <label>
                      <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                      <input type="file" id="editNfcBackImg" name="nfc_back_img"
                        class="image-upload file-validation d-none" accept="image/*" /> </label>
                  </span>
                </div>
                <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-start modal-footer p-0">
            {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary me-3', 'id' => 'serviceUpdate']) }}
            <button type="button" class="btn discard-btn cancel-edit-nfc"
              data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
