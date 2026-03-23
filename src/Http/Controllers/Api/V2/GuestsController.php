<?php

namespace Partymeister\Core\Http\Controllers\Api\V2;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Motor\Core\Http\Controllers\Api\V2\ApiController;
use Partymeister\Core\Http\Requests\Api\V2\GuestGetRequest;
use Partymeister\Core\Http\Requests\Api\V2\GuestPatchRequest;
use Partymeister\Core\Http\Requests\Api\V2\GuestPostRequest;
use Partymeister\Core\Http\Resources\V2\GuestCollection;
use Partymeister\Core\Http\Resources\V2\GuestResource;
use Partymeister\Core\Models\Guest;
use Partymeister\Core\Services\GuestService;

/**
 * @tags Guests
 */
class GuestsController extends ApiController
{
    protected string $model = Guest::class;

    protected string $modelResource = 'guest';

    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<GuestResource>>
     */
    public function index(GuestGetRequest $request): GuestCollection
    {
        $paginator = GuestService::collection()->getPaginator();

        return (new GuestCollection($paginator))
            ->additional(['meta' => ['message' => 'Guests retrieved']]);
    }

    public function store(GuestPostRequest $request): JsonResponse
    {
        $result = GuestService::create($request)->getResult();

        return (new GuestResource($result))
            ->additional(['meta' => ['message' => 'Guest created']])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Guest $guest): GuestResource
    {
        $result = GuestService::show($guest)->getResult();

        return (new GuestResource($result))
            ->additional(['meta' => ['message' => 'Guest retrieved']]);
    }

    public function update(GuestPatchRequest $request, Guest $guest): GuestResource
    {
        $result = GuestService::update($guest, $request)->getResult();

        return (new GuestResource($result))
            ->additional(['meta' => ['message' => 'Guest updated']]);
    }

    public function destroy(Guest $guest): Response
    {
        $result = GuestService::delete($guest)->getResult();

        if ($result) {
            return $this->noContentResponse();
        }

        abort(404, 'Problem deleting guest');
    }
}
