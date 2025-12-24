<div class="row">
    <div class="col-lg-12 mb-7">
        {{ Form::label('custom_css', __('messages.vcard.custom_css') . ':', ['class' => 'form-label']) }}
        {{ Form::textarea('custom_css', $setting['custom_css'] ?? null, ['class' => 'form-control', 'placeholder' => __('messages.form.css'), 'rows' => '5']) }}
    </div>

    <div class="col-lg-12 d-flex">
        <button type="submit" class="btn btn-primary me-3">
            {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('setting.advanced') }}"
            class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
</div>
