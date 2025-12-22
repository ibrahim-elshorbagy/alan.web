<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    private $data;
    private $languageId;
    private $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $view, string $subject, array $data = [], $vcardDefaultLanguage = null, $vcardAlias = null)
    {
        $this->view = $view;
        $this->subject = $subject;
        $this->data = $data;
        $this->languageId = getVcardLanguageId($vcardDefaultLanguage, $vcardAlias);
        $this->template = getEmailTemplate(9, $this->languageId, false);
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        $subject = $this->template ? $this->template->email_template_subject : $this->subject;
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'toname' => $this->data['toName'],
                'name' => $this->data['name'],
                'date' => $this->data['date'],
                'fromtime' => $this->data['from_time'],
                'totime' => $this->data['to_time'],
                'vcardname' => $this->data['vcard_name'],
                'phone' => $this->data['phone'],
                'appname' => getAppName(),
            ]);
            return $this->subject($subject)->from(config('mail.from.address'))->markdown($this->view)->with(compact('content'));
        } else {
            return $this->subject($subject)->from(config('app.mail_admin'))->markdown($this->view)->with($this->data);
        }
    }
}
