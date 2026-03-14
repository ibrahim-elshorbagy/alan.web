<?php

namespace App\Http\Controllers;

use App\Models\ShopVisit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Laracasts\Flash\Flash;

class ShopVisitController extends Controller
{
  // ─────────────────────────────────────────────
  //  Sales: own visits
  // ─────────────────────────────────────────────

  public function index()
  {
    $visits = ShopVisit::where('sales_user_id', Auth::id())
      ->orderBy('visited_at', 'desc')
      ->paginate(20);

    return view('sales.shop_visits.index', compact('visits'));
  }

  public function create()
  {
    // Fetch last visit for this sales user to pre-fill address fields
    $lastVisit = ShopVisit::where('sales_user_id', Auth::id())
      ->orderBy('created_at', 'desc')
      ->first();

    return view('sales.shop_visits.create', compact('lastVisit'));
  }

  public function store(Request $request): RedirectResponse
  {
    $validated = $request->validate([
      'city'       => 'required|string|max:255',
      'area'       => 'required|string|max:255',
      'street'     => 'required|string|max:255',
      'shop_name'  => 'required|string|max:255',
      'phone'      => 'required|string|max:20',
      'notes'      => 'nullable|string|max:1000',
    ]);

    $validated['sales_user_id'] = Auth::id();
    $validated['visited_at'] = Carbon::now();

    ShopVisit::create($validated);

    Flash::success(__('messages.shop_visits.created'));

    return redirect()->route('sales.shop-visits.index');
  }

  public function edit($id)
  {
    $visit = $this->findOwnVisit($id);

    return view('sales.shop_visits.edit', compact('visit'));
  }

  public function update(Request $request, $id): RedirectResponse
  {
    $visit = $this->findOwnVisit($id);

    $validated = $request->validate([
      'city'       => 'required|string|max:255',
      'area'       => 'required|string|max:255',
      'street'     => 'required|string|max:255',
      'shop_name'  => 'required|string|max:255',
      'phone'      => 'required|string|max:20',
      'notes'      => 'nullable|string|max:1000',
    ]);

    $visit->update($validated);

    Flash::success(__('messages.shop_visits.updated'));

    return redirect()->route('sales.shop-visits.index');
  }

  public function destroy($id): RedirectResponse
  {
    $visit = $this->findOwnVisit($id);
    $visit->delete();

    Flash::success(__('messages.shop_visits.deleted'));

    return redirect()->route('sales.shop-visits.index');
  }

  // ─────────────────────────────────────────────
  //  Super Admin: view a specific sales user's visits
  // ─────────────────────────────────────────────

  public function adminIndex($salesUserId)
  {
    $salesUser = User::whereHas('roles', fn($q) => $q->where('name', 'sales'))
      ->findOrFail($salesUserId);

    if (auth()->user()->hasRole('sales_agency') && $salesUser->agency_id != auth()->id()) {
      abort(403);
    }

    $visits = ShopVisit::where('sales_user_id', $salesUserId)
      ->orderBy('visited_at', 'desc')
      ->paginate(20);

    return view('sales.shop_visits.admin_index', compact('visits', 'salesUser'));
  }

  public function adminEdit($id)
  {
    $visit = ShopVisit::findOrFail($id);

    // Ensure the visit belongs to a sales user
    $salesUser = User::whereHas('roles', fn($q) => $q->where('name', 'sales'))
      ->findOrFail($visit->sales_user_id);

    if (auth()->user()->hasRole('sales_agency') && $salesUser->agency_id != auth()->id()) {
      abort(403);
    }

    return view('sales.shop_visits.admin_edit', compact('visit', 'salesUser'));
  }

  public function adminUpdate(Request $request, $id): RedirectResponse
  {
    $visit = ShopVisit::findOrFail($id);

    // Ensure the visit belongs to a sales user
    $salesUser = User::whereHas('roles', fn($q) => $q->where('name', 'sales'))
      ->findOrFail($visit->sales_user_id);

    if (auth()->user()->hasRole('sales_agency') && $salesUser->agency_id != auth()->id()) {
      abort(403);
    }

    $validated = $request->validate([
      'city'       => 'required|string|max:255',
      'area'       => 'required|string|max:255',
      'street'     => 'required|string|max:255',
      'shop_name'  => 'required|string|max:255',
      'phone'      => 'required|string|max:20',
      'notes'      => 'nullable|string|max:1000',
    ]);

    $visit->update($validated);

    Flash::success(__('messages.shop_visits.updated'));

    return redirect()->route('admin.sales-visits.index', $visit->sales_user_id);
  }

  // ─────────────────────────────────────────────
  //  Dashboard statistics (JSON)
  // ─────────────────────────────────────────────

