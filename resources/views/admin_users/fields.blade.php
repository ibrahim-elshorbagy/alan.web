<div class="row">
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::hidden('is_admin', true) }}
      {{ Form::label('first_name', __('messages.user.first_name') . ':', ['class' => 'form-label required']) }}
      {{ Form::text('first_name', isset($user) ? $user->first_name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.first_name'), 'required', 'id' => 'userFirstName']) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('last_name', __('messages.user.last_name') . ':', ['class' => 'form-label required']) }}
      {{ Form::text('last_name', isset($user) ? $user->last_name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.last_name'), 'required', 'id' => 'userLastName']) }}
    </div>
  </div>
  <div class="col-lg-6 mb-5">
    {{ Form::label('email', __('messages.user.email') . ':', ['class' => 'form-label required']) }}
    {{ Form::email('email', isset($user) ? $user->email : null, ['class' => 'form-control check-email', 'placeholder' => __('messages.form.mail'), 'required']) }}
    <input type="hidden" id="originalEmail" value="{{ isset($user) ? $user->email : '' }}">
    <span id="email-error-msg" class="text-danger fw-400 fs-small mt-2"></span>
  </div>
  <div class="col-lg-6">
    <label for="contact" class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
      {{ __('messages.user.contact_no') }}:
    </label>
    <input type="tel" name="contact" id="contact"
      class="form-control modern-input @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
              getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"
      placeholder="962 XXX XXXX" value="{{ isset($user) ? $user->contact : old('contact') }}"
      pattern="^(962)[1-9]\d{8}$" title="يرجى إدخال رقم هاتف أردني صالح يبدأ بـ 962 غير متبوع ب 0"
      style="padding: 8px 13px; padding-left: 50px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease; background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJDMTMuMSAyIDE0IDIuOSAxNCA0VjE2QzE0IDE3LjEgMTMuMSAxOCA5IDE4VjE2QzQuOSAxNiA0IDE1LjEgNCAxNFY0QzQgMi45IDQuOSAyIDYgMkgxOFoiIGZpbGw9IiM2MzY2RjEiLz4KPHN2ZyB4PSI2IiB5PSI2IiB3aWR0aD0iMTIiIGhlaWdodD0iMTIiIHZpZXdCb3g9IjAgMCAxMiAxMiIgZmlsbD0ibm9uZSI+Cjx0ZXh0IHg9IjAiIHk9IjEwIiBmb250LXNpemU9IjEwIiBmaWxsPSIjNjM2NkYxIj5KTzwvdGV4dD4KPHN2Zz4KPHN2Zz4K'); background-repeat: no-repeat; background-position: 10px center;">
    <div class="fv-plugins-message-container invalid-feedback"></div>
  </div>
  <div class="col-lg-6 mb-5">
    {{ Form::label('role',  __('messages.admin.role'). ':', ['class' => 'form-label required']) }}
    {{ Form::select('role', ['super_admin' => __('messages.admin.super_admin'), 'sales' => __('messages.admin.sales')], isset($user) ? $user->getRoleNames()->first() : old('role'), ['class' => 'form-control', 'required']) }}
  </div>
  @if (!isset($user))
    <div class="col-lg-6 mb-5">
      <label class="form-label required">{{ __('messages.user.password') . ':' }}</label>
      <div class="mb-3 position-relative">
        <input class="form-control" id="password" type="password" name="password"
          placeholder="{{ __('messages.form.password') }}" autocomplete="off" required aria-label="Password"
          data-toggle="password" />
        <span
          class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
          <i class="bi bi-eye-slash-fill"></i>
        </span>
      </div>
    </div>

    <div class="col-lg-6 mb-5">
      <label class="form-label required">{{ __('messages.user.confirm_password') . ':' }}</label>
      <div class="mb-3 position-relative">
        <input class="form-control " id="cPassword" type="password" placeholder="{{ __('messages.form.c_password') }}"
          name="password_confirmation" autocomplete="off" required aria-label="Password" data-toggle="password" />
        <span
          class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
          <i class="bi bi-eye-slash-fill"></i>
        </span>
      </div>
    </div>
  @endif
  <div class="mb-3" io-image-input="true">
    <label for="exampleInputImage" class="form-label">{{ __('auth.app.profile') . ':' }}</label>
    <span data-bs-toggle="tooltip" data-placement="top"
      data-bs-original-title="{{ __('messages.tooltip.profile_img') }}">
      <i class="fas fa-question-circle ml-1 general-question-mark"></i>
    </span>
    <div class="d-block">
      <div class="image-picker">
        <div class="image previewImage" id="exampleInputImage"
          style="background-image: url('{{ !empty($user->profile_image) ? $user->profile_image : asset('web/media/avatars/user.png') }}')">
        </div>
        <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip" data-placement="top"
          data-bs-original-title="{{ __('messages.tooltip.profile') }}">
          <label>
            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
            <input type="file" id="profile_image" name="profile"
              class="image-upload file-validation d-none crop-image-input" accept="image/*" data-crop-width="100"
              data-crop-height="100" data-preview-id="adminUserProfilePreview" />
          </label>
        </span>
      </div>
      <div class="form-text">{{ __('messages.allowed_file_types') }}</div>
    </div>
  </div>
  <div>
    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
    <a href="{{ route('admins.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
  </div>
</div>
