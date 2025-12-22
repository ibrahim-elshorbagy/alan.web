<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use Illuminate\Http\Request;
use App\Models\VcardSections;
use App\Http\Controllers\Controller;
use App\Repositories\VcardRepository;
use App\Http\Controllers\AppBaseController;

class ManageSectionAPIController extends AppBaseController
{
    private VcardRepository $vcardRepository;

    public function __construct(VcardRepository $vcardRepository)
    {
        $this->vcardRepository = $vcardRepository;
    }
    public function getManageSection(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('Vcard not found.');
        }

        $vcardSection = VcardSections::where('vcard_id', $vcard->id)->first()?->makeHidden(['updated_at','created_at','id']);

        return $this->sendResponse($vcardSection, 'Manage section data retrieved successfully.');
    }
 
    public function updateManageSection(Request $request)
    {
        $input = $request->all();
        $input['part'] = 'manage-section';
    
        $vcard = Vcard::findOrFail($input['vcard_id']);
        
        $this->vcardRepository->update($input,$vcard);

        return $this->sendSuccess('Manage section updated successfully.');
    }

}
