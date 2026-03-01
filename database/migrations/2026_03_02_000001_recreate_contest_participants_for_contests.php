<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    // Drop the old contest_participants table (Phase 1)
    Schema::dropIfExists('contest_participants');

    // Recreate with contest_id FK + winner columns
    Schema::create('contest_participants', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('contest_id');
      $table->string('name');
      $table->string('phone', 20);
      $table->tinyInteger('winner_rank')->unsigned()->nullable(); // 1, 2, 3
      $table->timestamp('won_at')->nullable();
      $table->timestamps();

      $table->unique(['contest_id', 'phone']);

      $table->foreign('contest_id')
        ->references('id')->on('contests')
        ->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('contest_participants');

    // Restore Phase 1 structure
    Schema::create('contest_participants', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('sales_advertise_setting_id');
      $table->string('name');
      $table->string('phone', 20);
      $table->timestamps();

      $table->unique(['sales_advertise_setting_id', 'phone']);
      $table->foreign('sales_advertise_setting_id')
        ->references('id')->on('sales_advertise_settings')
        ->onDelete('cascade');
    });
  }
};
