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
        Setting::Create(['key' => 'our_mission_title', 'value' => 'Our Mission']);
        Setting::Create(['key' => 'our_mission_description1', 'value' => 'We provide beautiful, interactive digital business cards that make sharing your professional identity as simple as sending a link or scanning a QR code.']);
        Setting::Create(['key' => 'our_mission_description2', 'value' => 'Our vision is to revolutionize professional networking by creating a sustainable, digital alternative to paper business cards.']);
    }
};
