<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Product;
use App\Models\Template;
use Laracasts\Flash\Flash;
use App\Models\WpOrderItem;
use Illuminate\Support\Str;
use App\Models\BusinessHour;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\WhatsappStore;
use App\Models\ProductCategory;
use App\Models\WpStoreTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\WhatsappStoreProduct;
use App\Http\Requests\WpProductBuyRequest;
use App\Models\WhatsappStoreTrendingVideo;
use App\Models\WhatsappStorePrivacyPolicy;
use App\Models\WhatsappStoreTermCondition;
use App\Models\WhatsappStoreShippingDelivery;
use App\Repositories\WhatsappStoreRepository;
use App\Models\WhatsappStoreEmailSubscription;
use App\Models\WhatsappStoreRefundCancellation;
use App\Http\Requests\CreateWhatsappStoreRequest;
use App\Http\Requests\UpdateWhatsappStoreRequest;
use App\Http\Requests\CreateWhatsappStoreEmailSubscribersRequest;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use App\Models\QrcodeEdit;
use Spatie\Color\Hex;

class WhatsappStoreController extends AppBaseController
{
  private WhatsappStoreRepository $whatsappStoreRepository;

  public function __construct(WhatsappStoreRepository $whatsappStoreRepository)
  {
    $this->whatsappStoreRepository = $whatsappStoreRepository;
  }

  public function index(Request $request)
  {
    $partName = $request->part;

    if ($partName === null) {
      return view('whatsapp_stores.index');
    }

    return view('whatsapp_stores.create', compact('partName'));
  }

  public function store(CreateWhatsappStoreRequest $request)
  {
    $input = $request->all();

    $whatsappStore = $this->whatsappStoreRepository->store($input);

    Flash::success(__('messages.flash.whatsapp_store_create'));

    return redirect(route('whatsapp.stores.edit', [$whatsappStore->id]));
  }

  public function edit(WhatsappStore $whatsappStore, Request $request)
  {
    $isWhatsappStoreAllowed = getPlanFeature(getCurrentSubscription()->plan)['whatsapp_store'];

    if (!$isWhatsappStoreAllowed) {
      abort(404);
    }

    $access = $whatsappStore->tenant_id == getLogInTenantId();

    if (!$access) {
      abort(404);
    }

    $partName = ($request->part === null) ? 'basics' : $request->part;

    $templates = WpStoreTemplate::all()->pluck('path', 'id')->toArray();

    $productsCategories = ProductCategory::where('whatsapp_store_id', $whatsappStore->id)->pluck('name', 'id')->toArray();

    $termCondition = $whatsappStore->termCondition;
    $privacyPolicy = $whatsappStore->privacyPolicy;
    $refundCancellation = $whatsappStore->refundCancellation;
    $shippingDelivery = $whatsappStore->shippingDelivery;


    return view('whatsapp_stores.edit', compact('whatsappStore', 'partName', 'productsCategories', 'templates', 'termCondition', 'privacyPolicy', 'refundCancellation', 'shippingDelivery'));
  }

  public function show($alias)
  {
    $whatsappStore = WhatsappStore::where('url_alias', $alias)->first();

    if ($whatsappStore === null || $whatsappStore->status == 0) {
      abort(404);
    }

    if (empty(getLocalLanguage())) {
      $alias = $whatsappStore->url_alias;
      $languageName = $whatsappStore->default_language;
      session(['languageChange_' . $alias => $languageName]);
      setLocalLang(getLocalLanguage());
    }

    $whatsappStoreUrl = route('whatsapp.store.show', ['alias' => $alias]);
    $user = User::whereTenantId($whatsappStore->tenant_id)->first();
    $userId = $user->id;
    $enable_pwa = getUserSettingValue('enable_pwa', $userId);
    $hide_sticky_bar = $whatsappStore->hide_stickybar;
    $news_letter_popup =  $whatsappStore->news_letter_popup;
    $business_hours = $whatsappStore->business_hours;

    $businessDaysTime = [];

    if (!empty($whatsappStore->businessHours) && $whatsappStore->businessHours->count()) {
      $dayKeys = [1, 2, 3, 4, 5, 6, 7];
      $openDayKeys = [];
      $openDays = [];
      $closeDays = [];

      foreach ($whatsappStore->businessHours as $key => $openDay) {
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

    // Get global QR code settings (same as VcardController)
    $customQrCode = QrcodeEdit::whereTenantId($whatsappStore->tenant_id)
      ->where('is_global', true)
      ->whereNull('vcard_id')
      ->whereNull('whatsapp_store_id')
      ->pluck('value', 'key')
      ->toArray();

    // If no global settings, use defaults
    if (empty($customQrCode)) {
      $customQrCode['qrcode_color'] = '#000000';
      $customQrCode['background_color'] = '#ffffff';
      $customQrCode['style'] = 'square';
      $customQrCode['eye_style'] = 'square';
      $customQrCode['applySetting'] = '1';
    }

    $qrcodeColor['qrcodeColor'] = Hex::fromString($customQrCode['qrcode_color'])->toRgb();
    $qrcodeColor['background_color'] = Hex::fromString($customQrCode['background_color'])->toRgb();

    return view('whatsapp_stores.templates.' . $whatsappStore->template->name . '.index', compact('whatsappStore', 'enable_pwa', 'news_letter_popup', 'business_hours', 'businessDaysTime', 'hide_sticky_bar', 'whatsappStoreUrl', 'customQrCode', 'qrcodeColor'));
  }

  public function update(WhatsappStore $whatsappStore, UpdateWhatsappStoreRequest $request)
  {
    $input = $request->all();

    $whatsappStore = $this->whatsappStoreRepository->update($whatsappStore, $input);

    Flash::success(__('messages.flash.whatsapp_store_update'));

    return redirect(route('whatsapp.stores.edit', [$whatsappStore->id]));
  }

  public function destroy($id)
  {
    $whatsappStore = WhatsappStore::findOrFail($id);

    if ($whatsappStore->tenant_id != getLogInTenantId()) {
      return $this->sendError('Unauthorized.');
    }

    $whatsappStore->clearMediaCollection(WhatsappStore::LOGO);
    $whatsappStore->clearMediaCollection(WhatsappStore::COVER_IMAGE);
    $whatsappStore->delete();

    return $this->sendSuccess(__('messages.flash.whatsapp_store_delete'));
  }

  public function wpTemplateUpate(WhatsappStore $whatsappStore, Request $request)
  {

    $whatsappStore->update(['template_id' => $request->template_id]);

    return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));
  }

