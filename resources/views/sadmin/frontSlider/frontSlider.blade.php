<div class="row mb-5">
    <div class="mb-2" io-image-input="true">
        <label for="frontSliderImg" class="form-label">{{ __('messages.front_slider_image') }}:
            <span data-bs-toggle="tooltip" data-placement="top"
                data-bs-original-title="{{ __('messages.tooltip.front_slider_img') }}">
                <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
            </span>
        </label>
        <div class="d-block">
            <div class="image-picker">
                <div class="image previewImage" id="frontSliderImg"
                    style="background-image: url('{{ !empty($about->front_slider_img_url) ? $about->front_slider_img_url : asset('front/images/front_slider_1.png') }}')">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                    data-placement="top" data-bs-original-title="{{ __('messages.tooltip.change_front_slider_image') }}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        <input type="file" name="image[{{ $about->id }}]"
                            class="image-upload file-validation d-none crop-image-input" accept=".png, .jpg, .jpeg" data-crop-width="448" data-crop-height="674" data-preview-id="frontSliderImagePreview"/>
                    </label>
                </span>
            </div>
        </div>
    </div>
    <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
</div>
