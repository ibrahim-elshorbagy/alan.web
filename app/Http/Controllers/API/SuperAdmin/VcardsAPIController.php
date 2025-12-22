<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Enquiry;
use App\Models\ScheduleAppointment;
use App\Models\Subscription;
use App\Models\Vcard;
use App\Repositories\VcardRepository;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VcardsAPIController extends AppBaseController
{
    private VcardRepository $vcardRepository;

    public function __construct(VcardRepository $vcardRepository)
    {
        $this->vcardRepository = $vcardRepository;
    }

    public function vcardsData()
    {
        $vcards = Vcard::all();

        if ($vcards->isEmpty()) {
            return $this->sendError('No vCards found', 404);
        }

        $data = [];

        foreach ($vcards as $vcard) {
            $data[] = [
                'id' => $vcard->id,
                'name' => $vcard->name,
                'url_alias' => route('vcard.show', ['alias' => $vcard->url_alias]),
                'occupation' => $vcard->occupation,
                'image' => !empty($vcard->template) ? $vcard->template->template_url : asset('assets/images/default_cover_image.jpg'),
            ];
        }

        return $this->sendResponse($data, 'vCards Data Retrieve Successfully.');
    }

    public function vcard($vcard)
    {
        $vcard = Vcard::find($vcard);

        if (empty($vcard)) {
            return $this->sendError('vCard not found', 404);
        }

        $data[] = [
            'id' => $vcard->id,
            'name' => $vcard->name,
            'occupation' => $vcard->occupation,
            'image' => !empty($vcard->template) ? $vcard->template->template_url : asset('assets/images/default_cover_image.jpg'),
            'created_at' => $vcard->created_at,
        ];
        return $this->sendResponse($data, 'vCards Data Retrieve Successfully.');
    }

    public function qrcodeVcard($vcard)
    {
        $vcard = Vcard::where('id', $vcard)->first();

        $data[] = [
            'url' => route('vcard.show', ['alias' => $vcard->url_alias]),
        ];

        return $this->sendResponse($data, "vCard Qr Code Retrieve Successfully.");
    }
}
