<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNfcOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nfcOrder;
    public $vcardName;
    public $cardType;
    private $languageId;
    private $template;

    /**
     * Create a new message instance.
     */
    public function __construct($nfcOrder, $vcardName, $cardType, $languageId = null)
    {
        $this->nfcOrder = $nfcOrder;
        $this->vcardName = $vcardName;
        $this->cardType = $cardType;
        $this->languageId = $languageId ?? getUserLanguageId();
        $this->template = getEmailTemplate(2, $this->languageId, false);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->template ? $this->template->email_template_subject : __('messages.nfc.nfc_order_recived')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'name' => $this->nfcOrder['name'],
                'cardtype' => $this->cardType,
                'vcardname' => $this->vcardName,
                'shippingaddress' => $this->nfcOrder['address'],
                'orderdate' => date('Y-m-d', strtotime($this->nfcOrder['created_at'])),
                'appname' => getAppName(),
            ]);
            return new Content(
                markdown: 'emails.admin_nfc_order',
                with: compact('content')
            );
        } else {
            return new Content(
                markdown: 'emails.admin_nfc_order',
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
