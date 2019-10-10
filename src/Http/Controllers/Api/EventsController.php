<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Core\Http\Requests\Backend\EventRequest;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Services\EventService;
use Partymeister\Core\Transformers\EventTransformer;

/**
 * Class EventsController
 * @package Partymeister\Core\Http\Controllers\Api
 */
class EventsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $paginator = EventService::collection()->getPaginator();
        $resource  = $this->transformPaginator($paginator, EventTransformer::class);

        return $this->respondWithJson('Event collection read', $resource);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param EventRequest $request
     * @return JsonResponse
     */
    public function store(EventRequest $request)
    {
        $result   = EventService::create($request)->getResult();
        $resource = $this->transformItem($result, EventTransformer::class);

        return $this->respondWithJson('Event created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param Event $record
     * @return JsonResponse
     */
    public function show(Event $record)
    {
        $result   = EventService::show($record)->getResult();
        $resource = $this->transformItem($result, EventTransformer::class);

        return $this->respondWithJson('Event read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EventRequest $request
     * @param Event        $record
     * @return JsonResponse
     */
    public function update(EventRequest $request, Event $record)
    {
        $result   = EventService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, EventTransformer::class);

        return $this->respondWithJson('Event updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Event $record
     * @return JsonResponse
     */
    public function destroy(Event $record)
    {
        $result = EventService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Event deleted', [ 'success' => true ]);
        }

        return $this->respondWithJson('Event NOT deleted', [ 'success' => false ]);
    }
}
