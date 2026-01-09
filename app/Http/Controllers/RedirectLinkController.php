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

class RedirectLinkController extends Controller
{
  public function index()
  {
    return view('admin.redirect_links.index');
  }

  public function create()
  {
    $nfcs = Nfc::all();

    return view('admin.redirect_links.create', compact('nfcs'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'redirect_link_type' => 'required|integer|min:1|max:10',
      'nfcs_id' => 'required|exists:nfcs,id',
      'number_of_cards' => 'required|integer|min:1|max:100',
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
      ]);

      $createdLinks[] = $redirectLink;
    }

    session()->flash('success', __('messages.redirect_links.created'));

    return $this->generatePackage($createdLinks);
  }

  public function extractAll()
  {
    $redirectLinks = RedirectLink::all();

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

    if ($redirectLinks->isEmpty()) {
      return redirect()->back()->with('error', __('messages.redirect_links.no_items_found'));
    }

    return $this->generatePackage($redirectLinks);
  }

  private function generatePackage($redirectLinks)
  {
    $timestamp = time();
    $publicDirectory = public_path('temp_redirect_qr/' . $timestamp);
    $storageDirectory = storage_path('app/temp_redirect_qr/' . $timestamp);

    // Create both directories
    if (!is_dir($publicDirectory)) {
      File::makeDirectory($publicDirectory, 0777, true);
    }
    if (!is_dir($storageDirectory)) {
      File::makeDirectory($storageDirectory, 0777, true);
    }

    $excelData = [];
    $qrCodes = [];

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

      // Save to PUBLIC folder for DomPDF
      $publicPngPath = $publicDirectory . '/' . $link->uri . '.png';
      file_put_contents($publicPngPath, $qrImage);

      $excelData[] = [
        'id' => $link->id,
        'uri' => $link->uri,
        'full_link' => $fullUrl,
      ];

      $qrCodes[] = [
        'id' => $link->id,
        'uri' => $link->uri,
        'full_link' => $fullUrl,
        'qr_path' => $publicPngPath, // Use public path for DomPDF
      ];
    }

    // Generate PDF with public file paths
    $pdfFileName = 'redirect_links_qr_codes.pdf';
    $pdfPath = $storageDirectory . '/' . $pdfFileName;
    $pdf = Pdf::loadView('pdf.redirect_qr_codes', ['qrCodes' => $qrCodes]);
    $pdf->setPaper('a4', 'portrait');
    $pdf->save($pdfPath);

    // Generate Excel
    $excelFileName = 'redirect_links_data.xlsx';
    $excelPath = $storageDirectory . '/' . $excelFileName;
    $excelContent = Excel::raw(new RedirectLinksExport($excelData), \Maatwebsite\Excel\Excel::XLSX);
    file_put_contents($excelPath, $excelContent);

    // Create ZIP
    $zipFileName = 'redirect_links_' . $timestamp . '.zip';
    $zipPath = $storageDirectory . '/' . $zipFileName;

    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
      foreach ($redirectLinks as $link) {
        $qrCodePath = $publicDirectory . '/' . $link->uri . '.png';
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
      $this->deleteDirectory($publicDirectory);
      $this->deleteDirectory($storageDirectory);
      return redirect()->back()->with('error', 'Failed to create ZIP file');
    }

    $zipContent = file_get_contents($zipPath);

    // Clean up both directories
    $this->deleteDirectory($publicDirectory);
    $this->deleteDirectory($storageDirectory);

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
    $users = User::whereDoesntHave('roles', function ($q) {
      $q->where('name', 'super_admin');
    })->get();
    $nfcs = Nfc::all();

    return view('admin.redirect_links.edit', compact('redirectLink', 'users', 'nfcs'));
  }

  public function update(Request $request, $id)
  {
    $redirectLink = RedirectLink::findOrFail($id);

    $validator = Validator::make($request->all(), [
      'user_id' => 'nullable|exists:users,id',
      'uri' => 'required|string|max:10|unique:redirect_links,uri,' . $id,
      'redirect_link' => 'nullable|url',
      'redirect_link_type' => 'required|integer|min:1|max:10',
      'status' => 'required|integer|in:0,1,2',
      'nfcs_id' => 'required|exists:nfcs,id',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $redirectLink->update($request->all());

    return redirect()->route('redirect-links.index')->with('success', __('messages.redirect_links.updated'));
  }

  public function destroy($id)
  {
    $redirectLink = RedirectLink::findOrFail($id);
    $redirectLink->delete();

    return redirect()->route('redirect-links.index')->with('success', __('messages.redirect_links.deleted'));
  }
}