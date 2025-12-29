<div class="modal fade" id="editServiceModal" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">{{ __('messages.vcard.edit_service') }}</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {!! Form::open(['id' => 'editServiceForm', 'files' => 'true']) !!}
        <div class="row">
          <div class="col-sm-12 mb-5">
            {{ Form::hidden('service_id', null, ['id' => 'serviceId']) }}
            {{ Form::hidden('vcard_id', $vcard->id, ['id' => 'vcardId']) }}
            {{ Form::label('name', __('messages.common.name') . ':', ['class' => 'form-label required fs-6  text-gray-700 mb-3']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'editName', 'required', 'placeholder' => __('messages.form.service')]) }}
          </div>
          <div class="mb-5">
            {{ Form::label('service_url', __('messages.common.service_url') . ':', ['class' => 'form-label']) }}
            {{ Form::text('service_url', null, ['class' => 'form-control', 'id' => 'editServiceURL', 'placeholder' => __('messages.common.service_url')]) }}
          </div>
          <div class="col-sm-12 mb-5">
            {{ Form::label('description', __('messages.common.description') . ':', ['class' => 'form-label required fs-6 text-gray-700 mb-3']) }}
            <div class="d-flex align-items-center mb-2">
              <a href="javascript:void(0)" id="generateAiServiceDescriptionBtn"
                class="text-primary text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 me-3">
                <i class="bi bi-stars"></i>
                {{ __('messages.vcard.generate_description_with_ai') }}
              </a>
            </div>
            {{ Form::textarea('description', null, ['class' => 'form-control', 'id' => 'editDescription', 'placeholder' => __('messages.form.short_description'), 'rows' => '5', 'required']) }}
          </div>
          <div class="col-sm-12 mb-5">

            <div class="mb-3" io-image-input="true">
              <label for="editServicePreview"
                class="form-label required">{{ __('messages.vcard.service_icon') . ':' }}</label>
              <span data-bs-toggle="tooltip" data-placement="top"
                data-bs-original-title="{{ __('messages.tooltip.vcard_defaut_img') }}">
                <i class="fas fa-question-circle ml-1 general-question-mark"></i>
              </span>
              <div class="d-block">
                <div class="image-picker">
                  <div class="image previewImage" id="editServicePreview"
                    style="background-image: url({{ asset('assets/images/default_service.png') }})"></div>
                  <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                    data-placement="top" data-bs-original-title="{{ __('messages.tooltip.change_service_icon') }}">
                    <label>
                      <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                      <input type="file" id="editServiceIcon" name="service_icon"
                        class="image-upload file-validation d-none" accept="image/*"
                        data-preview-id="editServicePreview" />
                    </label>
                  </span>
                </div>
                <!-- Image Paste Component -->
                <div data-image-paste data-file-input-id="editServiceIcon" data-preview-id="editServicePreview"
                  data-button-text="{{ __('messages.select_image') }}"
                  data-clipboard-button-text="{{ __('messages.paste_from_clipboard') }}"
                  data-success-text="{{ __('messages.image_pasted_successfully') }}"
                  data-invalid-type-text="{{ __('messages.invalid_image_type') }}"
                  data-image-too-large-text="{{ __('messages.image_too_large') }}"
                  data-no-image-text="{{ __('messages.no_image_in_clipboard') }}">
                </div>
                <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
              </div>
            </div>
          </div>
          <div class="d-flex">
            {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary me-3', 'id' => 'serviceUpdate']) }}
            <button type="button" class="btn btn-secondary"
              data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
