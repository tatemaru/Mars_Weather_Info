<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Mars_Weather_Infos_Service;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Mars_Weather_Infos_Service', Mars_Weather_Infos_Service::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
