<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Team;

class TeamTableSeeder extends Seeder
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
                [1,'Sinrisers Hyderabad','srh_logo.png','Hyderabad'],
                [2,'Mumbai Indians','mi_logo.jpeg','Mumbai'],
                [3,'Chennai Super Kings','csk_logo.jpeg','Chennai'],
                [4,'Kolkata Knight Riders','kkr_logo.jpeg','Kolkata'],
            ];
            DB::beginTransaction();
            foreach ($data as $datafield)
            {
                Team::updateOrCreate(['teamId' => $datafield[0]],['teamId' => $datafield[0], 'name' => $datafield[1],'logoUri'=>$datafield[2],'clubState'=>$datafield[3]]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            print "\n\n\n\n\n\n\n\nERROR----> " . $e->getMessage() . "\n\n\n\n\n\n\n\n";
        }
    }
}
