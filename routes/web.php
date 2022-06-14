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

Route::post('/posts/{id}/comment', [CommentController::class, 'store'])->name('comment.store');

Route::delete('/posts/{id}/comment/{comm}/delete', [CommentController::class, 'delete'])->name('comment.delete');

Route::get('/posts/{id}/comment/{comm}/edit', [CommentController::class, 'edit'])->name('comment.edit');

Route::put('/posts/{id}/comment/{comm}/update', [CommentController::class, 'update'])->name('comment.update');


Route::resource('/categories', CategoryController::class);

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('/admin')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.permissions');
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/users', UserController::class);
});

require __DIR__.'/auth.php';
