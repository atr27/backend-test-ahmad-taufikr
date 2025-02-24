<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('api_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => Auth::user()
            ]);
        }
    
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
