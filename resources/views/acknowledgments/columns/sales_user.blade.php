<div class="text-center">
  @if ($row->salesUser)
    <div>{{ $row->salesUser->first_name }} {{ $row->salesUser->last_name }}</div>
    <small class="text-muted">{{ $row->salesUser->email }}</small>
  @else
    <span class="text-muted">-</span>
  @endif
</div>
