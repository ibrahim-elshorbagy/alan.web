<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesAdvertiseSetting extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'is_enabled',
    'duration',
    'images',
    'impressions',
  ];

  protected $casts = [
    'is_enabled'  => 'boolean',
    'images'      => 'array',
    'impressions' => 'array',
  ];

  /**
   * The sales user this setting belongs to.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
