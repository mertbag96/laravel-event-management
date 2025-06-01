<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserAPIController;
use App\Http\Controllers\Api\EventAPIController;
use App\Http\Controllers\Api\AttendeeAPIController;
use App\Http\Controllers\Api\AuthenticationController;

// Authentication Routes
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout'])
    ->middleware('auth:sanctum');

// User Routes
Route::apiResource('users', UserAPIController::class)
    ->middleware('auth:sanctum');

// Event Routes
Route::apiResource('events', EventAPIController::class)
    ->middleware('auth:sanctum');

// Attendee Routes
Route::apiResource('events.attendees', AttendeeAPIController::class)
    ->scoped()
    ->except(['update'])
    ->middleware('auth:sanctum');