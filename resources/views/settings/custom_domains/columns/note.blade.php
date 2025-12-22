<style>
.modal-dialog-top {
    margin-top: 5rem !important; /* move modal to upper side */
}
</style>

<div>
    <!-- Note icon button -->
    <button type="button" class="btn btn-link p-0 text-primary"
            data-bs-toggle="modal"
            data-bs-target="#noteModal{{ $row->id }}">
        <i class="fa-regular fa-note-sticky fa-lg"></i>
    </button>

    <!-- Note Modal -->
    <div class="modal fade" id="noteModal{{ $row->id }}" tabindex="-1"
         aria-labelledby="noteModalLabel{{ $row->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-content ">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="noteModalLabel{{ $row->id }}">{{ __('messages.custom_domain.custom_domain_notes') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="quillEditor{{ $row->id }}" class="form-label fw-bold mb-2">
                        {{ __('messages.custom_domain.note') }}:
                    </label>
                    <div id="quillEditor{{ $row->id }}" class="quill-editor" style="height: 200px;">
                        {!! $row->note !!}
                    </div>
                    <input type="hidden" id="noteContent{{ $row->id }}" value="{!! $row->note !!}">
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-primary save-note-btn"
                            data-id="{{ $row->id }}"
                            data-url="{{ route('custom-domain.update-note', $row->id) }}">
                        {{ __('messages.common.save') }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
