<?php

namespace Partymeister\Core\Http\Controllers\Api\V2;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Motor\Core\Http\Controllers\Api\V2\ApiController;
use Partymeister\Core\Http\Requests\Api\V2\CallbackGetRequest;
use Partymeister\Core\Http\Requests\Api\V2\CallbackPatchRequest;
use Partymeister\Core\Http\Requests\Api\V2\CallbackPostRequest;
use Partymeister\Core\Http\Resources\V2\CallbackCollection;
use Partymeister\Core\Http\Resources\V2\CallbackResource;
use Partymeister\Core\Models\Callback;
use Partymeister\Core\Services\CallbackService;

/**
 * @tags Core: Callbacks
 */
class CallbacksController extends ApiController
{
    protected string $model = Callback::class;

    protected string $modelResource = 'callback';

    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<CallbackResource>>
     */
    public function index(CallbackGetRequest $request): CallbackCollection
    {
        $paginator = CallbackService::collection()->getPaginator();

        return (new CallbackCollection($paginator))
            ->additional(['meta' => ['message' => 'Callbacks retrieved']]);
    }

    public function store(CallbackPostRequest $request): JsonResponse
    {
        $result = CallbackService::create($request)->getResult();

        return (new CallbackResource($result))
            ->additional(['meta' => ['message' => 'Callback created']])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Callback $callback): CallbackResource
    {
        $result = CallbackService::show($callback)->getResult();

        return (new CallbackResource($result))
            ->additional(['meta' => ['message' => 'Callback retrieved']]);
    }

    public function update(CallbackPatchRequest $request, Callback $callback): CallbackResource
    {
        $result = CallbackService::update($callback, $request)->getResult();

        return (new CallbackResource($result))
            ->additional(['meta' => ['message' => 'Callback updated']]);
    }

    public function destroy(Callback $callback): Response
    {
        $result = CallbackService::delete($callback)->getResult();

        if ($result) {
            return $this->noContentResponse();
        }

        abort(404, 'Problem deleting callback');
    }
}
