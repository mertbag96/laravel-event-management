<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

use Illuminate\Http\Response;

use App\Http\Traits\APITrait;

use Illuminate\Support\Facades\Gate;

use App\Http\Resources\UserResource;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserAPIController extends Controller
{
    use APITrait;

    /**
     * The relationships to load for the User resource.
     * @var array
     */
    private array $relationships = ['events', 'attendees'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        $query = $this->loadRelationships(User::query());

        $resource = $query->get();

        return UserResource::collection($resource);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreUserRequest $request
     */
    public function store(StoreUserRequest $request)
    {
        Gate::authorize('create', User::class);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $resource = $this->loadRelationships($user, []);

        return new UserResource($resource);
    }

    /**
     * Display the specified resource.
     * @param User $user
     */
    public function show(User $user)
    {
        Gate::authorize('view', User::class);

        $resource = $this->loadRelationships($user);

        return new UserResource($resource);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateUserRequest $request
     * @param User $user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        Gate::authorize('update', $user);

        $user->update($request->validated());

        $resource = $this->loadRelationships($user, []);

        return new UserResource($resource);
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return response(status: 204);
    }
}
