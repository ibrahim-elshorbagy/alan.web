<div class="modal fade common-modal-card" id="uploadAddOnModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="mb-0">{{ __('messages.addon.upload_addon') }}</h2>
                <button type="button" class="modal-close p-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close">             
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Menu / Close_MD"> <path id="Vector" d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                </button>
            </div>
            {{ Form::open(['id' => 'addOnForm', 'files' => true, 'class' => 'addOnForm']) }}
            <div class="modal-body pt-0">
                <div class="alert alert-danger d-none hide" id="addonErrorsBox"></div>

                <div class="row">

                    <div class="form-group mb-3">
                        {{ Form::label('file', __('messages.addon.addon') . ':', ['class' => 'form-label required']) }}
                        <br>
                        {{ Form::file('file', [
                            'id' => 'addOnDocumentZip',
                            'class' => 'form-control',
                            'accept' => '.zip,application/zip',
                            'required',
                        ]) }}
                    </div>
                    <div class="modal-footer p-0 mt-4 justify-content-start">
                        {{ Form::button(__('messages.addon.upload'), ['type' => 'submit', 'class' => 'btn btn-primary m-0', 'id' => 'addOnBtnSave', 'data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                        <button type="button" aria-label="Close" class="btn btn-secondary discard-btn ms-3"
                            data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
