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
        $this->apiKey = config('services.openweather.key');
        $this->client = new Client([
            'verify' => false,  // Disable SSL verification
            'timeout' => 15.0,
            'connect_timeout' => 15.0,
            'http_errors' => false, // Prevent Guzzle from throwing exceptions on 4xx/5xx
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'defaults' => [
                'proxy' => []  // Disable proxy
            ]
        ]);
    }

    public function getCurrentWeather($city)
    {
        try {
            // Try to get from cache first
            $cacheKey = "weather.{$city}";
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }

            $url = "{$this->baseUrl}/weather";
            $response = $this->client->request('GET', $url, [
                'query' => [
                    'q' => $city,
                    'appid' => $this->apiKey,
                    'units' => 'metric'
                ],
                'proxy' => []  // Explicitly disable proxy for this request
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new Exception("Weather API returned status code: {$statusCode}");
            }

            $data = json_decode($response->getBody()->getContents(), true);
            if (!$data) {
                throw new Exception('Failed to decode weather data');
            }

            // Cache successful response
            Cache::put($cacheKey, $data, now()->addMinutes(30));
            
            return $data;

        } catch (Exception $e) {
            Log::error('Weather API error:', [
                'message' => $e->getMessage(),
                'city' => $city
            ]);
            
            // Return cached data if available
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
            
            throw $e;
        }
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

        if (empty($this->apiKey)) {
            Log::error('OpenWeather API key is not configured');
            throw new Exception('Weather service configuration error');
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