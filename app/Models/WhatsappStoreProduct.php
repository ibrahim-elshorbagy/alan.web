<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Models\Traits\StorageLimit;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsappStoreProduct extends Model implements HasMedia
{
    use HasFactory, StorageLimit,InteractsWithMedia, BelongsToTenant;

    const PRODUCT_IMAGES = 'product-image';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'selling_price',
        'net_price',
        'currency_id',
        'whatsapp_store_id',
        'tenant_id',
        'total_stock',
        'available_stock',
    ];

    protected $appends = [
        'images_url',
    ];

    public function getImagesUrlAttribute()
    {
        $media = $this->getMedia(self::PRODUCT_IMAGES);
        if (!empty($media)) {
            return $media->map(function ($item) {
                return $item->getFullUrl();
            });
        }

        return [];
    }


    public static $rules = [
        'name' => 'required',
        'description' => 'required',
        'category_id' => 'required',
        'selling_price' => 'required',
        'currency_id' => 'required|exists:currencies,id',
        'category_id' => 'required|exists:product_categories,id',
        'total_stock' => 'required',
        'images' => 'required|array|min:1',
        'images.*' => 'image|mimes:jpg,png,jpeg|max:2048',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function whatsappStore()
    {
        return $this->belongsTo(WhatsappStore::class);
    }

    public function ordersItems()
    {
        return $this->hasMany(WpOrderItem::class, 'product_id');
    }

}
