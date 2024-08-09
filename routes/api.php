<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BedroomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookerController;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

Route::get('/set-sse-message', function (Request $request) {
    $message = $request->input('message');

    Cache::set('message', $message);

    return response()->json(['message' => 'OK']);
});

Route::get('/listen-sse-message', function () {

    $message = Cache::get('message');

    Cache::clear();

    // Set the appropriate headers for SSE
    $response = new StreamedResponse(function () use ($message) {
        
            // Your server-side logic to get data
            $data = json_encode(['message' => $message]);

            echo "data: $data\n\n";

            // Flush the output buffer
            ob_flush();
            flush();

            // Delay for 1 second
            sleep(1);
        
    });

    $response->headers->set('Content-Type', 'text/event-stream');
    $response->headers->set('Cache-Control', 'no-cache');
    $response->headers->set('Connection', 'keep-alive');

    return $response;
});

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('users', UserController::class);

    Route::apiResource('bedrooms', BedroomController::class)->except('show');

    Route::post('users/avatar', [UserController::class, 'uploadAvatar'])->name('users.avatar');

    Route::apiResource('bookers', BookerController::class)->except(['store', 'destroy']);

    Route::apiResource('bookings', BookingController::class)->except(['destroy']);
});

Route::get('bedrooms/{bedroom}', [BedroomController::class, 'show'])->name('bedrooms.show');

Route::post('bookers/create', [BookerController::class, 'store'])->name('bookers.store');
