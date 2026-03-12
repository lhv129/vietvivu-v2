<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;

Route::prefix('locations')->group(function () { 
    Route::get('/', [LocationController::class, 'index']);
    Route::post('/', [LocationController::class, 'store']);
    Route::get('/{id}', [LocationController::class, 'show']);
    Route::put('/{id}', [LocationController::class, 'update']);
    Route::delete('/{id}', [LocationController::class, 'destroy']);
});
