<?php

namespace App\Enums;

enum RedirectLinkTypeEnum: int
{
  case WEBSITE = 1;
  case FACEBOOK = 2;
  case INSTAGRAM = 3;
  case TIKTOK = 4;
  case TWITTER = 5;
  case LINKEDIN = 6;
  case YOUTUBE = 7;
  case WHATSAPP = 8;
  case SNAPCHAT = 9;

  // public function label(): string
  // {
  //   return match ($this) {
  //     self::WEBSITE => __('messages.website'),
  //     self::FACEBOOK => __('messages.facebook'),
  //     self::INSTAGRAM => __('messages.instagram'),
  //     self::TIKTOK => __('messages.tiktok'),
  //     self::TWITTER => __('messages.twitter'),
  //     self::LINKEDIN => __('messages.linkedin'),
  //     self::YOUTUBE => __('messages.youtube'),
  //     self::WHATSAPP => __('messages.whatsapp'),
  //     self::SNAPCHAT => __('messages.snapchat'),
  //   };
  // }
}
