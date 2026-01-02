<?php ?>
@if ($partName == 'basics')
  @if (isset($whatsappStore))
    {!! Form::open([
        'route' => ['whatsapp.stores.update', $whatsappStore->id],
        'method' => 'post',
        'files' => 'true',
    ]) !!}
  @endif
  <input type="hidden" name="part" value="{{ $partName }}">
  <div class="container-fluid">
    <div class="row" id="basic">
      <div class="col-lg-6 mb-7">
        {{ Form::label('url_alias', __('messages.whatsapp_stores.store_unique_alias') . ':', ['class' => 'form-label required']) }}
        <div class="d-sm-flex">
          <div class="input-group">
            {{ Form::text('url_alias', isset($whatsappStore) ? $whatsappStore->url_alias : null, [
                'class' => 'form-control ms-1 vcard-url-alias',
                'id' => 'vcard-url-alias',
                'placeholder' => __('messages.whatsapp_stores.store_unique_alias'),
            ]) }}
            <button class="btn btn-secondary" type="button" id="generate-url-alias">
              <i class="fa-solid fa-arrows-rotate"></i>
            </button>
          </div>
        </div>
        <div id="error-url-alias-msg" class="text-danger ms-2 fs-6 d-none fw-light">
          {{ __('messages.vcard.already_alias_url') }}
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        {{ Form::label('store_name', __('messages.whatsapp_stores.store_name') . ':', ['class' => 'form-label required']) }}
        {{ Form::text('store_name', isset($whatsappStore) ? $whatsappStore->store_name : null, ['class' => 'form-control ', 'placeholder' => __('messages.whatsapp_stores.store_name'), 'required']) }}
      </div>
      <div class="col-lg-6">
        <div class="form-group  mb-7">
          {{ Form::label('whatsapp_no', __('messages.whatsapp_stores.whatsapp_no') . ':', ['class' => 'form-label required']) }}
          {{ Form::text('whatsapp_no', isset($whatsappStore) ? (isset($whatsappStore->region_code) ? '+' . $whatsappStore->region_code . '' . $whatsappStore->whatsapp_no : $whatsappStore->whatsapp_no) : null, ['class' => 'form-control', 'placeholder' => __('messages.whatsapp_stores.whatsapp_no'), 'id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
          {{ Form::hidden('region_code', isset($whatsappStore) ? $whatsappStore->region_code : null, ['id' => 'prefix_code']) }}
          <div class="mt-2">
            <span id="valid-msg"
              class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.valid_number') }}</span>
            <span id="error-msg" class="text-danger d-none fw-400 fs-small mt-2">Invalid
              Number</span>
          </div>
        </div>
      </div>

      <div class="col-lg-6 mb-7">
        <div class="d-flex">
          {{ Form::label('default_language', __('messages.setting.default_language') . ':', ['class' => 'form-label']) }}
        </div>
        <div class="form-group">
          {{ Form::select('default_language', getAllLanguage(), isset($whatsappStore) ? (isset($whatsappStore->default_language) ? $whatsappStore->default_language : getCurrentLanguageName()) : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
        </div>
      </div>

      <div class="col-lg-6 mb-7">
        {{ Form::label('address', __('messages.setting.address') . ':', ['class' => 'form-label required']) }}
        {{ Form::textarea('address', isset($whatsappStore) ? $whatsappStore->address : null, ['class' => 'form-control ', 'placeholder' => __('messages.setting.address'), 'required', 'rows' => 4]) }}
      </div>

      <div class="col-lg-6 pt-7">
        <div class="card shadow p-4">
          <label for="qrCodeDownloadSize" class="form-label fw-semibold">
            {{ __('messages.vcard.qr_code_download_size') }}
          </label>
          <div class="d-flex align-items-center">
            <input type="range" name="qr_code_download_size" class="form-range w-75 mx-2"
              value="{{ $whatsappStore->qr_code_download_size ?? 200 }}" min="100" max="500" step="100"
              id="qrCodeDownloadSize" oninput="document.getElementById('download-result').innerText = this.value+'px'">
            <span id="download-result" class="fw-bold">{{ $whatsappStore->qr_code_download_size ?? 200 . 'px' }}</span>
          </div>
        </div>
      </div>


      <div class="col-lg-3">
        <div class="form-check  mb-7">
          <input id="newsLetterPopupCheckbox" class="form-check-input me-2" type="checkbox" value="1"
            name="news_letter_popup"
            {{ isset($whatsappStore->news_letter_popup) && $whatsappStore->news_letter_popup ? 'checked' : '' }}>
          <label class="form-check-label" for="newsLetterPopupCheckbox">{!! __('messages.vcard.newslatter_popup') !!}</label>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="form-check  mb-7">
          <input id="businessHoursCheckbox" class="form-check-input me-2" type="checkbox" value="1"
            name="business_hours"
            {{ isset($whatsappStore->business_hours) && $whatsappStore->business_hours ? 'checked' : '' }}>
          <label class="form-check-label" for="businessHoursCheckbox">{!! __('messages.vcard.business_hours') !!}</label>
        </div>
      </div>


      <div class="col-lg-3">
        <div class="form-check  mb-7">
          <input id="enableDownloadQrCheckbox" class="form-check-input me-2" type="checkbox" value="1"
            name="enable_download_qr_code"
            {{ isset($whatsappStore->enable_download_qr_code) && $whatsappStore->enable_download_qr_code ? 'checked' : '' }}>
          <label class="form-check-label" for="enableDownloadQrCheckbox">{!! __('messages.vcard.display_download_qr_icon') !!}</label>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="form-check  mb-7">
          <input id="hideStickybarCheckbox" class="form-check-input me-2" type="checkbox" value="1"
            name="hide_stickybar"
            {{ isset($whatsappStore->hide_stickybar) && $whatsappStore->hide_stickybar ? 'checked' : '' }}>
          <label class="form-check-label" for="hideStickybarCheckbox">{!! __('messages.setting.hide_whatsapp_stickybar') !!}</label>
        </div>
      </div>



      <div class="col-lg-3 col-sm-6 mb-7">
        <div class="mb-3" io-image-input="true">
          <label for="exampleInputImage"
            class="form-label required">{{ __('messages.vcard.cover_image') . ':' }}</label>
          <span data-bs-toggle="tooltip" data-placement="top"
            data-bs-original-title="{{ __('messages.tooltip.app_logo') }}">
            <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
          </span>
          <div class="d-block">
            <div class="images-picker">
              <div class="image previewImage" id="coverPreview"
                style="background-image: url('{{ !empty($whatsappStore->cover_url) ? $whatsappStore->cover_url : '' }}');">
              </div>
              <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                data-placement="top" data-bs-original-title="{{ __('messages.tooltip.cover') }}">
                <label>
                  <i class="fa-solid fa-pen click-image" id="profileImageIcon"></i>
                  <input type="file" id="coverImg" name="cover_img" class="d-none" accept="image/*, video/*"
                    data-preview-id="whatsappStoreCoverPreview" />
                </label>
              </span>
            </div>
          </div>
          <!-- Image Paste Component -->
          <div data-image-paste data-file-input-id="coverImg" data-preview-id="coverPreview"
            data-button-text="{{ __('messages.select_image') }}"
            data-clipboard-button-text="{{ __('messages.paste_from_clipboard') }}"
            data-success-text="{{ __('messages.image_pasted_successfully') }}"
            data-invalid-type-text="{{ __('messages.invalid_image_type') }}"
            data-image-too-large-text="{{ __('messages.image_too_large') }}"
            data-no-image-text="{{ __('messages.no_image_in_clipboard') }}">
          </div>
        </div>
        <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
      </div>



      <div class="col-lg-3 col-sm-6 mb-7">
        <div class="mb-3" io-image-input="true">
          <label for="exampleInputImage" class="form-label required">{{ __('messages.nfc.logo') . ':' }}</label>
          <span data-bs-toggle="tooltip" data-placement="top"
            data-bs-original-title="{{ __('messages.tooltip.app_logo') }}">
            <i class="fas fa-question-circle ml-1 general-question-mark"></i>
          </span>
          <div class="d-block">
            <div class="image-picker">
              <div class="image previewImage" id="exampleInputImage"
                style="background-image: url('{{ !empty($whatsappStore->logo_url) ? $whatsappStore->logo_url : '' }}')">
              </div>
              <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                data-placement="top" data-bs-original-title="{{ __('messages.whatsapp_stores.change_logo') }}">
                <label>
                  <i class="fa-solid fa-pen"></i>
                  <input type="file" id="logo" name="logo" class="image-upload d-none" accept="image/*"
                    data-preview-id="whatsappStoreLogoPreview" />
                </label>
              </span>
            </div>
          </div>
          <!-- Image Paste Component -->
          <div data-image-paste data-file-input-id="logo" data-preview-id="exampleInputImage"
            data-button-text="{{ __('messages.select_image') }}"
            data-clipboard-button-text="{{ __('messages.paste_from_clipboard') }}"
            data-success-text="{{ __('messages.image_pasted_successfully') }}"
            data-invalid-type-text="{{ __('messages.invalid_image_type') }}"
            data-image-too-large-text="{{ __('messages.image_too_large') }}"
            data-no-image-text="{{ __('messages.no_image_in_clipboard') }}">
          </div>
        </div>
        <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
      </div>

      <div class="col-lg-6 mb-7">
        {{ Form::label('slider_video_banner', __('messages.whatsapp_stores.slider_video_banner') . ':', ['class' => 'form-label']) }}
        {{ Form::text('slider_video_banner', isset($whatsappStore) ? $whatsappStore->slider_video_banner : null, ['class' => 'form-control ', 'placeholder' => __('messages.whatsapp_stores.enter_youtube_video_link')]) }}
      </div>

      <div class="d-flex">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'vcardSaveBtn']) }}
        <a href="{{ route('whatsapp.stores') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>

  {{ Form::close() }}
@endif

@if ($partName == 'whatsapp-template')
  <input type="hidden" id="whatsappStoreId" value="{{ $whatsappStore->id }}">
  <div class="container-fluid">
    <div class="col-lg-12 mb-3">
      <input type="hidden" name="part" value="{{ $partName }}">
      <label class="form-label required">{{ __('messages.vcard.select_template') }}
        :</label>
    </div>
    <div class="row">
      @php
        $templateNames = [
            1 => 'Beauty Product',
            2 => 'E-Commerce',
            3 => 'Restaurant',
            4 => 'Grocery',
            5 => 'Cloth Store',
            6 => 'Home Decor',
            7 => 'Jewellery',
            8 => 'Travel',
        ];
      @endphp
      @foreach ($templates as $id => $url)
        <div class="col-12 col-md-6">
          <div class="form-group mb-7">
            <input type="hidden" name="template_id" id="themeInput" value="{{ $whatsappStore->template_id }}"
              id="themeInput">
            <div class="theme-img-radio img-thumbnail {{ $whatsappStore->template_id == $id ? 'img-border' : '' }}"
              data-id="{{ $id }}">
              <img src="{{ asset($url) }}" alt="Template" loading="lazy">
              <div class="whatsapp-store-template-name">{{ $templateNames[$id] }}</div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="col-lg-12 mt-2 d-flex">
      <button class="btn btn-primary me-3 wp-template-save">
        {{ __('messages.common.save') }}
      </button>
      <a href="{{ route('whatsapp.stores') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
  </div>
@endif

@if ($partName === 'business-hours')
  @php
    $hours = [];
    $businessHours = $whatsappStore->businessHours;
    foreach ($businessHours as $hour) {
        $hours[$hour->day_of_week] = [
            'start_time' => $hour->start_time,
            'end_time' => $hour->end_time,
        ];
    }
  @endphp
  <div class="container-fluid">
    <div class="row">
      <input type="hidden" name="part" value="{{ $partName }}">
      <input type="hidden" id="whatsappStoreId" value="{{ $whatsappStore->id }}">
      <div class="col-lg-3 mb-3">
        {{ Form::label('week_format', __('messages.week_format_type.week_format_type') . ':', ['class' => 'form-label']) }}
        @php
          $weekFormatOptions = collect(App\Models\BusinessHour::WEEK_FORMAT_TYPE)->map(function ($value) {
              return trans('messages.week_format_type.' . $value);
          });
        @endphp
        {{ Form::select('week_format', $weekFormatOptions, $whatsappStore->week_format ?? 1, ['class' => 'form-select', 'id' => 'week_format', 'data-control' => 'select2']) }}
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
                    <i class="bi bi-moon mx-2"></i>
                    <span>{{ __('messages.common.closed') }}</span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
      <div class="col-lg-12 mt-4 d-flex">
        <button class="btn btn-primary me-3 wp-business-hours-save">{{ __('messages.common.save') }}</button>
        <a href="{{ route('whatsapp.stores') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif


@if ($partName == 'order-details')
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
      <div class="row">
        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
          <label for="name"
            class="pb-2 fs-4 text-gray-600">{{ __('messages.whatsapp_stores.order_id') }}:</label>
          <span class="fs-4 text-gray-800">{{ $wpOrder->order_id }}</span>
        </div>
        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
          <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.mail.name') }}</label>
          <span class="fs-4 text-gray-800">{{ $wpOrder->name }}</span>
        </div>
        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
          <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.phone') }}:</label>
          <span class="fs-4 text-gray-800" dir="ltr"
            style='{{ getCurrentLanguageName() == 'ar' || getCurrentLanguageName() == 'fa' ? 'margin-right: 0px; margin-left: auto;"' : '' }}'>+{{ $wpOrder->region_code }}
            {{ $wpOrder->phone }}</span>
        </div>


        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
          <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.setting.address') }}:</label>
          <span class="fs-4 text-gray-800">{{ $wpOrder->address }}</span>
        </div>
        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
          <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.vcard.order_at') }}:</label>
          <span class="fs-4 text-gray-800">
            {{ getFormattedDateTime($wpOrder->created_at) }}
          </span>
        </div>
      </div>
    </div>
  </div>
@endif

@if ($partName == 'advanced')
  <input type="hidden" id="whatsappStoreId" value="{{ $whatsappStore->id }}">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 mb-7">
        {{ Form::label('custom_css', __('messages.vcard.custom_css') . ':', ['class' => 'form-label']) }}
        {{ Form::textarea('custom_css', isset($whatsappStore) ? $whatsappStore->custom_css : null, ['class' => 'form-control', 'placeholder' => __('messages.form.css'), 'rows' => '5']) }}
      </div>

      <div class="col-lg-12 mb-7">
        {{ Form::label('custom_js', __('messages.vcard.custom_js') . ':', ['class' => 'form-label']) }}
        {{ Form::textarea('custom_js', isset($whatsappStore) ? $whatsappStore->custom_js : null, ['class' => 'form-control', 'placeholder' => __('messages.form.js'), 'rows' => '5']) }}
      </div>
      <div class="col-lg-12 d-flex">
        <button type="submit" class="btn btn-primary me-3 wp-template-advance-save">
          {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('whatsapp.stores') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif

@if ($partName == 'custom-fonts')
  <input type="hidden" id="whatsappStoreId" value="{{ $whatsappStore->id }}">
  <div class="container-fluid">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6 mb-7">
          {{ Form::label('font_family', __('messages.font.font_family') . ':', ['class' => 'form-label']) }}
          {{ Form::select('font_family', \App\Models\WhatsappStore::FONT_FAMILY, $whatsappStore->font_family, [
              'class' => 'form-select',
              'data-control' => 'select2',
          ]) }}
        </div>
        <div class="col-lg-6 mb-7">
          {!! Form::label('font_size', __('messages.font.font_size') . ':', ['class' => 'form-label']) !!}

          {!! Form::number('font_size', $whatsappStore->font_size, [
              'class' => 'form-control',
              'min' => '14',
              'max' => '40',
              'placeholder' => __('messages.font.font_size_in_px'),
          ]) !!}
        </div>
        <div class="col-lg-12 d-flex">
          <button type="submit" class="btn btn-primary me-3 wp-template-custom-font-save">
            {{ __('messages.common.save') }}
          </button>
          <a href="{{ route('whatsapp.stores') }}"
            class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
      </div>
    </div>
@endif

@if ($partName == 'seo')
  <input type="hidden" id="whatsappStoreId" value="{{ $whatsappStore->id }}">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6 mb-7">
        {{ Form::label('Site title', __('messages.vcard.site_title') . ':', ['class' => 'form-label']) }}
        <div class="input-group">
          {{ Form::text('site_title', isset($whatsappStore) ? $whatsappStore->site_title : null, ['name' => 'site_title', 'class' => 'form-control', 'placeholder' => __('messages.form.site_title'), 'id' => 'wpSiteTitleInput']) }}
          <button class="btn btn-primary" type="button" id="generateAiWpSiteTitle">
            <i class="bi bi-stars"></i>
            <span class="spinner-border spinner-border-sm d-none ms-2" id="wpSiteTitleSpinner" role="status">
              <span class="visually-hidden">Loading...</span>
            </span>
          </button>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        {{ Form::label('Home title', __('messages.vcard.home_title') . ':', ['class' => 'form-label']) }}
        <div class="input-group">
          {{ Form::text('home_title', isset($whatsappStore) ? $whatsappStore->home_title : null, ['name' => 'home_title', 'class' => 'form-control', 'placeholder' => __('messages.form.home_title'), 'id' => 'wpHomeTitleInput']) }}
          <button class="btn btn-primary" type="button" id="generateAiWpHomeTitle">
            <i class="bi bi-stars"></i>
            <span class="spinner-border spinner-border-sm d-none ms-2" id="wpHomeTitleSpinner" role="status">
              <span class="visually-hidden">Loading...</span>
            </span>
          </button>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        {{ Form::label('Meta keyword', __('messages.vcard.meta_keyword') . ':', ['class' => 'form-label']) }}
        <div class="input-group">
          {{ Form::text('meta_keyword', isset($whatsappStore) ? $whatsappStore->meta_keyword : null, ['name' => 'meta_keyword', 'class' => 'form-control', 'placeholder' => __('messages.form.meta_keyword'), 'id' => 'wpMetaKeywordInput']) }}
          <button class="btn btn-primary" type="button" id="generateAiWpMetaKeyword">
            <i class="bi bi-stars"></i>
            <span class="spinner-border spinner-border-sm d-none ms-2" id="wpMetaKeywordSpinner" role="status">
              <span class="visually-hidden">Loading...</span>
            </span>
          </button>
        </div>
      </div>
      <div class="col-lg-6 mb-7">
        {{ Form::label('Meta Description', __('messages.vcard.meta_description') . ':', ['class' => 'form-label']) }}
        <div class="input-group">
          {{ Form::text('meta_description', isset($whatsappStore) ? $whatsappStore->meta_description : null, ['name' => 'meta_description', 'class' => 'form-control', 'placeholder' => __('messages.form.meta_description'), 'id' => 'wpMetaDescriptionInput']) }}
          <button class="btn btn-primary" type="button" id="generateAiWpMetaDescription">
            <i class="bi bi-stars"></i>
            <span class="spinner-border spinner-border-sm d-none ms-2" id="wpMetaDescriptionSpinner" role="status">
              <span class="visually-hidden">Loading...</span>
            </span>
          </button>
        </div>
      </div>
      <div class="col-lg-12 mb-7">
        {{ Form::label('Google Analytics', __('messages.vcard.google_analytics') . ':', ['class' => 'form-label']) }}
        {{ Form::textarea('google_analytics', isset($whatsappStore) ? $whatsappStore->google_analytics : null, ['name' => 'google_analytics', 'class' => 'form-control', 'placeholder' => __('messages.form.google_analytics')]) }}
      </div>
      <div class="col-lg-12 d-flex">
        <button type="submit" class="btn btn-primary me-3 wp-template-seo-save">
          {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('whatsapp.stores') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif

@if ($partName == 'trending-video')
  <input type="hidden" id="whatsappStoreId" value="{{ $whatsappStore->id }}">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        {{ Form::label('YouTube Links', __('messages.whatsapp_stores.youtube_links') . ':', ['class' => 'form-label pt-3']) }}
      </div>
      <div>
        <button type="button" class="btn btn-success youtube-links"
          data-whatsapp-store-id="{{ $whatsappStore->id }}">
          {{ __('messages.common.add') }}
        </button>
      </div>
    </div>

    <!-- Add row wrapper -->
    <div class="row youtube-links-add">
      @if ($whatsappStore->trendingVideo->count() > 0)
        @foreach ($whatsappStore->trendingVideo as $key => $video)
          <div class="col-lg-6 mb-3 youtube-links-div">
            <div class="d-flex">
              <div class="d-flex w-100">
                <input type="text" class="form-control youtube_links" name="youtube_links[{{ $key }}]"
                  value="{{ $video->youtube_link }}"
                  placeholder="{{ __('messages.whatsapp_stores.enter_youtube_video_link') }}">
                <input type="hidden" name="youtube_link_id[{{ $key }}]" class="youtubeLinkId"
                  value="{{ $video->id }}">
                <a href="javascript:void(0)" title="{{ __('messages.common.delete') }}"
                  class="btn px-1 text-danger fs-3 youtube-links-delete-btn">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      @else
        <div class="col-lg-6 mb-3 youtube-links-div">
          <div class="d-flex">
            <div class="d-flex w-100">
              <input type="text" class="form-control youtube_links" name="youtube_links[]"
                placeholder="{{ __('messages.whatsapp_stores.enter_youtube_video_link') }}">
              <input type="hidden" name="youtube_link_id[]" class="youtubeLinkId" value="">
              <a href="javascript:void(0)" title="{{ __('messages.common.delete') }}"
                class="btn px-1 text-danger fs-3 youtube-links-delete-btn">
                <i class="fa-solid fa-trash"></i>
              </a>
            </div>
          </div>
        </div>
      @endif
    </div>

    <div class="mt-3">
      <button type="button" class="btn btn-primary youtube_link_save"
        data-whatsapp-store-id="{{ $whatsappStore->id }}">
        {{ __('messages.common.save') }}
      </button>
    </div>
  </div>
@endif

@if ($partName == 'terms-conditions')
  <input type="hidden" id="whatsappStoreId" value="{{ $whatsappStore->id }}">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 mb-7">
        {{ Form::hidden('id', isset($termCondition) ? $termCondition->id : null, ['id' => 'termConditionId']) }}
        <div class="d-flex justify-content-between align-items-center mb-2">
          {{ Form::label('term_condition', __('messages.vcard.term_condition') . ':', ['class' => 'form-label required mb-0']) }}
          <button type="button" class="btn btn-sm btn-primary" id="generateAiWhatsappTermsConditions">
            <i class="bi bi-stars"></i> {{ __('messages.whatsapp_stores.generate_terms_conditions_with_ai') }}
          </button>
        </div>
        <div class="mb-3">
          {{ Form::label('terms_conditions_description', __('messages.whatsapp_stores.ai_description_prompt') . ':', ['class' => 'form-label']) }}
          {{ Form::textarea('terms_conditions_description', null, ['id' => 'termsConditionsAiDescription', 'class' => 'form-control', 'placeholder' => __('messages.whatsapp_stores.describe_your_business'), 'rows' => 2]) }}
        </div>
        {{ Form::textarea('term_condition', isset($termCondition) ? $termCondition->term_condition : null, ['id' => 'whatsappTermsConditionsDescription', 'class' => 'form-control summernote']) }}
      </div>
      <div class="col-lg-12 mb-7">
        {{ Form::hidden('id', isset($privacyPolicy) ? $privacyPolicy->id : null, ['id' => 'privacyPolicyId']) }}
        <div class="d-flex justify-content-between align-items-center mb-2">
          {{ Form::label('privacy_policy', __('messages.vcard.privacy_policy') . ':', ['class' => 'form-label required mb-0']) }}
          <button type="button" class="btn btn-sm btn-primary" id="generateAiWhatsappPrivacyPolicy">
            <i class="bi bi-stars"></i> {{ __('messages.whatsapp_stores.generate_privacy_policy_with_ai') }}
          </button>
        </div>
        <div class="mb-3">
          {{ Form::label('privacy_policy_description', __('messages.whatsapp_stores.ai_description_prompt') . ':', ['class' => 'form-label']) }}
          {{ Form::textarea('privacy_policy_description', null, ['id' => 'privacyPolicyAiDescription', 'class' => 'form-control', 'placeholder' => __('messages.whatsapp_stores.describe_your_business'), 'rows' => 2]) }}
        </div>
        {{ Form::textarea('privacy_policy', isset($privacyPolicy) ? $privacyPolicy->privacy_policy : null, ['id' => 'whatsappPrivacyPolicyDescription', 'class' => 'form-control summernote']) }}
      </div>
      <div class="col-lg-12 mb-7">
        {{ Form::hidden('id', isset($refundCancellation) ? $refundCancellation->id : null, ['id' => 'refundCancellationId']) }}
        <div class="d-flex justify-content-between align-items-center mb-2">
          {{ Form::label('refund_cancellation', __('messages.vcard.refund_cancellation_policy') . ':', ['class' => 'form-label required mb-0']) }}
          <button type="button" class="btn btn-sm btn-primary" id="generateAiWhatsappRefundCancellation">
            <i class="bi bi-stars"></i> {{ __('messages.whatsapp_stores.generate_refund_policy_with_ai') }}
          </button>
        </div>
        <div class="mb-3">
          {{ Form::label('refund_cancellation_description', __('messages.whatsapp_stores.ai_description_prompt') . ':', ['class' => 'form-label']) }}
          {{ Form::textarea('refund_cancellation_description', null, ['id' => 'refundCancellationAiDescription', 'class' => 'form-control', 'placeholder' => __('messages.whatsapp_stores.describe_your_business'), 'rows' => 2]) }}
        </div>
        {{ Form::textarea('refund_cancellation', isset($refundCancellation) ? $refundCancellation->refund_cancellation_policy : null, ['id' => 'whatsappRefundCancellationDescription', 'class' => 'form-control summernote']) }}
      </div>
      <div class="col-lg-12 mb-7">
        {{ Form::hidden('id', isset($shippingDelivery) ? $shippingDelivery->id : null, ['id' => 'shippingDeliveryId']) }}
        <div class="d-flex justify-content-between align-items-center mb-2">
          {{ Form::label('shipping_delivery', __('messages.vcard.shipping_delivery_policy') . ':', ['class' => 'form-label required mb-0']) }}
          <button type="button" class="btn btn-sm btn-primary" id="generateAiWhatsappShippingDelivery">
            <i class="bi bi-stars"></i> {{ __('messages.whatsapp_stores.generate_shipping_delivery_with_ai') }}
          </button>
        </div>
        <div class="mb-3">
          {{ Form::label('shipping_delivery_description', __('messages.whatsapp_stores.ai_description_prompt') . ':', ['class' => 'form-label']) }}
          {{ Form::textarea('shipping_delivery_description', null, ['id' => 'shippingDeliveryAiDescription', 'class' => 'form-control', 'placeholder' => __('messages.whatsapp_stores.describe_your_business'), 'rows' => 2]) }}
        </div>
        {{ Form::textarea('shipping_delivery', isset($shippingDelivery) ? $shippingDelivery->shipping_delivery_policy : null, ['id' => 'whatsappShippingDeliveryDescription', 'class' => 'form-control summernote']) }}
      </div>
      <div class="col-lg-12 d-flex">
        <button type="submit" class="btn btn-primary me-3 wp-template-terms-conditions-save">
          {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('whatsapp.stores') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>
@endif

