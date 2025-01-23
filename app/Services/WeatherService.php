<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class WeatherService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.openweather.key');
        
        if (empty($this->apiKey)) {
            throw new Exception('OpenWeather API key is not configured');
        }
    }

    public function getCurrentWeather($city)
    {
        return Cache::remember("weather.current.{$city}", 1800, function () use ($city) {
            return $this->makeRequest('weather', [
                'q' => $city,
                'units' => 'metric'
            ]);
        });
    }

    public function getForecast($city)
    {
        return Cache::remember("weather.forecast.{$city}", 3600, function () use ($city) {
            return $this->makeRequest('forecast', [
                'q' => $city,
                'units' => 'metric'
            ]);
        });
    }

    protected function makeRequest($endpoint, $params)
    {
        if (empty($params['q'])) {
            throw new Exception('City parameter is required');
        }

        try {
            $response = $this->client->get("{$this->baseUrl}/{$endpoint}", [
                'query' => array_merge([
                    'appid' => $this->apiKey
                ], $params)
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            if (empty($data)) {
                throw new Exception('Invalid response from weather service');
            }

            return $data;

        } catch (RequestException $e) {
            Log::error('Weather API error: ' . $e->getMessage(), [
                'endpoint' => $endpoint,
                'params' => $params,
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ]);

            if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 404) {
                throw new Exception('City not found');
            }

            if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 401) {
                throw new Exception('Invalid API key');
            }

            throw new Exception('Weather service is currently unavailable. Please try again later.');
        } catch (Exception $e) {
            Log::error('Weather service error: ' . $e->getMessage());
            throw new Exception('An unexpected error occurred while fetching weather data');
        }
    }
}