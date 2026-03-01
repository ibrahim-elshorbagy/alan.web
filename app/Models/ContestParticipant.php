<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestParticipant extends Model
{
  use HasFactory;

  protected $fillable = [
    'contest_id',
    'name',
    'phone',
    'winner_rank',
    'won_at',
  ];

  protected $casts = [
    'winner_rank' => 'integer',
    'won_at'      => 'datetime',
  ];

  /**
   * The contest this participant belongs to.
   */
  public function contest()
  {
    return $this->belongsTo(Contest::class);
  }
}
