<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
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

Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    // more auth routes
    Route::post('/logout', [AuthController::class, 'logout']);

    // resource routes
    Route::apiResource('/grupo', GrupoController::class);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/tag', TagController::class);

    // user account
    Route::group(['prefix' => 'account'], function() {
        Route::get('/grupos', [AccountController::class, 'grupos']);
        Route::get('/profile', [AccountController::class, 'getPofile']);
        Route::post('/profile', [AccountController::class, 'updatePofile']);
    });
});

// we will redefine some routes here
// because these routes should be public
$options = ['only' => ['index', 'show']];
Route::apiResource('/grupo', GrupoController::class, $options);
Route::apiResource('/tag', TagController::class, $options);
