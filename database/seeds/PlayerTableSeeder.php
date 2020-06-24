<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Player;

class PlayerTableSeeder extends Seeder
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
                [1,'Bhuvneshwar','Kumar','bhuvneshwar.jpeg',1,'India'],
                [2,'Ashish','Reddy','ashish.jpeg',2,'India'],
                [3,'Sandeep','Sharma','sandeep.jpeg',3,'India'],
                [4,'Kane','Williamson','kane.jpeg',4,'New Zealand'],
                [5,'David','Warner','david.jpeg',5,'Australia'],
                [6,'Yuvraj','Singh','yuvraj.jpeg',6,'India'],
                [7,'Hardik','Pandya','hardik.jpeg',7,'India'],
                [8,'Kieron','Pollard','pollard.jpeg',8,'West Indies'],
                [9,'Jasprit','Bumrah','bumrah.jpeg',9,'India'],
                [10,'Lasith','Malinga','malinga.jpeg',10,'Sri Lanka'],
                [11,'Ambati','Rayudu','rayudu.jpeg',11,'India'],
                [12,'Harbhajan','Singh','harbhajan.jpeg',12,'India'],
                [13,'Shane','Watson','watson.jpeg',13,'Australia'],
                [14,'Faf du','Plesis','duplesis.jpeg',14,'South Africa'],
                [15,'MS','Dhoni','dhoni.jpeg',15,'India'],
                [16,'Andre','Russel','russel.jpeg',16,'West Indies'],
                [17,'Sunil','Narane','sunil.jpeg',17,'West Indies'],
                [18,'Kuldeep','Yadav','kuldeep.jpeg',18,'India'],
                [19,'Piyush','Chawla','piyush.jpeg',19,'India'],
                [20,'Mitchell','Starc','starc.jpeg',20,'Australia'],
            ];
            DB::beginTransaction();
            foreach ($data as $datafield)
            {
                Player::updateOrCreate(['playerId' => $datafield[0]],['playerId' => $datafield[0], 'firstName' => $datafield[1],'lastName'=>$datafield[2],'imageUri'=>$datafield[3],'playerJersyNumber'=>$datafield[4],'country'=>$datafield[5]]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            print "\n\n\n\n\n\n\n\nERROR----> " . $e->getMessage() . "\n\n\n\n\n\n\n\n";
        }
    }
}
