@extends('frontend.layouts.master')

@section('content')
    <!-- Tranding news carousel-->
    @include('frontend.home-components.breaking-news')
    <!-- End Tranding news carousel -->

    <!-- Hero news -->
    @include('frontend.home-components.hero-silder')
    <!-- End Hero news -->

    <!-- Weather Information -->
    <div class="container mt-4 mb-4">
        <div class="weather-info" style="background: #007bff; color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            @if(isset($weather) && is_array($weather))
                <div class="row">
                    <div class="col-md-12">
                        <h2 style="font-size: 24px; margin-bottom: 15px;">
                            <i class="fas fa-cloud" style="margin-right: 10px;"></i>
                            Weather in {{ $weather['name'] ?? 'Unknown Location' }}
                        </h2>
                        <div style="font-size: 18px;">
                            @if(isset($weather['main']['temp']))
                                <p style="margin-bottom: 10px;">
                                    <i class="fas fa-temperature-high" style="margin-right: 10px;"></i>
                                    Temperature: {{ round($weather['main']['temp'] - 273.15, 1) }}°C
                                </p>
                            @endif
                            @if(isset($weather['weather'][0]['description']))
                                <p style="margin-bottom: 10px;">
                                    <i class="fas fa-cloud-sun" style="margin-right: 10px;"></i>
                                    Weather: {{ ucfirst($weather['weather'][0]['description']) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <p>Weather information is currently unavailable</p>
                @if(config('app.debug'))
                    <small>Debug: $weather variable is {{ isset($weather) ? gettype($weather) : 'not set' }}</small>
                @endif
            @endif
        </div>
    </div>
    <!-- End Weather Information -->

    

    <!-- End Hero news Section-->
    @if ($ad && $ad->home_top_bar_ad_status == 1)
        <a href="{{ $ad->home_top_bar_ad_url }}">
            <div class="large_add_banner">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="large_add_banner_img">
                                <img src="{{ $ad->home_top_bar_ad }}" alt="adds">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endif
    <!-- Live Football Scores -->
    <div class="container mt-4 mb-4">
        <div class="live-scores" style="background: #007bff; color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h2 style="font-size: 24px; margin-bottom: 15px;">
                <i class="fas fa-futbol" style="margin-right: 10px;"></i>
                Live Football Scores
            </h2>
            @if(isset($liveScores['response']) && count($liveScores['response']) > 0)
                <ul class="list-unstyled">
                    @foreach($liveScores['response'] as $match)
                        <li class="mb-2 p-2 bg-light text-dark rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ $match['teams']['home']['name'] }}</span>
                                <span class="badge bg-primary mx-2">
                                    {{ $match['goals']['home'] ?? 0 }} - {{ $match['goals']['away'] ?? 0 }}
                                </span>
                                <span>{{ $match['teams']['away']['name'] }}</span>
                            </div>
                            <small class="text-muted">{{ $match['fixture']['status']['elapsed'] }}' | {{ $match['league']['name'] }}</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center mb-0">No live matches available at the moment</p>
            @endif
        </div>
    </div>
    <!-- End Live Football Scores -->

    <!-- Popular news category -->
    @include('frontend.home-components.main-news')
    <!-- End Popular news category -->
@endsection
