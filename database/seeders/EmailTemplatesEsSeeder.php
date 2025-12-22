<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesEsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spanishTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Nuevo usuario registrado',
                'email_template_content' => '<h2>Hola,</h2><p>¡Un nuevo usuario ha sido registrado!</p><h4>Nombre: { firstname } { lastname }</h4><h4>Email: { email }</h4><p>Gracias y saludos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Cita aprobada',
                'email_template_content' => '<h2>Hola, { name }</h2><p>Su cita ha sido aprobada con éxito el { date } entre { fromtime } y { totime }</p><p>Gracias y saludos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Nuevo pedido de tarjeta NFC recibido',
                'email_template_content' => '<h2>Hola,</h2><p>Ha recibido un nuevo pedido de tarjeta NFC de { name }</p><p>Tipo de tarjeta : { cardtype }</p><p>Nombre vCard : { vcardname }</p><p>Dirección de envío : { shippingaddress }</p><p>Fecha de pedido : { orderdate }</p><p>Gracias y saludos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Consulta',
                'email_template_content' => '<h2>A continuación se muestran los detalles de la consulta</h2><p><b>Nombre: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Mensaje: </b>{ message }</p><p><b>Teléfono: </b>{ phone }</p><p><b>Nombre vCard: </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Estado del pedido de tarjeta NFC',
                'email_template_content' => '<h2>Hola, <b>{ name }</b></h2><p>El estado de su pedido ha cambiado</p><p><b>Estado del pedido: </b>{ status }</p><p>Gracias y saludos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Compra de producto exitosa',
                'email_template_content' => '<h2>Hola, { customername }</h2><p>Su pedido de producto ha sido confirmado con éxito.</p><p><b>Nombre del producto :</b> { productname }</p><p><b>Precio del producto :</b> { productprice }</p><p><b>Dirección :</b> { address }</p><p><b>Tipo de pago :</b> { paymenttype }</p><p><b>Fecha de pedido :</b> { orderdate }</p><p>Gracias y saludos,<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Compra de producto exitosa',
                'email_template_content' => '<h2>Hola, { customername }</h2><p>{ customername } ha comprado su producto.</p><p><b>Nombre del cliente :</b> { customername }</p><p><b>Nombre del producto :</b> { productname }</p><p><b>Número de teléfono :</b> { phone }</p><p><b>Dirección :</b> { address }</p><p><b>Tipo de pago :</b> { paymenttype }</p><p><b>Fecha de pedido :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Invitación recibida',
                'email_template_content' => '<h2>Hola,</h2><p>Ha recibido una invitación de { name }</p>Por favor, haga clic en el siguiente enlace para registrarse.<p>{ referralurl }</p><p></p><p>Gracias y saludos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Compra de suscripción exitosa',
                'email_template_content' => '<h2>Hola, { firstname } { lastname }</h2><p>Ha comprado el plan { planname } con éxito</p><p>Gracias y saludos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Reservar cita',
                'email_template_content' => '<h2>Hola, <b>{ toname }</b></h2><p><b>{ name } ha reservado una cita con usted</b>.</p><p><b>Hora de la cita : </b>{ date } - { fromtime } hasta { totime }</p><p><b>Nombre vCard: </b>{ vcardname }</p><p><b>Número de teléfono : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Solicitud de retiro aprobada',
                'email_template_content' => '<h2>Hola, <b>{ toname }</b></h2><p><b>Su solicitud de retiro por un monto de { amount } ha sido aprobada</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Solicitud de retiro rechazada',
                'email_template_content' => '<h2>Hola, <b>{ toname }</b></h2><p><b>Su solicitud de retiro por un monto de { amount } ha sido rechazada.</b></p><p><b>Motivo :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Reservar cita',
                'email_template_content' => '<h2>Hola, <b>{ name }</b></h2><p>Su cita ha sido reservada con éxito en { date } entre { fromtime } y { totime }</p><p>Gracias y saludos,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Consulta',
                'email_template_content' => '<h2>A continuación se muestran los detalles de la consulta</h2><p><b>Nombre: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Asunto: </b>{ subject }</p><p><b>Mensaje: </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'es')->value('id'),
                'email_template_subject' => 'Compra de producto exitosa',
                'email_template_content' => '<h2>Hola, { username }</h2><p>{ customername } ha comprado su producto.</p><p><b>Nombre del cliente : </b>{ customername }</p><p><b>Nombre del producto : </b>{ productname }</p><p><b>Número de teléfono : </b>{ phone }</p><p><b>Dirección : </b>{ address }</p><p><b>Fecha de pedido : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($spanishTemplates as $template) {
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
