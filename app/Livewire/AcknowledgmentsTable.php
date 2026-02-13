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
      Column::make(__('messages.count') . ' ' . __('messages.common.items'), 'total_count')
        ->view('acknowledgments.columns.total_count'),
      Column::make(__(key: 'messages.admin_price'), 'total_price')->sortable()
        ->view('acknowledgments.columns.total_price'),
      Column::make(__('messages.sales_representative_price'), 'total_sales_price')->sortable()
        ->view('acknowledgments.columns.total_sales_price'),
      Column::make(__('messages.common.date'), 'created_at')->sortable()
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

    // Get the actual user ID (considering impersonation)
    $actualUserId = auth()->user()->isImpersonated()
      ? app('impersonate')->getImpersonatorId()
      : auth()->id();

    // Get redirect link IDs from acknowledgment
    $redirectLinkIds = is_string($acknowledgment->redirect_link_ids)
      ? json_decode($acknowledgment->redirect_link_ids, true)
      : $acknowledgment->redirect_link_ids;

    // Log history for each card before deleting the acknowledgment
    if (is_array($redirectLinkIds)) {
      $redirectLinks = \App\Models\RedirectLink::whereIn('id', $redirectLinkIds)->get();
      foreach ($redirectLinks as $link) {
        $link->logHistory(
          'removed_from_acknowledgment',
          '#' . $acknowledgment->id,
          __('messages.redirect_links.history.none'),
          $actualUserId,
          __('messages.redirect_links.history.removed_from_acknowledgment', [
            'acknowledgment_id' => $acknowledgment->id
          ])
        );
      }
    }

    $acknowledgment->delete();

    session()->flash('success', __('messages.acknowledgment_deleted'));
    $this->dispatch('refresh');
  }
}
