<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Add impressions JSON column to track per-image view counts.
   * Array is indexed by image position: [0 => 12, 1 => 8, ...]
   */
  public function up(): void
  {
    Schema::table('sales_advertise_settings', function (Blueprint $table) {
      $table->json('impressions')->nullable()->after('images');
    });
  }

  public function down(): void
  {
    Schema::table('sales_advertise_settings', function (Blueprint $table) {
      $table->dropColumn('impressions');
    });
  }
};
