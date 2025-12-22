<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LinkedinEmbed extends Model
{
    use HasFactory;
        protected $table = 'linkedin_embeds';

    protected $fillable = [
        'type',
        'embedtag',
        'vcard_id',
    ];

    protected $casts = [
        'type' => 'string',
        'embedtag' => 'string',
        'vcard_id' => 'integer',
    ];

    public static $rules = [
        'type' => 'required',
        'embedtag' => 'nullable|required',
    ];

    const TYPE_POST = 0;

    const TYPE = [
        self::TYPE_POST => 'Post',
    ];

    public function vcard(): BelongsTo
    {
        return $this->belongsTo(Vcard::class, 'vcard_id');
    }

    public function getTypeNameAttribute($value): string
    {
        return self::TYPE[$this->type];
    }
}
