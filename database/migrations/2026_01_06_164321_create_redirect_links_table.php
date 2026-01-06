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
    Schema::create('redirect_links', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->nullable();
      $table->string('redeem_code', 16)->nullable();
      $table->string('uri')->unique();
      $table->text('redirect_link')->nullable();
      $table->unsignedTinyInteger('redirect_link_type');
      $table->unsignedTinyInteger('status')->default(0); // 0=not redeemed, 1=redeemed
      $table->unsignedBigInteger('nfcs_id');
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('nfcs_id')->references('id')->on('nfcs')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('redirect_links');
  }
};
