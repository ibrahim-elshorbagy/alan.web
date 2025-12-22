<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\WhatsappStore;
use Illuminate\Http\Request;

class WPFontAPIController extends AppBaseController
{
    public function getVcardFonts(WhatsappStore $whatsappStore)
    {
        $isNative = $whatsappStore->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('Whatsapp Store not found.');
        }
        $fonts = [
            'font_family' => $whatsappStore->font_family,
            'font_size' => $whatsappStore->font_size,
        ];

        return $this->sendResponse($fonts, 'Fonts retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'whatsapp_store_id' => 'required',
        ]);

        $whatsappStore = WhatsappStore::findOrFail($request->whatsapp_store_id);

        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        if (!isset(WhatsappStore::FONT_FAMILY[$request->get('font_family')])) {
            return $this->sendError('Invalid font family.');
        }

        $input = $request->all();

        $whatsappStore->update($input);

        return $this->sendSuccess('Fonts updated successfully.');
    }

    public function getFontList()
    {
        return $this->sendResponse(WhatsappStore::FONT_FAMILY, 'Font list retrieved successfully.');
    }
}
