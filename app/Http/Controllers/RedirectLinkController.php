<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RedirectLink;
use App\Models\User;
use App\Models\Nfc;
use Illuminate\Support\Facades\Validator;
use LaravelQRCode\Facades\QRCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RedirectLinksExport;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

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
      'redirect_link_type' => 'required|integer|min:1|max:9',
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
      $redeemCode = $this->generateUniqueRedeemCode();
      $uri = $this->generateUniqueUri();

      $redirectLink = RedirectLink::create([
        'user_id' => null,
        'redeem_code' => $redeemCode,
        'uri' => $uri,
        'redirect_link' => null,
        'redirect_link_type' => $redirectLinkType,
        'status' => 0,
        'nfcs_id' => $nfcsId,
      ]);

      $createdLinks[] = $redirectLink;
    }

    // Store success message in session BEFORE download
    session()->flash('success', __('messages.redirect_links.created'));

    // Generate all downloads
    return $this->generatePackage($createdLinks);
  }


  public function extractAll()
  {
    // Get all redirect links
    $redirectLinks = RedirectLink::all();

    if ($redirectLinks->isEmpty()) {
      return redirect()->back()->with('error', 'No redirect links found to extract');
    }

    // Generate package for all links
    return $this->generatePackage($redirectLinks);
  }

  public function exportSelected(Request $request)
  {
    $ids = $request->input('ids');

    if (!$ids) {
      return redirect()->back()->with('error', __('messages.redirect_links.no_items_selected'));
    }

    // Convert comma-separated string to array
    $idsArray = explode(',', $ids);

    // Get selected redirect links
    $redirectLinks = RedirectLink::whereIn('id', $idsArray)->get();

    if ($redirectLinks->isEmpty()) {
      return redirect()->back()->with('error', __('messages.redirect_links.no_items_found'));
    }

    // Generate package for selected links
    return $this->generatePackage($redirectLinks);
  }

  private function generatePackage($redirectLinks)
  {
    $timestamp = time();
    $tempDirectory = storage_path('app/temp_redirect_qr/' . $timestamp);

    // Create directory if it doesn't exist
    if (!is_dir($tempDirectory)) {
      File::makeDirectory($tempDirectory, 0777, true);
    }

    $excelData = [];
    $qrCodes = [];

    // Generate QR codes
    foreach ($redirectLinks as $link) {
      // Generate full URL
      $fullUrl = url('/auto-' . $link->uri);

      // Generate QR code with redeem code as filename
      $qrCodePath = $tempDirectory . '/' . $link->redeem_code . '.png';
      QRCode::url($fullUrl)
        ->setSize(10)
        ->setMargin(2)
        ->setOutfile($qrCodePath)
        ->png();

      // Prepare data for Excel
      $excelData[] = [
        'id' => $link->id,
        'redeem_code' => $link->redeem_code,
        'full_link' => $fullUrl,
      ];

      // Store QR code info for PDF
      $qrCodes[] = [
        'id' => $link->id,
        'redeem_code' => $link->redeem_code,
        'full_link' => $fullUrl,
        'qr_path' => $qrCodePath,
      ];
    }

    // 1. Generate Excel file
    $excelFileName = 'redirect_links_data.xlsx';
    $excelPath = $tempDirectory . '/' . $excelFileName;

    $excelContent = Excel::raw(new RedirectLinksExport($excelData), \Maatwebsite\Excel\Excel::XLSX);
    file_put_contents($excelPath, $excelContent);

    // 2. Generate PDF with only QR codes and redeem codes
    $pdfFileName = 'redirect_links_qr_codes.pdf';
    $pdfPath = $tempDirectory . '/' . $pdfFileName;

    $pdf = Pdf::loadView('pdf.redirect_qr_codes', ['qrCodes' => $qrCodes]);
    $pdf->setPaper('a4', 'portrait');
    $pdf->save($pdfPath);

    // 3. Create main ZIP file with QR images, Excel, and PDF
    $zipFileName = 'redirect_links_' . $timestamp . '.zip';
    $zipPath = $tempDirectory . '/' . $zipFileName;

    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
      // Add QR code images folder
      foreach ($redirectLinks as $link) {
        $qrCodePath = $tempDirectory . '/' . $link->redeem_code . '.png';
        if (file_exists($qrCodePath)) {
          $zip->addFile($qrCodePath, 'qr_codes/' . basename($qrCodePath));
        }
      }

      // Add Excel file
      if (file_exists($excelPath)) {
        $zip->addFile($excelPath, $excelFileName);
      }

      // Add PDF
      if (file_exists($pdfPath)) {
        $zip->addFile($pdfPath, $pdfFileName);
      }

      $zip->close();
    }

    // Check if ZIP was created successfully
    if (!file_exists($zipPath)) {
      $this->deleteDirectory($tempDirectory);
      return redirect()->back()->with('error', 'Failed to create ZIP file');
    }

    // Read ZIP file content
    $zipContent = file_get_contents($zipPath);

    // Delete the entire temp directory immediately
    $this->deleteDirectory($tempDirectory);

    // Return the ZIP as a download response
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

  private function generateUniqueRedeemCode()
  {
    do {
      $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 16));
    } while (RedirectLink::where('redeem_code', $code)->exists());

    return $code;
  }

  private function generateUniqueUri()
  {
    $lastUri = RedirectLink::where('uri', 'regexp', '^[a-z]{6}$')->orderBy('uri', 'desc')->value('uri');

    if (!$lastUri) {
      $uri = 'aaaaaa';
    } else {
      $uri = $this->incrementString($lastUri);
    }

    while (RedirectLink::where('uri', $uri)->exists()) {
      $uri = $this->incrementString($uri);
    }

    return $uri;
  }

  private function incrementString($string)
  {
    $length = strlen($string);
    for ($i = $length - 1; $i >= 0; $i--) {
      if ($string[$i] < 'z') {
        $string[$i] = chr(ord($string[$i]) + 1);
        return $string;
      } else {
        $string[$i] = 'a';
      }
    }
    return 'a' . $string;
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
      'redeem_code' => 'nullable|string|max:16',
      'uri' => 'required|string|unique:redirect_links,uri,' . $id,
      'redirect_link' => 'nullable|url',
      'redirect_link_type' => 'required|integer|min:1|max:9',
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
