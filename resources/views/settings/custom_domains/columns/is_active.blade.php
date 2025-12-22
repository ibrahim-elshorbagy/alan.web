@php
    $checked = $row->is_active == 0 ? '' : 'checked';
    $disabled = $row->is_approved == 0 || $row->is_approved == 2 ? 'disabled' : '';
@endphp
<div class="d-flex align-items-center">
    <label class="form-check form-switch d-flex justify-content-center cursor-pointer">
        <input name="is_active" data-id="{{ $row->id }}"
            class="form-check-input custom-domain-is-active cursor-pointer" type="checkbox" value="1"
            {{ $checked }} {{ $disabled }}>
        <span class="switch-slider" data-checked="&#x2713;" data-unchecked="&#x2715;"></span>
    </label>
</div>
