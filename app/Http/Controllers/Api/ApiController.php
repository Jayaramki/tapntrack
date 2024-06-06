<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ApiController extends Controller
{
    
    //Login API (POST)
    public function login(Request $request){
        // Data Validation
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check User
        if(!Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials!'
            ], 401);
        }

        // Create Token
        $user = User::where('username', $request->username)->first();
        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'status' => true,
            'message' => 'User logged in successfully!',
            'token' => $token
        ], 200);
    }

    //Logout API (GET)
    public function logout(){
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully!'
        ], 200);
    }
}
