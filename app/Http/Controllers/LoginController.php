<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request){

        $credentials = $request->only(['email','password']);

        if(!$token = auth()->attempt($credentials)){
            return response()->json([
                'status_code' => '0',
                'status_message' => 'Incorrect Email/Password'
            ]);
        }

        return response()->json([
            'status_code' => '1',
            'token'       => $token
        ]);

    }

}
