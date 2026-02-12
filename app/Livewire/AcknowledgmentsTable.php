<?php

namespace App\Livewire;

use App\Models\RedirectLinkAcknowledgment;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AcknowledgmentsTable extends LivewireTableComponent
{
  protected $model = RedirectLinkAcknowledgment::class;
  protected $listeners = ['refresh' => '$refresh'];

  public function configure(): void
  {
    $this->setPrimaryKey('id');
    $this->setPageName('acknowledgments-table');
    $this->setDefaultSort('created_at', 'desc');
    $this->setColumnSelectStatus(false);
    $this->setQueryStringStatus(false);
    $this->resetPage('acknowledgments-table');

    $this->setEagerLoadAllRelationsEnabled();

    $this->setThAttributes(function (Column $column) {
      return [
        'class' => 'text-center',
      ];
    });
  }

  public function columns(): array
  {
    return [
      Column::make(__('#'), 'id')->sortable()
        ->view('acknowledgments.columns.id'),
      Column::make(__('messages.received_by'), 'sales_user_id')->sortable()->searchable()
        ->view('acknowledgments.columns.sales_user'),
      Column::make(__('messages.created_by_admin'), 'created_by')->sortable()
        ->view('acknowledgments.columns.created_by'),
      Column::make(__('messages.common.total') . ' ' . __('messages.common.items'), 'total_count')
        ->view('acknowledgments.columns.total_count'),
      Column::make(__('messages.total_purchase_price'), 'total_price')->sortable()
        ->view('acknowledgments.columns.total_price'),
      Column::make(__('messages.total_selling_price'), 'total_sales_price')->sortable()
        ->view('acknowledgments.columns.total_sales_price'),
      Column::make(__('messages.acknowledgment_date'), 'created_at')->sortable()
        ->view('acknowledgments.columns.created_at'),
      Column::make(__('messages.common.action'), 'id')
        ->view('acknowledgments.columns.action'),
    ];
  }

  public function builder(): Builder
  {
    $query = RedirectLinkAcknowledgment::query()->with(['salesUser', 'creator']);

    // If user is sales, only show their own acknowledgments
    if (auth()->user()->hasRole('sales')) {
      $query->where('sales_user_id', auth()->id());
    }

    return $query->select('redirect_link_acknowledgments.*');
  }

  public function delete($id)
  {
    // Only super_admin can delete
    if (!auth()->user()->hasRole('super_admin')) {
      session()->flash('error', __('messages.common.unauthorized'));
      return;
    }

    $acknowledgment = RedirectLinkAcknowledgment::findOrFail($id);
    $acknowledgment->delete();

    session()->flash('success', __('messages.acknowledgment_deleted'));
    $this->dispatch('refresh');
  }
}
