<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;

class FontAPIController extends AppBaseController
{
    public function getFontList()
    {
        return $this->sendResponse(Vcard::FONT_FAMILY, 'Font list retrieved successfully.');
    }
    public function getVcardFonts(Vcard $vcard)
    {
    
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('Vcard not found.');
        }
        $fonts = [
            'font_family' => $vcard->font_family,
            'font_size' => $vcard->font_size,
        ];

        return $this->sendResponse($fonts, 'Fonts retrieved successfully.');
    }

    public function store(Request $request)
    {   
    
        $request->validate([
            'vcard_id' => 'required',
        ]);

        $vcard = Vcard::findOrFail($request->vcard_id);
        
        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('Vcard not found.');
        }
      
        if (!isset(Vcard::FONT_FAMILY[$request->get('font_family')])) {
            return $this->sendError('Invalid font family.');
        }
    
        $input = $request->all();
        
        $vcard->update($input);

        return $this->sendSuccess('Fonts updated successfully.');
    }
}
