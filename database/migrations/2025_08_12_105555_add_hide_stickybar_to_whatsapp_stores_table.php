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
            $table->boolean('hide_stickybar')->default(false);
            $table->boolean('enable_download_qr_code')->default(true);
            $table->integer('qr_code_download_size')->default(200);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_stores', function (Blueprint $table) {
            $table->dropColumn('hide_stickybar');
            $table->dropColumn('enable_download_qr_code');
            $table->dropColumn('qr_code_download_size');
        });
    }
};
