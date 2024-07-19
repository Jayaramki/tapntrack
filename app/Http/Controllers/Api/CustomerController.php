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
            'is_active' => 'integer'
        ]);
        
        $is_active = $request->input('is_active', 1);
        
        // Create User
        $customer = Customer::create([
            'franchise_id' => Auth::user()->franchiseId(),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email_id' => $request->email_id,
            'address' => $request->address,
            'profession' => $request->profession,
            'is_active' => $is_active
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully!',
            'customer' => $customer
        ], 201);
    }

    //Update Customer API (PUT)
    public function update(Request $request, $id){
        // Data Validation
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'string|nullable',
            'email_id' => 'email|nullable',
            'address' => 'string|nullable',
            'profession' => 'string|nullable',
            'is_active' => 'integer'
        ]);
        
        // Update Customer
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

         // Update the customer fields
        $customer->name = $request->input('name');
        $customer->phone_number = $request->input('phone_number', $customer->phone_number);
        $customer->email_id = $request->input('email_id', $customer->email_id);
        $customer->address = $request->input('address', $customer->address);
        $customer->profession = $request->input('profession', $customer->profession);
        $customer->is_active = $request->input('is_active', $customer->is_active);

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
    
    //Get All Customers API with Pagination (GET)
    ///api/customers?page=2&per_page=10
    public function getAll(Request $request){
        // Set default page size if not provided
        $pageSize = $request->input('page_size', 10);
        $sortField = $request->input('sort', 'id');
        $sortOrder = $request->input('order', 'asc');
        $isActive = $request->input('is_active', null);

        // Validate the sort order to prevent SQL injection
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }

        // Get the filter parameters from the request
        $filters = $request->only(['name', 'phone_number', 'email_id', 'address', 'profession']);

        // Get All Customers where is_deleted is null with pagination and filters
        $customers = Customer::where('is_deleted', null)
                            ->where('franchise_id', Auth::user()->franchiseId())
                            ->when($filters, function ($query, $filters) {
                                foreach ($filters as $column => $value) {
                                    if ($value !== null) {
                                        $query->where($column, '%'.$value.'%');
                                    }
                                }
                            })
                            ->when($isActive === true, function ($query) use ($isActive) {
                                $query->whereNotNull('is_active');
                            })
                            ->when($isActive === null, function ($query) use ($isActive) {
                                $query->whereNull('is_active');
                            })
                            ->orderBy($sortField, $sortOrder)
                            ->paginate($pageSize);

        return response()->json([
            'status' => true,
            'message' => 'Customers fetched successfully!',
            'customers' => $customers
        ], 200);
    }
                        

    //Delete Customer API (POST)
    public function delete($id){
        // Find Customer
        $customer = Customer::find($id);
    
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
