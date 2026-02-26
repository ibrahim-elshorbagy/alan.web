<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RedirectLink;
use App\Services\UserDeactivationService;
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

    // Verify this user belongs to the sales rep:
    // connected via redirect_link, created by them, or previously deactivated by them
    $isConnected = RedirectLink::where('assigned_id', $salesUserId)
      ->where('user_id', $user->id)
      ->exists();

    $isCreatedBy   = (int) $user->created_by  === $salesUserId;
    $isInactivatedBy = (int) $user->inactive_by === $salesUserId;

    if (! $isConnected && ! $isCreatedBy && ! $isInactivatedBy) {
      return $this->sendError(__('messages.common.unauthorized'));
    }

    $newStatus = ! $user->is_active;

    $user->update([
      'is_active' => $newStatus,
    ]);

    // When deactivating, deactivate all their vcards, whatsapp stores, and unassign redirect links
    if (! $newStatus) {
      $changedById = auth()->user()->isImpersonated()
        ? app('impersonate')->getImpersonatorId()
        : auth()->id();

      app(UserDeactivationService::class)->deactivate($user, $changedById);

      return $this->sendSuccess(__('messages.sales_customers.customer_deactivated'));
    }

    return $this->sendSuccess(__('messages.sales_customers.customer_activated'));
  }
}