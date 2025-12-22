<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Models\Traits\StorageLimit;
use App\Models\WhatsappStoreProduct;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model implements HasMedia
{
    use HasFactory,StorageLimit,InteractsWithMedia,BelongsToTenant;

    const IMAGE = 'category-image';
    protected $fillable = [
        'name',
        'whatsapp_store_id',
        'tenant_id'
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        $media = $this->getMedia(self::IMAGE)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }

    public function products()
    {
        return $this->hasMany(WhatsappStoreProduct::class, 'category_id', 'id');
    }
}
