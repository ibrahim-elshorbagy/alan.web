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
            $table->tinyInteger('week_format')
                ->default(1)    // 1 = Monday-Sunday
                ->comment('1 = Monday-Sunday, 2 = Sunday-Saturday')
                ->after('services_slider_view');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->dropColumn('week_format');
        });
    }
};
