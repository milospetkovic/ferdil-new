<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Company\CompanyController;

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

Route::get('/company/show/{id?}/worker/create', 'Worker\WorkerController@create')->name('create_worker_route');
Route::post('/company/show/{id?}/worker/create', 'Worker\WorkerController@store');
Route::get('/worker/show/{id}', 'Worker\WorkerController@show');
Route::get('/company/show/{company_id}/worker/{id}/edit', 'Worker\WorkerController@edit');
Route::post('/company/show/{company_id}/worker/{id}/edit', 'Worker\WorkerController@update');
Route::get('/company/show/{company_id}/worker/{id}/delete', 'Worker\WorkerController@delete');
Route::get('/worker/list/{id?}', 'Worker\WorkerController@listWorkers');

//Route::get('/firebase', 'Firebase\FirebaseController@index');
//Route::get('/firebase-v2', 'Firebase\FirebaseControllerV2@index');

Route::get('/fb/sendnotifications', 'Firebase\FirebaseBrozotController@sendNotifications');
Route::get('/worker/unactivateworkers', 'Worker\WorkerController@unactivateWorkers');

//Route::get('/firebase-v2', 'Firebase\FirebaseControllerV2@index');

// URI to save token sent from android device: token - sent from android device, checkapptoken: string saved in .env file and in android app (must match)
Route::get('/android/token/{token}/{checkapptoken}', 'Android\TokenController@checkIfTokenShouldBeStored');
