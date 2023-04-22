<?php

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
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::apiResource('/grupo', GrupoController::class);
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/tag', TagController::class);
});

// we will redefine some routes here
// because these routes should be public
$options = ['only' => ['index', 'show']];
Route::apiResource('/grupo', GrupoController::class, $options);
Route::apiResource('/tag', TagController::class, $options);
