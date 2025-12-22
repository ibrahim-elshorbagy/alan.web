@extends('settings.edit')
@section('section')
    <div class="card w-100">
        <div class="card-body d-md-flex">
            @include('settings.setting_menu')
            <div class="w-100">
                <div class="card-header px-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <h3 class="m-0">{{ __('messages.setting.google_recaptcha') }}
                        </h3>
                    </div>
                </div>
                <div class="card-body border-top p-3">
                    {{ Form::open(['route' => ['social.settings.page.update'], 'method' => 'post', 'files' => true, 'id' => 'homePageSetting']) }}
                    <div class="row mb-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-2">
                                    @php
                                        $recaptcha_version = collect(\App\Models\Setting::RECAPTCHA_VERSION)->map(function (
                                            $value,
                                        ) {
                                            return $value;
                                        });
                                    @endphp
                                    <div class="form-group col-sm-6 mb-3">
                                        {{ Form::label('recaptcha_version', __('messages.setting.recaptcha_version') . ':', ['class' => 'form-label']) }}
                                        {{ Form::select('recaptcha_version', $recaptcha_version, $setting['recaptcha_version'], ['class' => 'form-control', 'data-control' => 'select2', 'id' => 'recaptchaVersion']) }}
                                    </div>
                                    <div class="row pt-4 mb-2">
                                        <div class="form-group col-lg-6 mb-5">
                                            {{ Form::label('recaptcha_site_key', __('messages.setting.recaptcha_site_key') . ':', ['class' => 'form-label mb-3']) }}
                                            {{ Form::text('recaptcha_site_key', $social_setting['recaptcha_site_key'] ?? '', ['class' => 'form-control  recaptcha-site-key ', 'placeholder' => __('messages.setting.recaptcha_site_key')]) }}
                                        </div>
                                        <div class="form-group col-lg-6 mb-5">
                                            {{ Form::label('recaptcha_secret_key', __('messages.setting.recaptcha_secret_key') . ':', ['class' => 'form-label stripe-secret-label mb-3']) }}
                                            {{ Form::text('recaptcha_secret_key', $social_setting['recaptcha_secret_key'] ?? '', ['class' => 'form-control recaptcha-secret-key ', 'placeholder' => __('messages.setting.recaptcha_secret_key')]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                        <a href="{{ route('setting.index', ['section' => 'home_page_settings']) }}"
                            class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
