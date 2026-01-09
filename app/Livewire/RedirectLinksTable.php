<?php

namespace App\Livewire;

use App\Models\RedirectLink;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

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
    $this->setDefaultSort('updated_at', 'desc');
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

    $this->setAdditionalSelects(['redirect_links.user_id', 'redirect_links.nfcs_id']);

    $this->setThAttributes(function (Column $column) {
      return [
        'class' => 'text-center',
      ];
    });
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

    // Redirect to controller method with selected IDs
    return redirect()->route('redirect-links.export-selected', ['ids' => implode(',', $selectedIds)]);
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
      Column::make(__('messages.redirect_links.redirect_link_type'), 'redirect_link_type')
        ->view('admin.redirect_links.columns.redirect_link_type'),
      Column::make(__('messages.redirect_links.status'), 'status')
        ->view('admin.redirect_links.columns.status'),
      Column::make(__('messages.redirect_links.nfc'), 'nfcs_id')->sortable()->searchable(),
      Column::make(__('messages.redirect_links.updated_at'), 'updated_at')->sortable(),
      Column::make(__('messages.common.action'), 'id')
        ->view('admin.redirect_links.columns.action'),
    ];
  }

  public function builder(): Builder
  {
    return RedirectLink::query()->with(['user']);
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
