<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IframeController;
use App\Http\Controllers\NfcOrdersController;
use App\Http\Controllers\CustomLinkController;
use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\SocialAuthController;
use App\Http\Controllers\API\Admin\SeoAPIController;
use App\Http\Controllers\API\Admin\BlogAPIController;
use App\Http\Controllers\API\Admin\FontAPIController;
use App\Http\Controllers\API\Admin\GroupAPIController;
use App\Http\Controllers\API\Admin\VcardAPIController;
use App\Http\Controllers\AffiliationWithdrawController;
use App\Http\Controllers\API\Admin\BannerAPIController;
use App\Http\Controllers\API\Admin\IframeAPIController;
use App\Http\Controllers\API\RegistrationAPIController;
use App\Http\Controllers\API\Admin\EnquiryAPIController;
use App\Http\Controllers\API\Admin\GalleryAPIController;
use App\Http\Controllers\API\Admin\NfcCardAPIController;
use App\Http\Controllers\API\Admin\ProductAPIController;
use App\Http\Controllers\API\Admin\ServiceAPIController;
use App\Http\Controllers\API\Admin\SettingAPIController;
use App\Http\Controllers\API\Admin\InstaEmbedAPIController;
use App\Http\Controllers\API\Admin\AffiliationAPIController;
use App\Http\Controllers\API\Admin\AppointmentAPIController;
use App\Http\Controllers\API\Admin\SocialLinksAPIController;
use App\Http\Controllers\API\Admin\TestimonialsAPIController;
use App\Http\Controllers\API\SuperAdmin\ProfileAPIController;
use App\Http\Controllers\API\Admin\BusinessHoursAPIController;
use App\Http\Controllers\API\Admin\ManageSectionAPIController;
use App\Http\Controllers\API\Admin\PrivacyAndTermAPIController;
use App\Http\Controllers\API\SuperAdmin\DashboardAPIController;
use App\Http\Controllers\API\Admin\SubscriptionPlanAPIController;
use App\Http\Controllers\API\Admin\VcardAppointmentAPIController;
use App\Http\Controllers\API\Admin\BusinessAPIController as AdminBusinessAPIController;
use App\Http\Controllers\API\Admin\DashboardAPIController as AdminDashboardAPIController;
use App\Http\Controllers\API\Admin\FlutterwaveAPIController;
use App\Http\Controllers\API\Admin\MercadoPagoAPIController;
use App\Http\Controllers\API\Admin\PayfastAPIController;
use App\Http\Controllers\API\Admin\PaypalAPIController;
use App\Http\Controllers\API\Admin\PaystackAPIController;
use App\Http\Controllers\API\Admin\RazorpayAPIController;
use App\Http\Controllers\API\Admin\StripeAPIController;
use App\Http\Controllers\API\Admin\WhatsappStoreAPIController;
use App\Http\Controllers\API\Admin\WPBusinessHoursAPIController;
use App\Http\Controllers\API\Admin\WPFontAPIController;
use App\Http\Controllers\API\Admin\WPProductAPIController;
use App\Http\Controllers\API\Admin\WPProductCategoryAPIController;
use App\Http\Controllers\API\Admin\WPProductOrderAPIController;
use App\Http\Controllers\API\SuperAdmin\AddOnAPIController;
use App\Http\Controllers\API\Admin\WPTrendingVideoAPIController;
use App\Http\Controllers\API\SuperAdmin\GroupsAPIController as SuperAdminGroupsAPIController;
use App\Http\Controllers\API\SuperAdmin\VcardsAPIController as SuperAdminVcardsAPIController;
use App\Http\Controllers\API\SuperAdmin\BusinessAPIController as SuperAdminBusinessAPIController;
use App\Http\Controllers\API\SuperAdmin\GoogleWalletAPIController;
use App\Http\Controllers\API\SuperAdmin\SlackIntegrationAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [RegistrationAPIController::class, 'register']);
Route::post('login', [AuthAPIController::class, 'login']);
Route::post('/login/google', [SocialAuthController::class, 'googleLogin']);
Route::post(
    '/forgot-password',
    [AuthAPIController::class, 'sendPasswordResetLinkEmail']
)->middleware('throttle:5,1')->name('password.email');
Route::post(
    '/password',
    [AuthAPIController::class, 'resetPassword']
)->middleware('throttle:5,1')->name('set.password');
Route::post('/reset-password', [AuthAPIController::class, 'changePassword'])->name('password.reset');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthAPIController::class, 'logout']);

    Route::middleware('role:super_admin')->group(function () {

        //Super Admin Dashboard
        Route::get('dashboard', [DashboardAPIController::class, 'index']);
        Route::get('income-chart', [DashboardAPIController::class, 'incomeChartData']);
    });

    Route::prefix('admin')->middleware('role:admin')->group(function () {

        //Admin Dashboard
        Route::get('dashboard', [AdminDashboardAPIController::class, 'index']);
        Route::get('today-appointment', [AdminDashboardAPIController::class, 'todayAppointment']);
        Route::get('income-chart', [AdminDashboardAPIController::class, 'incomeChartData']);

        //Appointments
        Route::get('appointment', [AppointmentAPIController::class, 'appointmentsData']);
        Route::get('appointment/{scheduleAppointments}', [AppointmentAPIController::class, 'appointment']);
        Route::post('appointment-completed/{scheduleAppointmentsId}', [AppointmentAPIController::class, 'appointmentCompleted']);
        Route::delete('appointment-delete/{scheduleAppointments}', [AppointmentAPIController::class, 'deleteAppointment']);

        //Setting
        Route::get('settings-edit', [SettingAPIController::class, 'editSettings']);
        Route::post('settings-update', [SettingAPIController::class, 'updateSettings']);

        //Enquiry
        Route::get('enquiries', [EnquiryAPIController::class, 'enquiryData']);
        Route::get('enquiries/{enquiry}', [EnquiryAPIController::class, 'enquiry']);
        Route::delete('enquiries-delete/{enquiry}', [EnquiryAPIController::class, 'deleteEnquiry']);

        //Vcard
        Route::post('create-vcard', [VcardAPIController::class, 'vcardCreate']);
        Route::post('vcard/{vcard}', [VcardAPIController::class, 'vcardBasicDetails']);
        Route::get('vcard', [VcardAPIController::class, 'vcardData']);
        Route::get('vcard/{vcard}', [VcardAPIController::class, 'vcard']);
        Route::delete('vcard-delete/{vcard}', [VcardAPIController::class, 'deleteVcard']);
        Route::get('vcard-appointment/{vcard}', [VcardAPIController::class, 'appointmentVcard']);
        Route::get('vcard-enquires/{vcard}', [VcardAPIController::class, 'enquiresVcard']);
        Route::post('vcard/template/{vcard}', [VcardAPIController::class, 'vcardTemplate']);
        Route::get('vcard-basic-details/{vcard}', [VcardAPIController::class, 'getVcardBasicDetails']);
        Route::get('vcard-templates/{vcard}', [VcardAPIController::class, 'getVcardTemplate']);

        //Groups
        Route::post('groups-create', [GroupAPIController::class, 'groupCreate']);
        Route::get('groups', [GroupAPIController::class, 'groupData']);
        Route::delete('group-delete/{groupId}', [GroupAPIController::class, 'deleteGroup']);

        //BusinessCard
        Route::post('business-cards-create', [AdminBusinessAPIController::class, 'creatBusinessCard']);
        Route::get('business-cards', [AdminBusinessAPIController::class, 'businessCardData']);

        //Subscription Plan
        Route::get('subscription-plan', [SubscriptionPlanAPIController::class, 'subscriptionPlan']);
        Route::get('payment-is-pending', [SubscriptionPlanAPIController::class, 'paymentStatus']);
        Route::post('plans-buy/{plan}', [SubscriptionPlanAPIController::class, 'buyPlan']);

        //User Delete
        Route::delete('/delete-user/{user}', [AuthAPIController::class, 'userDelete']);

        //vCard Business Hours
        Route::post('business-hours', [BusinessHoursAPIController::class, 'store']);
        Route::get('business-hours/{vcard}', [BusinessHoursAPIController::class, 'getBusinessHours']);

        //vCard Product
        Route::post('products', [ProductAPIController::class, 'store']);
        Route::post('products/{product}', [ProductAPIController::class, 'update']);
        Route::get('products/{product}', [ProductAPIController::class, 'show']);
        Route::get('vcard-products/{vcard}', [ProductAPIController::class, 'getVcardProducts']);
        Route::delete('products/{product}', [ProductAPIController::class, 'destroy']);
        Route::get('currency-list', [ProductAPIController::class, 'getCurrencyList']);

        //vCard Services
        Route::post('services', [ServiceAPIController::class, 'store']);
        Route::post('services/{service}', [ServiceAPIController::class, 'update']);
        Route::get('services/{service}', [ServiceAPIController::class, 'show']);
        Route::get('vcard-services/{vcard}', [ServiceAPIController::class, 'getVcardProducts']);
        Route::delete('services/{service}', [ServiceAPIController::class, 'destroy']);
        Route::post("services/service-slider/{vcard}", [ServiceAPIController::class, 'servicesSliderView']);

        //vCard social links
        Route::post('social-links', [SocialLinksAPIController::class, 'store']);
        Route::get('social-links/{vcard}', [SocialLinksAPIController::class, 'getSocialLinks']);

        //vCard Advanced Settings
        Route::post('advanced-settings', [VcardAPIController::class, 'storeAdvanceDetails']);
        Route::get('advanced-settings/{vcard}', [VcardAPIController::class, 'getAdvanceDetails']);

        //vCard Appoitment
        Route::post('vcard-appointments', [VcardAppointmentAPIController::class, 'storeAppoitmentSchedule']);
        Route::get('vcard-appointments/{vcard}', [VcardAppointmentAPIController::class, 'getAppoitmentSchedule']);

        //vCard Testimonials
        Route::get('testimonials/{testimonials}', [TestimonialsAPIController::class, 'show']);
        Route::get('vcard-testimonials/{vcard}', [TestimonialsAPIController::class, 'getVcardTestimonials']);
        Route::post('testimonials', [TestimonialsAPIController::class, 'store']);
        Route::post('testimonials/{testimonials}', [TestimonialsAPIController::class, 'update']);
        Route::delete('testimonials/{testimonials}', [TestimonialsAPIController::class, 'destroy']);

        //vCard Blogs
        Route::get('blogs/{blog}', [BlogAPIController::class, 'show']);
        Route::get('vcard-blogs/{vcard}', [BlogAPIController::class, 'getVcardBlogs']);
        Route::post('blogs', [BlogAPIController::class, 'store']);
        Route::post('blogs/{blog}', [BlogAPIController::class, 'update']);
        Route::delete('blogs/{blog}', [BlogAPIController::class, 'destroy']);

        //vCard Fonts
        Route::get('fonts/{vcard}', [FontAPIController::class, 'getVcardFonts']);
        Route::post('fonts', [FontAPIController::class, 'store']);
        Route::get('fonts', [FontAPIController::class, 'getFontList']);

        //vCard Privacy Policies
        Route::get('privacy-policies/{vcard}', [PrivacyAndTermAPIController::class, 'getPrivacyPolicy']);
        Route::post('privacy-policies', [PrivacyAndTermAPIController::class, 'storePrivacyPolicy']);

        //vCard Terms & Conditions
        Route::get('terms-conditions/{vcard}', [PrivacyAndTermAPIController::class, 'getTermsConditions']);
        Route::post('terms-conditions', [PrivacyAndTermAPIController::class, 'storeTermsConditions']);

        //Enquires
        Route::get('enquires', [VcardAPIController::class, 'enquiresData']);
        Route::get('enquires/{enquire}', [VcardAPIController::class, 'getEnquiresDetails']);
        Route::delete('enquires/{enquire}', [VcardAPIController::class, 'deleteEnquiry']);

        //customize QR Code
        Route::get('qr-code/{vcard}', [VcardAPIController::class, 'qrcodeVcard']);
        Route::post('qr-code/{vcard}', [VcardAPIController::class, 'updateQrCode']);

        //Insta Embed CURD
        Route::get('/get-insta-embed/{vcard}', [InstaEmbedAPIController::class, 'getInstaEmbed']);
        Route::post('/store-insta-embed', [InstaEmbedAPIController::class, 'storeInstaEmbed']);
        Route::post('/update-insta-embed/{id}', [InstaEmbedAPIController::class, 'update']);
        Route::get('/insta-embed/{id}', [InstaEmbedAPIController::class, 'show']);
        Route::delete('/delete-insta-embed/{id}', [InstaEmbedAPIController::class, 'destroy']);

        //Gallery CURD
        Route::get("gallery-list/{vcard}", [GalleryAPIController::class, 'getGalleryList']);
        Route::get('gallery/{gallery}', [GalleryAPIController::class, 'getGallery']);
        Route::post('gallery', [GalleryAPIController::class, 'store']);
        Route::post('gallery/{gallery}', [GalleryAPIController::class, 'update']);
        Route::delete('gallery/{id}', [GalleryAPIController::class, 'destroy']);

        //IFrames CURD
        Route::get("iframe-list/{vcard}", [IframeController::class, 'getIframeList']);
        Route::get('iframe/{iframe}', [IframeController::class, 'edit']);
        Route::post('iframe', [IframeController::class, 'store']);
        Route::post('iframe/{iframe}', [IframeController::class, 'update']);
        Route::delete('iframe/{iframe}', [IframeController::class, 'destroy']);

        //Banner
        Route::get('banner/{vcard}',[BannerAPIController::class,'getBanner']);
        Route::post('update-banner',[BannerAPIController::class,'updateBanner']);

        //SEO
        Route::get('seo/{vcard}',[SeoAPIController::class,'getSeo']);
        Route::post('update-seo',[SeoAPIController::class,'updateSeo']);

        //Manage Section
        Route::get('manage-section/{vcard}',[ManageSectionAPIController::class,'getManageSection']);
        Route::post('update-manage-section',[ManageSectionAPIController::class,'updateManageSection']);

        //Product Orders
        Route::get('product-orders/{id?}',[ProductAPIController::class,'getProductOrders']);

        //Affiliation
        Route::get("get-affiliation", [AffiliationAPIController::class, 'getAffiliation']);
        Route::get("get-affiliation-list", [AffiliationAPIController::class, 'getAffiliationList']);
        Route::get("withdrawal-list", [AffiliationAPIController::class, 'getWithdrawalList']);
        Route::post("withdrawa-request", [AffiliationWithdrawController::class, 'withdrawAmount']);
        Route::get("show-withdrawa-request/{id}", [AffiliationWithdrawController::class, 'showAffiliationWithdraw']);

        //NFC Cards
        Route::get('nfc-cards/{id?}', [NfcCardAPIController::class, 'getNfcCardList']);
        Route::get('order-nfc', [NfcCardAPIController::class, 'getNfc']);
        Route::post('order-nfc', [NfcOrdersController::class, 'store']);
        Route::get('vcard-list', [NfcCardAPIController::class, 'getVcardList']);
        Route::get('payment-types', [NfcCardAPIController::class, 'getPaymentTypes']);

        //Storage
        Route::get('storage', [VcardAPIController::class, 'getStorageData']);

        //payment configuration
        Route::get('payment-config', [SettingAPIController::class, 'getPaymentConfig']);
        Route::post('payment-config', [SettingAPIController::class, 'updatePaymentConfig']);

        //custom links
        Route::get('custom-links/{vcard}', [CustomLinkController::class, 'getCustomLink']);
        Route::post('custom-link', [CustomLinkController::class, 'store']);
        Route::get('custom-link/{customLink}', [CustomLinkController::class, 'edit']);
        Route::post('update-custom-link/{id}', [CustomLinkController::class, 'update']);
        Route::delete('custom-link/{customLink}', [CustomLinkController::class, 'destroy']);
        Route::post('custom-link/{customLink}/toggle-show-as-button', [CustomLinkController::class, 'updateShowAsButton']);
        Route::post('custom-link/{customLink}/toggle-open-new-tab', [CustomLinkController::class, 'updateOpenNewTab']);

        //manage Subscription
        Route::get('manage-subscription', [VcardAPIController::class, 'getManageSubscription']);

        //razorpay
        Route::get('razorpay-onboard', [RazorpayAPIController::class, 'onBoard']);
        Route::post('razorpay-payment-success', [RazorpayAPIController::class, 'paymentSuccess']);

        //stripe
        Route::get('stripe-onboard', [StripeAPIController::class, 'onBoard'])->name('stripe.onboard');
        Route::match(['GET', 'POST'], 'stripe-payment-success', [StripeAPIController::class, 'paymentSuccess'])->name('stripe.success');
        Route::get('stripe-payment-cancel', [StripeAPIController::class, 'paymentCancel'])->name('stripe.cancel');

        //Flutterwave
        Route::post('flutterwave-subscription', [FlutterwaveAPIController::class, 'onBoard']);
        Route::get('flutterwave-subscription-success', [FlutterwaveAPIController::class, 'flutterwavePaymentSuccess']);

        //Paystack
        Route::post('paystack-onboard', [PaystackAPIController::class, 'redirectToGateway']);
        Route::match(['GET', 'POST'], 'paystack-subscription-success', [PaystackAPIController::class, 'paymentSuccess'])->name('paystack.subscription.success');

        //Paypal
        Route::post('paypal-onboard', [PaypalAPIController::class, 'onBoard'])->name('paypal.subscription.init');
        Route::match(['GET', 'POST'], 'paypal-subscription-success', [PaypalAPIController::class, 'paymentSuccess'])->name('paypal.subscription.success');
        Route::match(['GET', 'POST'], 'paypal-subscription-failed', [PaypalAPIController::class, 'paymentFailed'])   ->name('paypal.subscription.failed');

        //payfast
        // Route::get('payfast-onboard', [PayfastAPIController::class, 'onBoard'])->name('payfast.onboard');
        Route::post('payfast-onboard', [PayfastAPIController::class, 'onBoard'])->name('payfast.subscription.init');
        Route::get('payfast-payment-success', [PayfastAPIController::class, 'paymentSuccess'])->name('payfast.success');
        Route::get('payfast-payment-cancel', [PayfastAPIController::class, 'paymentCancel'])->name('payfast.cancel');
        Route::post('payfast-payment-notify', [PayFastAPIController::class, 'notify'])->name('payfast.notify');

        //Mercado Pago
        Route::get('mercadopago-onboard', [MercadoPagoAPIController::class, 'onBoard'])->name('mercadopago.onboard');
        Route::post('mercadopago-subscription-success', [MercadoPagoAPIController::class, 'paymentSuccess'])->name('mercadopago.success');

        //super admin payment gateway credentials
        Route::get('super-admin-payment-config', [SettingAPIController::class, 'getSuperAdminPaymentConfig']);

        //whatsapp store
        Route::post('create-whatsapp-store', [WhatsappStoreAPIController::class, 'wpCreate']);
        Route::get('whatsapp-store', [WhatsappStoreAPIController::class, 'whatsappStoreData']);
        Route::get('whatsapp-store/{whatsappStore}', [WhatsappStoreAPIController::class, 'editBasicDetails']);
        Route::post('whatsapp-store/{whatsappStore}', [WhatsappStoreAPIController::class, 'updateBasicDetails']);
        Route::get('whatsapp-store-template', [WhatsappStoreAPIController::class, 'getWhatsappStoreTemplate']);
        Route::get('whatsapp-store/template/{whatsappStore}', [WhatsappStoreAPIController::class, 'editWpTemplate']);
        Route::post('whatsapp-store/template/{whatsappStore}', [WhatsappStoreAPIController::class, 'wpTemplate']);
        Route::delete('whatsapp-store-delete/{whatsappStore}', [WhatsappStoreAPIController::class, 'deleteWhatsappStore']);
        Route::post('whatsapp-store-status/{whatsappStore}', [WhatsappStoreAPIController::class, 'updateStatus']);

        //Whatsapp Store Business Hours
        Route::post('wp-business-hours', [WPBusinessHoursAPIController::class, 'store']);
        Route::get('wp-business-hours/{whatsappStore}', [WPBusinessHoursAPIController::class, 'getBusinessHours']);

        //Whatsapp Store Product Category
        Route::get('wp-product-category/{whatsappStore}', [WPProductCategoryAPIController::class, 'getVcardProductCategories']);
        Route::post('wp-product-category', [WPProductCategoryAPIController::class, 'store']);
        Route::get('wp-product-category-edit/{productCategory}', [WPProductCategoryAPIController::class, 'edit']);
        Route::post('wp-product-category/{whatsappStore}/update', [WPProductCategoryAPIController::class, 'update']);
        Route::delete('wp-product-category/{whatsappStore}', [WPProductCategoryAPIController::class, 'destroy']);

        //Whatsapp Store Advanced
        Route::post('wp-advanced-settings', [WhatsappStoreAPIController::class, 'storeAdvanceDetails']);
        Route::get('wp-advanced-settings/{whatsappStore}', [WhatsappStoreAPIController::class, 'getAdvanceDetails']);

        //Whatsapp Store Fonts
        Route::get('wp-fonts/{whatsappStore}', [WPFontAPIController::class, 'getVcardFonts']);
        Route::post('wp-fonts', [WPFontAPIController::class, 'store']);
        Route::get('wp-fonts', [WPFontAPIController::class, 'getFontList']);

        //Whatsapp Store SEO
        Route::get('wp-seo/{whatsappStore}',[WhatsappStoreAPIController::class,'getSeo']);
        Route::post('wp-update-seo',[WhatsappStoreAPIController::class,'updateSeo']);

        //Whatsapp Store Product
        Route::get('wp-product/{whatsappStore}', [WPProductAPIController::class,'getProductList']);
        Route::post('wp-product', [WPProductAPIController::class, 'store']);
        Route::get('wp-product-edit/{product}', [WPProductAPIController::class,'edit']);
        Route::post('wp-product/{product}/update', [WPProductAPIController::class, 'update']);
        Route::delete('wp-product/{product}', [WPProductAPIController::class, 'destroy']);

        //Whatsapp Store Product Orders
        Route::get('wp-product-order/{whatsappStore}', [WPProductOrderAPIController::class,'getProductOrdersList']);
        Route::post('wp-order/{wpOrder}/status', [WPProductOrderAPIController::class, 'updateOrderStatus']);
        Route::delete('wp-product-order/{wpOrder}', [WPProductOrderAPIController::class, 'destroy']);

        //Whatsapp Store Trending Video
        Route::get('wp-trending-videos/{whatsappStore}', [WPTrendingVideoAPIController::class, 'getTrendingVideos']);
        Route::post('wp-trending-video', [WPTrendingVideoAPIController::class, 'store']);
        Route::post('wp-trending-video/update', [WPTrendingVideoAPIController::class, 'updateMultiple']);
        Route::delete('wp-trending-video/{id}/delete', [WPTrendingVideoAPIController::class, 'delete']);
    });

    //Vcards
    Route::get('vcard', [SuperAdminVcardsAPIController::class, 'vcardsData']);
    Route::get('vcard/{vcard}', [SuperAdminVcardsAPIController::class, 'vcard']);
    Route::get('vcard-qrcode/{vcard}', [SuperAdminVcardsAPIController::class, 'qrcodeVcard']);

    //Profile
    Route::get('profile-edit', [ProfileAPIController::class, 'editProfile']);
    Route::post('profile-update', [ProfileAPIController::class, 'updateProfile']);
    Route::post('language-update', [ProfileAPIController::class, 'updateLanguage']);

    //Groups
    Route::post('groups-create', [SuperAdminGroupsAPIController::class, 'groupCreate']);
    Route::get('groups', [SuperAdminGroupsAPIController::class, 'groupData']);
    Route::delete('group-delete/{groupId}', [SuperAdminGroupsAPIController::class, 'deleteGroup']);

    //BusinessCard
    Route::post('business-cards-create', [SuperAdminBusinessAPIController::class, 'createBusinessCard']);
    Route::get('business-cards', [SuperAdminBusinessAPIController::class, 'businessCardData']);

    //Add Ons
    Route::get('add-ons', [AddOnAPIController::class, 'addOnsData']);
    Route::post('add-on/{id}/update', [AddOnAPIController::class, 'update'])->name('addon.update');
    Route::post('/addon-extract-zip', [AddOnAPIController::class, 'extractZip'])->name('addOn.extractZip');
    Route::delete('/add-on-delete/{id}', [AddOnAPIController::class, 'destroy'])->name('addOn.delete');

    //Slack Integration AddOns
    if (moduleExists('SlackIntegration'))
    {
        Route::get('/slack-integration', [SlackIntegrationAPIController::class, 'edit'])->name('slack_integration.index');
        Route::put('/slack-integration', [SlackIntegrationAPIController::class, 'update'])->name('slack_integration.update');
    }

    //Google Wallet Addons
    if (moduleExists('GoogleWallet'))
    {
        Route::get('google-wallet', [GoogleWalletAPIController::class, 'index'])->name('google-wallet.index');
        Route::post('google-wallet/genrate-card', [GoogleWalletAPIController::class, 'genrateCard'])->name('google-wallet-genrate-card');
        // Route::get('google-wallet/create', [GoogleWalletAPIController::class, 'create'])->name('google-wallet.create');
        // Route::get('google-wallet-link', [GoogleWalletAPIController::class, 'googleWalletLink'])->name('google-wallet-link');
    }
});
