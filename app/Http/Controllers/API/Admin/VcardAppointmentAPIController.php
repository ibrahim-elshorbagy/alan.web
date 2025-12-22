<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\AppointmentDetail;
use App\Models\ScheduleAppointment;
use App\Http\Controllers\Controller;
use App\Repositories\VcardRepository;
use App\Http\Controllers\AppBaseController;

class VcardAppointmentAPIController extends AppBaseController
{
    private $vcardRepository;

    public function __construct(VcardRepository $vcardRepository)
    {
        $this->vcardRepository = $vcardRepository;
    }

    public function getAppoitmentSchedule($vcardId)
    {
        $appointment = Appointment::where('vcard_id', $vcardId)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->get();
        if($appointment->isEmpty()){
            return $this->sendResponse([], 'Appointment Schedule retrieved successfully.');
        }
        $appointment->makeHidden(['created_at', 'updated_at'])->toArray();

        $appointmentDetails = AppointmentDetail::where('vcard_id', $vcardId)->select('is_paid', 'price')->first()->toArray();

        $appointment = array_merge($appointment->toArray(), $appointmentDetails);

        return $this->sendResponse($appointment, 'Appointment Schedule retrieved successfully.');
    }

    public function  storeAppoitmentSchedule(Request $request)
    {

        $request->validate([
            'vcard_id' => 'required',
        ]);

        $vcard = Vcard::findOrFail($request->vcard_id);

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('vCard not found.');
        }
        $input = $request->all();


        $store = $this->vcardRepository->storeVcardAppointmentSchedule($input, $vcard);

        if(!$store){
            return $this->sendError('Something went wrong');
        }

        return $this->sendSuccess('vCard Appointment Schedule updated successfully.');
    }
}
