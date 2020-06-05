<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class PlayMatch extends FormRequest
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
            'teamOne' => [
                'bail',
                'required',
                'numeric',
                function($attribute, $value, $fail) { 
                    return ($this->teamIdExists($value) == 0) ? $fail(Config::get('constants.messages.teamNotExists')): true;
            }],
            'teamTwo' => [
                'bail',
                'required',
                'numeric',
                function($attribute, $value, $fail) {
                    $result = $this->teamIdExists($value);
                    if($result == 0){
                        return $fail(Config::get('constants.messages.teamNotExists'));
                    }else{
                        if($this->request->get('teamOne') == $this->request->get('teamTwo')){
                            return $fail(Config::get('constants.messages.twoTeamsCanNotBeSame'));
                        }else{
                            return true;
                        }
                    }
            }],
            'winner' => [
                'bail',
                'required',
                function($attribute, $value, $fail) {
                $validOptions = array("teamOne","teamTwo","draw");
                if (!in_array($value, $validOptions)) {
                    return $fail(Config::get('constants.messages.winnerRule'));
                }
                return true;
            }],        
        ];
    }
    
    public function teamIdExists($teamId){

        return (DB::table('team')
            ->select('team.teamId')    
            ->where('team.teamId', '=', $teamId)
            ->count()); 
    }
}
