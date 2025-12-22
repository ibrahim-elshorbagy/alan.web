<div class="modal fade py-3" id="askContactDetailFormModel" tabindex="-1" aria-hidden="true"
    aria-labelledby="askContactDetailFormModelLabel" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
    <div class="modal-dialog modal-bottom">
        <div class="modal-content" @if (getLanguage($vcard->default_language) == 'Arabic' || getLanguage($vcard->default_language) == 'Persian') dir="rtl" @endif>
            <div class="modal-header d-flex flex-column align-items-start">
                <h5 class="modal-title">{{ __('messages.setting.share_your_details') }}</h5>
                <p class="text-muted fs-14 m-0">{{ __('messages.setting.add_to_conact_model_decs') }}</p>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['id' => 'askContactDetailForm']) !!}
            <div class="modal-body">
                <input type="text" name="vcard_id" id="vcard_id" value="{{ $vcard->id }}" hidden="hidden">
                <input type="text" name="user_id" id="user_id"
                    value="{{ Auth::check() ? getLogInUser()->id : null }}" hidden="hidden">
                <div class="mb-3 form-group">
                    {{ Form::label('name', __('messages.common.name') . ' :', ['class' => 'form-label required']) }}
                    {{ Form::text('name', Auth::check() ? getLogInUser()->full_name : null, ['class' => 'form-control custom-placeholder', 'required', 'placeholder' => __('messages.form.enter_name'), 'id' => 'contactName']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('email', __('messages.common.email') . ' :', ['class' => 'form-label required ']) }}
                    {{ Form::text('email', Auth::check() ? getLogInUser()->email : null, ['class' => 'form-control custom-placeholder', 'required', 'placeholder' => __('messages.form.enter_email'), 'id' => 'contactEmail']) }}
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <div>
                            {{ Form::label('phone', __('messages.common.phone') . ':', ['class' => 'form-label required']) }}
                        </div>
                            {{ Form::text('phone', Auth::check() ? getLogInUser()->contact : null, ['class' => 'form-control custom-placeholder', 'placeholder' => __('messages.form.enter_phone'), 'required', 'id' => 'contactrPhone', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, "")']) }}
                        <input type="hidden" name="region_code" value="" id="prefix_code" />
                        <div class="mt-2">
                            <span id="valid-msg"
                                class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.valid_number') }}</span>
                            <span id="error-msg"
                                class="text-danger d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.invalid_number') }}</span>
                        </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer pt-0 border-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'submit-btn btn btn-primary m-0']) }}
                <button type="button" class="btn btn-secondary my-0 ms-3 me-0"
                    data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/intl-tel-input/build/intlTelInput.js') }}"></script>
<script>
    let defaultCountryCodeValue = "{{ getSuperAdminSettingValue('default_country_code') }}"
</script>
