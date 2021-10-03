<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Mars_Weather_Infos_Service;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);
        if (\App::environment('production')) {
            \URL::forceScheme('https');
    }
}
