<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Models\OpcionInteres;
use App\Http\Controllers\Api\EventsGatewayController;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/opciones/{categoriaId}', function ($categoriaId) {
    return OpcionInteres::where('categoria_interes_id', $categoriaId)->get();
});

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('events', [EventsGatewayController::class, 'index']);
