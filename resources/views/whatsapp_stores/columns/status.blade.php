@if (getLogInUser()->hasrole('super_admin'))
    @if ($row->status == 1)
        <span class="badge bg-success">{{ __('messages.common.active') }}</span>
    @else
        <span class="badge bg-danger">{{ __('messages.placeholder.de_active') }}</span>
    @endif
@else
    <div class="d-flex align-items-center">
        <label class="form-check form-switch mb-0">
            <input name="is_active" data-id="{{ $row->id }}" class="form-check-input whatsappStoreStatus"
                type="checkbox" value="1" {{ $row->status ? 'checked' : '' }}>
        </label>
    </div>
@endif
