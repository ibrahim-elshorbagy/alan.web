<?php ?>
@if ($partName == 'basics' || $partName == 'basics2' || $partName == 'basics3')
  @if (isset($vcard) && isset($vcard->id))
    <ul class="nav nav-tabs nav-items-all-tabs-vcard flex-nowrap gap-3 gap-lg-0 overflow-auto mb-1">
      <li class="text-nowrap nav-item nav-item-tabs">
        <a class="nav-link position-relative p-0 {{ isset($partName) && $partName == 'basics' ? 'active' : '' }}"
          href="{{ route('vcards.edit', $vcard->id) . '?part=basics' }}"
          aria-selected="true">{{ __('messages.basic_details1') }}</a>
      </li>
      <li class="text-nowrap nav-item nav-item-tabs">
        <a class="nav-link position-relative p-0 {{ isset($partName) && $partName == 'basics2' ? 'active' : '' }}"
          href="{{ route('vcards.edit', $vcard->id) . '?part=basics2' }}"
          aria-selected="false">{{ __('messages.basic_details2') }}</a>
      </li>
      <li class="text-nowrap nav-item nav-item-tabs">
        <a class="nav-link position-relative p-0 {{ isset($partName) && $partName == 'basics3' ? 'active' : '' }}"
          href="{{ route('vcards.edit', $vcard->id) . '?part=basics3' }}"
          aria-selected="false">{{ __('messages.basic_details3') }}</a>
      </li>
    </ul>
  @endif
@endif

