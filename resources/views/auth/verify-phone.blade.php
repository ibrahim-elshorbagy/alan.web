@extends('layouts.auth')
@section('title')
  {{ __('messages.common.verify_phone') }}
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
              <h1 class="text-center mb-7 fs-2 fw-bold">{{ __('messages.verify_phone.title') }}
              </h1>
              <p class="text-center mb-4 text-muted">
                {{ __('messages.verify_phone.subtitle') }}
                <strong>{{ session('phone_number') ?: session('password_reset_phone') }}</strong>
              </p>
              <form method="POST" action="{{ route('phone.verify') }}" id="verifyPhoneForm">
                @csrf
                <div class="row">
                  <div class="col-md-12 mb-4">
                    <label for="code" class="form-label">
                      {{ __('messages.verify_phone.enter_code') . ':' }}<span class="required"></span>
                    </label>
                    <input type="text" name="code" class="form-control" id="code"
                      placeholder="{{ __('messages.verify_phone.code_placeholder') }}" maxlength="6" pattern="[0-9]{6}"
                      required style="text-align: center; font-size: 24px; letter-spacing: 8px;">
                    <span class="text-muted fs-small mt-1 d-block">{{ __('messages.verify_phone.enter_code') }}</span>
                    <div id="verification-message" class="mt-2 text-center"></div>
                  </div>
                  <div class="col-md-12 mb-4">
                    <button type="submit" class="btn register-btn px-10 w-100" id="verifyBtn">
                      {{ __('messages.verify_phone.verify_button') }}
                    </button>
                  </div>
                  <div class="col-md-12 text-center">
                    <p class="text-muted mb-2">{{ __('messages.verify_phone.didnt_receive_code') }}</p>
                    <button type="button" id="resendCode" class="btn btn-link p-0 text-decoration-none">
                      {{ __('messages.verify_phone.resend_code') }}
                    </button>
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
      const form = document.getElementById('verifyPhoneForm');
      const codeInput = document.getElementById('code');
      const verifyBtn = document.getElementById('verifyBtn');
      const resendBtn = document.getElementById('resendCode');
      const messageDiv = document.getElementById('verification-message');
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      codeInput.focus();

      // Show message helper
      const showMessage = (message, isSuccess) => {
        const alertClass = isSuccess ? 'alert-success' : 'alert-danger';
        messageDiv.innerHTML = `<div class="alert ${alertClass} text-center">${message}</div>`;
      };

      // Handle form submission
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        verifyBtn.disabled = true;
        verifyBtn.textContent = '{{ __('messages.verify_phone.verifying') }}';

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
              verifyBtn.disabled = false;
              verifyBtn.textContent = '{{ __('messages.verify_phone.verify_button') }}';
            }
          })
          .catch(() => {
            showMessage('{{ __('messages.verify_phone.verification_failed') }}', false);
            verifyBtn.disabled = false;
            verifyBtn.textContent = '{{ __('messages.verify_phone.verify_button') }}';
          });
      });

      // Handle resend code
      resendBtn.addEventListener('click', function(e) {
        e.preventDefault();

        resendBtn.disabled = true;
        resendBtn.textContent = '{{ __('messages.verify_phone.sending') }}';

        fetch('{{ route('phone.verification.resend') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({})
          })
          .then(res => res.json())
          .then(data => {
            if (data.redirect) {
              window.location.href = data.redirect;
            } else {
              showMessage(data.message || '{{ __('messages.verify_phone.code_sent') }}', data.success);
            }
            resendBtn.disabled = false;
            resendBtn.textContent = '{{ __('messages.verify_phone.resend_code') }}';
          })
          .catch(() => {
            showMessage('{{ __('messages.verify_phone.resend_failed') }}', false);
            resendBtn.disabled = false;
            resendBtn.textContent = '{{ __('messages.verify_phone.resend_code') }}';
          });
      });

      // Auto-submit when 6 digits entered
      codeInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length === 6) {
          setTimeout(() => form.dispatchEvent(new Event('submit')), 500);
        }
      });
    });
  </script>
@endpush
