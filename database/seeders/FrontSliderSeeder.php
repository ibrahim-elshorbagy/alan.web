<?php

namespace Database\Seeders;

use App\Models\FrontSlider;
use Google\Service\CloudSearch\Id;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrontSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $FrontSlider1 = FrontSlider::create([
           'id' => 1,
        ]);

        $FrontSlider2 = FrontSlider::create([
           'id' => 2,
        ]);

        $FrontSlider3 = FrontSlider::create([
           'id' => 3,
        ]);

        $FrontSlider4 = FrontSlider::create([
           'id' => 4,
        ]);

        $FrontSlider5 = FrontSlider::create([
           'id' => 5,
        ]);
    }
}
