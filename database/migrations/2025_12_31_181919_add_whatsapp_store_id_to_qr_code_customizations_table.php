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
    Schema::table('qr_code_customizations', function (Blueprint $table) {
      if (!Schema::hasColumn('qr_code_customizations', 'whatsapp_store_id')) {
        $table->unsignedBigInteger('whatsapp_store_id')->nullable()->after('vcard_id');
      }

      if (!Schema::hasColumn('qr_code_customizations', 'is_global')) {
        $table->boolean('is_global')->default(false)->after('whatsapp_store_id');
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('qr_code_customizations', function (Blueprint $table) {
      if (Schema::hasColumn('qr_code_customizations', 'whatsapp_store_id')) {
        $table->dropColumn('whatsapp_store_id');
      }

      if (Schema::hasColumn('qr_code_customizations', 'is_global')) {
        $table->dropColumn('is_global');
      }
    });
  }
};