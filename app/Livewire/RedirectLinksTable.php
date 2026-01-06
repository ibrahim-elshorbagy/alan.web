<?php

namespace App\Livewire;

use App\Models\RedirectLink;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class RedirectLinksTable extends LivewireTableComponent
{
  protected $model = RedirectLink::class;
  public bool $showButtonOnHeader = false; // No add button for now
  protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPageTable'];

  public function configure(): void
  {
    $this->setPrimaryKey('id');
    $this->setPageName('redirect-links-table');
    $this->setDefaultSort('created_at', 'desc');
    $this->setColumnSelectStatus(false);
    $this->setQueryStringStatus(false);
    $this->resetPage('redirect-links-table');

    $this->setThAttributes(function (Column $column) {
      return [
        'class' => 'text-center',
      ];
    });
  }

  public function columns(): array
  {
    return [
      Column::make(__('messages.redirect_links.id'), 'id')->sortable()->searchable(),
      Column::make(__('messages.redirect_links.user'), 'user.first_name')
        ->searchable(function (Builder $query, $direction) {
          $query->whereHas('user', function ($q) use ($direction) {
            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
          });
        })->view('admin.redirect_links.columns.user'),
      Column::make(__('messages.redirect_links.redeem_code'), 'redeem_code')->sortable()->searchable(),
      Column::make(__('messages.redirect_links.uri'), 'uri')->sortable()->searchable(),
      Column::make(__('messages.redirect_links.redirect_link'), 'redirect_link')->sortable()->searchable()
        ->view('admin.redirect_links.columns.redirect_link'),
      Column::make(__('messages.redirect_links.redirect_link_type'), 'redirect_link_type')
        ->view('admin.redirect_links.columns.redirect_link_type'),
      Column::make(__('messages.redirect_links.status'), 'status')
        ->view('admin.redirect_links.columns.status'),
      Column::make(__('messages.redirect_links.nfc'), 'nfc.name')
        ->searchable(function (Builder $query, $direction) {
          $query->whereHas('nfc', function ($q) use ($direction) {
            $q->where('name', 'like', '%' . $direction . '%');
          });
        })->view('admin.redirect_links.columns.nfc'),
      Column::make(__('messages.redirect_links.created_at'), 'created_at')->sortable(),
      Column::make(__('messages.redirect_links.updated_at'), 'updated_at')->sortable(),
    ];
  }

  public function builder(): Builder
  {
    return RedirectLink::with(['user', 'nfc']);
  }

  public function resetPageTable($pageName = 'redirect-links-table')
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
