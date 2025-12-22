<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Blog extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'seo_title',
        'seo_keyword',
        'seo_description',
    ];

    public static $rules = [
        'title' => 'required',
        'slug' => 'required',
        'blog_image' => 'required',
        'description' => 'required',
    ];

    const BLOGIMAGE = 'blog_img';

    const IS_ACTIVE = 1;
    const DEACTIVATE = 0;
    const SELECT_STATUS = 2;

    const STATUS_ARR = [
        self::SELECT_STATUS => 'Select Status',
        self::IS_ACTIVE => 'Active',
        self::DEACTIVATE => 'Deactivate',
    ];

    protected $appends = ['blog_image',];

    public function getBlogImageAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::BLOGIMAGE)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('web/media/avatars/user.png');
    }

}
