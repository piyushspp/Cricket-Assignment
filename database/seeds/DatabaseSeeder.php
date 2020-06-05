<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TeamTableSeeder::class,
            PlayerTableSeeder::class,
            PlayerhistoryTableSeeder::class,
            TeamsPlayerTableSeeder::class,
            MatchesTableSeeder::class,
            PointsTableSeeder::class,
        ]);  
    }
}
