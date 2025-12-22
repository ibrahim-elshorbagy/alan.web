<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentApproveMail extends Mailable
{
    use Queueable, SerializesModels;

    public $input;
    private $languageId;
    private $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($input, $languageId = null)
    {
        $this->input = $input;
        $this->languageId = $languageId ?? getUserLanguageId();
        $this->template = getEmailTemplate(1, $this->languageId, false);
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        $subject = $this->template ? $this->template->email_template_subject : __('messages.mail.appointment_approve');
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'name' => $this->input['name'],
                'date' => $this->input['date'],
                'fromtime' => $this->input['from_time'],
                'totime' => $this->input['to_time'],
                'appname' => getAppName(),
            ]);
            return $this->subject($subject)->markdown('emails.appointment_approve', compact('content'));
        } else {
            return $this->subject($subject)->markdown('emails.appointment_approve')->with($this->input);
        }
    }
}
