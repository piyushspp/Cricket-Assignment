<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Teamsplayer;

class TeamsPlayerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $data = [
                [1,1,1],
                [2,1,2],
                [3,1,3],
                [4,2,6],
                [5,2,7],
                [6,2,8],
                [7,3,11],
                [8,3,12],
                [9,3,13],
                [10,4,16],
                [11,4,17],
                [12,4,18],
            ];
            DB::beginTransaction();
            foreach ($data as $datafield)
            {
                Teamsplayer::updateOrCreate(['teamPlayerId' => $datafield[0]],['teamPlayerId' => $datafield[0], 'teamId' => $datafield[1],'playerId'=>$datafield[2]]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            print "\n\n\n\n\n\n\n\nERROR----> " . $e->getMessage() . "\n\n\n\n\n\n\n\n";
        }
    }
}
