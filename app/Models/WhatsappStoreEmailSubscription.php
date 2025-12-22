<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsappStoreEmailSubscription extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_store_email_subscriptions';

    protected $fillable = [
        'whatsapp_store_id',
        'email',
    ];

    protected $casts = [
        'email' => 'string',
        'whatsapp_store_id' => 'integer',
    ];

    public static $rules = [
        'email' => 'required|email',
    ];

    public function whatsappStore(): BelongsTo
    {
        return $this->belongsTo(WhatsappStore::class, 'whatsapp_store_id');
    }
}
