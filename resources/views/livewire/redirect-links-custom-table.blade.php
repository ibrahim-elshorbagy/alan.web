<div x-data="{
    localSelected: @entangle('selected'),
    get hasSelected() { return this.localSelected && this.localSelected.length > 0; }
}">
  {{-- Loading Indicator --}}
  <div wire:loading.delay class="position-fixed top-50 start-50 translate-middle" style="z-index: 9999;">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <style>
    .group-accordion {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      margin-bottom: 15px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .group-accordion-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 15px 20px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.3s ease;
    }

    .group-accordion-header:hover {
      background: linear-gradient(135deg, #5a67d8 0%, #6b46a1 100%);
    }

    .group-accordion-header .group-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .group-accordion-header .group-name {
      font-size: 1.1rem;
      font-weight: 600;
    }

    .group-accordion-header .group-stats {
      display: flex;
      gap: 20px;
    }

    .group-accordion-header .stat-item {
      background: rgba(255, 255, 255, 0.2);
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
    }

    .group-accordion-header .chevron {
      transition: transform 0.15s ease;
    }

    .group-accordion-header.expanded .chevron {
      transform: rotate(180deg);
    }

    .group-accordion-body {
      background: #fff;
      display: none;
    }

    .group-accordion-body.show {
      display: block;
    }

    .filter-card {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .table-custom th {
      background: #f1f3f5;
      font-weight: 600;
      border-bottom: 2px solid #dee2e6;
    }

    .sort-icon {
      opacity: 0.5;
      margin-left: 5px;
    }

    .sort-icon.active {
      opacity: 1;
      color: #667eea;
    }

    .btn-group-toggle .btn {
      border-radius: 20px;
      margin: 0 5px;
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

  {{-- Filters Section --}}
  <div class="filter-card">
    <div class="row g-3 align-items-end">
      {{-- Search --}}
      <div class="col-md-3">
        <label class="form-label small mb-1">{{ __('messages.common.search') }}</label>
        <input type="text" class="form-control" wire:model.live.debounce.500ms="searchQuery"
          placeholder="{{ __('messages.common.search') }}...">
      </div>

      {{-- Assigned To Filter (only for non-sales users) --}}
      @if (!auth()->user()->hasRole('sales'))
        <div class="col-md-2">
          <label class="form-label small mb-1">{{ __('messages.redirect_links.assigned_to') }}</label>
          <select class="form-control form-select" wire:model.live="assignedFilter">
            <option value="">{{ __('messages.common.all') }}</option>
            @foreach ($salesUsers as $salesUser)
              <option value="{{ $salesUser->id }}">{{ $salesUser->first_name }} {{ $salesUser->last_name }}</option>
            @endforeach
          </select>
        </div>
      @endif

      {{-- Status Filter --}}
      <div class="col-md-2">
        <label class="form-label small mb-1">{{ __('messages.redirect_links.status') }}</label>
        <select class="form-control form-select" wire:model.live="statusFilter">
          <option value="">{{ __('messages.common.all') }}</option>
          <option value="0">{{ __('messages.redirect_links.not_redeemed') }}</option>
          <option value="1">{{ __('messages.redirect_links.redeemed') }}</option>
          <option value="2">{{ __('messages.redirect_links.rejected') }}</option>
        </select>
      </div>

      {{-- Redirect Type Filter --}}
      <div class="col-md-2">
        <label class="form-label small mb-1">{{ __('messages.redirect_links.redirect_type') }}</label>
        <select class="form-control form-select" wire:model.live="redirectTypeFilter">
          <option value="">{{ __('messages.common.all') }}</option>
          @foreach ($redirectTypes as $type)
            <option value="{{ $type->value }}">{{ $type->label() }}</option>
          @endforeach
        </select>
      </div>

      {{-- Card Type Filter --}}
      <div class="col-md-2">
        <label class="form-label small mb-1">{{ __('messages.redirect_links.card_type') }}</label>
        <select class="form-control form-select" wire:model.live="cardTypeFilter">
          <option value="">{{ __('messages.common.all') }}</option>
          @foreach ($nfcCards as $nfc)
            <option value="{{ $nfc->id }}">{{ $nfc->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- Date From --}}
      <div class="col-md-2">
        <label class="form-label small mb-1">{{ __('messages.common.date_from') }}</label>
        <input type="date" class="form-control" wire:model.defer="dateFromFilter" wire:change="$refresh">
      </div>

      {{-- Date To --}}
      <div class="col-md-2">
        <label class="form-label small mb-1">{{ __('messages.common.date_to') }}</label>
        <input type="date" class="form-control" wire:model.defer="dateToFilter" wire:change="$refresh">
      </div>

      {{-- Group By Filter (only for super admin) --}}
      @if (auth()->user()->hasRole('super_admin'))
        <div class="col-md-2">
          <label class="form-label small mb-1">{{ __('messages.redirect_links.group_by') }}</label>
          <select class="form-control form-select" wire:model.live="groupByFilter">
            <option value="">{{ __('messages.redirect_links.no_grouping') }}</option>
            <option value="redirect_type">{{ __('messages.redirect_links.redirect_type') }}</option>
            <option value="nfc_card">{{ __('messages.redirect_links.card_type') }}</option>
            <option value="sales_rep">{{ __('messages.redirect_links.assigned_to') }}</option>
          </select>
        </div>
      @endif

      {{-- Per Page --}}
      <div class="col-md-1">
        <label class="form-label small mb-1">{{ __('messages.common.per_page') }}</label>
        <select class="form-control form-select" wire:model.live="perPage">
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
          <option value="200">200</option>
        </select>
      </div>

      {{-- Reset Button --}}
      <div class="col-md-1">
        <button class="btn btn-outline-secondary w-100" wire:click="resetFilters">
          <i class="fas fa-undo"></i>
        </button>
      </div>
    </div>
  </div>

  {{-- Action Buttons --}}
  <div class="d-flex flex-wrap gap-2 mb-3">
    <template x-if="hasSelected">
      <div class="d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-warning" @click="$wire.exportSelected()">
          <i class="fas fa-file-export"></i> {{ __('messages.common.export_selected') }}
        </button>

        <button type="button" class="btn btn-success" @click="$wire.markSelectedAsReceived()">
          <i class="fas fa-check"></i> {{ __('messages.redirect_links.mark_selected_as_received') }}
        </button>

        <button type="button" class="btn btn-danger"
          @click="if(confirm('{{ __('messages.common.delete_confirm') }}')) { $wire.deleteSelected() }"">
          <i class="fas fa-trash"></i> {{ __('messages.common.delete_selected') }}
        </button>

        @if (auth()->user()->hasRole('super_admin'))
          <button type="button" class="btn btn-info" wire:click="syncAndRestore"
            wire:confirm="{{ __('messages.redirect_links.restore_confirmation') }}">
            <i class="fas fa-undo"></i> {{ __('messages.redirect_links.restore_selected') }}
          </button>
        @endif
      </div>
    </template>

    {{-- <a type="button" class="btn btn-success" href="{{ route('redirect-links.extract-all') }}">
      <i class="fas fa-download"></i> {{ __('messages.common.extract_all') }}
    </a> --}}

    @if (auth()->user()->hasRole('sales'))
      <form action="{{ route('redirect-links.mark-all-as-received') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-success" data-bs-toggle="tooltip"
          title="{{ __('messages.redirect_links.mark_all_tooltip') }}"
          onclick="return confirm('{{ __('messages.redirect_links.mark_all_confirm') }}')">
          {{ __('messages.redirect_links.received_all') }}
        </button>
      </form>
    @endif

    @if (!auth()->user()->hasRole('sales'))
      <a type="button" class="btn btn-primary" href="{{ route('redirect-links.create') }}">
        <i class="fas fa-plus"></i> {{ __('messages.common.add') }}
      </a>
    @endif

    {{-- Expand/Collapse All buttons when grouped --}}
    {{-- @if ($isGrouped)
      <div class="ms-auto">
        <button class="btn btn-outline-primary btn-sm" wire:click="expandAllGroups">
          <i class="fas fa-expand-alt"></i> {{ __('messages.redirect_links.expand_all') }}
        </button>
        <button class="btn btn-outline-secondary btn-sm" wire:click="collapseAllGroups">
          <i class="fas fa-compress-alt"></i> {{ __('messages.redirect_links.collapse_all') }}
        </button>
      </div>
    @endif --}}
  </div>

  {{-- Summary Card --}}
  <div class="summary-card">
    <div class="row">
      <div class="col-md-{{ auth()->user()->hasRole('sales') ? '4' : '3' }}">
        <div class="stat">
          <div class="stat-value">{{ $totalCount }}</div>
          <div class="stat-label">{{ __('messages.common.total') }} {{ __('messages.common.items') }}</div>
        </div>
      </div>
      <div class="col-md-{{ auth()->user()->hasRole('sales') ? '4' : '3' }}">
        <div class="stat">
          <div class="stat-value" x-text="localSelected ? localSelected.length : 0"></div>
          <div class="stat-label">{{ __('messages.common.selected') }}</div>
        </div>
      </div>
      @if (!auth()->user()->hasRole('sales'))
        <div class="col-md-3">
          <div class="stat">
            <div class="stat-value">{{ currencyFormat($totalPurchasePrice, 2) }}</div>
            <div class="stat-label">{{ __('messages.admin_price') }}</div>
          </div>
        </div>
      @endif
      <div class="col-md-{{ auth()->user()->hasRole('sales') ? '4' : '3' }}">
        <div class="stat">
          <div class="stat-value">{{ currencyFormat($totalSalesPrice, 2) }}</div>
          <div class="stat-label">
            {{ auth()->user()->hasRole('sales') ? __('messages.admin_price') : __('messages.sales_representative_price') }}
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- GROUPED VIEW (Accordion Style) --}}
  @if ($isGrouped)
    @if ($totalCount > 500)
      <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Performance Notice:</strong> Showing first 500 items. Use filters to narrow down results for better
        performance.
      </div>
    @endif
    <div class="grouped-view">
      @foreach ($groupedData as $groupKey => $allItems)
        @php
          $isExpanded = in_array((string) $groupKey, $expandedGroups);
          $groupPurchasePrice = $this->getGroupPurchasePrice($allItems);
          $groupSalesPrice = $this->getGroupSalesPrice($allItems);
          $items = $isExpanded ? $this->getGroupItems($groupKey, $allItems) : collect();
          $totalPages = $this->getGroupTotalPages($groupKey, $allItems);
          $currentPage = $this->groupPages[$groupKey] ?? 1;
        @endphp
        <div class="group-accordion">
          <div class="group-accordion-header {{ $isExpanded ? 'expanded' : '' }}"
            wire:click="toggleGroup('{{ $groupKey }}')">
            <div class="group-info">
              <i class="fas fa-folder{{ $isExpanded ? '-open' : '' }} fa-lg"></i>
              <span class="group-name">{{ $this->getGroupName($groupKey) }}</span>
            </div>
            <div class="group-stats">
              <span class="stat-item">
                <i class="fas fa-list"></i> {{ $allItems->count() }} {{ __('messages.common.items') }}
              </span>
              @if (!auth()->user()->hasRole('sales'))
                <span class="stat-item">
                  <i class="fas fa-money-bill"></i> {{ currencyFormat($groupPurchasePrice, 2) }}
                </span>
              @endif
              <span class="stat-item">
                <i class="fas fa-coins"></i> {{ currencyFormat($groupSalesPrice, 2) }}
              </span>
              <i class="fas fa-chevron-down chevron"></i>
            </div>
          </div>
          <div class="group-accordion-body {{ $isExpanded ? 'show' : '' }}">
            <div class="table-responsive">
              <table class="table table-custom table-striped table-hover mb-0">
                <thead wire:key="group-header-{{ $groupKey }}-{{ count($selected) }}">
                  <tr>
                    <th class="text-center" style="width: 40px;">
                      @php
                        $groupItemIds = $items->pluck('id')->map(fn($id) => (string) $id)->toArray();
                        $allGroupSelected =
                            !empty($groupItemIds) &&
                            !empty($selected) &&
                            count(array_intersect($groupItemIds, $selected)) === count($groupItemIds);
                      @endphp
                      <input type="checkbox"
                        wire:click="toggleGroupSelectAll('{{ $groupKey }}', {{ $items->toJson() }})"
                        @checked($allGroupSelected)>
                    </th>
                    <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('id')">
                      {{ __('messages.redirect_links.serial_number') }}
                      <i class="fas fa-sort sort-icon {{ $sortField === 'id' ? 'active' : '' }}"></i>
                    </th>
                    <th class="text-center">{{ __('messages.redirect_links.user') }}</th>
                    <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('uri')">
                      {{ __('messages.redirect_links.redeem_code') }}
                      <i class="fas fa-sort sort-icon {{ $sortField === 'uri' ? 'active' : '' }}"></i>
                    </th>
                    <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('redirect_link_type')">
                      {{ __('messages.redirect_links.redirect_link_type') }}
                      <i class="fas fa-sort sort-icon {{ $sortField === 'redirect_link_type' ? 'active' : '' }}"></i>
                    </th>
                    <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('status')">
                      {{ __('messages.redirect_links.status') }}
                      <i class="fas fa-sort sort-icon {{ $sortField === 'status' ? 'active' : '' }}"></i>
                    </th>
                    @if (!auth()->user()->hasRole('sales'))
                      <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('price')">
                        {{ __('messages.admin_price') }}
                        <i class="fas fa-sort sort-icon {{ $sortField === 'price' ? 'active' : '' }}"></i>
                      </th>
                    @endif
                    <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('sales_price')">
                      {{ auth()->user()->hasRole('sales') ? __('messages.admin_price') : __('messages.sales_representative_price') }}
                      <i class="fas fa-sort sort-icon {{ $sortField === 'sales_price' ? 'active' : '' }}"></i>
                    </th>
                    @if (!auth()->user()->hasRole('sales'))
                      <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('assigned_id')">
                        {{ __('messages.redirect_links.assigned_to') }}
                        <i class="fas fa-sort sort-icon {{ $sortField === 'assigned_id' ? 'active' : '' }}"></i>
                      </th>
                    @endif
                    <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('updated_at')">
                      {{ __('messages.common.dates') }}
                      <i class="fas fa-sort sort-icon {{ $sortField === 'updated_at' ? 'active' : '' }}"></i>
                    </th>
                    <th class="text-center">{{ __('messages.common.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($items as $row)
                    <tr>
                      <td class="text-center">
                        <input type="checkbox" wire:model.defer="selected" value="{{ $row->id }}">
                      </td>
                      <td class="text-center">
                        @include('admin.redirect_links.columns.serial_number', ['row' => $row])
                      </td>
                      <td class="text-center">
                        @include('admin.redirect_links.columns.user', ['row' => $row])
                      </td>
                      <td class="text-center">
                        @include('admin.redirect_links.columns.uri', ['row' => $row])
                      </td>
                      <td class="text-center">
                        @include('admin.redirect_links.columns.redirect_link_type', ['row' => $row])
                      </td>
                      <td class="text-center">
                        @include('admin.redirect_links.columns.combined_status', ['row' => $row])
                      </td>
                      @if (!auth()->user()->hasRole('sales'))
                        <td class="text-center">
                          @include('admin.redirect_links.columns.price', ['row' => $row])
                        </td>
                      @endif
                      <td class="text-center">
                        @include('admin.redirect_links.columns.sales_price', ['row' => $row])
                      </td>
                      @if (!auth()->user()->hasRole('sales'))
                        <td class="text-center">
                          @include('admin.redirect_links.columns.assigned_to', ['row' => $row])
                        </td>
                      @endif
                      <td class="text-center">
                        @include('admin.redirect_links.columns.dates', ['row' => $row])
                      </td>
                      <td class="text-center">
                        @include('admin.redirect_links.columns.action', ['row' => $row])
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              {{-- Group Pagination --}}
              @if ($totalPages > 1)
                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                  <div class="text-muted small">
                    {{ __('messages.showing') }} {{ ($currentPage - 1) * $itemsPerGroup + 1 }} -
                    {{ min($currentPage * $itemsPerGroup, $allItems->count()) }} {{ __('messages.of') }}
                    {{ $allItems->count() }}
                  </div>
                  <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" wire:click="prevGroupPage('{{ $groupKey }}')"
                      {{ $currentPage <= 1 ? 'disabled' : '' }}>
                      <i class="fas fa-chevron-left"
                        @if (app()->getLocale() == 'ar') style="transform: rotate(180deg);" @endif></i>
                      {{ __('messages.previous') }}
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" disabled>
                      {{ $currentPage }} / {{ $totalPages }}
                    </button>
                    <button class="btn btn-outline-primary btn-sm" wire:click="nextGroupPage('{{ $groupKey }}')"
                      {{ $currentPage >= $totalPages ? 'disabled' : '' }}>
                      {{ __('messages.next') }}
                      <i class="fas fa-chevron-right"
                        @if (app()->getLocale() == 'ar') style="transform: rotate(180deg);" @endif></i>
                    </button>
                  </div>
                </div>
              @endif


            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- NORMAL TABLE VIEW --}}
  @else
    <div class="table-responsive">
      <table class="table table-custom table-striped table-hover">
        <thead>
          <tr>
            <th class="text-center" style="width: 40px;">
              <input type="checkbox" wire:model.live="selectAll">
            </th>
            <th class="text-center" style="cursor: pointer;" wire:click="sortBy('id')">
              {{ __('messages.redirect_links.serial_number') }}
              <i class="fas fa-sort sort-icon {{ $sortField === 'id' ? 'active' : '' }}"></i>
            </th>
            <th class="text-center">{{ __('messages.redirect_links.user') }}</th>
            <th class="text-center" style="cursor: pointer;" wire:click="sortBy('uri')">
              {{ __('messages.redirect_links.redeem_code') }}
              <i class="fas fa-sort sort-icon {{ $sortField === 'uri' ? 'active' : '' }}"></i>
            </th>
            <th class="text-center">{{ __('messages.redirect_links.redirect_link_type') }}</th>
            <th class="text-center" style="cursor: pointer;" wire:click="sortBy('status')">
              {{ __('messages.redirect_links.status') }}
              <i class="fas fa-sort sort-icon {{ $sortField === 'status' ? 'active' : '' }}"></i>
            </th>
            @if (!auth()->user()->hasRole('sales'))
              <th class="text-center" style="cursor: pointer;" wire:click="sortBy('price')">
                {{ __('messages.admin_price') }}
                <i class="fas fa-sort sort-icon {{ $sortField === 'price' ? 'active' : '' }}"></i>
              </th>
            @endif
            <th class="text-center" style="cursor: pointer;" wire:click="sortBy('sales_price')">
              {{ auth()->user()->hasRole('sales') ? __('messages.admin_price') : __('messages.sales_representative_price') }}
              <i class="fas fa-sort sort-icon {{ $sortField === 'sales_price' ? 'active' : '' }}"></i>
            </th>
            @if (!auth()->user()->hasRole('sales'))
              <th class="text-center">{{ __('messages.redirect_links.assigned_to') }}</th>
            @endif
            <th class="text-center" style="cursor: pointer;" wire:click="sortBy('updated_at')">
              {{ __('messages.common.dates') }}
              <i class="fas fa-sort sort-icon {{ $sortField === 'updated_at' ? 'active' : '' }}"></i>
            </th>
            <th class="text-center">{{ __('messages.common.action') }}</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($redirectLinks as $row)
            <tr>
              <td class="text-center">
                <input type="checkbox" wire:model.defer="selected" value="{{ $row->id }}">
              </td>
              <td class="text-center">
                @include('admin.redirect_links.columns.serial_number', ['row' => $row])
              </td>
              <td class="text-center">
                @include('admin.redirect_links.columns.user', ['row' => $row])
              </td>
              <td class="text-center">
                @include('admin.redirect_links.columns.uri', ['row' => $row])
              </td>
              <td class="text-center">
                @include('admin.redirect_links.columns.redirect_link_type', ['row' => $row])
              </td>
              <td class="text-center">
                @include('admin.redirect_links.columns.combined_status', ['row' => $row])
              </td>
              @if (!auth()->user()->hasRole('sales'))
                <td class="text-center">
                  @include('admin.redirect_links.columns.price', ['row' => $row])
                </td>
              @endif
              <td class="text-center">
                @include('admin.redirect_links.columns.sales_price', ['row' => $row])
              </td>
              @if (!auth()->user()->hasRole('sales'))
                <td class="text-center">
                  @include('admin.redirect_links.columns.assigned_to', ['row' => $row])
                </td>
              @endif
              <td class="text-center">
                @include('admin.redirect_links.columns.dates', ['row' => $row])
              </td>
              <td class="text-center">
                @include('admin.redirect_links.columns.action', ['row' => $row])
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="11" class="text-center py-4">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">{{ __('messages.no_data') }}</p>
              </td>
            </tr>
          @endforelse
        </tbody>
        <tfoot class="table-dark">
          <tr>
            <td class="text-start px-3 fw-bold">{{ __('messages.common.total') }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @if (!auth()->user()->hasRole('sales'))
              <td class="text-center fw-bold">
                {{ currencyFormat($totalPurchasePrice, 2) }}
              </td>
            @endif
            <td class="text-center fw-bold">
              {{ currencyFormat($totalSalesPrice, 2) }}
            </td>
            @if (!auth()->user()->hasRole('sales'))
              <td></td>
            @endif
            <td></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>

    {{-- Pagination --}}
    @if ($redirectLinks && $redirectLinks->hasPages())
      <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
          {{ __('messages.showing') }} {{ $redirectLinks->firstItem() }} - {{ $redirectLinks->lastItem() }}
          {{ __('messages.of') }} {{ $redirectLinks->total() }}
        </div>
        <div>
          {{ $redirectLinks->links() }}
        </div>
      </div>
    @endif
  @endif
</div>
