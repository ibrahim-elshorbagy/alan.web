<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesFrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $frenchTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Nouvel utilisateur enregistré',
                'email_template_content' => '<h2>Bonjour,</h2><p>Un nouvel utilisateur a été enregistré !</p><h4>Nom : { firstname } { lastname }</h4><h4> Email : { email } </h4><p>Merci & Cordialement,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Rendez-vous approuvé',
                'email_template_content' => '<h2>Bonjour, { name }</h2><p>Votre rendez-vous a été approuvé avec succès le { date } entre { fromtime } et { totime }</p><p>Merci & Cordialement,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Nouvelle commande de carte NFC reçue',
                'email_template_content' => '<h2>Bonjour,</h2><p>Vous avez reçu une nouvelle commande de carte NFC de { name }</p><p>Type de carte : { cardtype }</p><p>Nom vCard : { vcardname }</p><p>Adresse de livraison : { shippingaddress }</p><p>Date de la commande : { orderdate }</p><p>Merci & Cordialement,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Demande',
                'email_template_content' => '<h2>Voici les détails de la demande</h2><p><b>Nom : </b>{ name }</p><p><b>Email : </b>{ email }</p><p><b>Message : </b>{ message }</p><p><b>Téléphone : </b>{ phone }</p><p><b>Nom vCard : </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Statut de la commande de carte NFC',
                'email_template_content' => '<h2>Bonjour, <b>{ name }</b></h2><p>Le statut de votre commande a changé</p><p><b>Statut de la commande : </b>{ status }</p><p>Merci & Cordialement,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Achat du produit réussi',
                'email_template_content' => '<h2>Bonjour, { customername }</h2><p>Votre commande a été confirmée avec succès.</p><p><b>Nom du produit :</b> { productname }</p><p><b>Prix du produit :</b> { productprice }</p><p><b>Adresse :</b> { address }</p><p><b>Type de paiement :</b> { paymenttype }</p><p><b>Date de la commande :</b> { orderdate }</p><p>Merci & Cordialement,<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Achat du produit réussi',
                'email_template_content' => '<h2>Bonjour, { customername }</h2><p>{ customername } a acheté votre produit.</p><p><b>Nom du client :</b> { customername }</p><p><b>Nom du produit :</b> { productname }</p><p><b>Numéro de téléphone :</b> { phone }</p><p><b>Adresse :</b> { address }</p><p><b>Type de paiement :</b> { paymenttype }</p><p><b>Date de la commande :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Invitation reçue',
                'email_template_content' => '<h2>Bonjour,</h2><p>Vous avez reçu une invitation de { name }</p>Veuillez cliquer sur le lien ci-dessous pour vous inscrire.<p>{ referralurl }</p><p></p><p>Merci & Cordialement,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Achat d\'abonnement réussi',
                'email_template_content' => '<h2>Bonjour, { firstname } { lastname }</h2><p>Vous avez acheté le forfait { planname } avec succès</p><p>Merci & Cordialement,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Prendre rendez-vous',
                'email_template_content' => '<h2>Bonjour, <b>{ toname }</b></h2><p><b>{ name } a pris un rendez-vous avec vous</b>.</p><p><b>Heure du rendez-vous : </b>{ date } - { fromtime } à { totime }</p><p><b>Nom vCard : </b>{ vcardname }</p><p><b>Numéro de téléphone : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Demande de retrait approuvée',
                'email_template_content' => '<h2>Bonjour, <b>{ toname }</b></h2><p><b>Votre demande de retrait d\'un montant de { amount } a été approuvée</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Demande de retrait refusée',
                'email_template_content' => '<h2>Bonjour, <b>{ toname }</b></h2><p><b>Votre demande de retrait d\'un montant de { amount } a été refusée.</b></p><p><b>Raison :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Prendre rendez-vous',
                'email_template_content' => '<h2>Bonjour, <b>{ name }</b></h2><p>Votre rendez-vous a été réservé avec succès le { date } entre { fromtime } et { totime }</p><p>Merci & Cordialement,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Demande',
                'email_template_content' => '<h2>Voici les détails de la demande</h2><p><b>Nom : </b>{ name }</p><p><b>Email : </b>{ email }</p><p><b>Sujet : </b>{ subject }</p><p><b>Message : </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'fr')->value('id'),
                'email_template_subject' => 'Achat du produit réussi',
                'email_template_content' => '<h2>Bonjour, { username }</h2><p>{ customername } a acheté votre produit.</p><p><b>Nom du client : </b>{ customername }</p><p><b>Nom du produit : </b>{ productname }</p><p><b>Numéro de téléphone : </b>{ phone }</p><p><b>Adresse : </b>{ address }</p><p><b>Date de la commande : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($frenchTemplates as $template) {
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
