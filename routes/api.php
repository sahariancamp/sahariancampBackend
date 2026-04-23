<?php

use App\Http\Controllers\Api\TentController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/tents', [TentController::class, 'index']);
Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/gallery', [\App\Http\Controllers\Api\GalleryController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
