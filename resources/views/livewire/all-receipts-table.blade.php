<div>
  @php
    // Calculate analytics
    $totalReceipts = \App\Models\Receipt::count();
    $totalAmount = \App\Models\Receipt::sum('amount');
    $thisMonthReceipts = \App\Models\Receipt::whereMonth('received_at', now()->month)
        ->whereYear('received_at', now()->year)
        ->count();
    $thisMonthAmount = \App\Models\Receipt::whereMonth('received_at', now()->month)
        ->whereYear('received_at', now()->year)
        ->sum('amount');
    $uniqueUsers = \App\Models\Receipt::distinct('user_id')->count('user_id');
  @endphp

  <!-- Analytics Cards -->
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">{{ __('messages.receipts.total_receipts') }}</h5>
          <h2 class="text-primary">{{ number_format($totalReceipts) }}</h2>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">{{ __('messages.receipts.total_amount') }}</h5>
          <h2 class="text-success">${{ number_format($totalAmount, 2) }}</h2>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">{{ __('messages.receipts.this_month_receipts') }}</h5>
          <h2 class="text-info">{{ number_format($thisMonthReceipts) }}</h2>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">{{ __('messages.receipts.unique_users') }}</h5>
          <h2 class="text-warning">{{ number_format($uniqueUsers) }}</h2>
        </div>
      </div>
    </div>
  </div>

  <!-- Receipts Table -->
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <livewire:all-receipts-table lazy />
      </div>
    </div>
  </div>
</div>
