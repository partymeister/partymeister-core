<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\PublicApi;

use Motor\Core\Http\Controllers\Api\V2\ApiController;
use Partymeister\Core\Http\Resources\V2\VisitorCollection;
use Partymeister\Core\Http\Resources\V2\VisitorResource;
use Partymeister\Core\Services\VisitorService;

/**
 * @tags Public
 */
class VisitorsController extends ApiController
{
    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<VisitorResource>>
     */
    public function index(): VisitorCollection
    {
        $paginator = VisitorService::collection()->getPaginator();

        return (new VisitorCollection($paginator))
            ->additional(['meta' => ['message' => 'Visitors retrieved']]);
    }
}
