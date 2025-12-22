<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesArSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arabicTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'تسجيل مستخدم جديد',
                'email_template_content' => '<h2>مرحبًا،</h2><p>تم تسجيل مستخدم جديد!</p><h4>الاسم: { firstname } { lastname }</h4><h4>البريد الإلكتروني: { email }</h4><p>شكرًا وتقديرًا،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'تمت الموافقة على الموعد',
                'email_template_content' => '<h2>مرحبًا، { name }</h2><p>تمت الموافقة على موعدك بنجاح في { date } بين { fromtime } إلى { totime }</p><p>شكرًا وتقديرًا،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'تم استلام طلب بطاقة NFC جديد',
                'email_template_content' => '<h2>مرحبًا،</h2><p>لقد استلمت طلب بطاقة NFC جديد من { name }</p><p>نوع البطاقة : { cardtype }</p><p>اسم vCard : { vcardname }</p><p>عنوان الشحن : { shippingaddress }</p><p>تاريخ الطلب : { orderdate }</p><p>شكرًا وتقديرًا،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'استفسار',
                'email_template_content' => '<h2>فيما يلي تفاصيل الاستفسار</h2><p><b>الاسم: </b>{ name }</p><p><b>البريد الإلكتروني: </b>{ email }</p><p><b>الرسالة: </b>{ message }</p><p><b>رقم الهاتف: </b>{ phone }</p><p><b>اسم vCard: </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'حالة طلب بطاقة NFC',
                'email_template_content' => '<h2>مرحبًا، <b>{ name }</b></h2><p>تم تغيير حالة طلبك</p><p><b>حالة الطلب: </b>{ status }</p><p>شكرًا وتقديرًا،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'تم شراء المنتج بنجاح',
                'email_template_content' => '<h2>مرحبًا، { customername }</h2><p>تم تأكيد طلب المنتج الخاص بك بنجاح.</p><p><b>اسم المنتج :</b> { productname }</p><p><b>سعر المنتج :</b> { productprice }</p><p><b>العنوان :</b> { address }</p><p><b>نوع الدفع :</b> { paymenttype }</p><p><b>تاريخ الطلب :</b> { orderdate }</p><p>شكرًا وتقديرًا،<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'تم شراء المنتج بنجاح',
                'email_template_content' => '<h2>مرحبًا، { customername }</h2><p>{ customername } قام بشراء منتجك.</p><p><b>اسم العميل :</b> { customername }</p><p><b>اسم المنتج :</b> { productname }</p><p><b>رقم الهاتف :</b> { phone }</p><p><b>العنوان :</b> { address }</p><p><b>نوع الدفع :</b> { paymenttype }</p><p><b>تاريخ الطلب :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'تلقي دعوة',
                'email_template_content' => '<h2>مرحبًا،</h2><p>لقد تلقيت دعوة من { name }</p>يرجى الضغط على الرابط أدناه للتسجيل.<p>{ referralurl }</p><p></p><p>شكرًا وتقديرًا،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'تم شراء الاشتراك بنجاح',
                'email_template_content' => '<h2>مرحبًا، { firstname } { lastname }</h2><p>لقد اشتريت خطة { planname } بنجاح</p><p>شكرًا وتقديرًا،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'حجز موعد',
                'email_template_content' => '<h2>مرحبًا، <b>{ toname }</b></h2><p><b>{ name } قام بحجز موعد معك</b>.</p><p><b>وقت الموعد : </b>{ date } - { fromtime } إلى { totime }</p><p><b>اسم vCard : </b>{ vcardname }</p><p><b>رقم الهاتف : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'تمت الموافقة على طلب السحب',
                'email_template_content' => '<h2>مرحبًا، <b>{ toname }</b></h2><p><b>تمت الموافقة على طلب السحب الخاص بك بمبلغ { amount }</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'تم رفض طلب السحب',
                'email_template_content' => '<h2>مرحبًا، <b>{ toname }</b></h2><p><b>تم رفض طلب السحب الخاص بك بمبلغ { amount }.</b></p><p><b>السبب :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'حجز موعد',
                'email_template_content' => '<h2>مرحبًا، <b>{ name }</b></h2><p>تم حجز موعدك بنجاح في { date } بين { fromtime } إلى { totime }</p><p>شكرًا وتقديرًا،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'استفسار',
                'email_template_content' => '<h2>فيما يلي تفاصيل الاستفسار</h2><p><b>الاسم: </b>{ name }</p><p><b>البريد الإلكتروني: </b>{ email }</p><p><b>الموضوع: </b>{ subject }</p><p><b>الرسالة: </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'ar')->value('id'),
                'email_template_subject' => 'تم شراء المنتج بنجاح',
                'email_template_content' => '<h2>مرحبًا، { username }</h2><p>{ customername } قام بشراء منتجك.</p><p><b>اسم العميل : </b>{ customername }</p><p><b>اسم المنتج : </b>{ productname }</p><p><b>رقم الهاتف : </b>{ phone }</p><p><b>العنوان : </b>{ address }</p><p><b>تاريخ الطلب : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($arabicTemplates as $template) {
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
