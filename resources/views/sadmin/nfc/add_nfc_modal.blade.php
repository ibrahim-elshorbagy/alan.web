<div class="modal fade common-modal-card" id="addNfcModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.nfc.new_nfc_card') }}</h3>
                <button type="button" class="modal-close p-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Menu / Close_MD"> <path id="Vector" d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                </button>
            </div>
            {{ Form::open(['id'=>'addNfcForm', 'files' => 'true']) }}
            <div class="modal-body pt-0">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none" role="alert" id="NfcValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-3">
                    {{ Form::label('name',__('messages.common.name').':', ['class' => 'form-label required']) }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'required','placeholder' => __('messages.common.name'),'id' => 'Name','autofocus']) }}
                </div>
                <div class="mb-3">
                        {{ Form::label('price', __('messages.common.price').':', ['class' => 'form-label required']) }}
                        {{ Form::number('price', null, ['class' => 'form-control','required','step'=>'0.01', 'min'=>'0', 'placeholder' => __('messages.form.price')]) }}
                </div>

            <div>
                <div class="col-sm-12 mb-2">
                    {{ Form::label('description', __('messages.common.description').':', ['class' => 'form-label required']) }}
                    {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('messages.form.short_description'), 'rows' => '5', 'required']) }}
                </div>
            </div>
                <div class="col-sm-12 mt-4 d-flex">
                    <div class="mb-3" io-image-input="true">
                        <label for="nfcImgId"
                               class="form-label required">{{ __('messages.nfc.nfc_image'). " : " }}</label>
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.tooltip.nfc_img') }}">
                            <i class="fas fa-question-circle ml-1 general-question-mark"></i>
                        </span>
                        <div class="d-block">
                            <div class="image-picker">
                                <div class="image previewImage" id="nfcPreview"
                                     style="background-image: url('{{ asset('assets/img/nfc/card_default.png') }}')"></div>
                                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                      data-placement="top" data-bs-original-title="{{__('messages.tooltip.image')}}">
                                    <label>
                                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                        <input type="file" id="nfc_img" name="nfc_img"
                                               class="image-upload file-validation  d-none crop-image-input" accept="image/*" data-crop-width="525" data-crop-height="420" data-preview-id="createNfcCardFrontImagePreview"/> </label>
                                </span>
                            </div>
                            <div class="form-text">{{__('messages.allowed_file_types')}}</div>
                        </div>
                        <input type="hidden" id="defaultNfcImgUrl" value="{{ asset('assets/img/nfc/card_default.png') }}" />
                    </div>
                    <div class="mb-3" io-image-input="true">
                        <label for="nfcImgId"
                               class="form-label required">{{ __('messages.nfc.nfc_back_image'). " : " }}</label>
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.tooltip.nfc_img') }}">
                            <i class="fas fa-question-circle ml-1 general-question-mark"></i>
                        </span>
                        <div class="d-block">
                            <div class="image-picker">
                                <div class="image previewImage" id="nfcPreview"
                                     style="background-image: url('{{ asset('assets/img/nfc/card_default.png') }}')"></div>
                                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                      data-placement="top" data-bs-original-title="{{__('messages.tooltip.change_back_image')}}">
                                    <label>
                                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                        <input type="file" id="nfc_back_img" name="nfc_back_img"
                                               class="image-upload file-validation  d-none crop-image-input" accept="image/*" data-crop-width="525" data-crop-height="420" data-preview-id="createNfcCardBackImagePreview"/> </label>
                                </span>
                            </div>
                            <div class="form-text">{{__('messages.allowed_file_types')}}</div>
                        </div>
                        <input type="hidden" id="defaultNfcImgUrl" value="{{ asset('assets/img/nfc/card_default.png') }}" />
                    </div>
                </div>

            </div>
            <div class="modal-footer pt-0 justify-content-start">
                {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary m-0','id'=>'btnSave']) }}
                <button type="button" class="btn discard-btn my-0 ms-3 me-0"
                        data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
