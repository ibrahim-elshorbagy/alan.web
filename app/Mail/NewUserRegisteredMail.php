<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    private $languageId;
    private $template;

    public function __construct($user, $languageId = null)
    {
        $this->user = $user;
        $this->languageId = $languageId ?? getUserLanguageId();
        $this->template = getEmailTemplate(0, $this->languageId, false);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->template ? $this->template->email_template_subject : __('messages.user.registered')
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function build()
    {
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'firstname' => $this->user->first_name,
                'lastname' => $this->user->last_name,
                'email' => $this->user->email,
                'appname' => getAppName(),
            ]);
            return $this->subject($this->template->email_template_subject)->markdown('emails.new_user_registered_mail', compact('content'));
        }

        return $this->subject(__('messages.user.registered'))->markdown('emails.new_user_registered_mail');
    }
}
