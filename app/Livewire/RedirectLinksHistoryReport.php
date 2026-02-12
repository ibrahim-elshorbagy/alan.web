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
   * Get active users (redeemed - deleted)
   */
  public function getActiveUsers()
  {
    // Get all redeemed redirect_link_ids
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

    $redeemedIds = $redeemedQuery->pluck('redirect_link_histories.redirect_link_id')->toArray();

    // Get all deleted redirect_link_ids
    $deletedQuery = DB::table('redirect_link_histories')
      ->where('action', 'user_deleted_link')
      ->join('redirect_links', 'redirect_link_histories.redirect_link_id', '=', 'redirect_links.id');

    // Apply same filters
    if (auth()->user()->hasRole('sales')) {
      $deletedQuery->where('redirect_links.assigned_id', auth()->id());
    }

    if ($this->assignedFilter !== '' && !auth()->user()->hasRole('sales')) {
      $deletedQuery->where('redirect_links.assigned_id', $this->assignedFilter);
    }

    if ($this->dateFromFilter !== '') {
      $deletedQuery->whereDate('redirect_link_histories.created_at', '>=', $this->dateFromFilter);
    }

    if ($this->dateToFilter !== '') {
      $deletedQuery->whereDate('redirect_link_histories.created_at', '<=', $this->dateToFilter);
    }

    $deletedIds = $deletedQuery->pluck('redirect_link_histories.redirect_link_id')->toArray();

    // Get active IDs (redeemed but not deleted)
    $activeIds = array_diff($redeemedIds, $deletedIds);

    if (empty($activeIds)) {
      return collect([]);
    }

    // Get the history records for active IDs
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
      );

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
