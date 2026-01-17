<div>
  <div class="d-flex text-center">
    @php
      $isSales = $row->roles->pluck('name')->contains('sales');
    @endphp

    @if ($isSales)
      <a href="{{ route('receipts.index', $row->id) }}" class="btn btn-sm btn-primary">
        {{ __('messages.receipts.receipts') }}
      </a>
    @else
      <span class="text-muted">-</span>
    @endif
  </div>
</div>
