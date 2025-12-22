<div class="modal fade common-modal-card" id="vcardCloneModal" tabindex="-1" aria-labelledby="vcardCloneModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.vcard.clone_to') }}</h3>
                <button type="button" class="modal-close bg-transparent p-0 border-0" data-bs-dismiss="modal" aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Menu / Close_MD"> <path id="Vector" d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                </button>
            </div>
            <form id="cloneVcardForm">
                <div class="modal-body pb-0 pt-2">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label required">{{ __('messages.users') }}</label>
                            <select id="user_id" class="form-control">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-4 justify-content-start">
                    <button type="submit" class="sadmin-duplicate-vcard-btn btn btn-primary d-flex align-items-center"
                        id="duplicateVcardBtn">
                        {{ __('messages.vcard.clone_to') }}
                    </button>
                    <button type="button" class="btn discard-btn"
                        data-bs-dismiss="modal">{{ __('crud.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
