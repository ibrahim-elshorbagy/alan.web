<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WhatDrivesUs extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'what_drives_us';

    protected $appends = ['what_drive_us_url'];

    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
    ];

    public static $rules = [
        'title.*' => 'required|string|max:100',
        'description.*' => 'required|string|max:500',
        'image.*' => 'mimes:jpg,bmp,png,apng,avif,jpeg,',
    ];

    const PATH = 'what_drives_us';

    public function getWhatDriveUsUrlAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::PATH)->first();
        if ($media !== null) {
            return $media->getFullUrl();
        }
        return '';
    }
}
