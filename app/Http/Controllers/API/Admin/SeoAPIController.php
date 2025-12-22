<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\VcardRepository;
use App\Http\Controllers\AppBaseController;

class SeoAPIController extends AppBaseController
{
    private VcardRepository $vcardRepository;

    public function __construct(VcardRepository $vcardRepository)
    {
        $this->vcardRepository = $vcardRepository;
    }
    public function getSeo(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('Vcard not found.');
        }

        $data [] = [
            'site_title' => $vcard->site_title,
            'home_title' => $vcard->home_title,
            'meta_keyword' => $vcard->meta_keyword,
            'meta_description' => $vcard->meta_description,
            'google_analytics' => $vcard->google_analytics,
        ];

        return $this->sendResponse($data, 'Seo data retrieved successfully.');
    }

    public function updateSeo(Request $request)
    {
        $input = $request->all();

        $vcard = Vcard::findOrFail($input['vcard_id']);

        $this->vcardRepository->update($input,$vcard);

        return $this->sendSuccess('Seo updated successfully.');
    }

}
