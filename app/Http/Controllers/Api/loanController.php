<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Loan;


class LoanController extends Controller
{
    //Add Loan API (POST)
    public function add(Request $request){
        $user = Auth::user();
        // Data Validation
        $request->validate([
            'cid' => 'required|integer',
            'loan_number' => 'required|string',
            'disbursed_amt' => 'required|integer',
            'loan_type' => 'required|string',
            'line_id' => 'required|integer',
            'interest_amt' => 'required|integer',
            'installment_amt' => 'required|integer',
            'disbursed_at' => 'required|date'
        ]);
        
        // Create User
        $loan = loan::create([
            'franchise_id' => Auth::user()->franchiseId(),
            'cid' => $request->cid,
            'loan_number' => $request->loan_number,
            'disbursed_amt' => $request->disbursed_amt,
            'loan_type' => $request->loan_type,
            'line_id' => $request->line_id,
            'interest_amt' => $request->interest_amt,
            'installment_amt' => $request->installment_amt,
            'disbursed_at' => $request->disbursed_at,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'loan created successfully!',
            'loan' => $loan
        ], 201);
    }

    //Get loan API (GET)
    public function get($id){
        $loan = loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'loan not found'], 404);
        }
        return response()->json([
            'status' => true,
            'loan' => $loan
        ], 200);
    }

    // Update loan API (PUT)
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        // Data Validation
        $request->validate([
            'cid' => 'required|integer',
            'loan_number' => 'required|string',
            'disbursed_amt' => 'required|integer',
            'loan_type' => 'required|string',
            'line_id' => 'required|integer',
            'interest_amt' => 'required|integer',
            'installment_amt' => 'required|integer',
            'disbursed_at' => 'required|date'
        ]);

        // Find the loan or return an error response
        $loan = Loan::find($id);
        if (!$loan) {
            return response()->json([
                'status' => false,
                'message' => 'Loan not found!'
            ], 404);
        }

        // Update loan using mass assignment
        $loan->update([
            'cid' => $request->cid,
            'loan_number' => $request->loan_number,
            'disbursed_amt' => $request->disbursed_amt,
            'loan_type' => $request->loan_type,
            'line_id' => $request->line_id,
            'interest_amt' => $request->interest_amt,
            'installment_amt' => $request->installment_amt,
            'disbursed_at' => $request->disbursed_at,
            'updated_by' => $user->id,
            'updated_at' => now()->utc()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Loan updated successfully!',
            'loan' => $loan
        ], 200);
    }

    //Delete loan API (DELETE)
    public function delete($id){
        $loan = loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'loan not found'], 404);
        }
        // Update the customer fields
        $loan->is_deleted = now()->utc();
    
        // Save the changes
        $loan->save();
        return response()->json([
            'status' => true,
            'message' => 'loan deleted successfully!'
        ], 200);
    }

    //Get all loan API (GET) with pagination
    public function getAll(Request $request){

        // Set a default values
        $defaultPageSize = 10;

        // Validate the parameters
        $request->validate([
            'page_size' => 'integer|min:1|max:100|nullable',
            'search' => 'string|nullable',
            'cid' => 'string|nullable',
            'loan_number' => 'numeric|nullable',
            'disbursed_amt' => 'string|nullable',
            'loan_type' => 'string|nullable',
            'line_id' => 'integer|nullable',
            'interest_amt' => 'integer|nullable',
            'installment_amt' => 'integer|nullable'
        ]);

        // Get the page size from the request or use the default
        $pageSize = $request->input('page_size', $defaultPageSize);

        // Define the filterable fields
        $filterableFields = ['cid', 'loan_number', 'disbursed_amt', 'loan_type', 'line_id', 'interest_amt', 'installment_amt'];

        // Start building the query
        $query = Loan::query();
        $query->where('franchise_id', Auth::user()->franchiseId());
        $query->whereNull('is_deleted');

        // Add filters dynamically
        foreach ($filterableFields as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        // Paginate the results
        $loans = $query->paginate($pageSize);

        return response()->json([
            'status' => true,
            'loans' => $loans
        ], 200);
    }
    
    //algorithm to create loan number
    public function createLoanNumber($cid){
        $loan = loan::where('cid', $cid)
                ->where('is_deleted', null)
                ->where('franchise_id', Auth::user()->franchiseId())
                ->orderBy('id', 'desc')->first();
        if (!$loan) {
            return response()->json([
                'status' => true,
                'loan_number' => $cid . '001'
            ], 200);
        }
        $loan_number = $loan->loan_number;
        $loan_number = (int)substr($loan_number, -3);
        $loan_number++;
        $loan_number = str_pad($loan_number, 3, '0', STR_PAD_LEFT);
        return response()->json([
            'status' => true,
            'loan_number' => $cid . $loan_number
        ], 200);
    }   
}
