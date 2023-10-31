<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Models\NbaTeam;
use App\Models\NbaTeamCollection;
use App\Response;
use Carbon\Carbon;

class ArticleController
{

    public function index(): Response
    {
        $teamCollection = new NbaTeamCollection();
        $teamCollection->fetchFromAPI();
        $teams = $teamCollection->getTeams();

        $articles = [];
        foreach ($teams as $team) {
            $description = NbaTeam::getDescription($team->getId());
            $articles[] = new Article($team->getId(), $team->getFullName(), $description, Carbon::now());
        }

        return new Response('index.twig', [
            'articles' => $articles
        ]);
    }

    public function show(array $vars): Response
    {
        $id = $vars['id'];
        $teamDetails = NbaTeam::getTeamById($id);

        if ($teamDetails) {
            $description = NbaTeam::getDescription($id);
            $article = new Article($teamDetails->getId(), $teamDetails->getFullName(), $description, Carbon::now());

            return new Response('show.twig', ['article' => $article]);
        } else {
            return new Response('error.twig', ['message' => 'Team not found']);
        }
    }
}