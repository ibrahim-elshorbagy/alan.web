<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\SocialLink;

class SocialLinksAPIController extends AppBaseController
{
    public function store(Request $request)
    {

        $request->validate([
            'vcard_id' => 'required',
        ]);

        $vcard = Vcard::findOrFail($request->vcard_id);

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('vCard not found.');
        }

        $socialLinks = SocialLink::where('vcard_id', $vcard->id)->first();

        if (empty($socialLinks)) {
            SocialLink::create($request->all());
            return $this->sendResponse([], 'Social links created successfully.');
        }else{
            $socialLinks->update($request->all());
            return $this->sendResponse([], 'Social links updated successfully.');
        }

        return $this->sendError('Something went wrong.');
    }

    public function getSocialLinks(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('vCard not found.');
        }
        $socialLinks = SocialLink::where('vcard_id', $vcard->id)->first();
        if (empty($socialLinks)) {
            return $this->sendResponse([], 'Social links retrieved successfully.');
        }
        $socialLink = $socialLinks->makeHidden(['created_at', 'updated_at','media'])->toArray();

        return $this->sendResponse($socialLink, 'Social links retrieved successfully.');
    }

}
