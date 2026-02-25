<div class="d-flex align-items-center justify-content-center gap-2">
  <span>{{ $row->assignedUser ? $row->assignedUser->first_name . ' ' . $row->assignedUser->last_name : 'N/A' }}</span>
  <button type="button" class="btn btn-sm p-0 border-0 bg-transparent {{ $row->note ? 'text-warning' : 'text-muted' }}"
    wire:click="openNoteModal({{ $row->id }})"
    title="{{ $row->note ? __('messages.redirect_links.note_has_content') : __('messages.redirect_links.add_note') }}"
    style="line-height: 1;">
    <i class="fas fa-sticky-note"></i>
  </button>
</div>