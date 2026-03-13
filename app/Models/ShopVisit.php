<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopVisit extends Model
{
  use HasFactory;

  protected $fillable = [
    'sales_user_id',
    'city',
    'area',
    'street',
    'shop_name',
    'phone',
    'notes',
    'visited_at',
  ];

  protected $casts = [
    'visited_at' => 'datetime',
  ];

  /**
   * The sales user who made this visit.
   */
  public function salesUser()
  {
    return $this->belongsTo(User::class, 'sales_user_id');
  }
}