  public function updateStatus(WhatsappStore $whatsappStore): JsonResponse
  {
    if ($whatsappStore->status == 0) {
      $user = getLogInUser();

      $activeWhatsappStores = WhatsappStore::where('tenant_id', $user->tenant_id)
        ->where('status', 1)
        ->get();

      $limitOfWhatsappStore = Subscription::whereTenantId($user->tenant_id)
        ->where('status', Subscription::ACTIVE)
        ->latest()
        ->first()
        ->no_of_whatsapp_store;

      if ($limitOfWhatsappStore <= $activeWhatsappStores->count()) {
        return $this->sendError(__('messages.whatsapp_stores_templates.you_have_reached_whatsapp_store_limit'));
      }
    }

    $whatsappStore->update([
      'status' => !$whatsappStore->status,
    ]);

    return $this->sendSuccess(__('messages.flash.whatsapp_store_status'));
  }

  public function wpTemplateSEOUpdate(WhatsappStore $whatsappStore, Request $request)
  {
    $data = $request->only([
      'template_id',
      'site_title',
      'home_title',
      'meta_keyword',
      'meta_description',
      'google_analytics',
    ]);

    $whatsappStore->update($data);

    return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));
  }

  public function wpTemplateAdvanceUpdate(WhatsappStore $whatsappStore, Request $request)
  {
    $data = $request->only([
      'custom_css',
      'custom_js',
    ]);

    $whatsappStore->update($data);

    return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));
  }

  public function wpTemplateCustomFontUpdate(WhatsappStore $whatsappStore, Request $request)
  {
    $request->validate([
      'font_family' => 'string',
      'font_size' => 'nullable|numeric|min:14|max:40',
    ]);

    $data = $request->only([
      'font_family',
      'font_size',
    ]);

    $whatsappStore->update($data);

    return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));
  }

  public function wpTemplateTrendingVideoUpdate(WhatsappStore $whatsappStore, Request $request)
  {
    $request->validate([
      'youtube_links' => 'nullable|array',
      'youtube_links.*' => 'nullable|string|url',
      'youtube_link_id' => 'nullable|array',
      'youtube_link_id.*' => 'nullable|integer',
    ]);

    try {
      DB::beginTransaction();

      if ($request->has('youtube_links')) {
        $youtubeLinks = $request->youtube_links ?? [];
        $youtubeLinkIds = $request->youtube_link_id ?? [];
        $totalFields = count($youtubeLinks);

        // Get existing records
        $existingRecords = $whatsappStore->trendingVideo()->get();
        $existingIds = $existingRecords->pluck('id')->toArray();

        // Process based on field count
        $processedIds = [];

        foreach ($youtubeLinks as $index => $youtubeLink) {
          $linkId = $youtubeLinkIds[$index] ?? null;
          $trimmedLink = trim($youtubeLink);

          // Handle single empty field (nullable case)
          if ($totalFields === 1 && empty($trimmedLink)) {
            if ($linkId) {
              // Delete existing record for single empty field
              WhatsappStoreTrendingVideo::where('id', $linkId)->delete();
              $processedIds[] = $linkId;
            }
            continue;
          }

          // Skip empty fields in multiple field scenario
          if (empty($trimmedLink)) {
            continue;
          }

          if ($linkId && !empty($linkId)) {
            // Update existing record
            $existing = $existingRecords->firstWhere('id', $linkId);
            if ($existing && $existing->youtube_link !== $trimmedLink) {
              $existing->update(['youtube_link' => $trimmedLink]);
            }
            $processedIds[] = $linkId;
          } else {
            // Create new record
            $whatsappStore->trendingVideo()->create([
              'youtube_link' => $trimmedLink
            ]);
          }
        }

        // Delete records that were not processed (removed from form)
        $idsToDelete = array_diff($existingIds, $processedIds);
        if (!empty($idsToDelete)) {
          $whatsappStore->trendingVideo()->whereIn('id', $idsToDelete)->delete();
        }
      }

      DB::commit();
      return $this->sendSuccess(__('messages.flash.trending_video_update'));
    } catch (\Exception $e) {
      DB::rollback();
      return $this->sendError($e->getMessage());
    }
  }

  public function showProducts($alias, $categoryId = null)
  {
    $whatsappStore = WhatsappStore::where('url_alias', $alias)->where('status', 1)->first();
    if (!$whatsappStore) {
      abort(404);
    }

    if (empty(getLocalLanguage())) {
      $alias = $whatsappStore->url_alias;
      $languageName = $whatsappStore->default_language;
      session(['languageChange_' . $alias => $languageName]);
      setLocalLang(getLocalLanguage());
    }


    $template = $whatsappStore->template->name;
    if ($whatsappStore === null) {
      abort(404);
    }
    return view('whatsapp_stores.templates.' . $template . '.products', compact('whatsappStore', 'categoryId'));
  }

  public function productDetails($alias, $id)
  {
    $whatsappStore = WhatsappStore::where('url_alias', $alias)->where('status', 1)->first();
    if (!$whatsappStore) {
      abort(404);
    }
    $product = WhatsappStoreProduct::where('id', $id)->whereHas('whatsappStore', function ($query) use ($whatsappStore) {
      $query->where('id', $whatsappStore->id);
    })->first();

    if (!$product) {
      abort(404);
    }

    if (empty(getLocalLanguage())) {
      $alias = $whatsappStore->url_alias;
      $languageName = $whatsappStore->default_language;
      session(['languageChange_' . $alias => $languageName]);
      setLocalLang(getLocalLanguage());
    }


    $template = $whatsappStore->template->name;

    return view('whatsapp_stores.templates.' . $template . '.product-details', compact('whatsappStore', 'product'));
  }

  public function analytics(WhatsappStore $whatsappStore, Request $request): \Illuminate\View\View
  {
    $input = $request->all();
    $data = $this->whatsappStoreRepository->analyticsData($input, $whatsappStore);
    $partName = ($request->part === null) ? 'overview' : $request->part;

    return view('whatsapp_stores.analytic', compact('whatsappStore', 'partName', 'data'));
  }

  public function chartData(Request $request): JsonResponse
  {
    try {
      $input = $request->all();
      $data = $this->whatsappStoreRepository->chartData($input);

      return $this->sendResponse($data, 'Users fetch successfully.');
    } catch (Exception $e) {
      throw new UnprocessableEntityHttpException($e->getMessage());
    }
  }

  public function emailSubscriprionStore(CreateWhatsappStoreEmailSubscribersRequest $request)
  {
    $input = $request->all();

    WhatsappStoreEmailSubscription::create($input);

    return $this->sendSuccess(__('messages.flash.email_send'));
  }

  public function showSubscribers(WhatsappStore $whatsappStore)
  {
    $whatsappStoreId = $whatsappStore->id;
    return view('whatsapp_stores.whatsappStore-subscribers', compact('whatsappStoreId'));
  }

  public function getCookie(Request $request)
  {
    $fullUrl = $request->url;
    $path = trim(parse_url($fullUrl, PHP_URL_PATH), '/');
    $segments = explode('/', $path);
    $urlAlias = end($segments);
    $whatsappStore = WhatsappStore::where('url_alias', $urlAlias)->first();
    $valuedata = 5 * 1000;
    if ($whatsappStore) {
      $user = User::where('tenant_id', $whatsappStore->tenant_id)->first();
      if ($user) {
        $value = getUserSettingValue('subscription_model_time', $user->id);
        $timeValue = empty($value) ? 5 : $value;
        $valuedata = intval($timeValue) * 1000;
      }
    }

    return $this->sendResponse($valuedata, '');
  }

  public function cloneTo(WhatsappStore $whatsappStore)
  {
    $users = User::role('admin')
      ->where('tenant_id', '!=', $whatsappStore->tenant_id)
      ->get()
      ->mapWithKeys(function ($user) {
        return [$user->id => $user->full_name];
      })
      ->toArray();

    $data = [
      'whatsappStore' => $whatsappStore,
      'users' => $users
    ];

    return $this->sendResponse($data,  'Whatsapp Store Retrieved Successfully.');
  }

  public function sadminDuplicateWhatsappStore($id, $userId = null): JsonResponse
  {
    try {
      $whatsappStore = WhatsappStore::with([
        'products',
        'categories',
      ])->where('id', $id)->first();
      $this->whatsappStoreRepository->getDuplicateVcard($whatsappStore, $userId);

      return $this->sendSuccess(__('messages.common.duplicate_whatsapp_store_create'));
    } catch (Exception $e) {
      throw new UnprocessableEntityHttpException($e->getMessage());
    }
  }

  public function language($languageName, $alias)
  {
    $currentLanguage = getLocalLanguage();
    session(['languageChange_' . $alias => $languageName]);
    setLocalLang(getLocalLanguage());

    return $this->sendSuccess(__('messages.flash.language_update', [], $currentLanguage));
  }


  public function wpBusinessHoursUpate(WhatsappStore $whatsappStore, Request $request)
  {
    $input = $request->all();

    if (isset($input['week_format'])) {
      $whatsappStore->update([
        'week_format' => $input['week_format']
      ]);
    }

    BusinessHour::where('whatsapp_store_id', $whatsappStore->id)->delete();

    if (isset($input['days'])) {
      foreach ($input['days'] as $day) {
        BusinessHour::create([
          'whatsapp_store_id' => $whatsappStore->id,
          'day_of_week' => $day,
          'start_time' => $input['startTime'][$day],
          'end_time' => $input['endTime'][$day],
        ]);
      }
    }

    return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));
  }

  public function wpTermsConditionsUpdate(Request $request, WhatsappStore $whatsappStore)
  {
    $request->validate([
      'term_condition' => 'required|string',
      'privacy_policy' => 'required|string',
      'refund_cancellation' => 'required|string',
      'shipping_delivery' => 'required|string',
    ]);

    DB::beginTransaction();

    try {
      WhatsappStoreTermCondition::updateOrCreate(
        ['whatsapp_store_id' => $whatsappStore->id],
        ['term_condition' => $request->term_condition]
      );

      WhatsappStorePrivacyPolicy::updateOrCreate(
        ['whatsapp_store_id' => $whatsappStore->id],
        ['privacy_policy' => $request->privacy_policy]
      );

      WhatsappStoreRefundCancellation::updateOrCreate(
        ['whatsapp_store_id' => $whatsappStore->id],
        ['refund_cancellation_policy' => $request->refund_cancellation]
      );

      WhatsappStoreShippingDelivery::updateOrCreate(
        ['whatsapp_store_id' => $whatsappStore->id],
        ['shipping_delivery_policy' => $request->shipping_delivery]
      );

      DB::commit();

      return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));
    } catch (Exception $e) {
      DB::rollback();
      throw new UnprocessableEntityHttpException($e->getMessage());
    }
  }

  public function showTermsConditions($alias)
  {
    $whatsappStore = WhatsappStore::where('url_alias', $alias)->where('status', 1)->firstOrFail();
    $termCondition = WhatsappStoreTermCondition::where('whatsapp_store_id', $whatsappStore->id)->first();
    $templateName = $whatsappStore->template->name;
    $viewPath = "whatsapp_stores.templates.{$templateName}.terms_condition.terms_conditions";

    return view($viewPath, compact('whatsappStore', 'termCondition'));
  }

  public function showPrivacyPolicy($alias)
  {
    $whatsappStore = WhatsappStore::where('url_alias', $alias)->where('status', 1)->firstOrFail();
    $privacyPolicy = WhatsappStorePrivacyPolicy::where('whatsapp_store_id', $whatsappStore->id)->first();
    $templateName = $whatsappStore->template->name;
    $viewPath = "whatsapp_stores.templates.{$templateName}.terms_condition.privacy_policy";

    return view($viewPath, compact('whatsappStore', 'privacyPolicy'));
  }

  public function showRefundCancellation($alias)
  {
    $whatsappStore = WhatsappStore::where('url_alias', $alias)->where('status', 1)->firstOrFail();
    $refundCancellation = WhatsappStoreRefundCancellation::where('whatsapp_store_id', $whatsappStore->id)->first();
    $templateName = $whatsappStore->template->name;
    $viewPath = "whatsapp_stores.templates.{$templateName}.terms_condition.refund_policy";

    return view($viewPath, compact('whatsappStore', 'refundCancellation'));
  }

  public function showShippingDelivery($alias)
  {
    $whatsappStore = WhatsappStore::where('url_alias', $alias)->where('status', 1)->firstOrFail();
    $shippingDelivery = WhatsappStoreShippingDelivery::where('whatsapp_store_id', $whatsappStore->id)->first();
    $templateName = $whatsappStore->template->name;
    $viewPath = "whatsapp_stores.templates.{$templateName}.terms_condition.shipping_policy";

    return view($viewPath, compact('whatsappStore', 'shippingDelivery'));
  }

  public function generateAiWhatsappTermsConditions(Request $request)
  {
    $request->validate([
      'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
      'description' => 'required|string|max:500',
    ]);

    // Get OpenAI settings
    $openAiEnable = getSuperAdminSettingValue('open_ai_enable');
    if ($openAiEnable != '1') {
      return $this->sendError(__('messages.vcard.open_ai_not_enabled'));
    }

    $apiKey = getSuperAdminSettingValue('openai_api_key');
    if (empty($apiKey)) {
      return $this->sendError(__('messages.vcard.openai_api_key_not_set'));
    }

    $model = getSuperAdminSettingValue('open_ai_model');
    if (empty($model)) {
      return $this->sendError(__('messages.vcard.open_ai_model_not_configured'));
    }

    $description = $request->description;

    // Get WhatsApp Store language from database
    $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);
    $currentLang = $whatsappStore->default_language ?? 'en';

    // Create language-specific prompt
    if ($currentLang == 'ar') {
      $prompt = "اكتب شروط وأحكام Terms & Conditions احترافية  يسمى '{$description}'. يجب أن تتضمن: استخدام المتجر، المنتجات والخدمات، الطلبات والدفع، المسؤولية، التعديلات. بطول 250-300 كلمة باللغة العربية. استخدم HTML للتنسيق مع عناوين <h3> وفقرات <p>.";
    } else {
      $prompt = "Write professional Terms & Conditions for a WhatsApp store business called '{$description}'. Should include: store usage, products and services, orders and payment, liability, modifications. Length 250-300 words in English. Use HTML formatting with <h3> headings and <p> paragraphs.";
    }

    try {
      $response = \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
      ])->timeout(40)->post('https://api.openai.com/v1/chat/completions', [
        'model' => $model,
        'messages' => [
          [
            'role' => 'system',
            'content' => 'You are a legal content writer that creates terms and conditions. Provide properly formatted HTML content.'
          ],
          [
            'role' => 'user',
            'content' => $prompt,
          ],
        ],
        'max_tokens' => 1000,
        'temperature' => 0.7,
      ]);

      if ($response->failed()) {
        $errorData = $response->json();
        $errorMessage = $errorData['error']['message'] ?? __('messages.vcard.open_ai_api_error');
        return response()->json(['success' => false, 'message' => $errorMessage], $response->status());
      }

      $responseData = $response->json();
      $content = trim($responseData['choices'][0]['message']['content'] ?? '');

      if (empty($content)) {
        return response()->json(['success' => false, 'message' => __('messages.vcard.generated_description_is_empty')], 500);
      }

      return response()->json([
        'success' => true,
        'content' => $content,
        'message' => __('messages.vcard.ai_generated_successfully')
      ]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function generateAiWhatsappPrivacyPolicy(Request $request)
  {
    $request->validate([
      'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
      'description' => 'required|string|max:500',
    ]);

    // Get OpenAI settings
    $openAiEnable = getSuperAdminSettingValue('open_ai_enable');
    if ($openAiEnable != '1') {
      return $this->sendError(__('messages.vcard.open_ai_not_enabled'));
    }

    $apiKey = getSuperAdminSettingValue('openai_api_key');
    if (empty($apiKey)) {
      return $this->sendError(__('messages.vcard.openai_api_key_not_set'));
    }

    $model = getSuperAdminSettingValue('open_ai_model');
    if (empty($model)) {
      return $this->sendError(__('messages.vcard.open_ai_model_not_configured'));
    }

    $description = $request->description;

    // Get WhatsApp Store language from database
    $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);
    $currentLang = $whatsappStore->default_language ?? 'en';

    // Create language-specific prompt
    if ($currentLang == 'ar') {
      $prompt = "اكتب سياسة خصوصية Privacy Policy احترافية  يسمى '{$description}'. يجب أن تتضمن: جمع البيانات، استخدام البيانات، حماية البيانات، مشاركة المعلومات، حقوق المستخدم. بطول 250-300 كلمة باللغة العربية. استخدم HTML للتنسيق مع عناوين <h3> وفقرات <p>.";
    } else {
      $prompt = "Write a professional Privacy Policy for a WhatsApp store business called '{$description}'. Should include: data collection, data usage, data protection, information sharing, user rights. Length 250-300 words in English. Use HTML formatting with <h3> headings and <p> paragraphs.";
    }

    try {
      $response = \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
      ])->timeout(40)->post('https://api.openai.com/v1/chat/completions', [
        'model' => $model,
        'messages' => [
          [
            'role' => 'system',
            'content' => 'You are a legal content writer that creates privacy policies. Provide properly formatted HTML content.'
          ],
          [
            'role' => 'user',
            'content' => $prompt,
          ],
        ],
        'max_tokens' => 1000,
        'temperature' => 0.7,
      ]);

      if ($response->failed()) {
        $errorData = $response->json();
        $errorMessage = $errorData['error']['message'] ?? __('messages.vcard.open_ai_api_error');
        return response()->json(['success' => false, 'message' => $errorMessage], $response->status());
      }

      $responseData = $response->json();
      $content = trim($responseData['choices'][0]['message']['content'] ?? '');

      if (empty($content)) {
        return response()->json(['success' => false, 'message' => __('messages.vcard.generated_description_is_empty')], 500);
      }

      return response()->json([
        'success' => true,
        'content' => $content,
        'message' => __('messages.vcard.ai_generated_successfully')
      ]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function generateAiWhatsappRefundCancellation(Request $request)
  {
    $request->validate([
      'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
      'description' => 'required|string|max:500',
    ]);

    // Get OpenAI settings
    $openAiEnable = getSuperAdminSettingValue('open_ai_enable');
    if ($openAiEnable != '1') {
      return $this->sendError(__('messages.vcard.open_ai_not_enabled'));
    }

    $apiKey = getSuperAdminSettingValue('openai_api_key');
    if (empty($apiKey)) {
      return $this->sendError(__('messages.vcard.openai_api_key_not_set'));
    }

    $model = getSuperAdminSettingValue('open_ai_model');
    if (empty($model)) {
      return $this->sendError(__('messages.vcard.open_ai_model_not_configured'));
    }

    $description = $request->description;

    // Get WhatsApp Store language from database
    $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);
    $currentLang = $whatsappStore->default_language ?? 'en';

    // Create language-specific prompt
    if ($currentLang == 'ar') {
      $prompt = "اكتب سياسة استرجاع وإلغاء Refund & Cancellation Policy احترافية  يسمى '{$description}'. يجب أن تتضمن: شروط الاسترجاع، عملية الإلغاء، المدة الزمنية، الاستثناءات، طريقة الاسترداد. بطول 250-300 كلمة باللغة العربية. استخدم HTML للتنسيق مع عناوين <h3> وفقرات <p>.";
    } else {
      $prompt = "Write a professional Refund & Cancellation Policy for a WhatsApp store business called '{$description}'. Should include: refund conditions, cancellation process, time frame, exceptions, refund method. Length 250-300 words in English. Use HTML formatting with <h3> headings and <p> paragraphs.";
    }

    try {
      $response = \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
      ])->timeout(40)->post('https://api.openai.com/v1/chat/completions', [
        'model' => $model,
        'messages' => [
          [
            'role' => 'system',
            'content' => 'You are a legal content writer that creates refund and cancellation policies. Provide properly formatted HTML content.'
          ],
          [
            'role' => 'user',
            'content' => $prompt,
          ],
        ],
        'max_tokens' => 1000,
        'temperature' => 0.7,
      ]);

      if ($response->failed()) {
        $errorData = $response->json();
        $errorMessage = $errorData['error']['message'] ?? __('messages.vcard.open_ai_api_error');
        return response()->json(['success' => false, 'message' => $errorMessage], $response->status());
      }

      $responseData = $response->json();
      $content = trim($responseData['choices'][0]['message']['content'] ?? '');

      if (empty($content)) {
        return response()->json(['success' => false, 'message' => __('messages.vcard.generated_description_is_empty')], 500);
      }

      return response()->json([
        'success' => true,
        'content' => $content,
        'message' => __('messages.vcard.ai_generated_successfully')
      ]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function generateAiWhatsappShippingDelivery(Request $request)
  {
    $request->validate([
      'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
      'description' => 'required|string|max:500',
    ]);

    // Get OpenAI settings
    $openAiEnable = getSuperAdminSettingValue('open_ai_enable');
    if ($openAiEnable != '1') {
      return $this->sendError(__('messages.vcard.open_ai_not_enabled'));
    }

    $apiKey = getSuperAdminSettingValue('openai_api_key');
    if (empty($apiKey)) {
      return $this->sendError(__('messages.vcard.openai_api_key_not_set'));
    }

    $model = getSuperAdminSettingValue('open_ai_model');
    if (empty($model)) {
      return $this->sendError(__('messages.vcard.open_ai_model_not_configured'));
    }

    $description = $request->description;

    // Get WhatsApp Store language from database
    $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);
    $currentLang = $whatsappStore->default_language ?? 'en';

    // Create language-specific prompt
    if ($currentLang == 'ar') {
      $prompt = "اكتب سياسة شحن وتسليم Shipping & Delivery Policy احترافية  يسمى '{$description}'. يجب أن تتضمن: مناطق الشحن، تكاليف الشحن، أوقات التسليم، طرق الشحن، التتبع، الاستثناءات. بطول 250-300 كلمة باللغة العربية. استخدم HTML للتنسيق مع عناوين <h3> وفقرات <p>.";
    } else {
      $prompt = "Write a professional Shipping & Delivery Policy for a WhatsApp store business called '{$description}'. Should include: shipping areas, shipping costs, delivery times, shipping methods, tracking, exceptions. Length 250-300 words in English. Use HTML formatting with <h3> headings and <p> paragraphs.";
    }

    try {
      $response = \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
      ])->timeout(40)->post('https://api.openai.com/v1/chat/completions', [
        'model' => $model,
        'messages' => [
          [
            'role' => 'system',
            'content' => 'You are a logistics content writer that creates shipping and delivery policies. Provide properly formatted HTML content.'
          ],
          [
            'role' => 'user',
            'content' => $prompt,
          ],
        ],
        'max_tokens' => 1000,
        'temperature' => 0.7,
      ]);

      if ($response->failed()) {
        $errorData = $response->json();
        $errorMessage = $errorData['error']['message'] ?? __('messages.vcard.open_ai_api_error');
        return response()->json(['success' => false, 'message' => $errorMessage], $response->status());
      }

      $responseData = $response->json();
      $content = trim($responseData['choices'][0]['message']['content'] ?? '');

      if (empty($content)) {
        return response()->json(['success' => false, 'message' => __('messages.vcard.generated_description_is_empty')], 500);
      }

      return response()->json([
        'success' => true,
        'content' => $content,
        'message' => __('messages.vcard.ai_generated_successfully')
      ]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function generateAiWhatsappSiteTitle(Request $request)
  {
    $request->validate([
      'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
    ]);

    // Get OpenAI settings
    $openAiEnable = getSuperAdminSettingValue('open_ai_enable');
    if ($openAiEnable != '1') {
      return $this->sendError(__('messages.vcard.open_ai_not_enabled'));
    }

    $apiKey = getSuperAdminSettingValue('openai_api_key');
    if (empty($apiKey)) {
      return $this->sendError(__('messages.vcard.openai_api_key_not_set'));
    }

    $model = getSuperAdminSettingValue('open_ai_model');
    if (empty($model)) {
      return $this->sendError(__('messages.vcard.open_ai_model_not_configured'));
    }

    // Get WhatsApp Store information
    $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);
    $storeName = $whatsappStore->store_name ?? '';
    $storeDescription = $whatsappStore->description ?? '';

    // Validate store data
    if (empty($storeName)) {
      $currentLang = $whatsappStore->default_language ?? 'en';
      $errorMsg = $currentLang == 'ar'
        ? 'الرجاء إضافة اسم المتجر أولاً في علامة التبويب الأساسيات'
        : 'Please add store name first in Basics tab';
      return response()->json(['success' => false, 'message' => $errorMsg], 400);
    }

    // Get language from database
    $currentLang = $whatsappStore->default_language ?? 'en';

    // Create language-specific prompt
    if ($currentLang == 'ar') {
      $prompt = "اكتب عنوان Title لمتجر واتساب، اسم المتجر '{$storeName}'" .
        (!empty($storeDescription) ? " ووصفه '{$storeDescription}'" : "") .
        ". مع التركيز على اسم المتجر بما لا يزيد على 4-5 كلمات. الرد يجب أن يكون العنوان فقط بدون أي إضافات أو علامات ترقيم خاصة.";
    } else {
      $prompt = "Write a Title for a WhatsApp store, store name is '{$storeName}'" .
        (!empty($storeDescription) ? " and description is '{$storeDescription}'" : "") .
        ". Focus on the store name, max 4-5 words. Response should be just the title without any additional text or special punctuation.";
    }

    try {
      $response = \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
      ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
        'model' => $model,
        'messages' => [
          [
            'role' => 'system',
            'content' => 'You are a helpful assistant that creates concise, SEO-friendly titles. Provide only the title text, nothing else.'
          ],
          [
            'role' => 'user',
            'content' => $prompt,
          ],
        ],
        'max_tokens' => 50,
        'temperature' => 0.7,
      ]);

      if ($response->failed()) {
        $errorData = $response->json();
        $errorMessage = $errorData['error']['message'] ?? __('messages.vcard.open_ai_api_error');
        return response()->json(['success' => false, 'message' => $errorMessage], $response->status());
      }

      $responseData = $response->json();
      $title = trim($responseData['choices'][0]['message']['content'] ?? '');
      $title = strip_tags($title);

      if (empty($title)) {
        return response()->json(['success' => false, 'message' => __('messages.vcard.generated_description_is_empty')], 500);
      }

      return response()->json(['success' => true, 'title' => $title]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function generateAiWhatsappHomeTitle(Request $request)
  {
    $request->validate([
      'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
    ]);

    // Get OpenAI settings
    $openAiEnable = getSuperAdminSettingValue('open_ai_enable');
    if ($openAiEnable != '1') {
      return $this->sendError(__('messages.vcard.open_ai_not_enabled'));
    }

    $apiKey = getSuperAdminSettingValue('openai_api_key');
    if (empty($apiKey)) {
      return $this->sendError(__('messages.vcard.openai_api_key_not_set'));
    }

    $model = getSuperAdminSettingValue('open_ai_model');
    if (empty($model)) {
      return $this->sendError(__('messages.vcard.open_ai_model_not_configured'));
    }

    // Get WhatsApp Store information
    $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);
    $storeName = $whatsappStore->store_name ?? '';
    $storeDescription = $whatsappStore->description ?? '';

    // Validate store data
    if (empty($storeName)) {
      $currentLang = $whatsappStore->default_language ?? 'en';
      $errorMsg = $currentLang == 'ar'
        ? 'الرجاء إضافة اسم المتجر أولاً في علامة التبويب الأساسيات'
        : 'Please add store name first in Basics tab';
      return response()->json(['success' => false, 'message' => $errorMsg], 400);
    }

    // Get language from database
    $currentLang = $whatsappStore->default_language ?? 'en';

    // Create language-specific prompt - Focus on description/type
    if ($currentLang == 'ar') {
      $prompt = "اكتب عنوان Title لمتجر واتساب، اسم المتجر '{$storeName}'" .
        (!empty($storeDescription) ? " ووصفه '{$storeDescription}'" : "") .
        ". مع التركيز على نوع المتجر أو المنتجات بما لا يزيد على 4-5 كلمات. الرد يجب أن يكون العنوان فقط بدون أي إضافات أو علامات ترقيم خاصة.";
    } else {
      $prompt = "Write a Title for a WhatsApp store, store name is '{$storeName}'" .
        (!empty($storeDescription) ? " and description is '{$storeDescription}'" : "") .
        ". Focus on the store type or products, max 4-5 words. Response should be just the title without any additional text or special punctuation.";
    }

    try {
      $response = \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
      ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
        'model' => $model,
        'messages' => [
          [
            'role' => 'system',
            'content' => 'You are a helpful assistant that creates concise, SEO-friendly titles. Provide only the title text, nothing else.'
          ],
          [
            'role' => 'user',
            'content' => $prompt,
          ],
        ],
        'max_tokens' => 50,
        'temperature' => 0.7,
      ]);

      if ($response->failed()) {
        $errorData = $response->json();
        $errorMessage = $errorData['error']['message'] ?? __('messages.vcard.open_ai_api_error');
        return response()->json(['success' => false, 'message' => $errorMessage], $response->status());
      }

      $responseData = $response->json();
      $title = trim($responseData['choices'][0]['message']['content'] ?? '');
      $title = strip_tags($title);

      if (empty($title)) {
        return response()->json(['success' => false, 'message' => __('messages.vcard.generated_description_is_empty')], 500);
      }

      return response()->json(['success' => true, 'title' => $title]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function generateAiWhatsappMetaKeyword(Request $request)
  {
    $request->validate([
      'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
    ]);

    // Get OpenAI settings
    $openAiEnable = getSuperAdminSettingValue('open_ai_enable');
    if ($openAiEnable != '1') {
      return $this->sendError(__('messages.vcard.open_ai_not_enabled'));
    }

    $apiKey = getSuperAdminSettingValue('openai_api_key');
    if (empty($apiKey)) {
      return $this->sendError(__('messages.vcard.openai_api_key_not_set'));
    }

    $model = getSuperAdminSettingValue('open_ai_model');
    if (empty($model)) {
      return $this->sendError(__('messages.vcard.open_ai_model_not_configured'));
    }

    // Get WhatsApp Store information
    $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);
    $storeName = $whatsappStore->store_name ?? '';
    $storeDescription = $whatsappStore->description ?? '';

    // Validate store data
    if (empty($storeName)) {
      $currentLang = $whatsappStore->default_language ?? 'en';
      $errorMsg = $currentLang == 'ar'
        ? 'الرجاء إضافة اسم المتجر أولاً في علامة التبويب الأساسيات'
        : 'Please add store name first in Basics tab';
      return response()->json(['success' => false, 'message' => $errorMsg], 400);
    }

    // Get language from database
    $currentLang = $whatsappStore->default_language ?? 'en';

    // Create language-specific prompt
    if ($currentLang == 'ar') {
      $prompt = "اقترح كلمات مفتاحية SEO لمتجر واتساب اسمه '{$storeName}'" .
        (!empty($storeDescription) ? " ووصفه '{$storeDescription}'" : "") .
        ". اذكر 5-7 كلمات مفتاحية مفصولة بفواصل، مناسبة لمحركات البحث. الرد يجب أن يكون الكلمات المفتاحية فقط مفصولة بفواصل.";
    } else {
      $prompt = "Suggest SEO keywords for a WhatsApp store named '{$storeName}'" .
        (!empty($storeDescription) ? " with description '{$storeDescription}'" : "") .
        ". Provide 5-7 keywords separated by commas, suitable for search engines. Response should be just the keywords separated by commas.";
    }

    try {
      $response = \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
      ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
        'model' => $model,
        'messages' => [
          [
            'role' => 'system',
            'content' => 'You are an SEO expert that creates relevant keywords. Provide only comma-separated keywords, nothing else.'
          ],
          [
            'role' => 'user',
            'content' => $prompt,
          ],
        ],
        'max_tokens' => 100,
        'temperature' => 0.7,
      ]);

      if ($response->failed()) {
        $errorData = $response->json();
        $errorMessage = $errorData['error']['message'] ?? __('messages.vcard.open_ai_api_error');
        return response()->json(['success' => false, 'message' => $errorMessage], $response->status());
      }

      $responseData = $response->json();
      $keywords = trim($responseData['choices'][0]['message']['content'] ?? '');
      $keywords = strip_tags($keywords);

      if (empty($keywords)) {
        return response()->json(['success' => false, 'message' => __('messages.vcard.generated_description_is_empty')], 500);
      }

      return response()->json(['success' => true, 'keywords' => $keywords]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function generateAiWhatsappMetaDescription(Request $request)
  {
    $request->validate([
      'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
    ]);

    // Get OpenAI settings
    $openAiEnable = getSuperAdminSettingValue('open_ai_enable');
    if ($openAiEnable != '1') {
      return $this->sendError(__('messages.vcard.open_ai_not_enabled'));
    }

    $apiKey = getSuperAdminSettingValue('openai_api_key');
    if (empty($apiKey)) {
      return $this->sendError(__('messages.vcard.openai_api_key_not_set'));
    }

    $model = getSuperAdminSettingValue('open_ai_model');
    if (empty($model)) {
      return $this->sendError(__('messages.vcard.open_ai_model_not_configured'));
    }

    // Get WhatsApp Store information
    $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);
    $storeName = $whatsappStore->store_name ?? '';
    $storeDescription = $whatsappStore->description ?? '';

    // Validate store data
    if (empty($storeName)) {
      $currentLang = $whatsappStore->default_language ?? 'en';
      $errorMsg = $currentLang == 'ar'
        ? 'الرجاء إضافة اسم المتجر أولاً في علامة التبويب الأساسيات'
        : 'Please add store name first in Basics tab';
      return response()->json(['success' => false, 'message' => $errorMsg], 400);
    }

    // Get language from database
    $currentLang = $whatsappStore->default_language ?? 'en';

    // Create language-specific prompt
    if ($currentLang == 'ar') {
      $prompt = "اقترح ميتا وصف Meta Description لمتجر واتساب اسمه '{$storeName}'" .
        (!empty($storeDescription) ? " ووصفه '{$storeDescription}'" : "") .
        ". اكتب وصف جذاب لمحركات البحث بحد أقصى 150-160 حرف. الرد يجب أن يكون الوصف فقط.";
    } else {
      $prompt = "Suggest a Meta Description for a WhatsApp store named '{$storeName}'" .
        (!empty($storeDescription) ? " with description '{$storeDescription}'" : "") .
        ". Write an engaging description for search engines, max 150-160 characters. Response should be just the description.";
    }

    try {
      $response = \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
      ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
        'model' => $model,
        'messages' => [
          [
            'role' => 'system',
            'content' => 'You are an SEO expert that creates compelling meta descriptions. Provide only the meta description text, nothing else.'
          ],
          [
            'role' => 'user',
            'content' => $prompt,
          ],
        ],
        'max_tokens' => 150,
        'temperature' => 0.7,
      ]);

      if ($response->failed()) {
        $errorData = $response->json();
        $errorMessage = $errorData['error']['message'] ?? __('messages.vcard.open_ai_api_error');
        return response()->json(['success' => false, 'message' => $errorMessage], $response->status());
      }

      $responseData = $response->json();
      $description = trim($responseData['choices'][0]['message']['content'] ?? '');
      $description = strip_tags($description);

      if (empty($description)) {
        return response()->json(['success' => false, 'message' => __('messages.vcard.generated_description_is_empty')], 500);
      }

      return response()->json(['success' => true, 'description' => $description]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }
}
