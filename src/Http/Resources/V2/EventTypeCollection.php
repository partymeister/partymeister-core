<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseCollection;

class EventTypeCollection extends BaseCollection
{
    public $collects = EventTypeResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
