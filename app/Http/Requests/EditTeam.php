<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class EditTeam extends FormRequest
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
            'name' => 'required|max:30',
            'state' => 'required|max:30',
        ];
    }
    
    public function teamIdExists(){

        return (DB::table('team')
            ->select('team.teamId')    
            ->where('team.teamId', '=', $this->request->get('teamId'))
            ->count()); 
    }
}
