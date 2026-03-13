<?php

namespace App\Livewire;

use App\Models\RedirectLink;
use App\Models\User;
use App\Models\Nfc;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RedirectLinksSalesReport extends Component
{
  // Filter properties
  public $dateFromFilter = '';
  public $dateToFilter = '';
  public $assignedFilter = '';
  public $cardTypeFilter = '';
  public $periodFilter = 'month'; // today, yesterday, week, month, custom

  protected $queryString = [];
  protected $listeners = ['refresh' => '$refresh'];

  public function mount()
  {
    $this->applyPeriodDates('month');
  }

  public function updatedPeriodFilter($value)
  {
    $this->applyPeriodDates($value);
  }

  public function updatingDateFromFilter()
  {
    $this->periodFilter = 'custom';
    $this->dispatch('refresh');
  }

  public function updatingDateToFilter()
  {
    $this->periodFilter = 'custom';
    $this->dispatch('refresh');
  }

  public function updatingAssignedFilter()
  {
    $this->dispatch('refresh');
  }

  public function updatingCardTypeFilter()
  {
    $this->dispatch('refresh');
  }

  private function applyPeriodDates($period)
  {
    switch ($period) {
      case 'today':
        $this->dateFromFilter = now()->format('Y-m-d');
        $this->dateToFilter = now()->format('Y-m-d');
        break;
      case 'yesterday':
        $this->dateFromFilter = now()->subDay()->format('Y-m-d');
        $this->dateToFilter = now()->subDay()->format('Y-m-d');
        break;
      case 'week':
        $this->dateFromFilter = now()->startOfWeek()->format('Y-m-d');
        $this->dateToFilter = now()->endOfWeek()->format('Y-m-d');
        break;
      case 'month':
        $this->dateFromFilter = now()->startOfMonth()->format('Y-m-d');
        $this->dateToFilter = now()->endOfMonth()->format('Y-m-d');
        break;
      case 'custom':
        // Don't change dates, let user pick
        break;
    }
  }

  public function resetFilters()
  {
    $this->periodFilter = 'month';
    $this->assignedFilter = '';
    $this->cardTypeFilter = '';
    $this->applyPeriodDates('month');
  }

  /**
   * Base query for active sales only.
   * "Active" = redeemed (user_redeem) and NOT subsequently deleted (user_deleted_link).
   * Only the most recent redemption per link is counted.
   */
  private function baseSalesQuery()
  {
    $query = DB::table('redirect_link_histories as rlh')
      ->join('redirect_links', 'rlh.redirect_link_id', '=', 'redirect_links.id')
      ->leftJoin('nfcs', 'redirect_links.nfcs_id', '=', 'nfcs.id')
      ->where('rlh.action', 'user_redeem')
      // Only the most recent redemption per link
      ->whereIn('rlh.id', function ($sub) {
        $sub->from('redirect_link_histories')
          ->select(DB::raw('MAX(id)'))
          ->where('action', 'user_redeem')
          ->groupBy('redirect_link_id');
      })
      // Exclude links that were deleted after redemption
      ->whereNotExists(function ($sub) {
        $sub->from('redirect_link_histories as rlh2')
          ->whereColumn('rlh2.redirect_link_id', 'rlh.redirect_link_id')
          ->where('rlh2.action', 'user_deleted_link')
          ->whereColumn('rlh2.id', '>', 'rlh.id');
      });

    // Role-based filtering
    if (auth()->user()->hasRole('sales')) {
      $query->where('redirect_links.assigned_id', auth()->id());
    }

    // Assigned filter (for super_admin)
    if ($this->assignedFilter !== '' && !auth()->user()->hasRole('sales')) {
      $query->where('redirect_links.assigned_id', $this->assignedFilter);
    }

    // Card type filter
    if ($this->cardTypeFilter !== '') {
      $query->where('redirect_links.nfcs_id', $this->cardTypeFilter);
    }

    // Date filters
    if ($this->dateFromFilter !== '') {
      $query->whereDate('rlh.created_at', '>=', $this->dateFromFilter);
    }

    if ($this->dateToFilter !== '') {
      $query->whereDate('rlh.created_at', '<=', $this->dateToFilter);
    }

    return $query;
  }

  /**
   * Get detailed active sales data
   */
  public function getSalesData()
  {
    return $this->baseSalesQuery()
      ->select(
        'rlh.*',
        'redirect_links.uri',
        'redirect_links.nfcs_id',
        'redirect_links.assigned_id',
        'redirect_links.user_id',
        'redirect_links.price',
        'redirect_links.sales_price',
        'nfcs.name as nfc_name'
      )
      ->orderBy('rlh.created_at', 'desc')
      ->get();
  }

  /**
   * Get sales summary by salesperson
   */
  public function getSalesBySalesperson()
  {
    $query = $this->baseSalesQuery()
      ->select(
        'redirect_links.assigned_id',
        DB::raw('COUNT(*) as total_sales'),
        DB::raw('COALESCE(SUM(redirect_links.price), 0) as total_price'),
        DB::raw('COALESCE(SUM(redirect_links.sales_price), 0) as total_sales_price')
      )
      ->groupBy('redirect_links.assigned_id');

    return $query->get();
  }

  /**
   * Get sales summary by card type
   */
  public function getSalesByCardType()
  {
    $query = $this->baseSalesQuery()
      ->select(
        'redirect_links.nfcs_id',
        'nfcs.name as nfc_name',
        DB::raw('COUNT(*) as total_sales'),
        DB::raw('COALESCE(SUM(redirect_links.price), 0) as total_price'),
        DB::raw('COALESCE(SUM(redirect_links.sales_price), 0) as total_sales_price')
      )
      ->groupBy('redirect_links.nfcs_id', 'nfcs.name');

    return $query->get();
  }

  /**
   * Get quick period stats (active only) for summary cards
   */
  private function getPeriodStats($dateFrom, $dateTo)
  {
    $query = DB::table('redirect_link_histories as rlh')
      ->join('redirect_links', 'rlh.redirect_link_id', '=', 'redirect_links.id')
      ->where('rlh.action', 'user_redeem')
      ->whereDate('rlh.created_at', '>=', $dateFrom)
      ->whereDate('rlh.created_at', '<=', $dateTo)
      // Only the most recent redemption per link
      ->whereIn('rlh.id', function ($sub) {
        $sub->from('redirect_link_histories')
          ->select(DB::raw('MAX(id)'))
          ->where('action', 'user_redeem')
          ->groupBy('redirect_link_id');
      })
      // Exclude links deleted after redemption
      ->whereNotExists(function ($sub) {
        $sub->from('redirect_link_histories as rlh2')
          ->whereColumn('rlh2.redirect_link_id', 'rlh.redirect_link_id')
          ->where('rlh2.action', 'user_deleted_link')
          ->whereColumn('rlh2.id', '>', 'rlh.id');
      });

    // Role-based filtering
    if (auth()->user()->hasRole('sales')) {
      $query->where('redirect_links.assigned_id', auth()->id());
    }

    // Assigned filter
    if ($this->assignedFilter !== '' && !auth()->user()->hasRole('sales')) {
      $query->where('redirect_links.assigned_id', $this->assignedFilter);
    }

    return $query->select(
      DB::raw('COUNT(*) as count'),
      DB::raw('COALESCE(SUM(redirect_links.price), 0) as total_price'),
      DB::raw('COALESCE(SUM(redirect_links.sales_price), 0) as total_sales_price')
    )->first();
  }

  public function getSalesUsers()
  {
    return User::role('sales')->get();
  }

  public function getNfcCards()
  {
    return Nfc::all();
  }

  public function render()
  {
    $salesData = $this->getSalesData();
    $salesBySalesperson = $this->getSalesBySalesperson();
    $salesByCardType = $this->getSalesByCardType();

    // Overall totals for filtered period
    $totalCount = $salesData->count();
    $totalPrice = $salesData->sum('price');
    $totalSalesPrice = $salesData->sum('sales_price');

    // Quick period stats
    $todayStats = $this->getPeriodStats(now()->format('Y-m-d'), now()->format('Y-m-d'));
    $yesterdayStats = $this->getPeriodStats(now()->subDay()->format('Y-m-d'), now()->subDay()->format('Y-m-d'));
    $weekStats = $this->getPeriodStats(now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d'));
    $monthStats = $this->getPeriodStats(now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d'));

    // Get all sales users for lookup
    $allSalesUsers = User::whereHas('roles', function ($q) {
      $q->whereIn('name', ['sales', 'super_admin']);
    })->get()->keyBy('id');

    return view('livewire.redirect-links-sales-report', [
      'salesData' => $salesData,
      'salesBySalesperson' => $salesBySalesperson,
      'salesByCardType' => $salesByCardType,
      'totalCount' => $totalCount,
      'totalPrice' => $totalPrice,
      'totalSalesPrice' => $totalSalesPrice,
      'todayStats' => $todayStats,
      'yesterdayStats' => $yesterdayStats,
      'weekStats' => $weekStats,
      'monthStats' => $monthStats,
      'salesUsers' => $this->getSalesUsers(),
      'nfcCards' => $this->getNfcCards(),
      'allSalesUsers' => $allSalesUsers,
    ]);
  }
}
