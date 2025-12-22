<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FrontSlider extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'front_sliders';

    protected $appends = ['front_slider_img_url'];

    public static $rules = [
        'front_slider_img.*' => 'mimes:jpg,bmp,png,apng,avif,jpeg,',
    ];

    const PATH = 'FrontSlider/img1';

    public function getFrontSliderImgUrlAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::PATH)->first();
        if ($media !== null) {
            return $media->getFullUrl();
        }
        return '';

    }
}
