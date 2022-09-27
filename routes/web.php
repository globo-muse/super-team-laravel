<?php

use App\Http\Controllers\Admin\{
    DepartmentController,
    PageSEOController,
    UserController,
    HomeController As AdminHomeController
};
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
xvfdfvdfg
Route::prefix('admin')
->middleware('auth')
->group(function() {
    Route::get('/', [AdminHomeController::class, 'index'])->name('admin.index');
    Route::resource('/users', UserController::class);
    Route::post('/users/create-list', [UserController::class, 'storeUserBatch'])->name('users.create.batch');
    Route::resource('/pages-seo', PageSEOController::class);
    Route::resource('/departments', DepartmentController::class)->except('show');
});
