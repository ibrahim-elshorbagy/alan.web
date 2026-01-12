@php
  $statusIcon = '';
  $statusTooltip = '';
  $receivedIcon = '';
  $receivedTooltip = '';
  $isClickable = false;

  if ($row->status == \App\Models\RedirectLink::STATUS_REDEEMED) {
      $statusIcon = 'fas fa-check-circle text-success';
      $statusTooltip = __('messages.redirect_links.redeemed');
  } elseif ($row->status == \App\Models\RedirectLink::STATUS_REJECTED) {
      $statusIcon = 'fas fa-times-circle text-danger';
      $statusTooltip = __('messages.redirect_links.rejected');
  } else {
      $statusIcon = 'fas fa-clock text-warning';
      $statusTooltip = __('messages.redirect_links.not_redeemed');
  }

  if ($row->received_status == \App\Models\RedirectLink::RECEIVED_STATUS_RECEIVED) {
      $receivedIcon = 'fas fa-box-open text-success';
      $receivedTooltip = __('messages.redirect_links.received');
  } else {
      $receivedIcon = 'fas fa-box text-muted';
      $receivedTooltip = __('messages.redirect_links.not_received');
  }

  if (auth()->user()->hasRole('sales') && $row->assigned_id == auth()->id()) {
      $isClickable = true;
  }
@endphp

<div class="d-flex justify-content-center gap-2">
  <i class="{{ $statusIcon }}" data-bs-toggle="tooltip" title="{{ $statusTooltip }}"></i>
  @if ($isClickable)
    <i class="{{ $receivedIcon }} cursor-pointer" data-bs-toggle="tooltip" title="{{ $receivedTooltip }}"
      wire:click="markAsReceived({{ $row->id }})"></i>
  @else
    <i class="{{ $receivedIcon }}" data-bs-toggle="tooltip" title="{{ $receivedTooltip }}"></i>
  @endif
</div>
