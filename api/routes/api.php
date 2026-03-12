<?php

use App\Http\Controllers\Api\AmenityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;



// Locations
Route::prefix('locations')->group(function () { 
    Route::get('/', [LocationController::class, 'index']);
    Route::post('/', [LocationController::class, 'store']);
    Route::get('/{id}', [LocationController::class, 'show']);
    Route::put('/{id}', [LocationController::class, 'update']);
    Route::delete('/{id}', [LocationController::class, 'destroy']);
});

// Amenities (Tiện ích)
Route::prefix('amenities')->group(function () { 
    Route::get('/', [AmenityController::class, 'index']);
    Route::post('/', [AmenityController::class, 'store']);
    Route::get('/{id}', [AmenityController::class, 'show']);
    Route::put('/{id}', [AmenityController::class, 'update']);
    Route::delete('/{id}', [AmenityController::class, 'destroy']);
});

