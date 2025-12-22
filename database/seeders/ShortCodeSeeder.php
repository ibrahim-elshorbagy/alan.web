<?php

namespace Database\Seeders;

use App\Models\ShortCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShortCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shortCodes = [
            [
                'email_template_type' => 0,
                'short_code' => '{ firstname }',
                'value' => 'First Name',
            ],
            [
                'email_template_type' => 0,
                'short_code' => '{ lastname }',
                'value' => 'Last Name',
            ],
            [
                'email_template_type' => 0,
                'short_code' => '{ email }',
                'value' => 'Email',
            ],
            [
                'email_template_type' => 0,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 1,
                'short_code' => '{ name }',
                'value' => 'Name',
            ],
            [
                'email_template_type' => 1,
                'short_code' => '{ date }',
                'value' => 'Date',
            ],
            [
                'email_template_type' => 1,
                'short_code' => '{ fromtime }',
                'value' => 'From Time',
            ],
            [
                'email_template_type' => 1,
                'short_code' => '{ totime }',
                'value' => 'To Time',
            ],
            [
                'email_template_type' => 1,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 2,
                'short_code' => '{ name }',
                'value' => 'Name',
            ],
            [
                'email_template_type' => 2,
                'short_code' => '{ cardtype }',
                'value' => 'CardType',
            ],
            [
                'email_template_type' => 2,
                'short_code' => '{ vcardname }',
                'value' => 'VcardName',
            ],
            [
                'email_template_type' => 2,
                'short_code' => '{ shippingaddress }',
                'value' => 'Shipping Address',
            ],
            [
                'email_template_type' => 2,
                'short_code' => '{ orderdate }',
                'value' => 'Order Date',
            ],
            [
                'email_template_type' => 2,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 3,
                'short_code' => '{ name }',
                'value' => 'Name',
            ],
            [
                'email_template_type' => 3,
                'short_code' => '{ email }',
                'value' => 'Email',
            ],
            [
                'email_template_type' => 3,
                'short_code' => '{ message }',
                'value' => 'Message',
            ],
            [
                'email_template_type' => 3,
                'short_code' => '{ phone }',
                'value' => 'Phone',
            ],
            [
                'email_template_type' => 3,
                'short_code' => '{ vcardname }',
                'value' => 'Vcard Name',
            ],
            [
                'email_template_type' => 3,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 4,
                'short_code' => '{ name }',
                'value' => 'Name',
            ],
            [
                'email_template_type' => 4,
                'short_code' => '{ status }',
                'value' => 'Status',
            ],
            [
                'email_template_type' => 4,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 5,
                'short_code' => '{ customername }',
                'value' => 'Customer Name',
            ],
            [
                'email_template_type' => 5,
                'short_code' => '{ productname }',
                'value' => 'Product Name',
            ],
            [
                'email_template_type' => 5,
                'short_code' => '{ productprice }',
                'value' => 'Product Price',
            ],
            [
                'email_template_type' => 5,
                'short_code' => '{ address }',
                'value' => 'Address',
            ],
            [
                'email_template_type' => 5,
                'short_code' => '{ paymenttype }',
                'value' => 'Payment Type',
            ],
            [
                'email_template_type' => 5,
                'short_code' => '{ orderdate }',
                'value' => 'Order Date',
            ],
            [
                'email_template_type' => 5,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 6,
                'short_code' => '{ customername }',
                'value' => 'Customer Name',
            ],
            [
                'email_template_type' => 6,
                'short_code' => '{ productname }',
                'value' => 'Product Name',
            ],
            [
                'email_template_type' => 6,
                'short_code' => '{ phone }',
                'value' => 'Mobile Number',
            ],
            [
                'email_template_type' => 6,
                'short_code' => '{ address }',
                'value' => 'Address',
            ],
            [
                'email_template_type' => 6,
                'short_code' => '{ paymenttype }',
                'value' => 'Payment Type',
            ],
            [
                'email_template_type' => 6,
                'short_code' => '{ orderdate }',
                'value' => 'Order Date',
            ],
            [
                'email_template_type' => 6,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 7,
                'short_code' => '{ name }',
                'value' => 'Name',
            ],
            [
                'email_template_type' => 7,
                'short_code' => '{ referralurl }',
                'value' => 'Referral Url',
            ],
            [
                'email_template_type' => 7,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 8,
                'short_code' => '{ firstname }',
                'value' => 'First Name',
            ],
            [
                'email_template_type' => 8,
                'short_code' => '{ lastname }',
                'value' => 'Last Name',
            ],
            [
                'email_template_type' => 8,
                'short_code' => '{ planname }',
                'value' => 'Plan Name',
            ],
            [
                'email_template_type' => 8,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 9,
                'short_code' => '{ toname }',
                'value' => 'To Name',
            ],
            [
                'email_template_type' => 9,
                'short_code' => '{ name }',
                'value' => 'Name',
            ],
            [
                'email_template_type' => 9,
                'short_code' => '{ date }',
                'value' => 'Date',
            ],
            [
                'email_template_type' => 9,
                'short_code' => '{ fromtime }',
                'value' => 'From Time',
            ],
            [
                'email_template_type' => 9,
                'short_code' => '{ totime }',
                'value' => 'To Time',
            ],
            [
                'email_template_type' => 9,
                'short_code' => '{ vcardname }',
                'value' => 'Vcard Name',
            ],
            [
                'email_template_type' => 9,
                'short_code' => '{ phone }',
                'value' => 'Phone',
            ],
            [
                'email_template_type' => 9,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 10,
                'short_code' => '{ toname }',
                'value' => 'To Name',
            ],
            [
                'email_template_type' => 10,
                'short_code' => '{ amount }',
                'value' => 'Amount',
            ],
            [
                'email_template_type' => 10,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 11,
                'short_code' => '{ toname }',
                'value' => 'To Name',
            ],
            [
                'email_template_type' => 11,
                'short_code' => '{ amount }',
                'value' => 'Amount',
            ],
            [
                'email_template_type' => 11,
                'short_code' => '{ rejectionnote }',
                'value' => 'Rejection Note',
            ],
            [
                'email_template_type' => 11,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 9,
                'short_code' => '{ name }',
                'value' => 'Name',
            ],
            [
                'email_template_type' => 12,
                'short_code' => '{ date }',
                'value' => 'Appointment Date',
            ],
            [
                'email_template_type' => 12,
                'short_code' => '{ fromtime }',
                'value' => 'From Time',
            ],
            [
                'email_template_type' => 12,
                'short_code' => '{ totime }',
                'value' => 'To Time',
            ],
            [
                'email_template_type' => 12,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 13,
                'short_code' => '{ name }',
                'value' => 'Name',
            ],
            [
                'email_template_type' => 13,
                'short_code' => '{ email }',
                'value' => 'Email',
            ],
            [
                'email_template_type' => 13,
                'short_code' => '{ subject }',
                'value' => 'Subject',
            ],
            [
                'email_template_type' => 13,
                'short_code' => '{ message }',
                'value' => 'Message',
            ],
            [
                'email_template_type' => 13,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
            [
                'email_template_type' => 14,
                'short_code' => '{ username }',
                'value' => 'User Name',
            ],
            [
                'email_template_type' => 14,
                'short_code' => '{ customername }',
                'value' => 'Customer Name',
            ],
            [
                'email_template_type' => 14,
                'short_code' => '{ productname }',
                'value' => 'Product Name',
            ],
            [
                'email_template_type' => 14,
                'short_code' => '{ phone }',
                'value' => 'Phone',
            ],
            [
                'email_template_type' => 14,
                'short_code' => '{ address }',
                'value' => 'Delivery Address',
            ],
            [
                'email_template_type' => 14,
                'short_code' => '{ orderdate }',
                'value' => 'Order Date',
            ],
            [
                'email_template_type' => 14,
                'short_code' => '{ appname }',
                'value' => 'App Name',
            ],
        ];
        foreach ($shortCodes as $shortCode) {
            ShortCode::create($shortCode);
        }
    }
}
