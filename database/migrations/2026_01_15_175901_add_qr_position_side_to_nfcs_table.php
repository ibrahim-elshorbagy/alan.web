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
    Schema::table('nfcs', function (Blueprint $table) {
      $table->string('qr_position_side')->default('front')->after('qr_size');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('nfcs', function (Blueprint $table) {
      $table->dropColumn('qr_position_side');
    });
  }
};