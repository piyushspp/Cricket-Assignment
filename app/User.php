<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function getUserByName($name) {
        return (new self)
                ->where('users.name',$name)
                ->first();
    }
    
    public function saveUser($data) {
        DB::beginTransaction();
        try{ 
           
            $user = new User();
            $user->name     = $data['username'];
            $user->email    = $data['email'];
            $user->password = $data['password'];;
            $user->save();
            DB::commit();
            return ['status'=>true,'message'=> Config::get('constants.messages.addTeam'),'data'=> $user];
        }
        catch(\Exception $ex){
            DB::rollBack();
            return ['status'=>false,'message'=> $ex->getMessage()];
        }
    }
}
