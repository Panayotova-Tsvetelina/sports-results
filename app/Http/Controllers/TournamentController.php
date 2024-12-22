<?php

namespace App\Http\Controllers;

use App\Models\Tournament;

class TournamentController extends Controller
{

    public function index()
    {
        $tournaments = Tournament::with(
            'seasons.games.team1',
            'seasons.games.team2',
            'seasons.games.result'
        )->get();

        $formattedTournaments = $tournaments->map(function ($tournament) {
            return [
                'id' => $tournament->id,
                'name' => $tournament->name,
                'seasons' => $tournament->seasons->map(function ($season) {
                    $games = $season->games->random(min(5, $season->games->count()));

                    return [
                        'id' => $season->id,
                        'name' => $season->name,
                        'games' => $games,
                    ];
                }),
            ];
        });

        return response()->json(['tournaments' => $formattedTournaments]);
    }
}
