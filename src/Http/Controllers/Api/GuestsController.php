<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;

use Partymeister\Core\Models\Guest;
use Partymeister\Core\Http\Requests\Backend\GuestRequest;
use Partymeister\Core\Services\GuestService;
use Partymeister\Core\Http\Resources\GuestResource;
use Partymeister\Core\Http\Resources\GuestCollection;

/**
 * Class GuestsController
 *
 * @package Partymeister\Core\Http\Controllers\Api
 */
class GuestsController extends ApiController
{
    protected string $model = 'Partymeister\Core\Models\Guest';

    protected string $modelResource = 'guest';

    /**
     * @OA\Get (
     *   tags={"GuestsController"},
     *   path="/api/guests",
     *   summary="Get guest collection",
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
     *         @OA\Items(ref="#/components/schemas/GuestResource")
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
     * @return GuestCollection
     */
    public function index()
    {
        $paginator = GuestService::collection()
                                 ->getPaginator();

        return (new GuestCollection($paginator))->additional(['message' => 'Guest collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"GuestsController"},
     *   path="/api/guests",
     *   summary="Create new guest",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/GuestRequest")
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
     *         ref="#/components/schemas/GuestResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Guest created"
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
     * @param GuestRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GuestRequest $request)
    {
        $result = GuestService::create($request)
                              ->getResult();

        return (new GuestResource($result))->additional(['message' => 'Guest created'])
                                           ->response()
                                           ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"GuestsController"},
     *   path="/api/guests/{guest}",
     *   summary="Get single guest",
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
     *     name="guest",
     *     parameter="guest",
     *     description="Guest id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/GuestResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Guest read"
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
     * @param Guest $record
     * @return GuestResource
     */
    public function show(Guest $record)
    {
        $result = GuestService::show($record)
                              ->getResult();

        return (new GuestResource($result))->additional(['message' => 'Guest read']);
    }

    /**
     * @OA\Put (
     *   tags={"GuestsController"},
     *   path="/api/guests/{guest}",
     *   summary="Update an existing guest",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/GuestRequest")
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
     *     name="guest",
     *     parameter="guest",
     *     description="Guest id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/GuestResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Guest updated"
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
     * @param GuestRequest $request
     * @param Guest $record
     * @return GuestResource
     */
    public function update(GuestRequest $request, Guest $record)
    {
        $result = GuestService::update($record, $request)
                              ->getResult();

        return (new GuestResource($result))->additional(['message' => 'Guest updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"GuestsController"},
     *   path="/api/guests/{guest}",
     *   summary="Delete a guest",
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
     *     name="guest",
     *     parameter="guest",
     *     description="Guest id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Guest deleted"
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
     *         example="Problem deleting guest"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param Guest $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Guest $record)
    {
        $result = GuestService::delete($record)
                              ->getResult();

        if ($result) {
            return response()->json(['message' => 'Guest deleted']);
        }

        return response()->json(['message' => 'Problem deleting Guest'], 404);
    }
}
