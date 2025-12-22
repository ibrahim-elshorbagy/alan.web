<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BannerRepository;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\VcardSections;

class BannerAPIController extends AppBaseController
{
    private $bannerRepo;

    public function __construct(BannerRepository $bannerRepo)
    {
        $this->bannerRepo = $bannerRepo;
    }

    public function getBanner(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('Vcard not found.');
        }
        
        $enableBanner = VcardSections::where('vcard_id', $vcard->id)->first();

        $banner = $vcard->banners()->get()->map(function ($banner) use ($enableBanner) {
            $banner->banner = $enableBanner->banner;

            return $banner;
        })->makeHidden(['updated_at','created_at','id','enable']);
      

        return $this->sendResponse($banner, 'Banner data retrieved successfully.');
    }

    public function updateBanner(CreateBannerRequest $request)
    {
        $input = $request->all();

        $this->bannerRepo->store($input);

        return $this->sendSuccess('Banner updated successfully.');
    }
}
