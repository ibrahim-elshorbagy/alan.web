<?php

namespace App\Http\Controllers;

use App\Models\RedirectLinkAcknowledgment;
use App\Models\RedirectLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AcknowledgmentController extends Controller
{
  /**
   * Display a listing of the acknowledgments.
   */
  public function index()
  {
    // Check authorization
    if (!auth()->user()->hasRole(['super_admin', 'sales'])) {
      abort(403, __('messages.common.unauthorized'));
    }

    return view('acknowledgments.index');
  }

  /**
   * Display the specified acknowledgment for viewing/printing.
   */
  public function view($id)
  {
    $acknowledgment = RedirectLinkAcknowledgment::with(['salesUser', 'creator'])->findOrFail($id);

    // Authorization check
    if (auth()->user()->hasRole('sales') && $acknowledgment->sales_user_id !== auth()->id()) {
      abort(403, __('messages.common.unauthorized'));
    }

    // Get redirect links
    $redirectLinks = $acknowledgment->getRedirectLinks();

    return view('acknowledgments.pdf.view', compact('acknowledgment', 'redirectLinks'));
  }

  /**
   * Show the form for editing the specified acknowledgment.
   */
  public function edit($id)
  {
    // Only super_admin can edit
    if (!auth()->user()->hasRole('super_admin')) {
      abort(403, __('messages.common.unauthorized'));
    }

    $acknowledgment = RedirectLinkAcknowledgment::with(['salesUser', 'creator'])->findOrFail($id);

    return view('acknowledgments.edit', compact('acknowledgment'));
  }

  /**
   * Update the specified acknowledgment in storage.
   */
  public function update(Request $request, $id)
  {
    // Only super_admin can update
    if (!auth()->user()->hasRole('super_admin')) {
      abort(403, __('messages.common.unauthorized'));
    }

    $acknowledgment = RedirectLinkAcknowledgment::findOrFail($id);

    $request->validate([
      'signature_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
      'notes' => 'nullable|string|max:1000',
    ]);

    $data = [
      'notes' => $request->notes,
    ];

    // Handle signature file upload
    if ($request->hasFile('signature_file')) {
      // Delete old signature file if exists
      if ($acknowledgment->signature_file) {
        Storage::disk('public')->delete($acknowledgment->signature_file);
      }

      // Store new file
      $path = $request->file('signature_file')->store('acknowledgment_signatures', 'public');
      $data['signature_file'] = $path;
    }

    $acknowledgment->update($data);

    return redirect()->route('acknowledgments.edit', $acknowledgment->id)
      ->with('success', __('messages.acknowledgment_updated'));
  }

  /**
   * Remove the specified acknowledgment from storage.
   */
  public function destroy($id)
  {
    // Only super_admin can delete
    if (!auth()->user()->hasRole('super_admin')) {
      abort(403, __('messages.common.unauthorized'));
    }

    $acknowledgment = RedirectLinkAcknowledgment::findOrFail($id);

    // Delete signature file if exists
    if ($acknowledgment->signature_file) {
      Storage::disk('public')->delete($acknowledgment->signature_file);
    }

    $acknowledgment->delete();

    return redirect()->route('acknowledgments.index')
      ->with('success', __('messages.acknowledgment_deleted'));
  }
}
