<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Team extends Model
{
    protected $table = 'team';
    protected $primaryKey = 'teamId';
    
    public function getList(){ 
        return (new self)->orderByDesc('teamId')->get();
    }
    
    public function getTeamById($teamId) {
        return (new self)
                ->where('team.teamId',$teamId)
                ->get();
    }
    
    public function getAllTeams(){ 
        
        $request = (new \GuzzleHttp\Client())->get(env('API_BASE_URL').'teams');
        $response = $request->getBody()->getContents();
        return json_decode($response, true);
    }
    
    public function getTeamPlayers($teamId){ 
        
        $request = (new \GuzzleHttp\Client())->get(env('API_BASE_URL').'team-players/'.$teamId);
        $response = $request->getBody()->getContents();
        return json_decode($response, true);
    }
    
    public function saveTeam($data) {
        DB::beginTransaction();
        try{ 
            $logoUri = time().'.'.$data->logoUri->extension();
            $data->logoUri->move(public_path('images'), $logoUri);
            chmod(public_path('images').'/'.$logoUri, 0777);
            $team = new Team();
            $team->name = $data['name'];
            $team->logoUri = $logoUri;
            $team->clubState = $data['state'];
            $team->save();
            $team->teamId;
            DB::commit();
            return ['status'=>true,'message'=> Config::get('constants.messages.addTeam'),'data'=> $team];
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
    }
    
    public function editTeam($data) {
        DB::beginTransaction();
        try{ 
            $update = [
                'name' => $data['name'],
                'clubState' => $data['state']
            ];
            if(!empty($data->logoUri)){
                $logoUri = time().'.'.$data->logoUri->extension();
                $data->logoUri->move(public_path('images'), $logoUri);
                chmod(public_path('images').'/'.$logoUri, 0777);
                $update['logoUri'] = $logoUri;
            }    
            DB::table('team')
              ->where('teamId', $data['teamId'])
              ->update($update);
            DB::commit();
            return ['status'=>true,'message'=> Config::get('constants.messages.editTeam')];
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
    }
    
    public function deleteTeam($data,$teamId) {
        DB::beginTransaction();
        try{ 
            (new \App\Teamsplayer())->drop($teamId);
            $team = self::find($teamId);
            (!empty($team)) ? $team->delete() : '';
            DB::commit();
            return ['status'=>true,'message'=> Config::get('constants.messages.deleteTeam')];
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
    }
    
    public function getTeamsPlayers($teamId){ 
        
        return (new self)
                ->join('teamsplayer','teamsplayer.teamId','=','team.teamId')
                ->join('player','player.playerId','=','teamsplayer.playerId')
                ->where('team.teamId',$teamId)
                ->get();
    }
    
    public function getTeamData($teamId) {
        $request = (new \GuzzleHttp\Client())->get(env('API_BASE_URL').'team-name/'.$teamId);
        $response = $request->getBody()->getContents();
        return json_decode($response, true);
    }
    
    public function consumeTeamListAPI() {
        
        $result = $this->getAllTeams();
        $data = [];
        foreach ($result as $value) {
            $data[$value['teamId']] = $value['name'];
        }
        return $data;
    }
}
