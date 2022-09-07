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

Route::get('/orders', 'App\Http\Controllers\Api\OrderApiController@index');
Route::post('/orders', 'App\Http\Controllers\Api\OrderApiController@store');
Route::get('/orders/me', 'App\Http\Controllers\Api\OrderApiController@getByRespondeId');
Route::get('/orders/aa', 'App\Http\Controllers\Api\OrderApiController@createSlot');

Route::post('/auth', 'App\Http\Controllers\Api\UserAuth@auth');
Route::get('/me', 'App\Http\Controllers\Api\UserAuth@me')->middleware(['auth:sanctum']);

