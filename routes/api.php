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
Route::post('user/register', [UserController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);

// Protected Routes
Route::group([
    "middleware" => ['auth:api']
], function() {

    /* User Module */
    Route::get('user/profile', [UserController::class, 'profile']);
    Route::get('user/get-users', [UserController::class, 'listUsers']);
    Route::put('user/update-profile', [UserController::class, 'updateProfile']);
    Route::put('user/change-password', [UserController::class, 'changePassword']);
    Route::put('user/delete-user', [UserController::class, 'deleteUser']);
    Route::get('logout', [ApiController::class, 'logout']);

    /* Customer Module */
    Route::post('customer/add', [CustomerController::class, 'add']);
});