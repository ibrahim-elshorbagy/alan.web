<?php

namespace App\Http\Controllers\API\Admin;

use Google\Service;
use App\Models\Vcard;
use App\Models\VcardService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use App\Repositories\VcardServiceRepository;

class ServiceAPIController extends AppBaseController
{
    private $vcardServiceRepo;

    public function __construct(VcardServiceRepository $vcardServiceRepo)
    {
        $this->vcardServiceRepo = $vcardServiceRepo;
    }

    public function index() {}

    public function getVcardProducts($vcardId)
    {

        $services = VcardService::where('vcard_id', $vcardId)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->get();


        if (empty($services)) {
            return $this->sendError('Service not found.');
        }

        $services->makeHidden(['created_at', 'updated_at', 'media'])->toArray();

        return $this->sendResponse($services, 'Service retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = VcardService::$rules;
        $rules['vcard_id'] = 'required';
        $rules['description'] = 'required';
        $rules['service_icon'] = 'required|file|mimes:jpg,jpeg,png|max:2048';

        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $vcard = Vcard::findOrFail($request->vcard_id); 

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('Vcard not found.');
        }


        $input = $request->all();

        $service = $this->vcardServiceRepo->store($input);

        return $this->sendSuccess('Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $service = VcardService::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();
        
        if (empty($service)) {
            return $this->sendError('Service not found.');
        }

        $service->makeHidden(['created_at', 'updated_at', 'media'])->toArray();

        return $this->sendResponse($service, 'Service retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $rules = VcardService::$rules;
        $rules['description'] = 'required';
        $rules['service_icon'] = 'file|mimes:jpg,jpeg,png|max:2048';

        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $service = VcardService::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();
   
        if (empty($service)) {
            return $this->sendError('Service not found.');
        }

        $input = $request->all();

        $products = $this->vcardServiceRepo->update($input, $id);

        return $this->sendSuccess('Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = VcardService::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($service)) {
            return $this->sendError('Service not found.');
        }
        $service->delete();

        return $this->sendSuccess('Service deleted successfully.');
    }

    public function servicesSliderView(Vcard $vcard): JsonResponse
    {
        if ($vcard) {
            $vcard->services_slider_view = !$vcard->services_slider_view;
            $vcard->save();
            return $this->sendSuccess('Service slider view updated successfully.');
        }
        return $this->sendError('Something went wrong', 200);
    }

}   
