<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Teamsplayer extends Model
{
    protected $table = 'teamsplayer';
    protected $primaryKey = 'teamsPlayerId';
    
    public function drop($teamId) {
        
        (new self)->where('teamId', $teamId)->delete();
    }
    
    public function assignPlayerToTeam($data) {
        DB::beginTransaction();
        try{ 
            $teamsplayer           = new Teamsplayer();
            $teamsplayer->teamId   = $data['teamId'];
            $teamsplayer->playerId = $data['playerId'];
            $teamsplayer->save();
            DB::commit();
            return ['status'=>true,'message'=> Config::get('constants.messages.playerAssigned')];
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
    }
    
    public function assignedPlayerIds() {
        
        $data = (new self)->select('teamsplayer.playerId')->get();
        $playerIds = [];
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $playerIds[$key] = $value['playerId'];
            }
        }    
        return ($playerIds ?? '');
    }
    
    public function removePlayerFromTeam($data) {
        DB::beginTransaction();
        try{ 
            (new self)
                    ->where([['teamsplayer.teamId',$data['teamId']],
                ['teamsplayer.playerId',$data['playerId']]])
                    ->delete();
            DB::commit();
            return ['status'=>true,'message'=> Config::get('constants.messages.playerRemoved')];
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
        
    }
}
