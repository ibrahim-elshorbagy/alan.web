<?php

namespace App\Http\Controllers;

use App\Models\QrcodeEdit;
use App\Models\Vcard;
use App\Models\WhatsappStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Spatie\Color\Hex;

class GlobalQrCodeController extends Controller
{
  public function index()
  {
    // Get global QR code settings for the current tenant
    $customQrCode = QrcodeEdit::whereTenantId(getLogInTenantId())
      ->where('is_global', true)
      ->whereNull('vcard_id')
      ->whereNull('whatsapp_store_id')
      ->pluck('value', 'key')
      ->toArray();

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
    $vcards = Vcard::whereTenantId(getLogInTenantId())->get();

    // Get all WhatsApp stores for the current tenant
    $whatsappStores = WhatsappStore::whereTenantId(getLogInTenantId())->get();

    return view('global_qr_code.index', compact('customQrCode', 'qrcodeColor', 'vcards', 'whatsappStores'));
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

      // Save or update global QR code settings
      foreach ($input as $key => $value) {
        if (in_array($key, ['qrcode_color', 'background_color', 'style', 'eye_style', 'applySetting'])) {
          $qrCodeCustomize = QrcodeEdit::whereTenantId(getLogInTenantId())
            ->where('key', $key)
            ->where('is_global', true)
            ->whereNull('vcard_id')
            ->whereNull('whatsapp_store_id')
            ->first();

          if ($qrCodeCustomize) {
            $qrCodeCustomize->update(['value' => $value]);
          } else {
            QrcodeEdit::create([
              'tenant_id' => getLogInTenantId(),
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

      return redirect()->route('global.qr.code.index');
    } catch (\Exception $e) {
      DB::rollBack();
      Flash::error($e->getMessage());

      return redirect()->back()->withInput();
    }
  }

  private function applyToAllVcardsAndStores($input)
  {
    $tenantId = getLogInTenantId();

    // Get all VCards for this tenant
    $vcards = \App\Models\Vcard::where('tenant_id', $tenantId)->pluck('id');

    // Get all WhatsApp Stores for this tenant
    $whatsappStores = \App\Models\WhatsappStore::where('tenant_id', $tenantId)->pluck('id');

    // Update or create QR code settings for all VCards
    foreach ($vcards as $vcardId) {
      foreach ($input as $key => $value) {
        if (in_array($key, ['qrcode_color', 'background_color', 'style', 'eye_style', 'applySetting'])) {
          $qrCodeCustomize = QrcodeEdit::whereTenantId($tenantId)
            ->where('key', $key)
            ->where('vcard_id', $vcardId)
            ->first();

          if ($qrCodeCustomize) {
            $qrCodeCustomize->update(['value' => $value]);
          } else {
            QrcodeEdit::create([
              'tenant_id' => $tenantId,
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
    foreach ($whatsappStores as $storeId) {
      foreach ($input as $key => $value) {
        if (in_array($key, ['qrcode_color', 'background_color', 'style', 'eye_style', 'applySetting'])) {
          $qrCodeCustomize = QrcodeEdit::whereTenantId($tenantId)
            ->where('key', $key)
            ->where('whatsapp_store_id', $storeId)
            ->first();

          if ($qrCodeCustomize) {
            $qrCodeCustomize->update(['value' => $value]);
          } else {
            QrcodeEdit::create([
              'tenant_id' => $tenantId,
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
