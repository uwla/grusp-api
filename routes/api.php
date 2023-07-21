<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

# auth routes
Route::post('/auth/login',       [AuthController::class, 'login'])->name('login');
Route::post('/auth/login_admin', [AuthController::class, 'loginAdmin']);
Route::post('/auth/register',    [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    // more auth routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // resource routes
    Route::apiResource('/permission', PermissionController::class, ['only' => 'index']);
    Route::apiResource('/grupo', GrupoController::class);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/role', RoleController::class);
    Route::apiResource('/tag', TagController::class);

    // other routes

    // user account
    Route::group(['prefix' => 'account'], function() {
        Route::get('/grupos', [AccountController::class, 'grupos']);
        Route::get('/profile', [AccountController::class, 'getProfile']);
        Route::post('/profile', [AccountController::class, 'updateProfile']);
        Route::get('/verify/{id}/{hash}', [AccountController::class, 'verifyEmail'])
            ->middleware('signed')
            ->name('verification.verify');
    });
});

// public routes
Route::group(['prefix' => 'public'], function() {
    Route::get('/tags', [PublicController::class, 'tags']);
    Route::get('/grupos', [PublicController::class, 'grupos']);
    Route::get('/grupos/{grupo}', [PublicController::class, 'grupo']);
    Route::get('/categorias', [PublicController::class, 'categories']);
});
