<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Worker\WorkerController;
use App\Http\Controllers\Firebase\FirebaseBrozotController;
use App\Http\Controllers\Android\TokenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/company/create', [CompanyController::class, 'create']);
Route::post('/company/store', [CompanyController::class, 'store']);
Route::get('/company/list', [CompanyController::class, 'listCompanies']);
Route::get('/company/show/{id}', [CompanyController::class, 'show']);
Route::get('/company/delete/{id}', [CompanyController::class, 'delete']);
Route::get('/company/edit/{id}', [CompanyController::class, 'edit']);
Route::post('/company/update', [CompanyController::class, 'update']);

Route::get('/company/show/{id?}/worker/create', [WorkerController::class, 'create'])->name('create_worker_route');
Route::post('/company/show/{id?}/worker/create', [WorkerController::class, 'store']);
Route::get('/worker/show/{id}', [WorkerController::class, 'show']);
Route::get('/company/show/{company_id}/worker/{id}/edit', [WorkerController::class, 'edit']);
Route::post('/company/show/{company_id}/worker/{id}/edit', [WorkerController::class, 'update']);
Route::get('/company/show/{company_id}/worker/{id}/delete', [WorkerController::class, 'delete']);
Route::get('/worker/list/{id?}', [WorkerController::class, 'listWorkers']);

//Route::get('/firebase', 'Firebase\FirebaseController@index');
//Route::get('/firebase-v2', 'Firebase\FirebaseControllerV2@index');

Route::get('/fb/sendnotifications', [FirebaseBrozotController::class, 'sendNotifications']);
Route::get('/worker/unactivateworkers', [WorkerController::class, 'unactivateWorkers']);

//Route::get('/firebase-v2', 'Firebase\FirebaseControllerV2@index');

// URI to save token sent from android device: token - sent from android device, checkapptoken: string saved in .env file and in android app (must match)
Route::get('/android/token/{token}/{checkapptoken}', [TokenController::class, 'checkIfTokenShouldBeStored']);
