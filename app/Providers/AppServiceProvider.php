<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('openweather', function ($app) {
            return new Client([
                'base_uri' => 'https://api.openweathermap.org/data/2.5/',
                'timeout'  => 20.0, // Increase timeout to 20 seconds
                'query' => [
                    'appid' => config('services.openweather.key'),
                    'units' => 'metric'  // For Celsius
                ]
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFour();
        
        // Add NoCaptcha class alias
        $this->app->bind('NoCaptcha', function($app) {
            return new \Anhskohbo\NoCaptcha\NoCaptcha(
                config('captcha.secret'), 
                config('captcha.sitekey')
            );
        });
    }
}
