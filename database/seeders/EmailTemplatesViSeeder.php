<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesViSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vietnameseTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Người dùng mới đã đăng ký',
                'email_template_content' => '<h2>Xin chào,</h2><p>Một người dùng mới vừa đăng ký!</p><h4>Tên: { firstname } { lastname }</h4><h4>Email: { email }</h4><p>Trân trọng cảm ơn,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Cuộc hẹn đã được xác nhận',
                'email_template_content' => '<h2>Xin chào, { name }</h2><p>Cuộc hẹn của bạn đã được xác nhận thành công vào ngày { date } từ { fromtime } đến { totime }</p><p>Trân trọng cảm ơn,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Đã nhận được đơn đặt hàng thẻ NFC mới',
                'email_template_content' => '<h2>Xin chào,</h2><p>Bạn vừa nhận được đơn đặt hàng thẻ NFC mới từ { name }</p><p>Loại thẻ : { cardtype }</p><p>Tên vCard : { vcardname }</p><p>Địa chỉ giao hàng : { shippingaddress }</p><p>Ngày đặt hàng : { orderdate }</p><p>Trân trọng cảm ơn,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Yêu cầu',
                'email_template_content' => '<h2>Chi tiết yêu cầu như sau</h2><p><b>Tên: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Tin nhắn: </b>{ message }</p><p><b>Điện thoại: </b>{ phone }</p><p><b>Tên vCard : </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Trạng thái đơn hàng thẻ NFC',
                'email_template_content' => '<h2>Xin chào, <b>{ name }</b></h2><p>Trạng thái đơn hàng của bạn đã thay đổi</p><p><b>Trạng thái đơn hàng: </b>{ status }</p><p>Trân trọng cảm ơn,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Mua sản phẩm thành công',
                'email_template_content' => '<h2>Xin chào, { customername }</h2><p>Đơn hàng sản phẩm của bạn đã được xác nhận thành công.</p><p><b>Tên sản phẩm :</b> { productname }</p><p><b>Giá sản phẩm :</b> { productprice }</p><p><b>Địa chỉ :</b> { address }</p><p><b>Hình thức thanh toán :</b> { paymenttype }</p><p><b>Ngày đặt hàng :</b> { orderdate }</p><p>Trân trọng cảm ơn,<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Mua sản phẩm thành công',
                'email_template_content' => '<h2>Xin chào, { customername }</h2><p>{ customername } đã mua sản phẩm của bạn.</p><p><b>Tên khách hàng :</b> { customername }</p><p><b>Tên sản phẩm :</b> { productname }</p><p><b>Số điện thoại :</b> { phone }</p><p><b>Địa chỉ :</b> { address }</p><p><b>Hình thức thanh toán :</b> { paymenttype }</p><p><b>Ngày đặt hàng :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Đã nhận được lời mời',
                'email_template_content' => '<h2>Xin chào,</h2><p>Bạn đã nhận được lời mời từ { name }</p>Vui lòng nhấp vào liên kết bên dưới để đăng ký.<p>{ referralurl }</p><p></p><p>Trân trọng cảm ơn,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Mua gói đăng ký thành công',
                'email_template_content' => '<h2>Xin chào, { firstname } { lastname }</h2><p>Bạn đã mua thành công gói { planname }</p><p>Trân trọng cảm ơn,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Đặt lịch hẹn',
                'email_template_content' => '<h2>Xin chào, <b>{ toname }</b></h2><p><b>{ name } đã đặt lịch hẹn với bạn</b>.</p><p><b>Thời gian hẹn : </b>{ date } - { fromtime } đến { totime }</p><p><b>Tên vCard : </b>{ vcardname }</p><p><b>Số điện thoại : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Yêu cầu rút tiền đã được phê duyệt',
                'email_template_content' => '<h2>Xin chào, <b>{ toname }</b></h2><p><b>Yêu cầu rút tiền của bạn với số tiền { amount } đã được phê duyệt</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Yêu cầu rút tiền đã bị từ chối',
                'email_template_content' => '<h2>Xin chào, <b>{ toname }</b></h2><p><b>Yêu cầu rút tiền của bạn với số tiền { amount } đã bị từ chối.</b></p><p><b>Lý do :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Đặt lịch hẹn',
                'email_template_content' => '<h2>Xin chào, <b>{ name }</b></h2><p>Lịch hẹn của bạn đã được đặt thành công vào ngày { date } từ { fromtime } đến { totime }</p><p>Trân trọng cảm ơn,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Yêu cầu',
                'email_template_content' => '<h2>Chi tiết yêu cầu như sau</h2><p><b>Tên: </b>{ name }</p><p><b>Email: </b>{ email }</p><p><b>Chủ đề: </b>{ subject }</p><p><b>Tin nhắn: </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'vi')->value('id'),
                'email_template_subject' => 'Mua sản phẩm thành công',
                'email_template_content' => '<h2>Xin chào, { username }</h2><p>{ customername } đã mua sản phẩm của bạn.</p><p><b>Tên khách hàng : </b>{ customername }</p><p><b>Tên sản phẩm : </b>{ productname }</p><p><b>Số điện thoại : </b>{ phone }</p><p><b>Địa chỉ : </b>{ address }</p><p><b>Ngày đặt hàng : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($vietnameseTemplates as $template) {
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
