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
            $table->dropForeign(['status_changed_by']);
            $table->dropForeign(['received_status_changed_by']);
            $table->dropColumn(['status_changed_by', 'status_changed_at', 'received_status_changed_by', 'received_status_changed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('redirect_links', function (Blueprint $table) {
            $table->unsignedBigInteger('status_changed_by')->nullable()->after('status');
            $table->timestamp('status_changed_at')->nullable()->after('status_changed_by');
            $table->unsignedBigInteger('received_status_changed_by')->nullable()->after('received_status');
            $table->timestamp('received_status_changed_at')->nullable()->after('received_status_changed_by');
            
            $table->foreign('status_changed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('received_status_changed_by')->references('id')->on('users')->onDelete('set null');
        });
    }
};
