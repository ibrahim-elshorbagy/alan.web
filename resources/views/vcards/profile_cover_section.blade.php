@if ($partName == 'profile-cover')
  @if (isset($vcard))
    <input type="hidden" id="vcardId" value="{{ $vcard->id }}">
  @endif
  <input type="hidden" name="part" value="{{ $partName }}">
  <div class="container-fluid mt-5">
    <div class="row" id="profile-cover">
      {{ Form::hidden('default_language', app()->getLocale()) }}

      <div class="col-12 mb-5">
        <h3 class="mb-4">{{ __('messages.images') }}</h3>
      </div>

      <!-- Cover Type Selection -->
      <div class="col-lg-4 mb-7">
        <div class="form-group">
          {{ Form::label('cover_type', __('messages.cover_type.cover_type') . ':', ['class' => 'form-label']) }}
          @php
            $coverType = collect(App\Models\Vcard::COVER_TYPE)->map(function ($value) {
                return trans('messages.cover_type.' . $value);
            });
          @endphp
          {{ Form::select('cover_type', $coverType, isset($vcard) ? $vcard->cover_type : null, ['class' => 'form-select cover-type', 'id' => 'coverType', 'data-control' => 'select2']) }}
        </div>
      </div>

      <!-- Cover Image Display Type -->
      <div class="col-lg-4 mb-7">
        <div class="form-group">
          {{ Form::label('cover_image_type', __('messages.cover_image_type.cover_image_type') . ':', ['class' => 'form-label']) }}
          @php
            $coverImageType = collect(App\Models\Vcard::COVER_IMAGE_TYPE)->map(function ($value) {
                return trans('messages.cover_image_type.' . $value);
            });
          @endphp
          {{ Form::select('cover_image_type', $coverImageType, isset($vcard) ? $vcard->cover_image_type : null, ['class' => 'form-select', 'id' => 'cover_image_type', 'data-control' => 'select2']) }}
        </div>
      </div>

      <div class="col-12"></div>

      <!-- Cover Image Section -->
      <div class="col-lg-12 mb-7 cover-imgs">
        <div class="mb-3">
          <label class="form-label">{{ __('messages.vcard.cover_img') . ':' }}</label>
          <span data-bs-toggle="tooltip" data-placement="top"
            data-bs-original-title="{{ __('messages.tooltip.vcard_cover_img') }}">
            <i class="fas fa-question-circle ml-1 general-question-mark"></i>
          </span>

          <!-- Cover Image Source Selection -->
          <div class="mb-4 mt-3">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="cover_image_source" id="predefinedCover"
                value="predefined"
                {{ isset($vcard) && !empty($vcard->cover_url) && str_contains($vcard->cover_url, 'cover_images') ? 'checked' : '' }}>
              <label class="form-check-label" for="predefinedCover">
                {{ __('messages.cover_image.predefined_images') }}
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="cover_image_source" id="customCover" value="custom"
                {{ isset($vcard) && !empty($vcard->cover_url) && !str_contains($vcard->cover_url, 'cover_images') ? 'checked' : '' }}>
              <label class="form-check-label" for="customCover">
                {{ __('messages.common.custom') }}
              </label>
            </div>
          </div>

          <!-- Predefined Images Gallery  - Full Width -->
          <div id="predefinedImages" class="mb-4"
            style="{{ isset($vcard) && !empty($vcard->cover_url) && str_contains($vcard->cover_url, 'cover_images') ? '' : 'display: none;' }}">
            <div class="card shadow-sm p-4">
              <h5 class="mb-4">{{ __('messages.cover_image.select_cover_image') }}</h5>
              <div class="row g-4">
                @php
                  $coverImages = \App\Models\CoverImage::where('status', true)->get();
                @endphp
                @forelse($coverImages as $image)
                  <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div
                      class="cover-image-option {{ isset($vcard) && $vcard->cover_url == $image->image_url ? 'selected' : '' }}"
                      data-url="{{ $image->image_url }}">
                      <img src="{{ $image->image_url }}" alt="{{ $image->name }}" class="img-fluid rounded"
                        style="cursor: pointer; border: 3px solid transparent; transition: all 0.3s;">
                      <p class="text-center mt-2 small">{{ $image->name }}</p>
                    </div>
                  </div>
                @empty
                  <div class="col-12 text-center">
                    <p class="text-muted">{{ __('messages.cover_image.no_cover_images') }}</p>
                  </div>
                @endforelse
              </div>
            </div>
            <input type="hidden" name="selected_cover_image" id="selectedCoverImage"
              value="{{ isset($vcard) && !empty($vcard->cover_url) && str_contains($vcard->cover_url, 'cover_images') ? $vcard->cover_url : '' }}">
          </div>

          <!-- Custom Upload -->
          <div id="customUpload" io-image-input="true"
            style="{{ isset($vcard) && !empty($vcard->cover_url) && !str_contains($vcard->cover_url, 'cover_images') ? '' : 'display: none;' }}">
            <div class="d-block">
              <div class="images-picker">
                <div class="image previewImage" id="coverPreview"
                  style="background-image: url('{{ !empty($vcard->cover_url) && in_array(pathinfo($vcard->cover_url, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? $vcard->cover_url : asset('assets/images/default_cover_image.jpg') }}');">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                  data-placement="top" data-bs-original-title="{{ __('messages.tooltip.cover') }}">
                  <label>
                    <i class="fa-solid fa-pen click-image" id="profileImageIcon"></i>
                    <input type="file" id="coverImg" name="cover_img" class="d-none" accept="image/*"
                      data-preview-id="coverPreview" />
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
        <div class="form-text">{{ __('messages.allowed_img_types') }}</div>
      </div>

      <!-- Cover Video Section -->
      <div class="col-lg-6 mb-7 cover-video d-none">
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

      <!-- YouTube Link -->
      <div class="col-lg-6 mb-7 d-none cover_youtube_link">
        {{ Form::label('youtube_link', __('messages.cover_type.youtube_link') . ':', ['class' => 'form-label fs-6 text-gray-700 mb-3']) }}
        {{ Form::text('youtube_link', isset($vcard) ? $vcard->youtube_link : null, ['class' => 'form-control', 'placeholder' => 'https://www.youtube.com/watch?v=hAGbufevHM4']) }}
      </div>

      <!-- Profile Image Section -->
      <div class="col-lg-4 mb-7">
        <div class="mb-3" io-image-input="true">
          <label for="exampleInputImage" class="form-label">{{ __('messages.vcard.profile_image') . ':' }}</label>
          <span data-bs-toggle="tooltip" data-placement="top"
            data-bs-original-title="{{ __('messages.tooltip.vcard_profile_img') }}">
            <i class="fas fa-question-circle ml-1 general-question-mark"></i>
          </span>
          <div class="d-block">
            <div class="image-picker">
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
        <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
      </div>

      <!-- Favicon Section -->
      <div class="col-lg-4 mb-7">
        <div class="mb-3" io-image-input="true">
          <label for="exampleInputImage" class="form-label">{{ __('messages.vcard.favicon_image') . ':' }}</label>
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
        <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
      </div>

      <div class="col-12"></div>

      <div class="d-flex">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'vcardSaveBtn']) }}
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
      </div>
    </div>
  </div>

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
      var currentCoverUrl = '{{ isset($vcard) ? $vcard->cover_url : '' }}';
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
