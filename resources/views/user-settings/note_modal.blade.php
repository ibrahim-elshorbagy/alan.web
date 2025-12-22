@if ($customDomain && $customDomain->is_approved == 1)
<div class="modal fade" id="noteModal{{ $customDomain->id }}" tabindex="-1" aria-labelledby="noteModalLabel{{ $customDomain->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-top">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="noteModalLabel{{ $customDomain->id }}">{{ __('messages.custom_domain.custom_domain_notes') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             {!! $customDomain->note ?? '<em>No note available</em>' !!}
            </div>
        </div>
    </div>
</div>
@endif
