<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Matches extends Model
{
    protected $table = 'matches';
    protected $primaryKey = 'matchId';
    
    public function getTeamMatches($teamId){ 
        $result= (new self)
                ->where('matches.teamOne',$teamId)
                ->orwhere('matches.teamTwo',$teamId)
                ->get();
        $summary = [];
        foreach ($result as $data) {
            $summary[] = $this->matchSummary($data,$teamId);     
        }
        return $summary;
    }
    
    public function matchSummary($data,$teamId) {
        if($data['teamOne'] == $teamId){
            $opponentTeamId = $data['teamTwo'];
        }else{
            $opponentTeamId = $data['teamOne'];
        }
        if($data['winner'] == $teamId){
            $data['matchStatus'] = Config::get('constants.messages.won');
            $data['points'] = 5;
        }else{
            if($data['winner'] == $opponentTeamId){
                $data['matchStatus'] = Config::get('constants.messages.lost');
                $data['points'] = 0;
            }else{
                $data['matchStatus'] = Config::get('constants.messages.drawn');
                $data['points'] = 2;
            }
        }
        $data['opponentTeamName'] = (new \App\Team())->getTeamById($opponentTeamId)[0]['name'] ;
        $data['teamName'] = (new \App\Team())->getTeamById($teamId)[0]['name'] ;
        return $data;
    }
    
    public function getTeamMatchesSummary($teamId){ 
        
        $request = (new \GuzzleHttp\Client())->get(env('API_BASE_URL').'team-matches/'.$teamId);
        $response = $request->getBody()->getContents();
        return json_decode($response, true);
    }
    
    
    public function playMatch($data) {
        
        DB::beginTransaction();
        try{ 
            if($data['winner'] == Config::get('constants.messages.draw')){
                $winner = 0;
            }else{
                $winner = $data[$data['winner']];
            }
            $matches = new Matches();
            $matches->teamOne  = $data['teamOne'];
            $matches->teamTwo  = $data['teamTwo'];
            $matches->winner   = $winner;
            if($matches->save()){ 
                $result = (new \App\Points())->saveMatchResult($data);
            }
            return ['status'=>true,'message'=> Config::get('constants.messages.matchSaved')];
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
    }
    
}
