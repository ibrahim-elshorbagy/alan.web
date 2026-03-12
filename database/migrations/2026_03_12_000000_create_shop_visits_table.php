<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('shop_visits', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('sales_user_id');
      $table->string('city');
      $table->string('area');
      $table->string('street');
      $table->string('shop_name');
      $table->string('phone', 20);
      $table->unsignedInteger('cards_sold')->default(0);
      $table->text('notes')->nullable();
      $table->timestamp('visited_at');
      $table->timestamps();

      $table->foreign('sales_user_id')
        ->references('id')->on('users')
        ->onDelete('cascade');

      $table->index('sales_user_id');
      $table->index('visited_at');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('shop_visits');
  }
};
