<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImprintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imprintExist = Setting::where('key', 'imprint')->exists();

        if (! $imprintExist) {
            $imprintHtml = view('settings.terms_conditions.imprint')->render();
            Setting::create(['key' => 'imprint', 'value' => $imprintHtml]);
        }

    }
}
