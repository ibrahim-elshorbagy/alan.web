<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\RedirectLink;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SalesCustomersTable extends LivewireTableComponent
{
  protected $model = User::class;
  protected $listeners = ['refresh' => '$refresh', 'resetPageTable'];

  public function configure(): void
  {
    $this->setPrimaryKey('id');
    $this->setPageName('sales-customers-table');
    $this->setDefaultSort('first_name', 'asc');
    $this->setColumnSelectStatus(false);
    $this->setQueryStringStatus(false);
    $this->resetPage('sales-customers-table');

    $this->setThAttributes(function (Column $column) {
      if ($column->isField('is_active') || $column->isField('created_at')) {
        return [
          'class' => 'text-center',
        ];
      }
      return [];
    });
  }

  public function columns(): array
  {
    return [
      Column::make(__('messages.sales_customers.name'), 'first_name')
        ->searchable(function (Builder $query, $direction) {
          $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
        })->sortable()->view('sales.customers.columns.name'),
      Column::make(__('messages.sales_customers.name'), 'last_name')->sortable()->searchable()->hideIf(1),
      Column::make(__('messages.sales_customers.email'), 'email')->sortable()->searchable()
        ->view('sales.customers.columns.email'),
      Column::make(__('messages.sales_customers.phone'), 'contact')->sortable()->searchable()
        ->view('sales.customers.columns.phone'),
      Column::make(__('messages.sales_customers.status'), 'is_active')
        ->view('sales.customers.columns.is_active'),
    ];
  }

  public function builder(): Builder
  {
    $salesUserId = auth()->id();

    // Get unique user_ids connected to this sales rep through redirect_links
    $customerIds = RedirectLink::where('assigned_id', $salesUserId)
      ->whereNotNull('user_id')
      ->distinct()
      ->pluck('user_id')
      ->toArray();

    return User::query()->whereIn('users.id', $customerIds)
      ->with(['media'])
      ->select('users.*');
  }

  public function resetPageTable($pageName = 'sales-customers-table')
  {
    $rowsPropertyData = $this->getRows()->toArray();
    $prevPageNum = $rowsPropertyData['current_page'] - 1;
    $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
    $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

    $this->setPage($pageNum, $pageName);
  }

  public function placeholder()
  {
    return view('lazy_loading.without-filter-skelecton');
  }
}