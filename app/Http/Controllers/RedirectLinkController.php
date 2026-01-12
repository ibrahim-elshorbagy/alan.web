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

    // Create PDF with TCPDF
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

      // Generate PNG QR code with colors
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
        $qrCodePath = $tempDirectory . '/' . $link->uri . '.png';
        if (file_exists($qrCodePath)) {
          $zip->addFile($qrCodePath, 'qr_codes/' . basename($qrCodePath));
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
