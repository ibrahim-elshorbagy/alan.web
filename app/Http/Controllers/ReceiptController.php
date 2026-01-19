<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\User;
use App\Models\RedirectLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
  public function allReceipts()
  {
    $totalRequired = RedirectLink::whereNotNull('assigned_id')
      ->whereNotNull('user_id')
      ->join('nfcs', 'redirect_links.nfcs_id', '=', 'nfcs.id')
      ->sum('nfcs.price');

    $totalPaid = Receipt::sum('amount');
    $totalAfterPaid = $totalRequired - $totalPaid;
    $totalRemaining = $totalAfterPaid;
    $totalReceipts = Receipt::count();
    $uniqueUsers = Receipt::distinct('user_id')->count('user_id');

    return view('receipts.all', compact('totalRequired', 'totalPaid', 'totalAfterPaid', 'totalRemaining', 'totalReceipts', 'uniqueUsers'));
  }

  public function allReceiptsPdf()
  {
    $totalRequired = RedirectLink::whereNotNull('assigned_id')
      ->whereNotNull('user_id')
      ->join('nfcs', 'redirect_links.nfcs_id', '=', 'nfcs.id')
      ->sum('nfcs.price');

    $totalPaid = Receipt::sum('amount');
    $totalAfterPaid = $totalRequired - $totalPaid;
    $totalRemaining = $totalAfterPaid;
    $totalReceipts = Receipt::count();
    $uniqueUsers = Receipt::distinct('user_id')->count('user_id');
    $receipts = Receipt::with('user')->orderBy('created_at', 'desc')->get();

    // Process Arabic text for receipts
    // foreach ($receipts as $receipt) {
    //   $receipt->user->first_name = processArabicText($receipt->user->first_name);
    //   $receipt->user->last_name = processArabicText($receipt->user->last_name);
    //   if ($receipt->notes) {
    //     $receipt->notes = processArabicText($receipt->notes);
    //   }
    //   if ($receipt->description) {
    //     $receipt->description = processArabicText($receipt->description);
    //   }
    // }

    $data = compact('totalRequired', 'totalPaid', 'totalAfterPaid', 'totalRemaining', 'totalReceipts', 'uniqueUsers', 'receipts');

    $pdf = Pdf::loadView('receipts.pdf.all_receipts', $data);
    $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
    $pdf->getDomPDF()->set_option('isRemoteEnabled', true);

    return $pdf->download('all_receipts_report_' . date('Y-m-d') . '.pdf');
  }

  public function receiptsPdf($userId)
  {
    $user = User::findOrFail($userId);

    $totalSold = RedirectLink::where('assigned_id', $userId)
      ->whereNotNull('user_id')
      ->count();

    $soldAmount = RedirectLink::where('assigned_id', $userId)
      ->whereNotNull('user_id')
      ->join('nfcs', 'redirect_links.nfcs_id', '=', 'nfcs.id')
      ->sum('nfcs.price');

    $totalReceived = Receipt::where('user_id', $userId)->sum('amount');
    $balance = $soldAmount - $totalReceived;
    $receipts = Receipt::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

    // Process notes for receipts
    // foreach ($receipts as $receipt) {
    //   if ($receipt->notes) {
    //     $receipt->notes = processArabicText($receipt->notes);
    //   }
    //   if ($receipt->description) {
    //     $receipt->description = processArabicText($receipt->description);
    //   }
    // }

    $data = compact('user', 'totalSold', 'soldAmount', 'totalReceived', 'balance', 'receipts');

    $pdf = Pdf::loadView('receipts.pdf.receipts', $data);
    $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
    $pdf->getDomPDF()->set_option('isRemoteEnabled', true);

    return $pdf->download($user->first_name . '_' . $user->last_name . '_receipts_' . date('Y-m-d') . '.pdf');
  }

  public function singleReceiptPdf($receiptId)
  {
    $receipt = Receipt::with('user')->findOrFail($receiptId);

    // Calculate balance for the user
    $userId = $receipt->user_id;
    $totalSold = RedirectLink::where('assigned_id', $userId)
      ->whereNotNull('user_id')
      ->count();

    $soldAmount = RedirectLink::where('assigned_id', $userId)
      ->whereNotNull('user_id')
      ->join('nfcs', 'redirect_links.nfcs_id', '=', 'nfcs.id')
      ->sum('nfcs.price');

    $totalReceived = Receipt::where('user_id', $userId)->sum('amount');
    $balance = $soldAmount - $totalReceived;

    $data = compact('receipt', 'balance');

    $pdf = Pdf::loadView('receipts.pdf.single_receipt', $data);
    $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
    $pdf->getDomPDF()->set_option('isRemoteEnabled', true);

    return $pdf->download('receipt_' . $receiptId . '_' . date('Y-m-d') . '.pdf');
  }

  public function index($userId)
  {
    $user = User::findOrFail($userId);

    $totalSold = RedirectLink::where('assigned_id', $userId)
      ->whereNotNull('user_id')
      ->count();

    $soldAmount = RedirectLink::where('assigned_id', $userId)
      ->whereNotNull('user_id')
      ->join('nfcs', 'redirect_links.nfcs_id', '=', 'nfcs.id')
      ->sum('nfcs.price');

    $totalReceived = Receipt::where('user_id', $userId)->sum('amount');
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
