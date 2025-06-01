<?php

use Illuminate\Support\Facades\Schedule;

use App\Console\Commands\SendEventReminders;

Schedule::command(SendEventReminders::class)->daily();