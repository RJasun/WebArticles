<?php
declare(strict_types=1);

namespace App\Models;

use GuzzleHttp\Client;

class NbaTeamCollection
{
    private array $teams = [];

    public function fetchFromAPI(): void
    {
        $client = new Client();
        $response = $client->get('https://www.balldontlie.io/api/v1/teams');
        $data = json_decode($response->getBody()->getContents(), true);

        foreach ($data['data'] as $teamData) {
            $team = new NbaTeam((string)$teamData['id'], $teamData['full_name']);
            $this->add($team);
        }
    }

    public function add(NbaTeam $team): void
    {
        $this->teams[] = $team;
    }

    public function getTeams(): array
    {
        return $this->teams;
    }
}