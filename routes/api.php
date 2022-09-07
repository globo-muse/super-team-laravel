<?php

use App\Http\Controllers\Api\CollaboratorControllers;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\PageApiController;
use App\Http\Controllers\Api\UserAuthController;
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


Route::post('/auth', [UserAuthController::class, 'auth']);

Route::get('/collaborators', [CollaboratorControllers::class, 'index'])->name('api.collaborators.list');
Route::get('/pages', [PageApiController::class, 'index'])->name('api.pages.list');
Route::get('/pages/{slug}', [PageApiController::class, 'show'])->name('api.pages.show');

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/me', [UserAuthController::class, 'me'])->name('api.auth.me');
    Route::get('/orders', [OrderApiController::class, 'index'])->name('api.orders.list');
    Route::post('/orders', [OrderApiController::class, 'store']);
    Route::get('/orders/{id}/vimeo-slot', [OrderApiController::class, 'createSlot']);
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::get('/orders/me', 'App\Http\Controllers\Api\OrderApiController@getByRespondeId');


