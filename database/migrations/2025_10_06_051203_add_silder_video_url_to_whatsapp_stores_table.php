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
            $table->string('slider_video_banner')->nullable()->after('google_analytics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_stores', function (Blueprint $table) {
            $table->dropColumn('slider_video_banner');
        });
    }
};
