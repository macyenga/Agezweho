<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        $city = 'YourDefaultCity'; // Replace with your default city
        $weather = $this->weatherService->getWeather($city);

        return view('frontend.home', compact('weather'));
    }

    // ...existing code...
}
