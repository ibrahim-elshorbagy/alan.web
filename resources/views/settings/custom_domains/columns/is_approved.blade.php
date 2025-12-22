@if ($row->is_approved == App\Models\CustomDomain::PENDING)
    <div wire:ignore id="customDomainStatus-{{ $row->id }}">
        {{ Form::select('type', App\Models\CustomDomain::STATUS_ARR, null, ['class' => 'customDomainStatus', 'data-control' => 'select2', 'data-id' => $row->id]) }}
    </div>
    <div class="spinner-border text-primary text-center d-none" id="customDomainSpinner-{{ $row->id }}"
        role="status">
        <span class="sr-only">Loading...</span>
    </div>
@elseif ($row->is_approved == App\Models\CustomDomain::REJECTED)
    <span class="badge bg-light-danger">{{ __('messages.common.rejected') }}</span>
@elseif($row->is_approved == App\Models\CustomDomain::APPROVED)
    <span class="badge bg-light-success">{{ __('messages.common.approved') }}</span>
@endif
