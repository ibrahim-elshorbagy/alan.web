<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurMission extends Model
{
    use HasFactory;

    public static $rules = [
        'our_mission_title' => 'required|string',
        'our_mission_description1' => 'required|string',
        'our_mission_description2' => 'required|string',
    ];
}
