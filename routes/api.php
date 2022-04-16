<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/user/companies', function (Request $request) {
    return response()->json([
        1 => 'Company 1',
        2 => 'Company 2',
    ]);
});

//Route::get('test', function () {
//    return response()->json(['message' => 'Hello world']);
//});

Route::middleware('auth:sanctum')->get('test', function (Request $request) {
    return response()->json(['message' => 'Hello world']);
});
