<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;

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

// Route::get('user', [AuthController::class, 'user']);

// Route::apiResource('auth', PostController::class);
// Route::get('user', AuthController::class, 'user');
// Route::get('register', AuthController::class, 'register');

Route::apiResource('posts', PostController::class);
