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
        Schema::create('wp_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_order_id');
            $table->unsignedBigInteger('product_id');
            $table->string('price');
            $table->integer('qty');
            $table->string('total_price');
            $table->timestamps();

            $table->foreign('wp_order_id')->references('id')->on('wp_orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('whatsapp_store_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wp_order_items');
    }
};
