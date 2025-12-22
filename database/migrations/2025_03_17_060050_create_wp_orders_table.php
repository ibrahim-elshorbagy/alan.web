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
        Schema::create('wp_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_store_id');
            $table->string('order_id')->unique();
            $table->string('name');
            $table->string('phone');
            $table->string('region_code');
            $table->longText('address');
            $table->string('grand_total');
            $table->tinyInteger ('status')->default(0);
            $table->timestamps();

            $table->foreign('wp_store_id')->references('id')->on('whatsapp_stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wp_orders');
    }
};
