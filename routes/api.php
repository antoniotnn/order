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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('jwt.auth')->group(function() {
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::apiResource('order', 'App\Http\Controllers\OrderController');
});

Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');

Route::get('orders/agregated', 'App\Http\Controllers\OrderController@ordersAgregated');
Route::patch('orders/update-custom', 'App\Http\Controllers\OrderController@customInputUpdateDefault');
Route::put('orders/update-custom', 'App\Http\Controllers\OrderController@customInputUpdateDefault');

Route::patch('orders/update-custom2', 'App\Http\Controllers\OrderController@customInputUpdateDefault');
Route::put('orders/update-custom2', 'App\Http\Controllers\OrderController@customInputUpdateDefault');

Route::patch('orders/update-custom3', 'App\Http\Controllers\OrderController@customInputUpdateDefault');
Route::put('orders/update-custom3', 'App\Http\Controllers\OrderController@customInputUpdateDefault');