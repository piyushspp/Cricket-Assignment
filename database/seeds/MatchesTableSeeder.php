<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Matches;

class MatchesTableSeeder extends Seeder
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
                [1,1,2,1],
                [2,1,3,3],
                [3,1,4,4],
                [4,2,3,2],
                [5,2,4,2],
                [6,3,4,4],
                [7,4,3,0],
                [8,2,1,0],
                [9,3,1,0],
            ];
            DB::beginTransaction();
            foreach ($data as $datafield)
            {
                Matches::updateOrCreate(['matchId' => $datafield[0]],['matchId' => $datafield[0], 'teamOne' => $datafield[1],'teamTwo'=>$datafield[2],'winner'=>$datafield[3]]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            print "\n\n\n\n\n\n\n\nERROR----> " . $e->getMessage() . "\n\n\n\n\n\n\n\n";
        }
    }
}
