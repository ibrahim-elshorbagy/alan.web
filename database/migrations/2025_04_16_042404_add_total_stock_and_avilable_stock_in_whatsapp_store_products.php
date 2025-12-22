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
        Schema::table('whatsapp_store_products', function (Blueprint $table) {
            $table->integer('total_stock')->default(0)->after('currency_id');
            $table->integer('available_stock')->default(0)->after('total_stock');
        });
    }
};
