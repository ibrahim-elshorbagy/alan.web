<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ShopVisitController;
use Illuminate\Support\Facades\Auth;

class SalesDashboardController extends Controller
{
  public function index()
  {
    $stats = ShopVisitController::getVisitStats(Auth::id());

    return view('sales.dashboard', compact('stats'));
  }
}
