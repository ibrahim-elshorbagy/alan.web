<?php

namespace App\Services;

use App\Models\RedirectLink;
use App\Models\Vcard;
use App\Models\WhatsappStore;
use App\Models\User;
use Carbon\Carbon;

class UserDeactivationService
{
  /**
   * Deactivate a user and cascade: deactivate their vcards, whatsapp stores,
   * unassign their redirect links, and record who deactivated them.
   *
   * @param  User  $user        The user being deactivated.
   * @param  int   $deactivatedBy  The ID of the actor performing the deactivation.
   */
  public function deactivate(User $user, int $deactivatedBy): void
  {
    // Record who deactivated and when
    $user->update([
      'inactive_by'   => $deactivatedBy,
      'inactive_time' => Carbon::now(),
    ]);

    // Deactivate all vcards
    Vcard::where('tenant_id', $user->tenant_id)->update(['status' => Vcard::INACTIVE]);

    // Deactivate all whatsapp stores
    WhatsappStore::where('tenant_id', $user->tenant_id)->update(['status' => false]);

    // Unassign all redirect links and log history
    $redirectLinks = RedirectLink::where('user_id', $user->id)->get();
    $userName = $user->first_name . ' ' . $user->last_name;

    foreach ($redirectLinks as $redirectLink) {
      $redirectLink->update([
        'user_id'       => null,
        'redirect_link' => null,
      ]);

      $redirectLink->logHistory(
        'user_deleted_link',
        $userName,
        __('messages.redirect_links.history.none'),
        $deactivatedBy,
        __('messages.redirect_links.history.user_deactivated', [
          'user' => $userName,
        ])
      );
    }
  }
}
