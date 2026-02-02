<a href="{{ route('client.redirect-links.edit', $row->id) }}"
  class="btn btn-sm btn-primary">{{ __('messages.common.edit') }}</a>
@if ($row->status == \App\Models\RedirectLink::STATUS_REDEEMED)
  <a href="javascript:void(0)"
    @click="if(confirm('{{ __('messages.common.delete_confirm') }}')) $wire.call('delete', {{ $row->id }})"
    class="btn btn-sm btn-danger ms-1">{{ __('messages.common.delete') }}</a>
@endif
