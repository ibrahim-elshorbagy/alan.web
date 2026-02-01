<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vcard;
use App\Models\RedirectLink;
use App\Models\WhatsappStore;

class HelpController extends Controller
{
  /**
   * Return data used to compose WhatsApp help message for logged-in admin.
   */
  public function whatsappHelpData(Request $request)
  {
    $user = Auth::user();

    $nameParts = preg_split('/\s+/', trim($user->full_name));
    $first = $nameParts[0] ?? '';
    $second = $nameParts[1] ?? '';

    $vcard = Vcard::where('tenant_id', $user->tenant_id)->first();
    $vcardNumber = null;
    if ($vcard && !empty($vcard->region_code) && !empty($vcard->phone)) {
      $vcardNumber = preg_replace('/\D+/', '', $vcard->region_code . $vcard->phone);
    }

    $redirectLink = RedirectLink::where('user_id', $user->id)->latest()->first();
    $redirectCard = null;
    if ($redirectLink) {
      // try to include nfc id if present, otherwise redirect link id
      $redirectCard = $redirectLink->nfcs_id ?? $redirectLink->id;
    }

    $whatsappStore = WhatsappStore::where('tenant_id', $user->tenant_id)->first();
    $storeLink = null;
    if ($whatsappStore) {
      try {
        $storeLink = route('whatsapp.store.show', $whatsappStore->url_alias);
      } catch (\Exception $e) {
        $storeLink = null;
      }
    }

    $sitePrefix = getSuperAdminSettingValue('prefix_code') ?? '';
    $sitePhone = getSuperAdminSettingValue('phone') ?? '';

    $toPhone = null;
    if (!empty($sitePhone)) {
      $toPhone = preg_replace('/\D+/', '', ($sitePrefix ? $sitePrefix : '') . $sitePhone);
    }

    return response()->json([
      'first' => $first,
      'second' => $second,
      'vcard_number' => $vcardNumber,
      'redirect_card' => $redirectCard,
      'store_link' => $storeLink,
      'to_phone' => $toPhone,
    ]);
  }
}
