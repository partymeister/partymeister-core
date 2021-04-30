<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;

use Partymeister\Core\Models\EventType;
use Partymeister\Core\Http\Requests\Backend\EventTypeRequest;
use Partymeister\Core\Services\EventTypeService;
use Partymeister\Core\Http\Resources\EventTypeResource;
use Partymeister\Core\Http\Resources\EventTypeCollection;

/**
 * Class EventTypesController
 *
 * @package Partymeister\Core\Http\Controllers\Api
 */
class EventTypesController extends ApiController
{
    protected string $model = 'Partymeister\Core\Models\EventType';

    protected string $modelResource = 'event_type';

    /**
     * @OA\Get (
     *   tags={"EventTypesController"},
     *   path="/api/event_types",
     *   summary="Get event_type collection",
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
     *         @OA\Items(ref="#/components/schemas/EventTypeResource")
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
     * @return EventTypeCollection
     */
    public function index()
    {
        $paginator = EventTypeService::collection()
                                     ->getPaginator();

        return (new EventTypeCollection($paginator))->additional(['message' => 'EventType collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"EventTypesController"},
     *   path="/api/event_types",
     *   summary="Create new event_type",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/EventTypeRequest")
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
     *         ref="#/components/schemas/EventTypeResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="EventType created"
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
     * @param EventTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EventTypeRequest $request)
    {
        $result = EventTypeService::create($request)
                                  ->getResult();

        return (new EventTypeResource($result))->additional(['message' => 'EventType created'])
                                               ->response()
                                               ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"EventTypesController"},
     *   path="/api/event_types/{event_type}",
     *   summary="Get single event_type",
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
     *     name="event_type",
     *     parameter="event_type",
     *     description="EventType id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EventTypeResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="EventType read"
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
     * @param EventType $record
     * @return EventTypeResource
     */
    public function show(EventType $record)
    {
        $result = EventTypeService::show($record)
                                  ->getResult();

        return (new EventTypeResource($result))->additional(['message' => 'EventType read']);
    }

    /**
     * @OA\Put (
     *   tags={"EventTypesController"},
     *   path="/api/event_types/{event_type}",
     *   summary="Update an existing event_type",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/EventTypeRequest")
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
     *     name="event_type",
     *     parameter="event_type",
     *     description="EventType id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EventTypeResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="EventType updated"
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
     * @param EventTypeRequest $request
     * @param EventType $record
     * @return EventTypeResource
     */
    public function update(EventTypeRequest $request, EventType $record)
    {
        $result = EventTypeService::update($record, $request)
                                  ->getResult();

        return (new EventTypeResource($result))->additional(['message' => 'EventType updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"EventTypesController"},
     *   path="/api/event_types/{event_type}",
     *   summary="Delete a event_type",
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
     *     name="event_type",
     *     parameter="event_type",
     *     description="EventType id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="EventType deleted"
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
     *         example="Problem deleting event_type"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param EventType $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EventType $record)
    {
        $result = EventTypeService::delete($record)
                                  ->getResult();

        if ($result) {
            return response()->json(['message' => 'EventType deleted']);
        }

        return response()->json(['message' => 'Problem deleting EventType'], 404);
    }
}
