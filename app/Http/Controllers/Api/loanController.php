<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\loan;


class loanController extends Controller
{
    //Add API (POST)
    public function add(Request $request){
        $user = Auth::user();
        // Data Validation
        $request->validate([
            'cid' => 'required|integer',
            'loan_number' => 'required|string',
            'disbursed_amt' => 'required|double',
            'loan_type' => 'required|string',
            'line_id' => 'required|integer',
            'interest_amount' => 'required|double',
            'installment_amount' => 'required|integer',
            'disbursed_at' => 'required|date'
        ]);
        
        // Create User
        $loan = loan::create([
            'franchise_id' => $user->franchise_id,
            'cid' => $request->cid,
            'loan_number' => $request->loan_number,
            'disbursed_amt' => $request->disbursed_amt,
            'loan_type' => $request->loan_type,
            'line_id' => $request->line_id,
            'interest_amt' => $request->interest_amount,
            'installment_amt' => $request->installment_amount,
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

    //Update loan API (PUT)
    public function update(Request $request, $id){
        $user = Auth::user();
        // Data Validation
        $request->validate([
            'cid' => 'required|integer',
            'loan_number' => 'required|string',
            'disbursed_amt' => 'required|double',
            'loan_type' => 'required|string',
            'line_id' => 'required|integer',
            'interest_amount' => 'required|double',
            'installment_amount' => 'required|integer',
            'disbursed_at' => 'required|date'
        ]);

        // Update loan
        $loan = loan::find($id);
        $loan->cid = $request->cid;
        $loan->loan_number = $request->loan_number;
        $loan->disbursed_amt = $request->disbursed_amt;
        $loan->loan_type = $request->loan_type;
        $loan->line_id = $request->line_id;
        $loan->interest_amt = $request->interest_amount;
        $loan->installment_amt = $request->installment_amount;
        $loan->disbursed_at = $request->disbursed_at;
        $loan->updated_by = $user->id;
        $loan->updated_at = now()->utc();
        $loan->save();

        return response()->json([
            'status' => true,
            'message' => 'loan updated successfully!',
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

    //Get all loan API (GET)
    public function getAll(){
        $user = Auth::user();
        $loans = loan::where('is_deleted', null)
                ->where('franchise_id', Auth::user()->franchise_id)
                ->get();

        return response()->json([
            'status' => true,
            'loans' => $loans
        ], 200);
    }

    //Get all loan by customer id API (GET)
    public function getAllByCustomerId($cid){
        $loans = loan::where('cid', $cid)
                    ->where('is_deleted', null)
                    ->where('franchise_id', Auth::user()->franchise_id)
                    ->get();

        return response()->json([
            'status' => true,
            'loans' => $loans
        ], 200);
    }

    //Get all loan by line id API (GET)
    public function getAllByLineId($line_id){
        $loans = loan::where('line_id', $line_id)
                    ->where('is_deleted', null)
                    ->where('franchise_id', Auth::user()->franchise_id)
                    ->get();

        return response()->json([
            'status' => true,
            'loans' => $loans
        ], 200);
    }

    //Get all loan by loan type API (GET)
    public function getAllByLoanType($loan_type){
        $loans = loan::where('loan_type', $loan_type)
                        ->where('is_deleted', null)
                        ->where('franchise_id', Auth::user()->franchise_id)
                        ->get();

        return response()->json([
            'status' => true,
            'loans' => $loans
        ], 200);
    }

    //Check loan number exists API (GET)
    public function checkLoanNumberExists($loan_number){
        $loan = loan::where('loan_number', $loan_number)
                    ->where('is_deleted', null)
                    ->where('franchise_id', Auth::user()->franchise_id)
                    ->first();
        if (!$loan) {
            return response()->json([
                'status' => false,
                'message' => 'Loan number not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Loan number already exists',
            'loan' => $loan
        ], 200);
    }

    //algorithm to create loan number
    public function createLoanNumber($cid){
        $loan = loan::where('cid', $cid)
                ->where('is_deleted', null)
                ->where('franchise_id', Auth::user()->franchise_id)
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
