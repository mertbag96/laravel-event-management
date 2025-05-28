<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Attendee;

use Illuminate\Database\Seeder;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $events = Event::all();

        foreach ($users as $user) {
            $randomEvents = $events->random(rand(1, 5));

            foreach ($randomEvents as $event) {
                Attendee::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id
                ]);
            }
        }
    }
}
