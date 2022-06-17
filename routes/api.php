<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\PermissionController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);
Route::get('category', [CategoryController::class, 'index']);



Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', function(Request $request) {
        return $request->user();
    });

    // Posts

    Route::controller(PostController::class)->group(function() {
        Route::post('posts', 'store');
        Route::put('posts/{post}', 'update');
        Route::delete('posts/{post}', 'destroy');
    });

    // Category

    Route::controller(CategoryController::class)->group(function() {
        Route::post('category', 'store');
        Route::put('category/{category}', 'update');
        Route::delete('category/{category}', 'destroy');
    });

    // Comment

    Route::controller(CommentController::class)->group(function() {
        Route::post('posts/{id}/comment', 'store');
        Route::put('posts/{id}/comment/{comm}', 'update');
        Route::delete('posts/{id}/comment/{comm}', 'destroy');
    });

});

// Admin

Route::middleware('auth:sanctum', 'role:admin')->prefix('/admin')->group(function() {
    Route::apiResource('permissions', PermissionController::class);
    Route::apiResource('roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissions']);
    Route::apiResource('users', UserController::class);
});



