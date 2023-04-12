<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BedroomController;
use App\Http\Controllers\PeopleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::get('get', [BedroomController::class, 'index'])->name('get')->middleware(["auth:sanctum"]);

Route::post('post', [PeopleController::class, 'store'])->middleware(["auth:sanctum"]);
