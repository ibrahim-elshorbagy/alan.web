<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
  use HasFactory;

  protected $fillable = [
    'redirect_link_id',
    'title',
    'text',
    'draw_date',
    'is_enabled',
    'num_winners',
  ];

  protected $casts = [
    'is_enabled' => 'boolean',
    'draw_date'  => 'datetime',
    'num_winners' => 'integer',
  ];

  /**
   * The redirect link this contest belongs to.
   */
  public function redirectLink()
  {
    return $this->belongsTo(RedirectLink::class);
  }

  /**
   * Participants of this contest.
   */
  public function participants()
  {
    return $this->hasMany(ContestParticipant::class);
  }

  /**
   * Winners of this contest.
   */
  public function winners()
  {
    return $this->hasMany(ContestParticipant::class)->whereNotNull('winner_rank')->orderBy('winner_rank');
  }
}
