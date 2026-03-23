<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseCollection;

class EventTypeCollection extends BaseCollection
{
    public $collects = EventTypeResource::class;
}
