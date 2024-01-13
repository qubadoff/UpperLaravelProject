<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\FirebaseController;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('ticket/take', [TicketController::class, 'take']);
    Route::post('tickets/deposit', [TicketController::class, 'deposit']);
    Route::post('tickets/filter', [TicketController::class, 'filter']);
    Route::get('tickets/user', [TicketController::class, 'user']);
    Route::get('user/detail', [UserController::class, 'detail']);
    Route::get('user/payments', [UserController::class, 'payments']);

    Route::post('/firebase', [FirebaseController::class, 'index']);
    Route::post('/testfirebase', [FirebaseController::class, 'sendNotification']);
});
