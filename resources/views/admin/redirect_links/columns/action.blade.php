<a href="{{ route('redirect-links.edit', $row->id) }}" class="btn btn-sm btn-primary">{{ __('messages.common.edit') }}</a>
@if(!auth()->user()->hasRole('sales'))
<form action="{{ route('redirect-links.destroy', $row->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ __('messages.common.are_you_sure') }}')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.common.delete') }}</button>
</form>
@endif
