<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsappStorePrivacyPolicy extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_store_privacy_policies';

    protected $fillable = [
        'whatsapp_store_id',
        'privacy_policy',
    ];

    protected $casts = [
        'privacy_policy' => 'string',
        'whatsapp_store_id' => 'integer',
    ];

    public static $rules = [
        'privacy_policy' => 'required',
        'whatsapp_store_id' => 'required',
    ];

    public function whatsappStore(): BelongsTo
    {
        return $this->belongsTo(WhatsappStore::class, 'whatsapp_store_id');
    }

}
