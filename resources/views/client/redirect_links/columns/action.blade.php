<a href="javascript:void(0)"
  @click="if(confirm('{{ __('messages.common.delete_confirm') }}')) $wire.call('delete', {{ $row->id }})"
  class="btn btn-sm btn-danger ms-1" title="{{ __('messages.common.delete') }}">
  <i class="fas fa-trash"></i>
</a>
