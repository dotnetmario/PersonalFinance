<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// models
use App\User;
// custom requests
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;

class AuthController extends Controller
{
    /**
     * registration
     * route => api (/auth/register)
     */
    public function register(RegisterRequest $request)
    {
        $params = $request->all();

        $user = (new User)->register($params);

        // return response
        if($user){
            return response()->json([
                "user" => $user->toJson(),
                "message" => trans('register.user_registred'),
            ], 201);
        }else{
            return response()->json([
                "user" => null,
                "message" => trans('app.something_went_wrong'),
            ], 500);
        }
    }

    /**
     * login
     * route => api (/auth/login)
     */
    public function login(LoginRequest $request)
    {
        $params = $request->all();

        $user = (new User)->login($params);
        

        // return response utf8_encode(
        if($user['status']){
            return response()->json([
                // "access_token" => $user['access_token'].toJson(),
                // "expires_at" => $user['expires_at'].toJson(),array_map("utf8_encode", $inputArray );
                "user" => array_map("utf8_encode", $user),
                "message" => trans('login.user_logged_in'),
            ], 200, ['Content-Type' => 'application/json;charset=utf8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                "user" => null,
                "message" => trans('login.email_or_pass_wrong'),
            ], 403, [], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * logout
     * route => api (/auth/logout)
     */
    public function logout(Request $request)
    {
        $user = (new User)->logout($request->user());

        // return response
        if($user){
            return response()->json([
                "message" => trans('login.user_logged_out')
            ], 200);
        }else{
            return response()->json([
                "message" => trans('app.something_went_wrong')
            ], 500);
        }
    }
}