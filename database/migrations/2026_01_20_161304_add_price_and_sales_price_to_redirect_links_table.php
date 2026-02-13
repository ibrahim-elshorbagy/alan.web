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
        Schema::table('redirect_links', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable()->after('nfc_order_id');
            $table->decimal('sales_price', 8, 2)->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('redirect_links', function (Blueprint $table) {
            $table->dropColumn(['price', 'sales_price']);
        });
    }
};