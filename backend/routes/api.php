<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware(['role:user'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::put('/update/{id}', [AuthController::class, 'update']);
        Route::delete('/delete/{id}', [AuthController::class, 'delete']);
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/index', [AuthController::class, 'index']);
    });
});

