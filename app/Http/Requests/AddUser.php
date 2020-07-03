<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class AddUser extends FormRequest
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
            'username' => [
                'bail',
                'required',
                'max:10',
                'min:3',
                function($attribute, $value, $fail) {
                    $data = (new \App\User())->getUserByName($value);
                    return (!empty($data)) ? $fail(Config::get('constants.messages.userExists')): true;
                },
            ],
            'email' => 'bail|required|email',
            'password' => 'bail|required|max:10|min:8',            
        ];
    }
}
