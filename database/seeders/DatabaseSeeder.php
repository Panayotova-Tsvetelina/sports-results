<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TeamsTableSeeder::class,
            TournamentsTableSeeder::class,
            SeasonsTableSeeder::class,
            GamesTableSeeder::class,
            ResultsTableSeeder::class
        ]);
    }
}
