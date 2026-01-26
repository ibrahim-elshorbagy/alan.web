@php
  // Debug: let's see what we're actually getting
  $rawValue = $row->redirect_link_type;
  $typeValue = is_numeric($row->redirect_link_type) ? (int) $row->redirect_link_type : $row->redirect_link_type;

  $icon = match ($typeValue) {
      1, \App\Enums\RedirectLinkTypeEnum::WEBSITE->value => 'fas fa-globe',
      2, \App\Enums\RedirectLinkTypeEnum::FACEBOOK->value => 'fab fa-facebook',
      3, \App\Enums\RedirectLinkTypeEnum::INSTAGRAM->value => 'fab fa-instagram',
      4, \App\Enums\RedirectLinkTypeEnum::TIKTOK->value => 'fab fa-tiktok',
      5, \App\Enums\RedirectLinkTypeEnum::TWITTER->value => 'fab fa-twitter',
      6, \App\Enums\RedirectLinkTypeEnum::LINKEDIN->value => 'fab fa-linkedin',
      7, \App\Enums\RedirectLinkTypeEnum::YOUTUBE->value => 'fab fa-youtube',
      8, \App\Enums\RedirectLinkTypeEnum::WHATSAPP->value => 'fab fa-whatsapp',
      9, \App\Enums\RedirectLinkTypeEnum::SNAPCHAT->value => 'fab fa-snapchat',
      10, \App\Enums\RedirectLinkTypeEnum::GOOGLE_BUSINESS->value => 'fas fa-business-time',
      11, \App\Enums\RedirectLinkTypeEnum::VCARD->value => 'fas fa-id-card',
      default => 'fas fa-question',
  };

  $tooltip = match ($typeValue) {
      1, \App\Enums\RedirectLinkTypeEnum::WEBSITE->value => __('messages.redirect_links.types.website'),
      2, \App\Enums\RedirectLinkTypeEnum::FACEBOOK->value => __('messages.redirect_links.types.facebook'),
      3, \App\Enums\RedirectLinkTypeEnum::INSTAGRAM->value => __('messages.redirect_links.types.instagram'),
      4, \App\Enums\RedirectLinkTypeEnum::TIKTOK->value => __('messages.redirect_links.types.tiktok'),
      5, \App\Enums\RedirectLinkTypeEnum::TWITTER->value => __('messages.redirect_links.types.twitter'),
      6, \App\Enums\RedirectLinkTypeEnum::LINKEDIN->value => __('messages.redirect_links.types.linkedin'),
      7, \App\Enums\RedirectLinkTypeEnum::YOUTUBE->value => __('messages.redirect_links.types.youtube'),
      8, \App\Enums\RedirectLinkTypeEnum::WHATSAPP->value => __('messages.redirect_links.types.whatsapp'),
      9, \App\Enums\RedirectLinkTypeEnum::SNAPCHAT->value => __('messages.redirect_links.types.snapchat'),
      10, \App\Enums\RedirectLinkTypeEnum::GOOGLE_BUSINESS->value => __(
          'messages.redirect_links.types.google_business',
      ),
      11, \App\Enums\RedirectLinkTypeEnum::VCARD->value => __('messages.redirect_links.types.vcard'),
      default => 'Unknown',
  };
@endphp

<i class="{{ $icon }}" data-bs-toggle="tooltip" title="{{ $tooltip }}"></i>
<i class="bi bi-cpu fs-5 me-1" title="{{ $row->nfc->name ?? 'N/A' }}" data-bs-toggle="tooltip"></i>
