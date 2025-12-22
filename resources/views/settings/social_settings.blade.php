@extends('settings.edit')
@section('section')
    <div class="card w-100">
        <div class="card-body d-md-flex">
            @include('settings.setting_menu')
            <div class="w-100">
                <div class="card-header px-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <h3 class="m-0">{{ __('messages.setting.google_login') }}
                        </h3>
                    </div>
                </div>
                <div class="card-body border-top p-3">
                    {{ Form::open(['route' => ['social.settings.page.update'], 'method' => 'post', 'files' => true, 'id' => 'homePageSetting']) }}
                    <div class="row mb-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <div class="row pt-4 mb-2">
                                        <div class="form-group col-lg-6 mb-2">
                                            {{ Form::label('google_client_id', __('messages.setting.google_client_id') . ':', ['class' => 'form-label mb-3']) }}
                                            {{ Form::text('google_client_id', $social_setting['google_client_id'] ?? '', ['class' => 'form-control  google-client-id', 'placeholder' => __('messages.setting.google_client_id')]) }}
                                        </div>
                                        <div class="form-group col-lg-6 mb-5">
                                            {{ Form::label('google_client_secret', __('messages.setting.google_client_secret') . ':', ['class' => 'form-label stripe-secret-label mb-3']) }}
                                            {{ Form::text('google_client_secret', $social_setting['google_client_secret'] ?? '', ['class' => 'form-control google-client-secret ', 'placeholder' => __('messages.setting.google_client_secret')]) }}
                                        </div>
                                        <div class="form-group col-lg-6 mb-5">
                                            {{ Form::label('google_redirect_url', __('messages.setting.google_redirect_url') . ':', ['class' => 'form-label stripe-secret-label mb-3']) }}
                                            {{ Form::text('google_redirect_url', $social_setting['google_redirect_url'] ?? '', ['class' => 'form-control google-redirect-url', 'placeholder' => __('messages.setting.google_redirect_url')]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header px-0">
                                <div class="d-flex align-items-center justify-content-center">
                                    <h3 class="m-0">{{ __('messages.setting.facebook_login') }}
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <div class="row border-top pt-4 mb-3">
                                        <div class="form-group col-lg-6 mb-5">
                                            {{ Form::label('facebook_app_id ', __('messages.setting.facebook_app_id') . ':', ['class' => 'form-label mb-3']) }}
                                            {{ Form::text('facebook_app_id', $social_setting['facebook_app_id'] ?? '', ['class' => 'form-control  facebook-app-id', 'placeholder' => __('messages.setting.facebook_app_id')]) }}
                                        </div>
                                        <div class="form-group col-lg-6 mb-5">
                                            {{ Form::label('facebook_app_secret', __('messages.setting.facebook_app_secret') . ':', ['class' => 'form-label stripe-secret-label mb-3']) }}
                                            {{ Form::text('facebook_app_secret', $social_setting['facebook_app_secret'] ?? '', ['class' => 'form-control facebook-app-secret', 'placeholder' => __('messages.setting.facebook_app_secret')]) }}
                                        </div>
                                        <div class="form-group col-lg-6 mb-5">
                                            {{ Form::label('facebook_redirect_url', __('messages.setting.facebook_redirect_url') . ':', ['class' => 'form-label stripe-secret-label mb-3']) }}
                                            {{ Form::text('facebook_redirect_url', $social_setting['facebook_redirect_url'] ?? '', ['class' => 'form-control facebook-redirect-url ', 'placeholder' => __('messages.setting.facebook_redirect_url')]) }}
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
