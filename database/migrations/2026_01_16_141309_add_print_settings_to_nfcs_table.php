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
      $table->string('print_format')->default('fixed')->after('image_height'); // 'fixed' or 'a5'
      $table->boolean('print_front_image')->default(true)->after('print_format');
      $table->boolean('print_back_image')->default(true)->after('print_front_image');
      $table->boolean('print_only_qr')->default(false)->after('print_back_image');
      $table->integer('text_font_size')->default(14)->after('print_only_qr');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('nfcs', function (Blueprint $table) {
      $table->dropColumn(['print_format', 'print_front_image', 'print_back_image', 'print_only_qr', 'text_font_size']);
    });
  }
};
