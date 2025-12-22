<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsappStoreShippingDelivery extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_store_shipping_delivery';

    protected $fillable = [
        'whatsapp_store_id',
        'shipping_delivery_policy',
    ];

    protected $casts = [
        'shipping_delivery_policy' => 'string',
        'whatsapp_store_id' => 'integer',
    ];

    public static $rules = [
        'shipping_delivery_policy' => 'required',
        'whatsapp_store_id' => 'required',
    ];

    public function whatsappStore(): BelongsTo
    {
        return $this->belongsTo(WhatsappStore::class, 'whatsapp_store_id');
    }

}
