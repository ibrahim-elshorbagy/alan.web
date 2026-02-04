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
        Schema::create('redirect_link_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('redirect_link_id');
            $table->string('action'); // 'status_changed', 'received_status_changed', 'assigned_changed', 'user_changed', 'redirect_link_updated', 'created'
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->string('changed_by_name')->nullable(); // Store name in case user is deleted
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('redirect_link_id')->references('id')->on('redirect_links')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redirect_link_histories');
    }
};
