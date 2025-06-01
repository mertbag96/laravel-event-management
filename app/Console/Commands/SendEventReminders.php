<?php

namespace App\Console\Commands;

use App\Models\Event;

use Illuminate\Support\Str;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

use App\Notifications\EventReminderNotification;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends reminder notifications to attendees about upcoming events.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $events = Event::query()
            ->with('attendees.user')
            ->whereBetween('start_time', [now(), now()->addDay()])
            ->get();

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);

        Log::info("Found {$eventCount} upcoming {$eventLabel}:" . PHP_EOL);
        $this->info("Found {$eventCount} upcoming {$eventLabel}:" . PHP_EOL);

        foreach ($events as $index => $event) {
            Log::info($index + 1 . ". " . $event->name);
            $this->info($index + 1 . ". " . $event->name);
            foreach ($event->attendees as $attendee) {
                Log::info("- Attendee: {$attendee->user->email}");
                $this->info("- Attendee: {$attendee->user->email}");
                try {
                    $attendee->user->notify(new EventReminderNotification($event));
                } catch (\Exception $exception) {
                    Log::error("Failed to send reminder to {$attendee->user->email}: " . $exception->getMessage());
                    $this->error("Failed to send reminder to {$attendee->user->email}: " . $exception->getMessage());
                }
            }
            Log::info(PHP_EOL);
            $this->info(PHP_EOL);
        }

        Log::info('Reminder notifications sent successfully!');
        $this->info('Reminder notifications sent successfully!');
    }
}
