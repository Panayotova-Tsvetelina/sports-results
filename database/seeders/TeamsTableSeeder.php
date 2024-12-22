<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            'Ajax',
            'Chelsea',
            'Manchester United',
            'Borussia Dortmund',
            'FC Heidenheim',
            'Las Palmas',
            'Wolfsburg',
            'Liverpool',
            'Tottenham',
            'Galatasaray',
        ];

        foreach ($teams as $teamName) {
            Team::updateOrCreate(['name' => $teamName]);
        }
    }
}
