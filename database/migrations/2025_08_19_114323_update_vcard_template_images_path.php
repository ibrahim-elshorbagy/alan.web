<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $templates = [
            'vcard1' => 'assets/img/templates/vcard1.png',
            'vcard2' => 'assets/img/templates/vcard2.png',
            'vcard3' => 'assets/img/templates/vcard3.png',
            'vcard4' => 'assets/img/templates/vcard4.png',
            'vcard5' => 'assets/img/templates/vcard5.png',
            'vcard6' => 'assets/img/templates/vcard6.png',
            'vcard7' => 'assets/img/templates/vcard7.png',
            'vcard8' => 'assets/img/templates/vcard8.png',
            'vcard9' => 'assets/img/templates/vcard9.png',
            'vcard10' => 'assets/img/templates/vcard10.png',
            'vcard11' => 'assets/img/templates/vcard11.png',
            'vcard12' => 'assets/img/new_vcard_templates/vcard12.png',
            'vcard13' => 'assets/img/new_vcard_templates/vcard13.png',
            'vcard14' => 'assets/img/new_vcard_templates/vcard14.png',
            'vcard15' => 'assets/img/new_vcard_templates/vcard15.png',
            'vcard16' => 'assets/img/templates/vcard16.png',
            'vcard17' => 'assets/img/new_vcard_templates/vcard17.png',
            'vcard18' => 'assets/img/new_vcard_templates/vcard18.png',
            'vcard19' => 'assets/img/new_vcard_templates/vcard19.png',
            'vcard20' => 'assets/img/new_vcard_templates/vcard20.png',
            'vcard21' => 'assets/img/new_vcard_templates/vcard21.png',
            'vcard22' => 'assets/img/new_vcard_templates/vcard22.png',
            'vcard23' => 'assets/img/new_vcard_templates/vcard23.png',
            'vcard24' => 'assets/img/new_vcard_templates/vcard24.png',
            'vcard25' => 'assets/img/new_vcard_templates/vcard25.png',
            'vcard26' => 'assets/img/new_vcard_templates/vcard26.png',
            'vcard27' => 'assets/img/new_vcard_templates/vcard27.png',
            'vcard28' => 'assets/img/new_vcard_templates/vcard28.png',
            'vcard29' => 'assets/img/new_vcard_templates/vcard29.png',
            'vcard30' => 'assets/img/new_vcard_templates/vcard30.png',
            'vcard31' => 'assets/img/new_vcard_templates/vcard31.png',
            'vcard32' => 'assets/img/new_vcard_templates/vcard32.png',
            'vcard33' => 'assets/img/new_vcard_templates/vcard33.png',
            'vcard34' => 'assets/img/new_vcard_templates/vcard34.png',
            'vcard35' => 'assets/img/new_vcard_templates/vcard35.png',
            'vcard36' => 'assets/img/new_vcard_templates/vcard36.png',
            'vcard37' => 'assets/img/new_vcard_templates/vcard37.png',
        ];

        foreach ($templates as $name => $path) {
            DB::table('templates')->where('name', $name)->update(['path' => $path]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // optional: if you want, you can revert to old path here
    }
};
