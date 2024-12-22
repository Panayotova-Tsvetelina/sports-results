<?php

namespace Database\Seeders;

use App\Models\Season;
use App\Models\Tournament;
use Illuminate\Database\Seeder;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tournaments = [
            'Premier League' => '2024/2025',
            'Champions League' => '2024/2025',
        ];

        foreach ($tournaments as $tournamentName => $seasonName) {
            $tournament = Tournament::where('name', $tournamentName)->first();

            if ($tournament) {
                Season::updateOrCreate(
                    ['name' => $seasonName, 'tournament_id' => $tournament->id]
                );
            } else {
                \Log::warning("Tournament not found: {$tournamentName}");
            }
        }
    }
}
