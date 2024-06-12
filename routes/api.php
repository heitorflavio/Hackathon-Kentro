<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/driver', [App\Http\Controllers\DriverController::class, 'show']);
Route::post('/create/driver', [App\Http\Controllers\DriverController::class, 'store']);

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

    Route::apiResource('vehicle', App\Http\Controllers\VehicleController::class);
});
