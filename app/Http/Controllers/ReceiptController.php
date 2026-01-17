<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\User;
use App\Models\RedirectLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceiptController extends Controller
{
  public function allReceipts()
  {
    // Calculate total required from sales (sum of all sold redirect links amounts)
    $totalRequired = RedirectLink::whereNotNull('assigned_id')
      ->whereNotNull('user_id')
      ->join('nfcs', 'redirect_links.nfcs_id', '=', 'nfcs.id')
      ->sum('nfcs.price');

    // Calculate total paid (sum of all receipt amounts)
    $totalPaid = Receipt::sum('amount');

    // Calculate total after paid (total required - total paid)
    $totalAfterPaid = $totalRequired - $totalPaid;

    // Calculate total remaining (same as total after paid)
    $totalRemaining = $totalAfterPaid;

    // Calculate total receipts count
    $totalReceipts = Receipt::count();

    // Calculate unique users who received payments
    $uniqueUsers = Receipt::distinct('user_id')->count('user_id');

    return view('receipts.all', compact('totalRequired', 'totalPaid', 'totalAfterPaid', 'totalRemaining', 'totalReceipts', 'uniqueUsers'));
  }

  public function index($userId)
  {
    $user = User::findOrFail($userId);

    // Calculate total sold redirect links for this salesman
    $totalSold = RedirectLink::where('assigned_id', $userId)
      ->whereNotNull('user_id')
      ->count();

    // Calculate total amount from sold redirect links
    $soldAmount = RedirectLink::where('assigned_id', $userId)
      ->whereNotNull('user_id')
      ->join('nfcs', 'redirect_links.nfcs_id', '=', 'nfcs.id')
      ->sum('nfcs.price');

    // Calculate total received amount
    $totalReceived = Receipt::where('user_id', $userId)->sum('amount');

    // Calculate remaining balance
    $balance = $soldAmount - $totalReceived;

    return view('receipts.index', compact('user', 'totalSold', 'soldAmount', 'totalReceived', 'balance'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), Receipt::$rules);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => $validator->errors()->first()
      ], 422);
    }

    Receipt::create($request->all());

    return response()->json([
      'success' => true,
      'message' => __('messages.receipts.receipt_created_successfully')
    ]);
  }

  public function edit($id)
  {
    $receipt = Receipt::findOrFail($id);

    return response()->json([
      'success' => true,
      'data' => $receipt
    ]);
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), Receipt::$rules);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => $validator->errors()->first()
      ], 422);
    }

    $receipt = Receipt::findOrFail($id);
    $receipt->update($request->all());

    return response()->json([
      'success' => true,
      'message' => __('messages.receipts.receipt_updated_successfully')
    ]);
  }

  public function destroy($id)
  {
    $receipt = Receipt::findOrFail($id);
    $receipt->delete();

    return response()->json([
      'success' => true,
      'message' => __('messages.receipts.receipt_deleted_successfully')
    ]);
  }
}
