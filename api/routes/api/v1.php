<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

});