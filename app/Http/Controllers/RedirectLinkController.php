<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RedirectLink;
use App\Models\User;
use App\Models\Nfc;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RedirectLinksExport;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\QrcodeEdit;
use Spatie\Color\Hex;
use TCPDF;

class RedirectLinkController extends Controller
{
  public function index()
  {
    return view('admin.redirect_links.index');
  }

  public function create()
  {
    $nfcs = Nfc::all();
    $salesUsers = User::role('sales')->get();

    return view('admin.redirect_links.create', compact('nfcs', 'salesUsers'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'redirect_link_type' => 'required|integer',
      'nfcs_id' => 'required|exists:nfcs,id',
      'number_of_cards' => 'required|integer|min:1|max:1000',
      'assigned_id' => 'nullable|exists:users,id',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $redirectLinkType = $request->redirect_link_type;
    $nfcsId = $request->nfcs_id;
    $numberOfCards = $request->number_of_cards;

    $createdLinks = [];

    for ($i = 0; $i < $numberOfCards; $i++) {
      $uri = $this->generateUniqueUri();

      $redirectLink = RedirectLink::create([
        'user_id' => null,
        'uri' => $uri,
        'redirect_link' => null,
        'redirect_link_type' => $redirectLinkType,
        'status' => 0,
        'nfcs_id' => $nfcsId,
        'assigned_id' => $request->assigned_id,
      ]);

      $createdLinks[] = $redirectLink;
    }

    session()->flash('success', __('messages.redirect_links.created'));

    return $this->generatePackage($createdLinks);
  }

  public function extractAll()
  {
    $redirectLinks = RedirectLink::all();

    // For sales, filter to only their assigned links
    if (auth()->user()->hasRole('sales')) {
      $redirectLinks = $redirectLinks->where('assigned_id', auth()->id());
    }

    if ($redirectLinks->isEmpty()) {
      return redirect()->back()->with('error', 'No redirect links found to extract');
    }

    return $this->generatePackage($redirectLinks);
  }

  public function exportSelected(Request $request)
  {
    $ids = $request->input('ids');

    if (!$ids) {
      return redirect()->back()->with('error', __('messages.redirect_links.no_items_selected'));
    }

    $idsArray = explode(',', $ids);
    $redirectLinks = RedirectLink::whereIn('id', $idsArray)->get();

    // For sales, filter to only their assigned links
    if (auth()->user()->hasRole('sales')) {
      $redirectLinks = $redirectLinks->where('assigned_id', auth()->id());
    }

    if ($redirectLinks->isEmpty()) {
      return redirect()->back()->with('error', __('messages.redirect_links.no_items_found'));
    }

    return $this->generatePackage($redirectLinks);
  }

  public function markAllAsReceived()
  {
    if (!auth()->user()->hasRole('sales')) {
      return redirect()->back()->with('error', 'Unauthorized');
    }

    $updated = RedirectLink::where('assigned_id', auth()->id())
      ->where('received_status', RedirectLink::RECEIVED_STATUS_NOT_RECEIVED)
      ->update(['received_status' => RedirectLink::RECEIVED_STATUS_RECEIVED]);

    if ($updated > 0) {
      session()->flash('success', __('messages.redirect_links.received_all') . ' (' . $updated . ' links)');
    } else {
      session()->flash('info', __('messages.redirect_links.no_items_found'));
    }

    return redirect()->back();
  }

  private function generatePackage($redirectLinks)
  {
    $timestamp = time();
    $tempDirectory = storage_path('app/temp_redirect_qr/' . $timestamp);

    if (!is_dir($tempDirectory)) {
      File::makeDirectory($tempDirectory, 0777, true);
    }

    $excelData = [];

    $customQrCode = QrcodeEdit::withoutGlobalScopes()
      ->whereNull('tenant_id')
      ->where('is_global', true)
      ->whereNull('vcard_id')
      ->whereNull('whatsapp_store_id')
      ->pluck('value', 'key')
      ->toArray();

    if (empty($customQrCode)) {
      $customQrCode['qrcode_color'] = '#000000';
      $customQrCode['background_color'] = '#ffffff';
      $customQrCode['style'] = 'square';
      $customQrCode['eye_style'] = 'square';
      $customQrCode['applySetting'] = '1';
    }

    $qrcodeColor['qrcodeColor'] = Hex::fromString($customQrCode['qrcode_color'])->toRgb();
    $qrcodeColor['background_color'] = Hex::fromString($customQrCode['background_color'])->toRgb();

    // Get NFC card information for the first link (all should have the same NFC)
    $nfc = $redirectLinks->first()->nfc;
    $useCustomPosition = $nfc && $nfc->apply_coordinates;

    // Create PDF with TCPDF - use A4 and scale images to fit
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('NFC System');
    $pdf->SetAuthor('NFC System');
    $pdf->SetTitle('QR Codes');
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetAutoPageBreak(false);

    foreach ($redirectLinks as $link) {
      $fullUrl = url('/auto-' . $link->uri);

      if ($useCustomPosition) {
        // Generate both front and back images with QR on selected side
        $images = $this->generateBothImagesWithQR(
          $link,
          $fullUrl,
          $nfc,
          $qrcodeColor,
          $customQrCode,
          $tempDirectory
        );

        $excelData[] = [
          'id' => $link->id,
          'uri' => $link->uri,
          'full_link' => $fullUrl,
        ];

        // Add single page with both front and back images side by side
        $pdf->AddPage();

        // Get dimensions for both images
        list($frontWidth, $frontHeight) = getimagesize($images['front']);
        list($backWidth, $backHeight) = getimagesize($images['back']);

        $frontWidthMm = $frontWidth * 0.264583;
        $frontHeightMm = $frontHeight * 0.264583;
        $backWidthMm = $backWidth * 0.264583;
        $backHeightMm = $backHeight * 0.264583;

        // Calculate scale to fit both images side by side on A4 (210x297mm)
        // Each image gets half the width with 5mm spacing
        $maxWidthPerImage = (210 - 15) / 2; // 15mm total margins (5mm left, 5mm center, 5mm right)
        $maxHeight = 277; // Height with margins

        // Scale front image
        $frontScale = min($maxWidthPerImage / $frontWidthMm, $maxHeight / $frontHeightMm);
        $frontNewWidth = $frontWidthMm * $frontScale;
        $frontNewHeight = $frontHeightMm * $frontScale;

        // Scale back image
        $backScale = min($maxWidthPerImage / $backWidthMm, $maxHeight / $backHeightMm);
        $backNewWidth = $backWidthMm * $backScale;
        $backNewHeight = $backHeightMm * $backScale;

        // Position images side by side centered
        $frontX = 5;
        $frontY = (297 - $frontNewHeight) / 2;
        $backX = 210 - $backNewWidth - 5;
        $backY = (297 - $backNewHeight) / 2;

        $pdf->Image($images['front'], $frontX, $frontY, $frontNewWidth, $frontNewHeight, 'PNG');
        $pdf->Image($images['back'], $backX, $backY, $backNewWidth, $backNewHeight, 'PNG');
      } else {
        // Use default behavior - generate QR code PNG
        $qrImage = QrCode::format('png')
          ->size(400)
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
          ->style($customQrCode['style'])
          ->eye($customQrCode['eye_style'])
          ->errorCorrection('H')
          ->generate($fullUrl);

        $pngPath = $tempDirectory . '/' . $link->uri . '.png';
        file_put_contents($pngPath, $qrImage);

        $excelData[] = [
          'id' => $link->id,
          'uri' => $link->uri,
          'full_link' => $fullUrl,
        ];

        // Add page to PDF
        $pdf->AddPage();

        // Add QR image (centered: x=55mm, y=50mm, width=100mm, height=100mm)
        $pdf->Image($pngPath, 55, 50, 100, 100, 'PNG');

        // Add URI text below image
        $pdf->SetFont('helvetica', 'B', 36);
        $pdf->SetXY(0, 170);
        $pdf->Cell(210, 10, $link->uri, 0, 0, 'C');
      }
    }

    // Save PDF
    $pdfFileName = 'redirect_links_qr_codes.pdf';
    $pdfPath = $tempDirectory . '/' . $pdfFileName;
    $pdf->Output($pdfPath, 'F');

    // Generate Excel
    $excelFileName = 'redirect_links_data.xlsx';
    $excelPath = $tempDirectory . '/' . $excelFileName;
    $excelContent = Excel::raw(new RedirectLinksExport($excelData), \Maatwebsite\Excel\Excel::XLSX);
    file_put_contents($excelPath, $excelContent);

    // Create ZIP
    $zipFileName = 'redirect_links_' . $timestamp . '.zip';
    $zipPath = $tempDirectory . '/' . $zipFileName;

    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
      foreach ($redirectLinks as $link) {
        if ($useCustomPosition) {
          $frontPath = $tempDirectory . '/' . $link->uri . '_front.png';
          $backPath = $tempDirectory . '/' . $link->uri . '_back.png';
          if (file_exists($frontPath)) {
            $zip->addFile($frontPath, 'images/' . $link->uri . '_front.png');
          }
          if (file_exists($backPath)) {
            $zip->addFile($backPath, 'images/' . $link->uri . '_back.png');
          }
        } else {
          $imagePath = $tempDirectory . '/' . $link->uri . '.png';
          if (file_exists($imagePath)) {
            $zip->addFile($imagePath, 'qr_codes/' . basename($imagePath));
          }
        }
      }

      if (file_exists($excelPath)) {
        $zip->addFile($excelPath, $excelFileName);
      }

      if (file_exists($pdfPath)) {
        $zip->addFile($pdfPath, $pdfFileName);
      }

      $zip->close();
    }

    if (!file_exists($zipPath)) {
      $this->deleteDirectory($tempDirectory);
      return redirect()->back()->with('error', 'Failed to create ZIP file');
    }

    $zipContent = file_get_contents($zipPath);
    $this->deleteDirectory($tempDirectory);

    return response($zipContent)
      ->header('Content-Type', 'application/zip')
      ->header('Content-Disposition', 'attachment; filename="' . $zipFileName . '"')
      ->header('Content-Length', strlen($zipContent));
  }

  private function generateBothImagesWithQR($link, $fullUrl, $nfc, $qrcodeColor, $customQrCode, $tempDirectory)
  {
    // Determine which side gets the QR code
    $qrSide = $nfc->qr_position_side ?? 'front';

    // Generate QR code image
    $qrSize = $nfc->qr_size ?? 400;
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
      ->style($customQrCode['style'])
      ->eye($customQrCode['eye_style'])
      ->errorCorrection('H')
      ->generate($fullUrl);

    // Save QR code temporarily
    $qrPath = $tempDirectory . '/' . $link->uri . '_qr.png';
    file_put_contents($qrPath, $qrImage);
    $qrImageGd = imagecreatefrompng($qrPath);

    // Get QR dimensions
    $qrWidth = imagesx($qrImageGd);
    $qrHeight = imagesy($qrImageGd);

    // Get positions from NFC settings
    $xPos = $nfc->qr_x_position ?? 0;
    $yPos = $nfc->qr_y_position ?? 0;

    // Process Front Image
    $frontImageUrl = $nfc->nfc_image;
    $frontImageContent = file_get_contents($frontImageUrl);
    $frontImage = imagecreatefromstring($frontImageContent);

    if ($qrSide === 'front') {
      // Add QR code to front
      imagecopy($frontImage, $qrImageGd, $xPos, $yPos, 0, 0, $qrWidth, $qrHeight);
    }

    // Add text overlays to front if QR is on front and coordinates applied
    if ($qrSide === 'front' && $nfc->apply_coordinates) {
      $this->addTextOverlays($frontImage, $link->uri, $link->id, $xPos, $yPos, $qrSize);
    }

    // Save front image
    $frontPath = $tempDirectory . '/' . $link->uri . '_front.png';
    imagepng($frontImage, $frontPath);
    imagedestroy($frontImage);

    // Process Back Image
    $backImageUrl = $nfc->nfc_back_image;
    $backImageContent = file_get_contents($backImageUrl);
    $backImage = imagecreatefromstring($backImageContent);

    if ($qrSide === 'back') {
      // Add QR code to back
      imagecopy($backImage, $qrImageGd, $xPos, $yPos, 0, 0, $qrWidth, $qrHeight);
    }

    // Add text overlays to back if QR is on back and coordinates applied
    if ($qrSide === 'back' && $nfc->apply_coordinates) {
      $this->addTextOverlays($backImage, $link->uri, $link->id, $xPos, $yPos, $qrSize);
    }

    // Save back image
    $backPath = $tempDirectory . '/' . $link->uri . '_back.png';
    imagepng($backImage, $backPath);
    imagedestroy($backImage);

    // Clean up QR image
    imagedestroy($qrImageGd);

    return [
      'front' => $frontPath,
      'back' => $backPath
    ];
  }

  private function addTextOverlays($image, $uri, $linkId, $qrX, $qrY, $qrSize)
  {
    // Get image dimensions
    $width = imagesx($image);
    $height = imagesy($image);

    // Set colors
    $black = imagecolorallocate($image, 0, 0, 0);
    $white = imagecolorallocate($image, 255, 255, 255);

    // Font paths - use system fonts or default
    $fontPath = public_path('fonts/Zain-Regular.ttf');
    if (!file_exists($fontPath)) {
      $fontPath = null; // Will use default font
    }

    // Text content
    $urlText = 'URL : ' . $uri;
    $serialText = 'Serial No : ' . str_pad($linkId, 4, '0', STR_PAD_LEFT);

    // Position directly below QR code
    $textY = $qrY + $qrSize + 20;
    $fontSize = 10; // Increased from 8 to 10 for slightly bigger text

    if ($fontPath) {
      // Normal text without outline
      imagettftext($image, $fontSize, 0, $qrX, $textY, $black, $fontPath, $urlText);
      imagettftext($image, $fontSize, 0, $qrX, $textY + 25, $black, $fontPath, $serialText);
    } else {
      // Fallback to default font
      imagestring($image, 2, $qrX, $textY, $urlText, $black);
      imagestring($image, 2, $qrX, $textY + 25, $serialText, $black);
    }
  }



  private function deleteDirectory($dir)
  {
    if (!file_exists($dir)) {
      return true;
    }

    if (!is_dir($dir)) {
      return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
      if ($item == '.' || $item == '..') {
        continue;
      }

      if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
        return false;
      }
    }

    return rmdir($dir);
  }

