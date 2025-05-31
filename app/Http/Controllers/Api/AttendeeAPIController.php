<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Attendee;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Traits\APITrait;

use App\Http\Controllers\Controller;

use App\Http\Resources\AttendeeResource;

class AttendeeAPIController extends Controller
{
    use APITrait;

    /**
     * The relationships to load for the Attendee resource.
     * @var array
     */
    private array $relationships = ['user'];

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $query = $this->loadRelationships($event->attendees());

        $resource = $query->get();

        return AttendeeResource::collection($resource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $attendee = $event->attendees()->create([
            'user_id' => 1,
        ]);

        $resource = $this->loadRelationships($attendee);

        return new AttendeeResource($resource);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        $resource = $this->loadRelationships($attendee);

        return new AttendeeResource($resource);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $event, Attendee $attendee): Response
    {
        $attendee->delete();

        return response(status: 204);
    }
}
