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
    Schema::table('nfcs', function (Blueprint $table) {
      $table->boolean('apply_coordinates')->default(false)->after('price');
      $table->integer('qr_x_position')->nullable()->after('apply_coordinates');
      $table->integer('qr_y_position')->nullable()->after('qr_x_position');
      $table->integer('qr_size')->nullable()->after('qr_y_position');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('nfcs', function (Blueprint $table) {
      $table->dropColumn(['apply_coordinates', 'qr_x_position', 'qr_y_position', 'qr_size']);
    });
  }
};