<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\PublicApi;

use Illuminate\Routing\Controller;
use Partymeister\Core\Http\Resources\V2\PublicVisitorCollection;
use Partymeister\Core\Http\Resources\V2\PublicVisitorResource;
use Partymeister\Core\Services\VisitorService;

/**
 * @tags Core: Public
 */
class VisitorsController extends Controller
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
