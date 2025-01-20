<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    // User CRUD Routes
    Route::resource('users', UserController::class);

    // Search Routes
    Route::get('/search/nama/{nama}', [SearchController::class, 'searchByName']);
    Route::get('/search/nim/{nim}', [SearchController::class, 'searchByNIM']);
    Route::get('/search/ymd/{ymd}', [SearchController::class, 'searchByDate']);
});