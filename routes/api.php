<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobListingController;
use App\Http\Controllers\Api\ApplicationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/jobs', [JobListingController::class, 'index']);
Route::get('/jobs/{job}', [JobListingController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store']);
    Route::get('/my-applications', [ApplicationController::class, 'myApplications']);
});
