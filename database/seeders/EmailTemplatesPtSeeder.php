<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesPtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portugueseTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Novo usuário registrado',
                'email_template_content' => '<h2>Olá,</h2><p>Um novo usuário foi registrado!</p><h4>Nome: { firstname } { lastname }</h4><h4>Email: { email }</h4><p>Obrigado e cumprimentos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Consulta aprovada',
                'email_template_content' => '<h2>Olá, { name }</h2><p>Sua consulta foi aprovada com sucesso em { date } entre { fromtime } e { totime }</p><p>Obrigado e cumprimentos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Novo pedido de cartão NFC recebido',
                'email_template_content' => '<h2>Olá,</h2><p>Você recebeu um novo pedido de cartão NFC de { name }</p><p>Tipo de cartão : { cardtype }</p><p>Nome vCard : { vcardname }</p><p>Endereço de envio : { shippingaddress }</p><p>Data do pedido : { orderdate }</p><p>Obrigado e cumprimentos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Consulta',
                'email_template_content' => '<h2>Aqui estão os detalhes da consulta</h2><p><b>Nome:</b> { name }</p><p><b>Email:</b> { email }</p><p><b>Mensagem:</b> { message }</p><p><b>Telefone: </b>{ phone }</p><p><b>Nome vCard: </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Status do Pedido do Cartão NFC',
                'email_template_content' => '<h2>Olá, <b>{ name }</b></h2><p>O status do seu pedido foi alterado</p><p><b>Status do pedido: </b>{ status }</p><p>Obrigado e cumprimentos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Compra de Produto Bem-sucedida',
                'email_template_content' => '<h2>Olá, { customername }</h2><p>Seu pedido de produto foi confirmado com sucesso.</p><p><b>Nome do produto :</b> { productname }</p><p><b>Preço do produto :</b> { productprice }</p><p><b>Endereço :</b> { address }</p><p><b>Tipo de pagamento :</b> { paymenttype }</p><p><b>Data do pedido :</b> { orderdate }</p><p>Obrigado e cumprimentos,<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Compra de Produto Bem-sucedida',
                'email_template_content' => '<h2>Olá, { customername }</h2><p>{ customername } comprou seu produto.</p><p><b>Nome do cliente :</b> { customername }</p><p><b>Nome do produto :</b> { productname }</p><p><b>Número de telefone :</b> { phone }</p><p><b>Endereço :</b> { address }</p><p><b>Tipo de pagamento :</b> { paymenttype }</p><p><b>Data do pedido :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Convite Recebido',
                'email_template_content' => '<h2>Olá,</h2><p>Você recebeu um convite de { name }</p>Por favor, clique no link abaixo para se registrar.<p>{ referralurl }</p><p></p><p>Obrigado e cumprimentos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Compra de Assinatura Bem-sucedida',
                'email_template_content' => '<h2>Olá, { firstname } { lastname }</h2><p>Você comprou o plano { planname } com sucesso</p><p>Obrigado e cumprimentos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Marcar Consulta',
                'email_template_content' => '<h2>Olá, <b>{ toname }</b></h2><p><b>{ name } marcou uma consulta com você</b>.</p><p><b>Horário da consulta: </b>{ date } - { fromtime } até { totime }</p><p><b>Nome vCard: </b>{ vcardname }</p><p><b>Número de telefone: </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Solicitação de Retirada Aprovada',
                'email_template_content' => '<h2>Olá, <b>{ toname }</b></h2><p><b>Sua solicitação de retirada no valor de { amount } foi aprovada</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Solicitação de Retirada Rejeitada',
                'email_template_content' => '<h2>Olá, <b>{ toname }</b></h2><p><b>Sua solicitação de retirada no valor de { amount } foi rejeitada.</b></p><p><b>Motivo :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Marcar Consulta',
                'email_template_content' => '<h2>Olá, <b>{ name }</b></h2><p>Sua consulta foi marcada com sucesso em { date } entre { fromtime } e { totime }</p><p>Obrigado e cumprimentos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Consulta',
                'email_template_content' => '<h2>Aqui estão os detalhes da consulta</h2><p><b>Nome:</b> { name }</p><p><b>Email:</b> { email }</p><p><b>Assunto:</b> { subject }</p><p><b>Mensagem:</b> { message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'pt')->value('id'),
                'email_template_subject' => 'Compra de Produto Bem-sucedida',
                'email_template_content' => '<h2>Olá, { username }</h2><p>{ customername } comprou seu produto.</p><p><b>Nome do cliente: </b>{ customername }</p><p><b>Nome do produto: </b>{ productname }</p><p><b>Número de telefone: </b>{ phone }</p><p><b>Endereço: </b>{ address }</p><p><b>Data do pedido: </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($portugueseTemplates as $template) {
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
