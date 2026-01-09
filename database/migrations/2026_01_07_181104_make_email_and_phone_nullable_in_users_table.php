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
    Schema::table('users', function (Blueprint $table) {
      // Drop existing unique constraint on email
      $table->dropUnique(['email']);

      // Make email nullable and add unique constraint that allows nulls
      $table->string('email')->nullable()->change();
      $table->unique('email');

      // Add unique constraint to contact (phone) and make it nullable
      $table->string('contact')->nullable()->unique()->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      // Revert email to not nullable and keep unique
      $table->string('email', 191)->nullable(false)->change();

      // Remove unique constraint from contact and keep it nullable
      $table->dropUnique(['contact']);
      $table->string('contact')->nullable()->change();
    });
  }
};
