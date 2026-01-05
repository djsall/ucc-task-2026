<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class EventController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): JsonResource
    {
        $events = $request->user()->events()->get();

        return EventResource::collection($events);
    }

    public function store(StoreEventRequest $request): JsonResource
    {
        $event = $request->user()->events()->create($request->validated());

        return EventResource::make($event);
    }

    public function show(Event $event): JsonResource
    {
        $this->authorize('view', $event);

        return EventResource::make($event);
    }

    public function update(UpdateEventRequest $request, Event $event): JsonResource
    {
        $this->authorize('update', $event);

        $event->update($request->validated());

        return EventResource::make($event);
    }

    public function destroy(Event $event): Response
    {
        $this->authorize('delete', $event);

        $event->delete();

        return response()->noContent();
    }
}
