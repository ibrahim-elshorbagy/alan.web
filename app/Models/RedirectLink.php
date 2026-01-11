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
  const STATUS_REJECTED = 2;

  const RECEIVED_STATUS_NOT_RECEIVED = 0;
  const RECEIVED_STATUS_RECEIVED = 1;

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function assignedUser(): BelongsTo
  {
    return $this->belongsTo(User::class, 'assigned_id');
  }

  public function nfc(): BelongsTo
  {
    return $this->belongsTo(Nfc::class, 'nfcs_id');
  }
}
