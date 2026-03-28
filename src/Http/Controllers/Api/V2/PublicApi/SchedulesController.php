<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\PublicApi;

use Illuminate\Routing\Controller;
use Partymeister\Core\Http\Resources\V2\ScheduleCollection;
use Partymeister\Core\Http\Resources\V2\ScheduleResource;
use Partymeister\Core\Models\Schedule;
use Partymeister\Core\Services\ScheduleService;

/**
 * @tags Core: Public
 */
class SchedulesController extends Controller
{
    /**
     * @response Illuminate\Http\Resources\Json\AnonymousResourceCollection<Illuminate\Pagination\LengthAwarePaginator<ScheduleResource>>
     */
    public function index(): ScheduleCollection
    {
        $paginator = ScheduleService::collection()->getPaginator();

        return (new ScheduleCollection($paginator))
            ->additional(['meta' => ['message' => 'Schedules retrieved']]);
    }

    public function show(Schedule $schedule): ScheduleResource
    {
        $result = ScheduleService::show($schedule)->getResult();

        return (new ScheduleResource($result))
            ->additional(['meta' => ['message' => 'Schedule retrieved']]);
    }
}
