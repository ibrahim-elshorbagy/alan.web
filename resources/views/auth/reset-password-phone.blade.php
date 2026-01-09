@extends('layouts.auth')
@section('title')
  {{ __('messages.common.reset_password') }}
@endsection
@section('content')
  <div class="register-section bg-white overflow-hidden position-relative h-100">
    <div class="top-vector">
      <img src="{{ asset('assets/images/top-vector.png') }}">
    </div>
    <div class="bottom-vector">
      <img src="{{ asset('assets/images/bottom-vector.png') }}">
    </div>
    <div class="row">
      <div class="col-md-6 col-12 p-0 d-none">
        <div class="register-img d-sm-block d-none">
          <img src="{{ asset($registerImage) }}" alt="Register Image" class="w-100 h-100">
        </div>
      </div>
      <div class="col-md-12 col-12 p-0 d-flex flex-column justify-content-center register-section"
        @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                getLanguageByKey(checkFrontLanguageSession()) == 'Persian') dir="rtl" @endif>
        <div class="register-form">
          <div class="px-sm-10 px-6 mb-5  h-100 w-100">
            <div class="text-center d-flex justify-content-center align-items-center login-app-name">
              <div class="image image-mini me-3">
                <a href="{{ route('home') }}" class="image">
                  <img alt="Logo" src="{{ getLogoUrl() }}" class="img-fluid"
                    style="width: 100px; height: 100px; object-fit: contain;">
                </a>
              </div>
              <span class="text-gray-900 fs-1 fw-bold">{{ getAppName() }}</span>
            </div>
            <div class="row element mt-4">
              <div class="col-md-12 width-540 mx-auto">
                @include('flash::message')
                @include('layouts.errors')
              </div>
              <h1 class="text-center mb-7 fs-2 fw-bold">{{ __('messages.verify_phone.reset_password_title') }}
              </h1>
              <p class="text-center mb-4 text-muted">
                {{ __('messages.verify_phone.reset_password_subtitle') }}
              </p>
              <form method="POST" action="{{ route('password.phone.update') }}" id="resetPasswordForm">
                @csrf
                <div class="row">
                  <div class="col-md-12 mb-4">
                    <label for="password" class="form-label">
                      {{ __('messages.common.new_password') . ':' }}<span class="required"></span>
                    </label>
                    <div class="mb-3 position-relative">
                      <input type="password" name="password" class="form-control" id="password" required
                        placeholder="{{ __('messages.common.new_password') }}" data-toggle="password">
                      <span
                        class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                        <i class="bi bi-eye-slash-fill"></i>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-12 mb-4">
                    <label for="password_confirmation" class="form-label">
                      {{ __('messages.common.confirm_password') . ':' }}<span class="required"></span>
                    </label>
                    <div class="mb-3 position-relative">
                      <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                        required placeholder="{{ __('messages.common.confirm_password') }}" data-toggle="password">
                      <span
                        class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                        <i class="bi bi-eye-slash-fill"></i>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-12 mb-4">
                    <button type="submit" class="btn register-btn px-10 w-100" id="resetBtn">
                      {{ __('messages.verify_phone.reset_password_button') }}
                    </button>
                  </div>
                  <div class="col-md-12 text-center">
                    <p class="text-muted mb-2">{{ __('messages.common.remember_password') }}</p>
                    <a href="{{ route('login') }}" class="btn btn-link p-0 text-decoration-none">
                      {{ __('messages.common.login') }}
                    </a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('resetPasswordForm');
      const passwordInput = document.getElementById('password');
      const confirmPasswordInput = document.getElementById('password_confirmation');
      const resetBtn = document.getElementById('resetBtn');
      const messageDiv = document.querySelector('#resetPasswordForm .text-center .alert') ||
        document.createElement('div');
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Create message div if it doesn't exist
      if (!document.querySelector('#resetPasswordForm .text-center .alert')) {
        const container = document.querySelector('#resetPasswordForm .col-md-12.mb-4');
        messageDiv.className = 'alert text-center mt-2';
        messageDiv.style.display = 'none';
        container.appendChild(messageDiv);
      }

      // Show message helper
      const showMessage = (message, isSuccess) => {
        const alertClass = isSuccess ? 'alert-success' : 'alert-danger';
        messageDiv.className = `alert ${alertClass} text-center`;
        messageDiv.textContent = message;
        messageDiv.style.display = 'block';
      };

      // Hide message
      const hideMessage = () => {
        messageDiv.style.display = 'none';
      };

      // Handle form submission
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        hideMessage();

        // Validate passwords match
        if (passwordInput.value !== confirmPasswordInput.value) {
          showMessage('{{ __('messages.placeholder.password_mismatch') }}', false);
          return;
        }

        resetBtn.disabled = true;
        resetBtn.textContent = '{{ __('messages.verify_phone.resetting') }}';

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
              'X-CSRF-TOKEN': csrfToken
            }
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              showMessage(data.message, true);
              setTimeout(() => window.location.href = data.redirect, 1500);
            } else {
              if (data.redirect) {
                window.location.href = data.redirect;
              } else {
                showMessage(data.message || '{{ __('messages.verify_phone.invalid_code') }}', false);
              }
              resetBtn.disabled = false;
              resetBtn.textContent = '{{ __('messages.verify_phone.reset_password_button') }}';
            }
          })
          .catch(() => {
            showMessage('{{ __('messages.verify_phone.verification_failed') }}', false);
            resetBtn.disabled = false;
            resetBtn.textContent = '{{ __('messages.verify_phone.reset_password_button') }}';
          });
      });
    });
  </script>
@endpush
