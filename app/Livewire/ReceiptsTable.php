<?php

namespace App\Livewire;

use App\Models\Receipt;
use App\Livewire\LivewireTableComponent;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class ReceiptsTable extends LivewireTableComponent
{
  public $userId;
  public bool $showButtonOnHeader = true;
  protected $listeners = ['refresh' => '$refresh', 'resetPageTable'];
  public string $buttonComponent = 'receipts.columns.add_button';

  public function mount($userId)
  {
    $this->userId = $userId;
  }

  public function configure(): void
  {
    $this->setPrimaryKey('id');
    $this->setPageName('receipts-table');
    $this->setDefaultSort('received_at', 'desc');
    $this->setQueryStringStatus(false);
    $this->resetPage('receipts-table');

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
          if (!empty($dateRange['minDate']) && !empty($dateRange['maxDate'])) {
            $builder->whereBetween('received_at', [$dateRange['minDate'], $dateRange['maxDate']]);
          }
        }),
    ];
  }

  public function columns(): array
  {
    return [
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
      Column::make(__('messages.common.action'), "id")
        ->view('receipts.columns.action'),
    ];
  }

  public function builder(): Builder
  {
    return Receipt::where('user_id', $this->userId)->select('receipts.*');
  }
}
