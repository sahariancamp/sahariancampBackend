<?php

use App\Http\Controllers\Api\TentController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/tents', [TentController::class, 'index']);
Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/gallery', [\App\Http\Controllers\Api\GalleryController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::post('/contact', [ContactController::class, 'submit']);
Route::get('/reviews', function() {
    return \App\Models\Review::where('is_published', true)->orderBy('stay_date', 'desc')->get();
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
