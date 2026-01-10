@extends('layouts.auth2')
@section('title')
  {{ __('messages.common.register') }}
@endsection
@section('content')
  <div class="register-section bg-white overflow-hidden position-relative min-vh-100"
    style="background-image: url('{{ asset($registerImage) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <div class="d-flex align-items-center justify-content-center min-vh-100 p-3 p-md-4"
      @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
              getLanguageByKey(checkFrontLanguageSession()) == 'Persian') dir="rtl" @endif style="position: relative;">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-11 col-sm-9 col-md-6 col-lg-5 col-xl-4">

            <div class="text-center mb-3 mb-md-3">
              <div class="d-flex flex-column justify-content-center align-items-center logo-container">
                <div class="mb-3">
                  <a href="{{ route('home') }}">
                    <img alt="Logo" src="{{ getLogoUrl() }}" class="img-fluid"
                      style="width: 100px; height: 100px; object-fit: contain;">
                  </a>
                </div>
              </div>
            </div>

            <div class="bg-white p-4 p-sm-5 modern-register-card"
              style="border-radius: 24px !important; max-width: 500px; margin: 0 auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.2) inset; border: 1px solid rgba(0, 0, 0, 0.05);">

              @include('flash::message')
              @include('layouts.errors')

              <form method="POST"
                action="{{ request()->input('referral-code') ? route('register') . '?referral-code=' . request()->input('referral-code') : route('register') }}"
                id="UserRegisterForm" class="form-horizontal" @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                        getLanguageByKey(checkFrontLanguageSession()) == 'Persian') dir="rtl" @endif>
                @csrf

                <div class="row pt-2">
                  <div class="col-md-6 mb-4">
                    <label for="formInputFirstName" class="form-label fw-semibold mb-2"
                      style="color: #374151; font-size: 14px;">
                      {{ __('messages.user.first_name') }}:<span class="required"></span>
                    </label>
                    <input name="first_name" type="text"
                      class="form-control modern-input @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                              getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"
                      id="first_name" placeholder="{{ __('messages.user.first_name') }}" aria-describedby="firstName"
                      value="{{ old('first_name') }}" required
                      style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;">
                  </div>
                  <div class="col-md-6 mb-4">
                    <label for="last_name" class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
                      {{ __('messages.user.last_name') }}:<span class="required"></span>
                    </label>
                    <input name="last_name" type="text"
                      class="form-control modern-input @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                              getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"
                      id="last_name" placeholder="{{ __('messages.user.last_name') }}" aria-describedby="lastName"
                      value="{{ old('last_name') }}" required
                      style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;">
                  </div>
                </div>

                <div class="mb-4">
                  <label class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
                    {{ __('messages.common.register_with_email_or_phone') }}
                  </label>
                  <div class="d-flex gap-3">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="register_type" id="register_email"
                        value="email" checked>
                      <label class="form-check-label" for="register_email">
                        {{ __('messages.user.email') }}
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="register_type" id="register_phone"
                        value="phone">
                      <label class="form-check-label" for="register_phone">
                        {{ __('messages.common.phone') }}
                      </label>
                    </div>
                  </div>
                </div>

                <div id="email-field" class="mb-4">
                  <label for="email" class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
                    {{ __('messages.user.email') }}:<span class="required"></span>
                  </label>
                  <input name="email" type="email"
                    class="form-control modern-input @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                            getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"
                    id="email" aria-describedby="email" placeholder="{{ __('messages.user.email') }}"
                    value="{{ old('email') }}" required
                    style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;">
                  <span id="email-error-msg"
                    class="text-danger fw-400 fs-small mt-2 @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                            getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"></span>
                </div>

                <div id="phone-field" class="mb-4" style="display: none;">
                  <label for="contact" class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
                    {{ __('messages.common.phone') }}:<span class="required"></span>
                  </label>
                  <input type="tel" name="contact" id="contact"
                    class="form-control modern-input @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                            getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"
                    placeholder="962 XXX XXXX" value="{{ old('contact') }}" pattern="^(962)7[789]\d{7}$"
                    title="يرجى إدخال رقم هاتف أردني صالح يبدأ بـ 962"
                    style="padding: 8px 13px; padding-left: 50px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease; background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJDMTMuMSAyIDE0IDIuOSAxNCA0VjE2QzE0IDE3LjEgMTMuMSAxOCA5IDE4VjE2QzQuOSAxNiA0IDE1LjEgNCAxNFY0QzQgMi45IDQuOSAyIDYgMkgxOFoiIGZpbGw9IiM2MzY2RjEiLz4KPHN2ZyB4PSI2IiB5PSI2IiB3aWR0aD0iMTIiIGhlaWdodD0iMTIiIHZpZXdCb3g9IjAgMCAxMiAxMiIgZmlsbD0ibm9uZSI+Cjx0ZXh0IHg9IjAiIHk9IjEwIiBmb250LXNpemU9IjEwIiBmaWxsPSIjNjM2NkYxIj5KTzwvdGV4dD4KPHN2Zz4KPHN2Zz4K'); background-repeat: no-repeat; background-position: 10px center;">

                  <div class="fv-plugins-message-container invalid-feedback"></div>
                </div>


                <div class="mb-4">
                  <label for="password" class="form-label fw-semibold mb-2" style="color: #374151; font-size: 14px;">
                    {{ __('messages.user.password') }}:<span class="required"></span>
                  </label>
                  <div class="position-relative">
                    <input type="password" name="password"
                      class="form-control modern-input @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                              getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"
                      id="password" placeholder="{{ __('messages.user.password') }}" aria-describedby="password"
                      required aria-label="Password" data-toggle="password"
                      style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;">
                    <span
                      class="position-absolute top-50 @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                              getLanguageByKey(checkFrontLanguageSession()) == 'Persian') start-0 ms-3 @else end-0 me-3 @endif translate-middle-y text-muted input-icon input-password-hide cursor-pointer modern-eye-btn"
                      style="color: #a0aec0; padding: 8px; border-radius: 8px; transition: all 0.3s ease;">
                      <i class="bi bi-eye-slash-fill"></i>
                    </span>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="password_confirmation" class="form-label fw-semibold mb-2"
                    style="color: #374151; font-size: 14px;">
                    {{ __('messages.user.confirm_password') }}:<span class="required"></span>
                  </label>
                  <div class="position-relative">
                    <input name="password_confirmation" type="password"
                      class="form-control modern-input @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                              getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"
                      placeholder="{{ __('messages.user.confirm_password') }}" id="password_confirmation"
                      aria-describedby="confirmPassword" required aria-label="Password" data-toggle="password"
                      style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;">
                    <span
                      class="position-absolute top-50 @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                              getLanguageByKey(checkFrontLanguageSession()) == 'Persian') start-0 ms-3 @else end-0 me-3 @endif translate-middle-y text-muted input-icon input-password-hide cursor-pointer modern-eye-btn"
                      style="color: #a0aec0; padding: 8px; border-radius: 8px; transition: all 0.3s ease;">
                      <i class="bi bi-eye-slash-fill"></i>
                    </span>
                  </div>
                </div>

                @if (!request()->has('referral-code'))
                  @if (getSuperAdminSettingValue('show_referral_code'))
                    <div class="mb-4">
                      <label for="referral_code" class="form-label fw-semibold mb-2"
                        style="color: #374151; font-size: 14px;">
                        {{ __('messages.user.referral_code') }}:
                      </label>
                      <input name="referral_code" type="text"
                        class="form-control modern-input @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                                getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"
                        id="referral_code" placeholder="{{ __('messages.user.referral_code') }}"
                        aria-describedby="referralCode" value="{{ old('referral_code') }}"
                        style="padding: 8px 13px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease;">
                    </div>
                  @endif
                @endif

                <div class="mb-4">
                  <label
                    class="modern-checkbox d-flex align-items-start @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                            getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"
                    style="cursor: pointer; user-select: none;">
                    <input type="checkbox" name="term_policy_check"
                      class="modern-checkbox-input @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                              getLanguageByKey(checkFrontLanguageSession()) == 'Persian') float-end @else float-start @endif"
                      id="privacyPolicyCheckbox" placeholder required
                      style="opacity: 0; position: absolute; pointer-events: none;">
                    <span class="checkbox-design @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                            getLanguageByKey(checkFrontLanguageSession()) == 'Persian') ms-3 @else me-3 @endif"
                      style="width: 20px; height: 20px; border: 2px solid #e2e8f0; border-radius: 6px; background: #ffffff; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; position: relative; flex-shrink: 0; margin-top: 2px;"></span>
                    <span class="form-check-label"
                      style="color: #4a5568; font-size: 13px; font-weight: 500; line-height: 1.5;">
                      @lang('messages.by_signing_up_you_agree_to_our')
                      <a href="{{ route('terms.conditions') }}" target="_blank" class="modern-link"
                        style="color: #667eea; text-decoration: none; font-weight: 600;">{!! __('messages.vcard.term_condition') !!}</a>
                      &
                      <a href="{{ route('privacy.policy') }}" target="_blank" class="modern-link"
                        style="color: #667eea; text-decoration: none; font-weight: 600;">{{ __('messages.vcard.privacy_policy') }}</a>
                    </span>
                  </label>
                </div>

                @if (getSuperAdminSettingValue('captcha_enable'))
                  <div class="mb-4 @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                          getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif">
                    @if (getRecaptchaVersion() == 1)
                      <div class="g-recaptcha @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                              getLanguageByKey(checkFrontLanguageSession()) == 'Persian') text-end @else text-start @endif"
                        data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                      <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    @else
                      <input type="hidden" name="g-recaptcha-response" id="recaptcha-token">
                      <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" async defer>
                      </script>
                      <script>
                        document.addEventListener("DOMContentLoaded", function() {
                          grecaptcha.ready(function() {
                            grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
                              action: 'submit'
                            }).then(function(token) {
                              document.getElementById('recaptcha-token').value = token;
                            });
                          });
                        });
                      </script>
                    @endif
                  </div>
                @endif

                <div class="mb-3 mb-md-3">
                  <button type="submit" class="btn w-100 text-white fw-bold border-0 modern-register-btn"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);">
                    {{ __('messages.common.register') }}
                  </button>
                </div>

                <div class="text-center p-3"
                  style="background: rgba(102, 126, 234, 0.05); border-radius: 12px; border: 1px solid rgba(102, 126, 234, 0.1);">
                  <span class="text-muted"
                    style="font-size: 15px;">{{ __('messages.common.already_have_an_account') }}? </span>
                  <a href="{{ route('login') }}" class="modern-link"
                    style="color: #667eea; text-decoration: none; font-weight: 700; font-size: 15px;">
                    {{ __('messages.common.sign_in_here') }}
                  </a>
                </div>
              </form>
            </div>

            <div class="text-center mt-3 mt-md-3 copy-right">
              <div class="copyright text-black" style="font-size: 14px;">
                {{ __('messages.placeholder.all_rights_reserve') }} &copy; {{ date('Y') }}
                <a href="{{ route('home') }}" class="font-weight-bold ms-1" target="_blank"
                  style="color: #667eea; text-decoration: none;">{{ getAppName() }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const emailRadio = document.getElementById('register_email');
    const phoneRadio = document.getElementById('register_phone');
    const emailField = document.getElementById('email-field');
    const phoneField = document.getElementById('phone-field');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('contact');

    function toggleFields() {
      if (emailRadio.checked) {
        emailField.style.display = 'block';
        phoneField.style.display = 'none';
        emailInput.required = true;
        phoneInput.required = false;
        phoneInput.value = ''; // Clear phone if switching
      } else {
        emailField.style.display = 'none';
        phoneField.style.display = 'block';
        emailInput.required = false;
        phoneInput.required = true;
        emailInput.value = ''; // Clear email if switching
      }
    }

    emailRadio.addEventListener('change', toggleFields);
    phoneRadio.addEventListener('change', toggleFields);

    // Initial state
    toggleFields();
  });
</script>
