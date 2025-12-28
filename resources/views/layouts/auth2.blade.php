<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title') | {{ getAppName() }}</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
  <!-- Zain Font for Arabic -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Zain:wght@200;300;400;500;700;800;900&display=swap" />
  <style>
    /* تطبيق خط Zain على صفحات المصادقة */
    * {
      font-family: "Zain", "Poppins", sans-serif !important;
    }

    /* تطبيق الخط على عناصر معينة */
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: "Zain", sans-serif;
      font-weight: 700;
    }

    body {
      font-family: "Zain", sans-serif;
      font-weight: 400;
    }

    /* لتطبيق الخط على النصوص العربية بشكل أفضل */
    body,
    p,
    span,
    div,
    a,
    li,
    button,
    input,
    textarea,
    select,
    label {
      font-family: "Zain", sans-serif !important;
    }
  </style>
  <!-- General CSS Files -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/page.css') }}"> <!-- CSS Libraries -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
  <style>
    /* Modern Input Focus Effects */
    .modern-input:focus {
      border-color: #667eea !important;
      background: #ffffff !important;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
      outline: none !important;
      transform: translateY(-1px);
    }

    /* Modern Eye Button */
    .modern-eye-btn:hover {
      color: #667eea !important;
      background: rgba(102, 126, 234, 0.1) !important;
    }

    .logo-container {
      @media (max-width: 425px) {
        padding-top: 5rem;
      }
    }

    /* Modern Checkbox */
    .modern-checkbox-input:checked+.checkbox-design {
      background: linear-gradient(135deg, #667eea, #764ba2) !important;
      border-color: transparent !important;
    }

    .modern-checkbox-input:checked+.checkbox-design::after {
      content: '✓';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: #ffffff;
      font-size: 14px;
      font-weight: bold;
    }

    /* Modern Login Button */
    .modern-login-btn:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5) !important;
      background: linear-gradient(135deg, #764ba2 0%, #667eea 100%) !important;
    }

    /* Modern Social Buttons */
    .modern-social-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    /* Modern Links */
    .modern-link:hover {
      color: #764ba2 !important;
    }

    /* Card Animation */
    .modern-login-card {
      animation: cardSlideIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .logo-container {
      animation: cardSlideIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Modern Register Button */
    .modern-register-btn:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5) !important;
      background: linear-gradient(135deg, #764ba2 0%, #667eea 100%) !important;
    }

    /* Card Animation */
    .modern-register-card {
      animation: cardSlideIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Modern Reset Button */
    .modern-reset-btn:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5) !important;
      background: linear-gradient(135deg, #764ba2 0%, #667eea 100%) !important;
    }

    /* Modern Cancel Button */
    .modern-cancel-btn:hover {
      background: #f9fafb !important;
      border-color: #d1d5db !important;
      transform: translateY(-1px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
      color: #374151 !important;
      text-decoration: none !important;
    }

    /* Modern Alert */
    .modern-alert {
      animation: alertSlideIn 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Card Animation */
    .modern-forgot-card {
      animation: cardSlideIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Card Animation */
    .modern-reset-card {
      animation: cardSlideIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    @keyframes cardSlideIn {
      from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    /* Mobile Improvements */
    @media (max-width: 768px) {
      .modern-input {
        font-size: 16px !important;
      }

      .d-flex.flex-column.flex-md-row.gap-3 {
        flex-direction: column !important;
      }
    }
  </style>

  @stack('css')
  @yield('css')
  {!! ReCaptcha::htmlScriptTagJsApi() !!}
</head>

<body>
  <div
    class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed authImage  @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
            getLanguageByKey(checkFrontLanguageSession()) == 'Persian') rtl @endif">
    <div class="dropdown z-index-9 @if (getLanguageByKey(checkFrontLanguageSession()) !== 'Arabic' &&
            getLanguageByKey(checkFrontLanguageSession()) !== 'Persian') ms-auto @endif">
      <button type="button" title="Active" class="dropdown-toggle hide-arrow btn btn btn-info m-7 mb-5 pl-2"
        id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false"
        @if (getLanguageByKey(checkFrontLanguageSession()) == 'Arabic' ||
                getLanguageByKey(checkFrontLanguageSession()) == 'Persian') dir="rtl" @endif>
        {{ strtoupper(getLanguageIsoCode(checkFrontLanguageSession())) }} <i class="fa  fa-language"></i>
      </button>
      <ul class="dropdown-menu min-width-0" aria-labelledby="dropdownMenuButton1"
        style="max-height: 380px;overflow: auto;">
        @foreach (getAllLanguageWithFullData() as $key => $value)
          <li style="padding: 0px"
            class="dropdown-item languageSelection padding {{ checkFrontLanguageSession() == $value->iso_code ? 'active' : '' }}"
            data-prefix-value="{{ $value->iso_code }}"><a
              class=" dropdown-item {{ checkFrontLanguageSession() == $value->iso_code ? 'active' : '' }}"
              class="text-decoration-none" data-id="{{ $value->iso_code }}" href="javascript:void(0)">

              @if (array_key_exists($value->iso_code, \App\Models\User::FLAG))
                @foreach (\App\Models\User::FLAG as $imageKey => $imageValue)
                  @if ($imageKey == $value->iso_code)
                    <img src="{{ asset($imageValue) }}" width="20" height="18" class="me-1" />
                  @endif
                @endforeach
              @else
                @if (count($value->media) != 0)
                  <img src="{{ $value->image_url }}" class="me-1" />
                @else
                  <i class="fa fa-flag fa-xl me-3 text-danger" aria-hidden="true"></i>
                @endif
              @endif
              {{ strtoupper($value->iso_code) }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
    <ul>
    </ul>
    @yield('content')
  </div>
  <footer>
    <div class="container-fluid padding-0 d-none">
      <div class="row align-items-center justify-content-center">
        <div class="col-xl-6">
          <div class="copyright text-center text-muted">
            {{ __('messages.placeholder.all_rights_reserve') }} &copy; {{ date('Y') }} <a
              href="{{ route('home') }}" class="font-weight-bold ml-1" target="_blank">{{ getAppName() }}</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Scripts -->
  @routes
  <script src="{{ mix('assets/js/front-third-party.js') }}"></script>
  <script src="{{ asset('messages.js?$mixID') }}"></script>
  <script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
  {{-- <script src="{{ mix('assets/js/custom/custom.js') }}"></script> --}}
  <script src="{{ mix('assets/js/auth/auth.js') }}"></script>
  @stack('scripts')

  <script>
    let defaultCountryCodeValue = 'in';
    let mobileValidation = "{{ getSuperAdminSettingValue('mobile_validation') }}";
    let utilsScript = "{{ asset('assets/js/inttel/js/utils.min.js') }}"
    $(document).ready(function() {
      $('.alert').delay(5000).slideUp(300)
    })
  </script>
  <script src="{{ mix('assets/js/intl-tel-input/build/intlTelInput.js') }}"></script>
  {{-- <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script> --}}
</body>

</html>
