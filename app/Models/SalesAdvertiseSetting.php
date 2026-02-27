<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesAdvertiseSetting extends Model
{
  use HasFactory;

  protected $fillable = [
    'redirect_link_id',
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
   * The redirect link this setting belongs to.
   */
  public function redirectLink()
  {
    return $this->belongsTo(RedirectLink::class);
  }
}
