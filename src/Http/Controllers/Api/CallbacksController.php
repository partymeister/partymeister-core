<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;

use Partymeister\Core\Models\Callback;
use Partymeister\Core\Http\Requests\Backend\CallbackRequest;
use Partymeister\Core\Services\CallbackService;
use Partymeister\Core\Http\Resources\CallbackResource;
use Partymeister\Core\Http\Resources\CallbackCollection;

/**
 * Class CallbacksController
 *
 * @package Partymeister\Core\Http\Controllers\Api
 */
class CallbacksController extends ApiController
{
    protected string $model = 'Partymeister\Core\Models\Callback';

    protected string $modelResource = 'callback';

    /**
     * @OA\Get (
     *   tags={"CallbacksController"},
     *   path="/api/callbacks",
     *   summary="Get callback collection",
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
     *         @OA\Items(ref="#/components/schemas/CallbackResource")
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
     * @return CallbackCollection
     */
    public function index()
    {
        $paginator = CallbackService::collection()
                                    ->getPaginator();

        return (new CallbackCollection($paginator))->additional(['message' => 'Callback collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"CallbacksController"},
     *   path="/api/callbacks",
     *   summary="Create new callback",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/CallbackRequest")
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
     *         ref="#/components/schemas/CallbackResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Callback created"
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
     * @param CallbackRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CallbackRequest $request)
    {
        $result = CallbackService::create($request)
                                 ->getResult();

        return (new CallbackResource($result))->additional(['message' => 'Callback created'])
                                              ->response()
                                              ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"CallbacksController"},
     *   path="/api/callbacks/{callback}",
     *   summary="Get single callback",
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
     *     name="callback",
     *     parameter="callback",
     *     description="Callback id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/CallbackResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Callback read"
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
     * @param Callback $record
     * @return CallbackResource
     */
    public function show(Callback $record)
    {
        $result = CallbackService::show($record)
                                 ->getResult();

        return (new CallbackResource($result))->additional(['message' => 'Callback read']);
    }

    /**
     * @OA\Put (
     *   tags={"CallbacksController"},
     *   path="/api/callbacks/{callback}",
     *   summary="Update an existing callback",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/CallbackRequest")
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
     *     name="callback",
     *     parameter="callback",
     *     description="Callback id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/CallbackResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Callback updated"
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
     * @param CallbackRequest $request
     * @param Callback $record
     * @return CallbackResource
     */
    public function update(CallbackRequest $request, Callback $record)
    {
        $result = CallbackService::update($record, $request)
                                 ->getResult();

        return (new CallbackResource($result))->additional(['message' => 'Callback updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"CallbacksController"},
     *   path="/api/callbacks/{callback}",
     *   summary="Delete a callback",
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
     *     name="callback",
     *     parameter="callback",
     *     description="Callback id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Callback deleted"
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
     *         example="Problem deleting callback"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param Callback $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Callback $record)
    {
        $result = CallbackService::delete($record)
                                 ->getResult();

        if ($result) {
            return response()->json(['message' => 'Callback deleted']);
        }

        return response()->json(['message' => 'Problem deleting Callback'], 404);
    }
}