  private function generateUniqueUri()
  {
    do {
      $uri = $this->generateRandomUri();
    } while (RedirectLink::where('uri', $uri)->exists());

    return $uri;
  }

  private function generateRandomUri()
  {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = 10;
    $uri = '';

    for ($i = 0; $i < $length; $i++) {
      $uri .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $uri;
  }

  public function edit($id)
  {
    $redirectLink = RedirectLink::findOrFail($id);

    if (auth()->user()->hasRole('sales') && $redirectLink->assigned_id != auth()->id()) {
      abort(403, 'Unauthorized');
    }

    $users = User::whereDoesntHave('roles', function ($q) {
      $q->where('name', 'super_admin');
    })->get();
    $nfcs = Nfc::all();
    $salesUsers = User::role('sales')->get();

    return view('admin.redirect_links.edit', compact('redirectLink', 'users', 'nfcs', 'salesUsers'));
  }

  public function update(Request $request, $id)
  {
    $redirectLink = RedirectLink::findOrFail($id);

    if (auth()->user()->hasRole('sales') && $redirectLink->assigned_id != auth()->id()) {
      abort(403, 'Unauthorized');
    }

    if (auth()->user()->hasRole('sales') && $redirectLink->status == 2) {
      return redirect()->back()->with('error', 'Cannot update rejected links');
    }

    $statusRule = auth()->user()->hasRole('sales') ? 'required|integer|in:0,1' : 'required|integer|in:0,1,2';

    $rules = [
      'redirect_link' => 'nullable|url',
      'status' => $statusRule,
    ];

    if (!auth()->user()->hasRole('sales')) {
      $rules = array_merge($rules, [
        'user_id' => 'nullable|exists:users,id',
        'uri' => 'required|string|max:10|unique:redirect_links,uri,' . $id,
        'redirect_link_type' => 'required|integer|min:1|max:11',
        'nfcs_id' => 'required|exists:nfcs,id',
        'assigned_id' => 'nullable|exists:users,id',
        'received_status' => 'nullable|integer|in:0,1',
      ]);
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $updateData = $request->all();

    if (auth()->user()->hasRole('sales')) {
      // For sales, only allow updating redirect_link and status
      $updateData = array_intersect_key($updateData, array_flip(['redirect_link', 'status']));
    }

    $redirectLink->update($updateData);

    return redirect()->route('redirect-links.index')->with('success', __('messages.redirect_links.updated'));
  }

  public function destroy($id)
  {
    $redirectLink = RedirectLink::findOrFail($id);

    if (auth()->user()->hasRole('sales')) {
      abort(403, 'Unauthorized');
    }

    $redirectLink->delete();

    return redirect()->route('redirect-links.index')->with('success', __('messages.redirect_links.deleted'));
  }
}