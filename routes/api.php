<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
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

// attributes for the routes
$attributes = [
    'auth' => [
        'prefix' => 'auth',
        'controller' => AuthController::class
    ],
    'account' => [
        'prefix' => 'account',
        'controller' => AccountController::class
    ],
    'public' => [
        'prefix' => 'public',
        'controller' => PublicController::class
    ],
];

// ─────────────────────────────────────────────────────────────────────────────
// auth routes

Route::group($attributes['auth'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');
        Route::post('login/admin', 'loginAdmin');
    });

    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::get('/verified', function() {
    return ['verified' => 'ok!'];
})->middleware(['auth:sanctum', 'verified']);

// ─────────────────────────────────────────────────────────────────────────────
// account routes

Route::group($attributes['account'], function () {
   // account verification
    Route::get('verify/{id}/{hash}', 'verifyEmail')
        ->middleware('signed')
        ->name('verification.verify');

    // profile
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/grupos', 'grupos');
        Route::get('/profile', 'getProfile');
        Route::post('/profile', 'updateProfile');
    });

    // password resets
    Route::group(['middleware' => 'guest', 'prefix' => 'password'], function () {
        Route::post('/link', 'sendResetLinkEmail');
        Route::post('/reset', 'resetPassword')->name('password.reset');
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// resource routes

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/permission', [PermissionController::class, 'index']);
    Route::apiResource('/grupo', GrupoController::class);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/role', RoleController::class);
    Route::apiResource('/tag', TagController::class);
    Route::apiResource('/vote', VoteController::class, ['only' => ['index', 'store', 'destroy']]);
});

// ─────────────────────────────────────────────────────────────────────────────
// public routes

Route::group($attributes['public'], function () {
    Route::get('/tags', 'tags');
    Route::get('/grupos', 'grupos');
    Route::get('/grupos/{grupo}', 'grupo');
    Route::get('/categorias', 'categories');
});
