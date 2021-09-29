<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MarsWeatherInformations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Mars_Weather_Informations', function (Blueprint $table) {
            $table->id();
            $table->integer('sol')->nullable()->default(null);
            $table->integer('max_temp')->nullable()->default(null);
            $table->integer('min_temp')->nullable()->default(null);
            $table->integer('max_gts_temp')->nullable()->default(null);
            $table->integer('min_gts_temp')->nullable()->default(null);
            $table->string('abs_humidity')->nullable()->default(null);
            $table->string('atmo_opacity')->nullable()->default(null);
            $table->string('local_uv_irradiance_index')->nullable()->default(null);
            $table->integer('ls')->nullable()->default(null);
            $table->integer('pressure')->nullable()->default(null);
            $table->string('pressure_string')->nullable()->default(null);
            $table->string('season')->nullable()->default(null);
            $table->string('wind_direction')->nullable()->default(null);
            $table->integer('wind_speed')->nullable()->default(null);
            $table->time('sunrise')->nullable()->default(null);
            $table->time('sunset')->nullable()->default(null);
            $table->dateTime('terrestrial_date')->nullable()->default(null);
            $table->date('update_date')->nullable()->default(null);
            $table->date('create_date')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Mars_Weather_Informations');
    }
}