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
    'price' => 'required|numeric',
    'sales_price' => 'nullable|numeric',
    'description' => 'required|string',
    'nfc_img' => 'required|mimes:jpg,jpeg,png|max:2048',
    'nfc_back_img' => 'required|mimes:jpg,jpeg,png|max:2048',
    'apply_coordinates' => 'boolean',
    'qr_x_position' => 'nullable|integer',
    'qr_y_position' => 'nullable|integer',
    'qr_size' => 'nullable|integer',
    'qr_position_side' => 'nullable|string|in:front,back',
    'image_width' => 'nullable|numeric',
    'image_height' => 'nullable|numeric',
    'print_format' => 'nullable|string|in:fixed,a5',
    'print_front_image' => 'boolean',
    'print_back_image' => 'boolean',
    'print_only_qr' => 'boolean',
    'text_font_size' => 'nullable|integer|min:8|max:72',

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
    'sales_price',
    'nfc_img',
    'nfc_back_img',
    'apply_coordinates',
    'qr_x_position',
    'qr_y_position',
    'qr_size',
    'qr_position_side',
    'image_width',
    'image_height',
    'print_format',
    'print_front_image',
    'print_back_image',
    'print_only_qr',
    'text_font_size',
  ];


  public function nfcOrders()
  {
    return $this->hasMany(NfcOrders::class, 'card_type', 'id');
  }

  public function routeNotificationForSlack(Notification $notification): string
  {
    // return $this->webhook_url;
    return config('services.slack.webhook_url', $this->webhook_url);
  }
}
