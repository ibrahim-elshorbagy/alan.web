<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\WhatsappStore;
use App\Models\WpStoreTemplate;
use App\Repositories\WhatsappStoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class WhatsappStoreAPIController extends AppBaseController
{
    private $whatsappStoreRepository;


    public function __construct(WhatsappStoreRepository $whatsappStoreRepository)
    {
        $this->whatsappStoreRepository = $whatsappStoreRepository;
    }
    public function whatsappStoreData()
    {
        $loggedInTenantId = getLogInTenantId();

        $wpIds = WhatsappStore::whereTenantId($loggedInTenantId)->pluck('id')->toArray();

        $whatsappStores = WhatsappStore::whereIn('id', $wpIds)->get();

        $data = [];

        foreach ($whatsappStores as $whatsappStore) {
            $data[] = [
                'id' => $whatsappStore->id,
                'store_name' => $whatsappStore->store_name,
                'url_alias' => route('whatsapp.store.show', ['alias' => $whatsappStore->url_alias]),
                'region_code' => $whatsappStore->region_code,
                'whatsapp_no' => $whatsappStore->whatsapp_no,
                'logo_url' => !empty($whatsappStore->logo_url) ? $whatsappStore->logo_url : asset('assets/images/default_cover_image.jpg'),
                'status' => $whatsappStore->status,
                'created_at' => $whatsappStore->created_at->toDateTimeString(),
            ];
        }

        return $this->sendResponse($data, 'whatsapp Store Data Retrieve Successfully.');
    }

    public function wpCreate(Request $request)
    {
        $rules = array_merge(WhatsappStore::$rules, [
            'url_alias' => 'required|string|min:8|max:100|unique:whatsapp_stores,url_alias',
            'store_name' => 'required',
            'region_code' => 'required',
            'whatsapp_no' => 'required|numeric',
            'logo' => 'required|file|image|mimes:jpg,png,jpeg|max:10240', // Max 1MB
            'cover_img' => 'required|file|image|mimes:jpg,png,jpeg|max:10240', // Max 1MB
            'address' => 'required|string|max:255',
        ]);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $input = $request->all();
        $input['tenant_id'] = getLogInTenantId();

        try {
            $whatsappStore = $this->whatsappStoreRepository->store($input);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
        $wpId = ['whatsapp_store_id' => $whatsappStore->id];

        return $this->sendResponse($wpId, 'Whatsapp Store Created Successfully.');
    }

    public function wpTemplate(Request $request, WhatsappStore $whatsappStore)
    {
        $validator = Validator::make($request->all(), [
            'template_id' => 'required|numeric|exists:wp_store_templates,id',
        ], [
            'template_id.exists' => 'Template does not exist.',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('vCard not found.');
        }

        $whatsappStore->update([
            'template_id' => $request->template_id,
        ]);

        return $this->sendSuccess(__('messages.flash.vcard_update'));
    }

    public function storeAdvanceDetails(Request $request)
    {
        $rules = [
            'whatsapp_store_id' => 'required|exists:whatsapp_stores,id',
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);

        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        try {
            $whatsappStore->update([
                'custom_css' => $request->custom_css,
                'custom_js'  => $request->custom_js,
            ]);
            return $this->sendSuccess('Whatsapp Store Advanced Details Saved Successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getAdvanceDetails(WhatsappStore $whatsappStore)
    {
        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $data = [
            'custom_css' => $whatsappStore->custom_css,
            'custom_js'  => $whatsappStore->custom_js,
        ];

        return $this->sendResponse($data, 'Whatsapp Store Advanced Details Retrieved Successfully.');
    }

    public function getSeo(WhatsappStore $whatsappStore)
    {
        $isNative = $whatsappStore->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('Whatsapp not found.');
        }

        $data [] = [
            'site_title' => $whatsappStore->site_title,
            'home_title' => $whatsappStore->home_title,
            'meta_keyword' => $whatsappStore->meta_keyword,
            'meta_description' => $whatsappStore->meta_description,
            'google_analytics' => $whatsappStore->google_analytics,
        ];

        return $this->sendResponse($data, 'Seo data retrieved successfully.');
    }

    public function updateSeo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whatsapp_store_id' => 'required|exists:whatsapp_stores,id',
            'site_title'        => 'nullable|string|max:255',
            'home_title'        => 'nullable|string|max:255',
            'meta_keyword'      => 'nullable|string',
            'meta_description'  => 'nullable|string',
            'google_analytics'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);

        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        try {
            $whatsappStore->update([
                'site_title'       => $request->site_title,
                'home_title'       => $request->home_title,
                'meta_keyword'     => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'google_analytics' => $request->google_analytics,
            ]);

            return $this->sendSuccess('SEO Settings updated successfully.');

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function updateBasicDetails(Request $request, WhatsappStore $whatsappStore)
    {
        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $rules = [
            'store_name' => 'required',
            'region_code' => 'required',
            'whatsapp_no' => 'required|numeric',
            'logo' => 'nullable|file|image|mimes:jpg,png,jpeg|max:10240', // Max 10MB
            'cover_img' => 'nullable|file|image|mimes:jpg,png,jpeg|max:10240', // Max 10MB
            'address' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $input = $request->all();

        try {
        $this->whatsappStoreRepository->update($whatsappStore, $input);
            return $this->sendSuccess('Whatsapp Store Basic Details Updated Successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function deleteWhatsappStore(WhatsappStore $whatsappStore)
    {
        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        try {
            $whatsappStore->delete();

            return $this->sendSuccess('Whatsapp Store Deleted Successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function updateStatus(Request $request, WhatsappStore $whatsappStore)
    {
        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            $whatsappStore->update([
                'status' => $request->status,
            ]);

            return $this->sendSuccess('Whatsapp Store Status Updated Successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getWhatsappStoreTemplate()
    {
        $templates = WpStoreTemplate::all();

        $data = [];

        foreach($templates as $template) {
            $data[] = [
                'id' => $template->id,
                'name' => $template->name,
                'preview_image_url' => !empty($template->preview_image_url) ? $template->preview_image_url : asset('assets/images/default_cover_image.jpg'),
            ];
        }

        return $this->sendResponse($data, 'Whatsapp Store Templates Retrieved Successfully.');
    }

    public function editWpTemplate(WhatsappStore $whatsappStore)
    {
        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $template = WpStoreTemplate::find($whatsappStore->template_id);

        if (empty($template)) {
            return $this->sendError('Template not found.');
        }

        $data = [
            'id' => $template->id,
            'name' => $template->name,
            'preview_image_url' => !empty($template->preview_image_url) ? $template->preview_image_url : asset('assets/images/default_cover_image.jpg'),
        ];

        return $this->sendResponse($data, 'Whatsapp Store Template Retrieved Successfully.');
    }

    public function editBasicDetails(WhatsappStore $whatsappStore)
    {
        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $data = [
            'url_alias' => route('whatsapp.store.show', ['alias' => $whatsappStore->url_alias]),
            'store_name' => $whatsappStore->store_name,
            'region_code' => $whatsappStore->region_code,
            'whatsapp_no' => $whatsappStore->whatsapp_no,
            'logo' => !empty($whatsappStore->logo_url) ? $whatsappStore->logo_url : asset('assets/images/default_cover_image.jpg'),
            'cover_img' => !empty($whatsappStore->cover_url) ? $whatsappStore->cover_url : asset('assets/images/default_cover_image.jpg'),
            'address' => $whatsappStore->address,
            'news_letter_popup' => $whatsappStore->news_letter_popup,
            'business_hours' => $whatsappStore->business_hours,
            'hide_stickybar' => $whatsappStore->hide_stickybar,
            'enable_download_qr_code' => $whatsappStore->enable_download_qr_code,
            'default_language' => $whatsappStore->default_language,
            'qr_code_download_size' => $whatsappStore->qr_code_download_size,
            'slider_video_banner' => $whatsappStore->slider_video_banner,
        ];

        return $this->sendResponse($data, 'Whatsapp Store Basic Details Retrieved Successfully.');
    }
}
