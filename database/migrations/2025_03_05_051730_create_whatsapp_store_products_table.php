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
        Schema::create('whatsapp_store_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->foreignId('whatsapp_store_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->bigInteger('category_id');
            $table->float('net_price')->nullable();
            $table->float('selling_price');
            $table->string('currency_id');
            $table->string('tenant_id');
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_store_products');
    }
};
