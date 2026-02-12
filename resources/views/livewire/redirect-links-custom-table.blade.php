<div x-data="{
    selected: [],

    // Get URI by ID from the DOM
    getUriById(id) {
        // Find all checkboxes and locate the one with matching ID
        const checkboxes = document.querySelectorAll('input[type=\'checkbox\']');
        for (let checkbox of checkboxes) {
            const checkAttribute = checkbox.getAttribute('x-bind:checked');
            if (checkAttribute && checkAttribute.includes(`isSelected(${id})`)) {
                const row = checkbox.closest('tr');
                if (row) {
                    // The URI is in the 4th td (index 3), accounting for checkbox being the 1st
                    const cells = row.querySelectorAll('td');
                    if (cells.length >= 4) {
                        const uriCell = cells[3]; // 0=checkbox, 1=serial, 2=user, 3=uri
                        const uriText = uriCell.textContent.trim();
                        return uriText || `#${id}`;
                    }
                }
            }
        }
        return `#${id}`;
    },

    // Check if an item is selected
    isSelected(id) {
        return this.selected.includes(String(id));
    },

    // Toggle a single item selection
    toggleItem(id) {
        const strId = String(id);
        if (this.isSelected(strId)) {
            this.selected = this.selected.filter(i => i !== strId);
        } else {
            this.selected = [...this.selected, strId];
        }
    },

    // Select all items from a given array of IDs
    selectAllItems(ids) {
        const strIds = ids.map(id => String(id));
        const allSelected = strIds.every(id => this.selected.includes(id));

        if (allSelected) {
            // Deselect all items from this table
            this.selected = this.selected.filter(id => !strIds.includes(id));
        } else {
            // Deselect everything first, then select only this table's items
            this.selected = [...strIds];
        }
    },

    // Check if all items from array are selected
    allItemsSelected(ids) {
        if (!ids || ids.length === 0) return false;
        const strIds = ids.map(id => String(id));
        return strIds.every(id => this.selected.includes(id));
    },

    // Check if some (but not all) items are selected
    someItemsSelected(ids) {
        if (!ids || ids.length === 0) return false;
        const strIds = ids.map(id => String(id));
        const selectedCount = strIds.filter(id => this.selected.includes(id)).length;
        return selectedCount > 0 && selectedCount < strIds.length;
    },

    // Clear all selections
    clearAll() {
        this.selected = [];
    },

    // Sync selections to server before action
    syncAndCall(method) {
        $wire.set('selected', this.selected).then(() => {
            $wire.call(method).then(() => {
                // Clear selections only after delete action
                if (method === 'deleteSelected') {
                    this.selected = [];
                }
            });
        });
    },

    // Getter for hasSelected
    get hasSelected() {
        return this.selected && this.selected.length > 0;
    }
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
      overflow: auto;
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
      flex-wrap: wrap;
      gap: 10px;
    }

    .group-accordion-header:hover {
      background: linear-gradient(135deg, #5a67d8 0%, #6b46a1 100%);
    }

    .group-accordion-header .group-info {
      display: flex;
      align-items: center;
      gap: 15px;
      flex: 1;
      min-width: 200px;
    }

    .group-accordion-header .group-name {
      font-size: 1.1rem;
      font-weight: 600;
    }

    .group-accordion-header .group-stats {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      align-items: center;
    }

    .group-accordion-header .stat-item {
      background: rgba(255, 255, 255, 0.2);
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      white-space: nowrap;
    }

    .group-accordion-header .stats-container {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
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
      overflow: auto;
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
      white-space: nowrap;
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

    /* Responsive styles */
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .table-custom {
      min-width: 1000px;
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
      .group-accordion-header {
        padding: 12px 15px;
      }

      .group-accordion-header .group-name {
        font-size: 1rem;
      }

      .group-accordion-header .group-stats {
        gap: 10px;
        width: 100%;
      }

      .group-accordion-header .stat-item {
        font-size: 0.75rem;
        padding: 4px 10px;
      }

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

      .btn {
        font-size: 0.85rem;
        padding: 0.375rem 0.75rem;
      }

      .btn i {
        font-size: 0.85rem;
      }
    }

    /* Tablet optimizations */
    @media (min-width: 769px) and (max-width: 1024px) {
      .group-accordion-header .stat-item {
        font-size: 0.8rem;
      }

      .table-custom {
        font-size: 0.9rem;
      }
    }

    /* Small mobile devices */
    @media (max-width: 576px) {
      .group-accordion-header .group-info {
        min-width: auto;
        width: 100%;
      }

      .group-accordion-header .group-stats {
        justify-content: flex-start;
      }

      .filter-card .row {
        margin: 0;
      }

      .filter-card .col-md-1,
      .filter-card .col-md-2,
      .filter-card .col-md-3 {
        margin-bottom: 10px;
      }
    }

    .selected-preview {
      position: relative;
      display: block;
      /* Change from inline-block to block */
      width: 100%;
      /* Ensure full width */
    }

    .stat {
      text-align: center;
      /* Ensure all stats are centered */
    }

    .selected-preview-tooltip {
      visibility: hidden;
      opacity: 0;
      position: absolute;
      bottom: 100%;
      left: 50%;
      transform: translateX(-50%);
      background-color: #333;
      color: #fff;
      padding: 12px 16px;
      border-radius: 8px;
      z-index: 1000;
      margin-bottom: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      transition: opacity 0.2s, visibility 0.2s;
      max-width: 300px;
      max-height: 200px;
      overflow-y: auto;
      white-space: normal;
      min-width: 200px;
      text-align: center;
    }

    .selected-preview-tooltip::after {
      content: '';
      position: absolute;
      top: 100%;
      left: 50%;
      transform: translateX(-50%);
      border: 6px solid transparent;
      border-top-color: #333;
    }

    .selected-preview:hover .selected-preview-tooltip {
      visibility: visible;
      opacity: 1;
    }

    .selected-code-item {
      padding: 4px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      text-align: center;
    }

    .selected-code-item:last-child {
      border-bottom: none;
    }

    [x-cloak] {
      display: none !important;
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


      {{-- Assigned To Filter (only for non-sales users) --}}
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

      {{-- Status Filter --}}
      <div class="col-md-2 col-sm-6 col-12">
        <label class="form-label small mb-1">{{ __('messages.redirect_links.status') }}</label>
        <select class="form-control form-select" wire:model.live="statusFilter">
          <option value="">{{ __('messages.common.all') }}</option>
          <option value="0">{{ __('messages.redirect_links.not_redeemed') }}</option>
          <option value="1">{{ __('messages.redirect_links.redeemed') }}</option>
          <option value="2">{{ __('messages.redirect_links.rejected') }}</option>
        </select>
      </div>

      {{-- Redirect Type Filter --}}
      <div class="col-md-2 col-sm-6 col-12">
        <label class="form-label small mb-1">{{ __('messages.redirect_links.redirect_type') }}</label>
        <select class="form-control form-select" wire:model.live="redirectTypeFilter">
          <option value="">{{ __('messages.common.all') }}</option>
          @foreach ($redirectTypes as $type)
            <option value="{{ $type->value }}">{{ $type->label() }}</option>
          @endforeach
        </select>
      </div>

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

      {{-- Date From --}}
      <div class="col-md-2 col-sm-6 col-12">
        <label class="form-label small mb-1">{{ __('messages.common.date_from') }}</label>
        <input type="date" class="form-control" wire:model.defer="dateFromFilter" wire:change="$refresh">
      </div>

      {{-- Date To --}}
      <div class="col-md-2 col-sm-6 col-12">
        <label class="form-label small mb-1">{{ __('messages.common.date_to') }}</label>
        <input type="date" class="form-control" wire:model.defer="dateToFilter" wire:change="$refresh">
      </div>

      {{-- Group By Filter --}}
      @if (count($allowedGroupByOptions) > 0)
        <div class="col-md-2 col-sm-6 col-12">
          <label class="form-label small mb-1">{{ __('messages.redirect_links.group_by') }}</label>
          <select class="form-control form-select" wire:model.live="groupByFilter">
            <option value="">{{ __('messages.redirect_links.no_grouping') }}</option>
            @foreach ($allowedGroupByOptions as $option)
              <option value="{{ $option }}">
                @if ($option == 'redirect_type')
                  {{ __('messages.redirect_links.redirect_type') }}
                @elseif($option == 'nfc_card')
                  {{ __('messages.redirect_links.card_type') }}
                @elseif($option == 'sales_rep')
                  {{ __('messages.redirect_links.assigned_to') }}
                @endif
              </option>
            @endforeach
          </select>
        </div>
      @endif

      {{-- Per Page --}}
      <div class="col-md-1 col-sm-6 col-6">
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
      <div class="col-md-1 col-sm-6 col-6">
        <button class="btn btn-outline-secondary w-100" wire:click="resetFilters">
          <i class="fas fa-undo"></i>
        </button>
      </div>
    </div>
    {{-- Search --}}
    <div class="col-md-4 col-sm-6 col-12 mt-2">
      <label class="form-label small mb-1">
        {{ __('messages.common.search') }}
      </label>

      <div class="d-flex gap-2 align-items-start">
        <textarea class="form-control" rows="3" wire:model.defer="searchQuery"
          placeholder="{{ __('messages.common.search') }}...">
    </textarea>

        <button class="btn btn-success" wire:click="performSearch" type="button">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>

  </div>

  {{-- Action Buttons --}}
  <div class="d-flex flex-wrap gap-2 mb-3">
    <template x-if="hasSelected">
      <div class="d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-warning" @click="syncAndCall('exportSelected')">
          <i class="fas fa-file-export"></i> <span
            class="d-none d-sm-inline">{{ __('messages.common.export_selected') }}</span>
        </button>

        <button type="button" class="btn btn-success" @click="syncAndCall('markSelectedAsReceived')">
          <i class="fas fa-check"></i> <span
            class="d-none d-sm-inline">{{ __('messages.redirect_links.mark_selected_as_received') }}</span>
        </button>

        @if (auth()->user()->hasRole('super_admin'))
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal">
            <i class="fas fa-user-plus"></i> <span
              class="d-none d-sm-inline">{{ __('messages.redirect_links.assign_selected') }}</span>
          </button>

          <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#acknowledgmentModal">
            <i class="fas fa-file-signature"></i> <span
              class="d-none d-sm-inline">{{ __('messages.create_acknowledgment') }}</span>
          </button>

          <button type="button" class="btn btn-danger"
            @click="if(confirm('{{ __('messages.common.delete_confirm') }}')) { syncAndCall('deleteSelected') }">
            <i class="fas fa-trash"></i> <span
              class="d-none d-sm-inline">{{ __('messages.common.delete_selected') }}</span>
          </button>
        @endif

        @if (auth()->user()->hasRole('super_admin'))
          <button type="button" class="btn btn-info"
            @click="if(confirm('{{ __('messages.redirect_links.restore_confirmation') }}')) { syncAndCall('syncAndRestore') }"
            data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('messages.redirect_links.restore_selected_tooltip') }}">
            <i class="fas fa-undo"></i> <span
              class="d-none d-sm-inline">{{ __('messages.redirect_links.restore_selected') }}</span>
          </button>
        @endif

        {{-- Clear Selection Button --}}
        <button type="button" class="btn btn-outline-secondary" @click="clearAll()">
          <i class="fas fa-times-circle"></i> <span
            class="d-none d-sm-inline">{{ __('messages.redirect_links.clear_selection') }}</span>
        </button>
      </div>
    </template>

    @if (!auth()->user()->hasRole('sales'))
      <a type="button" class="btn btn-primary" href="{{ route('redirect-links.create') }}">
        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('messages.common.add') }}</span>
      </a>
    @endif

    {{-- History Report Link --}}
    <a type="button" class="btn btn-info" href="{{ route('redirect-links.history-report') }}">
      <i class="fas fa-chart-line"></i> <span
        class="d-none d-sm-inline">{{ __('messages.redirect_links.history_report') }}</span>
    </a>
  </div>

  {{-- Summary Card --}}
  <div class="summary-card">
    <div class="row g-2">
      <div class="col-md-3 col-6">
        <div class="stat">
          <div class="stat-value">{{ $totalCount }}</div>
          <div class="stat-label">{{ __('messages.common.total') }} {{ __('messages.common.items') }}</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat selected-preview">
          <div class="stat-value" x-text="selected ? selected.length : 0"></div>
          <div class="stat-label">{{ __('messages.common.selected') }}</div>

          {{-- Tooltip with selected URIs --}}
          <div class="selected-preview-tooltip" x-show="selected && selected.length > 0" x-cloak>

            <template x-for="(id, index) in selected" :key="id">
              <div class="selected-code-item" style="text-align: center;">
                <span x-text="getUriById(id)"></span>
              </div>
            </template>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat">
          <div class="stat-value">{{ currencyFormat($totalPurchasePrice, 2) }}</div>
          <div class="stat-label">{{ __('messages.admin_price') }}</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat">
          <div class="stat-value">{{ currencyFormat($totalSalesPrice, 2) }}</div>
          <div class="stat-label">{{ __('messages.sales_representative_price') }}</div>
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
            <div class="group-stats d-flex justify-content-between align-items-center">
              <div class="stats-container">
                <span class="stat-item">
                  <i class="fas fa-list"></i> {{ $allItems->count() }} <span
                    class="d-none d-sm-inline">{{ __('messages.common.items') }}</span>
                </span>
                <span class="stat-item">
                  <i class="fas fa-money-bill"></i> {{ __('messages.admin_price') }}:
                  {{ currencyFormat($groupPurchasePrice, 2) }}
                </span>
                <span class="stat-item">
                  <i class="fas fa-coins"></i> {{ __('messages.sales_representative_price') }}:
                  {{ currencyFormat($groupSalesPrice, 2) }}
                </span>
              </div>
              <i class="fas fa-chevron-down chevron"></i>
            </div>
          </div>
          <div class="group-accordion-body {{ $isExpanded ? 'show' : '' }}">
            <div class="table-responsive">
              <table class="table table-custom table-striped table-hover mb-0">
                <thead>
                  <tr>
                    <th class="text-center" style="width: 40px;">
                      @php
                        $groupItemIds = $items->pluck('id')->toArray();
                      @endphp
                      <input type="checkbox" x-bind:checked="allItemsSelected({{ json_encode($groupItemIds) }})"
                        x-bind:indeterminate="someItemsSelected({{ json_encode($groupItemIds) }})"
                        @click="selectAllItems({{ json_encode($groupItemIds) }})">
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
                    @if ($groupByFilter != 'nfc_card')
                      <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('price')">
                        {{ __('messages.admin_price') }}
                        <i class="fas fa-sort sort-icon {{ $sortField === 'price' ? 'active' : '' }}"></i>
                      </th>
                      <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('sales_price')">
                        {{ __('messages.common.sales_price') }}
                        <i class="fas fa-sort sort-icon {{ $sortField === 'sales_price' ? 'active' : '' }}"></i>
                      </th>
                    @endif
                    <th class="text-center" style="cursor: pointer;" wire:click.stop="sortBy('assigned_id')">
                      {{ __('messages.redirect_links.assigned_to') }}
                      <i class="fas fa-sort sort-icon {{ $sortField === 'assigned_id' ? 'active' : '' }}"></i>
                    </th>
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
                        <input type="checkbox" x-bind:checked="isSelected({{ $row->id }})"
                          @click="toggleItem({{ $row->id }})">
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
                      @if ($groupByFilter != 'nfc_card')
                        <td class="text-center">
                          @include('admin.redirect_links.columns.price', ['row' => $row])
                        </td>
                        <td class="text-center">
                          @include('admin.redirect_links.columns.sales_price', ['row' => $row])
                        </td>
                      @endif
                      <td class="text-center">
                        @include('admin.redirect_links.columns.assigned_to', ['row' => $row])
                      </td>
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
                <div
                  class="d-flex flex-column flex-sm-row justify-content-between align-items-center p-3 border-top gap-2">
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
                      <span class="d-none d-sm-inline">{{ __('messages.previous') }}</span>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" disabled>
                      {{ $currentPage }} / {{ $totalPages }}
                    </button>
                    <button class="btn btn-outline-primary btn-sm" wire:click="nextGroupPage('{{ $groupKey }}')"
                      {{ $currentPage >= $totalPages ? 'disabled' : '' }}>
                      <span class="d-none d-sm-inline">{{ __('messages.next') }}</span>
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
              @php
                $pageItemIds = $redirectLinks->pluck('id')->toArray();
              @endphp
              <input type="checkbox" x-bind:checked="allItemsSelected({{ json_encode($pageItemIds) }})"
                x-bind:indeterminate="someItemsSelected({{ json_encode($pageItemIds) }})"
                @click="selectAllItems({{ json_encode($pageItemIds) }})">
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
            <th class="text-center" style="cursor: pointer;" wire:click="sortBy('price')">
              {{ __('messages.admin_price') }}
              <i class="fas fa-sort sort-icon {{ $sortField === 'price' ? 'active' : '' }}"></i>
            </th>
            <th class="text-center" style="cursor: pointer;" wire:click="sortBy('sales_price')">
              {{ __('messages.common.sales_price') }}
              <i class="fas fa-sort sort-icon {{ $sortField === 'sales_price' ? 'active' : '' }}"></i>
            </th>
            <th class="text-center">{{ __('messages.redirect_links.assigned_to') }}</th>
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
                <input type="checkbox" x-bind:checked="isSelected({{ $row->id }})"
                  @click="toggleItem({{ $row->id }})">
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
              <td class="text-center">
                @include('admin.redirect_links.columns.price', ['row' => $row])
              </td>
              <td class="text-center">
                @include('admin.redirect_links.columns.sales_price', ['row' => $row])
              </td>
              <td class="text-center">
                @include('admin.redirect_links.columns.assigned_to', ['row' => $row])
              </td>
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
            <td class="text-center fw-bold">
              {{ currencyFormat($totalPurchasePrice, 2) }}
            </td>
            <td class="text-center fw-bold">
              {{ currencyFormat($totalSalesPrice, 2) }}
            </td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>

    {{-- Pagination --}}
    @if ($redirectLinks && $redirectLinks->hasPages())
      <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 gap-2">
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

  {{-- Assignment Modal --}}
  <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="assignModalLabel">{{ __('messages.redirect_links.assign_selected') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">{{ __('messages.redirect_links.assigned_to') }}:</label>
            <select class="form-control form-select" wire:model="assignedUserId">
              <option value="">{{ __('messages.redirect_links.select_user') }}</option>
              @foreach ($salesUsers as $salesUser)
                <option value="{{ $salesUser->id }}">{{ $salesUser->first_name }} {{ $salesUser->last_name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <span
              x-text="'{{ __('messages.redirect_links.you_have_selected') }} ' + selected.length + ' {{ __('messages.redirect_links.items') }}'"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
          <button type="button" class="btn btn-primary" @click="syncAndCall('bulkAssign')" data-bs-dismiss="modal">
            {{ __('messages.redirect_links.assign') }}
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- Acknowledgment Modal --}}
  <div class="modal fade" id="acknowledgmentModal" tabindex="-1" aria-labelledby="acknowledgmentModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="acknowledgmentModalLabel">{{ __('messages.create_acknowledgment') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">{{ __('messages.select_sales_representative') }}:</label>
            <select class="form-control form-select" wire:model="acknowledgmentSalesUserId">
              <option value="">{{ __('messages.redirect_links.select_user') }}</option>
              @foreach ($salesUsers as $salesUser)
                <option value="{{ $salesUser->id }}">{{ $salesUser->first_name }} {{ $salesUser->last_name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <span
              x-text="'{{ __('messages.redirect_links.you_have_selected') }} ' + selected.length + ' {{ __('messages.redirect_links.items') }}'"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
          <button type="button" class="btn btn-info" @click="syncAndCall('createAcknowledgment')"
            data-bs-dismiss="modal">
            {{ __('messages.create_acknowledgment') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
