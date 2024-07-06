<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserTypeEnums as UserType;

class UserController extends Controller
{
    //Register Admin API (POST)
    public function addAdminUser(Request $request){
        // Data Validation
        $request->validate([
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
        
        $app_type = isset($request->app_type) ? $request->app_type : 'D';
        
        // Create User
        $user = User::create([
            'user_type' => UserType::ADMIN,
            'franchise_id' => 0,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => $request->is_active  
        ]);
        //Assign Role
        $user->assignRole('admin');

        $app_configuration = [
            ['franchise_id' => $user->id, 'key' => 'APP_NAME', 'value' => 'FEL'],
            ['franchise_id' => $user->id, 'key' => 'DAYS_TO_PAY', 'value' => 100],
            ['franchise_id' => $user->id, 'key' => 'INTEREST_PERCENTAGE', 'value' => 10],
            ['franchise_id' => $user->id, 'key' => 'TYPE', 'value' => $app_type]
        ];
        \DB::table('app_configuration')->insert($app_configuration);

        return response()->json([
            'status' => true,
            'message' => 'Admin created successfully!',
            'user' => $user
        ], 201);
    }

    //Register Admin API (POST)
    public function updateAdminUser(Request $request, $id){

        $user = User::find($id);
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'User not found!'
            ], 404);
        }

        // Data Validation
        $request->validate([
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
        
        $app_type = isset($request->app_type) ? $request->app_type : 'D';
        
        // Update Admin User
        $user->update([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => $request->is_active  
        ]);
        //Assign Role
        
        return response()->json([
            'status' => true,
            'message' => 'Admin updated successfully!',
            'user' => $user
        ], 201);
    }

    //Register Other users API (POST)
    public function addUser(Request $request){
        //print_r(Auth::user()->hasAnyPermission('user'));exit;
        // Data Validation
        $request->validate([
            'user_type' => 'required|integer|not_in:1',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'string|nullable',
            'email' => 'email|nullable',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
            'is_active' => 'boolean|nullable',
            'app_type' => 'string|nullable',    //app_type should only accept D, W, M
        ]);
        
        $franchise_id = Auth::user()->user_type == UserType::ADMIN ? Auth::user()->id : Auth::user()->franchise_id;
        
        // Create User
        $user = User::create([
            'user_type' => $request->user_type,
            'franchise_id' => $franchise_id,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => $request->is_active  
        ]);

        switch ($user->user_type) {
            case '1':
                $user->assignRole('admin');
                break;
            case '2':
                $user->assignRole('operator');
                break;
            case '3':
                $user->assignRole('collection_agent');
                break;
            default:
                $user->assignRole('collection_agent');
                break;
        }

        return response()->json([
            'status' => true,
            'message' => 'User created successfully!',
            'user' => $user
        ], 201);
    }

    //Profile API (GET)
    public function profile($id=null){
        if($id){
            $user = User::find($id);
            if(!$user){
                return response()->json([
                    'status' => false,
                    'message' => 'User not found!'
                ], 404);
            }
        } else {
            $user = Auth::user();
        }
        
        return response()->json([
            'status' => true,
            'message' => 'User profile fetched successfully!',
            'user' => $user
        ], 200);
    }

    //Update Profile API (POST)
    public function updateProfile(Request $request, $id=null){

        if($id){
            $user = User::find($id);
            if(!$user){
                return response()->json([
                    'status' => false,
                    'message' => 'User not found!'
                ], 404);
            }  
        } else {
            $user = Auth::user();
        }
        
        // Data Validation
        $request->validate([
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'email' => 'email|nullable',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
            'is_active' => 'boolean|nullable'
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->is_active = $request->is_active;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User profile updated successfully!',
            'user' => $user
        ], 200);
    }   

    //Update User Password API (POST)
    public function changeUsername(Request $request, $id=null){
        if($id){
            $user = User::find($id);
            if(!$user){
                return response()->json([
                    'status' => false,
                    'message' => 'User not found!'
                ], 404);
            }
        } else {
            $user = Auth::user();
        }
        
        // Data Validation
        $request->validate([
            'username' => 'required|string|unique:users,username,'.$user->id
        ]);
        
        // Update Password
        $user->username = $request->username;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Username has been updated successfully!'
        ], 200);
    }

    //Update User Password API (POST)
    public function updateUserPassword(Request $request, $id){
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'User not found!'
            ], 404);
        }
        // Data Validation
        $request->validate([
            'password' => 'required|string'
        ]);

        // Update Password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User password updated successfully!'
        ], 200);
    }

    //Change Password API (POST)
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

    //Delete User API (POST)
    public function deleteUser(Request $request){
        $request->validate([
            'user_id' => 'required|integer'
        ]);

        //Find User
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
        if($user->user_type == UserType::ADMIN){
            $users = User::where('franchise_id', $user->id)->where('is_deleted', null)->get();
        } else{
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

    //Check is username exists API (GET)
    public function checkIsUsernameExist(Request $request){
        // Data Validation
        $request->validate([
            'username' => 'required|string'
        ]);

        $user = User::where('username', $request->username)
                    ->where('is_deleted', null)
                    ->first();
        if($user){
            return response()->json([
                'status' => true,
                'message' => 'Username exists!'
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Username does not exist!'
            ], 404);
        }
    }
}

