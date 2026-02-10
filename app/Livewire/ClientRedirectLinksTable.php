<?php

namespace App\Livewire;

use App\Models\RedirectLink;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ClientRedirectLinksTable extends LivewireTableComponent
{
  protected $model = RedirectLink::class;
  protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPageTable'];

  public function configure(): void
  {
    $this->setPrimaryKey('id');
    $this->setPageName('client-redirect-links-table');
    $this->setDefaultSort('updated_at', 'desc');
    $this->setColumnSelectStatus(false);
    $this->setQueryStringStatus(false);
    $this->resetPage('client-redirect-links-table');

    $this->setEagerLoadAllRelationsEnabled();

    // Add this to force eager load
    $this->setAdditionalSelects(['redirect_links.nfcs_id']);

    $this->setThAttributes(function (Column $column) {
      return [
        'class' => 'text-center',
      ];
    });
  }

  public function columns(): array
  {
    return [
      Column::make(__('messages.redirect_links.uri'), 'uri')->sortable()->searchable()
        ->view('client.redirect_links.columns.uri'),
      Column::make(__('messages.redirect_links.redirect_link'), 'redirect_link')->sortable()->searchable()
        ->view('client.redirect_links.columns.redirect_link'),
      Column::make(__('messages.redirect_links.status'), 'status')
        ->view('client.redirect_links.columns.status'),
      Column::make(__('messages.redirect_links.updated_at'), 'updated_at')->sortable()
        ->view('client.redirect_links.columns.updated_at'),
      Column::make(__('messages.common.action'), 'id')
        ->view('client.redirect_links.columns.action'),
    ];
  }

  public function builder(): Builder
  {
    return RedirectLink::query()->where('user_id', auth()->id())->with(['nfc'])->select('redirect_links.*');
  }

  public function delete($id)
  {
    $redirectLink = RedirectLink::where('user_id', auth()->id())->findOrFail($id);

    // Get the actual user who is making this change (considering impersonation)
    $actualUserId = auth()->user()->isImpersonated()
      ? app('impersonate')->getImpersonatorId()
      : auth()->id();

    // Store user info before updating
    $userName = $redirectLink->user ? ($redirectLink->user->first_name . ' ' . $redirectLink->user->last_name) : __('messages.redirect_links.history.unknown_user');

    // Set user_id to null to "delete" from user's account, making it available for sales again
    $redirectLink->update([
      'user_id' => null,
      // 'status' => RedirectLink::STATUS_NOT_REDEEMED,
      'redirect_link' => null,
    ]);

    // Log the deletion (unassignment) history
    $redirectLink->logHistory(
      'user_deleted_link',
      $userName,
      __('messages.redirect_links.history.none'),
      $actualUserId,
      __('messages.redirect_links.history.user_deleted_link', [
        'user' => $userName
      ])
    );

    // Log status change
    // $redirectLink->logHistory(
    //   'status_changed',
    //   __('messages.redirect_links.redeemed'),
    //   __('messages.redirect_links.not_redeemed'),
    //   $actualUserId,
    //   __('messages.redirect_links.history.status_changed', [
    //     'old' => __('messages.redirect_links.redeemed'),
    //     'new' => __('messages.redirect_links.not_redeemed')
    //   ])
    // );

    session()->flash('success', __('messages.redirect_links.deleted'));
    $this->dispatch('refresh');
  }
  public function resetPageTable($pageName = 'client-redirect-links-table')
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
