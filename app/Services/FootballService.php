<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class FootballService
{
    protected $client;
    protected $apiKey;
    protected $apiHost;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = 'dba0ac98c1mshbdbf0e63f05c288p177095jsnbbd636dc524b'; // Your RapidAPI key
        $this->apiHost = 'api-football-v1.p.rapidapi.com';
    }

    public function getLiveScores()
    {
        try {
            // Array of popular league IDs
            $leagues = [
                39,  // Premier League
                140, // La Liga
                135, // Serie A
                78,  // Bundesliga
                61,  // Ligue 1
                235, // Premier League Russia
                88,  // Eredivisie
                197  // Super Lig
            ];

            $allMatches = [];
            foreach ($leagues as $leagueId) {
                $response = $this->client->request('GET', 'https://' . $this->apiHost . '/v3/fixtures', [
                    'headers' => [
                        'X-RapidAPI-Key' => $this->apiKey,
                        'X-RapidAPI-Host' => $this->apiHost
                    ],
                    'query' => [
                        'league' => $leagueId,
                        'season' => date('Y'),
                        'next' => '5'
                    ]
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                if (!empty($data['response'])) {
                    $allMatches = array_merge($allMatches, $data['response']);
                }
            }

            // Sort matches by date
            usort($allMatches, function($a, $b) {
                return strtotime($a['fixture']['date']) - strtotime($b['fixture']['date']);
            });

            // Log the total matches found
            \Log::info('Total matches found: ' . count($allMatches));

            return ['response' => array_slice($allMatches, 0, 10)]; // Return only 10 matches

        } catch (Exception $e) {
            \Log::error('Football API Error: ' . $e->getMessage());
            return ['response' => []];
        }
    }
}
