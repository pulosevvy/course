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

// Post
Route::resource('/posts', PostController::class);
Route::get('/posts/{post}', [PostController::class, 'detail'])->name('detail');

// Category
Route::resource('/categories', CategoryController::class);

// Comment

Route::controller(CommentController::class)->group(function() {
    Route::post('/posts/{id}/comment', 'store')->name('comment.store');
    Route::get('/posts/{id}/comment/{comm}/edit', 'edit')->name('comment.edit');
    Route::put('/posts/{id}/comment/{comm}/update', 'update')->name('comment.update');
    Route::delete('/posts/{id}/comment/{comm}/delete', 'delete')->name('comment.delete');
});

// Admin

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('/admin')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.permissions');
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/users', UserController::class);
});

require __DIR__.'/auth.php';
