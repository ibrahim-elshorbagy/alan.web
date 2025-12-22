<div class="modal fade" id="linkedinEmbedGuideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.LinkedinEmbedTag.Guide') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ol>
                    <li>{{ __('messages.LinkedinEmbedTag.step1') }}</li>
                    <li>{{ __('messages.LinkedinEmbedTag.step2') }}</li>
                    <li>{{ __('messages.LinkedinEmbedTag.step3') }}</li>
                </ol>

                <div class="mt-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                        <div>
                            <strong>{{ __('messages.custom_domain.note') }}:</strong>
                            {{ __('messages.LinkedinEmbedTag.linkedin_note') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
