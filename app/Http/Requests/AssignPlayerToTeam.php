<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class AssignPlayerToTeam extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teamId' => [
                'bail',
                'required',
                'numeric',
                function($attribute, $value, $fail) {
                    return ($this->teamIdExists() == 0) ? $fail(Config::get('constants.messages.teamNotExists')): true;
            }],
            'playerId' => [
                'bail',
                'required',
                'numeric',
                function($attribute, $value, $fail) {
                    $result = $this->checkPlayerAvailability();
                    if($result == 0){
                        return $fail(Config::get('constants.messages.playerNotExists'));
                    }else if($result == 1){
                        return $fail(Config::get('constants.messages.playerAlreadyInTeam'));
                    }else if($result == 2){
                        return $fail(Config::get('constants.messages.playerAlreadyInOtherTeam'));
                    }else{
                        return true;
                    }
            }],        
        ];
    }
    
    public function teamIdExists(){

        return (DB::table('team')
            ->select('team.teamId')    
            ->where('team.teamId', '=', $this->request->get('teamId'))
            ->count()); 
    }
    
    public function checkPlayerAvailability(){
        
        $count = DB::table('player')
            ->select('player.playerId')    
            ->where('player.playerId', '=', $this->request->get('playerId'))
            ->count(); 
        if($count == 0){
            return 0;
        }
        
        $data = DB::table('player')
            ->join('teamsplayer','teamsplayer.playerId','=','player.playerId')    
            ->where('player.playerId', '=', $this->request->get('playerId'))
            ->where('teamsplayer.teamId', '=', $this->request->get('teamId'))    
            ->count();
        if($data > 0){
            return 1;
        }
        
        $data = DB::table('player')
            ->join('teamsplayer','teamsplayer.playerId','=','player.playerId')    
            ->where('player.playerId', '=', $this->request->get('playerId'))
            ->count();
        if($data > 0){
            return 2;
        }
        
        return 3;
    }
}
