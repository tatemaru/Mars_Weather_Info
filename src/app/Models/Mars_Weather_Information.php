<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Mars_Weather_Information extends Model
{
    use HasFactory;

    protected $table = 'mars_weather_informations';

    public function __construct()
    {
        return $this->marsWeatherInfos = Http::get(config('const.API_URL'));
    }

    /**
     * Get the Body of the API response
     * The return value will be a string type of 1000000 bytes or more.
     * @return string
     */
    public function getResponseBody()
    {
        return $this->marsWeatherInfos->body();
    }

    /**
     * Get the API response as an array|mixed.
     * 
     * return is 
     * array => [
     *     'description' => 
     *          [],
     *          [],....
     *      'soles' =>
     *          [0],
     *          [1],....
     * ]
     * Mars weather information is included in soles.
     * @return array|mixed
     */
    public function getResponseJson()
    {
        return $this->marsWeatherInfos->json();
    }

    /**
     * Get the API response as an object.
     * 
     * Mars weather information is included in soles.
     * @return object
     */
    public function getResponseObject()
    {
        return $this->marsWeatherInfos->object();
    }

    /**
     * Get the API response as an array.
     * 
     * return is 
     * array => [
     *     'description' => 
     *          [],
     *          [],....
     *      'soles' =>
     *          [0],
     *          [1],....
     * ]
     * Mars weather information is included in soles.
     * @return array
     */
    public function getResponseCollect()
    {
        return $this->marsWeatherInfos->collect();
    }

    /**
     * Check if the status code of the response is 200.
     * 
     * @return bool
     */
    public function getResponseOK()
    {
        return $this->marsWeatherInfos->ok();
    }

    /**
     * Check if the status code of the response is in the 200 range.
     * 
     * @return bool
     */
    public function getResponseSuccessful()
    {
        return $this->marsWeatherInfos->successful();
    }

    /**
     * Check if the status code of the response is in the 300 range.
     * 
     * @return bool
     */
    public function getResponseRedirect()
    {
        return $this->marsWeatherInfos->redirect();
    }

    /**
     * Check if the status code of the response is in the 400 range.
     * 
     * @return bool
     */
    public function getResponseFailed()
    {
        return $this->marsWeatherInfos->failed();
    }

    /**
     * Check if the status code of the response is in the 500 range.
     * 
     * @return bool
     */
    public function getResponseServerError()
    {
        return $this->marsWeatherInfos->serverError();
    }

    /**
     * Check if the status code of the response is in the 500 range.
     * 
     * @return bool
     */
    public function getResponseClientError()
    {
        return $this->marsWeatherInfos->clientError();
    }

    /**
     * Get the request all headers.
     * 
     * @return array
     */
    public function getResponseHeaders()
    {
        return $this->marsWeatherInfos->headers();
    }

    /**
     * Get the request header.
     * 
     * @return 
     */
    public function getResponseHeader($header = null)
    {
        return $this->marsWeatherInfos->header($header);
    }
}
