<?php

namespace Database\Seeders;

use App\Models\WhatDrivesUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhatDrivesUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $whatDrivesUs1 = WhatDrivesUs::create([
            'title' => 'Innovation',
            'description' => 'We embrace new ideas and technologies to create cutting-edge solutions.',
        ]);

        $whatDrivesUs2 = WhatDrivesUs::create([
            'title' => 'User Focus',
            'description' => 'We put our users at the center of everything we design and build.',
        ]);

        $whatDrivesUs3 = WhatDrivesUs::create([
            'title' => 'Security',
            'description' => 'We prioritize the security and privacy of our users\' data above all else.',
        ]);
    }
}
