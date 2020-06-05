<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Playerhistory extends Model
{
    protected $table = 'playerhistory';
    protected $primaryKey = 'playerHistoryId';
      
    public function savePlayerHistory($data) {
        
        try{ 
            $playerHistory               = new Playerhistory();
            $playerHistory->matches      = $data['matches'];
            $playerHistory->run          = $data['run'];
            $playerHistory->highestScore = $data['highestScore'];
            $playerHistory->fifties      = $data['fifties'];
            $playerHistory->hundreds     = $data['hundreds'];
            $playerHistory->playerId     = $data['playerId'];;
            $playerHistory->save();
            DB::commit();
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
    }
    
    public function updatePlayerHistory($data) {
        
        try{ 
            DB::table('playerhistory')
              ->where('playerId', $data['playerId'])
              ->update(['matches' => $data['matches'], 'run' => $data['run'],
                  'highestScore' => $data['highestScore'],'fifties' => $data['fifties'],
                  'hundreds' => $data['hundreds']
            ]);
            DB::commit();
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
    }
}
