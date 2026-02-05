<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverImage extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'path',
    'status',
  ];

  protected $casts = [
    'status' => 'boolean',
  ];

  public function getImageUrlAttribute(): string
  {
    return asset('uploads/cover_images/' . $this->path);
  }
}