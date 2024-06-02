<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\AuthController;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {

    Route::apiResource('/tickets', TicketController::class);

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
});
