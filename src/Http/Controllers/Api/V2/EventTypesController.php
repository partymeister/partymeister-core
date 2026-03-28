<?php

namespace Partymeister\Core\Http\Controllers\Api\V2;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Motor\Core\Http\Controllers\Api\V2\ApiController;
use Partymeister\Core\Http\Requests\Api\V2\EventTypeGetRequest;
use Partymeister\Core\Http\Requests\Api\V2\EventTypePatchRequest;
use Partymeister\Core\Http\Requests\Api\V2\EventTypePostRequest;
use Partymeister\Core\Http\Resources\V2\EventTypeCollection;
use Partymeister\Core\Http\Resources\V2\EventTypeResource;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Services\EventTypeService;

/**
 * @tags Core: Event Types
 */
class EventTypesController extends ApiController
{
    protected string $model = EventType::class;

    protected string $modelResource = 'event_type';

    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<EventTypeResource>>
     */
    public function index(EventTypeGetRequest $request): EventTypeCollection
    {
        $paginator = EventTypeService::collection()->getPaginator();

        return (new EventTypeCollection($paginator))
            ->additional(['meta' => ['message' => 'Event types retrieved']]);
    }

    public function store(EventTypePostRequest $request): JsonResponse
    {
        $result = EventTypeService::create($request)->getResult();

        return (new EventTypeResource($result))
            ->additional(['meta' => ['message' => 'Event type created']])
            ->response()
            ->setStatusCode(201);
    }

    public function show(EventType $event_type): EventTypeResource
    {
        $result = EventTypeService::show($event_type)->getResult();

        return (new EventTypeResource($result))
            ->additional(['meta' => ['message' => 'Event type retrieved']]);
    }

    public function update(EventTypePatchRequest $request, EventType $event_type): EventTypeResource
    {
        $result = EventTypeService::update($event_type, $request)->getResult();

        return (new EventTypeResource($result))
            ->additional(['meta' => ['message' => 'Event type updated']]);
    }

    public function destroy(EventType $event_type): Response
    {
        $result = EventTypeService::delete($event_type)->getResult();

        if ($result) {
            return $this->noContentResponse();
        }

        abort(404, 'Problem deleting event type');
    }
}
