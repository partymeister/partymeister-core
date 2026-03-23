<?php

namespace Partymeister\Core\Http\Controllers\Api\V2;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Motor\Core\Http\Controllers\Api\V2\ApiController;
use Partymeister\Core\Http\Requests\Api\V2\VisitorGetRequest;
use Partymeister\Core\Http\Requests\Api\V2\VisitorPatchRequest;
use Partymeister\Core\Http\Requests\Api\V2\VisitorPostRequest;
use Partymeister\Core\Http\Resources\V2\VisitorCollection;
use Partymeister\Core\Http\Resources\V2\VisitorResource;
use Partymeister\Core\Models\Visitor;
use Partymeister\Core\Services\VisitorService;

/**
 * @tags Visitors
 */
class VisitorsController extends ApiController
{
    protected string $model = Visitor::class;

    protected string $modelResource = 'visitor';

    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<VisitorResource>>
     */
    public function index(VisitorGetRequest $request): VisitorCollection
    {
        $paginator = VisitorService::collection()->getPaginator();

        return (new VisitorCollection($paginator))
            ->additional(['meta' => ['message' => 'Visitors retrieved']]);
    }

    public function store(VisitorPostRequest $request): JsonResponse
    {
        $result = VisitorService::create($request)->getResult();

        return (new VisitorResource($result))
            ->additional(['meta' => ['message' => 'Visitor created']])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Visitor $visitor): VisitorResource
    {
        $result = VisitorService::show($visitor)->getResult();

        return (new VisitorResource($result))
            ->additional(['meta' => ['message' => 'Visitor retrieved']]);
    }

    public function update(VisitorPatchRequest $request, Visitor $visitor): VisitorResource
    {
        $result = VisitorService::update($visitor, $request)->getResult();

        return (new VisitorResource($result))
            ->additional(['meta' => ['message' => 'Visitor updated']]);
    }

    public function destroy(Visitor $visitor): Response
    {
        $result = VisitorService::delete($visitor)->getResult();

        if ($result) {
            return $this->noContentResponse();
        }

        abort(404, 'Problem deleting visitor');
    }
}
