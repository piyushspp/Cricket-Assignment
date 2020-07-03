<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddUser;

class UsersController extends Controller
{
    public function signup(AddUser $request) { 
        $result = (new \App\User())->saveUser($request);
        return response()->json($result);
    }
}
