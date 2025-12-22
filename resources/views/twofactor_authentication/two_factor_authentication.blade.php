<style>
    .tow-factor-modal .modal-header::after {
        content: none !important;
    }

    .tow-factor-modal .btn-close {
        top: 25px;
        right: 20px;
    }

    .qusetion-heading {
        background-color: #eff6ff;
        border-radius: 10px;
        color: #345ddc !important;

    }

    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 470px !important;
        }
    }

    .qusetion-heading p {
        font-size: 12px;
    }

    .question-icon-box {
        width: 35px;
        height: 35px;
        min-width: 35px;
        background-color: #dbeafe;
    }

    .count-cricle {
        width: 20px;
        height: 20px;
        min-width: 20px;
        font-size: 11px;
        background-color: #e5e7eb;
        color: #5d6571 !important;
    }

    .count-list p {
        color: #374150;
        font-size: 12px;
    }

    .count-list ul {
        list-style: disc;
        color: #9ca3af;
        list-style-position: inside
    }

    .count-list ul li {
        font-size: 12px;
        color: #525a68;
    }

    .qr-code-box {
        border: 1px solid #f3f4f6;
        border-radius: 5px;
        background-color: #f9fafb;
        padding: 20px 25px;
    }

    .qr-code-img {
        padding: 6px;
        background-color: white;
        max-width: 120px;
        max-height: 120px;
        aspect-ratio: 1;

    }

    .modal-body-bottom {
        border-bottom: 1px solid #f3f4f6;
    }

    .qr-code-img img {
        aspect-ratio: 1;
    }

    .form-control {
        font-size: 12px;

    }

    .fs-12 {
        font-size: 12px;
    }

    #generateQrCodeImg svg {
        width: 100% !important;
        height: 100% !important;
    }

    .manage-two-factor-modal .btn-close {
        top: 25px;
        right: 20px;
    }

    .manage-two-factor-modal .modal-header::after {
        content: none !important;
    }

    .two-factor {
        background-color: #f0fdf4;
        border-radius: 5px;
    }

    .two-factor-icon-1 {
        width: 35px;
        height: 35px;
        min-width: 35px;
        background-color: #dcfce7;
        border-radius: 50%;
    }

    .text-green {
        color: #4ab771;
    }

    .card-box {
        border: 1px solid #eaecf0;
        border-radius: 5px;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    }

    .yellow-box {
        background-color: #fefce8;
        border-left: 3px solid #facc17;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }

    .text-yellow {
        color: #a46715;
    }

    .lock-icon {
        top: 0;
        bottom: 0;
        right: 15px;
        margin: auto;
        position: absolute
    }

    .password-input:focus {
        border: 1px solid #6698f2 !important;
    }

    .pb-34 {
        padding-bottom: 34px !important;
    }

    .mb-40 {
        margin-bottom: 40px !important;
    }

    .text-green-dark {
        color: #2c8646 !important;
    }

    .text-blue-600 {
        color: #2863eb !important;
    }

    .password-icon-hide-show {
        width: 15px;
        height: 15px;
        right: 10px;
        top: 0;
        bottom: 0;
        margin: auto 0;
    }
</style>

<div class="modal fade tow-factor-modal" id="addTwoFactorAuthModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content"@if (getLogInUser()->language == 'ar') dir="rtl" @endif>
            <div class="modal-header px-4 pt-5 pb-0 border-b-0 position-relative">
                <h3>{{ __('messages.two_factor_auth.enable_tow_factor_authentication') }}</h3>
                <button type="button" class="btn-close position-absolute @if (getLogInUser()->language == 'ar') m-0 @endif"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="enableTwoFactorForm">
                @csrf
                <div class="modal-body pt-2 mb-2 pb-3">
                    <div class="d-flex align-items-center gap-3 p-3 qusetion-heading mb-4">
                        <div class="question-icon-box rounded-circle d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" width="15" height="15">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="mb-0">{{ __('messages.two_factor_auth.extra_layer_of_security') }} </p>
                    </div>
                    <div class="d-flex gap-2 count-list">
                        <div
                            class="fw-bold count-cricle d-flex justify-content-center align-items-center rounded-circle">
                            1
                        </div>
                        <div>
                            <p class="mb-2">
                                {{ __('messages.two_factor_auth.configure_your_authenticator_app') }}</p>
                            <ul>
                                <li>{{ __('messages.two_factor_auth.install_google_authenticator_or_authy') }}
                                </li>
                                <li>{{ __('messages.two_factor_auth.tap_and_add_new_account') }}</li>
                                <li>{{ __('messages.two_factor_auth.scan_qr_code_or_enter_secret_key') }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row modal-body-row">
                        <div class="col-sm-6 mb-2">

                            <div class="d-flex gap-2 count-list">
                                <div
                                    class="fw-bold count-cricle d-flex justify-content-center align-items-center rounded-circle">
                                    2
                                </div>
                                <div>
                                    <p class="mb-2">{{ __('messages.two_factor_auth.scan_qr_code') }}</p>
                                </div>
                            </div>
                            <div class="qr-code-box d-flex justify-content-center align-items-center">
                                <div class="qr-code-img h-100 w-100 mx-auto generate-qr-code-img"
                                    id="generateQrCodeImg">
                                    <img src="{{ asset('/assets/img/new_home_page/qr-code.png') }}" alt="images"
                                        class="h-100 w-100 ovbject-fit-cover">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <div class="mb-4">
                                <div class="d-flex gap-2 count-list">
                                    <div
                                        class="fw-bold count-cricle d-flex justify-content-center align-items-center rounded-circle">
                                        3
                                    </div>
                                    <div>
                                        <p class="mb-2">{{ __('messages.two_factor_auth.secret_key') }}</p>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="position-absolute password-icon-hide-show copy-icon" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                        <path
                                            d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                                    </svg>
                                    <input type="text" name="secret_key" class="form-control" id="secret_key"
                                        placeholder="{{ __('messages.two_factor_auth.secret_key') }}">
                                </div>
                            </div>
                            <div>
                                <div class="d-flex gap-2 count-list">
                                    <div
                                        class="fw-bold count-cricle d-flex justify-content-center align-items-center rounded-circle">
                                        4
                                    </div>
                                    <div>
                                        <p class="mb-2">{{ __('messages.two_factor_auth.verify_code') }}</p>
                                    </div>
                                </div>
                                <p class="fs-12 mb-2">
                                    {{ __('messages.two_factor_auth.enter_6_digit_code_from_your_authenticator_app') . ':' }}
                                </p>
                                <input type="password" name="code" class="form-control password-input text-center"
                                    placeholder="{{ __('messages.two_factor_auth.enter_6_digit_code') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body-bottom"></div>
                </div>
                <div class="modal-footer pt-0 @if (getLogInUser()->language == 'ar') gap-2 @endif">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-secondary my-0 me-0 px-3 py-2 fs-12" type="button"
                            data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
                        <button type="submit" class="btn btn-primary m-0 px-3 py-2 fs-12" id="enableTwoFactor">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-white me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>{{ __('messages.two_factor_auth.verify_and_activate_2fa') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade manage-two-factor-modal" id="ManageTwoFactorAuthModal" tabindex="-1" aria-modal="true"
    role="dialog">
    <div class="modal-dialog">
        <div class="modal-content"@if (getLogInUser()->language == 'ar') dir="rtl" @endif>
            <div class="modal-header px-4 pt-5 pb-0 border-b-0 position-relative">
                <h3>{{ __('messages.two_factor_auth.manage_tow_factor_authentication') }}</h3>
                <button type="button" class="btn-close position-absolute @if (getLogInUser()->language == 'ar') m-0 @endif"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ManageTwoFactorAuthentication">
                @csrf
                <div class="modal-body pt-2 pb-3">
                    <div class="d-flex two-factor p-4 gap-3 mb-4">
                        <div class="two-factor-icon-1 mt-1 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" height="20" width="20">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <p class="fs-12 mb-1 text-green-dark fw-medium lh-sm">
                                {{ __('messages.two_factor_auth.2fa_is_active') }}
                            </p>
                            <p class="fs-12 mb-0 text-green lh-sm">
                                {{ __('messages.two_factor_auth.account_protected_with_2fa') }}</p>
                        </div>
                    </div>
                    <div class="card-box p-4 pb-34 mb-40">
                        <div class="d-flex align-items-center gap-1 mb-2">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" height="16" width="16">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>

                            <p class="fs-12 mb-0"> {{ __('messages.two_factor_auth.disable_2fa') }}</p>
                        </div>
                        <div class="d-flex gap-2 mb-2 yellow-box ps-4 pe-3 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" height="30" width="30">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-yellow fs-12 mb-0 lh-sm">
                                {{ __('messages.two_factor_auth.warning_disabling_2fa_reduce_security') }}</p>
                        </div>
                        <p class="fs-12 lh-sm fw-medium mb-2">
                            {{ __('messages.two_factor_auth.confirm_with_authentication_code') }}
                        </p>
                        <p class="fs-12 lh-sm fw-normal mb-3">
                            {{ __('messages.two_factor_auth.disable_2fa_enter_current_6_digit_code') . ': ' }}
                        </p>
                        <div class="position-relative">
                            <input type="password" name="verification_code"
                                placeholder="{{ __('messages.two_factor_auth.enter_6_digit_code') }}"
                                class="form-control text-center password-input" id="varificationCode">
                            <svg xmlns="http://www.w3.org/2000/svg" class="lock-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" height="20" width="20">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                    <div class="modal-body-bottom"></div>
                </div>
                <div class="modal-footer pt-0 @if (getLogInUser()->language == 'ar') gap-2 @endif">
                    <div class="d-flex align-items-center gap-4">
                        <button type="button" class="btn fs-12 btn-secondary m-0 px-3 py-2"
                            id="enableTwoFactor" data-bs-dismiss="modal" aria-label="Close">{{ __('messages.common.cancel') }}</button>
                        <button class="btn btn-primary fs-12 my-0 me-0 px-3 py-2" type="submit"> <svg
                                xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg> {{ __('messages.two_factor_auth.disable_2fa') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    listenClick("#TwoFactorAuthentication", function() {
        $(".dropdown-menu").removeClass("show");
        let getGenerateQrCode = route("enable-2fa");
        $.ajax({
            url: getGenerateQrCode,
            type: "GET",
            success: function(result) {
                // Livewire.dispatch("refresh");
                let qrImage = result.data.QR_Image;
                $(".generate-qr-code-img").html(qrImage);
                $("#secret_key").val(result.data.secret_key);
                $("#addTwoFactorAuthModal").modal("show");
            },
            error: function(result) {
                displayErrorMessage(result.message);
            },
        });
    });

    $('#enableTwoFactorForm').on('submit', function(e) {
        e.preventDefault();
        $("#enableTwoFactor").prop("disabled", true);
        let formData = {
            secret_key: $('#secret_key').val(),
            code: $('input[name="code"]').val(),
            _token: $('input[name="_token"]').val()
        };
        $.ajax({
            url: "{{ route('2fa.enable') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                displaySuccessMessage(response.message);
                $('#addTwoFactorAuthModal').modal('hide');
                $("#enableTwoFactor").prop("disabled", false);
                setTimeout(function() {
                    location.reload();
                }, 5000);
            },
            error: function(result) {
                displayErrorMessage(result.responseJSON.message);
                $("#enableTwoFactor").prop("disabled", false);
            }
        });
    });

    listenClick("#ManageTwoFactorAuthenticationModel", function() {
        $(".dropdown-menu").removeClass("show");
        $("#ManageTwoFactorAuthModal").modal("show");
    });

    $('#ManageTwoFactorAuthentication').on('submit', function(e) {
        e.preventDefault();
        let formData = {
            verification_code: $('input[name="verification_code"]').val(),
            _token: $('input[name="_token"]').val()
        };
        $.ajax({
            url: "{{ route('disable.2fa') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                displaySuccessMessage(response.message);
                $("#ManageTwoFactorAuthModal").modal('hide');
                setTimeout(function() {
                    location.reload();
                }, 5000);
            },
            error: function(result) {
                displayErrorMessage(result.responseJSON.message);
            }
        });
    });


    listenClick('.copy-icon', function() {
        var input = document.getElementById('secret_key');
        input.select();
        input.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand('copy');
        displaySuccessMessage("{{ __('messages.two_factor_auth.secret_key_copied_successfully') }}");
    });
</script>
