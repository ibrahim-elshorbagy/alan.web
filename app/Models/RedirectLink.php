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

  protected $casts = [

  ];

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

  public function histories()
  {
    return $this->hasMany(RedirectLinkHistory::class)->orderBy('created_at', 'desc');
  }

  /**
   * Log history for any action on this redirect link
   */
  public function logHistory(string $action, $oldValue, $newValue, ?int $changedBy = null, ?string $description = null)
  {
    $changedByUser = $changedBy ? \App\Models\User::withoutGlobalScopes()->find($changedBy) : auth()->user();

    $history = new RedirectLinkHistory([
      'redirect_link_id' => $this->id,
      'action' => $action,
      'changed_by' => $changedByUser?->id,
      'changed_by_name' => $changedByUser ? ($changedByUser->first_name . ' ' . $changedByUser->last_name) : null,
      'old_value' => is_array($oldValue) ? json_encode($oldValue) : $oldValue,
      'new_value' => is_array($newValue) ? json_encode($newValue) : $newValue,
      'description' => $description,
    ]);

    $history->save();
  }
}