  public function salesDashboard()
  {
    $salesUserId = Auth::id();
    $stats = $this->getVisitStats($salesUserId);

    return view('sales.shop_visits.dashboard', compact('stats'));
  }

  public function adminDashboard($salesUserId)
  {
    $salesUser = User::whereHas('roles', fn($q) => $q->where('name', 'sales'))
      ->findOrFail($salesUserId);

    if (auth()->user()->hasRole('sales_agency') && $salesUser->agency_id != auth()->id()) {
      abort(403);
    }

    $stats = $this->getVisitStats($salesUserId);

    return view('sales.shop_visits.admin_dashboard', compact('stats', 'salesUser'));
  }

  // ─────────────────────────────────────────────
  //  Helpers
  // ─────────────────────────────────────────────

  private function findOwnVisit($id): ShopVisit
  {
    return ShopVisit::where('sales_user_id', Auth::id())->findOrFail($id);
  }

  public static function getVisitStats(int $salesUserId): array
  {
    $today = Carbon::today();
    $previousWorkingDay = self::getPreviousWorkingDay($today);
    [$weekStart, $weekEnd] = self::getCurrentWorkWeekRange($today);
    $monthStart = $today->copy()->startOfMonth()->startOfDay();
    $monthEnd = $today->copy()->endOfDay();

    $allVisits = ShopVisit::where('sales_user_id', $salesUserId)
      ->orderBy('visited_at')
      ->get(['visited_at']);

    $workVisits = $allVisits
      ->filter(fn(ShopVisit $visit) => !$visit->visited_at->isFriday())
      ->values();

    $todayVisits = $workVisits->filter(fn(ShopVisit $visit) => $visit->visited_at->isSameDay($today))->count();
    $previousWorkingDayVisits = $workVisits->filter(fn(ShopVisit $visit) => $visit->visited_at->isSameDay($previousWorkingDay))->count();

    $weeklyVisits = $workVisits->filter(function (ShopVisit $visit) use ($weekStart, $weekEnd) {
      return $visit->visited_at->greaterThanOrEqualTo($weekStart)
        && $visit->visited_at->lessThanOrEqualTo($weekEnd);
    })->count();

    $monthlyVisits = $workVisits->filter(function (ShopVisit $visit) use ($monthStart, $monthEnd) {
      return $visit->visited_at->greaterThanOrEqualTo($monthStart)
        && $visit->visited_at->lessThanOrEqualTo($monthEnd);
    })->count();

    $totalVisits = $workVisits->count();

    $salesStats = self::buildSalesStats($salesUserId, $today, $previousWorkingDay, $weekStart, $weekEnd, $monthStart, $monthEnd);

    return array_merge([
      'today_visits'   => $todayVisits,
      'previous_working_day_visits' => $previousWorkingDayVisits,
      'weekly_visits'  => $weeklyVisits,
      'monthly_visits' => $monthlyVisits,
      'total_visits'   => $totalVisits,
      'month_chart'    => self::buildCurrentMonthChart($workVisits, $monthStart, $monthEnd),
      'overall_chart'  => self::buildOverallChart($workVisits),
    ], $salesStats);
  }

  private static function getPreviousWorkingDay(Carbon $referenceDate): Carbon
  {
    $previousDay = $referenceDate->copy()->subDay();

    while ($previousDay->isFriday()) {
      $previousDay->subDay();
    }

    return $previousDay;
  }

  private static function getCurrentWorkWeekRange(Carbon $referenceDate): array
  {
    if ($referenceDate->isFriday()) {
      $referenceDate = $referenceDate->copy()->subDay();
    }

    $weekStart = $referenceDate->copy()->startOfWeek(Carbon::SATURDAY)->startOfDay();
    $weekEnd = $weekStart->copy()->addDays(5)->endOfDay();

    return [$weekStart, $weekEnd];
  }

  private static function buildCurrentMonthChart(Collection $workVisits, Carbon $monthStart, Carbon $monthEnd): array
  {
    $dailyCounts = $workVisits
      ->filter(function (ShopVisit $visit) use ($monthStart, $monthEnd) {
        return $visit->visited_at->greaterThanOrEqualTo($monthStart)
          && $visit->visited_at->lessThanOrEqualTo($monthEnd);
      })
      ->groupBy(fn(ShopVisit $visit) => $visit->visited_at->toDateString())
      ->map(fn(Collection $visits) => $visits->count());

    $labels = [];
    $data = [];
    $cursor = $monthStart->copy();

    while ($cursor->lessThanOrEqualTo($monthEnd)) {
      if (!$cursor->isFriday()) {
        $dateKey = $cursor->toDateString();
        $labels[] = $cursor->format('d M');
        $data[] = (int) ($dailyCounts[$dateKey] ?? 0);
      }

      $cursor->addDay();
    }

    return [
      'labels' => $labels,
      'data'   => $data,
    ];
  }

