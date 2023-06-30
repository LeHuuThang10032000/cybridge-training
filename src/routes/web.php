<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\PostController;
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


Route::post('test', function() {
    broadcast(new App\Events\LikePostEvent())->toOthers();
    return 'test';
})->name('test');

Route::group(['middleware' => ['auth']], function () {
    Route::get('', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
        Route::get('{id}', [PostController::class, 'detail'])->name('detail');
        Route::post('like', [PostController::class, 'like'])->name('like');

        Route::post('comments/store', [PostController::class, 'storeComment'])->name('comments.store');
        Route::put('comments/update', [PostController::class, 'updateComment'])->name('comments.update');
        Route::put('comments/destroy', [PostController::class, 'destroyComment'])->name('comments.destroy');

        Route::post('upload-image', [PostController::class, 'storeCKImage'])->name('media.upload');
    });

    Route::group(['prefix' => 'mypage', 'as' => 'mypage.'], function () {
        Route::get('liked', [MyPageController::class, 'like'])->name('liked');
        Route::get('profile', [MyPageController::class, 'profile'])->name('profile');

        Route::post('posts/upload-image', [PostController::class, 'storeCKImage'])->name('posts.media.upload');
        Route::resource('posts', PostController::class);
    });

    Route::resource('comments', CommentController::class);
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::match(['get', 'post'], 'login', [AdminAuthController::class, 'login'])->name('login');
    Route::get('register', [AdminAuthController::class, 'create'])->name('register');
    Route::post('register', [AdminAuthController::class, 'store']);

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('posts/export', [AdminPostController::class, 'export'])->name('posts.export');
        Route::post('posts/upload-image', [AdminPostController::class, 'storeCKImage'])->name('posts.media.upload');
        Route::resource('posts', AdminPostController::class);

        Route::get('users/export', [UserController::class, 'export'])->name('users.export');
        Route::post('users/import', [UserController::class, 'import'])->name('users.import');
        Route::resource('users', UserController::class);
        
        Route::resource('rules', RuleController::class);
        Route::resource('medias', MediaController::class);

        Route::post('comments/upload-image', [AdminCommentController::class, 'storeCKImage'])->name('comments.media.upload');
        Route::resource('comments', AdminCommentController::class);

        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});
