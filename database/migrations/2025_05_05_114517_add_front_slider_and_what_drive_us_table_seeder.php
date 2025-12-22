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
        Artisan::call('db:seed', ['--class' => 'FrontSliderSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'WhatDrivesUsTableSeeder', '--force' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
