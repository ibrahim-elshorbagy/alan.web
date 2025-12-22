<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendinviteMail extends Mailable
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
    public function __construct($input, $email, $languageId = null)
    {
        $this->input = $input;
        $this->email = $email;
        $this->languageId = $languageId ?? getUserLanguageId();
        $this->template = getEmailTemplate(7, $this->languageId, false);
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        $subject = $this->template ? $this->template->email_template_subject :__('messages.affiliation.invite_mail');
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'name' => $this->input['username'],
                'referralurl' => '<a href="' . $this->input['referralUrl'] . '">' . $this->input['referralUrl'] . '</a>',
                'appname' => getAppName(),
            ]);
            return $this->subject($subject)->markdown('emails.sendinvite_mail', compact('content'));
        } else {
            return $this->subject($subject)->markdown('emails.sendinvite_mail')->with($this->input);
        }
    }
}
