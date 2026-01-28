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
  case GOOGLE_BUSINESS = 10;


  public function label(): string
  {
    return match ($this) {
      self::WEBSITE => __('messages.redirect_links.types.website'),
      self::FACEBOOK => __('messages.redirect_links.types.facebook'),
      self::INSTAGRAM => __('messages.redirect_links.types.instagram'),
      self::TIKTOK => __('messages.redirect_links.types.tiktok'),
      self::TWITTER => __('messages.redirect_links.types.twitter'),
      self::LINKEDIN => __('messages.redirect_links.types.linkedin'),
      self::YOUTUBE => __('messages.redirect_links.types.youtube'),
      self::WHATSAPP => __('messages.redirect_links.types.whatsapp'),
      self::SNAPCHAT => __('messages.redirect_links.types.snapchat'),
      self::GOOGLE_BUSINESS => __('messages.redirect_links.types.google_business'),
    };
  }
}
