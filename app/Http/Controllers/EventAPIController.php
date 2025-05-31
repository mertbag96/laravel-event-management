<?php

namespace App\Http\Controllers;

use App\Models\Event;

use Illuminate\Http\Response;

use App\Http\Controllers\Controller;

use App\Http\Resources\EventResource;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('user', 'attendees')->get();

        return EventResource::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $event = Event::create([
            'user_id' => 1,
            ...$request->validated()
        ]);

        $event->load('user');

        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('user', 'attendees');

        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        return new EventResource($event);
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
