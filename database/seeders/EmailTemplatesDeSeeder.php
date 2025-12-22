<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesDeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $germanTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Neuer Benutzer registriert',
                'email_template_content' => '<h2>Hallo,</h2><p>Ein neuer Benutzer wurde registriert!</p><h4>Name: { firstname } { lastname }</h4><h4>Email: { email }</h4><p>Vielen Dank & Viele Grüße,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Termin bestätigt',
                'email_template_content' => '<h2>Hallo, { name }</h2><p>Ihr Termin wurde am { date } zwischen { fromtime } und { totime } erfolgreich bestätigt</p><p>Vielen Dank & Viele Grüße,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Neue NFC-Kartenbestellung erhalten',
                'email_template_content' => '<h2>Hallo,</h2><p>Sie haben eine neue NFC-Kartenbestellung von { name } erhalten</p><p>Kartentyp : { cardtype }</p><p>vCard Name : { vcardname }</p><p>Lieferadresse : { shippingaddress }</p><p>Bestelldatum : { orderdate }</p><p>Vielen Dank & Viele Grüße,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Anfrage',
                'email_template_content' => '<h2>Hier sind die Details der Anfrage</h2><p><b>Name: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Nachricht: </b>{ message }</p><p><b>Telefon: </b>{ phone }</p><p><b>vCard Name: </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Status der NFC-Kartenbestellung',
                'email_template_content' => '<h2>Hallo, <b>{ name }</b></h2><p>Der Status Ihrer Bestellung hat sich geändert</p><p><b>Bestellstatus: </b>{ status }</p><p>Vielen Dank & Viele Grüße,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Produktkauf erfolgreich',
                'email_template_content' => '<h2>Hallo, { customername }</h2><p>Ihre Produktbestellung wurde erfolgreich bestätigt.</p><p><b>Produktname :</b> { productname }</p><p><b>Produktpreis :</b> { productprice }</p><p><b>Adresse :</b> { address }</p><p><b>Zahlungsart :</b> { paymenttype }</p><p><b>Bestelldatum :</b> { orderdate }</p><p>Vielen Dank & Viele Grüße,<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Produktkauf erfolgreich',
                'email_template_content' => '<h2>Hallo, { customername }</h2><p>{ customername } hat Ihr Produkt gekauft.</p><p><b>Kundenname :</b> { customername }</p><p><b>Produktname :</b> { productname }</p><p><b>Telefonnummer :</b> { phone }</p><p><b>Adresse :</b> { address }</p><p><b>Zahlungsart :</b> { paymenttype }</p><p><b>Bestelldatum :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Einladung erhalten',
                'email_template_content' => '<h2>Hallo,</h2><p>Sie haben eine Einladung von { name } erhalten</p>Bitte klicken Sie auf den untenstehenden Link, um sich zu registrieren.<p>{ referralurl }</p><p></p><p>Vielen Dank & Viele Grüße,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Abonnementkauf erfolgreich',
                'email_template_content' => '<h2>Hallo, { firstname } { lastname }</h2><p>Sie haben das { planname }-Paket erfolgreich gekauft</p><p>Vielen Dank & Viele Grüße,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Termin vereinbaren',
                'email_template_content' => '<h2>Hallo, <b>{ toname }</b></h2><p><b>{ name } hat einen Termin mit Ihnen vereinbart</b>.</p><p><b>Terminzeit : </b>{ date } - { fromtime } bis { totime }</p><p><b>vCard Name : </b>{ vcardname }</p><p><b>Telefonnummer : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Auszahlungsanfrage genehmigt',
                'email_template_content' => '<h2>Hallo, <b>{ toname }</b></h2><p><b>Ihre Auszahlungsanfrage über { amount } wurde genehmigt</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Auszahlungsanfrage abgelehnt',
                'email_template_content' => '<h2>Hallo, <b>{ toname }</b></h2><p><b>Ihre Auszahlungsanfrage über { amount } wurde abgelehnt.</b></p><p><b>Grund :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Termin vereinbaren',
                'email_template_content' => '<h2>Hallo, <b>{ name }</b></h2><p>Ihr Termin wurde erfolgreich am { date } zwischen { fromtime } und { totime } gebucht</p><p>Vielen Dank & Viele Grüße,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Anfrage',
                'email_template_content' => '<h2>Hier sind die Details der Anfrage</h2><p><b>Name: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Betreff: </b>{ subject }</p><p><b>Nachricht: </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'de')->value('id'),
                'email_template_subject' => 'Produktkauf erfolgreich',
                'email_template_content' => '<h2>Hallo, { username }</h2><p>{ customername } hat Ihr Produkt gekauft.</p><p><b>Kundenname : </b>{ customername }</p><p><b>Produktname : </b>{ productname }</p><p><b>Telefonnummer : </b>{ phone }</p><p><b>Adresse : </b>{ address }</p><p><b>Bestelldatum : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($germanTemplates as $template) {
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
