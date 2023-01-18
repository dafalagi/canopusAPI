<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// POST
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// AUTHENTICATED ONLY
Route::middleware('auth:sanctum')->group(function () {
    // POST
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.default');

    // RESOURCES
    Route::apiResources([
        'user' => UserController::class,
        'content' => ContentController::class,
        'favorite' => FavoriteController::class,
    ]);
});
