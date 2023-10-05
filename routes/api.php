<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
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
        Route::post('login/admin', 'loginAdmin')->name('login-admin');
    });

    Route::post('logout', 'logout')->middleware('auth:sanctum')->name('logout');
});

Route::get('/verified', function() {
    return ['verified' => 'ok!'];
})->middleware(['auth:sanctum', 'verified'])->name('account.verified');

// ─────────────────────────────────────────────────────────────────────────────
// account routes

Route::group($attributes['account'], function () {
    // request link to verify account
    Route::post('verify_link', 'sendVerificationEmail')
        ->middleware('guest')
        ->name('verification.link');

   // verify account
    Route::get('verify/{id}/{hash}', 'verifyEmail')
        ->middleware('signed')
        ->name('verification.verify');

    // profile
    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
        Route::get('/bookmarks', 'bookmarks')->name('account.bookmarks');
        Route::get('/comments', 'comments')->name('account.comments');
        Route::get('/grupos', 'grupos')->name('account.grupos');
        Route::get('/votes', 'votes')->name('account.votes');
        Route::get('/profile', 'getProfile')->name('account.profile');
        Route::post('/profile', 'updateProfile')->name('account.profile-update');
    });

    // password resets
    Route::group(['middleware' => 'guest', 'prefix' => 'password'], function () {
        Route::post('/link', 'sendResetLinkEmail')->name('password.reset-email');
        Route::post('/reset', 'resetPassword')->name('password.reset');
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// resource routes

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/permission', PermissionController::class, ['only' => 'index']);
    Route::apiResource('/grupo', GrupoController::class);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/role', RoleController::class);
    Route::apiResource('/tag', TagController::class);
    Route::apiResource('/vote', VoteController::class, ['except' => ['index', 'show']]);
    Route::apiResource('/category', CategoryController::class);
    Route::apiResource('/comment', CommentController::class, ['except' => ['index', 'show']]);

    // bookmarks follow a different logic
    Route::post('/bookmark/{grupo}', [BookmarkController::class, 'store'])->name('bookmark.store');
    Route::delete('/bookmark/{grupo}', [BookmarkController::class, 'destroy'])->name('bookmark.destroy');
});

// ─────────────────────────────────────────────────────────────────────────────
// public routes

Route::group($attributes['public'], function () {
    Route::get('/tags', 'tags')->name('public.tags');
    Route::get('/grupos', 'grupos')->name('public.grupo.index');
    Route::get('/grupos/{grupo}', 'grupo')->name('public.grupo.show');
    Route::get('/categorias', 'categories')->name('public.category');
});