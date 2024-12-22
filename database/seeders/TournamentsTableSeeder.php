<?php

namespace Database\Seeders;

use App\Models\Tournament;
use Illuminate\Database\Seeder;

class TournamentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tournaments = [
            ['name' => 'Premier League'],
            ['name' => 'Champions League'],
        ];

        foreach ($tournaments as $tournamentData) {
            Tournament::updateOrCreate(['name' => $tournamentData['name']]);
        }
    }
}
