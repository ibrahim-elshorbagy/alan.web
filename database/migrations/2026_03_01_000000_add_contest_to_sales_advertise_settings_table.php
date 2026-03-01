<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Add contest (مسابقة) fields to sales_advertise_settings table.
   * Each redirect link can have one optional contest when ads are enabled.
   */
  public function up(): void
  {
    Schema::table('sales_advertise_settings', function (Blueprint $table) {
      $table->boolean('contest_enabled')->default(false)->after('impressions');
      $table->string('contest_title')->nullable()->after('contest_enabled');
      $table->text('contest_text')->nullable()->after('contest_title');
      $table->dateTime('contest_draw_date')->nullable()->after('contest_text');
    });
  }

  public function down(): void
  {
    Schema::table('sales_advertise_settings', function (Blueprint $table) {
      $table->dropColumn(['contest_enabled', 'contest_title', 'contest_text', 'contest_draw_date']);
    });
  }
};
