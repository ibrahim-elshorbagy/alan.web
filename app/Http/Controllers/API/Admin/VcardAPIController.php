<?php

namespace App\Http\Controllers\API\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vcard;
use App\Models\Enquiry;
use App\Models\Template;
use App\Models\QrcodeEdit;
use App\Models\Appointment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ScheduleAppointment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\VcardRepository;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;
use Illuminate\Console\Scheduling\Schedule;

class VcardAPIController extends AppBaseController
{
    private $vcardRepository;


    public function __construct(VcardRepository $vcardRepository)
    {
        $this->vcardRepository = $vcardRepository;
    }

    public function vcardData()
    {
        $loggedInTenantId = getLogInTenantId();

        $vcardIds = Vcard::whereTenantId($loggedInTenantId)->pluck('id')->toArray();

        $vcards = Vcard::whereIn('id', $vcardIds)->get();

        $data = [];

        foreach ($vcards as $vcard) {
            $data[] = [
                'id' => $vcard->id,
                'name' => $vcard->name,
                'url_alias' => route('vcard.show', ['alias' => $vcard->url_alias]),
                'occupation' => $vcard->occupation,
                'image' => !empty($vcard->template) ? $vcard->template->template_url : asset('assets/images/default_cover_image.jpg'),
            ];
        }

        return $this->sendResponse($data, 'vCards Data Retrieve Successfully.');
    }

    public function vcard(Vcard $vcard)
    {
        $tenantId = getLogInTenantId();

        $isAccess = $vcard->tenant_id == $tenantId;

        if (!$isAccess) {
            return $this->sendError('vCard not found');
        }

        $data = [
            'id' => $vcard->id,
            'name' => $vcard->name,
            'occupation' => $vcard->occupation,
            'image' => !empty($vcard->template) ? $vcard->template->template_url : asset('assets/images/default_cover_image.jpg'),
            'created_at' => $vcard->created_at,
            'services_slider_view' => $vcard->services_slider_view
        ];

        return $this->sendResponse($data, 'vCard Data Retrieved Successfully.');
    }



    public function deleteVcard($vcardId)
    {
        $tenantId = getLogInTenantId();

        $userVcard = Vcard::where('id', $vcardId)
            ->where('tenant_id', $tenantId)
            ->first();

        if (!$userVcard) {
            return $this->sendError('vCard not found');
        }

        $userVcard->delete();

        return $this->sendSuccess('vCard deleted successfully.');
    }

    public function appointmentVcard($vcard)
    {
        if (!is_array($vcard)) {
            $vcard = [$vcard];
        }

        $tenantId = getLogInTenantId();

        $scheduleAppointment = ScheduleAppointment::with('vcard')
            ->whereIn('vcard_id', $vcard)
            ->whereHas('vcard', function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })
            ->get();

        $data = [];

        foreach ($scheduleAppointment as $scheduleAppointments) {
            $data[] = [
                'id' => $scheduleAppointments->id,
                'vcard_id' => $scheduleAppointments->vcard->id,
                'vcard_name' => $scheduleAppointments->vcard->name,
                'name' => $scheduleAppointments->name,
                'date' => $scheduleAppointments->date,
                'from_time' => $scheduleAppointments->from_time,
                'to_time' => $scheduleAppointments->to_time,
                'status' => $scheduleAppointments->status,
                'paid_amount' => $scheduleAppointments->paid_amount,
            ];
        }

