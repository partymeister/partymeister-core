<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;

use Partymeister\Core\Models\MessageGroup;
use Partymeister\Core\Http\Requests\Backend\MessageGroupRequest;
use Partymeister\Core\Services\MessageGroupService;
use Partymeister\Core\Http\Resources\MessageGroupResource;
use Partymeister\Core\Http\Resources\MessageGroupCollection;

// TODO: is this class still needed?

/**
 * Class MessageGroupsController
 *
 * @package Partymeister\Core\Http\Controllers\Api
 */
class MessageGroupsController extends ApiController
{
    protected string $model = 'Partymeister\Core\Models\MessageGroup';

    protected string $modelResource = 'message_group';

    /**
     * @OA\Get (
     *   tags={"MessageGroupsController"},
     *   path="/api/message_groups",
     *   summary="Get message_group collection",
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
     *         @OA\Items(ref="#/components/schemas/MessageGroupResource")
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
     * @return MessageGroupCollection
     */
    public function index()
    {
        $paginator = MessageGroupService::collection()
                                        ->getPaginator();

        return (new MessageGroupCollection($paginator))->additional(['message' => 'MessageGroup collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"MessageGroupsController"},
     *   path="/api/message_groups",
     *   summary="Create new message_group",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/MessageGroupRequest")
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
     *         ref="#/components/schemas/MessageGroupResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="MessageGroup created"
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
     * @param MessageGroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MessageGroupRequest $request)
    {
        $result = MessageGroupService::create($request)
                                     ->getResult();

        return (new MessageGroupResource($result))->additional(['message' => 'MessageGroup created'])
                                                  ->response()
                                                  ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"MessageGroupsController"},
     *   path="/api/message_groups/{message_group}",
     *   summary="Get single message_group",
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
     *     name="message_group",
     *     parameter="message_group",
     *     description="MessageGroup id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/MessageGroupResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="MessageGroup read"
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
     * @param MessageGroup $record
     * @return MessageGroupResource
     */
    public function show(MessageGroup $record)
    {
        $result = MessageGroupService::show($record)
                                     ->getResult();

        return (new MessageGroupResource($result))->additional(['message' => 'MessageGroup read']);
    }

    /**
     * @OA\Put (
     *   tags={"MessageGroupsController"},
     *   path="/api/message_groups/{message_group}",
     *   summary="Update an existing message_group",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/MessageGroupRequest")
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
     *     name="message_group",
     *     parameter="message_group",
     *     description="MessageGroup id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/MessageGroupResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="MessageGroup updated"
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
     * @param MessageGroupRequest $request
     * @param MessageGroup $record
     * @return MessageGroupResource
     */
    public function update(MessageGroupRequest $request, MessageGroup $record)
    {
        $result = MessageGroupService::update($record, $request)
                                     ->getResult();

        return (new MessageGroupResource($result))->additional(['message' => 'MessageGroup updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"MessageGroupsController"},
     *   path="/api/message_groups/{message_group}",
     *   summary="Delete a message_group",
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
     *     name="message_group",
     *     parameter="message_group",
     *     description="MessageGroup id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="MessageGroup deleted"
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
     *         example="Problem deleting message_group"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param MessageGroup $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MessageGroup $record)
    {
        $result = MessageGroupService::delete($record)
                                     ->getResult();

        if ($result) {
            return response()->json(['message' => 'MessageGroup deleted']);
        }

        return response()->json(['message' => 'Problem deleting MessageGroup'], 404);
    }
}
