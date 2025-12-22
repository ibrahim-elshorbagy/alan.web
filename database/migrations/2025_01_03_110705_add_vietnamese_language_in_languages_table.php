<?php

use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $languageExists = Language::where('name', 'Vietnamese')->exists();
            if (!$languageExists) {
                Language::create(['name' => 'Vietnamese', 'iso_code' => 'vi', 'is_default' => false, 'status' => true]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            //
        });
    }
};
