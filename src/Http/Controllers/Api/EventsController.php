<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;

use Partymeister\Core\Models\Event;
use Partymeister\Core\Http\Requests\Backend\EventRequest;
use Partymeister\Core\Services\EventService;
use Partymeister\Core\Http\Resources\EventResource;
use Partymeister\Core\Http\Resources\EventCollection;

/**
 * Class EventsController
 *
 * @package Partymeister\Core\Http\Controllers\Api
 */
class EventsController extends ApiController
{
    protected string $model = 'Partymeister\Core\Models\Event';

    protected string $modelResource = 'event';

    /**
     * @OA\Get (
     *   tags={"EventsController"},
     *   path="/api/events",
     *   summary="Get event collection",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/EventResource")
     *       ),
     *       @OA\Property(
     *         property="meta",
     *         ref="#/components/schemas/PaginationMeta"
     *       ),
     *       @OA\Property(
     *         property="links",
     *         ref="#/components/schemas/PaginationLinks"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Collection read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   )
     * )
     *
     * Display a listing of the resource.
     *
     * @return EventCollection
     */
    public function index()
    {
        $paginator = EventService::collection()
                                 ->getPaginator();

        return (new EventCollection($paginator))->additional(['message' => 'Event collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"EventsController"},
     *   path="/api/events",
     *   summary="Create new event",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/EventRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EventResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Event created"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param EventRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EventRequest $request)
    {
        $result = EventService::create($request)
                              ->getResult();

        return (new EventResource($result))->additional(['message' => 'Event created'])
                                           ->response()
                                           ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"EventsController"},
     *   path="/api/events/{event}",
     *   summary="Get single event",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="event",
     *     parameter="event",
     *     description="Event id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EventResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Event read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Display the specified resource.
     *
     * @param Event $record
     * @return EventResource
     */
    public function show(Event $record)
    {
        $result = EventService::show($record)
                              ->getResult();

        return (new EventResource($result))->additional(['message' => 'Event read']);
    }

    /**
     * @OA\Put (
     *   tags={"EventsController"},
     *   path="/api/events/{event}",
     *   summary="Update an existing event",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/EventRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="event",
     *     parameter="event",
     *     description="Event id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EventResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Event updated"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Update the specified resource in storage.
     *
     * @param EventRequest $request
     * @param Event $record
     * @return EventResource
     */
    public function update(EventRequest $request, Event $record)
    {
        $result = EventService::update($record, $request)
                              ->getResult();

        return (new EventResource($result))->additional(['message' => 'Event updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"EventsController"},
     *   path="/api/events/{event}",
     *   summary="Delete a event",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="event",
     *     parameter="event",
     *     description="Event id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Event deleted"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   ),
     *   @OA\Response(
     *     response="400",
     *     description="Bad request",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Problem deleting event"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param Event $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Event $record)
    {
        $result = EventService::delete($record)
                              ->getResult();

        if ($result) {
            return response()->json(['message' => 'Event deleted']);
        }

        return response()->json(['message' => 'Problem deleting Event'], 404);
    }
}
