<?php

namespace Partymeister\Core\Http\Controllers\Api\V2;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Motor\Core\Http\Controllers\Api\V2\ApiController;
use Partymeister\Core\Http\Requests\Api\V2\EventGetRequest;
use Partymeister\Core\Http\Requests\Api\V2\EventPatchRequest;
use Partymeister\Core\Http\Requests\Api\V2\EventPostRequest;
use Partymeister\Core\Http\Resources\V2\EventCollection;
use Partymeister\Core\Http\Resources\V2\EventResource;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Services\EventService;

/**
 * @tags Events
 */
class EventsController extends ApiController
{
    protected string $model = Event::class;

    protected string $modelResource = 'event';

    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<EventResource>>
     */
    public function index(EventGetRequest $request): EventCollection
    {
        $paginator = EventService::collection()->getPaginator();

        return (new EventCollection($paginator))
            ->additional(['meta' => ['message' => 'Events retrieved']]);
    }

    public function store(EventPostRequest $request): JsonResponse
    {
        $result = EventService::create($request)->getResult();

        return (new EventResource($result))
            ->additional(['meta' => ['message' => 'Event created']])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Event $event): EventResource
    {
        $result = EventService::show($event)->getResult();

        return (new EventResource($result))
            ->additional(['meta' => ['message' => 'Event retrieved']]);
    }

    public function update(EventPatchRequest $request, Event $event): EventResource
    {
        $result = EventService::update($event, $request)->getResult();

        return (new EventResource($result))
            ->additional(['meta' => ['message' => 'Event updated']]);
    }

    public function destroy(Event $event): Response
    {
        $result = EventService::delete($event)->getResult();

        if ($result) {
            return $this->noContentResponse();
        }

        abort(404, 'Problem deleting event');
    }
}
