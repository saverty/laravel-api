<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    use AuthTrait;

    /**
     * Register
     * Register a new user
     * @group Authentification
     * @queryParam name required The name of the user
     * @queryParam email required The email of the user
     * @queryParam password required The passowrd of the user
     * @queryParam password-confirmation required The password confirmation of the user
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $validator = $this->registerValidator($request->all());
        if($validator["status"]){
            $user = $this->createUser($request->all());

            $token = $user->createToken('token');
            return response()->json([
                "user" => $user,
                "token" => $token->accessToken
            ],200);
        }else{
            return response()->json([
                "errors" => $validator["result"]
            ], 400);
        }
    }

    /**
     * Login
     * Login any types of user
     * @group Authentification
     * @queryParam email required The email of the user
     * @queryParam password required The password of the user
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]) )
        {
            $user = User::where('email', $request->email)->first();
            return response()->json([
                "user" => $user,
                "token" => $user->createToken('token')->accessToken
            ], 200);
        }
        else
        {
            return response()->json([
                "errors" => "Login credentials are wrongs",
            ], 400);
        }
    }
}
