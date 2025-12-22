@php
    $checked = $row->show_as_button == 0 ? '' : 'checked';
@endphp
<div class="d-flex justify-content-center align-items-center">
    <label class="form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex cursor-pointer">
        <input type="checkbox" name="status" class="form-check-input cursor-pointer show-as-button"
            data-id="{{ $row->id }}" {{ $checked }}>
        <span class="custom-switch-indicator"></span>
    </label>
</div>
