<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseCollection;

class ScheduleCollection extends BaseCollection
{
    public $collects = ScheduleResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
