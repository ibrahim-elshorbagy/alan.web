<div class="row">
    <div class="mb-3" io-image-input="true">
        <label for="aboutInputImage" class="form-label">{{__('messages.vcards_template.image')}}:
            <span data-bs-toggle="tooltip"
                data-placement="top"
                data-bs-original-title="{{__('messages.tooltip.home_image')}} 620x500">
                <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
            </span>
        </label>
        <div class="d-block">
            <div class="image-picker">
                <div class="image previewImage" id="aboutInputImage"
                    style="background-image: url('{{ !empty($whatdriveUs->what_drive_us_url) ? $whatdriveUs->what_drive_us_url :  asset('front/images/about-1.png') }}')">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                    data-placement="top" data-bs-original-title="{{__('messages.tooltip.image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        <input type="file" name="image[{{ $whatdriveUs->id }}]" class="image-upload file-validation d-none crop-image-input" accept=".png, .jpg, .jpeg" data-preview-id="whatDrivesUsImagePreview"/>
                    </label>
                </span>
            </div>
        </div>
    </div>
    <div class="form-text">{{__('messages.allowed_file_types')}}</div>
    <div class="col-lg-12">
        <div class="mb-5 mt-4">
            {{ Form::label('title', __('messages.about_us.title').':', ['class' => 'form-label required']) }}
            {{ Form::text('title['.$whatdriveUs->id.']', $whatdriveUs->title, ['class' => 'form-control', 'placeholder' => __('messages.about_us.title'), 'required', 'maxlength'=>'100']) }}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-5">
            {{ Form::label('description', __('messages.about_us.description').':', ['class' => 'form-label required']) }}
            {!! Form::textarea('description['.$whatdriveUs->id.']', $whatdriveUs->description, ['class' => 'form-control', 'placeholder' => __('messages.about_us.description'), 'required']) !!}
        </div>
    </div>
</div>
