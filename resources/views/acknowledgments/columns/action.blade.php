<div class="text-center">
  <a href="{{ route('acknowledgments.view', $row->id) }}" class="btn btn-sm btn-info" target="_blank"
    data-bs-toggle="tooltip" title="{{ __('messages.view_acknowledgment') }}">
    <i class="fas fa-eye"></i>
  </a>

  @if (auth()->user()->hasRole('super_admin'))
    <a href="{{ route('acknowledgments.edit', $row->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
      title="{{ __('messages.common.edit') }}">
      <i class="fas fa-edit"></i>
    </a>

    <button type="button" class="btn btn-sm btn-danger" wire:click="delete({{ $row->id }})"
      onclick="return confirm('{{ __('messages.common.delete_confirm') }}')" data-bs-toggle="tooltip"
      title="{{ __('messages.common.delete') }}">
      <i class="fas fa-trash"></i>
    </button>
  @endif
</div>
