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
    private $languageId;
    private $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($input, $email, $vcardDefaultLanguage = null, $vcardAlias = null)
    {
        $this->input = $input;
        $this->email = $email;
        $this->languageId = getVcardLanguageId($vcardDefaultLanguage, $vcardAlias);

        $this->template = getEmailTemplate(3, $this->languageId, false);
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        $subject = $this->template ? $this->template->email_template_subject : __('messages.contact_us.enquiry');
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'name' => $this->input['name'],
                'email' => $this->input['email'],
                'message' => $this->input['message'],
                'phone' => $this->input['phone'],
                'vcardname' => $this->input['vcard_name'],
                'appname' => getAppName(),
            ]);
            return $this->subject($subject)->markdown('emails.contactUs', compact('content'));
        } else {
            return $this->subject($subject)->markdown('emails.contactUs')->with($this->input);
        }
    }
}
