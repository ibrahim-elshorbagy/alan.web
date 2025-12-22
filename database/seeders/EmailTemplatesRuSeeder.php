<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesRuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $russianTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Новый пользователь зарегистрирован',
                'email_template_content' => '<h2>Здравствуйте,</h2><p>Новый пользователь был зарегистрирован!</p><h4>Имя: { firstname } { lastname }</h4><h4>Электронная почта: { email }</h4><p>Спасибо и с уважением,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Встреча подтверждена',
                'email_template_content' => '<h2>Здравствуйте, { name }</h2><p>Ваша встреча была успешно подтверждена на { date } между { fromtime } и { totime }</p><p>Спасибо и с уважением,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Получен новый заказ на карту NFC',
                'email_template_content' => '<h2>Здравствуйте,</h2><p>Вы получили новый заказ на карту NFC от { name }</p><p>Тип карты : { cardtype }</p><p>Имя vCard : { vcardname }</p><p>Адрес доставки : { shippingaddress }</p><p>Дата заказа : { orderdate }</p><p>Спасибо и с уважением,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Запрос',
                'email_template_content' => '<h2>Вот детали запроса</h2><p><b>Имя: </b>{ name }</p><p><b>Электронная почта: </b>{ email }</p><p><b>Сообщение: </b>{ message }</p><p><b>Телефон: </b>{ phone }</p><p><b>Имя vCard: </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Статус заказа карты NFC',
                'email_template_content' => '<h2>Здравствуйте, <b>{ name }</b></h2><p>Статус вашего заказа изменился</p><p><b>Статус заказа: </b>{ status }</p><p>Спасибо и с уважением,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Покупка товара успешна',
                'email_template_content' => '<h2>Здравствуйте, { customername }</h2><p>Ваш заказ на товар успешно подтвержден.</p><p><b>Название товара :</b> { productname }</p><p><b>Цена товара :</b> { productprice }</p><p><b>Адрес :</b> { address }</p><p><b>Тип оплаты :</b> { paymenttype }</p><p><b>Дата заказа :</b> { orderdate }</p><p>Спасибо и с уважением,<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Покупка товара успешна',
                'email_template_content' => '<h2>Здравствуйте, { customername }</h2><p>{ customername } приобрел ваш продукт.</p><p><b>Имя клиента :</b> { customername }</p><p><b>Название товара :</b> { productname }</p><p><b>Номер телефона :</b> { phone }</p><p><b>Адрес :</b> { address }</p><p><b>Тип оплаты :</b> { paymenttype }</p><p><b>Дата заказа :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Получено приглашение',
                'email_template_content' => '<h2>Здравствуйте,</h2><p>Вы получили приглашение от { name }</p>Пожалуйста, перейдите по ссылке ниже, чтобы зарегистрироваться.<p>{ referralurl }</p><p></p><p>Спасибо и с уважением,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Покупка подписки успешна',
                'email_template_content' => '<h2>Здравствуйте, { firstname } { lastname }</h2><p>Вы успешно приобрели тариф { planname }</p><p>Спасибо и с уважением,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Записаться на прием',
                'email_template_content' => '<h2>Здравствуйте, <b>{ toname }</b></h2><p><b>{ name } записался к вам на прием</b>.</p><p><b>Время приема : </b>{ date } - { fromtime } до { totime }</p><p><b>Имя vCard : </b>{ vcardname }</p><p><b>Номер телефона : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Запрос на вывод средств одобрен',
                'email_template_content' => '<h2>Здравствуйте, <b>{ toname }</b></h2><p><b>Ваш запрос на вывод средств на сумму { amount } был одобрен</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Запрос на вывод средств отклонен',
                'email_template_content' => '<h2>Здравствуйте, <b>{ toname }</b></h2><p><b>Ваш запрос на вывод средств на сумму { amount } был отклонен.</b></p><p><b>Причина :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Записаться на прием',
                'email_template_content' => '<h2>Здравствуйте, <b>{ name }</b></h2><p>Ваша запись была успешно забронирована на { date } между { fromtime } и { totime }</p><p>Спасибо и с уважением,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Запрос',
                'email_template_content' => '<h2>Вот детали запроса</h2><p><b>Имя: </b>{ name }</p><p><b>Электронная почта: </b>{ email }</p><p><b>Тема: </b>{ subject }</p><p><b>Сообщение: </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'ru')->value('id'),
                'email_template_subject' => 'Покупка товара успешна',
                'email_template_content' => '<h2>Здравствуйте, { username }</h2><p>{ customername } приобрел ваш продукт.</p><p><b>Имя клиента : </b>{ customername }</p><p><b>Название товара : </b>{ productname }</p><p><b>Номер телефона : </b>{ phone }</p><p><b>Адрес : </b>{ address }</p><p><b>Дата заказа : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($russianTemplates as $template) {
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
