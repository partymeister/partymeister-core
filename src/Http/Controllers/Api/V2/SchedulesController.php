<?php

namespace Partymeister\Core\Http\Controllers\Api\V2;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Motor\Core\Http\Controllers\Api\V2\ApiController;
use Partymeister\Core\Http\Requests\Api\V2\ScheduleGetRequest;
use Partymeister\Core\Http\Requests\Api\V2\SchedulePatchRequest;
use Partymeister\Core\Http\Requests\Api\V2\SchedulePostRequest;
use Partymeister\Core\Http\Resources\V2\ScheduleCollection;
use Partymeister\Core\Http\Resources\V2\ScheduleResource;
use Partymeister\Core\Models\Schedule;
use Partymeister\Core\Services\ScheduleService;

/**
 * @tags Schedules
 */
class SchedulesController extends ApiController
{
    protected string $model = Schedule::class;

    protected string $modelResource = 'schedule';

    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<ScheduleResource>>
     */
    public function index(ScheduleGetRequest $request): ScheduleCollection
    {
        $paginator = ScheduleService::collection()->getPaginator();

        return (new ScheduleCollection($paginator))
            ->additional(['meta' => ['message' => 'Schedules retrieved']]);
    }

    public function store(SchedulePostRequest $request): JsonResponse
    {
        $result = ScheduleService::create($request)->getResult();

        return (new ScheduleResource($result))
            ->additional(['meta' => ['message' => 'Schedule created']])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Schedule $schedule): ScheduleResource
    {
        $result = ScheduleService::show($schedule)->getResult();

        return (new ScheduleResource($result))
            ->additional(['meta' => ['message' => 'Schedule retrieved']]);
    }

    public function update(SchedulePatchRequest $request, Schedule $schedule): ScheduleResource
    {
        $result = ScheduleService::update($schedule, $request)->getResult();

        return (new ScheduleResource($result))
            ->additional(['meta' => ['message' => 'Schedule updated']]);
    }

    public function destroy(Schedule $schedule): Response
    {
        $result = ScheduleService::delete($schedule)->getResult();

        if ($result) {
            return $this->noContentResponse();
        }

        abort(404, 'Problem deleting schedule');
    }
}
