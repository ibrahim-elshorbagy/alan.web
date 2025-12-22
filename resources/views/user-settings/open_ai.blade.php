@extends('settings.edit')
@section('section')
    <div class="card w-100">
        <div class="card-body d-md-flex">
            <div class="">
                <div class="">
                    @include('user-settings.setting_menu')
                </div>
            </div>
            <div class="w-100">
                <button type="button"
                    class="btn px-0 aside-menu-container__aside-menubar d-block d-xl-none d-lg-none d-block edit-menu"
                    onclick="openNav()">
                    <i class="fa-solid fa-bars fs-1"></i>
                </button>
                <div class="card-header px-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <h3 class="m-0">{{ __('messages.vcard.open_ai') }}
                        </h3>
                    </div>
                </div>

                <div class="card-body border-top p-3">
                    {{ Form::open(['route' => 'open.ai.setting.update', 'id' => 'UserCredentialsSettings', 'class' => 'form']) }}
                    {{ Form::hidden('sectionName', $sectionName) }}
                    <div class="row">
                        <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3 me-3">{{ __('messages.vcard.open_ai') }}</span>
                            <label class="form-switch">
                                <input type="checkbox" name="open_ai_enable" class="form-check-input open-ai-enable"
                                    value="1" {{ !empty($setting['open_ai_enable']) == '1' ? 'checked' : '' }}
                                    id="openAiEnable">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="open-ai-div {{ !empty($setting['open_ai_enable']) == '1' ? '' : 'd-none' }} col-12">
                            <div class="row">
                                <div class="form-group col-sm-6 mb-5">
                                {{ Form::label('openai_api_key', __('messages.vcard.open_ai_api_key') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('openai_api_key', isset($setting['openai_api_key']) ? $setting['openai_api_key'] : null, ['class' => 'form-control', 'id' => 'openAikey', 'placeholder' => __('messages.vcard.open_ai_api_key')]) }}
                                </div>
                                <div class="form-group col-sm-6 mb-5">
                                    {{ Form::label('open_ai_model', __('messages.vcard.open_ai_model') . ':', ['class' => 'form-label required']) }}
                                    {{ Form::text('open_ai_model', isset($setting['open_ai_model']) ? $setting['open_ai_model'] : null, ['class' => 'form-control', 'id' => 'openAiModel', 'placeholder' => __('messages.vcard.open_ai_model')]) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"
                        id="userCredentialSettingBtn">{{ __('messages.common.save') }}</button>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    @endsection
