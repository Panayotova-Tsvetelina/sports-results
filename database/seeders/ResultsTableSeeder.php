<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Result;
use Illuminate\Database\Seeder;

class ResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = Game::all();

        foreach ($games as $game) {
            Result::create([
                'game_id' => $game->id,
                'team1_score' => rand(0, 5),
                'team2_score' => rand(0, 5)
            ]);
        }
    }
}
