<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\WorkerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// API routes under `auth:sanctum` middleware.
Route::group(['middleware' => 'auth:sanctum'], function() {

    // Get user's customers info.
    Route::get('/user/customers', [ CustomerController::class, 'getUserCustomers' ]);

    // Get user's customers list.
    Route::get('/user/customers/list', [ CustomerController::class, 'getUserCustomersList' ]);

    // Get customer's workers.
    Route::get('/customer/{id}/workers', [ CustomerController::class, 'getCustomerWorkers' ])->name('customer.workers');

    // Customer resource.
    Route::apiResource('customer','App\Http\Controllers\Api\CustomerController' );

    // Customers list.
    //Route::get('customers/list', [ App\Http\Controllers\Api\CustomerController::class, 'listCustomers' ]);

    // Get logged in user.
    Route::get('/user', function(Request $request) {
        return $request->user();
    });

    // Get user's workers.
    Route::get('/user/workers', [ WorkerController::class, 'getUserWorkers' ]);

    // Test route.
    Route::get('/test', function() {
        return response()->json(['message' => 'Hello world']);
    });

});

//Route::get('test', function () {
//    return response()->json(['message' => 'Hello world']);
//});

//Route::middleware('auth:sanctum')->get('test', function (Request $request) {
//    return response()->json(['message' => 'Hello world']);
//});
