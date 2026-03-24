<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\PublicApi;

use Motor\Core\Http\Controllers\Api\V2\ApiController;
use Partymeister\Core\Http\Resources\V2\PublicVisitorCollection;
use Partymeister\Core\Http\Resources\V2\PublicVisitorResource;
use Partymeister\Core\Services\VisitorService;

/**
 * @tags Public
 */
class VisitorsController extends ApiController
{
    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<PublicVisitorResource>>
     */
    public function index(): PublicVisitorCollection
    {
        $paginator = VisitorService::collection()->getPaginator();

        return (new PublicVisitorCollection($paginator))
            ->additional(['meta' => ['message' => 'Visitors retrieved']]);
    }
}
