<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Models\TermCondition;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;

class PrivacyAndTermAPIController extends AppBaseController
{
    public function getPrivacyPolicy(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('Vcard not found.');
        }

        $privacyPolicy = $vcard->privacy_policy;
      
        return $this->sendResponse($privacyPolicy, 'Privacy policy retrieved successfully.');
    }

    public function storePrivacyPolicy(Request $request)
    {
        $request->validate([
            'vcard_id' => 'required',
        ]);

        $vcard = Vcard::findOrFail($request->vcard_id);

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('Vcard not found.');
        }

        $input = $request->all();
        
        PrivacyPolicy::updateOrCreate(['vcard_id' => $vcard->id], $input);

        return $this->sendSuccess('Privacy policy updated successfully.');
        
    }

    public function getTermsConditions(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('Vcard not found.');
        }

        $termCondition = $vcard->term_condition;
      
        return $this->sendResponse($termCondition, 'Terms & Condition retrieved successfully.');
    }

    public function storeTermsConditions(Request $request)
    {
        $request->validate([
            'vcard_id' => 'required',
        ]);

        $vcard = Vcard::findOrFail($request->vcard_id);

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('Vcard not found.');
        }

        $input = $request->all();
        
        TermCondition::updateOrCreate(['vcard_id' => $vcard->id], $input);

        return $this->sendSuccess('Terms & Condition updated successfully.');
        
    }
}
