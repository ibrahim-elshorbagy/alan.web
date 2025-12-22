<div class="row">
    <div class="col-lg-4">
        <div class="row">
            <div class="col-xl-6 col-lg-12 col-md-6 col-12 mb-7">
                {{ Form::label('name', __('messages.common.name') . ':', ['class' => 'form-label required']) }}
                {{ Form::text('name', isset($plan) ? $plan->name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.plan_name'), 'required']) }}
            </div>
            @php
                $duration = collect(\App\Models\Plan::DURATION)->map(function ($value) {
                    return trans('messages.plan.' . $value);
                });
            @endphp
            <div class="col-xl-6 col-lg-12 col-md-6 col-12 mb-7">
                {{ Form::label('frequency', __('messages.plan.frequency') . ':', ['class' => 'form-label required']) }}
                {{ Form::select('frequency', $duration, isset($plan) ? $plan->frequency : null, ['class' => 'form-control', 'required', 'data-control' => 'select2']) }}
            </div>
            <div class="col-xl-6 col-lg-12 col-md-6 col-12 mb-7">
                {{ Form::label('currency_id', __('messages.plan.currency') . ':', ['class' => 'form-label required']) }}
                {{ Form::select('currency_id', getCurrencies(), isset($plan) ? $plan->currency_id : null, ['class' => 'form-control select2Selector', 'required', 'placeholder' => __('messages.form.select_currency'), 'data-control' => 'select2', 'required']) }}
            </div>
            <div class="col-xl-6 col-lg-12 col-md-6 col-12 mb-7">
                {!! Form::label('price', __('messages.plan.price') . ':', ['class' => 'form-label required']) !!}
                {!! Form::text('price', isset($plan) ? $plan->price : null, [
                    'class' => 'form-control price-format-input',
                    'min' => '0',
                    'step' => '0.01',
                    'placeholder' => __('messages.form.price'),
                    'required',
                    isset($plan) && $plan->is_trial ? 'disabled' : '',
                ]) !!}
            </div>
            <div class="col-xl-6 col-lg-12 col-md-6 col-12 mb-7">
                {!! Form::label('no_of_vcards', __('messages.plan.no_of_vcards') . ':', ['class' => 'form-label required']) !!}
                {!! Form::number('no_of_vcards', isset($plan) ? $plan->no_of_vcards : null, [
                    'class' => 'form-control',
                    'min' => '1',
                    'placeholder' => __('messages.form.allowed_vcard'),
                    'required',
                ]) !!}
            </div>
            <div class="col-xl-6 col-lg-12 col-md-6 col-12 mb-7">
                {!! Form::label('trial_days', __('messages.plan.trial_days') . ':', ['class' => 'form-label']) !!}
                {!! Form::number('trial_days', isset($plan) ? $plan->trial_days : null, [
                    'class' => 'form-control trialDays',
                    'placeholder' => __('messages.form.enter_trial'),
                ]) !!}
            </div>

            <div class="col-lg-12 col-12 mb-7">
                {!! Form::label('storage_limit', __('messages.plan.storage_limit') . ':', ['class' => 'form-label required']) !!}
                <span data-bs-toggle="tooltip" data-placement="top"
                    data-bs-original-title="{{ __('messages.tooltip.storage_limit_mb') }}">
                    <i class="fas fa-question-circle general-question-mark"></i>
                </span>
                {!! Form::number('storage_limit', isset($plan) ? $plan->storage_limit : 200, [
                    'class' => 'form-control',
                    'placeholder' => __('messages.plan.storage_limit'),
                ]) !!}
            </div>
            <div class="d-flex">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <label
                        class="form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex justify-content-start cursor-pointer">
                        <input type="checkbox" name="custom_select"
                            class="form-check-input cursor-pointer custom-select me-2 " id="customField" value="1"
                            {{ isset($plan) && $plan->custom_select && (count($planCustomFields) != 0) == 1 ? 'checked' : '' }}>
                        {{ __('messages.plan.custom_select') }}
                    </label>
                </div>
                <div class="col-lg-6 col-md-6 col-6 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="addFieldsButton"
                        style="display: {{ isset($plan) && $plan->custom_select == 1 && count($planCustomFields) != 0 ? 'block' : 'none' }};">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div id="customFieldsSection"
                style="display: {{ isset($plan) && $plan->custom_select == 1 ? 'block' : 'none' }};">
                <div class="row d-flex align-items-end" id="fieldsContainer">
                </div>
                @if (isset($planCustomFields))
                    @foreach ($planCustomFields as $key => $planCustomField)
                        <div class="row d-flex align-items-end " id="fieldsContainer">
                            <div class="col-lg-6 col-md-2 col-5 mt-7">
                                {!! Form::label('custom_vcard_number', __('messages.plan.custom_vcard_number') . ':', [
                                    'class' => 'form-label required',
                                ]) !!}
                                {!! Form::number('custom_vcard_number[]', $planCustomField->custom_vcard_number, [
                                    'class' => 'form-control',
                                    'placeholder' => __('messages.plan.custom_vcard_number'),
                                    'required',
                                ]) !!}
                            </div>
                            <div class="col-lg-5 col-md-2 col-5 mt-7">
                                {!! Form::label('custom_vcard_price', __('messages.plan.custom_vcard_price') . ':', [
                                    'class' => 'form-label required',
                                ]) !!}
                                {!! Form::number('custom_vcard_price[]', $planCustomField->custom_vcard_price, [
                                    'class' => 'form-control',
                                    'placeholder' => __('messages.plan.custom_vcard_price'),
                                    'required',
                                ]) !!}
                            </div>
                            <div class="col-lg-1 col-md-2 col-1 mb-2 trash">
                                <a href="javascript:void(0)"><i class="fas fa-trash text-danger fs-2"></i></a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>
    <div class="col-lg-8">
        <div class="mb-2 d-flex justify-content-between flex-wrap">
            {{ Form::label('template', __('messages.plan.multi_templates') . ':', ['class' => 'form-label required']) }}
            <label class="form-label form-check ps-0">
                {{ __('messages.plan.select_all_templates') }}
                <input class="form-check-input mx-2" type="checkbox" id="multiTemplatesAll" />
            </label>
        </div>
        <div class="form-group mb-10">
            <div class="templates d-flex flex-wrap">
                @php
                    $templateNames = [
                        1 => 'Simple Contact',
                        2 => 'Executive Profile',
                        3 => 'Clean Canvas',
                        4 => 'Professional',
                        5 => 'Corporate Connect',
                        6 => 'Modern Edge',
                        7 => 'Business Beacon',
                        8 => 'Corporate Classic',
                        9 => 'Corporate Identity',
                        10 => 'Pro Network',
                        11 => 'Portfolio',
                        12 => 'Gym 2',
                        13 => 'Hospital 2',
                        14 => 'Event Management 2',
                        15 => 'Salon 2',
                        16 => 'Lawyer 2',
                        17 => 'Programmer 2',
                        18 => 'CEO/CXO 2',
                        19 => 'Fashion Beauty 2',
                        20 => 'Culinary Food Services 2',
                        21 => 'Social Media 2',
                        22 => 'Dynamic vCard 2',
                        23 => 'Consulting Services 2',
                        24 => 'School Templates 2',
                        25 => 'Social Services 2',
                        26 => 'Retail E-commerce 2',
                        27 => 'Pet Shop 2',
                        28 => 'Pet Clinic 2',
                        29 => 'Marriage 2',
                        30 => 'Taxi Service 2',
                        31 => 'Handyman Services 2',
                        32 => 'Interior Designer 2',
                        33 => 'Musician 2',
                        34 => 'Photographer 2',
                        35 => 'Real Estate 2',
                        36 => 'Travel Agency 2',
                        37 => 'Flower Garden 2',
                        38 => 'Architecture',
                        39 => 'Gym 1',
                        40 => 'Hospital 1',
                        41 => 'Event Management 1',
                        42 => 'Salon 1',
                        43 => 'Lawyer 1',
                        44 => 'Programmer 1',
                        45 => 'CEO/CXO 1',
                        46 => 'Fashion Beauty 1',
                        47 => 'Culinary Food Services 1',
                        48 => 'Social Media 1',
                        49 => 'Dynamic vCard 1',
                        50 => 'Consulting Services 1',
                        51 => 'School Templates 1',
                        52 => 'Social Services 1',
                        53 => 'Retail E-commerce 1',
                        54 => 'Pet Shop 1',
                        55 => 'Pet Clinic 1',
                        56 => 'Marriage 1',
                        57 => 'Taxi Service 1',
                        58 => 'Handyman Services 1',
                        59 => 'Interior Designer 1',
                        60 => 'Musician 1',
                        61 => 'Photographer 1',
                        62 => 'Real Estate 1',
                        63 => 'Travel Agency 1',
                        64 => 'Flower Garden 1',
                        65 => 'Reporter',
                    ];

                    // Create pairs of templates
                    $templatePairs = [
                        39 => 12,
                        40 => 13,
                        41 => 14,
                        42 => 15,
                        43 => 16,
                        44 => 17,
                        45 => 18,
                        46 => 19,
                        47 => 20,
                        48 => 21,
                        49 => 22,
                        50 => 23,
                        51 => 24,
                        52 => 25,
                        53 => 26,
                        54 => 27,
                        55 => 28,
                        56 => 29,
                        57 => 30,
                        58 => 31,
                        59 => 32,
                        60 => 33,
                        61 => 34,
                        62 => 35,
                        63 => 36,
                        64 => 37,
                    ];

                    // Get all template URLs
                    $templateUrls = getTemplateUrls();

                    // Create ordered array with paired templates together
                    $orderedTemplates = [];
                    $processed = [];

                    foreach ($templateUrls as $id => $url) {
                        if (in_array($id, $processed)) {
                            continue;
                        }

                        // Add current template
                        $orderedTemplates[] = $id;
                        $processed[] = $id;

                        // Check if this template has a pair
                        if (isset($templatePairs[$id])) {
                            $pairId = $templatePairs[$id];
                            if (isset($templateUrls[$pairId])) {
                                $orderedTemplates[] = $pairId;
                                $processed[] = $pairId;
                            }
                        }
                    }
                @endphp

                @foreach ($orderedTemplates as $id)
                    <div class="col-custom img-box mb-2">
                        <input type="checkbox" name="template_ids[]" class="templateIds template-input"
                            value="{{ $id }}" @if ($id == 1 && Request::is('sadmin/plans/create')) checked @endif
                            {{ isset($templates) && in_array($id, $templates) ? 'checked' : '' }}>
                        <div
                            class="screen image
                            @if ($id == 11) vcard_11 @endif
                            @if ($id == 22) ribbon @endif
                            @if ($id == 1 && Request::is('sadmin/plans/create')) template-border @endif
                            {{ isset($templates) && in_array($id, $templates) ? 'template-border' : '' }}">
                            <img src="{{ $templateUrls[$id] }}" alt="Template {{ $id }}">
                            <span class="template-name fw-bold text-center">{{ $templateNames[$id] }}</span>
                            @if ($id == 22)
                                <div class="ribbon-wrapper">
                                    <div class="ribbon fw-bold">{{ __('messages.feature.dynamic_vcard') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row mt-7 col-12">
        <div class="mb-10 d-flex justify-content-between flex-wrap">
            {{ Form::label('feature', __('messages.plan.features') . ':', ['class' => 'form-label required']) }}
            <label class="form-label form-check ps-0">
                {{ __('messages.plan.select_all_feature') }}
                <input class="form-check-input mx-2" type="checkbox" id="featureAll" />
            </label>
        </div>
        <div class="row mb-5 plan-features">
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                        <input class="form-check-input feature mx-2" type="checkbox" value="1"
                            name="products_services"
                        {{ isset($feature) && $feature->products_services == 1 ? 'checked' : '' }} />
                    {{ __('messages.plan.services') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="testimonials"
                        {{ isset($feature) && $feature->testimonials == 1 ? 'checked' : '' }} />
                    {{ __('messages.plan.testimonials') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="hide_branding"
                        {{ isset($feature) && $feature->hide_branding == 1 ? 'checked' : '' }} />
                    <div>
                        {{ __('messages.plan.hide_branding') }}
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.tooltip.hide_branding') }}">
                            <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                        </span>
                    </div>
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="enquiry_form"
                        {{ isset($feature) && $feature->enquiry_form == 1 ? 'checked' : '' }} />
                    {{ __('messages.plan.inquiry_form') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="social_links"
                        {{ isset($feature) && $feature->social_links == 1 ? 'checked' : '' }} />
                    {{ __('messages.social.social_links') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="custom_links"
                        {{ isset($feature) && $feature->custom_links == 1 ? 'checked' : '' }} />
                    {{ __('messages.custom_links.custom_links') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="password"
                        {{ isset($feature) && $feature->password == 1 ? 'checked' : '' }} />
                    <div>
                        {{ __('messages.plan.password_protection') }}
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.tooltip.password_protection') }}">
                            <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                        </span>
                    </div>
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="custom_css"
                        {{ isset($feature) && $feature->custom_css == 1 ? 'checked' : '' }} />
                    <div>
                        {{ __('messages.plan.custom_css') }}
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.tooltip.custom_css') }}">
                            <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                        </span>
                    </div>
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="custom_js"
                        {{ isset($feature) && $feature->custom_js == 1 ? 'checked' : '' }} />
                    <div>
                        {{ __('messages.plan.custom_js') }}
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.tooltip.custom_js') }}">
                            <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                        </span>
                    </div>
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="custom_fonts"
                        {{ isset($feature) && $feature->custom_fonts == 1 ? 'checked' : '' }} />
                    <div>
                        {{ __('messages.feature.custom_fonts') }}
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.tooltip.custom_fonts') }}">
                            <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                        </span>
                    </div>
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="products"
                        {{ isset($feature) && $feature->products == 1 ? 'checked' : '' }} />
                    {{ __('messages.plan.products') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="appointments"
                        {{ isset($feature) && $feature->appointments == 1 ? 'checked' : '' }} />
                    {{ __('messages.vcard.appointments') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="gallery"
                        {{ isset($feature) && $feature->gallery == 1 ? 'checked' : '' }} />
                    {{ __('messages.plan.gallery') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="analytics"
                        {{ isset($feature) && $feature->analytics == 1 ? 'checked' : '' }} />
                    {{ __('messages.plan.analytics') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="seo"
                        {{ isset($feature) && $feature->seo == 1 ? 'checked' : '' }} />
                    {{ __('messages.plan.seo') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="blog"
                        {{ isset($feature) && $feature->blog == 1 ? 'checked' : '' }} />
                    {{ __('messages.plan.blog') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="affiliation"
                        {{ isset($feature) && $feature->affiliation == 1 ? 'checked' : '' }} />
                    {{ __('messages.plan.affiliation') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="custom_qrcode"
                        {{ isset($feature) && $feature->custom_qrcode == 1 ? 'checked' : '' }} />
                    {{ __('messages.plan.custom_qrcode') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="insta_embed"
                        {{ isset($feature) && $feature->insta_embed == 1 ? 'checked' : '' }} />
                    {{ __('messages.feature.insta_embed') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="linkedin_embed"
                        {{ isset($feature) && $feature->linkedin_embed == 1 ? 'checked' : '' }} />
                    {{ __('messages.feature.linkedin_embed') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="iframes"
                        {{ isset($feature) && $feature->iframes == 1 ? 'checked' : '' }} />
                    {{ __('messages.vcard.iframe') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1" name="dynamic_vcard"
                        {{ isset($feature) && $feature->dynamic_vcard == 1 ? 'checked' : '' }} />
                    {{ __('messages.Dynamic_vcard') }}
                    <span data-bs-toggle="tooltip" data-placement="top"
                        data-bs-original-title="{{ __('messages.tooltip.dynamic_vcard') }}">
                        <i class="fas fa-question-circle ml-1 general-question-mark"></i>
                    </span>
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" type="checkbox" value="1"
                        name="allow_custom_domain"
                        {{ isset($feature) && $feature->allow_custom_domain == 1 ? 'checked' : '' }} />
                    {{ __('messages.feature.allow_custom_domain') }}
                </label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xx-6 col-6 mb-5 p-0">
                <label class="form-label form-check p-0">
                    <input class="form-check-input feature mx-2" id="whatsappStoreCheck" type="checkbox"
                        value="1" name="whatsapp_store"
                        {{ isset($feature) && $feature->whatsapp_store == 1 ? 'checked' : '' }} />
                    {{ __('messages.whatsapp_stores.whatsapp_stores') }}
                </label>
                <div class="col-xxl-12 col-lg-12 p-2 col-md-2 col-5 mb-5 col-xs p-0 {{ isset($feature) && $feature->whatsapp_store == 1 ? '' : 'd-none' }}"
                    id="whatsappStore">
                    <input type="number" required class="form-control"
                        value="{{ $plan->no_of_whatsapp_store ?? '' }}" name="no_of_whatsapp_store"
                        placeholder="{{ __('messages.plan.no_of_whatsapp_stores') }}">
                </div>
            </div>
        </div>
    </div>
    <div>
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'planFormSubmit']) }}
        <a href="{{ route('plans.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
</div>
