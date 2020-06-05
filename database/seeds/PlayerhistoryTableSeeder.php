<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Playerhistory;

class PlayerhistoryTableSeeder extends Seeder
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
                [1,1,100,2000,110,2,1],
                [2,2,29,1000,152,1,1],
                [3,3,35,1500,104,2,2],
                [4,4,251,6000,190,10,12],
                [5,5,256,8000,245,15,16],
                [6,6,280,9000,212,30,12],
                [7,7,120,5000,125,5,5],
                [8,8,280,7500,159,16,10],
                [9,9,195,3000,123,2,1],
                [10,10,300,2500,102,2,1],
                [11,11,90,5000,186,15,5],
                [12,12,301,4000,127,8,2],
                [13,13,274,8000,139,19,12],
                [14,14,270,6500,148,18,11],
                [15,15,332,9500,158,19,8],
                [16,16,241,6000,169,15,14],
                [17,17,200,2560,118,5,1],
                [18,18,75,2500,116,7,1],
                [19,19,180,2900,127,6,1],
                [20,20,222,3300,120,9,1],
            ];
            DB::beginTransaction();
            foreach ($data as $datafield)
            {
                Playerhistory::updateOrCreate(['playerHistoryId' => $datafield[0]],['playerHistoryId' => $datafield[0], 'playerId' => $datafield[1],'matches'=>$datafield[2],'run'=>$datafield[3],'highestScore'=>$datafield[4],'fifties'=>$datafield[5],'hundreds'=>$datafield[6]]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            print "\n\n\n\n\n\n\n\nERROR----> " . $e->getMessage() . "\n\n\n\n\n\n\n\n";
        }
    }
}
