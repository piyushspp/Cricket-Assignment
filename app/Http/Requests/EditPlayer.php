<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class EditPlayer extends FormRequest
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
            'playerId' => 'bail|sometimes|nullable|numeric',
            'firstName' => 'bail|required|max:30|min:3',
            'lastName' => 'bail|required|max:30|min:3',
            'imageUri' => 'bail|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'playerJersyNumber' => 'bail|required|numeric|digits_between:1,3',
            'country'=> 'bail|required|max:50|min:3',
            'matches'=> 'bail|required|numeric|digits_between:1,3',
            'run'=> 'bail|required|numeric|digits_between:1,5',
            'highestScore'=> 'bail|required|numeric|digits_between:1,3',
            'fifties'=> 'bail|required|numeric|digits_between:1,2',
            'hundreds'=> 'bail|required|numeric|digits_between:1,2',
        ];
    }
}
