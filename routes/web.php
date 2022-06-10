<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class, 'showPost'], function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('/posts', PostController::class);
Route::get('/posts/{post}', [PostController::class, 'detail'])->name('detail');

Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('comment.store');

Route::resource('/categories', CategoryController::class);

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('/admin')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.permissions');
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/users', UserController::class);
});

require __DIR__.'/auth.php';
