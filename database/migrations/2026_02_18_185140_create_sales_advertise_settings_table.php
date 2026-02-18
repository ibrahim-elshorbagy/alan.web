<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Fields:
     *  - user_id          : FK to users (the sales user)
     *  - is_enabled       : Whether the advertisement is activated (super_admin only can toggle)
     *  - duration         : Slide duration in seconds (1–no DB limit; form limits 1–5; editable by both)
     *  - images           : JSON array of stored image paths (max 5 images, compressed to ≤1600px wide)
     */
    public function up(): void
    {
        Schema::create('sales_advertise_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_enabled')->default(false);
            $table->unsignedSmallInteger('duration')->default(3); // seconds
            $table->json('images')->nullable();                   // up to 5 compressed image paths
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_advertise_settings');
    }
};