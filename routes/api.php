<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\CacheController;

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

// Clear Cache
Route::get('clear-cache', [CacheController::class, 'clearCache']);
Route::get('clear-route-cache', [CacheController::class, 'clearRouteCache']);
Route::get('clear-config-cache', [CacheController::class, 'clearConfigCache']);

// Protected Routes
Route::group([
    "middleware" => ['auth:api']
], function() {

    /* User Module */
    Route::post('user/add', [UserController::class, 'addUser']);
    Route::get('user/get/{id?}', [UserController::class, 'profile']);
    Route::post('user/update/{id?}', [UserController::class, 'updateProfile']);
    Route::post('user/update-username/{id?}', [UserController::class, 'changeUsername']);
    Route::get('user/get-all', [UserController::class, 'listUsers']);
    Route::post('user/change-password', [UserController::class, 'changePassword']);
    Route::post('user/update-password/{id}', [UserController::class, 'updateUserPassword']);
    Route::post('user/delete', [UserController::class, 'deleteUser']);
    Route::get('logout', [ApiController::class, 'logout']);
    /* User Module */

    /* Customer Module */
    Route::post('customer', [CustomerController::class, 'add']);
    Route::put('customer/{id}', [CustomerController::class, 'update']);
    Route::get('customer/{id}', [CustomerController::class, 'get']);
    Route::get('customers', [CustomerController::class, 'getAll']);
    Route::delete('customer/{id}', [CustomerController::class, 'delete']);
    /* Customer Module */

    /* Loan Module */
    Route::post('loan', [LoanController::class, 'add']);
    Route::put('loan/{id}', [LoanController::class, 'update']);
    Route::get('loan/{id}', [LoanController::class, 'get']);
    Route::get('loans', [LoanController::class, 'getAll']);
    Route::delete('loan/{id}', [LoanController::class, 'delete']);

    Route::get('loan/get-all-by-customer/{cid}', [LoanController::class, 'getAllByCustomerId']);
    Route::get('loan/get-all-by-line/{line_id}', [LoanController::class, 'getAllByLineId']);
    Route::get('loan/check-loan-number/{loan_number}', [LoanController::class, 'checkLoanNumberExists']);
    Route::get('loan/create-loan-number', [LoanController::class, 'createLoanNumber']);
});