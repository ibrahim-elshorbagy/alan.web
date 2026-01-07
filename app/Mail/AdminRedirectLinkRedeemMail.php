<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminRedirectLinkRedeemMail extends Mailable
{
  use Queueable, SerializesModels;

  public $redirectLink;
  public $user;
  public $nfcCard;
  public $redirectType;
  private $languageId;

  public function __construct($redirectLink, $user, $nfcCard, $redirectType, $languageId = null)
  {
    $this->redirectLink = $redirectLink;
    $this->user = $user;
    $this->nfcCard = $nfcCard;
    $this->redirectType = $redirectType;
    $this->languageId = $languageId ?? getUserLanguageId();
  }

  public function build()
  {
    return $this
      ->subject(__('messages.redirect_links.redirect_link_redeemed_subject'))
      ->markdown('emails.admin_redirect_link_redeem')
      ->with([
        'redirectLink' => $this->redirectLink,
        'user'         => $this->user,
        'nfcCard'      => $this->nfcCard,
        'redirectType' => $this->redirectType,
        'languageId'   => $this->languageId,
      ]);
  }
}