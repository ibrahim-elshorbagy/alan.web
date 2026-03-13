<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (Schema::hasColumn('shop_visits', 'cards_sold')) {
      Schema::table('shop_visits', function (Blueprint $table) {
        $table->dropColumn('cards_sold');
      });
    }
  }

  public function down(): void
  {
    if (!Schema::hasColumn('shop_visits', 'cards_sold')) {
      Schema::table('shop_visits', function (Blueprint $table) {
        $table->unsignedInteger('cards_sold')->default(0)->after('phone');
      });
    }
  }
};
