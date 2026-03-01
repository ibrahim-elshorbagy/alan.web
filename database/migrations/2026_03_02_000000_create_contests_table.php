<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('contests', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('redirect_link_id');
      $table->string('title');
      $table->text('text')->nullable();
      $table->dateTime('draw_date');
      $table->boolean('is_enabled')->default(false);
      $table->tinyInteger('num_winners')->unsigned()->default(1);
      $table->timestamps();

      $table->foreign('redirect_link_id')
        ->references('id')->on('redirect_links')
        ->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('contests');
  }
};
