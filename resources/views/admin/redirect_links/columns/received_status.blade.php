@if ($row->received_status == \App\Models\RedirectLink::RECEIVED_STATUS_RECEIVED)
  <span class="badge bg-success">{{ __('messages.redirect_links.received') }}</span>
@else
  @if (auth()->user()->hasRole('sales') && $row->assigned_id == auth()->id())
    <button type="button" class="btn btn-sm btn-success"
      wire:click="markAsReceived({{ $row->id }})">{{ __('messages.redirect_links.mark_as_received') }}</button>
  @else
    <span class="badge bg-warning">{{ __('messages.redirect_links.not_received') }}</span>
  @endif
@endif
