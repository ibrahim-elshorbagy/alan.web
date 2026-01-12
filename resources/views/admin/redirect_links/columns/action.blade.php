<div class=" gap-2">
  <a href="{{ route('redirect-links.edit', $row->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
    title="{{ __('messages.common.edit') }}">
    <i class="fas fa-edit"></i>
  </a>
  @if (!auth()->user()->hasRole('sales'))
    <form action="{{ route('redirect-links.destroy', $row->id) }}" method="POST" style="display: inline;"
      onsubmit="return confirm('{{ __('messages.common.are_you_sure') }}')">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
        title="{{ __('messages.common.delete') }}">
        <i class="fas fa-trash"></i>
      </button>
    </form>
  @endif
</div>
