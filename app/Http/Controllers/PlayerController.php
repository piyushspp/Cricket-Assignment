<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPlayer;
use App\Http\Requests\AssignPlayerToTeam;
use App\Http\Requests\RemovePlayerFromTeam;

class PlayerController extends Controller
{
    
    public function playerlist(Request $request) {
        $result = (new \App\Player())->getPlayerList();
        return response()->json($result);
    }
    
    public function add(AddPlayer $request) { 
        $result = (new \App\Player())->savePlayer($request);
        return response()->json($result);
    }
    
    public function edit(AddPlayer $request) { 
        $result = (new \App\Player())->editPlayer($request);
        return response()->json($result);
    }
    
    public function addPlayer() {
        return  view('add-player');
    }
    
    public function editPlayer($playerId) {
        $data = (new \App\Player())->getPlayerDetails($playerId)[0];
        return  view('add-player')->with([
                        'player' => $data
        ]);
    }
    
    public function allPlayers() {
        $data = (new \App\Player())->getPlayerList();
        return  view('players-list')->with([
                        'players' => $data
        ]);
    }
     
    public function addPlayerToTeam($teamId) {
        $teamData = (new \App\Team())->getTeamData($teamId)[0];
        $playerData = (new \App\Player())->getAvailablePlayerData();
        $data = [
            'teamData'   => $teamData,
            'players' => $playerData['playerIdnName']
        ];
        return  view('addPlayerToTeam')->with([
                        'result' => $data
        ]);
    }
    
    public function assignPlayerToTeam(AssignPlayerToTeam $request) {
        $result = (new \App\Teamsplayer())->assignPlayerToTeam($request);
        return response()->json($result); 
    }
    
    public function availablePlayers(Request $request) {
        $result = (new \App\Player())->availablePlayersList();
        return response()->json($result); 
    }
    
    public function removePlayer(RemovePlayerFromTeam $request) { 
        $result = (new \App\Teamsplayer())->removePlayerFromTeam($request);
        return response()->json($result); 
    }
}
