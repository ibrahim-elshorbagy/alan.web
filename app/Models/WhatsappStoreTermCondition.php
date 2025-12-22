<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsappStoreTermCondition extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_store_term_conditions';

    protected $fillable = [
        'whatsapp_store_id',
        'term_condition',
    ];

    protected $casts = [
        'term_condition' => 'string',
        'whatsapp_store_id' => 'integer',
    ];

    public static $rules = [
        'term_condition' => 'required',
        'whatsapp_store_id' => 'required',
    ];

    public function whatsappStore(): BelongsTo
    {
        return $this->belongsTo(WhatsappStore::class, 'whatsapp_store_id');
    }

}