@if ($partName == 'basics')
  @if (isset($vcard))
    <input type="hidden" id="vcardId" value="{{ $vcard->id }}">
  @endif
  <input type="hidden" name="part" value="{{ $partName }}">
  <div class="container-fluid mt-5">
    <div class="row" id="basic">
      {{ Form::hidden('default_language', app()->getLocale()) }}
      <div class="col-lg-12 mb-7">
        {{ Form::label('url_alias', __('messages.vcard.url_alias') . ':', ['class' => 'form-label required']) }}
        <span data-bs-toggle="tooltip" data-placement="top"
          data-bs-original-title="{{ __('messages.tooltip.the_main_url') }}">
          <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
        </span>
        <div class="d-sm-flex">
          <div class="input-group">
            {{ Form::text('url_alias', isset($vcard) ? $vcard->url_alias : null, [
                'class' => 'form-control ms-1 vcard-url-alias',
                'id' => 'vcard-url-alias',
                'placeholder' => __('messages.form.my_vcard_url'),
                'readonly' => isset($vcard) && getSuperAdminSettingValue('url_alias') != 1 ? true : null,
            ]) }}
            <button class="btn btn-secondary" type="button" id="generate-url-alias"
              {{ isset($vcard) && getSuperAdminSettingValue('url_alias') != 1 ? 'disabled' : null }}>
              <i class="fa-solid fa-arrows-rotate"></i>
            </button>
          </div>
        </div>
        <div id="error-url-alias-msg" class="text-danger ms-2 fs-6 d-none fw-light">
          {{ __('messages.vcard.already_alias_url') }}
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        {{ Form::label('name', __('messages.vcard.vcard_name') . ':', ['class' => 'form-label required']) }}
        {{ Form::text('name', isset($vcard) ? $vcard->name : null, ['class' => 'form-control vcard-name', 'placeholder' => __('messages.form.vcard_name'), 'required']) }}
      </div>
      <div class="col-lg-6 mb-7">
        {{ Form::label('occupation', __('messages.vcard.occupation') . ':', ['class' => 'form-label']) }}
        {{ Form::text('occupation', isset($vcard) ? $vcard->occupation : null, ['class' => 'form-control', 'placeholder' => __('messages.form.occupation')]) }}
      </div>
      <div class="col-lg-6 mb-7">
        <div class="mb-5">
          {{ Form::label('description', __('messages.vcard.description') . ':', ['class' => 'form-label']) }}
          <div id="vcardDescriptionQuill" class="editor-height" style="height: 200px"></div>
          {{ Form::hidden('description', isset($vcard) ? $vcard->description : null, ['id' => 'vcardDescriptionData']) }}
        </div>
        <div class="mb-5">
          <a href="javascript:void(0)" data-bs-target="#aiDescriptionModal" data-bs-toggle="modal"
            class="text-primary text-decoration-none fw-semibold d-inline-flex align-items-center gap-2">
            <i class="bi bi-stars"></i>
            {{ __('messages.vcard.generate_description_with_ai') }}
          </a>
        </div>
        @include('vcards.ai-description.ai-description-modal')
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-lg-6 col-sm-8 mb-7">
            <div class="form-group mb-7">
              {{ Form::label('cover_type', __('messages.cover_type.cover_type') . ':', ['class' => 'form-label']) }}
              @php
                $coverType = collect(App\Models\Vcard::COVER_TYPE)->map(function ($value) {
                    return trans('messages.cover_type.' . $value);
                });
              @endphp
              {{ Form::select('cover_type', $coverType, isset($vcard) ? $vcard->cover_type : null, ['class' => 'form-select cover-type', 'id' => 'coverType', 'data-control' => 'select2']) }}
            </div>
            <div class="col-lg-6 col-sm-6 mb-7 cover-imgs ms-5">
              <div class="mb-3" io-image-input="true">
                <label for="exampleInputImage" class="form-label">{{ __('messages.vcard.cover_img') . ':' }}</label>
                <span data-bs-toggle="tooltip" data-placement="top"
                  data-bs-original-title="{{ __('messages.tooltip.vcard_cover_img') }}">
                  <i class="fas fa-question-circle ml-1 general-question-mark"></i>
                </span>
                <div class="d-block">
                  <div class="images-picker">
                    <div class="image previewImage" id="coverPreview"
                      style="background-image: url('{{ !empty($vcard->cover_url) && in_array(pathinfo($vcard->cover_url, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? $vcard->cover_url : asset('assets/images/default_cover_image.jpg') }}');">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                      data-placement="top" data-bs-original-title="{{ __('messages.tooltip.cover') }}">
                      <label>
                        <i class="fa-solid fa-pen click-image" id="profileImageIcon"></i>
                        <input type="file" id="coverImg" name="cover_img" class="d-none crop-image-input"
                          accept="image/*" data-preview-id="coverPreview" data-crop-width="576"
                          data-crop-height="300" />
                      </label>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-text">{{ __('messages.allowed_img_types') }}</div>
            </div>

            <div class="col-lg-6 col-sm-6 mb-7 cover-video d-none ms-5">
              <div class="mb-3" io-image-input="true">
                <label for="exampleInputImage" class="form-label">{{ __('messages.vcard.cover_video') . ':' }}</label>
                <div class="d-block">
                  <div class="images-picker">
                    <div class="image previewImage" id="coverPreview">
                      @if (!empty($vcard->cover_url) && in_array(pathinfo($vcard->cover_url, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi']))
                        <video width="100%" height="100%" controls>
                          <source src="{{ $vcard->cover_url }}" type="video/mp4">
                        </video>
                      @else
                        <img src="{{ asset('assets/images/video-icon.png') }}" alt="Default Video Icon" width="100%">
                      @endif
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                      data-placement="top" data-bs-original-title="{{ __('messages.tooltip.cover') }}">
                      <label>
                        <i class="fa-solid fa-pen click-image" id="profileImageIcon"></i>
                        <input type="file" id="coverImg" name="cover_video" class="d-none" accept="video/*" />
                      </label>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-text">{{ __('messages.allowed_video_types') }}</div>
            </div>

            <div class="col-lg-12 mb-7 d-none cover_youtube_link mt-3">
              {{ Form::label('youtube_link', __('messages.cover_type.youtube_link') . ':', ['class' => 'form-label fs-6 text-gray-700 mb-3']) }}
              {{ Form::text('youtube_link', isset($vcard) ? $vcard->youtube_link : null, ['class' => 'form-control', 'placeholder' => 'https://www.youtube.com/watch?v=hAGbufevHM4', 'id' => '']) }}
            </div>

          </div>
          <div class="col-lg-6 col-sm-4 mb-7">
            <div class="mb-3 ms-5" io-image-input="true">
              <label for="exampleInputImage"
                class="ms-5 form-label">{{ __('messages.vcard.profile_image') . ':' }}</label>
              <span data-bs-toggle="tooltip" data-placement="top"
                data-bs-original-title="{{ __('messages.tooltip.vcard_profile_img') }}">
                <i class="fas fa-question-circle ml-1 general-question-mark"></i>
              </span>
              <div class="d-block">
                <div class="image-picker ms-5">
                  <div class="image previewImage" id="exampleInputImage"
                    style="background-image: url('{{ !empty($vcard->profile_url) ? $vcard->profile_url : asset('web/media/avatars/user2.png') }}')">
                  </div>
                  <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                    data-placement="top" data-bs-original-title="{{ __('messages.tooltip.profile') }}">
                    <label>
                      <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                      <input type="file" id="profile_image" name="profile_img"
                        class="image-upload file-validation d-none crop-profile-input" accept="image/*"
                        data-preview-id="vCardProfilePreview" />
                    </label>
                  </span>
                </div>
              </div>
            </div>
            <div class="ms-5">
              <div class="form-text ms-5">{{ __('messages.allowed_file_types') }}</div>
            </div>

          </div>
          <div class="col-lg-6 mb-7 favicon-input margin-top-40">
            <div class="mb-3 ms-4" io-image-input="true">
              <label for="exampleInputImage"
                class="form-label">{{ __('messages.vcard.favicon_image') . ':' }}</label>
              <span data-bs-toggle="tooltip" data-placement="top"
                data-bs-original-title="{{ __('messages.tooltip.favicon_logo') }}">
                <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
              </span>
              <div class="d-block">
                <div class="image-picker">
                  <div class="image previewImage" id="exampleInputImage"
                    style="background-image: url('{{ !empty($vcard->favicon_url) ? $vcard->favicon_url : $adminFavicon }}')">
                  </div>
                  <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                    data-placement="top" data-bs-original-title="{{ __('messages.tooltip.change_favicon_logo') }}">
                    <label>
                      <i class="fa-solid fa-pen" id="faviconImageIcon"></i>
                      <input type="file" id="favicon_image" name="favicon_img"
                        class="image-upload file-validation d-none" accept="image/*"
                        data-preview-id="vcardFaviconPreview" />
                    </label>
                  </span>
                </div>
              </div>
            </div>
            <div class="form-text ms-4">{{ __('messages.allowed_file_types') }}</div>
          </div>
        </div>
      </div>
      <div class="d-flex">
        {{ Form::submit(__('messages.save_next'), ['class' => 'btn btn-primary me-3', 'id' => 'vcardSaveBtn']) }}
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif
@if ($partName == 'basics2')
  <div>
    {{ Form::hidden('default_language', app()->getLocale()) }}
    @if (isset($vcard))
      <input type="hidden" id="vcardId" value="{{ $vcard->id }}">
    @endif
    <input type="hidden" name="part" value="{{ $partName }}">
    <div class="container-fluid">
      <div class="row" id="basic">
        @if (isset($vcard))
          <div class="mt-5 row">
            <h4 class="fw-bolder text-gray-800 mb-5"> {{ __('messages.vcard.vcard_details') }} </h4>
            <div class="col-md-6">
              <div class="form-group mb-7">
                {{ Form::label('first_name', __('messages.vcard.first_name') . ':', ['class' => 'form-label required']) }}
                {{ Form::text('first_name', isset($vcard) ? $vcard->first_name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.f_name'), 'required']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-7">
                {{ Form::label('last_name', __('messages.vcard.last_name') . ':', ['class' => 'form-label required']) }}
                {{ Form::text('last_name', isset($vcard) ? $vcard->last_name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.l_name'), 'required']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-7">
                {{ Form::label('email', __('messages.user.email') . ':', ['class' => 'form-label']) }}
                {{ Form::text('email', isset($vcard) ? $vcard->email : null, ['class' => 'form-control', 'placeholder' => __('messages.form.email')]) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('phone', __('messages.user.phone') . ':', ['class' => 'form-label']) }}
                {{ Form::text('phone', isset($vcard) ? (isset($vcard->region_code) ? '+' . $vcard->region_code . '' . $vcard->phone : $vcard->phone) : null, ['class' => 'form-control', 'placeholder' => __('messages.form.phone'), 'id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                {{ Form::hidden('region_code', isset($vcard) ? $vcard->region_code : null, ['id' => 'prefix_code']) }}
                <div class="mt-2">
                  <span id="valid-msg"
                    class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.valid_number') }}</span>
                  <span id="error-msg" class="text-danger d-none fw-400 fs-small mt-2">Invalid
                    Number</span>
                </div>
              </div>
            </div>
            <div class='col-md-6 col-lg-6 col-sm-6 col-12'>
              <div class="form-group mb-7">
                {{ Form::label('alternative_email', __('messages.vcard.alternate_email') . ':', ['class' => 'form-label']) }}
                {{ Form::text('alternative_email', isset($vcard) ? $vcard->alternative_email : null, ['class' => 'form-control', 'placeholder' => __('messages.vcard.alternate_email')]) }}
              </div>
            </div>
            <div class='col-md-6 col-lg-6 col-sm-6 col-12'>
              <div class="form-group">
                {{ Form::label('alternative_phone', __('messages.vcard.alternative_phone') . ':', ['class' => 'form-label']) }}
                {{ Form::text('alternative_phone', isset($vcard) ? (isset($vcard->alternative_region_code) ? '+' . $vcard->alternative_region_code . '' . $vcard->alternative_phone : $vcard->alternative_phone) : null, ['class' => 'form-control', 'placeholder' => __('messages.vcard.alternative_phone'), 'id' => 'alternativePhone', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                {{ Form::hidden('alternative_region_code', isset($vcard) ? $vcard->alternative_region_code : null, ['id' => 'alternative_prefix_code']) }}
                <div class="mt-2">
                  <span id="alter-valid-msg"
                    class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.valid_number') }}</span>
                  <span id="alter-error-msg" class="text-danger d-none fw-400 fs-small mt-2">Invalid
                    Number</span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-7">
                {{ Form::label('location', __('messages.user.location') . ':', ['class' => 'form-label']) }}
                {{ Form::textarea('location', isset($vcard) ? $vcard->location : null, ['class' => 'form-control', 'placeholder' => __('messages.form.location'), 'rows' => '1']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-7">
                {{ Form::label('location_type', __('messages.setting.select_location_type') . ':', ['class' => 'form-label']) }}
                @php
                  $locationType = collect(App\Models\Vcard::LOCATION_TYPE)->map(function ($value) {
                      return trans('messages.location_type.' . $value);
                  });
                @endphp
                {{ Form::select('location_type', $locationType, isset($vcard) ? $vcard->location_type : null, ['class' => 'form-select', 'id' => 'location_type', 'data-control' => 'select2']) }}
              </div>
            </div>
            <div class="col-md-6" id="linkInputGroup">
              <div class="form-group mb-7">
                {{ Form::label('location_url', __('messages.setting.location_url') . ':', ['class' => 'form-label']) }}
                {{ Form::text('location_url', isset($vcard) ? $vcard->location_url : null, ['class' => 'form-control', 'placeholder' => __('messages.form.location_url')]) }}
              </div>
            </div>
            <div class="col-md-6" id="iframeInputGroup" style="display: none;">
              <div class="form-group mb-7">
                {{ Form::label('location_embed_tag', __('messages.location_type.location_embed_tag') . ':', ['class' => 'form-label']) }}
                {{ Form::textarea('location_embed_tag', isset($vcard) ? $vcard->location_embed_tag : null, ['class' => 'form-control', 'placeholder' => __('messages.location_type.location_embed_tag'), 'rows' => 1]) }}
              </div>
            </div>
            <div class="col-lg-6 mb-7">
              {{ Form::label('dob', __('messages.vcard.date_of_birth') . ':', ['class' => 'form-label']) }}
              {{ Form::text('dob', isset($vcard) ? $vcard->dob : null, ['class' => 'form-control', 'placeholder' => __('messages.form.DOB')]) }}
            </div>
            <div class="col-lg-6 mb-7">
              {{ Form::label('company', __('messages.vcard.company') . ':', ['class' => 'form-label']) }}
              {{ Form::text('company', isset($vcard) ? $vcard->company : null, ['class' => 'form-control', 'placeholder' => __('messages.form.company')]) }}
            </div>
            @if (checkFeature('advanced'))
              @if (checkFeature('advanced')->hide_branding)
                <div class="col-lg-6 mb-7">
                  {{ Form::label('made_by', __('messages.made_by') . ':', ['class' => 'form-label']) }}
                  {{ Form::text('made_by', isset($vcard) ? $vcard->made_by : null, ['class' => 'form-control', 'placeholder' => __('messages.made_by')]) }}
                </div>
                <div class="col-lg-6 mb-7">
                  {{ Form::label('made_by_url', __('messages.made_by_url') . ':', ['class' => 'form-label']) }}
                  {{ Form::text('made_by_url', isset($vcard) ? $vcard->made_by_url : null, ['class' => 'form-control', 'placeholder' => __('messages.made_by_url')]) }}
                </div>
              @endif
            @endif
            <div class="col-lg-6 mb-7">
              {{ Form::label('job_title', __('messages.vcard.job_title') . ':', ['class' => 'form-label']) }}
              {{ Form::text('job_title', isset($vcard) ? $vcard->job_title : null, ['class' => 'form-control', 'placeholder' => __('messages.form.job')]) }}
            </div>
            <div class="col-lg-6 mb-7">
              <div class="d-flex">
                {{ Form::label('default_language', __('messages.setting.default_language') . ':', ['class' => 'form-label']) }}
              </div>
              <div class="form-group">
                {{ Form::select('default_language', getAllLanguage(), isset($vcard) ? (isset($vcard->default_language) ? $vcard->default_language : getCurrentLanguageName()) : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-7">
                {{ Form::label('cover_image_type', __('messages.cover_image_type.cover_image_type') . ':', ['class' => 'form-label']) }}
                @php
                  $coverImageType = collect(App\Models\Vcard::COVER_IMAGE_TYPE)->map(function ($value) {
                      return trans('messages.cover_image_type.' . $value);
                  });
                @endphp
                {{ Form::select('cover_image_type', $coverImageType, isset($vcard) ? $vcard->cover_image_type : null, ['class' => 'form-select', 'id' => 'cover_image_type', 'data-control' => 'select2']) }}
              </div>
            </div>
          </div>
        @endif
        <div class="d-flex">
          {{ Form::submit(__('messages.save_next'), ['class' => 'btn btn-primary me-3', 'id' => 'vcardSaveBtn']) }}
          <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
      </div>
    </div>
  </div>
@endif
@if ($partName == 'basics3')
  <div>
    @if (isset($vcard))
      <input type="hidden" id="vcardId" value="{{ $vcard->id }}">
    @endif
    <input type="hidden" name="part" value="{{ $partName }}">
    <div class="container-fluid pt-5">
      <div class="row g-3 pt-5" id="basic">
        @if (isset($vcard))
          <div class="col-md-6 col-xl-3">
            <div class="card h-100 shadow p-5 text-center">
              {{ Form::label('language_enable', __('messages.vcard.display_language_localization') . ':', ['class' => 'form-label']) }}
              <div
                class="form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex justify-content-center">
                {{ Form::checkbox('language_enable', 1, $vcard['language_enable'] ?? 0, ['class' => 'form-check-input mt-2', 'id' => 'languageEnable']) }}
              </div>
            </div>
          </div>

          @if (checkFeature('enquiry_form'))
            <div class="col-md-6 col-xl-3">
              <div class="card h-100 shadow p-5 text-center">
                {{ Form::label('enable_enquiry_form', __('messages.vcard.display_enquiry_form') . ':', ['class' => 'form-label']) }}
                <div
                  class="form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex justify-content-center">
                  {{ Form::checkbox('enable_enquiry_form', 1, $vcard['enable_enquiry_form'] ?? 0, ['class' => 'form-check-input mt-2', 'id' => 'enableEnquiryForm']) }}
                </div>
              </div>
            </div>
          @endif

          <div class="col-md-6 col-xl-3">
            <div class="card h-100 shadow p-5 text-center">
              {{ Form::label('enable_download_qr_code', __('messages.vcard.display_download_qr_icon') . ':', ['class' => 'form-label']) }}
              <div
                class="form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex justify-content-center">
                {{ Form::checkbox('enable_download_qr_code', 1, $vcard['enable_download_qr_code'] ?? 0, ['class' => 'form-check-input mt-2', 'id' => 'enableDownloadQrCode']) }}
              </div>
            </div>
          </div>

          <div class="col-md-6 col-xl-3">
            <div class="card h-100 shadow p-5 text-center">
              {{ Form::label('show_qr_code', __('messages.vcard.display_qr_section') . ':', ['class' => 'form-label']) }}
              <div
                class="form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex justify-content-center">
                {{ Form::checkbox('show_qr_code', 1, $vcard['show_qr_code'] ?? 0, ['class' => 'form-check-input mt-2', 'id' => 'enableQrCode']) }}
              </div>
            </div>
          </div>

          @if (checkFeature('affiliation'))
            <div class="col-md-6 col-xl-3">
              <div class="card h-100 shadow p-5 text-center">
                <div class="d-flex justify-content-center align-items-center gap-1 mb-1">
                  {{ Form::label('enable_enquiry_form', __('messages.setting.display_user_affiliation') . ':', ['class' => 'form-label']) }}
                  <span data-bs-toggle="tooltip" class="mb-3" data-placement="top"
                    data-bs-original-title="{{ __('messages.tooltip.enable_affiliation') }}">
                    <i class="fas fa-question-circle ml-1 mx-1 general-question-mark"></i>
                  </span>
                </div>
                <div
                  class="form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex justify-content-center">
                  {{ Form::checkbox('enable_affiliation', 1, $vcard['enable_affiliation'] ?? 0, ['class' => 'form-check-input mt-2', 'id' => 'enableAffiliation']) }}
                </div>
              </div>
            </div>
          @endif

          <div class="col-md-6 col-xl-3">
            <div class="card h-100 shadow p-5 text-center">
              <div class="d-flex justify-content-center align-items-center gap-1 mb-1">
                {{ Form::label('enable_addcontact', __('messages.setting.display_add_to_contact') . ':', ['class' => 'form-label']) }}
                <span data-bs-toggle="tooltip" class="mb-3" data-placement="top"
                  data-bs-original-title="{{ __('messages.tooltip.enable_contact') }}">
                  <i class="fas fa-question-circle ml-1 mx-1 general-question-mark"></i>
                </span>
              </div>
              <div
                class="form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex justify-content-center">
                {{ Form::checkbox('enable_contact', 1, $vcard['enable_contact'] ?? 0, ['class' => 'form-check-input mt-2', 'id' => 'enableContact']) }}
              </div>
            </div>
          </div>

          <div class="col-md-6 col-xl-3">
            <div class="card h-100 shadow p-5 text-center">
              <div class="d-flex justify-content-center align-items-center gap-1 mb-1">
                {{ Form::label('hide_stickybar', __('messages.setting.hide_stickybar') . ':', ['class' => 'form-label']) }}
                <span data-bs-toggle="tooltip" class="mb-3" data-placement="top"
                  data-bs-original-title="{{ __('messages.tooltip.hide_stickybar') }}">
                  <i class="fas fa-question-circle ml-1 mx-1 general-question-mark"></i>
                </span>
              </div>
              <div
                class="form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex justify-content-center">
                {{ Form::checkbox('hide_stickybar', 1, $vcard['hide_stickybar'] ?? 0, ['class' => 'form-check-input mt-2', 'id' => 'hideStickyBar']) }}
              </div>
            </div>
          </div>

          <div class="col-md-6 col-xl-3">
            <div class="card h-100 shadow p-5 text-center">
              <div class="d-flex justify-content-center align-items-center gap-1 mb-1">
                {{ Form::label('whatsapp_share', __('messages.setting.display_whatsapp_share') . ':', ['class' => 'form-label']) }}
                <span data-bs-toggle="tooltip" class="mb-3" data-placement="top"
                  data-bs-original-title="{{ __('messages.tooltip.whatsapp_share') }}">
                  <i class="fas fa-question-circle ml-1 mx-1 general-question-mark"></i>
                </span>
              </div>
              <div
                class="form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex justify-content-center">
                {{ Form::checkbox('whatsapp_share', 1, $vcard['whatsapp_share'] ?? 0, ['class' => 'form-check-input mt-2', 'id' => 'whatsappShare']) }}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card shadow p-4">
              <label for="qrCodeDownloadSize" class="form-label fw-semibold">
                {{ __('messages.vcard.qr_code_download_size') }}
              </label>
              <div class="d-flex align-items-center">
                <input type="range" name="qr_code_download_size" class="form-range w-75 mx-2"
                  value="{{ $vcard['qr_code_download_size'] }}" min="100" max="500" step="100"
                  id="qrCodeDownloadSize"
                  oninput="document.getElementById('download-result').innerText = this.value+'px'">
                <span id="download-result" class="fw-bold">{{ $vcard['qr_code_download_size'] . 'px' }}</span>
              </div>
            </div>
          </div>
        @endif
        <div class="pt-3">
          {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'vcardSaveBtn']) }}
          <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
      </div>
    </div>
  </div>
@endif
@if ($partName == 'templates')
  <div class="container-fluid">
    <div class="col-lg-12 mb-3">
      <input type="hidden" name="part" value="{{ $partName }}">
      <label class="form-label required">{{ __('messages.vcard.select_template') }}
        :</label>
    </div>
    <div class="form-group mb-7 vcard-template">
      <div class="row">
        <input type="hidden" name="template_id" id="templateId" value="{{ $vcard->template_id }}">
        @php
          $templateNames = [
              1 => 'Simple Contact',
              2 => 'Executive Profile',
              3 => 'Clean Canvas',
              4 => 'Professional',
              5 => 'Corporate Connect',
              6 => 'Modern Edge',
              7 => 'Business Beacon',
              8 => 'Corporate Classic',
              9 => 'Corporate Identity',
              10 => 'Pro Network',
              11 => 'Portfolio',
              12 => 'Gym 2',
              13 => 'Hospital 2',
              14 => 'Event Management 2',
              15 => 'Salon 2',
              16 => 'Lawyer 2',
              17 => 'Programmer 2',
              18 => 'CEO/CXO 2',
              19 => 'Fashion Beauty 2',
              20 => 'Culinary Food Services 2',
              21 => 'Social Media 2',
              22 => 'Dynamic vCard 2',
              23 => 'Consulting Services 2',
              24 => 'School Templates 2',
              25 => 'Social Services 2',
              26 => 'Retail E-commerce 2',
              27 => 'Pet Shop 2',
              28 => 'Pet Clinic 2',
              29 => 'Marriage 2',
              30 => 'Taxi Service 2',
              31 => 'Handyman Services 2',
              32 => 'Interior Designer 2',
              33 => 'Musician 2',
              34 => 'Photographer 2',
              35 => 'Real Estate 2',
              36 => 'Travel Agency 2',
              37 => 'Flower Garden 2',
              38 => 'Architecture',
              39 => 'Gym 1',
              40 => 'Hospital 1',
              41 => 'Event Management 1',
              42 => 'Salon 1',
              43 => 'Lawyer 1',
              44 => 'Programmer 1',
              45 => 'CEO/CXO 1',
              46 => 'Fashion Beauty 1',
              47 => 'Culinary Food Services 1',
              48 => 'Social Media 1',
              49 => 'Dynamic vCard 1',
              50 => 'Consulting Services 1',
              51 => 'School Templates 1',
              52 => 'Social Services 1',
              53 => 'Retail E-commerce 1',
              54 => 'Pet Shop 1',
              55 => 'Pet Clinic 1',
              56 => 'Marriage 1',
              57 => 'Taxi Service 1',
              58 => 'Handyman Services 1',
              59 => 'Interior Designer 1',
              60 => 'Musician 1',
              61 => 'Photographer 1',
              62 => 'Real Estate 1',
              63 => 'Travel Agency 1',
              64 => 'Flower Garden 1',
              65 => 'Reporter',
          ];

          // Create pairs of templates
          $templatePairs = [
              39 => 12,
              40 => 13,
              41 => 14,
              42 => 15,
              43 => 16,
              44 => 17,
              45 => 18,
              46 => 19,
              47 => 20,
              48 => 21,
              49 => 22,
              50 => 23,
              51 => 24,
              52 => 25,
              53 => 26,
              54 => 27,
              55 => 28,
              56 => 29,
              57 => 30,
              58 => 31,
              59 => 32,
              60 => 33,
              61 => 34,
              62 => 35,
              63 => 36,
              64 => 37,
          ];

          // Sort templates to ensure pairs appear together
          $sortedTemplates = [];
          $processed = [];

          $reversedTemplatePairs = array_reverse($templatePairs, true);

          foreach ($reversedTemplatePairs as $version1Id => $version2Id) {
              if (isset($templates[$version1Id]) && !in_array($version1Id, $processed)) {
                  $sortedTemplates[$version1Id] = $templates[$version1Id];
                  $processed[] = $version1Id;
              }

              if (isset($templates[$version2Id]) && !in_array($version2Id, $processed)) {
                  $sortedTemplates[$version2Id] = $templates[$version2Id];
                  $processed[] = $version2Id;
              }
          }

          // Then add all templates without pairs (basic templates)
          foreach ($templates as $id => $url) {
              if (!array_key_exists($id, $templatePairs) && !in_array($id, $templatePairs)) {
                  $sortedTemplates[$id] = $url;
                  $processed[] = $id;
              }
          }

          // Add any remaining templates that weren't processed
          foreach ($templates as $id => $url) {
              if (!in_array($id, $processed)) {
                  $sortedTemplates[$id] = $url;
              }
          }
        @endphp

        {{-- For Debugging --}}
        @php
          ksort($sortedTemplates);
        @endphp

        @foreach ($sortedTemplates as $id => $url)
          {{-- For Debugging --}}
          @php
            $template = \App\Models\Template::find($id);
            $folderName = basename(dirname($template->path));
          @endphp
          <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-3 templatecard">
            {{-- For Debugging --}}
            <div class="template-header-info">
              <span class="template-id">ID: {{ $id }} | {{ $folderName }}</span>
              <span class="template-name">{{ $templateNames[$id] }}</span>
            </div>
            <div
              class="img-radio img-thumbnail {{ $id == 11 ? 'screen vcard_11' : '' }} {{ $vcard->template_id == $id ? 'img-border' : '' }} @if ($id == 22) ribbon @endif"
              data-id="{{ $id }}">
              <img src="{{ $url }}" alt="Template">
              <div class="hover-template-name">{{ $templateNames[$id] }}</div>
              @if ($id == 22)
                <div class="ribbon-wrapper">
                  <div class="ribbon fw-bold">{{ __('messages.feature.dynamic_vcard') }}</div>
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="col-lg-12 mt-5 mb-5">
      <div class="form-check form-switch">
        <input class="form-check-input me-3" type="checkbox" id="vcardTemplateStatus" name="status"
          {{ $vcard->status ? 'checked' : '' }}>
        <label class="form-label" for="vcardTemplateStatus">
          {{ __('messages.common.active') }}
        </label>
      </div>
    </div>
    <div class="col-lg-12 mt-2 d-flex">
      <button class="btn btn-primary me-3 template-save">
        {{ __('messages.common.save') }}
      </button>
      <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
  </div>
@endif

@if ($partName === 'business-hours')
  <div class="container-fluid">
    <div class="row">
      <input type="hidden" name="part" value="{{ $partName }}">
      <div class="col-lg-3 mb-3">
        {{ Form::label('week_format', __('messages.week_format_type.week_format_type') . ':', ['class' => 'form-label']) }}
        @php
          $weekFormatOptions = collect(App\Models\BusinessHour::WEEK_FORMAT_TYPE)->map(function ($value) {
              return trans('messages.week_format_type.' . $value);
          });
        @endphp
        {{ Form::select('week_format', $weekFormatOptions, $vcard->week_format ?? 1, ['class' => 'form-select', 'id' => 'week_format', 'data-control' => 'select2']) }}
      </div>
      @foreach (\App\Models\BusinessHour::DAY_OF_WEEK as $key => $day)
        @php
          $isChecked = !empty($hours[$key]);
          $start = $isChecked ? $hours[$key]['start_time'] : null;
          $end = $isChecked ? $hours[$key]['end_time'] : null;
        @endphp

        <div class="col-12 mb-5 d-flex align-items-center">

          <div class="me-4 d-flex align-items-center" style="min-width: 180px;">
            <div class="form-check form-switch me-2">
              <input class="form-check-input day-toggle" type="checkbox" id="dayToggle{{ $key }}"
                name="days[]" value="{{ $key }}" {{ $isChecked ? 'checked' : '' }}>
            </div>
            <label class="form-check-label fw-semibold mb-0" for="dayToggle{{ $key }}">
              {{ strtoupper(__('messages.business.' . $day)) }}
            </label>
          </div>

          <div class="flex-grow-1">
            <div class="time-fields" id="timeFields{{ $key }}"
              style="{{ $isChecked ? 'display: flex;' : 'display: none;' }}">
              <div class="d-flex">
                <span class="input-group-text bg-light text-muted small">{{ __('messages.common.from') }}</span>
                {{ Form::select("startTime[$key]", getSchedulesTimingSlot(), $start, ['class' => 'form-control', 'data-control' => 'select2']) }}

                <span class="input-group-text bg-light text-muted small ms-4">{{ __('messages.common.to') }}</span>
                {{ Form::select("endTime[$key]", getSchedulesTimingSlot(), $end, ['class' => 'form-control', 'data-control' => 'select2']) }}
              </div>
            </div>

            <div class="closed-state" id="closedState{{ $key }}"
              style="{{ $isChecked ? 'display: none;' : 'display: flex;' }}">
              <div class="">
                <div class="">
                  <span class="input-group-text bg-light text-muted w-100 justify-content-center">
                    <i class="bi bi-moon me-2"></i>
                    <span>{{ __('messages.common.closed') }}</span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
      <div class="col-lg-12 mt-4 d-flex">
        <button class="btn btn-primary me-3">{{ __('messages.common.save') }}</button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif

@if ($partName == 'appointments')
  <div class="col-12">
    <table class="table table-striped mt-lg-4">
      <tbody>
        <input type="hidden" name="part" value="{{ $partName }}">
        @foreach (App\Models\BusinessHour::WEEKDAY_NAME as $day => $shortWeekDay)
          <tr>
            <td>
              <div class="weekly-content" data-day="{{ $day }}">
                <div class="d-flex w-100 align-items-center position-relative">
                  <div class="d-flex row flex-md-row flex-column w-100 weekly-row">
                    <div class="col-xl-2 form-check mb-5 d-flex align-items-center ms-5">
                      <input id="chkShortWeekDay_{{ $shortWeekDay }}" class="form-check-input" type="checkbox"
                        value="{{ $day }}" name="checked_week_days[]"
                        {{ !empty($time[$day]) ? 'checked' : '' }}>
                      <label class="form-label mb-0 me-2" for="chkShortWeekDay_{{ $shortWeekDay }}">
                        <span
                          class="ms-4 d-md-block">{{ strtoupper(__('messages.business.' . strtolower($shortWeekDay))) }}</span>
                      </label>
                    </div>
                    <div class="col-xl-8 session-times">
                      @include('vcards.appointment.slot', ['day' => $day])
                    </div>
                  </div>
                  <div class="weekly-icon position-absolute end-0 d-flex">
                    <a href="javascript:void(0)" class="add-session-time btn px-2 fs-2"
                      id="add-session-{{ $day }}" data-day="{{ $day }}"
                      data-bs-toggle="tooltip" title="{{ __('messages.common.add') }}">
                      <i class="fa fa-plus text-primary" aria-hidden="true"></i>
                    </a>
                    <div class="dropdown d-flex align-items-center">
                      <button class="btn dropdown-toggle copy-days-btn ps-2 pe-0 hide-arrow" type="button"
                        id="dropdownCopyMenu-{{ $day }}" data-bs-toggle="dropdown" aria-expanded="false"
                        data-bs-auto-close="outside">
                        <i class="fa-solid fa-copy text-primary fs-2"></i>
                      </button>
                      <div class="dropdown-menu copy-menu py-0 rounded-10 min-width-220"
                        aria-labelledby="dropdownCopyMenu-{{ $day }}">
                        <div class="p-5 menu-content">
                          @foreach (App\Models\BusinessHour::WEEKDAY_NAME as $weekDayKey => $weekDay)
                            @if ($day != $weekDayKey)
                              <div
                                class="mb-5 form-check ps-0 d-flex align-items-center justify-content-between copy-label">
                                <label class="form-check-label text-gray-900"
                                  for="chkCopyDay_{{ $shortWeekDay }}_{{ $weekDay }}">{{ ucfirst(__('messages.business.' . strtolower($weekDay))) }}</label>
                                <input type="checkbox" id="chkCopyDay_{{ $shortWeekDay }}_{{ $weekDay }}"
                                  class="form-check-input float-none copy-check-input ms-0"
                                  value="{{ $weekDayKey }}">
                              </div>
                            @endif
                          @endforeach
                          <button type="button" data-copy-day="{{ $day }}"
                            class="btn btn-primary copy-btn w-100">{{ __('messages.appointment.copy') }}</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <p class="ms-1 fw-bold">{{ __('messages.appointment.appointment_type') }}</p>
    <input type="hidden" id="isUserPaidId" name="is_paid"
      value="{{ isset($appointmentDetail->is_paid) ? $appointmentDetail->is_paid : 0 }}">
    <div class="d-flex align-items-center gap-4 py-3 flex-wrap">
      <div class="form-check me-4">
        <input class="form-check-input" type="radio" name="is_paid_radio" id="freeRadio" value="0"
          {{ isset($appointmentDetail) && $appointmentDetail->is_paid == 0 ? 'checked' : (!isset($appointmentDetail) ? 'checked' : '') }}>
        <label class="form-check-label" for="freeRadio">
          {{ __('messages.appointment.free') }}
        </label>
      </div>
      <div class="form-check d-flex align-items-center me-4">
        <input class="form-check-input me-2" type="radio" name="is_paid_radio" id="paidRadio" value="1"
          {{ isset($appointmentDetail) && $appointmentDetail->is_paid == 1 ? 'checked' : '' }}>
        <label class="form-check-label me-3" for="paidRadio">
          {{ __('messages.appointment.paid') }}
        </label>
        <div id="userPaidInputDiv"
          class="{{ isset($appointmentDetail->is_paid) && $appointmentDetail->is_paid == 1 ? '' : 'd-none' }}">
          {{ Form::number('price', isset($appointmentDetail) ? $appointmentDetail->price : null, [
              'class' => 'form-control',
              'id' => 'userPaymentAmount',
              'placeholder' => __('messages.subscription.amount'),
              'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")',
              'min' => 0,
              'style' => 'width: 250px; margin-left: 20px;',
          ]) }}
        </div>
      </div>
    </div>
    <div class="col-lg-12 d-flex">
      <button type="submit" class="btn btn-primary me-3">
        {{ __('messages.common.save') }}
      </button>
      <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
  </div>
@endif

@if ($partName == 'social-links')
  <div class="container-fluid">
    <p>{{ __('messages.setting.note') }}</p>
    <input type="hidden" name="part" value="{{ $partName }}">
    <div class="row social-links-add">
      <div class="col-12 mb-7 d-flex justify-content-end">
        <button type="button"
          class="btn btn-primary social-links">{{ __('messages.common.add_social_link') }}</button>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fas fa-globe fa-2x text-primary mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('website', isset($socialLink) ? $socialLink->website : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.website'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-sm-0 p-2 px-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 448 512" width="30"
              height="30">
              <path
                d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z" />
            </svg>
          </div>
          <div class="col-sm-11">
            {!! Form::text('twitter', isset($socialLink) ? $socialLink->twitter : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.twitter'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fab fa-facebook-square fa-2x text-primary mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('facebook', isset($socialLink) ? $socialLink->facebook : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.facebook'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fab fa-instagram fa-2x text-danger mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('instagram', isset($socialLink) ? $socialLink->instagram : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.instagram'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fab fa-reddit-alien fa-2x text-danger mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('reddit', isset($socialLink) ? $socialLink->reddit : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.reddit'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fab fa-tumblr-square fa-2x text-dark mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('tumblr', isset($socialLink) ? $socialLink->tumblr : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.tumblr'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fab fa-youtube fa-2x text-danger mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('youtube', isset($socialLink) ? $socialLink->youtube : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.youtube'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fab fa-linkedin fa-2x text-primary mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('linkedin', isset($socialLink->linkedin) ? $socialLink->linkedin : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.linkedin'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fab fa-whatsapp fa-2x text-success mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('whatsapp', isset($socialLink) ? $socialLink->whatsapp : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.whatsapp'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fab fa-pinterest fa-2x text-danger mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('pinterest', isset($socialLink) ? $socialLink->pinterest : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.pinterest'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fab fa-tiktok fa-2x text-danger mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('tiktok', isset($socialLink) ? $socialLink->tiktok : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.tiktok'),
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        <div class="row">
          <div class="col-sm-1 mb-3 mb-sm-0">
            <i class="fab fa-snapchat fa-2x text-warning mt-3 me-3"></i>
          </div>
          <div class="col-sm-11">
            {!! Form::text('snapchat', isset($socialLink) ? $socialLink->snapchat : null, [
                'class' => 'form-control',
                'placeholder' => __('messages.form.snapchat'),
            ]) !!}
          </div>
        </div>
      </div>
      @foreach ($socialLink->icon as $key => $link)
        <div class="col-lg-6 mb-7 social-links-div">
          <div class="d-flex">
            <div class="mb-3 mb-sm-0 me-3">
              <div class="" io-image-input="true">
                <div class="    ">
                  <div class="image-picker">
                    <div class="image previewImage " id="exampleInputImage"
                      style="background-image: url('{!! $link->social_icon ?? 'https://cdn-icons-png.flaticon.com/512/87/87390.png' !!} ') ;width: 40px; height: 40px">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                      data-placement="top" data-bs-original-title="{{ __('messages.tooltip.profile') }}"
                      style="width: 22px; height: 22px">
                      <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        <input type="file" id="profile_image" name="social_links_image[{{ $key }}]"
                          class="image-upload file-validation d-none social_links_image crop-image-input"
                          accept="image/*" data-preview-id="socialLinkPreview{{ $key }}"
                          value="{{ $link->social_icon }}" />
                      </label>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex ml-2 w-100">
              <input type="text" class="form-control social_links" name="social_links[{{ $key }}]"
                value="{{ $link->link }}">
              <input type="hidden" name="social_link_id[{{ $key }}]" class="socialLinkId"
                value="{{ $link->id }}">
              <a href="javascript:void(0)" class="btn px-1 text-danger fs-3 social-links-delete-btn">
                <i class="fa-solid fa-trash"></i>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="col-lg-12 d-flex">
      <button type="button" class="btn btn-primary me-3 social_link_save">
        {{ __('messages.common.save') }}
      </button>
      <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
  </div>
@endif


@if ($partName == 'advanced')
  <div class="container-fluid">
    <div class="row">
      <input type="hidden" name="part" value="{{ $partName }}">
      @if (checkFeature('advanced')->password)
        <div class="col-lg-6 mb-7">
          <label class="form-label">{{ __('messages.user.password') . ':' }}</label>
          <div class="position-relative mb-3">
            <div class="mb-3 position-relative">
              <input class="form-control" type="password" placeholder="{{ __('messages.form.password') }}"
                name="password" value="{{ !empty($vcard->password) ? Crypt::decrypt($vcard->password) : '' }}"
                autocomplete="off" aria-label="Password" data-toggle="password" />
              <span
                class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                <i class="bi bi-eye-slash-fill"></i>
              </span>
            </div>
            <div class="d-flex align-items-center mb-3"></div>
          </div>
        </div>
      @endif

      @if (checkFeature('advanced')->custom_css)
        <div class="col-lg-12 mb-7">
          {{ Form::label('custom_css', __('messages.vcard.custom_css') . ':', ['class' => 'form-label']) }}
          {{ Form::textarea('custom_css', isset($vcard) ? $vcard->custom_css : null, ['class' => 'form-control', 'placeholder' => __('messages.form.css'), 'rows' => '5']) }}
        </div>
      @endif

      @if (checkFeature('advanced')->custom_js)
        <div class="col-lg-12 mb-7">
          {{ Form::label('custom_js', __('messages.vcard.custom_js') . ':', ['class' => 'form-label']) }}
          {{ Form::textarea('custom_js', isset($vcard) ? $vcard->custom_js : null, ['class' => 'form-control', 'placeholder' => __('messages.form.js'), 'rows' => '5']) }}
        </div>
      @endif

      @if (checkFeature('advanced')->hide_branding)
        <div class="col-lg-6 mb-7">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="branding" name="branding"
              {{ $vcard->branding ? 'checked' : '' }}>
            <label class="form-check-label" for="branding">
              {{ __('messages.vcard.remove_branding') }}
            </label>
            <span data-bs-toggle="tooltip" data-placement="top"
              data-bs-original-title="{{ __('messages.tooltip.remove_branding') }}">
              <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
            </span>
          </div>
        </div>
      @endif

      <div class="col-lg-12 d-flex">
        <button type="submit" class="btn btn-primary me-3">
          {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif

@if ($partName == 'custom-fonts')
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6 mb-7">
        {{ Form::label('font_family', __('messages.font.font_family') . ':', ['class' => 'form-label']) }}
        {{ Form::select('font_family', \App\Models\Vcard::FONT_FAMILY, $vcard->font_family, [
            'class' => 'form-select',
            'data-control' => 'select2',
        ]) }}
      </div>
      {{-- <div class="col-lg-6 mb-7">
                {!! Form::label('font_size', __('messages.font.font_size') . ':', ['class' => 'form-label']) !!}

                {!! Form::number('font_size', $vcard->font_size, [
                    'class' => 'form-control',
                    'min' => '14',
                    'max' => '40',
                    'placeholder' => __('messages.font.font_size_in_px'),
                ]) !!}
            </div> --}}
      <div class="col-lg-12 d-flex">
        <button type="submit" class="btn btn-primary me-3">
          {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
@endif

@if ($partName == 'seo')
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6 mb-7">
        {{ Form::label('Site title', __('messages.vcard.site_title') . ':', ['class' => 'form-label']) }}
        {{ Form::text('site_title', isset($vcard) ? $vcard->site_title : null, ['class' => 'form-control', 'placeholder' => __('messages.form.site_title')]) }}
      </div>
      <div class="col-lg-6 mb-7">
        {{ Form::label('Home title', __('messages.vcard.home_title') . ':', ['class' => 'form-label']) }}
        {{ Form::text('home_title', isset($vcard) ? $vcard->home_title : null, ['class' => 'form-control', 'placeholder' => __('messages.form.home_title')]) }}
      </div>
      <div class="col-lg-6 mb-7">
        {{ Form::label('Meta keyword', __('messages.vcard.meta_keyword') . ':', ['class' => 'form-label']) }}
        {{ Form::text('meta_keyword', isset($vcard) ? $vcard->meta_keyword : null, ['class' => 'form-control', 'placeholder' => __('messages.form.meta_keyword')]) }}
      </div>
      <div class="col-lg-6 mb-7">
        {{ Form::label('Meta Description', __('messages.vcard.meta_description') . ':', ['class' => 'form-label']) }}
        {{ Form::text('meta_description', isset($vcard) ? $vcard->meta_description : null, ['class' => 'form-control', 'placeholder' => __('messages.form.meta_description')]) }}
      </div>
      <div class="col-lg-12 mb-7">
        {{ Form::label('Google Analytics', __('messages.vcard.google_analytics') . ':', ['class' => 'form-label']) }}
        {{ Form::textarea('google_analytics', isset($vcard) ? $vcard->google_analytics : null, ['class' => 'form-control', 'placeholder' => __('messages.form.google_analytics')]) }}
      </div>
      <div class="col-lg-12 d-flex">
        <button type="submit" class="btn btn-primary me-3">
          {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
@endif

@if ($partName == 'privacy-policy')
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="mb-5">
          <input type="hidden" name="part" value="{{ $partName }}" id="privacyPolicyPartName">
          {{ Form::hidden('id', isset($privacyPolicy) ? $privacyPolicy->id : null, ['id' => 'privacyPolicyId']) }}
          {{ Form::label('privacy_policy', __('messages.vcard.privacy_policy') . ':', ['class' => 'form-label required']) }}
          <div id="privacyPolicyQuill" class="editor-height" style="height: 200px"></div>
          {{ Form::hidden('privacy_policy', isset($privacyPolicy) ? $privacyPolicy->privacy_policy : null, ['id' => 'privacyData']) }}
        </div>
      </div>
      <div class="col-lg-12 d-flex">
        <button type="submit" class="btn btn-primary me-3" id="privacyPolicySave">
          {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif

@if ($partName == 'term-condition')
  <div class="container-fluid">
    <div class="row">
      <input type="hidden" name="part" value="{{ $partName }}" id="termConditionPartName">
      <div class="col-lg-12">
        <div class="mb-5">
          {{ Form::hidden('id', isset($termCondition) ? $termCondition->id : null, ['id' => 'termConditionId']) }}
          {{ Form::label('term_condition', __('messages.vcard.term_condition') . ':', ['class' => 'form-label required']) }}
          <div id="termConditionQuill" class="editor-height" style="height: 200px"></div>
          {{ Form::hidden('term_condition', isset($termCondition) ? $termCondition->term_condition : null, ['id' => 'conditionData']) }}
        </div>
      </div>
      <div class="col-lg-12 d-flex">
        <button type="submit" class="btn btn-primary me-3" id="termConditionSave">
          {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif
@if ($partName == 'qrcode-customize')
  <input type="hidden" name="part" value="{{ $partName }}" id="qrcodeCustmizePartName">
  <input type="hidden" name="vcard_id" value="{{ $vcard->id }}">
  <div class="container d-flex justify-content-center align-items-center pt-5 overflow-hidden" style="height: 75vh;">
    <div class="col-md-6">
      <div class="card shadow rounded-3">
        <div class="card-body">
          <div class="mb-3">
            {{ Form::label('QR-Code Color', __('messages.vcard.qrcode_color') . ':', ['class' => 'form-label']) }}
            {{ Form::color('qrcode_color', isset($customQrCode['qrcode_color']) ? $customQrCode['qrcode_color'] : null, ['class' => 'form-control form-control-color w-100 mb-3', 'id' => 'qrcode_color']) }}
          </div>
          <div class="mb-3">
            {{ Form::label('Background Color', __('messages.vcard.back_color') . ':', ['class' => 'form-label']) }}
            {{ Form::color('background_color', isset($customQrCode['background_color']) ? $customQrCode['background_color'] : null, ['class' => 'form-control form-control-color w-100 mb-3', 'id' => 'background_color']) }}
          </div>
          <div class="mb-3">
            <label for="exampleInputSelect2" class="form-label">{{ __('messages.vcard.qrcode_style') }}</label>
            @php
              $qrcodeStyle = collect(App\Models\QrcodeEdit::QRCODE_STYLE)->map(function ($value) {
                  return trans('messages.qr_code.' . $value);
              });
            @endphp
            {{ Form::select('style', $qrcodeStyle, isset($customQrCode['style']) ? $customQrCode['style'] : null, ['class' => 'form-control form-select', 'data-control' => 'select2', 'id' => 'qrcodeStyle', 'wire:ignore']) }}
          </div>
          <div class="mb-4">
            <label for="exampleInputSelect2" class="form-label">{{ __('messages.vcard.qrcode_eye_style') }}</label>
            @php
              $qrcodeEyeStyle = collect(App\Models\QrcodeEdit::QRCODE_EYE_STYLE)->map(function ($value) {
                  return trans('messages.qr_code.' . $value);
              });
            @endphp
            {{ Form::select('eye_style', $qrcodeEyeStyle, isset($customQrCode['eye_style']) ? $customQrCode['eye_style'] : null, ['class' => 'form-control form-select', 'data-control' => 'select2', 'id' => 'qrcodeEyeStyle', 'wire:ignore']) }}
          </div>
          <div class="form-check form-switch mb-4">
            <input class="form-check-input me-3" name="applySetting" type="checkbox" id="flexSwitchCheckChecked"
              {{ isset($customQrCode['applySetting']) ? ($customQrCode['applySetting'] == 1 ? 'checked' : '') : '' }}>
            <label class="form-label"
              for="flexSwitchCheckChecked">{{ __('messages.common.use_this_configuration') }}</label>
          </div>
          <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3" id="custmizationSave">
              {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
              class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

@if ($partName == 'manage-section')
  <div class="container mt-5">
    <div class="card shadow-lg rounded-4 p-5">
      <input type="hidden" name="part" value="{{ $partName }}">

      <div class="row mt-4">
        <div class="col-md-4 mb-5">
          <input id="headerCheckbox" class="form-check-input me-2" type="checkbox" value="1" name="header"
            checked disabled>
          <label class="form-check-label" for="headerCheckbox">{!! __('messages.vcard.header') !!}</label>
        </div>
        <div class="col-md-4 mb-5">
          <input id="contactListCheckbox" class="form-check-input me-2" type="checkbox" value="1"
            name="contact_list"
            {{ (isset($managesection) && $managesection['contact_list']) || empty($managesection) ? 'checked' : '' }}>
          <label class="form-check-label" for="contactListCheckbox">{!! __('messages.vcard.contact') !!}</label>
        </div>
        @if (checkFeature('services'))
          <div class="col-md-4 mb-5">
            <input id="servicesCheckbox" class="form-check-input me-2" type="checkbox" value="1"
              name="services"
              {{ (isset($managesection) && $managesection['services']) || empty($managesection) ? 'checked' : '' }}>
            <label class="form-check-label" for="servicesCheckbox">{!! __('messages.vcard.services') !!}</label>
          </div>
        @endif
        @if (checkFeature('gallery'))
          <div class="col-md-4 mb-5">
            <input id="galleriesCheckbox" class="form-check-input me-2" type="checkbox" value="1"
              name="galleries"
              {{ (isset($managesection) && $managesection['galleries']) || empty($managesection) ? 'checked' : '' }}>
            <label class="form-check-label" for="galleriesCheckbox">{!! __('messages.vcard.galleries') !!}</label>
          </div>
        @endif
        @if (checkFeature('products'))
          <div class="col-md-4 mb-5">
            <input id="productsCheckbox" class="form-check-input me-2" type="checkbox" value="1"
              name="products"
              {{ (isset($managesection) && $managesection['products']) || empty($managesection) ? 'checked' : '' }}>
            <label class="form-check-label" for="productsCheckbox">{!! __('messages.vcard.products') !!}</label>
          </div>
        @endif
        @if (checkFeature('testimonials'))
          <div class="col-md-4 mb-5">
            <input id="testimonialsCheckbox" class="form-check-input me-2" type="checkbox" value="1"
              name="testimonials"
              {{ (isset($managesection) && $managesection['testimonials']) || empty($managesection) ? 'checked' : '' }}>
            <label class="form-check-label" for="testimonialsCheckbox">{!! __('messages.vcard.testimonials') !!}</label>
          </div>
        @endif
        @if (checkFeature('blog'))
          <div class="col-md-4 mb-5">
            <input id="blogsCheckbox" class="form-check-input me-2" type="checkbox" value="1" name="blogs"
              {{ (isset($managesection) && $managesection['blogs']) || empty($managesection) ? 'checked' : '' }}>
            <label class="form-check-label" for="blogsCheckbox">{!! __('messages.vcard.blogs') !!}</label>
          </div>
        @endif
        <div class="col-md-4 mb-5">
          <input id="businessHoursCheckbox" class="form-check-input me-2" type="checkbox" value="1"
            name="business_hours"
            {{ (isset($managesection) && $managesection['business_hours']) || empty($managesection) ? 'checked' : '' }}>
          <label class="form-check-label" for="businessHoursCheckbox">{!! __('messages.vcard.business_hours') !!}</label>
        </div>
        @if (checkFeature('appointments'))
          <div class="col-md-4 mb-5">
            <input id="appointmentsCheckbox" class="form-check-input me-2" type="checkbox" value="1"
              name="appointments"
              {{ (isset($managesection) && $managesection['appointments']) || empty($managesection) ? 'checked' : '' }}>
            <label class="form-check-label" for="appointmentsCheckbox">{!! __('messages.vcard.appointments') !!}</label>
          </div>
        @endif
        <div class="col-md-4 mb-5">
          <input id="mapCheckbox" class="form-check-input me-2" type="checkbox" value="1" name="map"
            {{ (isset($managesection) && $managesection['map']) || empty($managesection) ? 'checked' : '' }}>
          <label class="form-check-label" for="mapCheckbox">{!! __('messages.vcard.map') !!}</label>
        </div>
        <div class="col-md-4 mb-5">
          <input id="bannerCheckbox" class="form-check-input me-2" type="checkbox" value="1" name="banner"
            {{ (isset($managesection) && $managesection['banner']) || empty($managesection) ? 'checked' : '' }}>
          <label class="form-check-label" for="bannerCheckbox">{!! __('messages.front_cms.banner_title') !!}</label>
        </div>
        @if (checkFeature('insta_embed'))
          <div class="col-md-4 mb-5">
            <input id="instaembedCheckbox" class="form-check-input me-2" type="checkbox" value="1"
              name="insta_embed"
              {{ (isset($managesection) && $managesection['insta_embed']) || empty($managesection) ? 'checked' : '' }}>
            <label class="form-check-label" for="instaembedCheckbox">{!! __('messages.feature.insta_embed') !!}</label>
          </div>
        @endif
        @if (checkFeature('linkedin_embed'))
          <div class="col-md-4 mb-5">
            <input id="linkedinembedCheckbox" class="form-check-input me-2" type="checkbox" value="1"
              name="linkedin_embed"
              {{ (isset($managesection) && $managesection['linkedin_embed']) || empty($managesection) ? 'checked' : '' }}>
            <label class="form-check-label" for="linkedinembedCheckbox">{!! __('messages.feature.linkedin_embed') !!}</label>
          </div>
        @endif
        @if (checkFeature('iframes'))
          <div class="col-md-4 mb-5">
            <input id="iframeCheckbox" class="form-check-input me-2" type="checkbox" value="1" name="iframe"
              {{ (isset($managesection) && $managesection['iframe']) || empty($managesection) ? 'checked' : '' }}>
            <label class="form-check-label" for="iframeCheckbox">{!! __('messages.vcard.iframe') !!}</label>
          </div>
        @endif
        <div class="col-md-4 mb-5">
          <input id="newsLatterPopupCheckbox" class="form-check-input me-2" type="checkbox" value="1"
            name="news_latter_popup"
            {{ (isset($managesection) && $managesection['news_latter_popup']) || empty($managesection) ? 'checked' : '' }}>
          <label class="form-check-label" for="newsLatterPopupCheckbox">{!! __('messages.vcard.newslatter_popup') !!}</label>
        </div>
      </div>
      <div class="text-center mt-5">
        <button type="submit" class="btn btn-primary me-2">{{ __('messages.common.save') }}</button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif

@if ($partName == 'dynamic_vcard')
  <input type="hidden" name="part" value="{{ $partName }}">
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-6 mb-5">
        <div class="row m-0">
          <div class="col-6 order-first text-md-start text-center mb-3">
            {{ Form::label('Primary Color', __('messages.vcard.primary_color') . ':', ['class' => 'form-label']) }}
            <div class="color-picker"></div>
            {{ Form::color('primary_color', isset($dynamicVcard['primary_color']) ? $dynamicVcard['primary_color'] : '#b8ff69', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto d-none', 'id' => 'primary_color']) }}
          </div>
          <div class="col-6 text-md-start text-center mb-3">
            {{ Form::label('Background Secondary color', __('messages.vcard.background_secondary_color') . ':', ['class' => 'form-label']) }}
            <div class="back-color-picker"></div>
            {{ Form::color('back_color', isset($dynamicVcard['back_color']) ? $dynamicVcard['back_color'] : '#224754', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto d-none', 'id' => 'back_color']) }}
          </div>
          <div class="col-6 text-md-start text-center mb-3">
            {{ Form::label('Background color', __('messages.vcard.background_color') . ':', ['class' => 'form-label']) }}
            <div class="back-seconds-color-picker"></div>
            {{ Form::color('back_seconds_color', isset($dynamicVcard['back_seconds_color']) ? $dynamicVcard['back_seconds_color'] : '#0f2f3a', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto d-none', 'id' => 'back_seconds_color']) }}
          </div>
          <div class="col-6 text-md-start text-center mb-3">
            {{ Form::label('Button Text Color', __('messages.vcard.button_text_color') . ':', ['class' => 'form-label']) }}
            <div class="button-text-color-picker"></div>
            {{ Form::color('button_text_color', isset($dynamicVcard['button_text_color']) ? $dynamicVcard['button_text_color'] : '#2d2624', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto d-none', 'id' => 'button_text_color']) }}
          </div>
          <div class="col-6 text-md-start text-center mb-3">
            {{ Form::label('Label Text Color', __('messages.vcard.label_text_color') . ':', ['class' => 'form-label']) }}
            <div class="text-label-color-picker"></div>
            {{ Form::color('text_label_color', isset($dynamicVcard['text_label_color']) ? $dynamicVcard['text_label_color'] : '#ffffff', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto d-none', 'id' => 'text_label_color']) }}
          </div>
          <div class="col-6 text-md-start text-center mb-3">
            {{ Form::label('Description Text Color', __('messages.vcard.description_text_color') . ':', ['class' => 'form-label']) }}
            <div class="text-description-color-picker"></div>
            {{ Form::color('text_description_color', isset($dynamicVcard['text_description_color']) ? $dynamicVcard['text_description_color'] : '#9facb0', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto d-none', 'id' => 'text_description_color']) }}
          </div>
          <div class="col-6 text-md-start text-center mb-3">
            {{ Form::label('Cards Background', __('messages.vcard.card_back') . ':', ['class' => 'form-label']) }}
            <div class="cards-back-color-picker"></div>
            {{ Form::color('cards_back', isset($dynamicVcard['cards_back']) ? $dynamicVcard['cards_back'] : '#ffffff', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto d-none', 'id' => 'cards_back']) }}
          </div>
          <div class="col-6 text-md-start text-center mb-3">
            {{ Form::label('Social Icon Color', __('messages.vcard.social_icon_color') . ':', ['class' => 'form-label']) }}
            <div class="social-icon-color-picker"></div>
            {{ Form::color('social_icon_color', isset($dynamicVcard['social_icon_color']) ? $dynamicVcard['social_icon_color'] : '#ffffff', ['class' => 'form-control form-control-color w-100 mb-3 mx-md-0 mx-auto d-none', 'id' => 'social_icon_color']) }}
          </div>
          <div class="col text-md-start text-center">
            {{ Form::label('Sticky button', __('messages.vcard.sticky_btn') . ':', ['class' => 'form-label']) }}
            <div class="col">
              <label class="button-label mx-2 mb-3">
                <input type="radio" name="sticky_bar" class="sticky-btn btn btn-secondary"
                  value="0"{{ isset($dynamicVcard['sticky_bar']) && $dynamicVcard['sticky_bar'] == 0 ? 'checked' : '' }}>
                <span class="sticky-btn-title">{{ __('messages.vcard.left') }}</span>
              </label>
              <label class="button-label mx-2">
                <input type="radio" name="sticky_bar" class="sticky-btn btn btn-secondary"
                  value="1"{{ empty($dynamicVcard) || $dynamicVcard['sticky_bar'] == 1 ? 'checked' : '' }}>
                <span class="sticky-btn-title">{{ __('messages.vcard.right') }}</span>
              </label>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col text-md-start text-center">
              {{ Form::label('Button Styles', __('messages.vcard.button_style') . ':', ['class' => 'form-label']) }}
              <div class="col">
                <label class="button-label mx-2 button-style mt-2">
                  <input type="radio" name="button_style" class="btn btn-secondary button-style" value="1"
                    {{ empty($dynamicVcard) || $dynamicVcard['button_style'] == 1 ? 'checked' : '' }}>
                  <span class="button-style-one btn btn-secondary">{{ __('messages.vcard.style_1') }}</span>
                </label>
                <label class="button-label mx-2 mb-3 button-style mt-2">
                  <input type="radio" name="button_style" class="btn btn-secondary rouned-0 button-style"
                    value="2"{{ isset($dynamicVcard['button_style']) && $dynamicVcard['button_style'] == 2 ? 'checked' : '' }}>
                  <span class="button-style-two btn btn-secondary">{{ __('messages.vcard.style_2') }}</span>
                </label>
                <label class="button-label mx-2 button-style mt-2">
                  <input type="radio" name="button_style" class="btn btn-secondary button-style"
                    value="3"{{ isset($dynamicVcard['button_style']) && $dynamicVcard['button_style'] == 3 ? 'checked' : '' }}>
                  <span class="button-style-three btn btn-secondary">{{ __('messages.vcard.style_3') }}</span>
                </label>
                <label class="button-label mx-2 button-style mt-2">
                  <input type="radio" name="button_style" class="btn btn-secondary button-style"
                    value="4"{{ isset($dynamicVcard['button_style']) && $dynamicVcard['button_style'] == 4 ? 'checked' : '' }}>
                  <span class="button-style-four btn btn-secondary">{{ __('messages.vcard.style_4') }}</span>
                </label>
                <label class="button-label mx-2 button-style mt-2">
                  <input type="radio" name="button_style" class="btn btn-secondary button-style"
                    value="5"{{ isset($dynamicVcard['button_style']) && $dynamicVcard['button_style'] == 5 ? 'checked' : '' }}>
                  <span class="button-style-five btn">{{ __('messages.vcard.style_5') }}</span>
                </label>
                <label class="button-label mx-2 button-style mt-2">
                  <input type="radio" name="button_style" class="btn btn-secondary button-style"
                    value="6"{{ isset($dynamicVcard['button_style']) && $dynamicVcard['button_style'] == 6 ? 'checked' : '' }}>
                  <span class="button-style-six btn">{{ __('messages.vcard.style_6') }}</span>
                </label>
                <label class="button-label mx-2 button-style mt-5">
                  <input type="radio" name="button_style" class="btn btn-secondary button-style" value="7"
                    {{ isset($dynamicVcard['button_style']) && $dynamicVcard['button_style'] == 7 ? 'checked' : '' }}>
                  <span class="button-style-seven btn">{{ __('messages.vcard.style_7') }}</span>
                </label>
                <label class="button-label mx-2 button-style mt-5">
                  <input type="radio" name="button_style" class="btn btn-secondary button-style" value="8"
                    {{ isset($dynamicVcard['button_style']) && $dynamicVcard['button_style'] == 8 ? 'checked' : '' }}>
                  <span class="button-style-eight btn">{{ __('messages.vcard.style_8') }}</span>
                </label>
                <label class="button-label mx-2 button-style mt-5">
                  <input type="radio" name="button_style" class="btn btn-secondary button-style" value="9"
                    {{ isset($dynamicVcard['button_style']) && $dynamicVcard['button_style'] == 9 ? 'checked' : '' }}>
                  <span class="button-style-nine btn">{{ __('messages.vcard.style_9') }}</span>
                </label>
                <label class="button-label mx-2 button-style mt-5">
                  <input type="radio" name="button_style" class="btn btn-secondary button-style" value="10"
                    {{ isset($dynamicVcard['button_style']) && $dynamicVcard['button_style'] == 10 ? 'checked' : '' }}>
                  <span class="button-style-ten">{{ __('messages.vcard.style_10') }}</span>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-5 mt-5">
        <div class="dynamic-vcard">
          @include('vcards.dynamic')
        </div>
      </div>
    </div>
    <div class="col-lg-12 mt-5">
      <div class="col-lg-12 d-flex">
        <button type="submit" class="btn btn-primary me-3" id="dynamicColorSave" data-turbo="false">
          {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif
