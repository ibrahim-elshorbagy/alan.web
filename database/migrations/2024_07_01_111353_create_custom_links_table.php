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
        Schema::create('custom_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vcard_id');
            $table->foreign('vcard_id')->references('id')->on('vcards')->onUpdate('cascade')->onDelete('cascade');
            $table->string('link_name');
            $table->integer('show_as_button');
            $table->integer('open_new_tab');
            $table->string('link');
            $table->string('button_color');
            $table->string('button_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_links');
    }
};
