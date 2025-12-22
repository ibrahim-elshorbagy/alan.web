<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsappStoreTrendingVideo extends Model
{
    use HasFactory;
    protected $table = 'whatsapp_store_trending_video';
    protected $fillable = [
        'whatsapp_store_id',
        'youtube_link',
    ];

    protected $casts = [
        'whatsapp_store_id' => 'integer',
        'youtube_link' => 'string',
    ];

    public static $rules = [
        'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
        'youtube_link' => 'nullable|url',
    ];

    public function whatsappStore(): BelongsTo
    {
        return $this->belongsTo(WhatsappStore::class, 'whatsapp_store_id');
    }
}
