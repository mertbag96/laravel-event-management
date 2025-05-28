<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventAPIController;
use App\Http\Controllers\AttendeeAPIController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('events', EventAPIController::class);

Route::apiResource('events.attendees', AttendeeAPIController::class)
    ->scoped(['attendee' => 'event']);