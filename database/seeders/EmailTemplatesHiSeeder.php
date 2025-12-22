<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplatesHiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hindiTemplates = [
            [
                'email_template_type' => 0,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'नया उपयोगकर्ता पंजीकृत हुआ',
                'email_template_content' => '<h2>नमस्ते,</h2><p>एक नया उपयोगकर्ता पंजीकृत हुआ है!</p><h4>नाम: { firstname } { lastname }</h4><h4>ईमेल: { email }</h4><p>धन्यवाद एवं शुभकामनाएं,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 1,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'नियुक्ति स्वीकृत',
                'email_template_content' => '<h2>नमस्ते, { name }</h2><p>आपकी नियुक्ति { date } को { fromtime } से { totime } के बीच सफलतापूर्वक स्वीकृत हुई</p><p>धन्यवाद एवं शुभकामनाएं,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 2,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'नया NFC कार्ड ऑर्डर प्राप्त हुआ',
                'email_template_content' => '<h2>नमस्ते,</h2><p>आपको { name } से नया NFC कार्ड ऑर्डर प्राप्त हुआ है</p><p>कार्ड प्रकार : { cardtype }</p><p>vCard नाम : { vcardname }</p><p>शिपिंग पता : { shippingaddress }</p><p>ऑर्डर तिथि : { orderdate }</p><p>धन्यवाद एवं शुभकामनाएं,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 3,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'पूछताछ',
                'email_template_content' => '<h2>यहाँ पूछताछ का विवरण है</h2><p><b>नाम: </b>{ name }</p><p><b>ईमेल: </b>{ email }</p><p><b>संदेश: </b>{ message }</p><p><b>फ़ोन: </b>{ phone }</p><p><b>vCard नाम: </b>{ vcardname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 4,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'NFC कार्ड ऑर्डर स्थिति',
                'email_template_content' => '<h2>नमस्ते, <b>{ name }</b></h2><p>आपके ऑर्डर की स्थिति बदल गई है</p><p><b>ऑर्डर स्थिति: </b>{ status }</p><p>धन्यवाद एवं शुभकामनाएं,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 5,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'उत्पाद खरीद सफल',
                'email_template_content' => '<h2>नमस्ते, { customername }</h2><p>आपका उत्पाद ऑर्डर सफलतापूर्वक पुष्टि हो गया है।</p><p><b>उत्पाद नाम :</b> { productname }</p><p><b>उत्पाद मूल्य :</b> { productprice }</p><p><b>पता :</b> { address }</p><p><b>भुगतान प्रकार :</b> { paymenttype }</p><p><b>ऑर्डर तिथि :</b> { orderdate }</p><p>धन्यवाद एवं शुभकामनाएं,<br>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 6,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'उत्पाद खरीद सफल',
                'email_template_content' => '<h2>नमस्ते, { customername }</h2><p>{ customername } ने आपका उत्पाद खरीदा है।</p><p><b>ग्राहक नाम :</b> { customername }</p><p><b>उत्पाद नाम :</b> { productname }</p><p><b>फोन नंबर :</b> { phone }</p><p><b>पता :</b> { address }</p><p><b>भुगतान प्रकार :</b> { paymenttype }</p><p><b>ऑर्डर तिथि :</b> { orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 7,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'निमंत्रण प्राप्त हुआ',
                'email_template_content' => '<h2>नमस्ते,</h2><p>आपको { name } से एक निमंत्रण प्राप्त हुआ है</p>पंजीकरण के लिए कृपया नीचे दिए गए लिंक पर क्लिक करें।<p>{ referralurl }</p><p></p><p>धन्यवाद एवं शुभकामनाएं,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 8,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'सब्सक्रिप्शन खरीद सफल',
                'email_template_content' => '<h2>नमस्ते, { firstname } { lastname }</h2><p>आपने { planname } प्लान सफलतापूर्वक खरीदा है</p><p>धन्यवाद एवं शुभकामनाएं,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 9,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'नियुक्ति बुक करें',
                'email_template_content' => '<h2>नमस्ते, <b>{ toname }</b></h2><p><b>{ name } ने आपके साथ नियुक्ति बुक की है</b>।</p><p><b>नियुक्ति समय : </b>{ date } - { fromtime } से { totime }</p><p><b>vCard नाम : </b>{ vcardname }</p><p><b>फोन नंबर : </b>{ phone }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 10,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'निकासी अनुरोध स्वीकृत',
                'email_template_content' => '<h2>नमस्ते, <b>{ toname }</b></h2><p><b>आपका { amount } राशि का निकासी अनुरोध स्वीकृत किया गया है</b></p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 11,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'निकासी अनुरोध अस्वीकृत',
                'email_template_content' => '<h2>नमस्ते, <b>{ toname }</b></h2><p><b>आपका { amount } राशि का निकासी अनुरोध अस्वीकृत किया गया है।</b></p><p><b>कारण :</b></p><p style="text-align: justify">{ rejectionnote }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 12,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'नियुक्ति बुक करें',
                'email_template_content' => '<h2>नमस्ते, <b>{ name }</b></h2><p>आपकी नियुक्ति { date } को { fromtime } से { totime } के बीच सफलतापूर्वक बुक हो गई है</p><p>धन्यवाद एवं शुभकामनाएं,</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 13,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'पूछताछ',
                'email_template_content' => '<h2>यहाँ पूछताछ का विवरण है</h2><p><b>नाम: </b>{ name }</p><p><b>ईमेल: </b>{ email }</p><p><b>विषय: </b>{ subject }</p><p><b>संदेश: </b>{ message }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'email_template_type' => 14,
                'language_id' => \App\Models\Language::where('iso_code', 'hi')->value('id'),
                'email_template_subject' => 'उत्पाद खरीद सफल',
                'email_template_content' => '<h2>नमस्ते, { username }</h2><p>{ customername } ने आपका उत्पाद खरीदा है।</p><p><b>ग्राहक नाम : </b>{ customername }</p><p><b>उत्पाद नाम : </b>{ productname }</p><p><b>फोन नंबर : </b>{ phone }</p><p><b>पता : </b>{ address }</p><p><b>ऑर्डर तिथि : </b>{ orderdate }</p><p>{ appname }</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($hindiTemplates as $template) {
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
