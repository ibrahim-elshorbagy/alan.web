<?php

namespace App\Http\Controllers;

use Str;
use URL;
use Image;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Vcard;
use Spatie\Color\Hex;
use App\Models\Banner;
use App\Models\Iframe;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\VcardBlog;
use App\Models\CustomLink;
use App\Models\QrcodeEdit;
use App\Models\SocialIcon;
use App\Models\SocialLink;
use Laracasts\Flash\Flash;
use App\Models\Appointment;
use App\Models\UserSetting;
use App\Models\CustomDomain;
use App\Models\DynamicVcard;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Models\TermCondition;
use App\Models\VcardSections;
use App\Models\ContactRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AppointmentDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use App\Models\ScheduleAppointment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactRequestExport;
use App\Repositories\VcardRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Models\VcardEmailSubscription;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\CreateVcardRequest;
use App\Http\Requests\UpdateVcardRequest;
use App\Http\Middleware\CustomDomainCheck;
use JeroenDesloovere\VCard\VCard as VCardVCard;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\CreateEmailSubscribersRequest;
use Modules\SlackIntegration\Entities\SlackIntegration;
use Modules\SlackIntegration\Notifications\SlackNotification;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class VcardController extends AppBaseController
{
    private VcardRepository $vcardRepository;

    public function __construct(VcardRepository $vcardRepository)
    {
        $this->vcardRepository = $vcardRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        $makeVcard = $this->vcardRepository->checkTotalVcard();

        return view('vcards.index', compact('makeVcard'));
    }

    /**
     * @return Application|Factory|View
     */
    public function template(): \Illuminate\View\View
    {
        return view('sadmin.vcards.index');
    }

    public function download($id): JsonResponse
    {
        $data = Vcard::with('socialLink')->find($id);

        return $this->sendResponse($data, __('messages.flash.vcard_retrieve'));
    }

    /**
     * @return Application|Factory|View
     */
    public function vcards(): \Illuminate\View\View
    {
        $makeVcard = $this->vcardRepository->checkTotalVcard();

        return view('vcards.templates', compact('makeVcard'));
    }

    public function verified(Vcard $vcard): JsonResponse
    {
        $vcard->update([
            'is_verified' => ! $vcard->is_verified,
        ]);
        return $this->sendResponse($vcard, __('messages.flash.vcard_verified'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $makeVcard = $this->vcardRepository->checkTotalVcard();
        if (! $makeVcard) {
            return redirect(route('vcards.index'));
        }

        $partName = 'basics';

        static $settings;
        if (empty($settings)) {
            $settings = Setting::all()->keyBy('key');
        }
        $favicon = $settings['favicon'];
        $adminFavicon = $favicon->favicon_url;

        return view('vcards.create', compact('partName', 'adminFavicon'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateVcardRequest $request): RedirectResponse
    {
        if ($request->favicon_img) {
            $imageSize = getimagesize($request->favicon_img);
            $width = $imageSize[0];
            $height = $imageSize[1];

            if ($width > 16 && $height > 16) {
                Flash::error(__('messages.placeholder.favicon_invalid'));

                return redirect()->back();
            }
        }
        $input = $request->all();

        $vcard = $this->vcardRepository->store($input);

        Flash::success(__('messages.flash.vcard_create'));

        // Send Slack Notification after successful payment initialization
        $user = Auth::user();
        $userName = implode(' ', [$user->first_name, $user->last_name]);


        if (moduleExists('SlackIntegration')) {
            $slackIntegration = SlackIntegration::first();

            if ($slackIntegration && $slackIntegration->user_create_vcard_notification == 1 && !empty($slackIntegration->webhook_url)) {
                $message = "🔔 New vCard Created !!\n{$userName} A new vCard has been created.";
                $slackIntegration->notify(new SlackNotification($message));
            }
        }

        return redirect(route('vcards.edit', $vcard->id));
    }

    /**
     * @return Application|Factory|View
     */
    public function show($alias, $id = null)
    {
        $middleware = new CustomDomainCheck();

        // Manually handle the middleware
        $response = $middleware->handle(request(), function ($req) {
            // Continue processing after middleware passes
            return null;
        });

        if ($response) {
            return $response;
        }

        $requestName = request()->route()->getName();

        if ($requestName == "vcard.subdomain") {
            $alias = request()->alias;
        }

        if (request()->has('fbclid')) {
            $cleanUrl = request()->fullUrlWithoutQuery('fbclid');
            return redirect()->to($cleanUrl);
        }

        $vcard = Vcard::with([
            'businessHours' => function ($query) {
                $query->where('end_time', '!=', '00:00');
            },
            'services',
            'testimonials',
            'products',
            'blogs',
            'privacy_policy',
            'term_condition',
            'user',
            'banners',
            'iframes',
            'dynamic_vcard',
        ])->whereUrlAlias($alias)->first();

        $customDomain = CustomDomain::where('user_id', $vcard->user_id)->where('is_active', 1)->first();
        $isCustomDomainUse = $customDomain ? $customDomain->is_use_vcard : false;
        $vcardUrl = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}" : route('vcard.show', ['alias' => $vcard->url_alias]);
        $vcardProductUrl = $isCustomDomainUse ? "https://{$customDomain->domain}/products/{$vcard->id}/{$vcard->url_alias}" : route('showProducts', ['id' => $vcard->id, 'alias' => $vcard->url_alias]);
        $vcardPrivacyAndTerm = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/privacy-policy/{$vcard->id}" : route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]);
        $vcard11Contact = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/contact" : route('vcard.show.contact', $vcard->url_alias);
        $vcard11Blog = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/blog" : route('vcard.show.blog', $vcard->url_alias);
        $vcard11PrivacyPolicy = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/privacy-policy/{$vcard->id}" : route('vcard.show.privacy-policy', [$vcard->url_alias, $vcard->id]);
        $vcard11TermAndCondition = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/term-condition/{$vcard->id}" : route('vcard.show.term-condition', [$vcard->url_alias, $vcard->id]);

        $vcardProducts = $vcard->products()->orderBy('id', 'desc')->get();

        $blogSingle = '';
        if (isset($id)) {
            $blogSingle = VcardBlog::where('id', $id)->first();
        }
        $setting = Setting::pluck('value', 'key')->toArray();
        $vcard_name = $vcard->template->name;
        $url = explode('/', $vcard->location_url);

        $appointmentDetail = AppointmentDetail::where('vcard_id', $vcard->id)->first();
        $instagramEmbed = AppointmentDetail::where('vcard_id', $vcard->id)->first();
        $managesection = VcardSections::where('vcard_id', $vcard->id)->first();
        $banners = Banner::where('vcard_id', $vcard->id)->first();
        $iframes = Iframe::where('vcard_id', $vcard->id)->first();
        $dynamicVcard = DynamicVcard::where('vcard_id', $vcard->id)->first();
        $customLink = CustomLink::where('vcard_id', $vcard->id)->get();

        $userSetting = UserSetting::where('user_id', $vcard->user->id)->pluck('value', 'key')->toArray();

        $currency = '';
        $paymentMethod = null;
        if (isset($userSetting['currency_id']) && count($userSetting) > 0) {
            $currency = Currency::where('id', $userSetting['currency_id'])->first();
            $paymentMethod = getPaymentMethod($userSetting);
        }

        $reqpage = str_replace('/' . $vcard->url_alias, '', \Request::getRequestUri());
        $reqpage = empty($reqpage) ? 'index' : $reqpage;
        $reqpage = preg_replace("/\.$/", '', $reqpage);
        $reqpage = preg_replace('/[0-9]+/', '', $reqpage);
        $reqpage = str_replace('/', '', $reqpage);
        $reqpage = str_contains($reqpage, '?') ? substr($reqpage, 0, strpos($reqpage, '?')) : $reqpage;

        $vcard_name = $vcard_name == 'vcard11' ? 'vcard11.' . $reqpage : $vcard_name;

        // PWA Support
        $userId = $vcard->user->id;
        $inquiry = getUserSettingValue('enable_attachment_for_inquiry', $userId);
        $contactRequest = getUserSettingValue('ask_details_before_downloading_contact', $userId);
        $enable_pwa = getUserSettingValue('enable_pwa', $userId);
        $pwa_icon = getUserSettingValue('pwa_icon', $userId);
        $pwa_icon = (!$pwa_icon) ? 'logo.png' : str_replace(rtrim(env('APP_URL'), '/'), '', $pwa_icon);
        // notifation
        // if(getUserSettingValue('notifation_enable',$userId)){
        //     config([
        //         'app.one_signal_app_id' => getUserSettingValue('onesignal_app_id',$userId),
        //         'onesignal.app_id' => getUserSettingValue('onesignal_app_id',$userId),
        //         'onesignal.rest_api_key' => getUserSettingValue('onesignal_rest_api_key',$userId),
        //     ]);
        // }

        $pwa_name = $vcard->url_alias;

        $path = public_path('pwa/1.json');
        $json = json_decode(file_get_contents($path), true);
        $json['name'] = $pwa_name;
        $json['short_name'] = $pwa_name;
        $json['start_url'] = route('vcard.show', ['alias' => $vcard->url_alias]);
        if (isset($userSetting['enable_pwa']) && $userSetting['enable_pwa'] == "1") {
            $json['display'] = "fullscreen";
        } else {
            unset($json['display']);
        }
        $json['icons'] = [
            [
                "src" => $pwa_icon,
                "sizes" => "512x512",
                "type" => "image/png",
                "purpose" => "any maskable",
            ],
        ];
        file_put_contents($path, json_encode($json));

        $businessDaysTime = [];

        if ($vcard->businessHours->count()) {
            $dayKeys = [1, 2, 3, 4, 5, 6, 7];
            $openDayKeys = [];
            $openDays = [];
            $closeDays = [];

            foreach ($vcard->businessHours as $key => $openDay) {
                $openDayKeys[] = $openDay->day_of_week;
                $openDays[$openDay->day_of_week] = $openDay->start_time . ' - ' . $openDay->end_time;
            }

            $closedDayKeys = array_diff($dayKeys, $openDayKeys);

            foreach ($closedDayKeys as $closeDayKey) {
                $closeDays[$closeDayKey] = null;
            }

            $businessDaysTime = $openDays + $closeDays;
            ksort($businessDaysTime);
        }
        $customQrCode = QrcodeEdit::whereTenantId($vcard->user->tenant_id)->where('vcard_id', $vcard->id)->pluck('value', 'key')->toArray();

        if ($customQrCode == null) {
            $customQrCode['qrcode_color'] = '#000000';
            $customQrCode['background_color'] = '#ffffff';
        }
        $qrcodeColor['qrcodeColor'] = Hex::fromString($customQrCode['qrcode_color'])->toRgb();
        $qrcodeColor['background_color'] = Hex::fromString($customQrCode['background_color'])->toRgb();

        if (empty(getLocalLanguage())) {
            $alias = $vcard->url_alias;
            $languageName = $vcard->default_language;
            session(['languageChange_' . $alias => $languageName]);
            setLocalLang(getLocalLanguage());
        }

        if ($vcard->status) {

            $templateId = $vcard->template_id;
            $templateName = $vcard->template->name;

            $viewPath = '';
            $templateFile = '';

            if ($templateId >= 1 && $templateId <= 38) {
                // IDs 1-38: Use vcardTemplates directory with database name
                $viewPath = 'vcardTemplates';
                $templateFile = $templateName;

                // Handle special case for vcard11 page variations
                if ($templateName == 'vcard11') {
                    $templateFile = 'vcard11.' . $reqpage;
                }

            } elseif ($templateId >= 39 && $templateId <= 64) {
                // IDs 39-64: Use oldVcardTemplates directory
                $viewPath = 'oldVcardTemplates';

                // Remove 'oldVcard' prefix and keep only the number part
                $templateFile = str_replace('oldVcard', 'vcard', $templateName); // e.g., oldVcard12 -> vcard12

            } else {
                // IDs 65+: Use vcardTemplates directory with database name
                $viewPath = 'vcardTemplates';
                $templateFile = $templateName;
            }

            return view(
                $viewPath . '.' . $templateFile,
                compact(
                    'vcard',
                    'setting',
                    'url',
                    'appointmentDetail',
                    'banners',
                    'managesection',
                    'userSetting',
                    'currency',
                    'paymentMethod',
                    'blogSingle',
                    'businessDaysTime',
                    'customQrCode',
                    'qrcodeColor',
                    'vcardProducts',
                    'dynamicVcard',
                    'instagramEmbed',
                    'iframes',
                    'inquiry',
                    'customLink',
                    'contactRequest',
                    'enable_pwa',
                    'vcardUrl',
                    'vcardProductUrl',
                    'isCustomDomainUse',
                    'customDomain',
                    'vcardPrivacyAndTerm',
                    'vcard11Contact',
                    'vcard11Blog',
                    'vcard11PrivacyPolicy',
                    'vcard11TermAndCondition',
                )
            );
        }
        abort('404');
    }

    public function checkPassword(Request $request, Vcard $vcard): JsonResponse
    {
        setLocalLang(checkLanguageSession($vcard->url_alias));

        if (Crypt::decrypt($vcard->password) == $request->password) {
            session(['password_' => '1']);

            return $this->sendSuccess(__('messages.placeholder.password_is_correct'));
        }

        return $this->sendError(__('messages.placeholder.password_invalid'));
    }

    /**
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function edit(Vcard $vcard, Request $request)
    {
        $partName = ($request->part === null) ? 'basics' : $request->part;

        if ($partName !== TermCondition::TERM_CONDITION && $partName !== PrivacyPolicy::PRIVACY_POLICY) {
            if (! checkFeature($partName)) {
                return redirect(route('vcards.edit', $vcard->id));
            }
        }

        $data = $this->vcardRepository->edit($vcard);
        $data['partName'] = $partName;
        $appointmentDetail = AppointmentDetail::where('vcard_id', $vcard->id)->first();
        $banners = Banner::where('vcard_id', $vcard->id)->first();
        $privacyPolicy = PrivacyPolicy::where('vcard_id', $vcard->id)->first();
        $termCondition = TermCondition::where('vcard_id', $vcard->id)->first();
        $managesection = VcardSections::where('vcard_id', $vcard->id)->first();
        $dynamicVcard = DynamicVcard::where('vcard_id', $vcard->id)->first();
        $instagramEmbed = AppointmentDetail::where('vcard_id', $vcard->id)->first();
        $iframes = Iframe::where('vcard_id', $vcard->id)->first();
        $customLink = CustomLink::where('vcard_id', $vcard->id)->first();
        static $settings;
        if (empty($settings)) {
            $settings = Setting::all()->keyBy('key');
        }
        $favicon = $settings['favicon'];
        $adminFavicon = $favicon->favicon_url;

        return view('vcards.edit', compact('appointmentDetail', 'privacyPolicy', 'termCondition', 'iframes', 'managesection', 'instagramEmbed', 'banners', 'dynamicVcard', 'customLink','adminFavicon',))->with($data);
    }

    public function updateStatus(Vcard $vcard): JsonResponse
    {
        if ($vcard->status == 0) {
            $user = getLogInUser();
            $vCards = Vcard::where('tenant_id', $user->tenant_id)->where('status', 1)->get();
            $limitOfVcards = Subscription::whereTenantId($user->tenant_id)->where('status', Subscription::ACTIVE)->latest()->first()->no_of_vcards;
            if ($limitOfVcards <= $vCards->count()) {
                return $this->sendError(__('messages.vcard.you_have_reached_vcard_limit'));
            }
        }
        $vcard->update([
            'status' => ! $vcard->status,
        ]);

        return $this->sendSuccess(__('messages.flash.vcard_status'));
    }


    public function update(UpdateVcardRequest $request, Vcard $vcard): RedirectResponse
    {
        if ($request->favicon_img) {
            $imageSize = getimagesize($request->favicon_img);
            $width = $imageSize[0];
            $height = $imageSize[1];

            if ($width > 16 && $height > 16) {
                Flash::error(__('messages.placeholder.favicon_invalid'));

                return redirect()->back();
            }
        }
        $request->except('url_alias');
        $input = $request->all();

        $edit_alias_url = getSuperAdminSettingValue('url_alias');
        if ($edit_alias_url == 0 && isset($input['url_alias']) && $input['url_alias'] != $vcard->url_alias) {
            Flash::error(__('messages.flash.url_alias'));
            return redirect()->back();
        }

        $vcard = $this->vcardRepository->update($input, $vcard);

        if ($vcard) {
            Session::flash('success', ' ' . __('messages.flash.vcard_update'));
        }
        // $userId = getLogInUserId();
        // if(getUserSettingValue('notifation_enable',$userId)){
        //     config([
        //         'app.one_signal_app_id' => getUserSettingValue('onesignal_app_id',$userId),
        //         'onesignal.app_id' => getUserSettingValue('onesignal_app_id',$userId),
        //         'onesignal.rest_api_key' => getUserSettingValue('onesignal_rest_api_key',$userId),
        //     ]);
        //     sendVcardNotifications($vcard->id);
        // }
        if (isset($input['part'])) {
        if($input['part'] == 'basics'){
            return redirect()->route('vcards.edit', ['vcard' => $vcard->id, 'part' => 'basics2']);
        }
        if($input['part'] == 'basics2'){
            return redirect()->route('vcards.edit', ['vcard' => $vcard->id, 'part' => 'basics3']);
        }
        }
        return redirect()->back();
    }

    public function destroy(Vcard $vcard): JsonResponse
    {
        $termCondition = TermCondition::whereVcardId($vcard->id)->first();

        if (! empty($termCondition)) {
            $termCondition->delete();
        }

        $privacyPolicy = PrivacyPolicy::whereVcardId($vcard->id)->first();

        if (! empty($privacyPolicy)) {
            $privacyPolicy->delete();
        }

        $vcard->clearMediaCollection(Vcard::PROFILE_PATH);
        $vcard->clearMediaCollection(Vcard::COVER_PATH);
        $vcard->delete();

        $data['make_vcard'] = $this->vcardRepository->checkTotalVcard();

        return $this->sendResponse($data, __('messages.flash.vcard_delete'));
    }

    public function getAvailableDays(Request $request): JsonResponse
    {
        try {
            $vcardId = $request->get('vcardId');

            if (!$vcardId) {
                return $this->sendError(__('messages.placeholder.invalid_request_parameters'));
            }

            $availableWeekdays = Appointment::where('vcard_id', $vcardId)
                ->distinct()
                ->pluck('day_of_week')
                ->toArray();

            return $this->sendResponse($availableWeekdays, 'Available days retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError(__('messages.placeholder.something_went_wrong'));
        }
    }

    public function getSlot(Request $request): JsonResponse
    {
        $day = $request->get('day');
        $slots = getSchedulesTimingSlot();
        $html = view('vcards.appointment.slot', ['slots' => $slots, 'day' => $day])->render();

        return $this->sendResponse($html, 'Retrieved successfully.');
    }

    public function getSession(Request $request): JsonResponse
    {
        try {
            setLocalLang(getLocalLanguage());


            $vcardId = $request->get('vcardId');
            $appointmentDate = $request->date;

            if (!$vcardId || !$appointmentDate) {
                return $this->sendError(__('messages.placeholder.invalid_request_parameters'));
            }

            $buttonStyle = DynamicVcard::where('vcard_id', $vcardId)->value('button_style');
            $date = \Carbon\Carbon::parse($appointmentDate);
            $dayOfWeek = $date->dayOfWeek == 0 ? 7 : $date->dayOfWeek;

            $weekDaySessions = Appointment::where('day_of_week', $dayOfWeek)
                ->where('vcard_id', $vcardId)
                ->get();

            if ($weekDaySessions->isEmpty()) {
                return $this->sendError(__('messages.placeholder.there_is_not_available_slot'));
            }

            $bookedAppointments = ScheduleAppointment::where('vcard_id', $vcardId)
                ->whereDate('date', $appointmentDate)
                ->get();

            $userId = Vcard::with('user')->find($vcardId)->user->id;
            $timeFormat = getUserSettingValue('time_format', $userId) == UserSetting::HOUR_24 ? 'H:i' : 'h:i A';

            $bookedSlot = $bookedAppointments->map(function ($appointment) use ($timeFormat) {
                return date($timeFormat, strtotime($appointment->from_time)) . ' - ' . date($timeFormat, strtotime($appointment->to_time));
            })->toArray();

            $bookingSlot = $weekDaySessions->map(function ($session) use ($timeFormat) {
                if ($timeFormat == 'H:i') {
                    $startTime = substr($session->start_time, 0, 5);
                    $endTime = substr($session->end_time, 0, 5);
                } else {
                    $startTime = substr($session->start_time, 0, 8);
                    $endTime = substr($session->end_time, 0, 8);
                }
                return date($timeFormat, strtotime($startTime)) . ' - ' . date($timeFormat, strtotime($endTime));
            })->toArray();

            $availableSlots = array_diff($bookingSlot, $bookedSlot);

            if (empty($availableSlots)) {
                return $this->sendError(__('messages.placeholder.there_is_not_available_slot'));
            }

            $buttonStyle = $buttonStyle ?? '';

            return $this->sendResponse($availableSlots, $buttonStyle, 'Retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError(__('messages.placeholder.something_went_wrong'));
        }
    }

    public function language($languageName, $alias)
    {
        $currentLanguage = getLocalLanguage();
        session(['languageChange_' . $alias => $languageName]);
        setLocalLang(getLocalLanguage());

        return $this->sendSuccess(__('messages.flash.language_update', [], $currentLanguage));
    }

    /**
     * @return Application|Factory|View
     */
    public function analytics(Vcard $vcard, Request $request): \Illuminate\View\View
    {
        $input = $request->all();
        $data = $this->vcardRepository->analyticsData($input, $vcard);
        $partName = ($request->part === null) ? 'overview' : $request->part;

        return view('vcards.analytic', compact('vcard', 'partName', 'data'));
    }

    public function chartData(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $data = $this->vcardRepository->chartData($input);

            return $this->sendResponse($data, 'Users fetch successfully.');
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function dashboardChartData(Request $request)
    {
        try {
            $input = $request->except('_');
            $data = $this->vcardRepository->dashboardChartData($input);

            return $this->sendResponse($data, 'Data fetch successfully.');
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function showBlog($alias, $id): \Illuminate\View\View
    {
        setLocalLang(getLocalLanguage());
        $blog = VcardBlog::with('vcard:id,template_id,name')->whereRelation('vcard', 'url_alias', '=', $alias)
            ->whereRelation('vcard', 'status', '=', 1)
            ->where('id', $id)
            ->firstOrFail();
        $dynamicVcard = DynamicVcard::where('vcard_id', $blog->vcard_id)->first();

        $templateId = $blog->vcard->template_id;

        // Choose blog template based on template ID
        if ($templateId >= 39 && $templateId <= 64) {
            // IDs 39-64: Use old blog template
            return view('vcards.oldTheme.blog', compact('blog', 'dynamicVcard'));
        } else {
            // IDs 1-38 and 65+: Use new blog template
            return view('vcards.blog', compact('blog', 'dynamicVcard'));
        }

    }

    /**
     * @return Application|Factory|View
     */
    public function showPrivacyPolicy($alias, $id)
    {
        $vacrdTemplate = vcard::find($id);
        setLocalLang(getLocalLanguage());
        $privacyPolicy = PrivacyPolicy::with('vcard')->where('vcard_id', $id)->first();
        $termCondition = TermCondition::with('vcard')->where('vcard_id', $id)->first();
        $dynamicVcard = DynamicVcard::with('vcard')->where('vcard_id', $id)->first();

        $customDomain = CustomDomain::where('user_id', Auth::id())->first();
        $isCustomDomainUse = $customDomain ? $customDomain->is_use_vcard : false;
        $vcardUrl = $isCustomDomainUse ? "https://{$customDomain->domain}/{$alias}" : route('vcard.show', ['alias' => $alias]);

        if ($vacrdTemplate->template_id == 11) {
            return redirect()->route('vcard.show.privacy-policy', [$alias, $id]);
            // return view('vcardTemplates.vcard11.portfolio', compact('privacyPolicy', 'alias', 'termCondition'));
        }

        $templateId = $vacrdTemplate->template_id;
        if ($templateId >= 39 && $templateId <= 64) {
            return view('vcards.oldTheme.privacy-policy', compact('privacyPolicy', 'vcardUrl', 'termCondition', 'dynamicVcard', 'vacrdTemplate'));
        } else {
            return view('vcards.privacy-policy', compact('privacyPolicy', 'vcardUrl', 'termCondition', 'dynamicVcard', 'vacrdTemplate'));
        }
    }

    public function duplicateVcard($id): JsonResponse
    {
        try {
            $vcard = Vcard::with([
                'services',
                'testimonials',
                'products',
                'blogs',
                'privacy_policy',
                'term_condition',
                'socialLink',
                'customeLink',
                'banners',
                'iframes',
                'InstagramEmbed',
                'Qrcode',
            ])->where('id', $id)->first();
            $this->vcardRepository->getDuplicateVcard($vcard);

            return $this->sendSuccess(__('messages.common.duplicate_vcard_create'));
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function getUniqueUrlAlias()
    {
        return getUniqueVcardUrlAlias();
    }

    public function checkUniqueUrlAlias($urlAlias)
    {
        $isUniqueUrl = isUniqueVcardUrlAlias($urlAlias);
        if ($isUniqueUrl === true) {
            return $this->sendResponse(['isUnique' => true], 'URL Alias is available to use.');
        }

        $response = ['isUnique' => false, 'usedInVcard' => $isUniqueUrl];

        return $this->sendResponse($response, 'This URL Alias is already in use');
    }

    public function addContact(Vcard $vcard)
    {
        ini_set('memory_limit', '-1');

        $vcfVcard = new VCardVCard();
        $lastname = $vcard->last_name;
        $firstname = $vcard->first_name;
        $vcfVcard->addName($lastname, $firstname);
        $vcfVcard->addCompany($vcard->company);
        $vcfVcard->addJobtitle($vcard->job_title);

        if (! empty($vcard->email)) {
            $vcfVcard->addEmail($vcard->email);
        }

        if (! empty($vcard->alternative_email)) {
            $vcfVcard->addEmail($vcard->alternative_email, 'EMAIL;type=Alternate Email');
        }

        if (! empty($vcard->phone)) {
            $vcfVcard->addPhoneNumber('+' . $vcard->region_code . $vcard->phone, 'TEL;type=CELL');
        }
        if (! empty($vcard->alternative_phone)) {
            $vcfVcard->addPhoneNumber('+' . $vcard->alternative_region_code . $vcard->alternative_phone, 'TEL;type=Alternate Phone');
        }

        $vcfVcard->addAddress($vcard->location);
        if (! empty($vcard->location_url)) {
            $vcfVcard->addURL($vcard->location_url, 'TYPE=Location URL');
        }

        $socialLinks = SocialLink::whereVcardId($vcard->id)->first()->toArray();
        $customSocialLinks = SocialIcon::with('media')->whereSocialLinkId($socialLinks['id'])->get();
        unset($socialLinks['id']);
        unset($socialLinks['media']);
        unset($socialLinks['created_at']);
        unset($socialLinks['updated_at']);
        unset($socialLinks['social_icon']);
        unset($socialLinks['vcard_id']);

        foreach ($customSocialLinks as $link) {
            $socialLinks = array_merge($socialLinks, [$link->media[0]['name'] => $link->link]);
        }

        foreach ($socialLinks as $key => $link) {
            $name = Str::camel($key);
            $vcfVcard->addURL($link, 'TYPE=' . $name);
        }

        $vcfVcard->addURL(URL::to($vcard->url_alias));

        if ($media = $vcard->getMedia(\App\Models\Vcard::PROFILE_PATH)->first()) {
            $vcfVcard->addPhotoContent(file_get_contents($media->getFullUrl()));
        }

        return \Response::make(
            $vcfVcard->getOutput(),
            200,
            $vcfVcard->getHeaders(true)
        );
    }

    public function showProducts($id, $alias)
    {
        $vcard = Vcard::with([
            'businessHours' => function ($query) {
                $query->where('end_time', '!=', '00:00');
            },
            'services',
            'testimonials',
            'products',
            'blogs',
            'privacy_policy',
            'term_condition',
            'user',
        ])->whereUrlAlias($alias)->first();

        $userSetting = UserSetting::where('user_id', $vcard->user->id)->pluck('value', 'key')->toArray();

        $vcardProducts = $vcard->products->sortDesc()->take(6);

        $products =  Product::with('vcard')->whereVcardId($id)->get();
        $template_id = $products->first()->vcard->template_id;
        $customLink = CustomLink::where('vcard_id', $vcard->id)->get();

        $customDomain = CustomDomain::where('user_id', Auth::id())->first();
        $isCustomDomainUse = $customDomain ? $customDomain->is_use_vcard : false;
        $vcardUrl = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}" : route('vcard.show', ['alias' => $vcard->url_alias]);
        $vcardPrivacyAndTerm = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}/privacy-policy/{$vcard->id}" : route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]);

        if ($vcard->status) {

            $template = \App\Models\Template::find($template_id);
            $templateName = $template->name;

            $viewPath = '';

            if ($template_id >= 39 && $template_id <= 64) {
                // Old templates (IDs 39-64):
                $fileName = str_replace('oldVcard', 'vcard', $templateName);
                $viewPath = 'oldVcardTemplates/oldThemeProducts/' . $fileName;
            } else {
                // New templates (IDs 1-38 and 65+):
                $viewPath = 'vcardTemplates/products/' . $templateName;
            }

            return view(
                $viewPath,
                compact(
                    'vcard',
                    'vcardProducts',
                    'customLink',
                    'products',
                    'userSetting',
                    'vcardUrl',
                    'vcardPrivacyAndTerm'
                )
            );
        }
    }

    public function deleteAccount()
    {
        setLocalLang(getCurrentLanguageName());
        return view('vcards.delete_account');
    }

    public function getCookie(Request $request)
    {
        $fullUrl = $request->url;
        $urlWithoutDomain = trim(parse_url($fullUrl, PHP_URL_PATH), '/');
        $vcard = Vcard::whereUrlAlias($urlWithoutDomain)->first();
        $valuedata = 5 * 1000;
        if ($vcard) {
            $user = $vcard->user;
            if ($user) {
                $value = getUserSettingValue('subscription_model_time', $user->id);
                $timeValue = empty($value) ? 5 : $value;
                $valuedata = intval($timeValue) * 1000;
            }
        }

        return $this->sendResponse($valuedata, '');
    }


    public function emailSubscriprionStore(CreateEmailSubscribersRequest $request)
    {
        $input = $request->all();

        VcardEmailSubscription::create($input);

        return $this->sendSuccess(__('messages.flash.email_send'));
    }
    public function showSubscribers(Vcard $vcard)
    {
        $vcardId = $vcard->id;
        return view('vcards.vcard-subscribers', compact('vcardId'));
    }
    public function showContact(Vcard $vcard)
    {
        $vcardId = $vcard->id;
        return view('vcards.vcard-contact', compact('vcardId'));
    }

    public function vcardViewType(Request $request): JsonResponse
    {
        $viewType = $request->input('vcard_table_view_type');
        $user = getLogInUser();
        $user->update(['vcard_table_view_type' => $viewType]);
        return $this->sendSuccess(__('messages.vcard_table_view_changed'));
    }

    public function servicesSliderView(Vcard $vcard): JsonResponse
    {
        if ($vcard) {
            $vcard->services_slider_view = !$vcard->services_slider_view;
            $vcard->save();
            return $this->sendSuccess(__('messages.flash.services_slider_view'));
        }
        return $this->sendError('Something went wrong', 200);
    }

    public function cloneTo(Vcard $vcard)
    {
        $users = User::role('admin')
            ->where('tenant_id', '!=', $vcard->user->tenant_id)
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->full_name];
            })
            ->toArray();

        $data = [
            'vcard' => $vcard,
            'users' => $users
        ];

        return $this->sendResponse($data,  'Vcard Retrieved Successfully.');
    }

    public function sadminDuplicateVcard($id, $userId = null): JsonResponse
    {
        try {
            $vcard = Vcard::with([
                'services',
                'testimonials',
                'products',
                'blogs',
                'privacy_policy',
                'term_condition',
                'socialLink',
                'customeLink',
                'banners',
                'iframes',
                'InstagramEmbed',
                'Qrcode',
            ])->where('id', $id)->first();
            $this->vcardRepository->getDuplicateVcard($vcard, $userId);

            return $this->sendSuccess(__('messages.common.duplicate_vcard_create'));
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function downloadVcardContactsPdf($vcardId)
    {
        $vcard = Vcard::findOrFail($vcardId);
        $contacts = ContactRequest::where('vcard_id', $vcardId)->get();

        $appLogo = getLogoUrl();
        $appName = getAppName();
        $address = getSuperAdminSettingValue('address');
        $companyLogo = (string) \Image::make($appLogo)->encode('data-url');

        $pdf = Pdf::loadView('vcards.contact.vcard-contacts-pdf', compact('vcard', 'contacts', 'companyLogo', 'appName', 'address'));

        return $pdf->download('vcard-contacts-' . $vcardId . '.pdf');
    }

    public function downloadVcardContactsXls($vcardId)
    {
        return Excel::download(new ContactRequestExport($vcardId), 'vcard-contacts-' . $vcardId . '.xlsx');
    }

    public function generateAiDescription(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $userApiKey = getUserSettingValue('openai_api_key', getLogInUserId());
        $envApiKey = env('OPENAI_API_KEY');

        $apiKey = !empty($userApiKey) ? $userApiKey : $envApiKey;

        if (empty($apiKey)) {
            return $this->sendError(__('messages.vcard.openai_api_key_not_set'));
        }

        $model = getUserSettingValue('open_ai_model', getLogInUserId());

        if (empty($model)) {
            return $this->sendError(__('messages.vcard.open_ai_model_not_configured'));
        }

        if(getUserSettingValue('open_ai_enable',getLogInUserId()) == 0){
            return $this->sendError(__('messages.vcard.open_ai_not_enabled'));
        }
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant that writes professional, engaging, and concise vCard descriptions for business cards.Write a description of maximum 255 characters. The text should be suitable for direct use in a rich text editor (Quill). You may use HTML formatting tags like <b>, <strong>, <i>, <em>, <u>, <br> and do not wrap the description in any quotation marks, stars, or symbols. Just return the plain HTML content.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->prompt,
                    ],
                ],
            ]);

            if ($response->failed()) {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? __('messages.vcard.open_ai_api_error');

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ], $response->status());
            }

            $responseData = $response->json();
            $description = trim($responseData['choices'][0]['message']['content'] ?? '');

            if (empty($description)) {
                return response()->json([
                'success' => false,
                'message' => __('messages.vcard.generated_description_is_empty'),
                ], 500);
            }

            return response()->json([
                'success' => true,
                'description' => $description,
            ]);

        } catch (\Exception $e) {
            return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            ], 500);
        }
    }
}
