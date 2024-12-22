<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Season;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $seasons = Season::where('name', '2024/2025')
            ->whereIn('tournament_id', Tournament::whereIn('name', ['Premier League', 'Champions League'])->pluck('id'))
            ->get()
            ->keyBy('tournament_id');

        if ($seasons->count() < 2) {
            \Log::warning("One or both seasons not found for 2024/2025");
            return;
        }

        $teams = Team::all();

        foreach ($teams as $team1) {
            foreach ($teams as $team2) {
                if ($team1->id !== $team2->id) {
                    $premierLeagueSeason = $seasons->get(Tournament::where('name', 'Premier League')->first()->id);
                    $championsLeagueSeason = $seasons->get(Tournament::where('name', 'Champions League')->first()->id);

                    if ($premierLeagueSeason) {
                        $this->createGame($premierLeagueSeason, $team1, $team2);
                    }

                    if ($championsLeagueSeason) {
                        $this->createGame($championsLeagueSeason, $team1, $team2);
                    }
                }
            }
        }
    }

    /**
     * Create a game between two teams in a given season.
     */
    private function createGame($season, $team1, $team2)
    {
        Game::updateOrCreate(
            [
                'season_id' => $season->id,
                'team1_id' => $team1->id,
                'team2_id' => $team2->id,
            ]
        );
    }
}
