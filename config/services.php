<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'recaptcha' => [
        'sitekey' => env('NOCAPTCHA_SITEKEY'),
        'secret' => env('NOCAPTCHA_SECRET'),
    ],

    'openweather' => [
        'key' => env('OPENWEATHERMAP_API_KEY'),
        'city' => env('OPENWEATHER_CITY', 'Kigali'),
    ],

    'news_api' => [
        'key' => env('NEWS_API_KEY'),
        'min_content_length' => 50,
        'local_content_ratio' => 0.3,
        'cache_duration' => 1800,
        'restricted_keywords' => [
            'adult', 'gambling', 'betting', 'casino',
            'violence', 'gore', 'hate', 'racism', 'drugs'
        ],
        'attribution_required' => true
    ],

];
