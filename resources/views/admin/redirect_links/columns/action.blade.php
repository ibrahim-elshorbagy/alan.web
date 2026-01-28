<div class="d-flex gap-2 justify-content-center">
  <a href="{{ route('redirect-links.edit', $row->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
    title="{{ __('messages.common.edit') }}">
    <i class="fas fa-edit"></i>
  </a>
  @if (!auth()->user()->hasRole('sales'))
    <button type="button" class="btn btn-sm btn-danger" wire:click="delete({{ $row->id }})"
      wire:confirm="{{ __('messages.common.are_you_sure') }}" data-bs-toggle="tooltip"
      title="{{ __('messages.common.delete') }}">
      <i class="fas fa-trash"></i>
    </button>
  @endif
</div>
