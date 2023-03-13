<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ParkingLotController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\VehicleController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {

    Route::post('/login', [AuthController::class, 'authentication']);
    Route::post('/register', [UserController::class, 'createUser']);

    Route::group(['middleware' => ["auth:sanctum"]], function() {
        Route::post('/vehicle_type/create', [VehicleController::class, 'createVehicleType']);
        Route::post('/entrance/new', [ParkingLotController::class, 'createNewEntrance']);
        Route::get('/logout', [AuthController::class, 'logout']);
    });
});