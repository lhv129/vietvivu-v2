<?php

use App\Http\Controllers\Api\AmenityController;
use App\Http\Controllers\Api\FacilityController;
use App\Http\Controllers\Api\HouseRuleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PropertyTypeController;

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

// Facilities (Cơ sở vật chất)
Route::prefix('facilities')->group(function () {
    Route::get('/', [FacilityController::class, 'index']);
    Route::post('/', [FacilityController::class, 'store']);
    Route::get('/{id}', [FacilityController::class, 'show']);
    Route::put('/{id}', [FacilityController::class, 'update']);
    Route::delete('/{id}', [FacilityController::class, 'destroy']);
});

// Property Types (Loại chỗ ở)
Route::prefix('property-types')->group(function () {
    Route::get('/', [PropertyTypeController::class, 'index']);
    Route::post('/', [PropertyTypeController::class, 'store']);
    Route::get('/{id}', [PropertyTypeController::class, 'show']);
    Route::put('/{id}', [PropertyTypeController::class, 'update']);
    Route::delete('/{id}', [PropertyTypeController::class, 'destroy']);
});

// House Rules (Quy tắc nhà)
Route::prefix('house-rules')->group(function () {
    Route::get('/', [HouseRuleController::class, 'index']);
    Route::post('/', [HouseRuleController::class, 'store']);
    Route::get('/{id}', [HouseRuleController::class, 'show']);
    Route::put('/{id}', [HouseRuleController::class, 'update']);
    Route::delete('/{id}', [HouseRuleController::class, 'destroy']);
});
