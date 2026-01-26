<div>
  {{-- Include the filter buttons component --}}
  @if ($this->showButtonOnHeader && isset($this->buttonComponent))
    <div class="mb-3">
      @livewire($this->buttonComponent)
    </div>
  @endif

  {{-- Custom grouped table view --}}
  @if ($groupedData && count($groupedData) > 0)
    <style>
      .group-header-row {
        background-color: #e3f2fd !important;
        border-top: 2px solid #1976d2 !important;
        border-bottom: 2px solid #1976d2 !important;
      }

      .group-header-row td {
        padding: 12px !important;
        font-weight: 600 !important;
        color: #1565c0 !important;
      }

      .group-item-row {
        border-left: 3px solid #e3f2fd;
      }
    </style>
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th class="text-center">
              <input type="checkbox" wire:model.live="selectAll">
            </th>
            <th class="text-center">{{ __('messages.redirect_links.user') }}</th>
            <th class="text-center">{{ __('messages.redirect_links.redeem_code') }}</th>
            <th class="text-center">{{ __('messages.redirect_links.redirect_link_type') }}</th>
            <th class="text-center">{{ __('messages.redirect_links.status') }}</th>
            @if (!auth()->user()->hasRole('sales'))
              <th class="text-center">{{ __('messages.admin_price') }}</th>
            @endif
            <th class="text-center">
              {{ auth()->user()->hasRole('sales') ? __('messages.admin_price') : __('messages.sales_representative_price') }}
            </th>
            @if (!auth()->user()->hasRole('sales'))
              <th class="text-center">{{ __('messages.redirect_links.assigned_to') }}</th>
            @endif
            <th class="text-center">{{ __('messages.common.dates') }}</th>
            <th class="text-center">{{ __('messages.common.action') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($groupedData as $groupKey => $items)
            {{-- Group Header Row --}}
            <tr class="group-header-row">
              <td colspan="2" class="text-start px-3">
                <i class="fas fa-folder-open me-2"></i>
                {{ $this->getGroupName($groupKey) }}
                <span class="badge bg-primary ms-2">{{ $items->count() }} {{ __('messages.common.items') }}</span>
              </td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              @if (!auth()->user()->hasRole('sales'))
                <td class="text-end pe-3">
                  <strong>{{ currencyFormat($this->getGroupPurchasePrice($items), 2) }}</strong>
                </td>
              @endif
              <td class="text-end pe-3">
                <strong>{{ currencyFormat($this->getGroupSalesPrice($items), 2) }}</strong>
              </td>
              @if (!auth()->user()->hasRole('sales'))
                <td></td>
              @endif
              <td colspan="2"></td>
            </tr>

            {{-- Group Items --}}
            @foreach ($items as $row)
              <tr wire:key="row-{{ $row->id }}" class="group-item-row">
                <td class="text-center">
                  <input type="checkbox" wire:model.live="selected" value="{{ $row->id }}">
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
          @endforeach
        </tbody>

        {{-- Grand Total Footer --}}
        <tfoot class="table-dark">
          <tr>
            <td colspan="5" class="text-start px-3 fw-bold">
              {{ __('messages.common.total') }}
            </td>
            @if (!auth()->user()->hasRole('sales'))
              <td class="text-end pe-3 fw-bold">
                {{ currencyFormat($this->getPurchasePriceSum(), 2) }}
              </td>
            @endif
            <td class="text-end pe-3 fw-bold">
              {{ currencyFormat($this->getSalesPriceSum(), 2) }}
            </td>
            <td colspan="{{ auth()->user()->hasRole('sales') ? 3 : 4 }}"></td>
          </tr>
        </tfoot>
      </table>
    </div>
  @else
    <div class="alert alert-info text-center">
      <i class="fas fa-info-circle me-2"></i>
      {{ __('messages.no_data_available') }}
    </div>
  @endif
</div>
