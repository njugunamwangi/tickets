<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {

    Route::prefix('v1')->group(function() {
        Route::apiResource('/tickets', TicketController::class);
        Route::apiResource('/users', UserController::class);
    });

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
});
