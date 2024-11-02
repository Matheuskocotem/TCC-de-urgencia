<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeetingRoomController;
use App\Http\Controllers\MeetingController; 

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware(['role:user'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::put('/update/{id}', [AuthController::class, 'update']);
        Route::delete('/delete/{id}', [AuthController::class, 'delete']);
        
        Route::prefix('meeting-rooms')->group(function () {
            Route::get('/', [MeetingRoomController::class, 'index']); 
            Route::get('/{id}', [MeetingRoomController::class, 'show']); 
        });

        // Rotas para reuniões
        Route::prefix('meetings')->group(function () {
            Route::get('/', [MeetingController::class, 'index']); 
            Route::post('/', [MeetingController::class, 'store']); 
            Route::get('/{id}', [MeetingController::class, 'show']); 
            Route::put('/{id}', [MeetingController::class, 'update']); 
            Route::delete('/{id}', [MeetingController::class, 'destroy']); 
        });
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/index', [AuthController::class, 'index']);
        Route::post('/add-admin', [AuthController::class, 'addAdmin']);

        Route::prefix('meeting-rooms')->group(function () {
            Route::post('/', [MeetingRoomController::class, 'store']); 
            Route::put('/{id}', [MeetingRoomController::class, 'update']); 
            Route::delete('/{id}', [MeetingRoomController::class, 'destroy']); 
        });
    });
});
