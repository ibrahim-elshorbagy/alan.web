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
        Schema::table('vcards', function (Blueprint $table) {
            $table->string('location_type')->after('phone')->default(0)->nullable();
            $table->longText('location_embed_tag')->after('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->dropColumn('location_type');
            $table->dropColumn('location_embed_tag');
        });
    }
};
