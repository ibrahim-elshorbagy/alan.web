<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesFaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $persianTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'کاربر جدید ثبت‌نام کرد',
                'email_template_content' => '<h2>سلام،</h2><p>یک کاربر جدید ثبت‌نام کرد!</p><h4>نام: { firstname } { lastname }</h4><h4>ایمیل: { email }</h4><p>با تشکر و ارادت،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'وقت ملاقات تأیید شد',
                'email_template_content' => '<h2>سلام، { name }</h2><p>وقت ملاقات شما با موفقیت در تاریخ { date } بین { fromtime } تا { totime } تأیید شد</p><p>با تشکر و ارادت،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'سفارش جدید کارت NFC دریافت شد',
                'email_template_content' => '<h2>سلام،</h2><p>شما یک سفارش کارت NFC جدید از { name } دریافت کردید</p><p>نوع کارت : { cardtype }</p><p>نام vCard : { vcardname }</p><p>آدرس ارسال : { shippingaddress }</p><p>تاریخ سفارش : { orderdate }</p><p>با تشکر و ارادت،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'درخواست',
                'email_template_content' => '<h2>جزئیات درخواست به شرح زیر است</h2><p><b>نام: </b>{ name }</p><p><b>ایمیل: </b>{ email }</p><p><b>پیام: </b>{ message }</p><p><b>تلفن: </b>{ phone }</p><p><b>نام vCard : </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'وضعیت سفارش کارت NFC',
                'email_template_content' => '<h2>سلام، <b>{ name }</b></h2><p>وضعیت سفارش شما تغییر کرد</p><p><b>وضعیت سفارش: </b>{ status }</p><p>با تشکر و ارادت،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'خرید محصول موفقیت‌آمیز بود',
                'email_template_content' => '<h2>سلام، { customername }</h2><p>سفارش محصول شما با موفقیت تأیید شد.</p><p><b>نام محصول :</b> { productname }</p><p><b>قیمت محصول :</b> { productprice }</p><p><b>آدرس :</b> { address }</p><p><b>نوع پرداخت :</b> { paymenttype }</p><p><b>تاریخ سفارش :</b> { orderdate }</p><p>با تشکر و ارادت،<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'خرید محصول موفقیت‌آمیز بود',
                'email_template_content' => '<h2>سلام، { customername }</h2><p>{ customername } محصول شما را خریداری کرده است.</p><p><b>نام مشتری :</b> { customername }</p><p><b>نام محصول :</b> { productname }</p><p><b>شماره تلفن :</b> { phone }</p><p><b>آدرس :</b> { address }</p><p><b>نوع پرداخت :</b> { paymenttype }</p><p><b>تاریخ سفارش :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'دعوت‌نامه دریافت شد',
                'email_template_content' => '<h2>سلام،</h2><p>شما یک دعوت‌نامه از { name } دریافت کردید</p>لطفاً برای ثبت‌نام روی لینک زیر کلیک کنید.<p>{ referralurl }</p><p></p><p>با تشکر و ارادت،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'خرید اشتراک موفقیت‌آمیز بود',
                'email_template_content' => '<h2>سلام، { firstname } { lastname }</h2><p>شما با موفقیت پلن { planname } را خریداری کردید</p><p>با تشکر و ارادت،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'رزرو قرار ملاقات',
                'email_template_content' => '<h2>سلام، <b>{ toname }</b></h2><p><b>{ name } با شما یک قرار ملاقات رزرو کرد</b>.</p><p><b>زمان قرار ملاقات : </b>{ date } - { fromtime } تا { totime }</p><p><b>نام vCard : </b>{ vcardname }</p><p><b>شماره تلفن : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'درخواست برداشت تأیید شد',
                'email_template_content' => '<h2>سلام، <b>{ toname }</b></h2><p><b>درخواست برداشت شما به مبلغ { amount } تأیید شد</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'درخواست برداشت رد شد',
                'email_template_content' => '<h2>سلام، <b>{ toname }</b></h2><p><b>درخواست برداشت شما به مبلغ { amount } رد شد.</b></p><p><b>دلیل :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'رزرو قرار ملاقات',
                'email_template_content' => '<h2>سلام، <b>{ name }</b></h2><p>قرار ملاقات شما با موفقیت در تاریخ { date } بین { fromtime } تا { totime } رزرو شد</p><p>با تشکر و ارادت،</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'درخواست',
                'email_template_content' => '<h2>جزئیات درخواست به شرح زیر است</h2><p><b>نام: </b>{ name }</p><p><b>ایمیل: </b>{ email }</p><p><b>موضوع: </b>{ subject }</p><p><b>پیام: </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'fa')->value('id'),
                'email_template_subject' => 'خرید محصول موفقیت‌آمیز بود',
                'email_template_content' => '<h2>سلام، { username }</h2><p>{ customername } محصول شما را خریداری کرده است.</p><p><b>نام مشتری : </b>{ customername }</p><p><b>نام محصول : </b>{ productname }</p><p><b>شماره تلفن : </b>{ phone }</p><p><b>آدرس : </b>{ address }</p><p><b>تاریخ سفارش : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($persianTemplates as $template) {
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
