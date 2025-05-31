<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;

use Illuminate\Http\Response;

use App\Http\Traits\APITrait;

use App\Http\Controllers\Controller;

use App\Http\Resources\EventResource;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class EventAPIController extends Controller implements HasMiddleware
{
    use APITrait;

    /**
     * The relationships to load for the Event resource.
     * @var array
     */
    private array $relationships = ['user', 'attendees', 'attendees.user'];

    /**
     * Define the middleware for this controller.
     * @return array<Middleware>
     */
    public static function middleware(): array
    {
        return [(new Middleware('auth:sanctum'))->except(['index', 'show'])];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->loadRelationships(Event::query());

        $resource = $query->get();

        return EventResource::collection($resource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $event = Event::create([
            'user_id' => $request->user()->id,
            ...$request->validated()
        ]);

        $resource = $this->loadRelationships($event, ['user']);

        return new EventResource($resource);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $resource = $this->loadRelationships($event);

        return new EventResource($resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        $resource = $this->loadRelationships($event, ['user']);

        return new EventResource($resource);
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
