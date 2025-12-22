<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use App\Models\BusinessHour;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

class BusinessHoursAPIController extends AppBaseController
{
    public function store(Request $request)
    {
       
        $request->validate([
            'vcard_id' => 'required',
        ]);

        $vcard = Vcard::findOrFail($request->vcard_id);

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('Vcard not found.');
        }
        $input = $request->all();

        try {
            BusinessHour::whereVcardId($vcard->id)->delete();
            if (isset($input['days'])) {
                foreach ($input['days'] as $day) {
                    BusinessHour::create([
                        'vcard_id' => $vcard->id,
                        'day_of_week' => $day,
                        'start_time' => $input['startTime'][$day],
                        'end_time' => $input['endTime'][$day],
                    ]);
                }
            }

            return $this->sendSuccess('Business hours updated successfully.');
        } catch (\Exception $e) {

            return $this->sendError($e->getMessage());
        }
    }

    public function getBusinessHours($vcardId)
    {
        $businessHours = BusinessHour::where('vcard_id', $vcardId)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->get();
        if($businessHours->isEmpty()){
            return $this->sendResponse([], 'Business hours retrieved successfully.');
        }
        $businessHours->makeHidden(['created_at', 'updated_at'])->toArray();

        return $this->sendResponse($businessHours, 'Business hours retrieved successfully.');
    }
}
