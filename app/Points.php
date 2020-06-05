<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Points extends Model
{
    protected $table = 'points';
    protected $primaryKey = 'pointId';
    
    public function getTeamPoints($teamId){ 
        return (new self)
                ->join('team','team.teamId','=','points.teamId')
                ->where('points.teamId',$teamId)
                ->get();
    }
    
    public function getTeamTotalPoints($teamId) {
        $request = (new \GuzzleHttp\Client())->get(env('API_BASE_URL').'team-points/'.$teamId);
        $response = $request->getBody()->getContents();
        return json_decode($response, true);
    }
    
    public function saveMatchResult($data){ 
        
        $calculation = $this->calculatePoints($data['teamOne'],$data['teamTwo'],$data['winner']);  
        $teams = [
            0 => Config::get('constants.messages.teamOne'),
            1 => Config::get('constants.messages.teamTwo')
        ];
        
        foreach ($teams as $team) {
            $this->saveDataForTeam($calculation[$team]);
        }
    }
    
    public function saveDataForTeam($data) {
        
        $teamPoints = (new self)
                ->select('points.teamPoints')
                ->where('points.teamId',$data['teamId'])
                ->first();
        if(!empty($teamPoints)){
            $totalTeamPoints = $teamPoints['teamPoints'] + $data['teamPoints'];
            DB::table('points')
              ->where('teamId', $data['teamId'])
              ->update(['teamPoints' => $totalTeamPoints]);
        }else{
            $point             = new Points();
            $point->teamId     = $data['teamId'];
            $point->teamPoints = $data['teamPoints'];
            $point->save();
        }
        DB::commit();
    }
    
    public function calculatePoints($teamOneId,$teamTwoId,$matchResult) {
        
       $data = [];
       if($matchResult == Config::get('constants.messages.draw')){
           $teamOne = [
               'teamId' => $teamOneId,
               'teamPoints' => 2
           ];
           $teamTwo = [
               'teamId' => $teamTwoId,
               'teamPoints' => 2
           ];
       }elseif($matchResult == Config::get('constants.messages.teamOne')){
           $teamOne = [
               'teamId' => $teamOneId,
               'teamPoints' => 5
           ];
           $teamTwo = [
               'teamId' => $teamTwoId,
               'teamPoints' => 0
           ];
       }else{
           $teamOne = [
               'teamId' => $teamOneId,
               'teamPoints' => 0
           ];
           $teamTwo = [
               'teamId' => $teamTwoId,
               'teamPoints' => 5
           ];
       }
       $data = [
           'teamOne'=> $teamOne,
           'teamTwo'=> $teamTwo,
       ];
       return $data;
    }
    
    public function teamPointsList() {
        
        return (new self)
                ->select('team.teamId','team.name','points.teamPoints')
                ->join('team','team.teamId','=','points.teamId')
                ->get();
    }
    
    public function consumeTeamPointsTableAPI() {
        $request = (new \GuzzleHttp\Client())->get(env('API_BASE_URL').'team-points-table');
        $response = $request->getBody()->getContents();
        return json_decode($response, true);
    }
}
