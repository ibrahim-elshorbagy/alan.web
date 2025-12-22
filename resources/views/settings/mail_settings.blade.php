@extends('settings.edit')
@section('section')
    <div class="card w-100">
        <div class="card-body d-md-flex">
            @include('settings.setting_menu')
            <div class="w-100">
                <div class="card-header px-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <h3 class="m-0">{{ __('messages.vcard.mail_settings') }}
                        </h3>
                    </div>
                </div>

                <div class="card-body border-top p-4">
                    {{ Form::open(['route' => ['mails.update'], 'method' => 'POST']) }}
                    <div class="row">
                        <!-- Mail Protocol Field -->
                        <div class="form-group col-sm-6 mb-3">
                            {{ Form::label('mail_protocol', __('messages.setting.mail_protocol') . ':', ['class' => 'form-label mb-3 required']) }}
                            {{ Form::select('mail_protocol', \App\Models\MailSetting::TYPE, $mailsetting['mail_protocol'] ?? null, ['class' => 'form-select', 'required', 'data-control' => 'select2', 'placeholder' => __('messages.setting.select_mail_protocol')]) }}
                        </div>

                        <!-- SMTP Encryption -->
                        <div class="form-group col-sm-6 mb-4">
                            {{ Form::label('mail_encryption', __('messages.setting.mail_encryption') . ':', ['class' => 'form-label mb-3 required']) }}
                            {{ Form::select('mail_encryption', \App\Models\MailSetting::ENCRYPTION_TYPE, $mailsetting['mail_encryption'] ?? null, ['class' => 'form-select ', 'required', 'data-control' => 'select2', 'placeholder' => __('messages.setting.select_encryption')]) }}
                        </div>

                        <!-- SMTP Host Field -->
                        <div class="form-group col-sm-6 mb-3">
                            {{ Form::label('mail_host', __('messages.setting.mail_host') . ':', ['class' => 'form-label required']) }}
                            {{ Form::text('mail_host', $mailsetting['mail_host'] ?? null, ['class' => 'form-control', 'id' => 'mailHost', 'required', 'placeholder' => __('messages.setting.mail_host')]) }}
                        </div>

                        <!-- SMTP Port Field -->
                        <div class="form-group col-sm-6 mb-3">
                            {{ Form::label('mail_port', __('messages.setting.mail_port') . ':', ['class' => 'form-label required']) }}
                            {{ Form::text('mail_port', $mailsetting['mail_port'] ?? null, ['class' => 'form-control', 'id' => 'mailHost', 'required', 'placeholder' => __('messages.setting.mail_port')]) }}
                        </div>

                        <!-- SMTP Username Field -->
                        <div class="form-group col-sm-6">
                            {{ Form::label('mail_username', __('messages.setting.mail_username') . ':', ['class' => 'form-label required']) }}
                            {{ Form::text('mail_username', $mailsetting['mail_username'] ?? null, ['class' => 'form-control', 'required', 'id' => 'mail_username', 'required', 'placeholder' => __('messages.setting.mail_username')]) }}
                        </div>

                        <!-- SMTP Password Field -->
                        <div class="form-group col-sm-6">
                            <label class="form-label required">{{ __('messages.setting.mail_password') . ':' }}</label>
                            <div class="mb-3 position-relative">
                                <input class="form-control" id="mail_password" type="password" name="mail_password"
                                    placeholder="{{ __('messages.setting.mail_password') }}" autocomplete="off" required
                                    aria-label="Password" data-toggle="password"
                                    value="{{ $mailsetting['mail_password'] ?? null }}" />
                                <span
                                    class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                                    <i class="bi bi-eye-slash-fill"></i>
                                </span>
                            </div>
                        </div>

                        <!-- sender email address Field -->
                        <div class="form-group col-sm-6 mb-4">
                            {{ Form::label('sender_email_address', __('messages.setting.sender_email_address') . ':', ['class' => 'form-label required']) }}
                            {{ Form::email('sender_email_address', $mailsetting['sender_email_address'] ?? null, ['class' => 'form-control', 'required', 'id' => 'sender_email_address', 'placeholder' => __('messages.setting.sender_email_address')]) }}
                        </div>

                    </div>
                    <div>
                        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                        <a href="{{ route('setting.index', ['section' => 'mail_settings']) }}"
                            class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
