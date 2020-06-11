<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Player extends Model
{
    protected $table = 'player';
    protected $primaryKey = 'playerId';
    
       
    public function getAllTeams(){ 
        
        $request = (new \GuzzleHttp\Client())->get(env('API_BASE_URL').'teams');
        $response = $request->getBody()->getContents();
        return json_decode($response, true);
    }
    
    public function savePlayer($data) {
        
        DB::beginTransaction();
        try{ 
            $imageUri = time().'.'.$data->imageUri->extension();
            $data->imageUri->move(public_path('images'), $imageUri);
            chmod(public_path('images').'/'.$imageUri, 0777);
            $player = new Player();
            $player->firstName          = $data['firstName'];
            $player->lastName           = $data['lastName'];
            $player->imageUri           = $imageUri;
            $player->playerJersyNumber  = $data['playerJersyNumber'];
            $player->country            = $data['country'];
            if($player->save()){
                $data['playerId'] = $player->playerId;
                $result = (new \App\Playerhistory())->savePlayerHistory($data);
            }
            return ['status'=>true,'message'=> Config::get('constants.messages.addPlayer'),'data' => $player];
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
    }
            
    public function editPlayer($data) {
        
        DB::beginTransaction();
        try{ 
            $update = [
                'firstName' => $data['firstName'],'lastName' => $data['lastName'],
                'playerJersyNumber' => $data['playerJersyNumber'],'country' => $data['country']
            ];
            if(!empty($data->imageUri)){
                $imageUri = time().'.'.$data->imageUri->extension();
                $data->imageUri->move(public_path('images'), $imageUri);
                chmod(public_path('images').'/'.$imageUri, 0777);
                $update['imageUri'] = $imageUri;
            }  
            DB::table('player')
              ->where('playerId', $data['playerId'])
              ->update($update);
            (new \App\Playerhistory())->updatePlayerHistory($data);
            return ['status'=>true,'message'=> Config::get('constants.messages.editPlayer')];
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
    }
    
    public function getPlayerDetails($playerId) {
        return (new self)
                ->join('playerhistory','playerhistory.playerId','=','player.playerId')
                ->where('player.playerId',$playerId)
                ->get();
        
    }
    
    public function getPlayerList() {
        return (new self)
                ->join('playerhistory','playerhistory.playerId','=','player.playerId')
                ->orderByDesc('player.playerId')
                ->get();
    }
    
    public function availablePlayersList() {
        $playerIds = (new \App\Teamsplayer())->assignedPlayerIds();
        $list = [];
        $data =  (new self)
                ->join('playerhistory','playerhistory.playerId','=','player.playerId')
                ->whereNotIn('player.playerId',$playerIds)
                ->get();
        $list['playerData'] = $data;
        $availablePlayerIds = [];
        if(!empty($data)){
            foreach ($data as $value) {
                $availablePlayerIds[$value['playerId']] = $value['firstName'].' '.$value['lastName'];
            }
            $list ['playerIdnName'] = $availablePlayerIds;

        }  
        return $list;
    }
    
    public function getAvailablePlayerData() {
        $request = (new \GuzzleHttp\Client())->get(env('API_BASE_URL').'available-players/');
        $response = $request->getBody()->getContents();
        return json_decode($response, true);
    }
}
