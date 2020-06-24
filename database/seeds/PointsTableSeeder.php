<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Points;

class PointsTableSeeder extends Seeder
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
                [1,1,9],
                [2,2,12],
                [3,3,9],
                [4,4,12],
            ];
            DB::beginTransaction();
            foreach ($data as $datafield)
            {
                Points::updateOrCreate(['pointId' => $datafield[0]],['pointId' => $datafield[0], 'teamId' => $datafield[1],'teamPoints'=>$datafield[2]]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            print "\n\n\n\n\n\n\n\nERROR----> " . $e->getMessage() . "\n\n\n\n\n\n\n\n";
        }
    }
}
