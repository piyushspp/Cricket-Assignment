<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class RemovePlayerFromTeam extends FormRequest
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
                    return ($this->checkPlayerExistsInTeam() == 0) ? $fail(Config::get('constants.messages.playerNotExistsInTeam')): true;
            }],        
        ];
    }
    
    public function teamIdExists(){

        return (DB::table('team')
            ->select('team.teamId')    
            ->where('team.teamId', '=', $this->request->get('teamId'))
            ->count()); 
    }
    
    public function checkPlayerExistsInTeam(){
        
        return (DB::table('teamsplayer')
            ->select('teamsplayer.teamPlayerId')    
            ->where([['teamsplayer.teamId',$this->request->get('teamId')],
                ['teamsplayer.playerId',$this->request->get('playerId')]])    
            ->count());
        
    }
}
