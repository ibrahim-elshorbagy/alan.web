<?php

namespace App\Livewire;

use App\Models\Receipt;
use App\Models\User;
use App\Livewire\LivewireTableComponent;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class AllReceiptsTable extends LivewireTableComponent
{
  public bool $showButtonOnHeader = false;
  protected $listeners = ['refresh' => '$refresh', 'resetPageTable'];

  public function configure(): void
  {
    $this->setPrimaryKey('id');
    $this->setPageName('all-receipts-table');
    $this->setDefaultSort('received_at', 'desc');
    $this->setQueryStringStatus(false);
    $this->resetPage('all-receipts-table');

    $this->setThAttributes(function (Column $column) {
      return [
        'class' => 'text-center',
      ];
    });

    $this->setFiltersEnabled();
  }

  public function filters(): array
  {
    return [
      DateRangeFilter::make(__('messages.common.dates'))
        ->setFilterPillTitle(__('messages.common.dates'))
        ->filter(function (Builder $builder, array $dateRange) {
          $builder->whereBetween('received_at', $dateRange);
        }),
    ];
  }

  public function columns(): array
  {
    return [
      Column::make(__('messages.user.full_name'), "user.first_name")
        ->sortable()
        ->searchable()
        ->view('receipts.columns.user_name'),
      Column::make(__('messages.receipts.amount'), "amount")
        ->sortable()
        ->searchable()
        ->view('receipts.columns.amount'),
      Column::make(__('messages.receipts.received_at'), "received_at")
        ->sortable()
        ->view('receipts.columns.received_at'),
      Column::make(__('messages.receipts.description'), "description")
        ->searchable()
        ->view('receipts.columns.description'),
    ];
  }

  public function builder(): Builder
  {
    return Receipt::with('user')->select('receipts.*');
  }
}
