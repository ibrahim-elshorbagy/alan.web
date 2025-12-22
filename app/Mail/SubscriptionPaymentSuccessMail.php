<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionPaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $emailData;
    private $languageId;
    private $template;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
        $this->languageId = $languageId ?? getUserLanguageId();
        $this->template = getEmailTemplate(8, $this->languageId, false);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function build()
    {
        $subject = $this->template ? $this->template->email_template_subject :__('messages.mail.subscription_purchase_success');
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'firstname' => $this->emailData['first_name'],
                'lastname' => $this->emailData['last_name'],
                'planname' => $this->emailData['planName'],
                'name' => $this->emailData['first_name'] . ' ' . $this->emailData['last_name'],
                'appname' => getAppName(),
            ]);
            return $this->subject($subject)->markdown('emails.subscription_payment_success', compact('content'));
        } else {
            return $this->subject($subject)->markdown('emails.subscription_payment_success')->with(['data' => $this->emailData]);
        }
    }
}
