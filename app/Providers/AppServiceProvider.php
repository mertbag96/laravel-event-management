<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Attendee;

use Illuminate\Support\Facades\Gate;

use Illuminate\Support\ServiceProvider;

use Illuminate\Contracts\Auth\Authenticatable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Gate definition for updating an event.
         * @param Authenticatable $user
         * @param Event $event
         * @return bool
         */
        Gate::define('update-event', function ($user, Event $event): bool {
            return $user->id === $event->user_id;
        });

        /**
         * Gate definition for deleting an event.
         * @param Authenticatable $user
         * @param Event $event
         * @param Attendee $attendee
         * @return bool
         */
        Gate::define('delete-attendee', function ($user, Event $event, Attendee $attendee): bool {
            return $user->id === $event->user_id || $user->id == $attendee->user_id;
        });
    }
}
