<?php

namespace App\Services;

use GuzzleHttp\Client;

class WeatherService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENWEATHERMAP_API_KEY');
    }

    public function getWeather($city)
    {
        $response = $this->client->get("http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$this->apiKey}");
        return json_decode($response->getBody()->getContents(), true);
    }
}