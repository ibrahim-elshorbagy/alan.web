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
            $table->text('site_title')->nullable()->after('tenant_id');
            $table->text('home_title')->nullable()->after('site_title');
            $table->text('meta_keyword')->nullable()->after('home_title');
            $table->text('meta_description')->nullable()->after('meta_keyword');
            $table->longText('google_analytics')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_stores', function (Blueprint $table) {
            $table->text('site_title')->nullable()->after('tenant_id');
            $table->text('home_title')->nullable()->after('site_title');
            $table->text('meta_keyword')->nullable()->after('home_title');
            $table->text('meta_description')->nullable()->after('meta_keyword');
            $table->longText('google_analytics')->nullable()->after('meta_description');
        });
    }
};
