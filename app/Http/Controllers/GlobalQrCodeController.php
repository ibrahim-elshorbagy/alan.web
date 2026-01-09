<?php

namespace App\Http\Controllers;

use App\Models\QrcodeEdit;
use App\Models\Vcard;
use App\Models\WhatsappStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Spatie\Color\Hex;

class GlobalQrCodeController extends Controller
{
  public function index()
  {
    // Get global QR code settings for the current tenant (or global for super admin)
    $tenantId = getLogInTenantId();
    if (auth()->user()->hasRole('super_admin')) {
      // For super admin, get global settings that apply to all tenants
      $customQrCode = QrcodeEdit::withoutGlobalScopes()->where('is_global', true)
        ->whereNull('vcard_id')
        ->whereNull('whatsapp_store_id')
        ->whereNull('tenant_id')
        ->pluck('value', 'key')
        ->toArray();
    } else {
      // For normal admin, get tenant-specific global settings, or super admin global if none
      $customQrCode = QrcodeEdit::whereTenantId($tenantId)
        ->where('is_global', true)
        ->whereNull('vcard_id')
        ->whereNull('whatsapp_store_id')
        ->pluck('value', 'key')
        ->toArray();
      // If no tenant global, get super admin global
      if (empty($customQrCode)) {
        $customQrCode = QrcodeEdit::withoutGlobalScopes()->whereNull('tenant_id')
          ->where('is_global', true)
          ->whereNull('vcard_id')
          ->whereNull('whatsapp_store_id')
          ->pluck('value', 'key')
          ->toArray();
      }
    }

    // Set default values if no global settings exist
    if (empty($customQrCode)) {
      $customQrCode['qrcode_color'] = '#000000';
      $customQrCode['background_color'] = '#ffffff';
      $customQrCode['style'] = 'square';
      $customQrCode['eye_style'] = 'square';
      $customQrCode['applySetting'] = '1';
    }

    // Convert hex colors to RGB for QR code generation (same as VcardController)
    $qrcodeColor['qrcodeColor'] = Hex::fromString($customQrCode['qrcode_color'])->toRgb();
    $qrcodeColor['background_color'] = Hex::fromString($customQrCode['background_color'])->toRgb();

    // Get all vCards for the current tenant
    $vcards = Vcard::whereTenantId($tenantId)->get();

    // Get all WhatsApp stores for the current tenant
    $whatsappStores = WhatsappStore::whereTenantId($tenantId)->get();

    // If no vcards or whatsapp stores, add a demo vcard for showcase
    if ($vcards->isEmpty() && $whatsappStores->isEmpty()) {
      $demoVcard = (object) [
        'id' => 'demo',
        'name' => 'Demo NFC Card',
        'url_alias' => 'demo',
        'url' => 'https://nfcjo.com',
        'is_demo' => true,
      ];
      $vcards = collect([$demoVcard]);
    }

    // Get all redirect links for the current user
    $redirectLinks = \App\Models\RedirectLink::where('user_id', Auth::id())->with('nfc')->get();

    return view('global_qr_code.index', compact('customQrCode', 'qrcodeColor', 'vcards', 'whatsappStores', 'redirectLinks'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'qrcode_color' => 'required',
      'background_color' => 'required',
      'style' => 'required',
      'eye_style' => 'required',
    ]);

    try {
      DB::beginTransaction();

      $input = $request->all();
      // Always apply to all - force it to be enabled
      $input['applySetting'] = 1;

      $tenantId = getLogInTenantId();
      $isSuperAdmin = auth()->user()->hasRole('super_admin');

      // Save or update global QR code settings
      foreach ($input as $key => $value) {
        if (in_array($key, ['qrcode_color', 'background_color', 'style', 'eye_style', 'applySetting'])) {
          if ($isSuperAdmin) {
            // For super admin, don't filter by tenant_id
            $qrCodeCustomize = QrcodeEdit::where('key', $key)
              ->where('is_global', true)
              ->whereNull('vcard_id')
              ->whereNull('whatsapp_store_id')
              ->whereNull('tenant_id')
              ->first();
          } else {
            // For normal admin, filter by tenant_id
            $qrCodeCustomize = QrcodeEdit::whereTenantId($tenantId)
              ->where('key', $key)
              ->where('is_global', true)
              ->whereNull('vcard_id')
              ->whereNull('whatsapp_store_id')
              ->first();
          }

          if ($qrCodeCustomize) {
            $qrCodeCustomize->update(['value' => $value]);
          } else {
            QrcodeEdit::create([
              'tenant_id' => $isSuperAdmin ? null : $tenantId,
              'key' => $key,
              'value' => $value,
              'is_global' => true,
            ]);
          }
        }
      }

      // Always apply to all existing VCards and WhatsApp Stores
      $this->applyToAllVcardsAndStores($input);

      DB::commit();

      Flash::success(__('messages.flash.global_qr_code_updated'));

      $routeName = $isSuperAdmin ? 'sadmin.global.qr.code.index' : 'global.qr.code.index';
      return redirect()->route($routeName);
    } catch (\Exception $e) {
      DB::rollBack();
      Flash::error($e->getMessage());

      return redirect()->back()->withInput();
    }
  }

