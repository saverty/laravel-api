<?php

namespace App\Traits;

use Validator;
use App\User;
trait AuthTrait
{
    public function registerValidator($params){
        $validator =  Validator::make($params, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        if($validator->fails()){
            return [
                "status" => false,
                "result" => $validator->errors()->messages()
            ];
        }else{
            return [
                "status" => true
            ];
        }
    }

    public function createUser($params){
        $user = new User();
        $user->name = $params['name'];
        $user->email = $params['email'];
        $user->password = bcrypt($params['password']);
        $user->save();

        return $user;
    }
}