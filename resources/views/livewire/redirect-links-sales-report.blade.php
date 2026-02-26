<div>
  {{-- Loading Indicator --}}
  <div wire:loading.delay class="position-fixed top-50 start-50 translate-middle" style="z-index: 9999;">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <style>
    .filter-card {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .summary-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .summary-card .stat {
      text-align: center;
    }

    .summary-card .stat-value {
      font-size: 1.5rem;
      font-weight: 700;
    }

    .summary-card .stat-label {
      font-size: 0.85rem;
      opacity: 0.9;
    }

    .period-card {
      background: white;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      border: 1px solid #e9ecef;
    }

    .period-card .period-stat {
      text-align: center;
      padding: 10px;
    }

    .period-card .period-stat-value {
      font-size: 1.3rem;
      font-weight: 700;
      color: #333;
    }

    .period-card .period-stat-label {
      font-size: 0.8rem;
      color: #6c757d;
    }

    .period-card .period-stat-price {
      font-size: 0.85rem;
      color: #28a745;
      font-weight: 600;
    }

    .period-btn {
      border-radius: 20px;
      margin: 0 3px;
      transition: all 0.3s ease;
    }

    .period-btn.active {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-color: #667eea;
    }

    .table-custom th {
      background: #f1f3f5;
      font-weight: 600;
      border-bottom: 2px solid #dee2e6;
      white-space: nowrap;
    }

    .breakdown-card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      border: 1px solid #e9ecef;
    }

    .breakdown-card h6 {
      font-weight: 700;
      color: #333;
      margin-bottom: 15px;
    }

    @media (max-width: 768px) {
      .summary-card {
        padding: 15px;
      }

      .summary-card .stat-value {
        font-size: 1.2rem;
      }

      .summary-card .stat-label {
        font-size: 0.75rem;
      }

      .filter-card {
        padding: 15px;
      }

      .table-custom {
        font-size: 0.85rem;
      }

      .table-custom th,
      .table-custom td {
        padding: 8px 5px;
      }

      .period-card .period-stat-value {
        font-size: 1rem;
      }
    }
  </style>

  {{-- Flash Messages --}}
  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Page Header --}}
  <div class="mb-4">
    <h3 class="mb-2">{{ __('messages.redirect_links.sales_report') }}</h3>
    <p class="text-muted">{{ __('messages.redirect_links.sales_report_description') }}</p>
  </div>


  {{-- Period Selector --}}
  <div class="mb-3 d-flex flex-wrap gap-2 justify-content-center">
    <button class="btn period-btn {{ $periodFilter === 'today' ? 'active' : 'btn-outline-primary' }}"
      wire:click="$set('periodFilter', 'today')">
      <i class="fas fa-calendar-day"></i> {{ __('messages.redirect_links.today') }}
    </button>
    <button class="btn period-btn {{ $periodFilter === 'yesterday' ? 'active' : 'btn-outline-primary' }}"
      wire:click="$set('periodFilter', 'yesterday')">
      <i class="fas fa-calendar-minus"></i> {{ __('messages.redirect_links.yesterday') }}
    </button>
    <button class="btn period-btn {{ $periodFilter === 'week' ? 'active' : 'btn-outline-primary' }}"
      wire:click="$set('periodFilter', 'week')">
      <i class="fas fa-calendar-week"></i> {{ __('messages.redirect_links.this_week') }}
    </button>
    <button class="btn period-btn {{ $periodFilter === 'month' ? 'active' : 'btn-outline-primary' }}"
      wire:click="$set('periodFilter', 'month')">
      <i class="fas fa-calendar-alt"></i> {{ __('messages.redirect_links.this_month') }}
    </button>
    <button class="btn period-btn {{ $periodFilter === 'custom' ? 'active' : 'btn-outline-secondary' }}"
      wire:click="$set('periodFilter', 'custom')">
      <i class="fas fa-sliders-h"></i> {{ __('messages.redirect_links.custom_period') }}
    </button>
  </div>

  {{-- Filters Section --}}
  <div class="filter-card">
    <div class="row g-3 align-items-end">
      {{-- Date From --}}
      <div class="col-md-3 col-sm-6 col-12">
        <label class="form-label small mb-1">{{ __('messages.common.date_from') }}</label>
        <input type="date" class="form-control" wire:model.defer="dateFromFilter" wire:change="$refresh">
      </div>

      {{-- Date To --}}
      <div class="col-md-3 col-sm-6 col-12">
        <label class="form-label small mb-1">{{ __('messages.common.date_to') }}</label>
        <input type="date" class="form-control" wire:model.defer="dateToFilter" wire:change="$refresh">
      </div>

      {{-- Assigned To Filter (only for super_admin) --}}
      @if (!auth()->user()->hasRole('sales'))
        <div class="col-md-2 col-sm-6 col-12">
          <label class="form-label small mb-1">{{ __('messages.redirect_links.assigned_to') }}</label>
          <select class="form-control form-select" wire:model.live="assignedFilter">
            <option value="">{{ __('messages.common.all') }}</option>
            @foreach ($salesUsers as $salesUser)
              <option value="{{ $salesUser->id }}">{{ $salesUser->first_name }} {{ $salesUser->last_name }}</option>
            @endforeach
          </select>
        </div>
      @endif

      {{-- Card Type Filter --}}
      <div class="col-md-2 col-sm-6 col-12">
        <label class="form-label small mb-1">{{ __('messages.redirect_links.card_type') }}</label>
        <select class="form-control form-select" wire:model.live="cardTypeFilter">
          <option value="">{{ __('messages.common.all') }}</option>
          @foreach ($nfcCards as $nfc)
            <option value="{{ $nfc->id }}">{{ $nfc->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- Reset Button --}}
      <div class="col-md-2 col-sm-6 col-12">
        <button class="btn btn-outline-secondary w-100" wire:click="resetFilters">
          <i class="fas fa-undo"></i> {{ __('messages.common.reset') }}
        </button>
      </div>
    </div>
  </div>

  {{-- Main Summary Card --}}
  <div class="summary-card">
    <div class="row g-2">
      <div class="col-md-4 col-12">
        <div class="stat">
          <div class="stat-value">{{ number_format($totalCount) }}</div>
          <div class="stat-label">{{ __('messages.redirect_links.total_sales_count') }}</div>
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="stat">
          <div class="stat-value">{{ currencyFormat($totalPrice, 2) }}</div>
          <div class="stat-label">{{ __('messages.admin_price') }}</div>
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="stat">
          <div class="stat-value">{{ currencyFormat($totalSalesPrice, 2) }}</div>
          <div class="stat-label">{{ __('messages.sales_representative_price') }}</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Breakdown Cards (Side by Side) --}}
  <div class="row">
    {{-- Sales by Salesperson --}}
    @if (!auth()->user()->hasRole('sales'))
      <div class="col-md-6 col-12">
        <div class="breakdown-card">
          <h6><i class="fas fa-users"></i> {{ __('messages.redirect_links.sales_by_salesperson') }}</h6>
          <div class="table-responsive">
            <table class="table table-sm table-striped mb-0">
              <thead>
                <tr>
                  <th>{{ __('messages.redirect_links.assigned_to') }}</th>
                  <th class="text-center">{{ __('messages.redirect_links.count') }}</th>
                  <th class="text-center">{{ __('messages.admin_price') }}</th>
                  <th class="text-center">{{ __('messages.sales_representative_price') }}</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($salesBySalesperson as $row)
                  <tr>
                    <td>
                      @if ($row->assigned_id && isset($allSalesUsers[$row->assigned_id]))
                        {{ $allSalesUsers[$row->assigned_id]->first_name }}
                        {{ $allSalesUsers[$row->assigned_id]->last_name }}
                      @else
                        <span class="text-muted">{{ __('messages.redirect_links.not_assigned') }}</span>
                      @endif
                    </td>
                    <td class="text-center fw-bold">{{ number_format($row->total_sales) }}</td>
                    <td class="text-center text-success">{{ currencyFormat($row->total_price, 2) }}</td>
                    <td class="text-center text-info">{{ currencyFormat($row->total_sales_price, 2) }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center text-muted">{{ __('messages.redirect_links.no_sales_data') }}</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endif

    {{-- Sales by Card Type --}}
    <div class="{{ !auth()->user()->hasRole('sales') ? 'col-md-6' : 'col-12' }}">
      <div class="breakdown-card">
        <h6><i class="fas fa-id-card"></i> {{ __('messages.redirect_links.sales_by_card_type') }}</h6>
        <div class="table-responsive">
          <table class="table table-sm table-striped mb-0">
            <thead>
              <tr>
                <th>{{ __('messages.redirect_links.card_type') }}</th>
                <th class="text-center">{{ __('messages.redirect_links.count') }}</th>
                <th class="text-center">{{ __('messages.admin_price') }}</th>
                <th class="text-center">{{ __('messages.sales_representative_price') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($salesByCardType as $row)
                <tr>
                  <td>{{ $row->nfc_name ?? '-' }}</td>
                  <td class="text-center fw-bold">{{ number_format($row->total_sales) }}</td>
                  <td class="text-center text-success">{{ currencyFormat($row->total_price, 2) }}</td>
                  <td class="text-center text-info">{{ currencyFormat($row->total_sales_price, 2) }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted">{{ __('messages.redirect_links.no_sales_data') }}</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Detailed Sales Table --}}
  <div class="breakdown-card">
    <h6><i class="fas fa-list-alt"></i> {{ __('messages.redirect_links.sales_details') }}</h6>
    <div class="table-responsive">
      <table class="table table-custom table-striped table-hover">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th class="text-center">{{ __('messages.redirect_links.uri') }}</th>
            <th class="text-center">{{ __('messages.redirect_links.user_name') }}</th>
            <th class="text-center">{{ __('messages.redirect_links.card_type') }}</th>
            <th class="text-center">{{ __('messages.admin_price') }}</th>
            <th class="text-center">{{ __('messages.sales_representative_price') }}</th>
            <th class="text-center">{{ __('messages.redirect_links.date') }}</th>
            @if (!auth()->user()->hasRole('sales'))
              <th class="text-center">{{ __('messages.redirect_links.assigned_to') }}</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @forelse ($salesData as $index => $record)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td class="text-center">
                <a href="{{ url('/auto-' . $record->uri) }}" target="_blank" class="text-decoration-none fw-bold">
                  {{ $record->uri }}
                </a>
              </td>
              <td class="text-center">{{ $record->new_value }}</td>
              <td class="text-center">{{ $record->nfc_name ?? '-' }}</td>
              <td class="text-center text-success fw-bold">{{ currencyFormat($record->price ?? 0, 2) }}</td>
              <td class="text-center text-info fw-bold">{{ currencyFormat($record->sales_price ?? 0, 2) }}</td>
              <td class="text-center">
                {{ \Carbon\Carbon::parse($record->created_at)->format('Y-m-d H:i') }}
              </td>
              @if (!auth()->user()->hasRole('sales'))
                <td class="text-center">
                  @if ($record->assigned_id && isset($allSalesUsers[$record->assigned_id]))
                    {{ $allSalesUsers[$record->assigned_id]->first_name }}
                    {{ $allSalesUsers[$record->assigned_id]->last_name }}
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
              @endif
            </tr>
          @empty
            <tr>
              <td colspan="{{ auth()->user()->hasRole('sales') ? '6' : '7' }}" class="text-center text-muted py-5">
                <i class="fas fa-chart-bar fa-3x mb-3 d-block"></i>
                {{ __('messages.redirect_links.no_sales_data') }}
              </td>
            </tr>
          @endforelse
        </tbody>
        @if ($salesData->count() > 0)
          <tfoot>
            <tr class="fw-bold" style="background: #e9ecef;">
              <td colspan="{{ auth()->user()->hasRole('sales') ? '4' : '4' }}" class="text-center">
                {{ __('messages.common.total') }}
              </td>
              {{-- <td class="text-center">{{ number_format($totalCount) }}</td> --}}
              <td class="text-center text-success">{{ currencyFormat($totalPrice, 2) }}</td>
              <td class="text-center text-info">{{ currencyFormat($totalSalesPrice, 2) }}</td>
              <td colspan="{{ auth()->user()->hasRole('sales') ? '2' : '2' }}"></td>
            </tr>
          </tfoot>
        @endif
      </table>
    </div>
  </div>
</div>
