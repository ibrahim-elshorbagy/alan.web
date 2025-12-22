<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\ShortCode;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplatesController extends AppBaseController
{
    public function index(): \Illuminate\View\View
    {
        $allTemplates = EmailTemplate::all();
        $groupedTemplates = $allTemplates->groupBy(['email_template_type', 'language_id']);
        $languages = Language::where('status', 1)->orderBy('name')->get();
        $newUserRegister = EmailTemplate::where('email_template_type', 0)->first();
        $appointmentApprove = EmailTemplate::where('email_template_type', 1)->first();
        $adminNfcOrderMail = EmailTemplate::where('email_template_type', 2)->first();
        $contactUs = EmailTemplate::where('email_template_type', 3)->first();
        $nfcOrderStatus = EmailTemplate::where('email_template_type', 4)->first();
        $productOrderSendCustomer = EmailTemplate::where('email_template_type', 5)->first();
        $productOrderSendUser = EmailTemplate::where('email_template_type', 6)->first();
        $sendInvite = EmailTemplate::where('email_template_type', 7)->first();
        $subscriptionPaymentSuccess = EmailTemplate::where('email_template_type', 8)->first();
        $userAppointmentMail = EmailTemplate::where('email_template_type', 9)->first();
        $withdrawalApprove = EmailTemplate::where('email_template_type', 10)->first();
        $withdrawalReject = EmailTemplate::where('email_template_type', 11)->first();
        $appointmentMail = EmailTemplate::where('email_template_type', 12)->first();
        $landingContactUs = EmailTemplate::where('email_template_type', 13)->first();
        $whatsappStoreProductOrderUser = EmailTemplate::where('email_template_type', 14)->first();
        $shortCodes = ShortCode::all();
        $selectedTemplate = EmailTemplate::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();
        if ($selectedTemplate == null) {
            $selectedTemplate['email_template_type'] = 0;
        }

        $defaultLanguageCode = getSuperAdminSettingValue('default_language' ?? 'en'); // fallback to 'en'
        $defaultLanguage = $languages->where('iso_code', $defaultLanguageCode)->first() ?? $languages->first();

        return view('sadmin.email_templates.index', compact('shortCodes', 'newUserRegister', 'appointmentApprove', 'adminNfcOrderMail', 'contactUs', 'nfcOrderStatus', 'productOrderSendCustomer','productOrderSendUser','sendInvite','subscriptionPaymentSuccess','userAppointmentMail','withdrawalApprove','withdrawalReject', 'selectedTemplate', 'languages', 'groupedTemplates', 'defaultLanguage','appointmentMail', 'landingContactUs', 'whatsappStoreProductOrderUser'));
    }

    public function store(Request $request)
    {
        $emailTemplate = EmailTemplate::where([
            'email_template_type' => $request->email_template_type,
            'language_id' => $request->language_id
        ])->first();

        if ($emailTemplate) {
            $emailTemplate->update($request->all());
        } else {
            EmailTemplate::create($request->all());
        }

        Flash::success(__('messages.email_templates.email_template_updated_successfully'));
        return redirect()->back();
    }
}
