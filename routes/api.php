<?php

use App\Http\Controllers\API\APIAuthController;
use App\Http\Controllers\API\APITestimonyController;
use App\Http\Controllers\API\APINewsController;
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


Route::post('login', [APIAuthController::class, 'login']);

Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::resource('testimony', APITestimonyController::class);
    Route::post('/testimony/{id}', [APITestimonyController::class, 'update']);
    Route::resource('news', APINewsController::class);
});

