@extends('frontend.layouts.master')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h1>Today's Football Matches</h1>
                </div>
                <div class="card-body">
                    @if(isset($liveScores['response']) && count($liveScores['response']) > 0)
                        <ul class="list-group">
                            @foreach($liveScores['response'] as $match)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="team">{{ $match['teams']['home']['name'] }}</span>
                                        <div class="score-container">
                                            <span class="badge {{ in_array($match['fixture']['status']['short'], ['1H','2H','ET','P','BT','LIVE']) ? 'bg-danger' : 'bg-primary' }}">
                                                {{ $match['goals']['home'] ?? 0 }} - {{ $match['goals']['away'] ?? 0 }}
                                            </span>
                                            <small class="d-block text-center text-muted">
                                                @if(in_array($match['fixture']['status']['short'], ['1H','2H','ET','P','BT','LIVE']))
                                                    {{ $match['fixture']['status']['elapsed'] }}' LIVE
                                                @else
                                                    {{ date('H:i', strtotime($match['fixture']['date'])) }}
                                                @endif
                                            </small>
                                        </div>
                                        <span class="team">{{ $match['teams']['away']['name'] }}</span>
                                    </div>
                                    <div class="text-muted mt-1">
                                        <small>{{ $match['league']['name'] }} - {{ $match['league']['country'] }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center">No matches scheduled for today</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.team {
    width: 40%;
    padding: 0 10px;
}
.score-container {
    text-align: center;
    width: 20%;
}
</style>
@endsection
