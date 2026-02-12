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
    Schema::create('redirect_link_acknowledgments', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('sales_user_id'); // The sales representative
      $table->unsignedBigInteger('created_by'); // Super admin who created it
      $table->json('redirect_link_ids'); // Array of redirect link IDs
      $table->decimal('total_price', 10, 2)->default(0);
      $table->decimal('total_sales_price', 10, 2)->default(0);
      $table->integer('total_count')->default(0);
      $table->string('signature_file')->nullable(); // Uploaded signature image/pdf
      $table->text('notes')->nullable();
      $table->timestamps();

      $table->foreign('sales_user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('redirect_link_acknowledgments');
  }
};
