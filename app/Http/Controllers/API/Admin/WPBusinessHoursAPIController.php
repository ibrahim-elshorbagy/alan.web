<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\BusinessHour;
use App\Models\WhatsappStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WPBusinessHoursAPIController extends AppBaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whatsapp_store_id' => 'required|numeric|exists:whatsapp_stores,id',
            'days' => 'nullable|array',
            'week_format' => 'required|numeric|in:1,2',
        ], [
            'whatsapp_store_id.exists' => 'Invalid WhatsApp store ID.',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);

        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        try {

            $whatsappStore->week_format = $request->week_format;
            $whatsappStore->save();

            BusinessHour::where('whatsapp_store_id', $whatsappStore->id)->delete();

            if ($request->has('days')) {
                foreach ($request->days as $day) {
                    BusinessHour::create([
                        'whatsapp_store_id' => $whatsappStore->id,
                        'day_of_week' => $day,
                        'start_time' => $request->startTime[$day] ?? null,
                        'end_time' => $request->endTime[$day] ?? null,
                    ]);
                }
            }
            return $this->sendSuccess('Business hours updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getBusinessHours($whatsappStoreId)
    {
        $businessHours = BusinessHour::with('whatsappStore:id,week_format')
            ->where('whatsapp_store_id', $whatsappStoreId)
            ->whereHas('whatsappStore', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->get();

        if ($businessHours->isEmpty()) {
            return $this->sendResponse([], 'Business hours retrieved successfully.');
        }

        $businessHours->makeHidden(['created_at', 'updated_at', 'vcard_id'])->toArray();

        $businessHours = $businessHours->map(function ($item) {
            $formatNumber = $item->whatsappStore->week_format ?? null;

            $item->week_format = BusinessHour::WEEK_FORMAT_TYPE[$formatNumber] ?? null;

            unset($item->whatsappStore);

            return $item;
        });

        return $this->sendResponse($businessHours, 'Business hours retrieved successfully.');
    }
}
