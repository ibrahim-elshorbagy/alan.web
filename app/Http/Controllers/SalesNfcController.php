<?php

namespace App\Http\Controllers;

use App\Models\Nfc;
use Illuminate\Http\Request;

class SalesNfcController extends Controller
{
  public function index()
  {
    $nfcCards = Nfc::all()->sortBy('name');
    $currency = getCurrencyIcon(getSuperAdminSettingValue('default_currency'));

    return view('sales.nfc-showcase', compact('nfcCards', 'currency'));
  }
}
