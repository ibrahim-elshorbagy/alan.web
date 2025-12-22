<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WhatsappStoreProductOrderSendUser extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    private $languageId;
    private $template;

    public function __construct($data = [], $storeDefaultLanguage = null, $storeAlias = null)
    {
        $this->data = $data;
        $this->languageId = getVcardLanguageId($storeDefaultLanguage, $storeAlias);
        $this->template = getEmailTemplate(14, $this->languageId, false);
    }

    public function build()
    {
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'username' => $this->data['user_name'],
                'customername' => $this->data['customer_name'],
                'productname' => $this->data['product_name'],
                'phone' => $this->data['phone'],
                'address' => $this->data['address'],
                'orderdate' => $this->data['order_date'],
                'appname' => getAppName(),
            ]);

            return $this->subject($this->template->email_template_subject)
                        ->markdown('emails.whatsapp_store_product_order_send_user', compact('content'))->with(['data' => $this->data]);
        } else {
            return $this->subject(__('messages.mail.product_purchase'))
                        ->markdown('emails.whatsapp_store_product_order_send_user')
                        ->with(['data' => $this->data]);
        }
    }
}
