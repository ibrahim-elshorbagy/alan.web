<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesZhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chineseTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '新用户注册',
                'email_template_content' => '<h2>你好，</h2><p>有新的用户已注册！</p><h4>姓名：{ firstname } { lastname }</h4><h4>邮箱：{ email }</h4><p>感谢与问候，</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '预约已批准',
                'email_template_content' => '<h2>你好，{ name }</h2><p>您的预约已于 { date } 在 { fromtime } 到 { totime } 之间成功批准</p><p>感谢与问候，</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '收到新的NFC卡订单',
                'email_template_content' => '<h2>你好，</h2><p>您已收到来自 { name } 的新NFC卡订单</p><p>卡类型：{ cardtype }</p><p>vCard名称：{ vcardname }</p><p>收货地址：{ shippingaddress }</p><p>订单日期：{ orderdate }</p><p>感谢与问候，</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '咨询',
                'email_template_content' => '<h2>以下是咨询详情</h2><p><b>姓名：</b>{ name }</p><p><b>邮箱：</b>{ email }</p><p><b>信息：</b>{ message }</p><p><b>电话：</b>{ phone }</p><p><b>vCard名称：</b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => 'NFC卡订单状态',
                'email_template_content' => '<h2>你好，<b>{ name }</b></h2><p>您的订单状态已变更</p><p><b>订单状态：</b>{ status }</p><p>感谢与问候，</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '产品购买成功',
                'email_template_content' => '<h2>你好，{ customername }</h2><p>您的产品订单已成功确认。</p><p><b>产品名称：</b> { productname }</p><p><b>产品价格：</b> { productprice }</p><p><b>地址：</b> { address }</p><p><b>支付类型：</b> { paymenttype }</p><p><b>下单时间：</b> { orderdate }</p><p>感谢与问候，<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '产品购买成功',
                'email_template_content' => '<h2>你好，{ customername }</h2><p>{ customername } 已购买了您的产品。</p><p><b>客户姓名：</b> { customername }</p><p><b>产品名称：</b> { productname }</p><p><b>手机号码：</b> { phone }</p><p><b>地址：</b> { address }</p><p><b>支付类型：</b> { paymenttype }</p><p><b>下单时间：</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '收到邀请',
                'email_template_content' => '<h2>你好，</h2><p>你收到了来自 { name } 的邀请</p>请点击下方链接进行注册。<p>{ referralurl }</p><p></p><p>感谢与问候，</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '订阅购买成功',
                'email_template_content' => '<h2>你好，{ firstname } { lastname }</h2><p>你已成功购买 { planname } 套餐</p><p>感谢与问候，</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '预约',
                'email_template_content' => '<h2>你好，<b>{ toname }</b></h2><p><b>{ name } 已预约与你</b>。</p><p><b>预约时间：</b>{ date } - { fromtime } 到 { totime }</p><p><b>vCard名称：</b>{ vcardname }</p><p><b>手机号码：</b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '提现请求已批准',
                'email_template_content' => '<h2>你好，<b>{ toname }</b></h2><p><b>你的提现请求 { amount } 已被批准</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '提现请求被拒绝',
                'email_template_content' => '<h2>你好，<b>{ toname }</b></h2><p><b>你的提现请求 { amount } 已被拒绝。</b></p><p><b>原因：</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '预约',
                'email_template_content' => '<h2>你好，<b>{ name }</b></h2><p>你的预约已成功预订于 { date } 在 { fromtime } 到 { totime } 之间</p><p>感谢与问候，</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '咨询',
                'email_template_content' => '<h2>以下是咨询详情</h2><p><b>姓名：</b>{ name }</p><p><b>邮箱：</b>{ email }</p><p><b>主题：</b>{ subject }</p><p><b>信息：</b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'zh')->value('id'),
                'email_template_subject' => '产品购买成功',
                'email_template_content' => '<h2>你好，{ username }</h2><p>{ customername } 已购买了您的产品。</p><p><b>客户姓名：</b>{ customername }</p><p><b>产品名称：</b>{ productname }</p><p><b>手机号码：</b>{ phone }</p><p><b>地址：</b>{ address }</p><p><b>下单时间：</b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($chineseTemplates as $template) {
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
