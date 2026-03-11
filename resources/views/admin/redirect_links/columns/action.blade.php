<div class="d-flex gap-2 justify-content-center">
  <a href="{{ route('redirect-links.edit', $row->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
    title="{{ __('messages.common.edit') }}" target="_blank">
    <i class="fas fa-edit"></i>
  </a>
  @if (!auth()->user()->hasRole('sales'))
    <a href="{{ route('redirect-links.export-contests', $row->id) }}" class="btn btn-sm btn-success"
      data-bs-toggle="tooltip" title="{{ __('messages.contest.export_all_contests') }}" target="_blank">
      <i class="fa-solid fa-file-excel"></i>
    </a>
  @endif
  @if (!auth()->user()->hasRole('sales'))
    <a href="{{ route('redirect-links.ad-settings', $row->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
      title="{{ __('messages.sales_advertise.advertise_settings') }}" target="_blank">
      <i class="fa-solid fa-bullhorn"></i>
    </a>
  @endif
  @if (!auth()->user()->hasRole('sales'))
    <button type="button" class="btn btn-sm btn-danger" wire:click="delete({{ $row->id }})"
      wire:confirm="{{ __('messages.common.are_you_sure') }}" data-bs-toggle="tooltip"
      title="{{ __('messages.common.delete') }}">
      <i class="fas fa-trash"></i>
    </button>
  @endif
</div>