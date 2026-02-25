<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vcard;
use App\Models\RedirectLink;
use App\Models\WhatsappStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SalesCustomerController extends AppBaseController
{
  /**
   * Display the sales customers list page.
   */
  public function index()
  {
    return view('sales.customers.index');
  }

  /**
   * Toggle the active status of a customer (user) belonging to this sales rep.
   */
  public function updateStatus(User $user): JsonResponse
  {
    $salesUserId = Auth::id();

    // Verify this user is connected to the current sales rep via redirect_links
    $isConnected = RedirectLink::where('assigned_id', $salesUserId)
      ->where('user_id', $user->id)
      ->exists();

    if (! $isConnected) {
      return $this->sendError(__('messages.common.unauthorized'));
    }

    $newStatus = ! $user->is_active;

    $user->update([
      'is_active' => $newStatus,
    ]);

    // When deactivating, deactivate all their vcards, whatsapp stores, and unassign redirect links
    if (! $newStatus) {
      // Deactivate all vcards
      Vcard::where('tenant_id', $user->tenant_id)->update(['status' => Vcard::INACTIVE]);

      // Deactivate all whatsapp stores
      WhatsappStore::where('tenant_id', $user->tenant_id)->update(['status' => false]);

      // Unassign all redirect links
      $redirectLinks = RedirectLink::where('user_id', $user->id)->get();
      $userName = $user->first_name . ' ' . $user->last_name;
      $changedById = auth()->user()->isImpersonated()
      ? app('impersonate')->getImpersonatorId()
      : auth()->id();

      foreach ($redirectLinks as $redirectLink) {
        $redirectLink->update([
          'user_id' => null,
          'redirect_link' => null,
        ]);

        $redirectLink->logHistory(
          'user_deleted_link',
          $userName,
          __('messages.redirect_links.history.none'),
          $changedById,
          __('messages.redirect_links.history.user_deactivated', [
            'user' => $userName,
          ])
        );
      }

      return $this->sendSuccess(__('messages.sales_customers.customer_deactivated'));
    }

    return $this->sendSuccess(__('messages.sales_customers.customer_activated'));
  }
}