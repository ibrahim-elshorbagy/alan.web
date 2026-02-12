<div class="text-center">
  @if ($row->creator)
    <div>{{ $row->creator->first_name }} {{ $row->creator->last_name }}</div>
  @else
    <span class="text-muted">-</span>
  @endif
</div>
