<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $templates = [
            'vcard16' => 'assets/img/new_vcard_templates/vcard16.png',
            'vcard17' => 'assets/img/templates/vcard17.png',
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
        Schema::table('seeder', function (Blueprint $table) {
            //
        });
    }
};