        return $this->sendResponse($data, 'vCard Appointment Data Retrieve Successfully.');
    }


    public function enquiresVcard($vcard)
    {
        $tenantId = getLogInTenantId();

        $enquiriesDatas = Enquiry::whereHas('vcard', function ($query) use ($vcard, $tenantId) {
            $query->where('id', $vcard)
                ->where('tenant_id', $tenantId);
        })
            ->get();

        $data = [];

        foreach ($enquiriesDatas as $enquiriesData) {
            $data[] = [
                'id' => $enquiriesData->id,
                'vcard_name' => $enquiriesData->vcard->name,
                'name' => $enquiriesData->name,
                'email' => $enquiriesData->email,
                'phone' => $enquiriesData->phone,
                'message' => $enquiriesData->message,
                'created_at' => $enquiriesData->created_at,
            ];
        }

        return $this->sendResponse($data, 'vCard Enquiries Data Retrieve Successfully.');
    }

    public function vcardCreate(Request $request)
    {

        $rules = array_merge(Vcard::$rules, [
            'url_alias' => 'required|string|min:6|max:100|unique:vcards,url_alias',
            'name' => 'required|string|min:6',
            'occupation' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $input = $request->all();
        $input['tenant_id'] = getLogInTenantId();

        try {
            $vcard = $this->vcardRepository->store($input);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
        $vcardId = ['vcard_id' => $vcard->id];

        return $this->sendResponse($vcardId, 'vCard Created Successfully.');

    }

    public function vcardBasicDetails(Request $request, Vcard $vcard)
    {

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('Vcard not found.');
        }

        $rules = Vcard::$rules;
        $rules['url_alias'] = [
            'string',
            'min:6',
            'max:100',
            Rule::unique('vcards', 'url_alias')->ignore($vcard->id),
        ];

        $rules['name'] = 'required|string|min:2';
        $rules['first_name'] = 'required|string|min:2';
        $rules['last_name'] = 'required|string';
        $rules['profile_img'] = 'file|mimes:jpg,bmp,png,apng,avif,jpeg,';
        $rules['cover_img'] = 'file|mimes:jpg,bmp,png,apng,avif,jpeg,mp4,mpeg,ogg,webm,3gp,mov,flv,avi,wmv,ts|max:10240';
        $rules['email'] = 'required|email|regex:/(.*)@(.*)\.(.*)/';
        $rules['phone'] = 'required|numeric';
        $rules['region_code'] = 'required';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $input = $request->all();

        $editAliasURL = getSuperAdminSettingValue('url_alias');

        if ($editAliasURL == 0 && isset($input['url_alias']) && $input['url_alias'] != $vcard->url_alias) {
            return $this->sendError(__('messages.flash.url_alias'));
        }
        $vcard = $this->vcardRepository->updateVcardBasicDetails($input, $vcard);

        if (!$vcard) {
            return $this->sendError(__('something went wrong'));
        }

        return $this->sendSuccess(__('messages.flash.vcard_update'));
    }

    public function vcardTemplate(Request $request, Vcard $vcard)
    {
        $status = request('status');

        $request->validate([
            'template_id' => 'required|numeric',
        ]);

        if ($status == null) {
            return $this->sendError(__('status field is required'));
        }

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('vCard not found.');
        }


        $input = [
            'template_id' => request('template_id'),
            'status' => $status,
        ];

        $vcard = $this->vcardRepository->updateVcardTemplate($input, $vcard);

        if (!$vcard) {
            return $this->sendError(__('something went wrong'));
        }

        return $this->sendSuccess(__('messages.flash.vcard_update'));
    }

    public function storeAdvanceDetails(Request $request, Vcard $vcard)
    {

        $request->validate([
            'vcard_id' => 'required',
        ]);

        $vcard = Vcard::findOrFail($request->vcard_id);

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('vCard not found.');
        }
        $input = $request->all();
        $input['password'] = isset($input['password']) ? Crypt::encrypt($input['password']) : '';

        $vcard->update($input);

        return $this->sendSuccess('vCard updated successfully.');
    }

    public function getAdvanceDetails(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('vCard not found.');
        }

        $vcardData = [
            'custom_js' => $vcard->custom_js,
            'custom_css' => $vcard->custom_css,
            'branding' => $vcard->branding,
            'password' => !empty($vcard->password) ? Crypt::decrypt($vcard->password) : null,
        ];

        return $this->sendResponse($vcardData, 'Advance details retrieved successfully.');
    }

    public function getVcardBasicDetails(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('vCard not found.');
        }

        $vcard = $vcard->makeHidden('media');

        return $this->sendResponse($vcard, 'vCard basic details retrieved successfully.');
    }


    public function getVcardTemplate(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('vCard not found.');
        }
        $status = $vcard->status;

        $vcardTemplateList = [];

        $templateList = [];

        $currentPlan = getCurrentSubscription();

        if ($currentPlan->plan) {
             $templateList = getTemplateUrls($currentPlan->plan->templates);
        } else {
            $templateList = getTemplateUrls();
        }

        $templateList = array_keys($templateList);

        $templates = Template::whereIn('id', $templateList)->get();


        foreach ($templates as $template) {
            $vcardTemplateList[] = [
                'id' => $template->id,
                'name' => $template->name,
                'template_url' => $template->template_url,
                'is_selected' => $template->id == $vcard->template_id
            ];
        }

        array_push($vcardTemplateList, ['status' => $status]);

        return $this->sendResponse($vcardTemplateList, 'vCard template retrieved successfully.');
    }

    public function enquiresData()
    {
        $vcardIds = Vcard::where('tenant_id', getLogInTenantId())->pluck('id')->toArray();

        $enquiries = Enquiry::with('vcard')->whereIn('vcard_id', $vcardIds)->get();

        if (!empty($enquiries)) {
            $enquiries->makeHidden(['media', 'updated_at'])->toArray();
        }

        return $this->sendResponse($enquiries, 'Enquiries retrieved successfully.');
    }

    public function getEnquiresDetails($enquiryId)
    {
        $enquiry = Enquiry::where('id', $enquiryId)->whereHas('vcard', function ($query) {
            $query->where('tenant_id', getLogInTenantId());
        })->first();

        return $this->sendResponse($enquiry, 'Enquiry details retrieved successfully.');
    }

    public function deleteEnquiry($enquiryId)
    {
        $enquiry = Enquiry::where('id', $enquiryId)->whereHas('vcard', function ($query) {
            $query->where('tenant_id', getLogInTenantId());
        })->first();

        if (empty($enquiry)) {
            return $this->sendError('Enquiry not found.');
        }

        $enquiry->delete();

        return $this->sendSuccess('Enquiry deleted successfully.');
    }


    public function qrcodeVcard(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('vCard not found.');
        }

        $qrCode = QrcodeEdit::where('vcard_id', $vcard->id)->get()->makeHidden(['updated_at', 'created_at', 'id', 'tenant_id']);

        return $this->sendResponse($qrCode, 'Qrcode data retrieved successfully.');
    }

    public function updateQrCode(Request $request, Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('vCard not found.');
        }

        $input = $request->all();

        $this->vcardRepository->updateAPIQrCode($input, $vcard->id);

        return $this->sendSuccess('Qrcode updated successfully.');
    }


    public function getStorageData()
    {
       $data = $this->vcardRepository->storageData();

        return $this->sendResponse($data, 'Storage data retrieved successfully.');
    }
    public function getBanner(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('vCard not found.');
        }
        $banner = $vcard->banners()->get();

        return $this->sendResponse($banner, 'Banner data retrieved successfully.');
    }

    public function getManageSubscription()
    {
        $subscription = Subscription::with(['plan.currency'])
            ->where('tenant_id', getLogInTenantId())
            ->orderBy('id', 'desc')
            ->get()
            ->makeHidden(['updated_at', 'created_at', 'id', 'tenant_id'])
            ->map(function ($subscription) {
                $now = \Carbon\Carbon::now();
                $statusLabel = '';

                if ($now->gt($subscription->ends_at)) {
                    $statusLabel = "Expired";
                } elseif ($subscription->status == Subscription::PENDING) {
                    $statusLabel = "Pending";
                } elseif ($subscription->status == Subscription::ACTIVE) {
                    $statusLabel = "Active";
                } elseif ($subscription->status == Subscription::REJECT) {
                    $statusLabel = "Rejected";
                } else {
                    $statusLabel = "Closed";
                }

                return [
                    'plan_name' => $subscription->plan->name,
                    'amount' => $subscription->plan->price,
                    'subscribed_date' => \Carbon\Carbon::parse($subscription->starts_at)->format('dS M, Y'),
                    'expired_date' => \Carbon\Carbon::parse($subscription->ends_at)->format('dS M, Y'),
                    'status' => $statusLabel,
                ];
            });


        return $this->sendResponse($subscription, 'Subscription data retrieved successfully.');
    }
}
