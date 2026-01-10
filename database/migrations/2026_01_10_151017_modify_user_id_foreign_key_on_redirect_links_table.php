<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('redirect_links', function (Blueprint $table) {
      // Drop the existing foreign key
      $table->dropForeign(['user_id']);

      // Recreate the foreign key with onDelete('set null')
      $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });

  }
  
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {

    Schema::table('redirect_links', function (Blueprint $table) {
      // Drop the modified foreign key
      $table->dropForeign(['user_id']);

      // Recreate the original foreign key with onDelete('cascade')
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }
};