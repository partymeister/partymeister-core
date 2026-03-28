<?php

namespace Partymeister\Core\Http\Controllers\Api\V2;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Motor\Core\Http\Controllers\Api\V2\ApiController;
use Partymeister\Core\Http\Requests\Api\V2\MessageGroupGetRequest;
use Partymeister\Core\Http\Requests\Api\V2\MessageGroupPatchRequest;
use Partymeister\Core\Http\Requests\Api\V2\MessageGroupPostRequest;
use Partymeister\Core\Http\Resources\V2\MessageGroupCollection;
use Partymeister\Core\Http\Resources\V2\MessageGroupResource;
use Partymeister\Core\Models\MessageGroup;
use Partymeister\Core\Services\MessageGroupService;

/**
 * @tags Core: Message Groups
 */
class MessageGroupsController extends ApiController
{
    protected string $model = MessageGroup::class;

    protected string $modelResource = 'message_group';

    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<MessageGroupResource>>
     */
    public function index(MessageGroupGetRequest $request): MessageGroupCollection
    {
        $paginator = MessageGroupService::collection()->getPaginator();

        return (new MessageGroupCollection($paginator))
            ->additional(['meta' => ['message' => 'Message groups retrieved']]);
    }

    public function store(MessageGroupPostRequest $request): JsonResponse
    {
        $result = MessageGroupService::create($request)->getResult();

        return (new MessageGroupResource($result))
            ->additional(['meta' => ['message' => 'Message group created']])
            ->response()
            ->setStatusCode(201);
    }

    public function show(MessageGroup $message_group): MessageGroupResource
    {
        $result = MessageGroupService::show($message_group)->getResult();

        return (new MessageGroupResource($result))
            ->additional(['meta' => ['message' => 'Message group retrieved']]);
    }

    public function update(MessageGroupPatchRequest $request, MessageGroup $message_group): MessageGroupResource
    {
        $result = MessageGroupService::update($message_group, $request)->getResult();

        return (new MessageGroupResource($result))
            ->additional(['meta' => ['message' => 'Message group updated']]);
    }

    public function destroy(MessageGroup $message_group): Response
    {
        $result = MessageGroupService::delete($message_group)->getResult();

        if ($result) {
            return $this->noContentResponse();
        }

        abort(404, 'Problem deleting message group');
    }
}
