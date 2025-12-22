<div class="modal fade" id="customDomainRejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('Custom Domain Rejection') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customDomainRejectForm">
                    <input type="hidden" name="id" id="customDomainId">
                    <div class="form-group">
                        <label class="form-label required">{{ __('Reject Reason') }}</label>
                        <textarea class="form-control" name="rejection_note" rows="4" id="rejectionNote"
                            placeholder="{{ __('Enter rejection reason') }}" required></textarea>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="submit" id="customDomainRejectBtn" class="btn btn-primary m-0">{{ __('crud.save') }}
                        </button>
                        <button  class="btn btn-secondary my-0 ms-5 me-0"
                            data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
