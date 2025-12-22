<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomLink extends Model
{
    use HasFactory;

    protected $table = 'custom_links';

    protected $fillable = [
        'vcard_id',
        'link_name',
        'show_as_button',
        'open_new_tab',
        'link',
        'button_color',
        'button_type',
    ];

    public static $rules = [
        'link_name' => 'required',
        'link' => 'required|url',
    ];

    const SQUARE = 'square';

    const ROUND = 'rounded';

    const BUTTON_STYLE = [
        self::SQUARE => 'square',
        self::ROUND => 'rounded',
    ];

    public function vcard(): BelongsTo
    {
        return $this->belongsTo(Vcard::class, 'vcard_id');
    }
}
