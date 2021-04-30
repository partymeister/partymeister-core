<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;

use Partymeister\Core\Models\Visitor;
use Partymeister\Core\Http\Requests\Backend\VisitorRequest;
use Partymeister\Core\Services\VisitorService;
use Partymeister\Core\Http\Resources\VisitorResource;
use Partymeister\Core\Http\Resources\VisitorCollection;

/**
 * Class VisitorsController
 *
 * @package Partymeister\Core\Http\Controllers\Api
 */
class VisitorsController extends ApiController
{
    protected string $model = 'Partymeister\Core\Models\Visitor';

    protected string $modelResource = 'visitor';

    /**
     * @OA\Get (
     *   tags={"VisitorsController"},
     *   path="/api/visitors",
     *   summary="Get visitor collection",
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
     *         @OA\Items(ref="#/components/schemas/VisitorResource")
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
     * @return VisitorCollection
     */
    public function index()
    {
        $paginator = VisitorService::collection()
                                   ->getPaginator();

        return (new VisitorCollection($paginator))->additional(['message' => 'Visitor collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"VisitorsController"},
     *   path="/api/visitors",
     *   summary="Create new visitor",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/VisitorRequest")
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
     *         ref="#/components/schemas/VisitorResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Visitor created"
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
     * @param VisitorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VisitorRequest $request)
    {
        $result = VisitorService::create($request)
                                ->getResult();

        return (new VisitorResource($result))->additional(['message' => 'Visitor created'])
                                             ->response()
                                             ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"VisitorsController"},
     *   path="/api/visitors/{visitor}",
     *   summary="Get single visitor",
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
     *     name="visitor",
     *     parameter="visitor",
     *     description="Visitor id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/VisitorResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Visitor read"
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
     * @param Visitor $record
     * @return VisitorResource
     */
    public function show(Visitor $record)
    {
        $result = VisitorService::show($record)
                                ->getResult();

        return (new VisitorResource($result))->additional(['message' => 'Visitor read']);
    }

    /**
     * @OA\Put (
     *   tags={"VisitorsController"},
     *   path="/api/visitors/{visitor}",
     *   summary="Update an existing visitor",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/VisitorRequest")
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
     *     name="visitor",
     *     parameter="visitor",
     *     description="Visitor id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/VisitorResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Visitor updated"
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
     * @param VisitorRequest $request
     * @param Visitor $record
     * @return VisitorResource
     */
    public function update(VisitorRequest $request, Visitor $record)
    {
        $result = VisitorService::update($record, $request)
                                ->getResult();

        return (new VisitorResource($result))->additional(['message' => 'Visitor updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"VisitorsController"},
     *   path="/api/visitors/{visitor}",
     *   summary="Delete a visitor",
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
     *     name="visitor",
     *     parameter="visitor",
     *     description="Visitor id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Visitor deleted"
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
     *         example="Problem deleting visitor"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param Visitor $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Visitor $record)
    {
        $result = VisitorService::delete($record)
                                ->getResult();

        if ($result) {
            return response()->json(['message' => 'Visitor deleted']);
        }

        return response()->json(['message' => 'Problem deleting Visitor'], 404);
    }
}
