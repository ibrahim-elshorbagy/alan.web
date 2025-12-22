<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LandingContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $input;

    public $email;
    private $languageId;
    private $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($input, $email)
    {
        $this->input = $input;
        $this->email = $email;
        $this->languageId = $languageId ?? getUserLanguageId();
        $this->template = getEmailTemplate(13, $this->languageId, false);
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'name' => $this->input['name'],
                'email' => $this->input['email'],
                'subject' => $this->input['subject'],
                'message' => $this->input['message'],
                'appname' => getAppName(),
            ]);

            return $this->subject($this->template->email_template_subject)
                        ->markdown('emails.landing_contact_us_mail', compact('content'))->with($this->input);
        } else {
            $subject = __('messages.contact_us.enquiry');

            return $this->subject($subject)
                        ->markdown('emails.landing_contact_us_mail')
                        ->with($this->input);
        }
    }
}
