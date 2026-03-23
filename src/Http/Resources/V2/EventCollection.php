<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseCollection;

class EventCollection extends BaseCollection
{
    public $collects = EventResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
