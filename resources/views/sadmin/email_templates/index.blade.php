@extends('layouts.app')
@section('title')
    {{ __('messages.email_templates.email_templates') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            @include('layouts.errors')
            <div class="d-flex justify-content-between align-items-end mb-5">
                <h1>{{ __('messages.email_templates.email_templates') }}</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {{ Form::open(['route' => ['email.templates.store'], 'method' => 'post', 'id' => 'emailTemplateForm']) }}
                            @php
                                $emailTempleteType = [
                                    __('messages.email_templates.new_user_register'),
                                    __('messages.email_templates.appointment_approve'),
                                    __('messages.email_templates.admin_nfc_order_mail'),
                                    __('messages.email_templates.contact_us'),
                                    __('messages.email_templates.nfc_order_status'),
                                    __('messages.email_templates.product_order_send_customer'),
                                    __('messages.email_templates.product_order_send_user'),
                                    __('messages.email_templates.send_invite'),
                                    __('messages.email_templates.subscription_payment_success'),
                                    __('messages.email_templates.user_appointment_mail'),
                                    __('messages.email_templates.withdrawal_approve'),
                                    __('messages.email_templates.withdrawal_reject'),
                                    __('messages.email_templates.appointment_mail'),
                                    __('messages.email_templates.landing_contact_us'),
                                    __('messages.email_templates.whatsapp_store_product_order_send_user'),
                                ];
                            @endphp

                            <!-- Email Template Type Selection -->
                            <div class="row mb-5">
                                <div class="col-lg-12 mt-4">
                                    <label class="form-label required">{{ __('messages.email_templates.email_template_type') }}</label>
                                    {{ Form::select('email_template_type', $emailTempleteType, $selectedTemplate['email_template_type'] ?? 0, ['class' => 'form-select email-template-type', 'required', 'id' => 'EmailTemplateType', 'data-control' => 'select2', 'placeholder' => __('messages.email_templates.select_email_template_type')]) }}
                                </div>
                            </div>

                            <!-- Language Tabs Section -->
                            @if($languages->count() > 0)
                            <div id="languageTabsContainer" class="language-tabs-section d-none mb-4">
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label class="form-label required">{{ __('messages.email_templates.select_language') . ':' }}</label>
                                        <span data-bs-toggle="tooltip"
                                            data-placement="top"
                                            data-bs-original-title="{{__('messages.email_templates.select_langauge_code')}}">
                                        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                                        </span>
                                        <ul class="nav nav-pills language-tabs" id="languageTabs" role="tablist">
                                            @foreach($languages as $index => $language)
                                                @php
                                                    $isActive = $language->id === $defaultLanguage->id;
                                                @endphp
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link {{ $isActive ? 'active' : '' }} language-tab-btn"
                                                            id="lang-{{ $language->iso_code }}-tab"
                                                            data-bs-toggle="pill"
                                                            data-bs-target="#lang-{{ $language->iso_code }}-content"
                                                            data-language-id="{{ $language->id }}"
                                                            data-language-code="{{ $language->iso_code }}"
                                                            data-language-name="{{ $language->name }}"
                                                            type="button"
                                                            role="tab">
                                                        {{ strtoupper($language->iso_code) }}
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="selected-language-info mt-3">
                                            <span class="text-muted">{{ __('messages.email_templates.editing_template_for') }}:</span>
                                            <strong id="selectedLanguageName" class="text-primary ms-2">{{ $defaultLanguage->name }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Language Content Tabs -->
                                <div class="tab-content" id="languageTabContent">
                                    @foreach($languages as $index => $language)
                                        @php
                                            $isActive = $language->id === $defaultLanguage->id;
                                        @endphp
                                        <div class="tab-pane fade {{ $isActive ? 'show active' : '' }}"
                                            id="lang-{{ $language->iso_code }}-content"
                                            role="tabpanel">

                                            <!-- Email Template Subject -->
                                            <div class="form-group mb-3">
                                                {{ Form::label('email_template_subject', __('messages.email_templates.email_template_subject') . ':', ['class' => 'form-label required']) }}
                                                {{ Form::text('subject_' . $language->id, '', ['class' => 'form-control email-template-subject-field', 'placeholder' => __('messages.email_templates.email_template_subject'), 'data-language-id' => $language->id, 'id' => 'subject_' . $language->id]) }}
                                            </div>

                                            <!-- Email Template Content -->
                                            <div class="form-group mb-3">
                                                <div class="col-lg-12 mt-5">
                                                    <div class="mb-5">
                                                        {{ Form::label('email_template_content', __('messages.email_templates.email_template_content') . ':', ['class' => 'form-label required']) }}
                                                        <div id="emailEditor_{{ $language->id }}"
                                                            class="editor-height-200 email-template-content-editor"
                                                            data-language-id="{{ $language->id }}"
                                                            data-turbo="false">
                                                        </div>
                                                        {{ Form::hidden('content_' . $language->id, '', ['class' => 'emailTemplateData', 'data-language-id' => $language->id, 'id' => 'content_' . $language->id]) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{ Form::hidden('language_id', $defaultLanguage->id, ['id' => 'selectedLanguageId']) }}
                            {{ Form::hidden('email_template_subject', '', ['id' => 'finalSubject']) }}
                            {{ Form::hidden('email_template_content', '', ['id' => 'finalContent']) }}
                            @endif

                        </div>
                        <div class="col-lg-4">
                            <div class="shortcode-sidebar">
                                <div class="sidebar-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="mb-0 fw-bold">{{ __('messages.email_templates.short_codes') }}</h6>
                                    </div>
                                    <p class="text-white small mb-0 mt-1">{{ __('messages.email_templates.click_to_insert_into_template') }}</p>
                                </div>

                                <div class="sidebar-body" id="shortCodesContainer">
                                    @foreach ($shortCodes as $shortCode)
                                        <div class="shortcode-item insert-shortcode {{ $shortCode->email_template_type == ($selectedTemplate['email_template_type'] ?? 0) ? '' : 'd-none' }}"
                                            data-content="{{ $shortCode->short_code }}"
                                            data-template-type="{{ $shortCode->email_template_type }}">
                                            <div class="d-flex align-items-center">
                                                <div class="shortcode-icon">
                                                    <i class="fas fa-code"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="shortcode-name">{{ trim(str_replace(['{', '}'], '', $shortCode->short_code)) }}</div>
                                                    <div class="shortcode-desc">{{ $shortCode->value }}</div>
                                                </div>
                                                <div class="shortcode-action">
                                                    <i class="fas fa-plus-circle text-success"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'submitSendMailBtn']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        // Pass PHP data to JavaScript and ensure proper initialization
        window.emailTemplates = @json($groupedTemplates ?? []);
        window.languages = @json($languages);

        // Set default language from settings
        window.defaultLanguage = @json($defaultLanguage);

        // Ensure the page initializes properly after DOM is ready
        document.addEventListener("DOMContentLoaded", function() {
            // Small delay to ensure all elements are properly rendered
            setTimeout(function() {
                loadEmailTemplateData();
            }, 100);
        });
    </script>
@endpush
@endsection
