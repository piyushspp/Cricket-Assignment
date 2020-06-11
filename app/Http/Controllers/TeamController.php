<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddTeam;
use App\Http\Requests\EditTeam;
use App\Http\Requests\DeleteTeam;

class TeamController extends Controller
{
    public function teams(Request $request){
        return response()->json((new \App\Team)->getList());
    }
    
    public function teamPlayers(Request $request, $teamId){
        return response()->json((new \App\Team)->getTeamsPlayers($teamId));
    }
    
    public function teamNameById(Request $request, $teamId){
        return response()->json((new \App\Team)->getTeamById($teamId));
    }
    
    public function teamPoints(Request $request, $teamId){
        return response()->json((new \App\Points)->getTeamPoints($teamId));
    }
    
    public function teamTotalPoints(Request $request, $teamId){
        $result = (new \App\Points)->getTeamTotalPoints($teamId);       
        return  view('team-points')->with([
                        'data' => $result
        ]);
    }
    
    public function add(AddTeam $request) { 
        $result = (new \App\Team())->saveTeam($request);
        return response()->json($result);
    }
    
    public function edit(EditTeam $request) { 
        $result = (new \App\Team())->editTeam($request);
        return response()->json($result);
    }
    
    public function delete(DeleteTeam $request, $teamId) { 
        $result = (new \App\Team())->deleteTeam($request,$teamId);
        return response()->json($result);
    }
    
    public function addTeam() {
        return  view('add-edit-team');
    }
    
    public function editTeam($teamId) {
        $data = (new \App\Team)->getTeamById($teamId)[0];
        return  view('add-edit-team')->with([
                        'team' => $data
        ]);
    }
    
    public function teamPointsTable(Request $request) { 
        $result = (new \App\Points())->teamPointsList();
        return response()->json($result);
    }
    
    public function getTeamPointTable() {
        $result = (new \App\Points)->consumeTeamPointsTableAPI();       
        return  view('team-points-table')->with([
                        'data' => $result
        ]);
    }
}
