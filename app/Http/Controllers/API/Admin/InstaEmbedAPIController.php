<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use Illuminate\Http\Request;
use App\Models\InstagramEmbed;
use App\Repositories\VcardRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\InstagramEmbedRepository;

class InstaEmbedAPIController extends AppBaseController
{
    private $instagramembedRepo;

    public function __construct(InstagramEmbedRepository $instagramembedRepo)
    {
        $this->instagramembedRepo = $instagramembedRepo;
    }
    public function getInstaEmbed(Vcard $vcard)
    {
        $instaEmbed = $vcard->InstagramEmbed;

        return $this->sendResponse($instaEmbed, 'Instagram Embed data retrieved successfully.');
    }

    public function storeInstaEmbed(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'embedtag' => 'nullable|required',
        ]);

        $input = $request->all();

        $this->instagramembedRepo->store($input);

        return $this->sendSuccess('Instagram Embed created successfully.');
    }

    public function show($id)
    {
        $instagramembed = InstagramEmbed::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($instagramembed)) {
            return $this->sendError('Instagram Embed not found.');
        }

        return $this->sendResponse($instagramembed, 'Instagram Embed retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $instagramembed = InstagramEmbed::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($instagramembed)) {
            return $this->sendError('Instagram Embed not found.');
        }

        $input = $request->all();

        $this->instagramembedRepo->update($input, $id);

        return $this->sendSuccess('Instagram Embed updated successfully.');
    }

    public function destroy($id)
    {
        $instagramembed = InstagramEmbed::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($instagramembed)) {
            return $this->sendError('Instagram Embed not found.');
        }
        $instagramembed->delete();

        return $this->sendSuccess('Instagram Embed deleted successfully.');
    }
}