  private function applyToAllVcardsAndStores($input)
  {
    $tenantId = getLogInTenantId();
    $isSuperAdmin = auth()->user()->hasRole('super_admin');

    if ($isSuperAdmin) {
      // For super admin, apply to all tenants
      $vcards = \App\Models\Vcard::withoutGlobalScopes()->get();
      $whatsappStores = \App\Models\WhatsappStore::withoutGlobalScopes()->get();
    } else {
      // For normal admin, apply only to current tenant
      $vcards = \App\Models\Vcard::whereTenantId($tenantId)->get();
      $whatsappStores = \App\Models\WhatsappStore::whereTenantId($tenantId)->get();
    }

    // Update or create QR code settings for all VCards
    foreach ($vcards as $vcard) {
      $vcardId = $vcard->id;
      foreach ($input as $key => $value) {
        if (in_array($key, ['qrcode_color', 'background_color', 'style', 'eye_style', 'applySetting'])) {
          if ($isSuperAdmin) {
            // For super admin, find existing settings without tenant filter
            $qrCodeCustomize = QrcodeEdit::where('key', $key)
              ->where('vcard_id', $vcardId)
              ->first();
          } else {
            // For normal admin, filter by tenant
            $qrCodeCustomize = QrcodeEdit::whereTenantId($tenantId)
              ->where('key', $key)
              ->where('vcard_id', $vcardId)
              ->first();
          }

          if ($qrCodeCustomize) {
            $qrCodeCustomize->update(['value' => $value]);
          } else {
            QrcodeEdit::create([
              'tenant_id' => $isSuperAdmin ? $vcard->tenant_id : $tenantId,
              'vcard_id' => $vcardId,
              'key' => $key,
              'value' => $value,
              'is_global' => false,
            ]);
          }
        }
      }
    }

    // Update or create QR code settings for all WhatsApp Stores
    foreach ($whatsappStores as $store) {
      $storeId = $store->id;
      foreach ($input as $key => $value) {
        if (in_array($key, ['qrcode_color', 'background_color', 'style', 'eye_style', 'applySetting'])) {
          if ($isSuperAdmin) {
            // For super admin, find existing settings without tenant filter
            $qrCodeCustomize = QrcodeEdit::where('key', $key)
              ->where('whatsapp_store_id', $storeId)
              ->first();
          } else {
            // For normal admin, filter by tenant
            $qrCodeCustomize = QrcodeEdit::whereTenantId($tenantId)
              ->where('key', $key)
              ->where('whatsapp_store_id', $storeId)
              ->first();
          }

          if ($qrCodeCustomize) {
            $qrCodeCustomize->update(['value' => $value]);
          } else {
            QrcodeEdit::create([
              'tenant_id' => $isSuperAdmin ? $store->tenant_id : $tenantId,
              'whatsapp_store_id' => $storeId,
              'key' => $key,
              'value' => $value,
              'is_global' => false,
            ]);
          }
        }
      }
    }
  }
}
