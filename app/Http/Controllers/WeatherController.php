<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function show(Request $request)
    {
        try {
            $city = $request->query('city', config('services.openweather.city', 'Kigali'));
            
            $weather = $this->weatherService->getCurrentWeather($city);
            $forecast = $this->weatherService->getForecast($city);

            return view('weather.show', compact('weather', 'forecast'));

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required|string|min:2|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $city = $request->input('city');
            $weather = $this->weatherService->getCurrentWeather($city);
            return response()->json($weather);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}