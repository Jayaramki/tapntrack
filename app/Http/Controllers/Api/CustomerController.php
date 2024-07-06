<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerController extends Controller
{
    //Add API (POST)
    public function add(Request $request){
        // Data Validation
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'string|nullable',
            'email_id' => 'email|nullable',
            'address' => 'string',
            'profession' => 'string|nullable',
            'is_active' => 'integer|nullable'
        ]);
        
        // Create User
        $customer = Customer::create([
            'franchise_id' => Auth::user()->franchiseId(),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email_id' => $request->first_name,
            'address' => $request->last_name,
            'profession' => $request->email,
            'is_active' => $request->is_active
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully!',
            'customer' => $customer
        ], 201);
    }

    //Update Custome API (PUT)
    public function update(Request $request, $id){
        // Data Validation
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'string|nullable',
            'email_id' => 'email|nullable',
            'address' => 'string|nullable',
            'profession' => 'string|nullable',
            'is_active' => 'integer|nullable'
        ]);
        
        // Update Customer
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

         // Update the customer fields
        $customer->name = $request->input('name');
        $customer->phone_number = $request->input('phone_number');
        $customer->email_id = $request->input('email_id');
        $customer->address = $request->input('address');
        $customer->profession = $request->input('profession');
        $customer->is_active = $request->input('is_active');

        // Save the changes
        $customer->save();

        return response()->json([
            'status' => true,
            'message' => 'Customer updated successfully!',
            'customer' => $customer
        ], 200);
    }

    //Get Customer API (GET)
    public function get($id){
        // Get Customer
        $customer = Customer::find($id);
        
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Customer fetched successfully!',
            'customer' => $customer
        ], 200);
    }
    
    //Get All Customers API (GET)
    public function getAll(){
        // Get All Customers where is_deleted is null
        $customers = Customer::where('is_deleted', null)
                            ->where('franchise_id', Auth::user()->franchiseId())
                            ->get();
                            
        return response()->json([
            'status' => true,
            'message' => 'Customers fetched successfully!',
            'customers' => $customers
        ], 200);
    }
                        
    //Get All Active Customers API (GET)
    public function getAllActive(){
        // Get All Active Customers and is_deleted is null
        $customers = Customer::where('is_deleted', null)
        ->where('franchise_id', Auth::user()->franchiseId())
        ->where('is_active', 0)
        ->get();
                            
        return response()->json([
            'status' => true,
            'message' => 'Active Customers fetched successfully!',
            'customers' => $customers
        ], 200);
    }

    //Delete Customer API (POST)
    public function delete(Request $request){
        $request->validate([
            'customer_id' => 'required|integer'
        ]);
        // Find Customer
        $customer = Customer::find($request->customer_id);
    
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
    
         // Update the customer fields
        $customer->is_deleted = now()->utc();
        
        // Save the changes
        $customer->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Customer deleted successfully!'
        ], 200);
    }
}
