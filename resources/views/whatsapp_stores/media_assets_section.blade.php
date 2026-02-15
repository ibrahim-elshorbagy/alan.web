@if ($partName == 'media-assets')
  @if (isset($whatsappStore))
    {!! Form::open([
        'route' => ['whatsapp.stores.update', $whatsappStore->id],
        'method' => 'post',
        'files' => 'true',
    ]) !!}
    <input type="hidden" name="part" value="{{ $partName }}">
  @endif

  <div class="container-fluid mt-5">
    <div class="row" id="media-assets">

      <div class="col-12 mb-5">
        <h3 class="mb-4">{{ __('messages.images') }}</h3>
      </div>

      <!-- Cover Image Section - Full Width -->
      <div class="col-lg-12 mb-7">
        <div class="mb-3">
          <label class="form-label required">{{ __('messages.vcard.cover_image') . ':' }}</label>

          <span data-bs-toggle="tooltip" data-placement="top"
            data-bs-original-title="{{ __('messages.tooltip.cover_selection') }}">
            <i class="fas fa-question-circle ml-1 general-question-mark"></i>
          </span>

          <!-- Cover Image Source Selection -->

          <div class="mb-4 mt-3">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="cover_image_source" id="predefinedCover"
                value="predefined"
                {{ isset($whatsappStore) && !empty($whatsappStore->cover_url) && str_contains($whatsappStore->cover_url, 'cover_images') ? 'checked' : '' }}>
              <label class="form-check-label" for="predefinedCover">
                {{ __('messages.cover_image.predefined_images') }}
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="cover_image_source" id="customCover" value="custom"
                {{ isset($whatsappStore) && !empty($whatsappStore->cover_url) && !str_contains($whatsappStore->cover_url, 'cover_images') ? 'checked' : '' }}>
              <label class="form-check-label" for="customCover">
                {{ __('messages.common.custom') }}
              </label>
            </div>
          </div>

          <!-- Predefined Images Gallery - Full Width -->
          <div id="predefinedImages" class="mb-4"
            style="{{ isset($whatsappStore) && !empty($whatsappStore->cover_url) && str_contains($whatsappStore->cover_url, 'cover_images') ? '' : 'display: none;' }}">
            <div class="card shadow-sm p-4">
              <h5 class="mb-4">{{ __('messages.cover_image.select_cover_image') }}</h5>
              @php
                $coverImages = \App\Models\CoverImage::where('status', 1)->get();
              @endphp
              @if ($coverImages->count() > 0)
                <div class="row g-4">
                  @foreach ($coverImages as $image)
                    <div class="col-lg-4 col-md-6 col-12">
                      <div
                        class="cover-image-option {{ isset($whatsappStore) && $whatsappStore->cover_url == $image->image_url ? 'selected' : '' }}"
                        data-url="{{ $image->image_url }}">
                        <img src="{{ $image->image_url }}" alt="Cover Image" class="img-fluid rounded"
                          style="cursor: pointer; border: 3px solid transparent; transition: all 0.3s;">
                      </div>
                    </div>
                  @endforeach
                </div>
              @else
                <p class="text-muted text-center">{{ __('messages.cover_image.no_cover_images') }}</p>
              @endif
            </div>
            <input type="hidden" name="selected_cover_image" id="selectedCoverImage"
              value="{{ isset($whatsappStore) && !empty($whatsappStore->cover_url) && str_contains($whatsappStore->cover_url, 'cover_images') ? $whatsappStore->cover_url : '' }}">
          </div>

          <!-- Custom Upload -->
          <div id="customUpload"
            style="{{ isset($whatsappStore) && !empty($whatsappStore->cover_url) && !str_contains($whatsappStore->cover_url, 'cover_images') ? '' : 'display: none;' }}">
            <div class="d-block">
              <div class="images-picker" style="width: 100%; max-width: 600px;">
                <div class="image previewImage" id="coverPreview"
                  style="background-image: url('{{ !empty($whatsappStore->cover_url) ? $whatsappStore->cover_url : '' }}'); width: 100%; height: 200px; background-size: contain; background-position: center;">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                  data-placement="top" data-bs-original-title="{{ __('messages.tooltip.cover') }}">
                  <label>
                    <i class="fa-solid fa-pen"></i>
                    <input type="file" id="coverImg" name="cover_img" class="d-none" accept="image/*"
                      data-preview-id="whatsappStoreCoverPreview" />
                  </label>
                </span>
              </div>
              <div data-image-paste data-file-input-id="coverImg" data-preview-id="coverPreview"
                data-button-text="{{ __('messages.select_image') }}"
                data-clipboard-button-text="{{ __('messages.paste_from_clipboard') }}"
                data-success-text="{{ __('messages.image_pasted_successfully') }}"
                data-invalid-type-text="{{ __('messages.invalid_image_type') }}"
                data-image-too-large-text="{{ __('messages.image_too_large') }}"
                data-no-image-text="{{ __('messages.no_image_in_clipboard') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
      </div>

      <!-- Logo Section -->
      <div class="col-lg-4 mb-7">
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

      <!-- Slider Video Banner -->
      <div class="col-lg-8 mb-7">
        {{ Form::label('slider_video_banner', __('messages.whatsapp_stores.slider_video_banner') . ':', ['class' => 'form-label']) }}
        <span data-bs-toggle="tooltip" data-placement="top"
          data-bs-original-title="{{ __('messages.whatsapp_stores.enter_youtube_video_link') }}">
          <i class="fas fa-question-circle ml-1 general-question-mark"></i>
        </span>
        {{ Form::text('slider_video_banner', isset($whatsappStore) ? $whatsappStore->slider_video_banner : null, ['class' => 'form-control', 'placeholder' => __('messages.whatsapp_stores.enter_youtube_video_link')]) }}
      </div>

      <div class="col-12"></div>

      <div class="d-flex">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
        <a href="{{ route('whatsapp.stores') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>

  @if (isset($whatsappStore))
    {{ Form::close() }}
  @endif

  <style>
    .cover-image-option {
      cursor: pointer;
      transition: all 0.3s;
    }

    .cover-image-option:hover img {
      border-color: #007bff !important;
      transform: scale(1.05);
    }

    .cover-image-option.selected img {
      border-color: #007bff !important;
      box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }
  </style>

  <script>
    $(document).ready(function() {
      // Handle cover image source selection
      $('input[name="cover_image_source"]').change(function() {
        if ($(this).val() === 'predefined') {
          $('#predefinedImages').show();
          $('#customUpload').hide();
          $('#selectedCoverImage').val('');
        } else {
          $('#predefinedImages').hide();
          $('#customUpload').show();
          $('#selectedCoverImage').val('');
        }
      });

      // Handle predefined image selection
      $('.cover-image-option').click(function() {
        $('.cover-image-option').removeClass('selected').find('img').css('border', '3px solid transparent');
        $(this).addClass('selected').find('img').css('border', '3px solid #007bff');
        $('#selectedCoverImage').val($(this).data('url'));
        $('#predefinedCover').prop('checked', true);
        $('#customCover').prop('checked', false);
        $('#predefinedImages').show();
        $('#customUpload').hide();
      });

      // Highlight selected predefined image on load
      var currentCoverUrl = '{{ $whatsappStore->cover_url ?? '' }}';
      if (currentCoverUrl && currentCoverUrl.includes('cover_images')) {
        $('.cover-image-option').each(function() {
          if ($(this).data('url') === currentCoverUrl) {
            $(this).addClass('selected').find('img').css('border', '3px solid #007bff');
            $('#selectedCoverImage').val(currentCoverUrl);
          }
        });
      }
    });
  </script>
@endif
