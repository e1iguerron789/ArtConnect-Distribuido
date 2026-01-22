<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventoController;

Route::get('/ping', function () {
    return response()->json(['ok' => true, 'service' => 'event-service']);
});

Route::get('/health', function () {
    return response()->json(['status' => 'up']);
});

Route::prefix('events')->group(function () {
    Route::get('/', [EventoController::class, 'index']);
    Route::post('/', [EventoController::class, 'store']);
    Route::get('/{id}', [EventoController::class, 'show']);

    Route::put('/{id}', [EventoController::class, 'update']);
    Route::patch('/{id}', [EventoController::class, 'update']);

    Route::delete('/{id}', [EventoController::class, 'destroy']);
});

