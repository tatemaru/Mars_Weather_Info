<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Mars_Weather_Infos_Service extends Facade
{
    protected static function getFacadeAccessor() {
        return 'Mars_Weather_Infos_Service';
    }
}