<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Create contest_participants table.
   * Stores people who joined a contest  for a specific redirect link's ad setting.
   */
  public function up(): void
  {
    Schema::create('contest_participants', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('sales_advertise_setting_id');
      $table->string('name');
      $table->string('phone', 20); // stored as 962XXXXXXXXX
      $table->timestamps();

      $table->foreign('sales_advertise_setting_id')
        ->references('id')
        ->on('sales_advertise_settings')
        ->onDelete('cascade');

      // One phone per contest
      $table->unique(['sales_advertise_setting_id', 'phone']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('contest_participants');
  }
};
