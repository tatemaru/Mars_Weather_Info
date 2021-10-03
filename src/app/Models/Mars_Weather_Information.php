<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Mars_Weather_Information extends Model
{
    use HasFactory;

    protected $table = 'mars_weather_informations';
}
