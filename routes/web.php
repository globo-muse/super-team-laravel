<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController As AdminHomeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')
->middleware('auth')
->group(function() {
    Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');
    Route::resource('/users', UserController::class);
});
