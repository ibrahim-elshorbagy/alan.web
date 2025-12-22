<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesItSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $italianTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Nuovo utente registrato',
                'email_template_content' => '<h2>Ciao,</h2><p>Un nuovo utente si è registrato!</p><h4>Nome: { firstname } { lastname }</h4><h4>Email: { email }</h4><p>Grazie e cordialità,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Appuntamento approvato',
                'email_template_content' => '<h2>Ciao, { name }</h2><p>Il tuo appuntamento è stato approvato con successo il { date } tra { fromtime } e { totime }</p><p>Grazie e cordialità,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Nuovo ordine di scheda NFC ricevuto',
                'email_template_content' => '<h2>Ciao,</h2><p>Hai ricevuto un nuovo ordine di scheda NFC da { name }</p><p>Tipo di scheda : { cardtype }</p><p>Nome vCard : { vcardname }</p><p>Indirizzo di spedizione : { shippingaddress }</p><p>Data ordine : { orderdate }</p><p>Grazie e cordialità,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Richiesta',
                'email_template_content' => '<h2>Ecco i dettagli della richiesta</h2><p><b>Nome: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Messaggio: </b>{ message }</p><p><b>Telefono: </b>{ phone }</p><p><b>Nome vCard: </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Stato ordine scheda NFC',
                'email_template_content' => '<h2>Ciao, <b>{ name }</b></h2><p>Lo stato del tuo ordine è cambiato</p><p><b>Stato ordine: </b>{ status }</p><p>Grazie e cordialità,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Acquisto del prodotto riuscito',
                'email_template_content' => '<h2>Ciao, { customername }</h2><p>Il tuo ordine è stato confermato con successo.</p><p><b>Nome prodotto :</b> { productname }</p><p><b>Prezzo prodotto :</b> { productprice }</p><p><b>Indirizzo :</b> { address }</p><p><b>Tipo di pagamento :</b> { paymenttype }</p><p><b>Ordinato il :</b> { orderdate }</p><p>Grazie e cordialità,<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Acquisto del prodotto riuscito',
                'email_template_content' => '<h2>Ciao, { customername }</h2><p>{ customername } ha acquistato il tuo prodotto.</p><p><b>Nome cliente :</b> { customername }</p><p><b>Nome prodotto :</b> { productname }</p><p><b>Numero di telefono :</b> { phone }</p><p><b>Indirizzo :</b> { address }</p><p><b>Tipo di pagamento :</b> { paymenttype }</p><p><b>Ordinato il :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Invito ricevuto',
                'email_template_content' => '<h2>Ciao,</h2><p>Hai ricevuto un invito da { name }</p>Si prega di cliccare sul link sottostante per registrarsi.<p>{ referralurl }</p><p></p><p>Grazie e cordialità,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Acquisto dell\'abbonamento riuscito',
                'email_template_content' => '<h2>Ciao, { firstname } { lastname }</h2><p>Hai acquistato correttamente il piano { planname }</p><p>Grazie e cordialità,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Prenota appuntamento',
                'email_template_content' => '<h2>Ciao, <b>{ toname }</b></h2><p><b>{ name } ha prenotato un appuntamento con te</b>.</p><p><b>Orario appuntamento : </b>{ date } - { fromtime } a { totime }</p><p><b>Nome vCard : </b>{ vcardname }</p><p><b>Numero di telefono : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Richiesta di prelievo approvata',
                'email_template_content' => '<h2>Ciao, <b>{ toname }</b></h2><p><b>La tua richiesta di prelievo di { amount } è stata approvata</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Richiesta di prelievo rifiutata',
                'email_template_content' => '<h2>Ciao, <b>{ toname }</b></h2><p><b>La tua richiesta di prelievo di { amount } è stata rifiutata.</b></p><p><b>Motivo :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Prenota appuntamento',
                'email_template_content' => '<h2>Ciao, <b>{ name }</b></h2><p>Il tuo appuntamento è stato prenotato con successo il { date } tra { fromtime } e { totime }</p><p>Grazie e cordialità,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Richiesta',
                'email_template_content' => '<h2>Ecco i dettagli della richiesta</h2><p><b>Nome: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Oggetto: </b>{ subject }</p><p><b>Messaggio: </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'it')->value('id'),
                'email_template_subject' => 'Acquisto del prodotto riuscito',
                'email_template_content' => '<h2>Ciao, { username }</h2><p>{ customername } ha acquistato il tuo prodotto.</p><p><b>Nome cliente : </b>{ customername }</p><p><b>Nome prodotto : </b>{ productname }</p><p><b>Numero di telefono : </b>{ phone }</p><p><b>Indirizzo : </b>{ address }</p><p><b>Ordinato il : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($italianTemplates as $template) {
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
