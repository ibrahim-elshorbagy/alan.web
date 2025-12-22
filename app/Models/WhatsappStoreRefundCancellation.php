<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsappStoreRefundCancellation extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_store_refund_cancellation';

    protected $fillable = [
        'whatsapp_store_id',
        'refund_cancellation_policy',
    ];

    protected $casts = [
        'refund_cancellation_policy' => 'string',
        'whatsapp_store_id' => 'integer',
    ];

    public static $rules = [
        'refund_cancellation_policy' => 'required',
        'whatsapp_store_id' => 'required',
    ];

    public function whatsappStore(): BelongsTo
    {
        return $this->belongsTo(WhatsappStore::class, 'whatsapp_store_id');
    }

}
