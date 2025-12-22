<?php

use App\Models\Language;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $languageExists = Language::where('name', 'Persian')->exists();
            if (!$languageExists) {
                Language::create(['name' => 'Persian', 'iso_code' => 'fa', 'is_default' => false, 'status' => true]);
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
