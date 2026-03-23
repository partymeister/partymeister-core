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

class EventTypesController extends ApiController
{
    public function index(EventTypeGetRequest $request): EventTypeCollection
    {
        $paginator = EventTypeService::collection()->getPaginator();

        return new EventTypeCollection($paginator);
    }

    public function store(EventTypePostRequest $request): JsonResponse
    {
        $result = EventTypeService::create($request)->getResult();

        return (new EventTypeResource($result))
            ->additional(['meta' => ['message' => 'EventType created']])
            ->response()
            ->setStatusCode(201);
    }

    public function show(EventTypeGetRequest $request, EventType $event_type): EventTypeResource
    {
        $result = EventTypeService::show($event_type)->getResult();

        return new EventTypeResource($result);
    }

    public function update(EventTypePatchRequest $request, EventType $event_type): EventTypeResource
    {
        $result = EventTypeService::update($event_type, $request)->getResult();

        return new EventTypeResource($result);
    }

    public function destroy(EventType $event_type): Response
    {
        EventTypeService::delete($event_type);

        return $this->noContentResponse();
    }
}
