<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Change sales_advertise_settings from per-user (sales) level
   * to per-redirect_link level.
   *
   * - Drop user_id foreign + unique + column
   * - Add redirect_link_id foreign + unique
   */
  public function up(): void
  {
    Schema::table('sales_advertise_settings', function (Blueprint $table) {
      // Drop existing user_id foreign key and column
      $table->dropForeign(['user_id']);
      $table->dropUnique(['user_id']);
      $table->dropColumn('user_id');

      // Add redirect_link_id
      $table->unsignedBigInteger('redirect_link_id')->unique()->after('id');
      $table->foreign('redirect_link_id')->references('id')->on('redirect_links')->onDelete('cascade');
    });
  }

  /**
   * Reverse: restore user_id, drop redirect_link_id.
   */
  public function down(): void
  {
    Schema::table('sales_advertise_settings', function (Blueprint $table) {
      $table->dropForeign(['redirect_link_id']);
      $table->dropUnique(['redirect_link_id']);
      $table->dropColumn('redirect_link_id');

      $table->unsignedBigInteger('user_id')->unique()->after('id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }
};
