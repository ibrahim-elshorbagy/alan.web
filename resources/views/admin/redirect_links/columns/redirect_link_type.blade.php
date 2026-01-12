@php
  $icon = match ($row->redirect_link_type) {
      \App\Enums\RedirectLinkTypeEnum::WEBSITE->value => 'fas fa-globe',
      \App\Enums\RedirectLinkTypeEnum::FACEBOOK->value => 'fab fa-facebook',
      \App\Enums\RedirectLinkTypeEnum::INSTAGRAM->value => 'fab fa-instagram',
      \App\Enums\RedirectLinkTypeEnum::TIKTOK->value => 'fab fa-tiktok',
      \App\Enums\RedirectLinkTypeEnum::TWITTER->value => 'fab fa-twitter',
      \App\Enums\RedirectLinkTypeEnum::LINKEDIN->value => 'fab fa-linkedin',
      \App\Enums\RedirectLinkTypeEnum::YOUTUBE->value => 'fab fa-youtube',
      \App\Enums\RedirectLinkTypeEnum::WHATSAPP->value => 'fab fa-whatsapp',
      \App\Enums\RedirectLinkTypeEnum::SNAPCHAT->value => 'fab fa-snapchat',
      \App\Enums\RedirectLinkTypeEnum::GOOGLE_BUSINESS->value => 'fas fa-business-time',
      \App\Enums\RedirectLinkTypeEnum::VCARD->value => 'fas fa-id-card',
      default => 'fas fa-question',
  };

  $tooltip = match ($row->redirect_link_type) {
      \App\Enums\RedirectLinkTypeEnum::WEBSITE->value => __('messages.redirect_links.types.website'),
      \App\Enums\RedirectLinkTypeEnum::FACEBOOK->value => __('messages.redirect_links.types.facebook'),
      \App\Enums\RedirectLinkTypeEnum::INSTAGRAM->value => __('messages.redirect_links.types.instagram'),
      \App\Enums\RedirectLinkTypeEnum::TIKTOK->value => __('messages.redirect_links.types.tiktok'),
      \App\Enums\RedirectLinkTypeEnum::TWITTER->value => __('messages.redirect_links.types.twitter'),
      \App\Enums\RedirectLinkTypeEnum::LINKEDIN->value => __('messages.redirect_links.types.linkedin'),
      \App\Enums\RedirectLinkTypeEnum::YOUTUBE->value => __('messages.redirect_links.types.youtube'),
      \App\Enums\RedirectLinkTypeEnum::WHATSAPP->value => __('messages.redirect_links.types.whatsapp'),
      \App\Enums\RedirectLinkTypeEnum::SNAPCHAT->value => __('messages.redirect_links.types.snapchat'),
      \App\Enums\RedirectLinkTypeEnum::GOOGLE_BUSINESS->value => __('messages.redirect_links.types.google_business'),
      \App\Enums\RedirectLinkTypeEnum::VCARD->value => __('messages.redirect_links.types.vcard'),
      default => 'Unknown',
  };
@endphp

<i class="{{ $icon }}" data-bs-toggle="tooltip" title="{{ $tooltip }}"></i>
