@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Search Form -->
        <form action="{{ route('weather.show') }}" method="GET" class="mb-8">
            <div class="flex gap-4">
                <input type="text" 
                       name="city" 
                       value="{{ request('city', 'London') }}"
                       class="flex-1 px-4 py-2 border rounded-lg"
                       placeholder="Enter city name">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg">
                    Search
                </button>
            </div>
            @error('city')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </form>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Current Weather -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h1 class="text-2xl font-bold mb-4">Current Weather in {{ $weather['name'] }}</h1>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <p class="text-4xl font-bold">{{ round($weather['main']['temp']) }}°C</p>
                    <p class="text-lg">{{ $weather['weather'][0]['description'] }}</p>
                    <img src="http://openweathermap.org/img/w/{{ $weather['weather'][0]['icon'] }}.png" 
                         alt="Weather icon" 
                         class="w-16 h-16">
                </div>
                <div class="space-y-2">
                    <p>Feels like: {{ round($weather['main']['feels_like']) }}°C</p>
                    <p>Humidity: {{ $weather['main']['humidity'] }}%</p>
                    <p>Wind: {{ $weather['wind']['speed'] }} m/s</p>
                </div>
            </div>
        </div>

        @if(isset($forecast))
        <!-- Forecast -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">5-Day Forecast</h2>
            <div class="grid md:grid-cols-5 gap-4">
                @foreach(array_slice($forecast['list'], 0, 5) as $day)
                <div class="text-center p-4 border rounded-lg">
                    <p class="font-bold">{{ \Carbon\Carbon::createFromTimestamp($day['dt'])->format('D, M d') }}</p>
                    <img src="http://openweathermap.org/img/w/{{ $day['weather'][0]['icon'] }}.png" 
                         alt="Weather icon" 
                         class="mx-auto w-12 h-12">
                    <p>{{ round($day['main']['temp_max']) }}°C / {{ round($day['main']['temp_min']) }}°C</p>
                    <p class="text-sm">{{ $day['weather'][0]['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection