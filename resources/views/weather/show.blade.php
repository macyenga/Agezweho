<!DOCTYPE html>
<html>
<head>
    <title>Weather</title>
</head>
<body>
    <h1>Weather in {{ $weather['name'] }}</h1>
    <p>Temperature: {{ $weather['main']['temp'] }}K</p>
    <p>Weather: {{ $weather['weather'][0]['description'] }}</p>
</body>
</html>