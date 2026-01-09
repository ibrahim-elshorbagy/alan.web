@extends('layouts.auth')
@section('title')
  {{ __('messages.common.forgot_password') }}
@endsection
@section('content')
  <div class="forget-password-section bg-white overflow-hidden position-relative h-100">
    <div class="top-vector">
      <img src="{{ asset('assets/images/top-vector.png') }}">
    </div>
    <div class="bottom-vector">
      <img src="{{ asset('assets/images/bottom-vector.png') }}">
    </div>
    <div class="row">
      <div class="col-md-6 col-12 p-0 d-none">
        <div class="forget-password-img">
          <img src="{{ asset($registerImage) }}" alt="Register Image" class="w-100 h-100">
        </div>
      </div>
      <div class="col-md-12 col-12 p-0 d-flex flex-column justify-content-center forget-password-section"
        @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                getLanguageByKey(checkFrontLanguageSession()) == 'Persian') dir="rtl" @endif>
        <div class="forget-password-form">
          <div class="px-sm-10 px-6 mb-5 h-100 w-100">
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
              <h1 class="text-center mb-7 fs-2 fw-bold">{{ __('messages.common.forgot_password') . ' ?' }}</h1>
              <p class="text-center mb-4 text-muted">
                {{ __('messages.verify_phone.forgot_password_subtitle') }}
              </p>
              <form method="POST" action="{{ route('password.phone.email') }}" id="forgotPasswordPhoneForm">
                @csrf
                <div class="row">
                  <div class="col-md-12 mb-4">
                    <label for="phone" class="form-label">
                      {{ __('messages.user.contact_number') . ':' }}<span class="required"></span>
                    </label>
                    <input type="tel" name="phone" class="form-control" id="phone"
                      required>
                    <span class="text-muted fs-small mt-1 d-block">{{ __('messages.verify_phone.phone_format_hint') }}</span>
                    <div id="phone-message" class="mt-2 text-center"></div>
                  </div>
                  <div class="col-md-12 mb-4">
                    <button type="submit" class="btn register-btn px-10 w-100" id="sendCodeBtn">
                      {{ __('messages.verify_phone.send_code') }}
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
      const form = document.getElementById('forgotPasswordPhoneForm');
      const phoneInput = document.getElementById('phone');
      const sendCodeBtn = document.getElementById('sendCodeBtn');
      const messageDiv = document.getElementById('phone-message');
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Show message helper
      const showMessage = (message, isSuccess) => {
        const alertClass = isSuccess ? 'alert-success' : 'alert-danger';
        messageDiv.innerHTML = `<div class="alert ${alertClass} text-center">${message}</div>`;
      };

      // Handle form submission
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        sendCodeBtn.disabled = true;
        sendCodeBtn.textContent = '{{ __('messages.verify_phone.sending') }}';

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
              setTimeout(() => window.location.href = '{{ route('phone.verification.show') }}', 1500);
            } else {
              showMessage(data.message || '{{ __('messages.verify_phone.sms_failed') }}', false);
              sendCodeBtn.disabled = false;
              sendCodeBtn.textContent = '{{ __('messages.verify_phone.send_code') }}';
            }
          })
          .catch(() => {
            showMessage('{{ __('messages.verify_phone.sms_failed') }}', false);
            sendCodeBtn.disabled = false;
            sendCodeBtn.textContent = '{{ __('messages.verify_phone.send_code') }}';
          });
      });
    });
  </script>
@endpush
