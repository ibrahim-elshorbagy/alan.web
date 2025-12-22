<?php

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
        Schema::table('whatsapp_stores', function (Blueprint $table) {
            $table->boolean('news_letter_popup')->default(true)->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_stores', function (Blueprint $table) {
            $table->dropColumn('news_letter_popup');
        });
    }
};
