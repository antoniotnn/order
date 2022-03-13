<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        
        $credentials = $request->all(['email', 'password']);

        //objetivo autenticação (email e senha)
        $token = auth('api')->attempt($credentials); 

        if($token) { 
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'User or password incorrect'], 403);
        }
        //return  Json Web Token (JWT), after autenticated
        return 'login';
    }

    public function logout() {
        auth('api')->logout();
        return response()->json(['msg' => 'Logged out successfully!']);
    }

    public function refresh() {
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }

    public function me() {
        return response()->json(auth()->user());
    }

}
