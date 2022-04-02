<?php

namespace Partymeister\Core\Http\Controllers\Api\Public;

use Motor\Backend\Http\Controllers\PublicApiController;
use Partymeister\Core\Services\VisitorService;
use Partymeister\Core\Http\Resources\Public\VisitorCollection;

/**
 * Class VisitorsController
 *
 * @package Partymeister\Core\Http\Controllers\Api\Public
 */
class VisitorsController extends PublicApiController
{
    protected string $model = 'Partymeister\Core\Models\Visitor';

    protected string $modelResource = 'visitor';

    /**
     * @OA\Get (
     *   tags={"VisitorsController"},
     *   path="/api/public/visitors",
     *   summary="Get visitor collection",
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/PublicVisitorResource")
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

        return (new VisitorCollection($paginator))->additional(['message' => 'Public visitor collection read']);
    }
}
