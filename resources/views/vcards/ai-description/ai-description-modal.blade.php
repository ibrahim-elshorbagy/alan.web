<div class="modal fade" id="aiDescriptionModal" tabindex="-1" aria-labelledby="aiDescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aiDescriptionModalLabel">{{ __('messages.vcard.ai_description_generator') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="aiDescriptionTextarea" class="form-label">{{ __('messages.vcard.enter_ypur_prompt') }}:</label>
                    <textarea id="aiDescriptionTextarea" class="form-control" rows="6"
                        placeholder="{{ __('messages.vcard.enter_your_prompt_for_ai_vcard_description') }}"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="generateAiDescriptionBtn" class="btn btn-primary">
                    {{ __('messages.vcard.generate_description') }}
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('messages.common.discard') }}
                </button>
            </div>
        </div>
    </div>
</div>
