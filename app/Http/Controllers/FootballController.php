<?php

namespace App\Http\Controllers;

use App\Services\FootballService;

class FootballController extends Controller
{
    protected $footballService;

    public function __construct(FootballService $footballService)
    {
        $this->footballService = $footballService;
    }

    public function liveScores()
    {
        $liveScores = $this->footballService->getLiveScores();
        return view('football.live-scores', compact('liveScores'));
    }
}
