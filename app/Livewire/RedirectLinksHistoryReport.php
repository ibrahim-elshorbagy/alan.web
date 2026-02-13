<?php

namespace App\Livewire;

use App\Models\RedirectLink;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class RedirectLinksHistoryReport extends Component
{
  // Filter properties
  public $dateFromFilter = '';
  public $dateToFilter = '';
  public $assignedFilter = '';
  public $reportType = 'redeemed'; // redeemed, deleted, active

  protected $queryString = [];
  protected $listeners = ['refresh' => '$refresh'];

  public function mount()
  {
    // Auto-set date to current month
    $this->dateFromFilter = now()->startOfMonth()->format('Y-m-d');
    $this->dateToFilter = now()->endOfMonth()->format('Y-m-d');
  }

  public function updatingDateFromFilter()
  {
    $this->dispatch('refresh');
  }

  public function updatingDateToFilter()
  {
    $this->dispatch('refresh');
  }

  public function updatingAssignedFilter()
  {
    $this->dispatch('refresh');
  }

  public function updatingReportType()
  {
    $this->dispatch('refresh');
  }

  public function resetFilters()
  {
    $this->dateFromFilter = now()->startOfMonth()->format('Y-m-d');
    $this->dateToFilter = now()->endOfMonth()->format('Y-m-d');
    $this->assignedFilter = '';
    $this->reportType = 'redeemed';
  }

  /**
   * Get redeemed users (user_redeem from history)
   */
  public function getRedeemedUsers()
  {
    $query = DB::table('redirect_link_histories')
      ->where('action', 'user_redeem')
      ->join('redirect_links', 'redirect_link_histories.redirect_link_id', '=', 'redirect_links.id')
      ->select(
        'redirect_link_histories.*',
        'redirect_links.uri',
        'redirect_links.nfcs_id',
        'redirect_links.assigned_id',
        'redirect_links.user_id'
      );

    // Apply role-based filtering
    if (auth()->user()->hasRole('sales')) {
      $query->where('redirect_links.assigned_id', auth()->id());
    }

    // Apply assigned filter (only for super_admin)
    if ($this->assignedFilter !== '' && !auth()->user()->hasRole('sales')) {
      $query->where('redirect_links.assigned_id', $this->assignedFilter);
    }

    // Apply date filters
    if ($this->dateFromFilter !== '') {
      $query->whereDate('redirect_link_histories.created_at', '>=', $this->dateFromFilter);
    }

    if ($this->dateToFilter !== '') {
      $query->whereDate('redirect_link_histories.created_at', '<=', $this->dateToFilter);
    }

    return $query->orderBy('redirect_link_histories.created_at', 'desc')->get();
  }

  /**
   * Get deleted users (user_deleted_link from history)
   */
  public function getDeletedUsers()
  {
    $query = DB::table('redirect_link_histories')
      ->where('action', 'user_deleted_link')
      ->join('redirect_links', 'redirect_link_histories.redirect_link_id', '=', 'redirect_links.id')
      ->select(
        'redirect_link_histories.*',
        'redirect_links.uri',
        'redirect_links.nfcs_id',
        'redirect_links.assigned_id',
        'redirect_links.user_id'
      );

    // Apply role-based filtering
    if (auth()->user()->hasRole('sales')) {
      $query->where('redirect_links.assigned_id', auth()->id());
    }

    // Apply assigned filter (only for super_admin)
    if ($this->assignedFilter !== '' && !auth()->user()->hasRole('sales')) {
      $query->where('redirect_links.assigned_id', $this->assignedFilter);
    }

    // Apply date filters
    if ($this->dateFromFilter !== '') {
      $query->whereDate('redirect_link_histories.created_at', '>=', $this->dateFromFilter);
    }

    if ($this->dateToFilter !== '') {
      $query->whereDate('redirect_link_histories.created_at', '<=', $this->dateToFilter);
    }

    return $query->orderBy('redirect_link_histories.created_at', 'desc')->get();
  }

  /**
   * Get active users (links where most recent action is redeem, not delete)
   */
  public function getActiveUsers()
  {
    // Get all redirect_link_ids that have been redeemed
    $redeemedQuery = DB::table('redirect_link_histories')
      ->where('action', 'user_redeem')
      ->join('redirect_links', 'redirect_link_histories.redirect_link_id', '=', 'redirect_links.id');

    // Apply role-based filtering
    if (auth()->user()->hasRole('sales')) {
      $redeemedQuery->where('redirect_links.assigned_id', auth()->id());
    }

    // Apply assigned filter (only for super_admin)
    if ($this->assignedFilter !== '' && !auth()->user()->hasRole('sales')) {
      $redeemedQuery->where('redirect_links.assigned_id', $this->assignedFilter);
    }

    // Apply date filters
    if ($this->dateFromFilter !== '') {
      $redeemedQuery->whereDate('redirect_link_histories.created_at', '>=', $this->dateFromFilter);
    }

    if ($this->dateToFilter !== '') {
      $redeemedQuery->whereDate('redirect_link_histories.created_at', '<=', $this->dateToFilter);
    }

    $redeemedIds = $redeemedQuery->pluck('redirect_link_histories.redirect_link_id')->unique()->toArray();

    if (empty($redeemedIds)) {
      return collect([]);
    }

    // For each redeemed link, check if the MOST RECENT action is a redemption or deletion
    $activeIds = [];

    foreach ($redeemedIds as $linkId) {
      $lastAction = DB::table('redirect_link_histories')
        ->where('redirect_link_id', $linkId)
        ->whereIn('action', ['user_redeem', 'user_deleted_link'])
        ->orderBy('created_at', 'desc')
        ->first();

      // If most recent action is redeem, it's active
      if ($lastAction && $lastAction->action === 'user_redeem') {
        $activeIds[] = $linkId;
      }
    }

    if (empty($activeIds)) {
      return collect([]);
    }

    // Get the MOST RECENT redemption history records for active IDs
    $query = DB::table('redirect_link_histories')
      ->where('action', 'user_redeem')
      ->whereIn('redirect_link_id', $activeIds)
      ->join('redirect_links', 'redirect_link_histories.redirect_link_id', '=', 'redirect_links.id')
      ->select(
        'redirect_link_histories.*',
        'redirect_links.uri',
        'redirect_links.nfcs_id',
        'redirect_links.assigned_id',
        'redirect_links.user_id'
      )
      // Get only the latest redemption for each link
      ->whereIn('redirect_link_histories.id', function ($subquery) use ($activeIds) {
        $subquery->select(DB::raw('MAX(id)'))
          ->from('redirect_link_histories')
          ->where('action', 'user_redeem')
          ->whereIn('redirect_link_id', $activeIds)
          ->groupBy('redirect_link_id');
      });

    return $query->orderBy('redirect_link_histories.created_at', 'desc')->get();
  }
  public function getSalesUsers()
  {
    return User::role('sales')->get();
  }

  public function render()
  {
    $redeemedUsers = $this->getRedeemedUsers();
    $deletedUsers = $this->getDeletedUsers();
    $activeUsers = $this->getActiveUsers();

    $redeemedCount = $redeemedUsers->count();
    $deletedCount = $deletedUsers->count();
    $activeCount = $activeUsers->count();

    // Filter by report type
    $displayData = collect([]);
    switch ($this->reportType) {
      case 'redeemed':
        $displayData = $redeemedUsers;
        break;
      case 'deleted':
        $displayData = $deletedUsers;
        break;
      case 'active':
        $displayData = $activeUsers;
        break;
      default:
        // Show all (redeemed)
        $displayData = $redeemedUsers;
        break;
    }

    return view('livewire.redirect-links-history-report', [
      'redeemedCount' => $redeemedCount,
      'deletedCount' => $deletedCount,
      'activeCount' => $activeCount,
      'displayData' => $displayData,
      'salesUsers' => $this->getSalesUsers(),
    ]);
  }
}