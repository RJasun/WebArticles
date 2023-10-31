<?php
declare(strict_types=1);

namespace App\Models;

use GuzzleHttp\Client;

class NbaTeam
{

    private string $id;
    private string $fullName;

    private const BASE_API_URL = 'https://www.balldontlie.io/api/v1/teams';

    public function __construct(string $id, string $fullName)
    {
        $this->id = $id;
        $this->fullName = $fullName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public static function getTeamById(string $id): ?NbaTeam
    {
        $client = new Client();
        $response = $client->get(self::BASE_API_URL);
        $data = json_decode($response->getBody()->getContents());

        $teams = $data->data;

        foreach ($teams as $team) {
            if ($team->id == $id) {
                return new self((string)$team->id, $team->full_name);
            }
        }

        return null;
    }

    public static function getDescription(string $id): ?string
    {
        $client = new Client();
        $response = $client->get(self::BASE_API_URL);
        $data = json_decode($response->getBody()->getContents());
        $teams = $data->data;

        foreach ($teams as $team) {
            if ($team->id == $id) {
                return "City - " . $team->city .
                    " | Abbreviation - " . $team->abbreviation .
                    " | Full Name - " . $team->full_name;

            }
        }
        return null;
    }
}