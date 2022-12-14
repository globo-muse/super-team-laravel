<?php

use App\Http\Controllers\Api\CollaboratorControllers;
use App\Http\Controllers\Api\DepartmentApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\PageApiController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\VideosApiController;
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

Route::get('/', function(){ return response(['works'], 200); })->name('api.home');

Route::post('/auth', [UserAuthController::class, 'auth'])->name('user.auth');

Route::get('/collaborators', [CollaboratorControllers::class, 'index'])->middleware('guest')->name('api.collaborators.list');
Route::get('/collaborators/{id}', [CollaboratorControllers::class, 'show'])->name('api.collaborators.show');
Route::get('/pages', [PageApiController::class, 'index'])->name('api.pages.list');
Route::get('/pages/{slug}', [PageApiController::class, 'show'])->name('api.pages.show');
Route::get('/departments-users', [DepartmentApiController::class, 'getAllWithUsers'])->name('api.departments.users.index');
Route::get('/departments', [DepartmentApiController::class, 'index'])->name('api.departments.index');
Route::get('/departments/{id}/users', [DepartmentApiController::class, 'getUsers'])->name('api.departments.users');
Route::get('/videos/logo-waiting', [VideosApiController::class, 'getAllVideosLogoable'])->name('api.videos.logoable.list');
Route::post('/videos/{id}/status', [VideosApiController::class, 'setVideoStatus'])->name('api.videos.logoable.set.status');
Route::post('/forgot-password', [UserAuthController::class, 'resetPassword'])->middleware('guest')->name('password.email');

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/me', [UserAuthController::class, 'me'])->name('api.auth.me');
    Route::post('/me', [UserAuthController::class, 'updateMe'])->name('api.update.me');
    Route::get('/orders/to-answer', [OrderApiController::class, 'index'])->name('api.orders.order.to.answer');
    Route::get('/orders', [OrderApiController::class, 'getByUserId'])->name('api.orders.my.orders');
    Route::post('/orders', [OrderApiController::class, 'store'])->name('api.orders.store');
    Route::get('/orders/{id}', [OrderApiController::class, 'show'])->name('api.orders.show');
    Route::post('/orders/{id}/vimeo-slot', [OrderApiController::class, 'createSlot']);
    Route::post('/orders/{id}/file-sended', [OrderApiController::class, 'videoFileSended']);
    Route::put('/orders/{id}/deny', [OrderApiController::class, 'denyOrder']);
});
