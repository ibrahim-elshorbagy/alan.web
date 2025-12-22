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
        Schema::table('analytics', function (Blueprint $table) {
            $table->unsignedBigInteger('whatsapp_store_id')->nullable()->after('vcard_id');

            $table->foreign('whatsapp_store_id')->references('id')->on('whatsapp_stores')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analytics', function (Blueprint $table) {
            $table->dropColumn('whatsapp_store_id');
        });
    }
};
