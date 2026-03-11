<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\RedirectLink;
use App\Models\User;
use App\Models\Nfc;
use App\Models\Role;
use App\Models\MultiTenant;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RedirectLinksExport;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\QrcodeEdit;
use Spatie\Color\Hex;
use Carbon\Carbon;
use TCPDF;
use App\Services\SmsService;

class RedirectLinkController extends Controller
{
  public function index()
  {
    return view('admin.redirect_links.index');
  }

  public function historyReport()
  {
    return view('redirect_links.history_report');
  }

  public function salesReport()
  {
    return view('redirect_links.sales_report');
  }

  public function create()
  {
    $nfcs = Nfc::all();
    // Include both sales and super_admin roles as assignable users
    $salesUsers = User::whereHas('roles', function ($q) {
      $q->whereIn('name', ['sales', 'super_admin']);
    })->get();

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

    // Get NFC price
    $nfc = Nfc::find($nfcsId);
    $nfcPrice = $nfc->price;
    $nfcSalesPrice = $nfc->sales_price;

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
        'price' => $nfcPrice,
        'sales_price' => $nfcSalesPrice,
      ]);

      // Log creation history
      $redirectLink->logHistory(
        'created',
        null,
        'Created',
        auth()->id(),
        __('messages.redirect_links.history.created', ['uri' => $uri])
      );

      // Log assignment if assigned
      if ($request->assigned_id) {
        $assignedUser = User::find($request->assigned_id);
        $redirectLink->logHistory(
          'assigned_id_changed',
          null,
          $assignedUser->first_name . ' ' . $assignedUser->last_name,
          auth()->id(),
          __('messages.redirect_links.history.assigned_to', ['name' => $assignedUser->first_name . ' ' . $assignedUser->last_name])
        );
      }

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

    // Get the actual user ID (considering impersonation)
    $actualUserId = auth()->user()->isImpersonated()
      ? app('impersonate')->getImpersonatorId()
      : auth()->id();

    $redirectLinks = RedirectLink::where('assigned_id', auth()->id())
      ->where('received_status', RedirectLink::RECEIVED_STATUS_NOT_RECEIVED)
      ->get();

    $updated = 0;
    foreach ($redirectLinks as $redirectLink) {
      $redirectLink->update([
        'received_status' => RedirectLink::RECEIVED_STATUS_RECEIVED,
      ]);

      // Log received status change
      $redirectLink->logHistory(
        'received_status_changed',
        __('messages.redirect_links.not_received'),
        __('messages.redirect_links.received'),
        $actualUserId,
        __('messages.redirect_links.history.received_status_changed', [
          'old' => __('messages.redirect_links.not_received'),
          'new' => __('messages.redirect_links.received')
        ])
      );

      $updated++;
    }

    if ($updated > 0) {
      session()->flash('success', __('messages.redirect_links.received_all') . ' (' . $updated . ' links)');
    } else {
      session()->flash('info', __('messages.redirect_links.no_items_found'));
    }

    return redirect()->back();
  }

  public function markSelectedAsReceived(Request $request)
  {
    $ids = $request->input('ids');

    if (!$ids) {
      return redirect()->back()->with('error', __('messages.redirect_links.no_items_selected'));
    }

    $idsArray = explode(',', $ids);

    $query = RedirectLink::whereIn('id', $idsArray)
      ->where('received_status', RedirectLink::RECEIVED_STATUS_NOT_RECEIVED);

    // For sales, filter to only their assigned links
    if (auth()->user()->hasRole('sales')) {
      $query->where('assigned_id', auth()->id());
    }

    // Get the actual user ID (considering impersonation)
    $actualUserId = auth()->user()->isImpersonated()
      ? app('impersonate')->getImpersonatorId()
      : auth()->id();

    $redirectLinks = $query->get();
    $updated = 0;

    foreach ($redirectLinks as $redirectLink) {
      $redirectLink->update([
        'received_status' => RedirectLink::RECEIVED_STATUS_RECEIVED,
      ]);

      // Log received status change
      $redirectLink->logHistory(
        'received_status_changed',
        __('messages.redirect_links.not_received'),
        __('messages.redirect_links.received'),
        $actualUserId,
        __('messages.redirect_links.history.received_status_changed', [
          'old' => __('messages.redirect_links.not_received'),
          'new' => __('messages.redirect_links.received')
        ])
      );

      $updated++;
    }

    if ($updated > 0) {
      session()->flash('success', __('messages.redirect_links.marked_as_received') . ' (' . $updated . ' links)');
    } else {
      session()->flash('info', __('messages.redirect_links.no_items_to_mark'));
    }

    return redirect()->back();
  }

  public function restoreSelected(Request $request)
  {
    // Only super admin can restore
    if (!auth()->user()->hasRole('super_admin')) {
      return redirect()->back()->with('error', 'Unauthorized');
    }

    $ids = $request->input('ids');

    if (!$ids) {
      return redirect()->back()->with('error', __('messages.redirect_links.no_items_selected'));
    }

    $idsArray = explode(',', $ids);

    // Only restore redirect links that are NOT connected to user_id
    $updated = RedirectLink::whereIn('id', $idsArray)
      ->whereNull('user_id') // Only links not connected to users
      ->update([
        'assigned_id' => null,
        'received_status' => RedirectLink::RECEIVED_STATUS_NOT_RECEIVED
      ]);

    if ($updated > 0) {
      session()->flash('success', __('messages.redirect_links.restored_successfully') . ' (' . $updated . ' links)');
    } else {
      session()->flash('info', __('messages.redirect_links.no_items_to_restore'));
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

    // Convert array to collection if needed
    if (is_array($redirectLinks)) {
      $redirectLinks = collect($redirectLinks);
    }

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

    // Group links by NFC card
    $groupedLinks = $redirectLinks->groupBy('nfcs_id');

    // Create PDF with TCPDF - Always use A4 format
    $pageFormat = 'A4'; // Always A4
    $pdf = new TCPDF('P', 'mm', $pageFormat, true, 'UTF-8', false);
    $pdf->SetCreator('NFC System');
    $pdf->SetAuthor('NFC System');
    $pdf->SetTitle('QR Codes');
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetAutoPageBreak(false);

    // A4 dimensions: 210mm x 297mm
    $a4Width = 210;
    $a4Height = 297;

    // Process each NFC group separately
    foreach ($groupedLinks as $nfcId => $links) {
      $nfc = $links->first()->nfc;
      $useCustomPosition = $nfc && $nfc->apply_coordinates;

      // Get print settings from NFC
      $printFormat = $nfc->print_format ?? 'fixed';
      $printFrontImage = $nfc->print_front_image ?? true;
      $printBackImage = $nfc->print_back_image ?? true;
      $printOnlyQr = $nfc->print_only_qr ?? false;
      $textFontSize = $nfc->text_font_size ?? 14;

      // A4 dimensions: 210mm x 297mm
      $a4Width = 210;
      $a4Height = 297;

      // A5 dimensions: Upper half of A4 page (210mm x 148.5mm)
      $a5Width = 210;
      $a5Height = 148.5;

      if ($printFormat === 'a5') {
        // A5 Format handling - fills the full page with larger images
        // For A5, images are sized to take half the page each

        if ($printFrontImage && $printBackImage) {
          // Front and back on same page - one card per page, each takes half the upper half
          foreach ($links as $link) {
            $fullUrl = url('/auto-' . $link->uri);

            if ($useCustomPosition) {
              $images = $this->generateBothImagesWithQR(
                $link,
                $fullUrl,
                $nfc,
                $qrcodeColor,
                $customQrCode,
                $tempDirectory,
                $printFrontImage,
                $printBackImage,
                $printOnlyQr
              );

              $excelData[] = [
                'id' => $link->id,
                'uri' => $link->uri,
                'full_link' => $fullUrl,
              ];

              $pdf->AddPage();

              // Each image takes half the page height
              $imageWidth = $a5Width;  // Full width: 210mm
              $imageHeight = $a5Height;  // Half height: 148.5mm

              // Front image takes upper half
              $pdf->Image($images['front'], 0, 0, $imageWidth, $imageHeight, 'PNG');

              // Back image takes lower half
              $pdf->Image($images['back'], 0, $a5Height, $imageWidth, $imageHeight, 'PNG');
            }
          }
        } elseif ($printFrontImage) {
          // Only front images - 2 images per page in upper half of A4
          $linkIndex = 0;
          $totalLinks = count($links);

          while ($linkIndex < $totalLinks) {
            $pdf->AddPage();

            $imageWidth = $a5Width;  // Full width: 210mm
            $imageHeight = $a5Height;  // Half height: 148.5mm

            // First card takes upper half
            if ($linkIndex < $totalLinks) {
              $link = $links[$linkIndex];
              $fullUrl = url('/auto-' . $link->uri);

              if ($useCustomPosition) {
                $images = $this->generateBothImagesWithQR(
                  $link,
                  $fullUrl,
                  $nfc,
                  $qrcodeColor,
                  $customQrCode,
                  $tempDirectory,
                  true,
                  false,
                  false
                );

                $excelData[] = [
                  'id' => $link->id,
                  'uri' => $link->uri,
                  'full_link' => $fullUrl,
                ];

                $pdf->Image($images['front'], 0, 0, $imageWidth, $imageHeight, 'PNG');
              }
              $linkIndex++;
            }

            // Second card takes lower half
            if ($linkIndex < $totalLinks) {
              $link = $links[$linkIndex];
              $fullUrl = url('/auto-' . $link->uri);

              if ($useCustomPosition) {
                $images = $this->generateBothImagesWithQR(
                  $link,
                  $fullUrl,
                  $nfc,
                  $qrcodeColor,
                  $customQrCode,
                  $tempDirectory,
                  true,
                  false,
                  false
                );

                $excelData[] = [
                  'id' => $link->id,
                  'uri' => $link->uri,
                  'full_link' => $fullUrl,
                ];

                $pdf->Image($images['front'], 0, $a5Height, $imageWidth, $imageHeight, 'PNG');
              }
              $linkIndex++;
            }
          }
        } elseif ($printBackImage) {
          // Only back images - 2 images per page in upper half of A4
          $linkIndex = 0;
          $totalLinks = count($links);

          while ($linkIndex < $totalLinks) {
            $pdf->AddPage();

            $imageWidth = $a5Width;  // Full width: 210mm
            $imageHeight = $a5Height;  // Half height: 148.5mm

            // First card takes upper half
            if ($linkIndex < $totalLinks) {
              $link = $links[$linkIndex];
              $fullUrl = url('/auto-' . $link->uri);

              if ($useCustomPosition) {
                $images = $this->generateBothImagesWithQR(
                  $link,
                  $fullUrl,
                  $nfc,
                  $qrcodeColor,
                  $customQrCode,
                  $tempDirectory,
                  false,
                  true,
                  false
                );

                $excelData[] = [
                  'id' => $link->id,
                  'uri' => $link->uri,
                  'full_link' => $fullUrl,
                ];

                $pdf->Image($images['back'], 0, 0, $imageWidth, $imageHeight, 'PNG');
              }
              $linkIndex++;
            }

            // Second card takes lower half
            if ($linkIndex < $totalLinks) {
              $link = $links[$linkIndex];
              $fullUrl = url('/auto-' . $link->uri);

              if ($useCustomPosition) {
                $images = $this->generateBothImagesWithQR(
                  $link,
                  $fullUrl,
                  $nfc,
                  $qrcodeColor,
                  $customQrCode,
                  $tempDirectory,
                  false,
                  true,
                  false,
                );

                $excelData[] = [
                  'id' => $link->id,
                  'uri' => $link->uri,
                  'full_link' => $fullUrl,
                ];

                $pdf->Image($images['back'], 0, $a5Height, $imageWidth, $imageHeight, 'PNG');
              }
              $linkIndex++;
            }
          }
        }
      } else {
        // Fixed Width/Height Format (original behavior)
        foreach ($links as $link) {
          $fullUrl = url('/auto-' . $link->uri);

          if ($useCustomPosition) {
            // Generate both front and back images with QR on selected side
            $images = $this->generateBothImagesWithQR(
              $link,
              $fullUrl,
              $nfc,
              $qrcodeColor,
              $customQrCode,
              $tempDirectory,
              $printFrontImage,
              $printBackImage,
              $printOnlyQr
            );

            $excelData[] = [
              'id' => $link->id,
              'uri' => $link->uri,
              'full_link' => $fullUrl,
            ];

            $pdf->AddPage();

            // Use exact dimensions from NFC settings (in mm)
            $imageWidthMm = $nfc->image_width ?? 85;
            $imageHeightMm = $nfc->image_height ?? 54;

            // Position based on print options
            $x = (210 - $imageWidthMm) / 2;

            if ($printFrontImage && $printBackImage) {
              // Both images vertically
              $frontY = 20;
              $backY = $frontY + $imageHeightMm + 10;

              $pdf->Image($images['front'], $x, $frontY, $imageWidthMm, $imageHeightMm, 'PNG');
              $pdf->Image($images['back'], $x, $backY, $imageWidthMm, $imageHeightMm, 'PNG');
            } elseif ($printFrontImage) {
              // Only front
              $y = (297 - $imageHeightMm) / 2;
              $pdf->Image($images['front'], $x, $y, $imageWidthMm, $imageHeightMm, 'PNG');
            } elseif ($printBackImage) {
              // Only back
              $y = (297 - $imageHeightMm) / 2;
              $pdf->Image($images['back'], $x, $y, $imageWidthMm, $imageHeightMm, 'PNG');
            }
          } else {
            // Use default behavior - generate QR code with text overlays
            $qrSize = 400;
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
            $qrPath = $tempDirectory . '/' . $link->uri . '_qr_temp.png';
            file_put_contents($qrPath, $qrImage);
            $qrImageGd = imagecreatefrompng($qrPath);

            // Get QR dimensions
            $qrWidth = imagesx($qrImageGd);
            $qrHeight = imagesy($qrImageGd);

            // Set QR position variables for consistency
            $qrY = 0;
            $qrSize = $qrHeight;

            // Create a larger canvas to accommodate QR code and text
            $canvasWidth = max($qrWidth, 400);
            $canvasHeight = $qrHeight + 120; // Extra space for text

            $canvas = imagecreatetruecolor($canvasWidth, $canvasHeight);
            $white = imagecolorallocate($canvas, 255, 255, 255);
            imagefill($canvas, 0, 0, $white);

            // Copy QR code to canvas (centered)
            $qrXPos = ($canvasWidth - $qrWidth) / 2;
            imagecopy($canvas, $qrImageGd, $qrXPos, 0, 0, 0, $qrWidth, $qrHeight);

            // Add text overlays with dynamic spacing
            $black = imagecolorallocate($canvas, 0, 0, 0);
            $fontPath = public_path('fonts/Zain-Regular.ttf');
            $fontSize = intval($nfc->text_font_size ?? 14);

            // Text content
            $urlText = 'Code : ' . $link->uri;
            $serialText = 'Serial No : ' . str_pad($link->id, 4, '0', STR_PAD_LEFT);

            // Calculate dynamic spacing based on font size and QR size to avoid collisions.
            $baseGap = intval(round($fontSize * 0.8)); // 14->11, 16->13
            $extra = intval(round($qrSize * 0.02)); // small adjustment relative to QR size
            $firstLineY = $qrY + $qrSize + $baseGap + $extra;
            $lineSpacing = intval(round($fontSize * 1.2)); // 14->17, 16->19
            $secondLineY = $firstLineY + $lineSpacing;

            if (file_exists($fontPath)) {
              imagettftext($canvas, $fontSize, 0, $qrXPos, $firstLineY + 2, $black, $fontPath, $urlText);
              imagettftext($canvas, $fontSize, 0, $qrXPos, $secondLineY + 2, $black, $fontPath, $serialText);
            } else {
              $fallbackFont = 3;
              $adjust = intval(round($fontSize * 0.35));
              imagestring($canvas, $fallbackFont, $qrXPos, max(0, $firstLineY - $adjust), $urlText, $black);
              imagestring($canvas, $fallbackFont, $qrXPos, max(0, $secondLineY - $adjust), $serialText, $black);
            }

            // Save the combined image
            $pngPath = $tempDirectory . '/' . $link->uri . '.png';
            imagepng($canvas, $pngPath);
            imagedestroy($canvas);
            imagedestroy($qrImageGd);

            $excelData[] = [
              'id' => $link->id,
              'uri' => $link->uri,
              'full_link' => $fullUrl,
            ];

            // Add page to PDF
            $pdf->AddPage();

            // Add combined QR+text image (centered)
            $imageWidthMm = 100;
            $imageHeightMm = ($canvasHeight / $canvasWidth) * $imageWidthMm;
            $x = (210 - $imageWidthMm) / 2;
            $y = (297 - $imageHeightMm) / 2;
            $pdf->Image($pngPath, $x, $y, $imageWidthMm, $imageHeightMm, 'PNG');
          }
        }
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
        $nfc = $link->nfc;
        $useCustomPosition = $nfc && $nfc->apply_coordinates;

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

  private function generateBothImagesWithQR($link, $fullUrl, $nfc, $qrcodeColor, $customQrCode, $tempDirectory, $printFrontImage = true, $printBackImage = true, $printOnlyQr = false)
  {
    $generatedImages = [];

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

    if ($printOnlyQr) {
      // Create a larger canvas to accommodate QR code and text
      $canvasWidth = max($qrWidth, 300);
      $canvasHeight = $qrHeight + 100; // Extra space for text

      $canvas = imagecreatetruecolor($canvasWidth, $canvasHeight);
      $white = imagecolorallocate($canvas, 255, 255, 255);
      imagefill($canvas, 0, 0, $white);

      // Copy QR code to canvas
      $qrXPos = ($canvasWidth - $qrWidth) / 2; // Center horizontally
      imagecopy($canvas, $qrImageGd, $qrXPos, 0, 0, 0, $qrWidth, $qrHeight);

      // Add text overlays
      $this->addTextOverlays($canvas, $link->uri, $link->id, $qrXPos, 0, $qrSize, $nfc);

      // Save the combined image
      $qrWithTextPath = $tempDirectory . '/' . $link->uri . '_qr_with_text.png';
      imagepng($canvas, $qrWithTextPath);
      imagedestroy($canvas);

      $generatedImages['qr'] = $qrWithTextPath;
    } else {
      // Process Front Image
      if ($printFrontImage) {
        $frontImageUrl = $nfc->nfc_image;
        $frontImageContent = file_get_contents($frontImageUrl);
        $frontImage = imagecreatefromstring($frontImageContent);

        if ($qrSide === 'front' && $nfc->apply_coordinates) {
          // Add QR code to front
          imagecopy($frontImage, $qrImageGd, $xPos, $yPos, 0, 0, $qrWidth, $qrHeight);
        }

        // Always add text overlays to front
        if ($qrSide === 'front' && $nfc->apply_coordinates) {
          $this->addTextOverlays($frontImage, $link->uri, $link->id, $xPos, $yPos, $qrSize, $nfc);
        }

        // Save front image
        $frontPath = $tempDirectory . '/' . $link->uri . '_front.png';
        imagepng($frontImage, $frontPath);
        $generatedImages['front'] = $frontPath;
        imagedestroy($frontImage);
      }

      // Process Back Image
      if ($printBackImage) {
        $backImageUrl = $nfc->nfc_back_image;
        $backImageContent = file_get_contents($backImageUrl);
        $backImage = imagecreatefromstring($backImageContent);

        if ($qrSide === 'back' && $nfc->apply_coordinates) {
          // Add QR code to back
          imagecopy($backImage, $qrImageGd, $xPos, $yPos, 0, 0, $qrWidth, $qrHeight);
        }

        if ($qrSide === 'back' && $nfc->apply_coordinates) {
          // Always add text overlays to back
          $this->addTextOverlays($backImage, $link->uri, $link->id, $xPos, $yPos, $qrSize, $nfc);
        }

        // Save back image
        $backPath = $tempDirectory . '/' . $link->uri . '_back.png';
        imagepng($backImage, $backPath);
        $generatedImages['back'] = $backPath;
        imagedestroy($backImage);
      }
    }

    // Clean up QR image
    imagedestroy($qrImageGd);

    return $generatedImages;
  }

  private function addTextOverlays($image, $uri, $linkId, $qrX, $qrY, $qrSize, $nfc)
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
    $urlText = 'Code : ' . $uri;
    $serialText = 'Serial No : ' . str_pad($linkId, 4, '0', STR_PAD_LEFT);

    // Calculate dynamic spacing based on font size and QR size to avoid collisions.
    $fontSize = intval($nfc->text_font_size ?? 14);
    $baseGap = intval(round($fontSize * 0.8)); // 14->11, 16->13
    $extra = intval(round($qrSize * 0.02)); // small adjustment relative to QR size
    $firstLineY = $qrY + $qrSize + $baseGap + $extra;
    $lineSpacing = intval(round($fontSize * 1.2)); // 14->17, 16->19
    $secondLineY = $firstLineY + $lineSpacing;

    if ($fontPath) {
      // Use TrueType rendering; imagettftext expects the y coordinate as baseline
      imagettftext($image, $fontSize, 0, $qrX, $firstLineY + 2, $black, $fontPath, $urlText);
      imagettftext($image, $fontSize, 0, $qrX, $secondLineY + 2, $black, $fontPath, $serialText);
    } else {
      // Fallback to built-in font. imagestring uses pixel coordinates for y as top of text,
      // so adjust slightly to align visually with the TrueType baseline.
      $fallbackFont = 3; // medium built-in font
      $adjust = intval(round($fontSize * 0.35));
      imagestring($image, $fallbackFont, $qrX, max(0, $firstLineY - $adjust), $urlText, $black);
      imagestring($image, $fallbackFont, $qrX, max(0, $secondLineY - $adjust), $serialText, $black);
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
    $characters = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
    $length = 10;
    $uri = '';

    for ($i = 0; $i < $length; $i++) {
      $uri .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $uri;
  }

  public function edit($id)
  {
    $redirectLink = RedirectLink::with(['histories.changedBy'])->findOrFail($id);

    if (auth()->user()->hasRole('sales') && $redirectLink->assigned_id != auth()->id()) {
      abort(403, 'Unauthorized');
    }

    $users = User::whereDoesntHave('roles', function ($q) {
      $q->where('name', 'super_admin');
    })->get();
    $nfcs = Nfc::all();
    // Include both sales and super_admin roles as assignable users
    $salesUsers = User::whereHas('roles', function ($q) {
      $q->whereIn('name', ['sales', 'super_admin']);
    })->get();

    // Get the latest acknowledgment for this redirect link
    $latestAcknowledgment = \App\Models\RedirectLinkAcknowledgment::whereJsonContains('redirect_link_ids', $id)
      ->orderBy('created_at', 'desc')
      ->first();

    // Load ad setting for this redirect link (for super_admin view)
    $adSetting = \App\Models\SalesAdvertiseSetting::where('redirect_link_id', $id)->first();

    return view('admin.redirect_links.edit', compact('redirectLink', 'users', 'nfcs', 'salesUsers', 'latestAcknowledgment', 'adSetting'));
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
      'note' => 'nullable|string|max:5000',
    ];

    // Allow sales to update assigned_id and user_id
    if (auth()->user()->hasRole('sales')) {
      $rules['assigned_id'] = 'nullable|exists:users,id';
      $rules['user_id'] = 'nullable|exists:users,id';
    }

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

    // Add price fields validation for super admin only
    if (auth()->user()->hasRole('super_admin')) {
      $rules = array_merge($rules, [
        'price' => 'nullable|numeric|min:0',
        'sales_price' => 'nullable|numeric|min:0',
      ]);
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $updateData = $request->all();

    // Get the actual user ID (considering impersonation)
    $actualUserId = auth()->user()->isImpersonated()
      ? app('impersonate')->getImpersonatorId()
      : auth()->id();

    // Track changes for history
    $changes = [];

    // Track status changes
    if (isset($updateData['status']) && $redirectLink->status != $updateData['status']) {
      $statusLabels = [
        0 => __('messages.redirect_links.not_redeemed'),
        1 => __('messages.redirect_links.redeemed'),
        2 => __('messages.redirect_links.rejected')
      ];

      $changes['status'] = [
        'old' => $statusLabels[$redirectLink->status],
        'new' => $statusLabels[$updateData['status']]
      ];
    }

    // Track received_status changes
    if (isset($updateData['received_status']) && $redirectLink->received_status != $updateData['received_status']) {
      $receivedStatusLabels = [
        0 => __('messages.redirect_links.not_received'),
        1 => __('messages.redirect_links.received')
      ];

      $changes['received_status'] = [
        'old' => $receivedStatusLabels[$redirectLink->received_status],
        'new' => $receivedStatusLabels[$updateData['received_status']]
      ];
    }

    // Track assigned_id changes
    if (isset($updateData['assigned_id']) && $redirectLink->assigned_id != $updateData['assigned_id']) {
      $oldAssigned = $redirectLink->assigned_id ? $redirectLink->assignedUser->first_name . ' ' . $redirectLink->assignedUser->last_name : __('messages.redirect_links.history.none');
      $newAssigned = $updateData['assigned_id'] ? User::find($updateData['assigned_id'])->first_name . ' ' . User::find($updateData['assigned_id'])->last_name : __('messages.redirect_links.history.none');

      $changes['assigned_id'] = [
        'old' => $oldAssigned,
        'new' => $newAssigned
      ];
    }

    // Track user_id changes
    if (isset($updateData['user_id']) && $redirectLink->user_id != $updateData['user_id']) {
      $oldUser = $redirectLink->user_id ? $redirectLink->user->first_name . ' ' . $redirectLink->user->last_name : __('messages.redirect_links.history.none');
      $newUser = $updateData['user_id'] ? User::find($updateData['user_id'])->first_name . ' ' . User::find($updateData['user_id'])->last_name : __('messages.redirect_links.history.none');

      $changes['user_id'] = [
        'old' => $oldUser,
        'new' => $newUser
      ];
    }

    // Track redirect_link changes
    if (isset($updateData['redirect_link']) && $redirectLink->redirect_link != $updateData['redirect_link']) {
      $changes['redirect_link'] = [
        'old' => $redirectLink->redirect_link ?? __('messages.redirect_links.history.none'),
        'new' => $updateData['redirect_link'] ?? __('messages.redirect_links.history.none')
      ];
    }

    // Track note changes
    if (array_key_exists('note', $updateData) && $redirectLink->note !== $updateData['note']) {
      $changes['note'] = [
        'old' => $redirectLink->note ?? '',
        'new' => $updateData['note'] ?? ''
      ];
    }

    // Handle assignment changes - reset received_status if sales is reassigning
    if (isset($updateData['assigned_id']) && $redirectLink->assigned_id != $updateData['assigned_id']) {
      if (auth()->user()->hasRole('sales')) {
        $updateData['received_status'] = RedirectLink::RECEIVED_STATUS_NOT_RECEIVED;

        // Track received_status reset if it was previously received
        if ($redirectLink->received_status == RedirectLink::RECEIVED_STATUS_RECEIVED) {
          $changes['received_status'] = [
            'old' => __('messages.redirect_links.received'),
            'new' => __('messages.redirect_links.not_received')
          ];
        }
      }
    }

    if (auth()->user()->hasRole('sales')) {
      // For sales, allow updating redirect_link, status, assigned_id, received_status, and user_id (from quick user creation)
      $allowedFields = ['redirect_link', 'status', 'assigned_id', 'received_status', 'user_id', 'note'];
      $updateData = array_intersect_key($updateData, array_flip($allowedFields));
    } else if (auth()->user()->hasRole('super_admin')) {
      // For super admin, allow all fields including price and sales_price
      $allowedFields = ['user_id', 'uri', 'redirect_link_type', 'nfcs_id', 'redirect_link', 'status', 'assigned_id', 'received_status', 'price', 'sales_price', 'note'];
      $updateData = array_intersect_key($updateData, array_flip($allowedFields));
    } else {
      // For other admins, allow all except price fields
      $allowedFields = ['user_id', 'uri', 'redirect_link_type', 'nfcs_id', 'redirect_link', 'status', 'assigned_id', 'received_status', 'note'];
      $updateData = array_intersect_key($updateData, array_flip($allowedFields));
    }

    $redirectLink->update($updateData);

    // Log all changes to history
    foreach ($changes as $field => $change) {
      $action = $field . '_changed';
      $redirectLink->logHistory(
        $action,
        $change['old'],
        $change['new'],
        $actualUserId,
        __('messages.redirect_links.history.' . $action, ['old' => $change['old'], 'new' => $change['new']])
      );
    }

    // Handle ad settings update - now on separate page

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

  /**
   * Create a quick user via AJAX from the redirect link edit form.
   * Available for super_admin and sales roles.
   */
  public function createQuickUser(Request $request): JsonResponse
  {
    $validator = Validator::make($request->all(), [
      'first_name' => 'required|string|max:180',
      'last_name' => 'required|string|max:180',
      'contact' => 'required|string|unique:users,contact',
    ], [
      'contact.unique' => __('messages.redirect_links.quick_user.phone_already_exists'),
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => $validator->errors()->first(),
        'errors' => $validator->errors(),
      ], 422);
    }

    try {
      DB::beginTransaction();

      $tenant = MultiTenant::create(['tenant_username' => $request->first_name]);
      $userDefaultLanguage = Setting::where('key', 'user_default_language')->first()->value ?? 'en';

      // Generate a random password
      $rawPassword = substr(str_shuffle('abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 8);

      // Get the actual user ID (considering impersonation)
      $actualUserId = auth()->user()->isImpersonated()
        ? app('impersonate')->getImpersonatorId()
        : auth()->id();

      $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => null,
        'region_code' => 'JO',
        'contact' => $request->contact,
        'language' => $userDefaultLanguage,
        'steps' => 0,
        'email_verified_at' => Carbon::now(), // Mark as verified immediately
        'password' => Hash::make($rawPassword),
        'tenant_id' => $tenant->id,
        'affiliate_code' => generateUniqueAffiliateCode(),
        'created_by' => $actualUserId,
      ])->assignRole(Role::ROLE_ADMIN);

      // Assign default plan (same as normal registration)
      $plan = Plan::whereIsDefault(true)->first();
      $customFields = $plan->planCustomFields;
      if ($plan->custom_select == 1 && $customFields->isNotEmpty()) {
        $vcardsOfNo = $customFields->first()->custom_vcard_number;
      } else {
        $vcardsOfNo = $plan->no_of_vcards;
      }
      Subscription::create([
        'plan_id' => $plan->id,
        'plan_amount' => $plan->price,
        'plan_frequency' => $plan->frequency,
        'starts_at' => Carbon::now(),
        'ends_at' => Carbon::now()->addDays($plan->trial_days),
        'trial_ends_at' => Carbon::now()->addDays($plan->trial_days),
        'status' => Subscription::ACTIVE,
        'tenant_id' => $tenant->id,
        'no_of_vcards' => $vcardsOfNo,
      ]);

      DB::commit();

      // Send SMS with login credentials
      try {
        $normalizedPhone = normalizePhoneNumber($user->contact);
        $loginUrl = config('app.url') . '/login';
        $fullName = $user->first_name . ' ' . $user->last_name;
        $smsMessage = 'عزيزي، ' . $fullName . "\n\n" .
          'يمكنك الدخول للوحة التحكم عبر الرابط' . "\n\n" .
          $loginUrl . "\n\n" .
          'اسم الدخول ' . $user->contact . "\n\n" .
          'الباسوورد ' . $rawPassword;
        $smsService = new SmsService();
        $smsService->sendSms($normalizedPhone, $smsMessage);
      } catch (\Exception $smsException) {
        Log::warning('SMS sending failed for quick user', [
          'user_id' => $user->id,
          'error'   => $smsException->getMessage(),
        ]);
      }

      return response()->json([
        'success' => true,
        'message' => __('messages.redirect_links.quick_user.created_successfully'),
        'user' => [
          'id' => $user->id,
          'full_name' => $user->first_name . ' ' . $user->last_name,
          'contact' => $user->contact,
          'password' => $rawPassword,
        ],
      ]);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Quick user creation error', ['error' => $e->getMessage()]);

      return response()->json([
        'success' => false,
        'message' => __('messages.redirect_links.quick_user.creation_failed'),
      ], 500);
    }
  }
}
