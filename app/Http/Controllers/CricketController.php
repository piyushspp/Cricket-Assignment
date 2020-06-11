<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CricketController extends Controller
{
    public function home(Request $request){
        /*$userSessionData =[
          'id' =>20,
          'username' => 'piyushspp'  
        ];
        $tokenData = \App\JwtToken::create($userSessionData);*/
        $result = (new \App\Team)->getAllTeams();        
        return  view('home')->with([
                        'data' => $result
        ]);
    }
    
    public function team(Request $request, $teamId){
        
        $result = (new \App\Team)->getTeamPlayers($teamId);     
        $name = (new \App\Team)->getTeamById($teamId)[0]['name'];
        return  view('team')->with([
                        'data'    => $result,
                        'teamName'=> $name,
                        'teamId'  => $teamId
        ]);
    }
    
    public function phpunit(){
        
        return  view('phpunit');
    }
}
