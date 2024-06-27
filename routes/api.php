<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Syntax: <Project URL>/api/<URI>
// Syntax: <HTTP-VERB>('<URI>', [Controller::class, '<METHOD>']);

// Open Routes
Route::post('login', [ApiController::class, 'login']);
Route::post('user/add-admin', [UserController::class, 'addAdminUser']);
Route::post('user/update-admin/{id}', [UserController::class, 'addAdminUser']);


// Protected Routes
Route::group([
    "middleware" => ['auth:api']
], function() {

    /* User Module */
    //pass optional parameter for update api
    Route::post('user/add', [UserController::class, 'addUser']);
    Route::get('user/get/{id?}', [UserController::class, 'profile']);
    Route::post('user/update/{id?}', [UserController::class, 'updateProfile']);
    Route::post('user/update-username/{id?}', [UserController::class, 'changeUsername']);
    Route::get('user/get-all', [UserController::class, 'listUsers']);
    Route::post('user/change-password', [UserController::class, 'changePassword']);
    Route::post('user/update-password/{id}', [UserController::class, 'updateUserPassword']);
    Route::post('user/delete/{id}', [UserController::class, 'deleteUser']);
    Route::get('logout', [ApiController::class, 'logout']);

    /* Customer Module */
    Route::post('customer/add', [CustomerController::class, 'add']);
    Route::put('customer/update/{id}', [CustomerController::class, 'update']);
    Route::get('customer/get/{id}', [CustomerController::class, 'get']);
    Route::get('customer/get-all', [CustomerController::class, 'getAll']);
    Route::get('customer/get-all-active', [CustomerController::class, 'getAllActive']);
    Route::post('customer/delete/{id}', [CustomerController::class, 'delete']);

    /* Loan Module */
    Route::post('loan/add', [LoanController::class, 'add']);
    Route::put('loan/update/{id}', [LoanController::class, 'update']);
    Route::get('loan/get/{id}', [LoanController::class, 'get']);
    Route::get('loan/get-all', [LoanController::class, 'getAll']);
    Route::get('loan/get-all-by-customer/{cid}', [LoanController::class, 'getAllByCustomerId']);
    Route::get('loan/get-all-by-line/{line_id}', [LoanController::class, 'getAllByLineId']);
    Route::get('loan/delete/{id}', [LoanController::class, 'delete']);
    Route::get('loan/check-loan-number/{loan_number}', [LoanController::class, 'checkLoanNumberExists']);
    Route::get('loan/create-loan-number', [LoanController::class, 'createLoanNumber']);
});