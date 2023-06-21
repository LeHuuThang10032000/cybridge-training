<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'create'])->name('register');
Route::post('register', [AuthController::class, 'store']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::match(['get', 'post'], 'login', [AdminAuthController::class, 'login'])->name('login');
    Route::get('register', [AdminAuthController::class, 'create'])->name('register');
    Route::post('register', [AdminAuthController::class, 'store']);

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::resource('posts', PostController::class);
        Route::post('posts/upload-image', [PostController::class, 'storeCKImage'])->name('posts.media.upload');

        Route::resource('users', UserController::class);

        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::post('media/upload', [MediaController::class, 'upload'])->name('media.upload');
    });
});