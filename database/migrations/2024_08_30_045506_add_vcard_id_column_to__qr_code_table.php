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
        Schema::table('qr_code_customizations', function (Blueprint $table) {
            if (!Schema::hasColumn('qr_code_customizations', 'vcard_id')) {
                $table->unsignedBigInteger('vcard_id')->nullable();
            }

            $table->foreign('vcard_id')->references('id')->on('vcards')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
};
