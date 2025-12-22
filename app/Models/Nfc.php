<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Notifiable;

class Nfc extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $table = 'nfcs';

    const NFC_PATH = 'nfc_image';

    const NFC_BACK_IMAGE = 'nfc_back_image';

    public static $rules = [
        'name' => 'required|string',
        'price' => 'required|integer',
        'description' => 'required|string',
        'nfc_img' => 'required|mimes:jpg,jpeg,png',
        'nfc_back_img' => 'required|mimes:jpg,jpeg,png',
    ];

    protected $appends = ['nfc_image', 'nfc_back_image'];
    protected $with = ['media'];

    public function getNfcImageAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::NFC_PATH)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/img/nfc/card_default.png');
    }

    public function getNfcBackImageAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::NFC_BACK_IMAGE)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/img/nfc/card_default.png');
    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'nfc_img',
        'nfc_back_img',
    ];


    public function nfcOrders()
    {
        return $this->hasMany(NfcOrders::class,'card_type','id');
    }

    public function routeNotificationForSlack(Notification $notification): string
    {
        // return $this->webhook_url;
        return config('services.slack.webhook_url', $this->webhook_url);
    }
}
