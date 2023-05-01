<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BedroomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookerController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('auth/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('users', UserController::class)->except(['show']);

    Route::apiResource('bedrooms', BedroomController::class)->except(['index', 'show']);

    Route::apiResource('bookers', BookerController::class)->except(['index', 'store', 'show', 'destroy']);

    Route::apiResource('bookings', BookingController::class)->except(['index', 'destroy']);
});

Route::post('bookers/create', [BookerController::class, 'store'])->name('bookers.store');