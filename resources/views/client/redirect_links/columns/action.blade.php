<div class="d-flex gap-2 justify-content-center">

  <a href="{{ route('client.redirect-links.ad-settings', $row->id) }}" class="btn btn-sm btn-warning"
    title="{{ __('messages.sales_advertise.advertise_settings') }}">
    <i class="fa-solid fa-bullhorn"></i>
  </a>
  <a href="javascript:void(0)"
    @click="if(confirm('{{ __('messages.common.delete_confirm') }}')) $wire.call('delete', {{ $row->id }})"
    class="btn btn-sm btn-danger" title="{{ __('messages.common.delete') }}">
    <i class="fas fa-trash"></i>
  </a>
</div>