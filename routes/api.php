<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('events', EventController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
