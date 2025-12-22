<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesEnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $englishTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'New User Registered',
                'email_template_content' => '<h2>Hello,</h2><p>New user has been registered !</p><h4>Name: { firstname } { lastname }</h4><h4> Email: { email } </h4><p>Thanks & Regards,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Appointment Approved',
                'email_template_content' => '<h2>Hello, { name }</h2><p>Your appointment approved successfully on { date } between { fromtime } To { totime }</p><p>Thanks & Regards,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'New NFC Card Order Recived',
                'email_template_content' => '<h2>Hello,</h2><p>You have Received New NFC Card Order from { name }</p><p>Card Type : { cardtype }</p><p>vCard Name : { vcardname }</p><p>Shipping Address : { shippingaddress }</p><p>Order Date : { orderdate }</p><p>Thanks & Regards,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Enquiry',
                'email_template_content' => '<h2>Here is a Inquiry Detail</h2><p><b>Name: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Message: </b>{ message }</p><p><b>Phone: </b>{ phone }</p><p><b>vCard Name: </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'NFC Card Order Status',
                'email_template_content' => '<h2>Hello, <b>{ name }</b></h2><p>Your Order Status Changed</p><p><b>Order Status: </b>{ status }</p><p>Thanks & Regards,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Product Purchase Success',
                'email_template_content' => '<h2>Hello, { customername }</h2><p>Your product order has been confirmed successfully.</p><p><b>Product Name :</b> { productname }</p><p><b>Product Price :</b> { productprice }</p><p><b>Address :</b> { address }</p><p><b>Payment Type :</b> { paymenttype }</p><p><b>Ordered At :</b> { orderdate }</p><p>Thanks & Regards,<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Product Purchase Success',
                'email_template_content' => '<h2>Hello, { customername }</h2><p>{ customername } has purchased your product.</p><p><b>Customer Name :</b> { customername }</p><p><b>Product Name :</b> { productname }</p><p><b>Mobile Number :</b> { phone }</p><p><b>Address :</b> { address }</p><p><b>Payment Type :</b> { paymenttype }</p><p><b>Ordered At :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Invitation Received',
                'email_template_content' => '<h2>Hello,</h2><p>You have received an invite from { name }</p>Please click on below link to get register.<p>{ referralurl }</p><p></p><p>Thanks & Regards,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Subscription Purchase Success',
                'email_template_content' => '<h2>Hello, { firstname } { lastname }</h2><p>You have purchased the { planname } Plan Successfully</p><p>Thanks & Regards,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Book Appointment',
                'email_template_content' => '<h2>Hello, <b>{ toname }</b></h2><p><b>{ name } booked appointment with you</b>.</p><p><b>Appointment Time : </b>{ date } - { fromtime } To { totime }</p><p><b>vCard Name : </b>{ vcardname }</p><p><b>Mobile Number : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Withdrawal Request Approved',
                'email_template_content' => '<h2>Hello, <b>{ toname }</b></h2><p><b>Your Withdrawal Request of amount { amount } is Approved</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Withdrawal Request Rejected',
                'email_template_content' => '<h2>Hello, <b>{ toname }</b></h2><p><b>Your Withdrawal Request of amount { amount } is Rejected.</b></p><p><b>Reason :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Book Appointment',
                'email_template_content' => '<h2>Hello, <b>{ name }</b></h2><p>Your appointment booked successfully on { date } between { fromtime } To { totime }</p><p>Thanks & Regards,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Enquiry',
                'email_template_content' => '<h2>Here is a Inquiry Detail</h2><p><b>Name: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Subject: </b>{ subject }</p><p><b>Message: </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'en')->value('id'),
                'email_template_subject' => 'Product Purchase Success',
                'email_template_content' => '<h2>Hello, { username }</h2><p>{ customername } has purchased your product.</p><p><b>Customer Name : </b>{ customername }</p><p><b>Product Name : </b>{ productname }</p><p><b>Mobile Number : </b>{ phone }</p><p><b>Address : </b>{ address }</p><p><b>Ordered At : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($englishTemplates as $template) {
            EmailTemplate::updateOrCreate(
                [
                    'email_template_type' => $template['email_template_type'],
                    'language_id' => $template['language_id'],
                ],
                $template
            );
        }
    }
}
