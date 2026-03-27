<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\PublicApi;

use Illuminate\Routing\Controller;
use Partymeister\Core\Http\Resources\V2\EventCollection;
use Partymeister\Core\Http\Resources\V2\EventResource;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Services\EventService;

/**
 * @tags Public
 */
class EventsController extends Controller
{
    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<EventResource>>
     */
    public function index(): EventCollection
    {
        $paginator = EventService::collection()->getPaginator();

        return (new EventCollection($paginator))
            ->additional(['meta' => ['message' => 'Events retrieved']]);
    }

    public function show(Event $event): EventResource
    {
        $result = EventService::show($event)->getResult();

        return (new EventResource($result))
            ->additional(['meta' => ['message' => 'Event retrieved']]);
    }
}
