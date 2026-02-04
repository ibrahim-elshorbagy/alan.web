<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEnquiryRequest;
use App\Jobs\SendEmailJob;
use App\Models\Enquiry;
use App\Models\Vcard;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class EnquiryController extends AppBaseController
{
  /**
   * @throws Exception
   */
  public function index(Request $request, $id): \Illuminate\View\View
  {
    return view('enquiry.index');
  }

  public function store(CreateEnquiryRequest $request, Vcard $vcard)
  {
    $input = $request->all();
    $input['vcard_id'] = $vcard->id;
    $input['vcard_name'] = $vcard->name;
    $enquiry = Enquiry::create($input);
    Log::info('Enquiry created', ['enquiry_id' => $enquiry->id, 'input' => $input]);
    if (isset($input['attachment']) && !empty($input['attachment'])) {
      $enquiry->addMedia($input['attachment'])->toMediaCollection(Enquiry::ATTACHMENT, config('app.media_disc'));
      Log::info('Attachment added to enquiry', ['enquiry_id' => $enquiry->id]);
    }
    $enquiry->load('media');
    Log::info('Media disk', ['disk' => config('app.media_disc')]);
    if ($enquiry->media->isNotEmpty()) {
      foreach ($enquiry->media as $media) {
        Log::info('Media file', ['path' => $media->getPath(), 'exists' => file_exists($media->getPath()), 'size' => filesize($media->getPath())]);
      }
    }
    $email = empty($vcard->email) ? $vcard->user->email : $vcard->email;
    if (!empty($email)) {
      Log::info('Sending email to', ['email' => $email, 'enquiry_id' => $enquiry->id]);
      try {
        Mail::to($email)->send(new ContactUsMail($input, $email, $enquiry));
        Log::info('Email sent successfully');
      } catch (Exception $e) {
        Log::error('Email send failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
      }
    } else {
      Log::warning('No email found for vcard', ['vcard_id' => $vcard->id]);
    }

    setLocalLang(getLocalLanguage());

    return $this->sendSuccess(__('messages.placeholder.enquiry_sent'));
  }

  public function show($id): JsonResponse
  {
    $enquiry = Enquiry::with('vcard', 'media')->where('id', '=', $id)->first();
    return $this->sendResponse($enquiry, 'Testimonial successfully retrieved.');
  }

  /**
   * @return Application|Factory|View
   *
   * @throws Exception
   */
  public function enquiryList(Request $request): \Illuminate\View\View
  {
    return view('enquiry.list');
  }

  public function destroy(Enquiry $enquiry): JsonResponse
  {
    $enquiry->delete();

    return $this->sendSuccess('Enquiry deleted successfully.');
  }

  public function inquiriesAttachmentDownload($id)
  {
    try {
      $enquiry = Enquiry::findOrFail($id);

      $documentMedia = $enquiry->media[0];
      $documentPath = $documentMedia->getPath();

      if (config('app.media_disc') === 'public') {
        $documentPath = Str::after($documentMedia->getUrl(), '/uploads');
      }

      $file = Storage::disk(config('app.media_disc'))->get($documentPath);

      $headers = [
        'Content-Type' => $documentMedia->mime_type,
        'Content-Description' => 'File Transfer',
        'Content-Disposition' => "attachment; filename={$documentMedia->file_name}",
        'filename' => $documentMedia->file_name,
      ];

      return response($file, 200, $headers);
    } catch (Exception $e) {
      throw new UnprocessableEntityHttpException($e->getMessage());
    }
  }
}
