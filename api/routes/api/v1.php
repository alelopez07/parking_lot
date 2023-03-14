<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ParkingLotController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\VehicleController;
use App\Models\VehicleType;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

Route::prefix('v1')->group(function() {

    Route::post('/login', [AuthController::class, 'authentication']);
    Route::post('/register', [UserController::class, 'createUser']);

    Route::group(['middleware' => ["auth:sanctum"]], function() {
        Route::post('/entrance/new', [ParkingLotController::class, 'createNewEntrance']);
        Route::post('/entrance/complete', [ParkingLotController::class, 'completeEntrance']);
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::post('/vehicle_type/{id}', [VehicleController::class, 'newVehicle']);
        Route::post('/vehicle_type/{id}', [VehicleController::class, 'newVehicle']);
        Route::post('/vehicle_type/createhow t', [VehicleController::class, 'createVehicleType']);
        Route::get('/initMonth', [VehicleController::class, 'initMonth']);
        Route::get('/vehicle_types', function() {
            return new JsonResponse(VehicleType::all(), Response::HTTP_OK);
        });
    });
});