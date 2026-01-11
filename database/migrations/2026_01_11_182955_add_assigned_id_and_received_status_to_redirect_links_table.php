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
      $table->unsignedBigInteger('assigned_id')->nullable()->after('nfc_order_id');
      $table->foreign('assigned_id')->references('id')->on('users')->onDelete('set null');
      $table->unsignedTinyInteger('received_status')->default(0)->after('assigned_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('redirect_links', function (Blueprint $table) {
      $table->dropForeign(['assigned_id']);
      $table->dropColumn(['assigned_id', 'received_status']);
    });
  }
};