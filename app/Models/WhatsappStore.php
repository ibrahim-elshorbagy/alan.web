<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Models\Traits\StorageLimit;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsappStore extends Model implements HasMedia
{
    use HasFactory,StorageLimit, InteractsWithMedia, BelongsToTenant;

    const LOGO = 'whatsapp-logo';
    const COVER_IMAGE = 'whatsapp-cover-image';

    protected $fillable = [
        'url_alias',
        'store_name',
        'region_code',
        'whatsapp_no',
        'address',
        'store_id',
        'tenant_id',
        'template_id',
         'site_title',
        'home_title',
        'meta_keyword',
        'meta_description',
        'google_analytics',
        'custom_css',
        'custom_js',
        'font_family',
        'font_size',
        'news_letter_popup',
        'status',
        'default_language',
        'business_hours',
        'hide_stickybar',
        'enable_download_qr_code',
        'qr_code_download_size',
        'slider_video_banner',
        'week_format',
    ];

    protected $appends = [
        'logo_url',
        'cover_url',
    ];

    const FONT_FAMILY = [
        'Poppins' => 'Default',
        'Roboto' => 'Roboto',
        'Times New Roman' => 'Times New Roman',
        'Open Sans' => 'Open Sans',
        'Montserrat' => 'Montserrat',
        'Lato' => 'Lato',
        'Raleway' => 'Raleway',
        'PT Sans' => 'PT Sans',
        'Merriweather' => 'Merriweather',
        'Prompt' => 'Prompt',
        'Work Sans' => 'Work Sans',
        'Concert One' => 'Concert One',
        'Tajawal' => 'تجوال',
        'Cairo' => 'القاهرة',
        'Amiri' => 'أميري',
        'Noto Sans Arabic' => 'نوتو سانز عربي',
        'Noto Naskh Arabic' => 'نوتو نسخ عربي',
        'Noto Kufi Arabic' => 'نوتو كوفي عربي',
        'Scheherazade' => 'شهرزاد',
        'Lateef' => 'لتيف',
        'Harmattan' => 'هرمتان',
        'Reem Kufi' => 'ريم كوفي',
        'Jomhuria' => 'جمهورية',
        'Mada' => 'مدى',
        'Lemonada' => 'ليمونادا',
        'Zain'=>'زين',

    ];

    public function getLogoUrlAttribute()
    {
        $media = $this->getMedia(self::LOGO)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }

    public function getCoverUrlAttribute()
    {
        $media = $this->getMedia(self::COVER_IMAGE)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }

    public function template()
    {
        return $this->belongsTo(WpStoreTemplate::class, 'template_id');
    }

    public function products()
    {
        return $this->hasMany(WhatsappStoreProduct::class, 'whatsapp_store_id');
    }

    public function categories()
    {
        return $this->hasMany(ProductCategory::class, 'whatsapp_store_id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'tenant_id', 'tenant_id');
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(Analytic::class, 'whatsapp_store_id');
    }

    public function businessHours(): HasMany
    {
        return $this->hasMany(BusinessHour::class, 'whatsapp_store_id', 'id');
    }

    public function trendingVideo(): HasMany
    {
        return $this->hasMany(WhatsappStoreTrendingVideo::class, 'whatsapp_store_id', 'id');
    }
    public function termCondition(): HasOne
    {
        return $this->hasOne(WhatsappStoreTermCondition::class, 'whatsapp_store_id');
    }

    public function privacyPolicy(): HasOne
    {
        return $this->hasOne(WhatsappStorePrivacyPolicy::class, 'whatsapp_store_id');
    }

    public function refundCancellation(): HasOne
    {
        return $this->hasOne(WhatsappStoreRefundCancellation::class, 'whatsapp_store_id');
    }

    public function shippingDelivery(): HasOne
    {
        return $this->hasOne(WhatsappStoreShippingDelivery::class, 'whatsapp_store_id');
    }
    public static $rules = [
        'url_alias' => 'required|string|min:8|max:100|unique:whatsapp_stores,url_alias',
        'store_name' => 'required',
        'region_code' => 'required',
        'whatsapp_no' => 'required|numeric',
        'logo' => 'required|file|image|mimes:jpg,png,jpeg|max:1024', // Max 1MB
        'cover_img' => 'required|file|image|mimes:jpg,png,jpeg|max:1024', // Max 1MB
        'slider_video_banner' => 'nullable|url',
    ];
}
