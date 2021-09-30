<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mars_Weather_Information;

class indexController extends Controller
{
    public function __construct()
    {
        $this->MWImodel = new Mars_Weather_Information();
    }
    public function index()
    {
        return view('index')->with([
            "weeklyData" => $this->getWeeklyMarsWeatherInfo(),
         ]);
    }

    public function getWeeklyMarsWeatherInfo(){
        return $this->MWImodel->orderBy('terrestrial_date', 'desc')->limit(7)->get();
    }
}
