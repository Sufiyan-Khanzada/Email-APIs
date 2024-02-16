<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\SubscribersController;

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
Route::post('register', [PassportController::class, 'register']);
Route::post('login', [PassportController::class, 'login']);
Route::get('showadmin', [PassportController::class, 'showall']);
Route::get('showcustomer', [PassportController::class, 'showallclients']);
Route::get('singleclients/{id}', [PassportController::class, 'show']);
Route::post('users_update/{id}', [PassportController::class, 'update_users']);


//////////Subscribers API's///////////////
Route::post('addsubs', [SubscribersController::class, 'addsubs']);
Route::get('showallsubs', [SubscribersController::class, 'shwoallsubs']);
Route::post('subsupdate/{id}', [SubscribersController::class, 'update_subs']);
Route::get('singlesubs/{id}', [SubscribersController::class, 'show_single_subs']);
Route::get('deletesubs/{id}', [SubscribersController::class, 'destroy_subs']);












Route::middleware('auth:api')->group(function () {
    Route::get('user-detail', [PassportController::class, 'userDetail']);
    Route::post('logout', [PassportController::class, 'logout']);
});
