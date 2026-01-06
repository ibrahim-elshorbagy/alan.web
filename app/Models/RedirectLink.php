<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedirectLink extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  // Status
  const STATUS_NOT_REDEEMED = 0;
  const STATUS_REDEEMED = 1;

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function nfc(): BelongsTo
  {
    return $this->belongsTo(Nfc::class, 'nfcs_id');
  }
}
