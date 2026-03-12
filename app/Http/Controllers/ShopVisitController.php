<?php

namespace App\Http\Controllers;

use App\Models\ShopVisit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Carbon\Carbon;

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
      'cards_sold' => 'nullable|integer|min:0',
      'notes'      => 'nullable|string|max:1000',
    ]);

    $validated['sales_user_id'] = Auth::id();
    $validated['visited_at'] = Carbon::now();
    $validated['cards_sold'] = $validated['cards_sold'] ?? 0;

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
      'cards_sold' => 'nullable|integer|min:0',
      'notes'      => 'nullable|string|max:1000',
    ]);

    $validated['cards_sold'] = $validated['cards_sold'] ?? 0;

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

    return view('sales.shop_visits.admin_edit', compact('visit', 'salesUser'));
  }

  public function adminUpdate(Request $request, $id): RedirectResponse
  {
    $visit = ShopVisit::findOrFail($id);

    $validated = $request->validate([
      'city'       => 'required|string|max:255',
      'area'       => 'required|string|max:255',
      'street'     => 'required|string|max:255',
      'shop_name'  => 'required|string|max:255',
      'phone'      => 'required|string|max:20',
      'cards_sold' => 'nullable|integer|min:0',
      'notes'      => 'nullable|string|max:1000',
    ]);

    $validated['cards_sold'] = $validated['cards_sold'] ?? 0;

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
    $weekStart = Carbon::now()->startOfWeek();
    $monthStart = Carbon::now()->startOfMonth();

    $baseQuery = ShopVisit::where('sales_user_id', $salesUserId);

    // Daily
    $dailyVisits = (clone $baseQuery)->whereDate('visited_at', $today)->count();
    $dailyCards  = (clone $baseQuery)->whereDate('visited_at', $today)->sum('cards_sold');

    // Weekly
    $weeklyVisits = (clone $baseQuery)->where('visited_at', '>=', $weekStart)->count();
    $weeklyCards  = (clone $baseQuery)->where('visited_at', '>=', $weekStart)->sum('cards_sold');

    // Monthly
    $monthlyVisits = (clone $baseQuery)->where('visited_at', '>=', $monthStart)->count();
    $monthlyCards  = (clone $baseQuery)->where('visited_at', '>=', $monthStart)->sum('cards_sold');

    return [
      'daily_visits'   => $dailyVisits,
      'daily_cards'    => (int) $dailyCards,
      'weekly_visits'  => $weeklyVisits,
      'weekly_cards'   => (int) $weeklyCards,
      'monthly_visits' => $monthlyVisits,
      'monthly_cards'  => (int) $monthlyCards,
    ];
  }
}
