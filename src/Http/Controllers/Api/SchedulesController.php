<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;

use Partymeister\Core\Models\Schedule;
use Partymeister\Core\Http\Requests\Backend\ScheduleRequest;
use Partymeister\Core\Services\ScheduleService;
use Partymeister\Core\Http\Resources\ScheduleResource;
use Partymeister\Core\Http\Resources\ScheduleCollection;

/**
 * Class SchedulesController
 *
 * @package Partymeister\Core\Http\Controllers\Api
 */
class SchedulesController extends ApiController
{
    protected string $model = 'Partymeister\Core\Models\Schedule';

    protected string $modelResource = 'schedule';

    /**
     * @OA\Get (
     *   tags={"SchedulesController"},
     *   path="/api/schedules",
     *   summary="Get schedule collection",
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
     *         @OA\Items(ref="#/components/schemas/ScheduleResource")
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
     * @return ScheduleCollection
     */
    public function index()
    {
        $paginator = ScheduleService::collection()
                                    ->getPaginator();

        return (new ScheduleCollection($paginator))->additional(['message' => 'Schedule collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"SchedulesController"},
     *   path="/api/schedules",
     *   summary="Create new schedule",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/ScheduleRequest")
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
     *         ref="#/components/schemas/ScheduleResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Schedule created"
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
     * @param ScheduleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ScheduleRequest $request)
    {
        $result = ScheduleService::create($request)
                                 ->getResult();

        return (new ScheduleResource($result))->additional(['message' => 'Schedule created'])
                                              ->response()
                                              ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"SchedulesController"},
     *   path="/api/schedules/{schedule}",
     *   summary="Get single schedule",
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
     *     name="schedule",
     *     parameter="schedule",
     *     description="Schedule id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/ScheduleResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Schedule read"
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
     * @param Schedule $record
     * @return ScheduleResource
     */
    public function show(Schedule $record)
    {
        $result = ScheduleService::show($record)
                                 ->getResult();

        return (new ScheduleResource($result))->additional(['message' => 'Schedule read']);
    }

    /**
     * @OA\Put (
     *   tags={"SchedulesController"},
     *   path="/api/schedules/{schedule}",
     *   summary="Update an existing schedule",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/ScheduleRequest")
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
     *     name="schedule",
     *     parameter="schedule",
     *     description="Schedule id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/ScheduleResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Schedule updated"
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
     * @param ScheduleRequest $request
     * @param Schedule $record
     * @return ScheduleResource
     */
    public function update(ScheduleRequest $request, Schedule $record)
    {
        $result = ScheduleService::update($record, $request)
                                 ->getResult();

        return (new ScheduleResource($result))->additional(['message' => 'Schedule updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"SchedulesController"},
     *   path="/api/schedules/{schedule}",
     *   summary="Delete a schedule",
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
     *     name="schedule",
     *     parameter="schedule",
     *     description="Schedule id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Schedule deleted"
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
     *         example="Problem deleting schedule"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param Schedule $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Schedule $record)
    {
        $result = ScheduleService::delete($record)
                                 ->getResult();

        if ($result) {
            return response()->json(['message' => 'Schedule deleted']);
        }

        return response()->json(['message' => 'Problem deleting Schedule'], 404);
    }
}
