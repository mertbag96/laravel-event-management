<?php

namespace App\Http\Controllers;

use App\Models\Event;

use Illuminate\Http\Response;

use Illuminate\Support\Collection;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Collection<Event>
     */
    public function index(): Collection
    {
        return Event::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request): Event
    {
        $event = Event::create([
            'user_id' => 1,
            ...$request->validated()
        ]);

        return $event;
    }

    /**
     * Display the specified resource.
     * @param Event $event
     * @return Event
     */
    public function show(Event $event): Event
    {
        return $event;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event): Event
    {
        $event->update($request->validated());

        return $event;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): Response
    {
        $event->delete();

        return response(status: 204);
    }
}
