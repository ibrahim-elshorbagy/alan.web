<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesTrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $turkishTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Yeni Kullanıcı Kaydedildi',
                'email_template_content' => '<h2>Merhaba,</h2><p>Yeni bir kullanıcı kaydedildi!</p><h4>Adı: { firstname } { lastname }</h4><h4>Email: { email }</h4><p>Teşekkürler & Saygılar,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Randevu Onaylandı',
                'email_template_content' => '<h2>Merhaba, { name }</h2><p>Randevunuz { date } tarihinde { fromtime } - { totime } saatleri arasında başarıyla onaylandı</p><p>Teşekkürler & Saygılar,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Yeni NFC Kart Siparişi Alındı',
                'email_template_content' => '<h2>Merhaba,</h2><p>{ name } tarafından yeni bir NFC kart siparişi aldınız</p><p>Kart Tipi : { cardtype }</p><p>vCard Adı : { vcardname }</p><p>Gönderim Adresi : { shippingaddress }</p><p>Sipariş Tarihi : { orderdate }</p><p>Teşekkürler & Saygılar,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Sorgu',
                'email_template_content' => '<h2>Sorgunun ayrıntıları aşağıdadır</h2><p><b>Adı: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Mesaj: </b>{ message }</p><p><b>Telefon: </b>{ phone }</p><p><b>vCard Adı: </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'NFC Kart Sipariş Durumu',
                'email_template_content' => '<h2>Merhaba, <b>{ name }</b></h2><p>Siparişinizin durumu değişti</p><p><b>Sipariş Durumu: </b>{ status }</p><p>Teşekkürler & Saygılar,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Ürün Satın Alma Başarılı',
                'email_template_content' => '<h2>Merhaba, { customername }</h2><p>Ürün siparişiniz başarıyla onaylandı.</p><p><b>Ürün Adı :</b> { productname }</p><p><b>Ürün Fiyatı :</b> { productprice }</p><p><b>Adres :</b> { address }</p><p><b>Ödeme Türü :</b> { paymenttype }</p><p><b>Sipariş Tarihi :</b> { orderdate }</p><p>Teşekkürler & Saygılar,<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Ürün Satın Alma Başarılı',
                'email_template_content' => '<h2>Merhaba, { customername }</h2><p>{ customername } ürününüzü satın aldı.</p><p><b>Müşteri Adı :</b> { customername }</p><p><b>Ürün Adı :</b> { productname }</p><p><b>Telefon Numarası :</b> { phone }</p><p><b>Adres :</b> { address }</p><p><b>Ödeme Türü :</b> { paymenttype }</p><p><b>Sipariş Tarihi :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Davet Alındı',
                'email_template_content' => '<h2>Merhaba,</h2><p>{ name } tarafından bir davet aldınız</p>Lütfen kayıt olmak için aşağıdaki bağlantıya tıklayın.<p>{ referralurl }</p><p></p><p>Teşekkürler & Saygılar,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Abonelik Satın Alımı Başarılı',
                'email_template_content' => '<h2>Merhaba, { firstname } { lastname }</h2><p>Başarıyla { planname } planını satın aldınız</p><p>Teşekkürler & Saygılar,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Randevu Al',
                'email_template_content' => '<h2>Merhaba, <b>{ toname }</b></h2><p><b>{ name } sizinle bir randevu aldı</b>.</p><p><b>Randevu Saati : </b>{ date } - { fromtime } ile { totime }</p><p><b>vCard Adı : </b>{ vcardname }</p><p><b>Telefon Numarası : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Çekme Talebi Onaylandı',
                'email_template_content' => '<h2>Merhaba, <b>{ toname }</b></h2><p><b>{ amount } tutarındaki çekme talebiniz onaylandı</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Çekme Talebi Reddedildi',
                'email_template_content' => '<h2>Merhaba, <b>{ toname }</b></h2><p><b>{ amount } tutarındaki çekme talebiniz reddedildi.</b></p><p><b>Neden :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Randevu Al',
                'email_template_content' => '<h2>Merhaba, <b>{ name }</b></h2><p>Randevunuz { date } tarihinde { fromtime } ile { totime } arasında başarıyla alındı</p><p>Teşekkürler & Saygılar,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Sorgu',
                'email_template_content' => '<h2>Sorgunun ayrıntıları aşağıdadır</h2><p><b>Adı: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Konu: </b>{ subject }</p><p><b>Mesaj: </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'tr')->value('id'),
                'email_template_subject' => 'Ürün Satın Alma Başarılı',
                'email_template_content' => '<h2>Merhaba, { username }</h2><p>{ customername } ürününüzü satın aldı.</p><p><b>Müşteri Adı : </b>{ customername }</p><p><b>Ürün Adı : </b>{ productname }</p><p><b>Telefon Numarası : </b>{ phone }</p><p><b>Adres : </b>{ address }</p><p><b>Sipariş Tarihi : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($turkishTemplates as $template) {
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
