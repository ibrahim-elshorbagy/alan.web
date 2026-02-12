<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RedirectLinkAcknowledgment extends Model
{
  use HasFactory;

  protected $fillable = [
    'sales_user_id',
    'created_by',
    'redirect_link_ids',
    'total_price',
    'total_sales_price',
    'total_count',
    'signature_file',
    'notes',
  ];

  protected $casts = [
    'redirect_link_ids' => 'array',
    'total_price' => 'decimal:2',
    'total_sales_price' => 'decimal:2',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  /**
   * Get the sales user for this acknowledgment
   */
  public function salesUser(): BelongsTo
  {
    return $this->belongsTo(User::class, 'sales_user_id');
  }

  /**
   * Get the creator of this acknowledgment
   */
  public function creator(): BelongsTo
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  /**
   * Get the redirect links for this acknowledgment
   */
  public function getRedirectLinks()
  {
    return RedirectLink::whereIn('id', $this->redirect_link_ids ?? [])->get();
  }

  /**
   * Get the signature file URL
   */
  public function getSignatureUrlAttribute(): ?string
  {
    return $this->signature_file ? asset('storage/' . $this->signature_file) : null;
  }
}
