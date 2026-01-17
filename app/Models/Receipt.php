<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'received_at',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public static $rules = [
        'user_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:0',
        'received_at' => 'required|date',
        'description' => 'nullable|string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
