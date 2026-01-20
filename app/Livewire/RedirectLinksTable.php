<?php

namespace App\Livewire;

use App\Models\RedirectLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class RedirectLinksTable extends LivewireTableComponent
{
  protected $model = RedirectLink::class;
  public bool $showButtonOnHeader = true;
  public string $buttonComponent = 'livewire.redirect_links.add-button';
  protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPageTable'];

  public $selectedRecordId;

  public function configure(): void
  {
    $this->setPrimaryKey('id');
    $this->setPageName('redirect-links-table');
    $this->setDefaultSort('redirect_links.updated_at', 'desc');
    $this->setColumnSelectStatus(false);
    $this->setQueryStringStatus(false);
    $this->resetPage('redirect-links-table');

    // Enable bulk actions
    $this->setBulkActionsEnabled();

    // Make sure bulk actions dropdown is always visible
    $this->setBulkActionsStatus(true);

    // Show bulk actions even when nothing is selected
    $this->setHideBulkActionsWhenEmptyDisabled();

    $this->setEagerLoadAllRelationsEnabled();

    $this->setAdditionalSelects(['redirect_links.user_id', 'redirect_links.nfcs_id', 'redirect_links.created_at', 'redirect_links.updated_at', 'redirect_links.received_status']);

    $this->setFiltersEnabled();

    $this->setPerPageAccepted([10, 25, 50, 100, 200]);

    $this->setThAttributes(function (Column $column) {
      return [
        'class' => 'text-center',
      ];
    });
  }



  public function filters(): array
  {
    $filters = [
      SelectFilter::make(__('messages.redirect_links.status'), 'status')
        ->setFilterPillTitle(__('messages.redirect_links.status'))
        ->options([
          '' => __('messages.common.all'),
          0 => __('messages.redirect_links.not_redeemed'),
          1 => __('messages.redirect_links.redeemed'),
          2 => __('messages.redirect_links.rejected'),
        ])
        ->filter(function (Builder $builder, string $value) {
          if ($value !== '') {
            $builder->where('status', $value);
          }
        }),
      DateRangeFilter::make(__('messages.common.dates'))
        ->setFilterPillTitle(__('messages.common.dates'))
        ->filter(function (Builder $builder, array $dateRange) {
          if (!empty($dateRange['minDate']) && !empty($dateRange['maxDate'])) {
            $builder->where(function ($q) use ($dateRange) {
              $q->whereBetween('redirect_links.created_at', [$dateRange['minDate'], $dateRange['maxDate']])
                ->orWhereBetween('redirect_links.updated_at', [$dateRange['minDate'], $dateRange['maxDate']]);
            });
          }
        }),
    ];

    if (!auth()->user()->hasRole('sales')) {
      $assignedOptions = ['' => __('messages.common.all')] + User::role('sales')->get()->mapWithKeys(fn($user) => [$user->id => $user->first_name . ' ' . $user->last_name])->toArray();
      $filters[] = SelectFilter::make(__('messages.redirect_links.assigned_to'), 'assigned_id')
        ->setFilterPillTitle(__('messages.redirect_links.assigned_to'))
        ->options($assignedOptions)
        ->filter(function (Builder $builder, string $value) {
          if ($value !== '') {
            $builder->where('assigned_id', $value);
          }
        });
    }

    return $filters;
  }

  public function bulkActions(): array
  {
    return [
      'exportSelected' => __('messages.redirect_links.export_selected'),
    ];
  }

  public function setSelectedRecord($recordId)
  {
    $this->selectedRecordId = $recordId;
  }

  public function exportSelected()
  {
    $selectedIds = $this->getSelected();

    if (empty($selectedIds)) {
      return redirect()->back()->with('error', __('messages.redirect_links.no_items_selected'));
    }

    // For sales, ensure they can only export their assigned links
    if (auth()->user()->hasRole('sales')) {
      $selectedIds = RedirectLink::whereIn('id', $selectedIds)
        ->where('assigned_id', auth()->id())
        ->pluck('id')
        ->toArray();

      if (empty($selectedIds)) {
        return redirect()->back()->with('error', __('messages.redirect_links.no_items_selected'));
      }
    }

    // Redirect to controller method with selected IDs
    return redirect()->route('redirect-links.export-selected', ['ids' => implode(',', $selectedIds)]);
  }

  public function columns(): array
  {
    $columns = [
      Column::make(__('messages.redirect_links.user'), 'user.first_name')
        ->searchable(function (Builder $query, $direction) {
          $query->whereHas('user', function ($q) use ($direction) {
            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
          });
        })->view('admin.redirect_links.columns.user'),
      Column::make(__('messages.redirect_links.redeem_code'), 'uri')->sortable()->searchable()
        ->view('admin.redirect_links.columns.uri'),
      Column::make(__('messages.redirect_links.redirect_link_type'), 'redirect_link_type')
        ->view('admin.redirect_links.columns.redirect_link_type'),
      Column::make(__('messages.redirect_links.status'), 'status')
        ->view('admin.redirect_links.columns.combined_status'),
      Column::make(__('messages.admin_price'), 'price')
        ->view('admin.redirect_links.columns.price')
        ->footer(fn() => __('messages.common.total') . ': ' . currencyFormat($this->getPurchasePriceSum(), 0))
        ->hideIf(auth()->user()->hasRole('sales')),
      Column::make(__('messages.selling_price'), 'sales_price')
        ->view('admin.redirect_links.columns.sales_price')
        ->footer(fn() => __('messages.common.total') . ': ' . currencyFormat($this->getSalesPriceSum(), 0)),
      Column::make(__('messages.redirect_links.assigned_to'), 'assigned_id')
        ->view('admin.redirect_links.columns.assigned_to')
        ->hideIf(auth()->user()->hasRole('sales')),
      Column::make(__('messages.common.dates'), 'created_at')
        ->view('admin.redirect_links.columns.dates'),
      Column::make(__('messages.common.action'), 'id')
        ->view('admin.redirect_links.columns.action'),
    ];


    return $columns;
  }

  public function builder(): Builder
  {
    $query = RedirectLink::query()->with(['user', 'assignedUser', 'nfc']);

    if (auth()->user()->hasRole('sales')) {
      $query->where('assigned_id', auth()->id());
    }

    return $query;
  }

  public function markAsReceived($id)
  {
    $redirectLink = RedirectLink::findOrFail($id);

    if (auth()->user()->hasRole('sales') && $redirectLink->assigned_id == auth()->id() && $redirectLink->received_status == RedirectLink::RECEIVED_STATUS_NOT_RECEIVED) {
      $redirectLink->update(['received_status' => RedirectLink::RECEIVED_STATUS_RECEIVED]);
      $this->dispatchSelf('refresh');
    }
  }

  public function getPurchasePriceSum()
  {
    return $this->getRows()->sum(function ($row) {
      return $row->price ?? 0;
    });
  }

  public function getSalesPriceSum()
  {
    return $this->getRows()->sum(function ($row) {
      return $row->sales_price ?? 0;
    });
  }

  public function placeholder()
  {
    return view('lazy_loading.without-filter-skelecton');
  }
}
