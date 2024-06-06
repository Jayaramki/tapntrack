<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    //Register API (POST)
    public function register(Request $request){
        // Data Validation
        $request->validate([
            'user_type' => 'required|integer',
            'franchise_id' => 'required|integer',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'string|nullable',
            'email' => 'email|nullable',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
            'is_active' => 'integer|nullable',
            'app_type' => 'string|nullable',    //app_type should only accept D, W, M
        ]);
        
        $is_active = isset($request->is_active) && $request->is_active == 0 ? null : now()->utc();
        $app_type = isset($request->app_type) ? $request->app_type : 'D';
        
        // Create User
        $user = User::create([
            'user_type' => $request->user_type,
            'franchise_id' => $request->franchise_id,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => $is_active  
        ]);

        if($request->user_type == 1 || $request->user_type == 2){
            $app_configuration = [
                ['franchise_id' => $user->id, 'key' => 'APP_NAME', 'value' => 'FEL'],
                ['franchise_id' => $user->id, 'key' => 'DAYS_TO_PAY', 'value' => 100],
                ['franchise_id' => $user->id, 'key' => 'INTEREST_PERCENTAGE', 'value' => 10],
                ['franchise_id' => $user->id, 'key' => 'TYPE', 'value' => $app_type]
            ];
            \DB::table('app_configuration')->insert($app_configuration);
        }

        return response()->json([
            'status' => true,
            'message' => 'User created successfully!',
            'user' => $user
        ], 201);
    }

    //Profile API (GET)
    public function profile(){
        $user = Auth::user();
        
        return response()->json([
            'status' => true,
            'message' => 'User profile fetched successfully!',
            'user' => $user
        ], 200);
    }

    //Update Profile API (PUT)
    public function updateProfile(Request $request){
        // Data Validation
        $request->validate([
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'email' => 'email|nullable',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
            'is_active' => 'integer|nullable'
        ]);

        $is_active = isset($request->is_active) && $request->is_active == 0 ? null : now()->utc();
        
        // Update User
        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->is_active = $is_active;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User profile updated successfully!',
            'user' => $user
        ], 200);
    }

    //Change Password API (PUT)
    public function changePassword(Request $request){
        // Data Validation
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string'
        ]);

        // Check Old Password
        $user = Auth::user();
        if(!Hash::check($request->old_password, $user->password)){
            return response()->json([
                'status' => false,
                'message' => 'Invalid old password!'
            ], 401);
        }

        // Update Password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User password updated successfully!'
        ], 200);
    }

    //Delete User API (DELETE)
    public function deleteUser(Request $request){
        // Data Validation
        $request->validate([
            'user_id' => 'required|integer'
        ]);

        // Delete User
        $user = User::find($request->user_id);
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'User not found!'
            ], 404);
        }
        $user->is_deleted = now()->utc();
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully!'
        ], 200);
    }

    //List Users API (GET)
    public function listUsers(){
        $user = Auth::user();
        if($user->user_type == 1){
            $users = User::where('is_deleted', null)->get();
        }else if($user->user_type == 2){
            $users = User::where('franchise_id', $user->id)->where('is_deleted', null)->get();
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access!'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Users fetched successfully!',
            'users' => $users
        ], 200);
    }
}

