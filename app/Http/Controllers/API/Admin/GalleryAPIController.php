<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Repositories\GalleryRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;

class GalleryAPIController extends AppBaseController
{
    private $galleryRepo;

    public function __construct(GalleryRepository $galleryRepo)
    {
        $this->galleryRepo = $galleryRepo;
    }

    public function getGalleryList(Vcard $vcard)
    {
        $galleries = $vcard->gallery()->orderBy('id', 'desc')->get()->makeHidden(['updated_at', 'created_at', 'media']);

        return $this->sendResponse($galleries, 'Gallery data retrieved successfully.');
    }

    public function getGallery(Gallery $gallery)
    {
        $gallery = $gallery->makeHidden(['updated_at', 'created_at', 'media']);
        return $this->sendResponse($gallery, 'Gallery retrieved successfully.');
    }

    public function store(CreateGalleryRequest $request)
    {
        $input = $request->all();

        $this->galleryRepo->store($input);

        return $this->sendSuccess('Gallery created successfully.');
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $input = $request->all();
        $vcard = Vcard::whereId($gallery->vcard_id)->first();

        $this->galleryRepo->update($input, $gallery->id);

        return $this->sendSuccess('Gallery updated successfully.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($gallery)) {
            return $this->sendError('Gallery Embed not found.');
        }
        $gallery->delete();

        return $this->sendSuccess('Gallery Embed deleted successfully.');
    }
}
