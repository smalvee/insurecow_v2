<?php

use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\CattleRegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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


// ------------------------ API login and registration portion added ------------------------

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

});


Route::controller(ApiAuthController::class)->group(function(){
    Route::post('apilogin', 'apilogin');
    Route::post('apiregister', 'apiregister');
});

Route::controller(CattleRegisterController::class)->group(function(){
    Route::post('apistore', 'apistore');
});

// ------------------------ API login and registration portion added ------------------------
