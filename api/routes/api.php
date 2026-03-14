<?php

use App\Http\Controllers\Api\AmenityController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\FacilityController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\HouseRuleController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PropertyTypeController;
use App\Http\Controllers\Api\RoomTypeController;
use App\Http\Controllers\Api\RoomTypePriceRuleController;
use Illuminate\Support\Facades\Route;



// Auth
Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

Route::middleware(['auth:api', 'role:1,2'])->group(function () {

    // Locations (Địa điểm)
    Route::prefix('locations')->group(function () {
        Route::post('/', [LocationController::class, 'store']);
        Route::put('/{id}', [LocationController::class, 'update']);
        Route::delete('/{id}', [LocationController::class, 'destroy']);
    });

    // Amenities (Tiện ích)
    Route::prefix('amenities')->group(function () {
        Route::post('/', [AmenityController::class, 'store']);
        Route::put('/{id}', [AmenityController::class, 'update']);
        Route::delete('/{id}', [AmenityController::class, 'destroy']);
    });

    // Facilities (Cơ sở vật chất)
    Route::prefix('facilities')->group(function () {
        Route::post('/', [FacilityController::class, 'store']);
        Route::put('/{id}', [FacilityController::class, 'update']);
        Route::delete('/{id}', [FacilityController::class, 'destroy']);
    });

    // Property Types (Loại chỗ ở)
    Route::prefix('property-types')->group(function () {
        Route::post('/', [PropertyTypeController::class, 'store']);
        Route::put('/{id}', [PropertyTypeController::class, 'update']);
        Route::delete('/{id}', [PropertyTypeController::class, 'destroy']);
    });

    // House Rules (Quy tắc nhà)
    Route::prefix('house-rules')->group(function () {
        Route::post('/', [HouseRuleController::class, 'store']);
        Route::put('/{id}', [HouseRuleController::class, 'update']);
        Route::delete('/{id}', [HouseRuleController::class, 'destroy']);
    });
});

Route::middleware(['auth:api', 'role:1,2,3,4'])->group(function () {
    // Hotels (Khách sạn)
    Route::prefix('hotels')->group(function () {
        Route::post('/', [HotelController::class, 'store']);
        Route::put('/{id}', [HotelController::class, 'update']);
        Route::delete('/{id}', [HotelController::class, 'destroy']);

        Route::get('/{id}/publish', [HotelController::class, 'publish']);
    });

    // Room Types (thể loại phòng)
    Route::prefix('room-types')->group(function () {
        Route::post('/', [RoomTypeController::class, 'store']);
    });

    // Room Type Price Rules (thể loại phòng)
    Route::prefix('room-type-price-rules')->group(function () {
        Route::post('/', [RoomTypePriceRuleController::class, 'store']);
        Route::put('/{id}', [RoomTypePriceRuleController::class, 'update']);
    });
});




// Locations (Địa điểm)
Route::prefix('locations')->group(function () {
    Route::get('/', [LocationController::class, 'index']);
    Route::get('/{id}', [LocationController::class, 'show']);
});

// Hotels (Khách sạn)
Route::prefix('hotels')->group(function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::get('/{id}', [HotelController::class, 'show']);
});

// Room Types (thể loại phòng)
Route::prefix('room-types')->group(function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::get('/{id}', [HotelController::class, 'show']);
});


// Amenities (Tiện ích)
Route::prefix('amenities')->group(function () {
    Route::get('/', [AmenityController::class, 'index']);
    Route::get('/{id}', [AmenityController::class, 'show']);
});

// Facilities (Cơ sở vật chất)
Route::prefix('facilities')->group(function () {
    Route::get('/', [FacilityController::class, 'index']);
    Route::get('/{id}', [FacilityController::class, 'show']);
});

// Property Types (Loại chỗ ở)
Route::prefix('property-types')->group(function () {
    Route::get('/', [PropertyTypeController::class, 'index']);
    Route::get('/{id}', [PropertyTypeController::class, 'show']);
});

// House Rules (Quy tắc nhà)
Route::prefix('house-rules')->group(function () {
    Route::get('/', [HouseRuleController::class, 'index']);
    Route::get('/{id}', [HouseRuleController::class, 'show']);
});
