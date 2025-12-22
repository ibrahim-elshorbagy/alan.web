<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Language;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $languageExists = Language::where('name', 'Hindi')->exists();
        if (!$languageExists) {
            Language::create(['name' => 'हिन्दी', 'iso_code' => 'hi', 'is_default' => false, 'status' => true]);
        }
    }
};
