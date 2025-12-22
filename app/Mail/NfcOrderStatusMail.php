<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\Models\NfcOrders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NfcOrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $status;
    private $languageId;
    private $template;
    /**
     * Create a new message instance.
     */
    public function __construct($order, $status, $languageId = null)
    {
        $this->order = $order;
        $this->status = $status;
        $this->languageId = $languageId ?? getUserLanguageId();
        $this->template = getEmailTemplate(4, $this->languageId, false);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->template ? $this->template->email_template_subject : __('messages.nfc.nfc_order_status'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'name' => $this->order['name'],
                'status' =>  __('messages.nfc.' . NfcOrders::ORDER_STATUS_ARR[$this->status]),
                'appname' => getAppName(),
            ]);
            return new Content(
                markdown: 'emails.nfc_order_status',
                with: compact('content')
            );
        } else {
            return new Content(
                markdown: 'emails.nfc_order_status',
            );
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
