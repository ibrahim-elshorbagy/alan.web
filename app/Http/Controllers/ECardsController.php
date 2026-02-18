<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEcardRequest;
use App\Models\Vcard;
use App\Models\WhatsappStore;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\QrcodeEdit;
use Spatie\Color\Hex;

class ECardsController extends Controller
{
  public function index(): View|Factory|Application
  {
    $tenantId = Auth::user()->tenant_id;
    $vCards = Vcard::whereTenantId($tenantId)->pluck('name', 'id');

    return view('virtual-backgrounds.index', compact('vCards'));
  }

  public function getVcardData(Request $request): JsonResponse
  {
    $input = $request->all();
    $vcard = Vcard::with('socialLink')->findOrFail($input['vcardId']);

    $data = [
      'id' => $vcard['id'],
      'first_name' => $vcard['first_name'],
      'last_name' => $vcard['last_name'],
      'email' => $vcard['email'],
      'occupation' => $vcard['occupation'],
      'location' => $vcard['location'],
      'region_code' => $vcard['region_code'],
      'phone' => $vcard['phone'],
      'website' => $vcard['socialLink']['website'],
    ];

    return response()->json(['data' => $data, 'success' => true]);
  }

  public function getWhatsappStoreData(Request $request): JsonResponse
  {
    $input = $request->all();
    $store = WhatsappStore::findOrFail($input['storeId']);

    // Build a website URL from the store alias
    $website = url('/wp-store/' . $store->url_alias);

    $data = [
      'id'          => $store->id,
      'first_name'  => $store->store_name,
      'last_name'   => '',
      'email'       => '',
      'occupation'  => $store->store_name,
      'location'    => $store->address ?? '',
      'region_code' => $store->region_code ?? '',
      'phone'       => $store->whatsapp_no ?? '',
      'website'     => $website,
    ];

    return response()->json(['data' => $data, 'success' => true]);
  }

  public function downloadEcard(CreateEcardRequest $request): RedirectResponse
  {
    $input = $request->all();

    if ($request->hasFile('ecard-logo')) {
      $image = $request->file('ecard-logo');
      $resizedImage = Image::make($image)->resize(150, 150);
      $filename = time() . '_' . $image->getClientOriginalName();
      $tempPath = public_path('uploads/ecard/temp');
      if (!file_exists($tempPath)) {
        mkdir($tempPath, 0755, true);
      }
      $path = $tempPath . '/' . $filename;
      $resizedImage->save($path);
      $input['ecard-logo'] = $path;
    }

    $path = asset('uploads/ecard');

    if (! Storage::exists($path)) {
      Storage::disk('public')->makeDirectory('uploads/ecard');
    }

    $zipFile = public_path('virtual_backgrounds/virtual-backgrounds.zip');
    if (File::exists($zipFile)) {
      File::delete($zipFile);
    }

    // Get Global QR Code settings for the current tenant
    $tenantId = getLogInTenantId();
    $isSuperAdmin = auth()->user()->hasRole('super_admin');

    if ($isSuperAdmin) {
      // For super admin, get global settings
      $customQrCode = QrcodeEdit::withoutGlobalScopes()->where('is_global', true)
        ->whereNull('vcard_id')
        ->whereNull('whatsapp_store_id')
        ->whereNull('tenant_id')
        ->pluck('value', 'key')
        ->toArray();
    } else {
      // For normal admin, get tenant-specific global settings
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

    // Convert hex colors to RGB for QR code generation
    $qrcodeColor = [
      'qrcodeColor' => Hex::fromString($customQrCode['qrcode_color'])->toRgb(),
      'background_color' => Hex::fromString($customQrCode['background_color'])->toRgb(),
    ];

    if ($input['e-card-id'] == 1) {
      $data = retriveH1Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 2) {
      $data = retriveH2Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 3) {
      $data = retriveH3Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 4) {
      $data = retriveH4Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 5) {
      $data = retriveH5Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 6) {
      $data = retriveH6Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 7) {
      $data = retriveH7Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 8) {
      $data = retriveH8Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 9) {
      $data = retriveH9Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 10) {
      $data = retriveH10Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 11) {
      $data = retriveH11Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 12) {
      $data = retriveH12Card($input, $customQrCode, $qrcodeColor);
    }
    if ($input['e-card-id'] == 13) {
      $data = retriveH13Card($input, $customQrCode, $qrcodeColor);
    }

    // delete images after generate zip file
    $vcardId = ($input['source_type'] ?? 'vcard') === 'whatsapp_store'
      ? 'ws_' . ($input['whatsapp_store_id'] ?? 0)
      : $input['vcard_id'];
    $qrCodeImage = public_path('ecard/' . $vcardId . '-qr.png');
    $frontImage = public_path('virtual_backgrounds/Front.jpg');
    $backImage = public_path('virtual_backgrounds/Back.jpg');
    $frontImage1 = public_path('uploads/ecard/' . $vcardId . '/Front.png');
    $backImage1 = public_path('uploads/ecard/' . $vcardId . '/Back.png');
    $directory = public_path('uploads/ecard/' . $vcardId);


    if (File::exists($qrCodeImage)) {
      File::delete($qrCodeImage);
    }
    if (File::exists($frontImage)) {
      File::delete($frontImage);
    }
    if (File::exists($backImage)) {
      File::delete($backImage);
    }
    if (File::exists($frontImage1)) {
      File::delete($frontImage1);
    }
    if (File::exists($backImage1)) {
      File::delete($backImage1);
      File::deleteDirectory($directory);
    }

    return redirect(asset($data[0]));
  }

  public function getEcard(Request $request): \Illuminate\View\View
  {
    return view();
  }

  public function create($ecard): \Illuminate\View\View
  {
    $vcards = Vcard::whereTenantId(getLogInTenantId())->where('status', Vcard::ACTIVE)->pluck('name', 'id')->toArray();
    $whatsappStores = WhatsappStore::whereTenantId(getLogInTenantId())->pluck('store_name', 'id')->toArray();

    return view('virtual-backgrounds.create', compact('vcards', 'ecard', 'whatsappStores'));
  }

  public function store(Request $request, $cardImageId) {}

  public function custom(): View|Factory|Application
  {
    $tenantId = Auth::user()->tenant_id;
    $vcards = Vcard::whereTenantId($tenantId)->pluck('name', 'id');

    return view('virtual-backgrounds.custom', compact('vcards'));
  }

  public function qrCode(Request $request)
  {
    $link = $request->input('link');
    $qrcode = QrCode::size(100)->generate($link);
    return $qrcode;
  }
}
