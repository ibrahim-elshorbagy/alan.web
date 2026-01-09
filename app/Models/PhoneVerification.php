<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PhoneVerification extends Model
{
  use HasFactory;

  protected $fillable = [
    'phone',
    'code',
    'expires_at',
    'verified',
  ];

  protected $casts = [
    'expires_at' => 'datetime',
    'verified' => 'boolean',
  ];

  /**
   * Check if the verification code is still valid
   *
   * @return bool
   */
  public function isValid(): bool
  {
    return !$this->verified && $this->expires_at->isFuture();
  }

  /**
   * Mark the verification as verified
   *
   * @return bool
   */
  public function markAsVerified(): bool
  {
    $this->verified = true;
    return $this->save();
  }

  /**
   * Scope to get only non-verified codes
   */
  public function scopeUnverified($query)
  {
    return $query->where('verified', false);
  }

  /**
   * Scope to get only valid (non-expired) codes
   */
  public function scopeValid($query)
  {
    return $query->where('expires_at', '>', Carbon::now());
  }
}
