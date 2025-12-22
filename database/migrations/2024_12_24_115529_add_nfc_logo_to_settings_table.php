<?php

use App\Models\Setting;
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
        Schema::table('settings', function (Blueprint $table) {
            Schema::table('settings', function (Blueprint $table) {
                Setting::create([
                    'key' => 'nfc_logo_required',
                    'value' => true,
                ]);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            Setting::where('key', 'nfc_logo_required')->delete();
        });
    }
};
