@if ($row->user)
  <a href="{{ route('receipts.index', $row->user->id) }}" class="btn btn-sm btn-primary">
    {{ $row->user->first_name . ' ' . $row->user->last_name }}
  </a>
@else
  N/A
@endif
