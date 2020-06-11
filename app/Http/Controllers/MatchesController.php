<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlayMatch;

class MatchesController extends Controller
{
    public function teamMatches(Request $request, $teamId){
        return response()->json((new \App\Matches)->getTeamMatches($teamId));
    }
    
    public function teamMatchesSummary($teamId) {
        $result = (new \App\Matches)->getTeamMatchesSummary($teamId);   
        return  view('team-match-summary')->with([
                        'data' => $result
        ]);
    }
    
    public function teamMatch(PlayMatch $request){
        $result = (new \App\Matches)->playMatch($request);
        return response()->json($result);
    }
    
    public function executeMatch() {
        $teamList = (new \App\Team())->consumeTeamListAPI();  
        return  view('execute-match')->with([
                        'data' => $teamList
        ]);
    }
}
