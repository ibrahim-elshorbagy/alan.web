<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductOrderSendCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    private $languageId;
    private $template;

    public function __construct($data = [], $vcardDefaultLanguage = null, $vcardAlias = null)
    {
        $this->data = $data;
        $this->languageId = getVcardLanguageId($vcardDefaultLanguage, $vcardAlias);
        $this->template = getEmailTemplate(5, $this->languageId, false);
    }

    public function build()
    {
        if ($this->template) {
            $content = parseEmailTemplate($this->template->email_template_content, [
                'customername' => $this->data['customer_name'],
                'productname' => $this->data['product_name'],
                'productprice' => $this->data['product_price'],
                'address' => $this->data['address'],
                'paymenttype' => $this->data['payment_type'],
                'orderdate' => $this->data['order_date'],
                'appname' => getAppName(),
            ]);
            return $this->subject($this->template->email_template_subject)->markdown('emails.product_order_send_customer', compact('content'));
        } else {
            return $this->subject(__('messages.mail.product_purchase'))->markdown('emails.product_order_send_customer')->with(['data' => $this->data]);
        }
    }
}
