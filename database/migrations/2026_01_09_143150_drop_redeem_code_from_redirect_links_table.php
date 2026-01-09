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
    Schema::table('redirect_links', function (Blueprint $table) {
      $table->dropColumn('redeem_code');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('redirect_links', function (Blueprint $table) {
      $table->string('redeem_code', 16)->nullable();
    });
  }
};
