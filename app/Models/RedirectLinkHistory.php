<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedirectLinkHistory extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  public function redirectLink(): BelongsTo
  {
    return $this->belongsTo(RedirectLink::class);
  }

  public function changedBy(): BelongsTo
  {
    return $this->belongsTo(User::class, 'changed_by');
  }

  /**
   * Get the display name for who made the change
   */
  public function getChangedByDisplayName(): string
  {
    if ($this->changedBy) {
      return $this->changedBy->first_name . ' ' . $this->changedBy->last_name;
    }

    return $this->changed_by_name ?? __('messages.redirect_links.history.deleted_user');
  }
}
