<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;

use Illuminate\Http\Response;

use App\Http\Traits\APITrait;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Gate;

use App\Http\Resources\EventResource;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventAPIController extends Controller
{
    use APITrait;

    /**
     * The relationships to load for the Event resource.
     * @var array
     */
    private array $relationships = ['user', 'attendees', 'attendees.user'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Event::class);

        $query = $this->loadRelationships(Event::query());

        $resource = $query->get();

        return EventResource::collection($resource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        Gate::authorize('create', Event::class);

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
        Gate::authorize('view', Event::class);

        $resource = $this->loadRelationships($event);

        return new EventResource($resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        Gate::authorize('update', $event);

        $event->update($request->validated());

        $resource = $this->loadRelationships($event, ['user']);

        return new EventResource($resource);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): Response
    {
        Gate::authorize('delete', $event);

        $event->delete();

        return response(status: 204);
    }
}
