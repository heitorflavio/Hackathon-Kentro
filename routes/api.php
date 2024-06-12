<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/driver', [App\Http\Controllers\DriverController::class, 'show']);
Route::post('/register/driver', [App\Http\Controllers\DriverController::class, 'store']);

Route::post('/auth/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        // faz autenticação com o sanctum
        $token = Auth::user()->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token]);
    }
    return response()->json(['message' => 'Login failed']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route::apiResource('vehicle', App\Http\Controllers\VehicleController::class);
    Route::post('/vehicle', [App\Http\Controllers\VehicleController::class, 'store']);
    Route::get('/vehicles', [App\Http\Controllers\VehicleController::class, 'show']);
    Route::put('/vehicle', [App\Http\Controllers\VehicleController::class, 'update']);
    Route::delete('/vehicle', [App\Http\Controllers\VehicleController::class, 'destroy']);

    Route::post('/status/driver', [App\Http\Controllers\DriverController::class, 'status']);
    Route::get('/drivers', [App\Http\Controllers\DriverController::class, 'index']);
});
