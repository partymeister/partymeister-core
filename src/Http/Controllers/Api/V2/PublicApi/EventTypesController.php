<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\PublicApi;

use Motor\Core\Http\Controllers\Api\V2\ApiController;
use Partymeister\Core\Http\Resources\V2\EventTypeCollection;
use Partymeister\Core\Http\Resources\V2\EventTypeResource;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Services\EventTypeService;

/**
 * @tags Public
 */
class EventTypesController extends ApiController
{
    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<EventTypeResource>>
     */
    public function index(): EventTypeCollection
    {
        $paginator = EventTypeService::collection()->getPaginator();

        return (new EventTypeCollection($paginator))
            ->additional(['meta' => ['message' => 'Event types retrieved']]);
    }

    public function show(EventType $event_type): EventTypeResource
    {
        $result = EventTypeService::show($event_type)->getResult();

        return (new EventTypeResource($result))
            ->additional(['meta' => ['message' => 'Event type retrieved']]);
    }
}
