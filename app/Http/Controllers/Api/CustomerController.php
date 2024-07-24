<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Spatie\QueryBuilder\QueryBuilder;

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
            'is_active' => 'enum:0,1'
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

        // Set a default values
        $defaultPageSize = 10;

        // Validate the parameters
        $request->validate([
            'page_size' => 'integer|min:1|max:100|nullable',
            'search' => 'string|nullable',
            'name' => 'string|nullable',
            'email_id' => 'numeric|nullable',
            'address' => 'string|nullable',
            'profession' => 'string|nullable',
            'is_active' => 'integer|nullable'
        ]);

        // Get the page size from the request or use the default
        $pageSize = $request->input('page_size', $defaultPageSize);

        // Define the filterable fields
        $filterableFields = ['name', 'email_id', 'address', 'profession', 'is_active'];

        // Start building the query
        $query = Customer::query();
        $query->where('franchise_id', Auth::user()->franchiseId());
        $query->whereNull('is_deleted');

        // Add filters dynamically
        foreach ($filterableFields as $field) {
            if ($request->filled($field)) {
                if ($field === 'is_active') {
                    // Exact match for numeric fields
                    $query->where($field, $request->input($field));
                } else {
                    // Partial match for string fields
                    $query->where($field, 'like', '%' . $request->input($field) . '%');
                }
            }
        }

        // Handle general search across multiple columns
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search, $filterableFields) {
                foreach ($filterableFields as $field) {
                    if ($field !== 'is_active') { // Exclude non-string fields from general search
                        $q->orWhere($field, 'like', '%' . $search . '%');
                    }
                }
            });
        }

        // Paginate the results
        $customers = $query->paginate($pageSize);

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
