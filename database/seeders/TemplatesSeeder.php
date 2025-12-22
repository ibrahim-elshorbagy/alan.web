<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            'vcard1' => ('assets/img/templates/vcard1.png'),
            'vcard2' => ('assets/img/templates/vcard2.png'),
            'vcard3' => ('assets/img/templates/vcard3.png'),
            'vcard4' => ('assets/img/templates/vcard4.png'),
            'vcard5' => ('assets/img/templates/vcard5.png'),
            'vcard6' => ('assets/img/templates/vcard6.png'),
            'vcard7' => ('assets/img/templates/vcard7.png'),
            'vcard8' => ('assets/img/templates/vcard8.png'),
            'vcard9' => ('assets/img/templates/vcard9.png'),
            'vcard10' => ('assets/img/templates/vcard10.png'),
            'vcard11' => ('assets/img/templates/vcard11.png'),
            'vcard12' => ('assets/img/templates/vcard12.png'),
            'vcard13' => ('assets/img/templates/vcard13.png'),
            'vcard14' => ('assets/img/templates/vcard14.png'),
            'vcard15' => ('assets/img/templates/vcard15.png'),
            'vcard16' => ('assets/img/templates/vcard16.png'),
            'vcard17' => ('assets/img/templates/vcard17.png'),
            'vcard18' => ('assets/img/templates/vcard18.png'),
            'vcard19' => ('assets/img/templates/vcard19.png'),
            'vcard20' => ('assets/img/templates/vcard20.png'),
            'vcard21' => ('assets/img/templates/vcard21.png'),
            'vcard22' => ('assets/img/templates/vcard22.png'),
            'vcard23' => ('assets/img/templates/vcard23.png'),
            'vcard24' => ('assets/img/templates/vcard24.png'),
            'vcard25' => ('assets/img/templates/vcard25.png'),
            'vcard26' => ('assets/img/templates/vcard26.png'),
            'vcard27' => ('assets/img/templates/vcard27.png'),
            'vcard28' => ('assets/img/templates/vcard28.png'),
            'vcard29' => ('assets/img/templates/vcard29.png'),
            'vcard30' => ('assets/img/templates/vcard30.png'),
            'vcard31' => ('assets/img/templates/vcard31.png'),
            'vcard32' => ('assets/img/templates/vcard32.png'),
            'vcard33' => ('assets/img/templates/vcard33.png'),
            'vcard34' => ('assets/img/templates/vcard34.png'),
            'vcard35' => ('assets/img/templates/vcard35.png'),
            'vcard36' => ('assets/img/templates/vcard36.png'),
            'vcard37' => ('assets/img/templates/vcard37.png'),
            'vcard38' => ('assets/img/new_vcard_templates/vcard38.png'),
            'oldVcard12' => ('assets/img/old_vcard_templates/vcard12.png'),
            'oldVcard13' => ('assets/img/old_vcard_templates/vcard13.png'),
            'oldVcard14' => ('assets/img/old_vcard_templates/vcard14.png'),
            'oldVcard15' => ('assets/img/old_vcard_templates/vcard15.png'),
            'oldVcard16' => ('assets/img/old_vcard_templates/vcard16.png'),
            'oldVcard17' => ('assets/img/old_vcard_templates/vcard17.png'),
            'oldVcard18' => ('assets/img/old_vcard_templates/vcard18.png'),
            'oldVcard19' => ('assets/img/old_vcard_templates/vcard19.png'),
            'oldVcard20' => ('assets/img/old_vcard_templates/vcard20.png'),
            'oldVcard21' => ('assets/img/old_vcard_templates/vcard21.png'),
            'oldVcard22' => ('assets/img/old_vcard_templates/vcard22.png'),
            'oldVcard23' => ('assets/img/old_vcard_templates/vcard23.png'),
            'oldVcard24' => ('assets/img/old_vcard_templates/vcard24.png'),
            'oldVcard25' => ('assets/img/old_vcard_templates/vcard25.png'),
            'oldVcard26' => ('assets/img/old_vcard_templates/vcard26.png'),
            'oldVcard27' => ('assets/img/old_vcard_templates/vcard27.png'),
            'oldVcard28' => ('assets/img/old_vcard_templates/vcard28.png'),
            'oldVcard29' => ('assets/img/old_vcard_templates/vcard29.png'),
            'oldVcard30' => ('assets/img/old_vcard_templates/vcard30.png'),
            'oldVcard31' => ('assets/img/old_vcard_templates/vcard31.png'),
            'oldVcard32' => ('assets/img/old_vcard_templates/vcard32.png'),
            'oldVcard33' => ('assets/img/old_vcard_templates/vcard33.png'),
            'oldVcard34' => ('assets/img/old_vcard_templates/vcard34.png'),
            'oldVcard35' => ('assets/img/old_vcard_templates/vcard35.png'),
            'oldVcard36' => ('assets/img/old_vcard_templates/vcard36.png'),
            'oldVcard37' => ('assets/img/old_vcard_templates/vcard37.png'),
            'vcard39' => ('assets/img/new_vcard_templates/vcard39.png'),
        ];

        foreach ($templates as $name => $template) {
            $templates = Template::where('name', $name)->exists();
            if (!$templates) {
             Template::create(['name' => $name, 'path' => $template]);
            }
        }
    }
}