  private static function buildOverallChart(Collection $workVisits): array
  {
    $monthlyCounts = $workVisits
      ->groupBy(fn(ShopVisit $visit) => $visit->visited_at->format('Y-m'))
      ->map(fn(Collection $visits) => $visits->count())
      ->sortKeys();

    $labels = [];
    $data = [];

    foreach ($monthlyCounts as $month => $count) {
      $labels[] = Carbon::createFromFormat('Y-m', $month)->format('M Y');
      $data[] = (int) $count;
    }

    return [
      'labels' => $labels,
      'data'   => $data,
    ];
  }

  /**
   * Build active redirect-link sales stats for the given sales user.
   * "Active" = most recent redemption (user_redeem) NOT followed by user_deleted_link.
   */
  private static function buildSalesStats(
    int    $salesUserId,
    Carbon $today,
    Carbon $previousWorkingDay,
    Carbon $weekStart,
    Carbon $weekEnd,
    Carbon $monthStart,
    Carbon $monthEnd
  ): array {
    // Fetch timestamps of all active redemptions assigned to this salesperson
    $activeSaleDates = DB::table('redirect_link_histories as rlh')
      ->join('redirect_links as rl', 'rlh.redirect_link_id', '=', 'rl.id')
      ->where('rlh.action', 'user_redeem')
      ->where('rl.assigned_id', $salesUserId)
      // Only the most recent redemption per link
      ->whereIn('rlh.id', function ($sub) {
        $sub->from('redirect_link_histories')
          ->select(DB::raw('MAX(id)'))
          ->where('action', 'user_redeem')
          ->groupBy('redirect_link_id');
      })
      // No deletion after this redemption
      ->whereNotExists(function ($sub) {
        $sub->from('redirect_link_histories as rlh2')
          ->whereColumn('rlh2.redirect_link_id', 'rlh.redirect_link_id')
          ->where('rlh2.action', 'user_deleted_link')
          ->whereColumn('rlh2.id', '>', 'rlh.id');
      })
      ->orderBy('rlh.created_at')
      ->pluck('rlh.created_at')
      ->map(fn($t) => Carbon::parse($t));

    $todaySales        = $activeSaleDates->filter(fn($d) => $d->isSameDay($today))->count();
    $prevDaySales      = $activeSaleDates->filter(fn($d) => $d->isSameDay($previousWorkingDay))->count();
    $weeklySales       = $activeSaleDates->filter(fn($d) => $d->greaterThanOrEqualTo($weekStart) && $d->lessThanOrEqualTo($weekEnd))->count();
    $monthlySales      = $activeSaleDates->filter(fn($d) => $d->greaterThanOrEqualTo($monthStart) && $d->lessThanOrEqualTo($monthEnd))->count();
    $totalActiveSales  = $activeSaleDates->count(); // all-time, no date filter

    // Current-month daily chart
    $monthSalesByDay = $activeSaleDates
      ->filter(fn($d) => $d->greaterThanOrEqualTo($monthStart) && $d->lessThanOrEqualTo($monthEnd))
      ->groupBy(fn($d) => $d->toDateString())
      ->map(fn($g) => $g->count());

    $monthSalesLabels = [];
    $monthSalesData   = [];
    $cursor = $monthStart->copy();
    while ($cursor->lessThanOrEqualTo($monthEnd)) {
      if (!$cursor->isFriday()) {
        $dateKey = $cursor->toDateString();
        $monthSalesLabels[] = $cursor->format('d M');
        $monthSalesData[]   = (int) ($monthSalesByDay[$dateKey] ?? 0);
      }
      $cursor->addDay();
    }

    // Overall monthly chart
    $overallSalesByMonth = $activeSaleDates
      ->groupBy(fn($d) => $d->format('Y-m'))
      ->map(fn($g) => $g->count())
      ->sortKeys();

    $overallSalesLabels = [];
    $overallSalesData   = [];
    foreach ($overallSalesByMonth as $month => $count) {
      $overallSalesLabels[] = Carbon::createFromFormat('Y-m', $month)->format('M Y');
      $overallSalesData[]   = (int) $count;
    }

    return [
      'today_active_sales'                => $todaySales,
      'previous_working_day_active_sales' => $prevDaySales,
      'weekly_active_sales'               => $weeklySales,
      'monthly_active_sales'              => $monthlySales,
      'total_active_sales'                => $totalActiveSales,
      'month_sales_chart'                 => ['labels' => $monthSalesLabels, 'data' => $monthSalesData],
      'overall_sales_chart'               => ['labels' => $overallSalesLabels, 'data' => $overallSalesData],
    ];
  }
}