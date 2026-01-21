<?php

namespace App\Http\Controllers;

use App\Models\Nfc;
use App\Models\Setting;
use App\Models\NfcOrders;
use Laracasts\Flash\Flash;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\NfcOrderTransaction;
use App\Repositories\NfcRepository;
use App\Http\Requests\CreateNfcRequest;
use App\Http\Requests\UpdateNfcCardRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\QrcodeEdit;
use Spatie\Color\Hex;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class NfcController extends AppBaseController
{
  private $NfcRepository;

  public function __construct(NfcRepository $NfcRepository)
  {
    $this->NfcRepository = $NfcRepository;
  }

  public function index(Request $request)
  {
    return view('sadmin.nfc.index');
  }

  public function store(CreateNfcRequest $request)
  {

    $input = $request->all();

    $nfc = $this->NfcRepository->store($input);

    return $this->sendResponse($nfc, __('messages.nfc.nfc_card_created_success'));
  }

  public function edit($id)
  {

    $nfc = Nfc::with('media')->find($id);

    return $this->sendResponse($nfc, 'Nfc Type  successfully retrieved.');
  }

  public function update(UpdateNfcCardRequest $request, $id)
  {
    $input = $request->all();

    $nfc = $this->NfcRepository->update($input, $id);

    return $this->sendResponse($nfc, __('messages.nfc.nfc_card_updated_success'));
  }

  public function destroy($id)
  {
    $nfcOrder = NfcOrders::where('card_type', $id)->exists();

    if ($nfcOrder) {
      return $this->sendError(__('messages.nfc.card_can_not_deleted'));
    }

    $nfc = Nfc::find($id);
    $nfc->delete();

    return $this->sendSuccess(__('messages.nfc.nfc_card_deleted_success'));
  }

  public function getNfcCardTax()
  {
    $tax = Setting::where('key', 'nfc_tax_value')->value('value');
    $status = Setting::where('key', 'nfc_tax_enabled')->value('value');

    return response()->json([
      'tax' => $tax,
      'status' => $status == 1 ? true : false,
    ]);
  }

  public function nfcCardTax(Request $request)
  {
    $input = $request->all();

    $request->validate([
      'nfc_tax_value' => 'required|numeric',
    ]);

    $taxSettings = [
      'nfc_tax_value' => $input['nfc_tax_value'],
      'nfc_tax_enabled' => isset($input['nfc_tax_enabled']) ? 1 : 0,
    ];

    foreach ($taxSettings as $key => $value) {
      Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    return response()->json([
      'success' => true,
      'message' => __('messages.nfc.nfc_card_tax_saved_successfully'),
    ]);
  }

  public function exportTestImages($id)
  {
    $nfc = Nfc::with('media')->findOrFail($id);

    Log::info("Exporting test images for NFC ID: {$id}");
    Log::info("NFC media count: " . $nfc->media->count());
    Log::info("Front media: " . ($nfc->getFirstMedia('nfc_image') ? 'exists' : 'not found'));
    Log::info("Back media: " . ($nfc->getFirstMedia('nfc_back_image') ? 'exists' : 'not found'));

    $timestamp = time();
    $tempDirectory = storage_path('app/temp_nfc_test/' . $timestamp);

    if (!is_dir($tempDirectory)) {
      mkdir($tempDirectory, 0777, true);
    }

    // Get QR code settings
    $customQrCode = QrcodeEdit::withoutGlobalScopes()
      ->where('tenant_id', getLogInTenantId())
      ->first();

    if (empty($customQrCode)) {
      $customQrCode = [
        'qrcode_color' => '#000000',
        'background_color' => '#ffffff',
      ];
    }

    $qrcodeColor['qrcodeColor'] = Hex::fromString($customQrCode['qrcode_color'])->toRgb();
    $qrcodeColor['background_color'] = Hex::fromString($customQrCode['background_color'])->toRgb();

    // Test URL and data
    $testUrl = 'https://nfcjo.com/';
    $testCode = 'XXXXXX';
    $testSerialNo = '00001';

    // Generate both images
    $generatedImages = $this->generateTestImagesWithQR(
      $testUrl,
      $testCode,
      $testSerialNo,
      $nfc,
      $qrcodeColor,
      $customQrCode,
      $tempDirectory
    );

    // Check if any images were generated
    if (empty($generatedImages)) {
      $debug = [
        'nfc_id' => $id,
        'media_count' => $nfc->media->count(),
        'front_media_exists' => $nfc->getFirstMedia('nfc_image') ? true : false,
        'back_media_exists' => $nfc->getFirstMedia('nfc_back_image') ? true : false,
        'front_media_path' => $nfc->getFirstMedia('nfc_image') ? $nfc->getFirstMedia('nfc_image')->getPath() : null,
        'back_media_path' => $nfc->getFirstMedia('nfc_back_image') ? $nfc->getFirstMedia('nfc_back_image')->getPath() : null,
        'front_file_exists' => $nfc->getFirstMedia('nfc_image') && file_exists($nfc->getFirstMedia('nfc_image')->getPath()),
        'back_file_exists' => $nfc->getFirstMedia('nfc_back_image') && file_exists($nfc->getFirstMedia('nfc_back_image')->getPath()),
      ];
      $this->deleteDirectory($tempDirectory);
      return response()->json(['error' => 'No images could be processed. Please check that your NFC card has valid front/back images.', 'debug' => $debug], 400);
    }

    $zipFileName = 'nfc_test_images_' . $nfc->name . '_' . $timestamp . '.zip';
    $zipPath = $tempDirectory . '/' . $zipFileName;

    $zip = new ZipArchive();
    $zipOpenResult = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    if ($zipOpenResult !== TRUE) {
      $this->deleteDirectory($tempDirectory);
      return response()->json(['error' => 'Failed to create ZIP file. Error code: ' . $zipOpenResult], 500);
    }

    $filesAdded = 0;
    foreach ($generatedImages as $imagePath) {
      if (file_exists($imagePath)) {
        $zip->addFile($imagePath, basename($imagePath));
        $filesAdded++;
      }
    }
    $zip->close();

    if ($filesAdded === 0 || !file_exists($zipPath)) {
      $this->deleteDirectory($tempDirectory);
      return response()->json(['error' => 'Failed to add images to ZIP file'], 500);
    }

    $zipContent = file_get_contents($zipPath);
    $this->deleteDirectory($tempDirectory);

    return response($zipContent)
      ->header('Content-Type', 'application/zip')
      ->header('Content-Disposition', 'attachment; filename="' . $zipFileName . '"')
      ->header('Content-Length', strlen($zipContent));
  }

  private function generateTestImagesWithQR($testUrl, $testCode, $testSerialNo, $nfc, $qrcodeColor, $customQrCode, $tempDirectory)
  {
    $generatedImages = [];

    Log::info("Generating test images for NFC: {$nfc->id}");

    // Determine which side gets the QR code
    $qrSide = $nfc->qr_position_side ?? 'front';

    // Generate QR code image
    $qrSize = $nfc->qr_size ?? 100;
    $qrImage = QrCode::format('png')
      ->size($qrSize)
      ->color(
        $qrcodeColor['qrcodeColor']->red(),
        $qrcodeColor['qrcodeColor']->green(),
        $qrcodeColor['qrcodeColor']->blue()
      )
      ->backgroundColor(
        $qrcodeColor['background_color']->red(),
        $qrcodeColor['background_color']->green(),
        $qrcodeColor['background_color']->blue()
      )
      ->margin(0)
      ->generate($testUrl);

    // Save QR code temporarily
    $qrPath = $tempDirectory . '/test_qr.png';
    file_put_contents($qrPath, $qrImage);
    $qrImageGd = imagecreatefrompng($qrPath);

    // Get QR dimensions
    $qrWidth = imagesx($qrImageGd);
    $qrHeight = imagesy($qrImageGd);

    // Get positions from NFC settings
    $xPos = $nfc->qr_x_position ?? 0;
    $yPos = $nfc->qr_y_position ?? 0;

    // Get the front and back images
    $frontMedia = $nfc->getFirstMedia('nfc_image');
    $backMedia = $nfc->getFirstMedia('nfc_back_image');

    Log::info("Front media object: " . ($frontMedia ? 'exists' : 'null'));
    Log::info("Back media object: " . ($backMedia ? 'exists' : 'null'));

    if ($frontMedia) {
      try {
        $frontImagePath = $frontMedia->getPath();
        Log::info("Front image path: {$frontImagePath}");
        Log::info("Front image file exists: " . (file_exists($frontImagePath) ? 'yes' : 'no'));
        $frontImage = imagecreatefromstring(file_get_contents($frontImagePath));
        Log::info("Front image created: " . ($frontImage !== false ? 'success' : 'failed'));
        if ($frontImage !== false) {
          if ($qrSide === 'front') {
            imagecopy($frontImage, $qrImageGd, $xPos, $yPos, 0, 0, $qrWidth, $qrHeight);
            $this->addTestTextOverlays($frontImage, $testCode, $testSerialNo, $xPos, $yPos, $qrSize, $nfc);
          }
          $frontPath = $tempDirectory . '/nfc_front_test.png';
          imagepng($frontImage, $frontPath);
          imagedestroy($frontImage);
          $generatedImages[] = $frontPath;
          Log::info("Front image processed successfully");
        }
      } catch (\Exception $e) {
        Log::error("Error processing front image: " . $e->getMessage());
        // Skip if error
      }
    }

    if ($backMedia) {
      try {
        $backImagePath = $backMedia->getPath();
        Log::info("Back image path: {$backImagePath}");
        Log::info("Back image file exists: " . (file_exists($backImagePath) ? 'yes' : 'no'));
        $backImage = imagecreatefromstring(file_get_contents($backImagePath));
        Log::info("Back image created: " . ($backImage !== false ? 'success' : 'failed'));
        if ($backImage !== false) {
          if ($qrSide === 'back') {
            imagecopy($backImage, $qrImageGd, $xPos, $yPos, 0, 0, $qrWidth, $qrHeight);
            $this->addTestTextOverlays($backImage, $testCode, $testSerialNo, $xPos, $yPos, $qrSize, $nfc);
          }
          $backPath = $tempDirectory . '/nfc_back_test.png';
          imagepng($backImage, $backPath);
          imagedestroy($backImage);
          $generatedImages[] = $backPath;
          Log::info("Back image processed successfully");
        }
      } catch (\Exception $e) {
        Log::error("Error processing back image: " . $e->getMessage());
        // Skip if error
      }
    }

    Log::info("Generated images count: " . count($generatedImages));

    imagedestroy($qrImageGd);
    return $generatedImages;
  }

  private function addTestTextOverlays($image, $testCode, $testSerialNo, $qrX, $qrY, $qrSize, $nfc)
  {
    // Get font size from NFC settings
    $fontSize = $nfc->text_font_size ?? 14;

    // Convert font size to GD font size (approximate)
    $gdFontSize = max(1, min(5, round($fontSize / 3)));

    // Text color (black)
    $textColor = imagecolorallocate($image, 0, 0, 0);

    // Starting Y position (below QR code)
    $textY = $qrY + $qrSize + 10;

    // Add "Code: XXXXXX"
    imagestring($image, $gdFontSize, $qrX, $textY, "Code: " . $testCode, $textColor);

    // Add "Serial No: 00001"
    $textY += $fontSize + 5;
    imagestring($image, $gdFontSize, $qrX, $textY, "Serial No: " . $testSerialNo, $textColor);
  }

  private function deleteDirectory($dir)
  {
    if (!is_dir($dir)) {
      return false;
    }

    $items = array_diff(scandir($dir), ['.', '..']);

    foreach ($items as $item) {
      $path = $dir . DIRECTORY_SEPARATOR . $item;
      if (is_dir($path)) {
        $this->deleteDirectory($path);
      } else {
        unlink($path);
      }
    }

    return rmdir($dir);
  }
}
