<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Models\Weather;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function show($city)
    {
        $weather = Weather::where('city', $city)->first();

        if (!$weather || $weather->updated_at->diffInMinutes(now()) > 30) {
            $data = $this->weatherService->getWeather($city);
            $weather = Weather::updateOrCreate(['city' => $city], ['data' => json_encode($data)]);
        }

        return view('weather.show', ['weather' => json_decode($weather->data, true)]);
    }
}