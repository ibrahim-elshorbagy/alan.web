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
      background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
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

    .table-custom th {
      background: #f1f3f5;
      font-weight: 600;
      border-bottom: 2px solid #dee2e6;
      white-space: nowrap;
    }

    .report-type-btn {
      border-radius: 20px;
      margin: 0 5px;
      transition: all 0.3s ease;
    }

    .report-type-btn.active {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-color: #667eea;
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
    <h3 class="mb-2">{{ __('messages.redirect_links.history_report') }}</h3>
    <p class="text-muted">{{ __('messages.redirect_links.history_report_description') }}</p>
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
        <div class="col-md-3 col-sm-6 col-12">
          <label class="form-label small mb-1">{{ __('messages.redirect_links.assigned_to') }}</label>
          <select class="form-control form-select" wire:model.live="assignedFilter">
            <option value="">{{ __('messages.common.all') }}</option>
            @foreach ($salesUsers as $salesUser)
              <option value="{{ $salesUser->id }}">{{ $salesUser->first_name }} {{ $salesUser->last_name }}</option>
            @endforeach
          </select>
        </div>
      @endif

      {{-- Reset Button --}}
      <div class="col-md-2 col-sm-6 col-12">
        <button class="btn btn-outline-secondary w-100" wire:click="resetFilters">
          <i class="fas fa-undo"></i> {{ __('messages.common.reset') }}
        </button>
      </div>
    </div>
  </div>

  {{-- Report Type Selector --}}
  <div class="mb-3 d-flex flex-wrap gap-2 justify-content-center">
    <button class="btn report-type-btn {{ $reportType === 'redeemed' ? 'active' : 'btn-outline-success' }}"
      wire:click="$set('reportType', 'redeemed')">
      <i class="fas fa-user-check"></i> {{ __('messages.redirect_links.redeemed_users') }}
    </button>
    <button class="btn report-type-btn {{ $reportType === 'deleted' ? 'active' : 'btn-outline-danger' }}"
      wire:click="$set('reportType', 'deleted')">
      <i class="fas fa-user-times"></i> {{ __('messages.redirect_links.user_deleted_redirect_link') }}
    </button>
    <button class="btn report-type-btn {{ $reportType === 'active' ? 'active' : 'btn-outline-info' }}"
      wire:click="$set('reportType', 'active')">
      <i class="fas fa-user-shield"></i> {{ __('messages.redirect_links.user_active_redirect_link') }}
    </button>
  </div>

  {{-- Summary Cards --}}
  <div class="summary-card">
    <div class="row g-2">
      <div class="col-md-4 col-12">
        <div class="stat">
          <div class="stat-value">{{ number_format($redeemedCount) }}</div>
          <div class="stat-label">{{ __('messages.redirect_links.total_redeemed') }}</div>
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="stat">
          <div class="stat-value">{{ number_format($deletedCount) }}</div>
          <div class="stat-label">{{ __('messages.redirect_links.total_deleted') }}</div>
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="stat">
          <div class="stat-value">{{ number_format($activeCount) }}</div>
          <div class="stat-label">{{ __('messages.redirect_links.total_active') }}</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Data Table --}}
  <div class="table-responsive">
    <table class="table table-custom table-striped table-hover">
      <thead>
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">{{ __('messages.redirect_links.uri') }}</th>
          <th class="text-center">{{ __('messages.redirect_links.user_name') }}</th>
          <th class="text-center">{{ __('messages.redirect_links.action') }}</th>
          <th class="text-center">{{ __('messages.redirect_links.date') }}</th>
          @if (!auth()->user()->hasRole('sales'))
            <th class="text-center">{{ __('messages.redirect_links.assigned_to') }}</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse ($displayData as $index => $record)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">
              <a href="{{ url('/auto-' . $record->uri) }}" target="_blank"
                class="text-decoration-none fw-bold">
                {{ $record->uri }}
              </a>

            </td>
            <td class="text-center">
              @if ($record->action === 'user_redeem')
                {{ $record->new_value }}
              @elseif ($record->action === 'user_deleted_link')
                {{ $record->old_value }}
              @else
                {{ $record->new_value }}
              @endif
            </td>
            <td class="text-center">
              @if ($record->action === 'user_redeem')
                <span class="badge bg-success">{{ __('messages.redirect_links.redeemed') }}</span>
              @elseif ($record->action === 'user_deleted_link')
                <span class="badge bg-danger">{{ __('messages.redirect_links.deleted') }}</span>
              @endif
            </td>
            <td class="text-center">
              {{ \Carbon\Carbon::parse($record->created_at)->format('Y-m-d H:i') }}
            </td>
            @if (!auth()->user()->hasRole('sales'))
              <td class="text-center">
                @if ($record->assigned_id)
                  @php
                    $assignedUser = \App\Models\User::withoutGlobalScopes()->find($record->assigned_id);
                  @endphp
                  @if ($assignedUser)
                    {{ $assignedUser->first_name }} {{ $assignedUser->last_name }}
                  @else
                    <span class="text-muted">-</span>
                  @endif
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
            @endif
          </tr>
        @empty
          <tr>
            <td colspan="{{ auth()->user()->hasRole('sales') ? '5' : '6' }}" class="text-center text-muted py-5">
              <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
              {{ __('messages.redirect_links.no_history_records') }}
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Export Button --}}
  {{-- @if ($displayData->count() > 0)
    <div class="mt-3 d-flex justify-content-end">
      <button class="btn btn-primary" onclick="window.print()">
        <i class="fas fa-print"></i> {{ __('messages.common.print') }}
      </button>
    </div>
  @endif --}}
</div>
