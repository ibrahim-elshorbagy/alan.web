<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
  use Queueable, SerializesModels;

  public $input;

  public $email;
  public $enquiry;
  private $languageId;
  private $template;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($input, $email, $enquiry = null, $vcardDefaultLanguage = null, $vcardAlias = null)
  {
    $this->input = $input;
    $this->email = $email;
    $this->enquiry = $enquiry;
    $this->languageId = getVcardLanguageId($vcardDefaultLanguage, $vcardAlias);

    $this->template = getEmailTemplate(3, $this->languageId, false);
  }

  /**
   * Build the message.
   */
  public function build(): static
  {
    $subject = $this->template ? $this->template->email_template_subject : __('messages.contact_us.enquiry');
    $mail = $this;
    if ($this->template) {
      $content = parseEmailTemplate($this->template->email_template_content, [
        'name' => $this->input['name'],
        'email' => $this->input['email'] ?? null,
        'message' => $this->input['message'],
        'phone' => $this->input['phone'],
        'vcardname' => $this->input['vcard_name'],
        'appname' => getAppName(),
      ]);
      $mail = $this->subject($subject)->markdown('emails.contactUs', compact('content'));
    } else {
      $mail = $this->subject($subject)->markdown('emails.contactUs')->with($this->input);
    }

    if ($this->enquiry && $this->enquiry->media->isNotEmpty()) {
      foreach ($this->enquiry->media as $media) {
        $mail->attach($media->getPath(), [
          'as' => $media->file_name,
          'mime' => $media->mime_type,
        ]);
      }
    }

    return $mail;
  }
}
