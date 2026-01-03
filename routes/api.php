<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PasswordResetController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:auth_api');

    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
        ->name('password.email');

    Route::post('/reset-password', [PasswordResetController::class, 'reset'])
        ->name('password.reset');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('events', EventController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
