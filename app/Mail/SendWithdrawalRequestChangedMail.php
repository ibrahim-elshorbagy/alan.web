<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendWithdrawalRequestChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public string $mailSubject;

    public string $mailView;
    private $languageId;
    private $approvedTemplate;
    private $rejectedTemplate;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data, string $subject, string $mailView, $languageId = null)
    {
        $this->data = $data;
        $this->mailSubject = $subject;
        $this->mailView = $mailView;
        $this->languageId = $languageId ?? getUserLanguageId();
        $this->approvedTemplate = getEmailTemplate(10, $this->languageId, false);
        $this->rejectedTemplate = getEmailTemplate(11, $this->languageId, false);
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        if ($this->mailView == "emails.withdrawal_approved_mail") {
            if ($this->approvedTemplate) {
                $content = parseEmailTemplate($this->approvedTemplate->email_template_content, [
                    'toname' => $this->data['toName'],
                    'amount' => $this->data['amount'],
                    'appname' => getAppName(),
                ]);

                return $this->subject($this->approvedTemplate->email_template_subject)
                            ->from(config('mail.from.address'))
                            ->markdown($this->mailView, compact('content'))
                            ->with($this->data);
            } else {
                return $this->subject($this->mailSubject)
                            ->from(config('mail.from.address'))
                            ->markdown($this->mailView)
                            ->with($this->data);
            }
        }

        if ($this->mailView == "emails.withdrawal_rejected_mail") {
            if ($this->rejectedTemplate) {
                $content = parseEmailTemplate($this->rejectedTemplate->email_template_content, [
                    'toname' => $this->data['toName'],
                    'amount' => $this->data['amount'],
                    'rejectionnote' => $this->data['rejectionNote'],
                    'appname' => getAppName(),
                ]);

                return $this->subject($this->rejectedTemplate->email_template_subject)
                            ->from(config('mail.from.address'))
                            ->markdown($this->mailView, compact('content'))
                            ->with($this->data);
            } else {
                return $this->subject($this->mailSubject)
                            ->from(config('mail.from.address'))
                            ->markdown($this->mailView)
                            ->with($this->data);
            }
        }
        return $this->subject($this->mailSubject)->from(config('mail.from.address'))->markdown($this->mailView)->with($this->data);
    }
}
