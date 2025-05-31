<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventAPIController;
use App\Http\Controllers\AttendeeAPIController;

Route::apiResource('events', EventAPIController::class);

Route::apiResource('events.attendees', AttendeeAPIController::class)->scoped()->except(['update']);