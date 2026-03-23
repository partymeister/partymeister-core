<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseCollection;

class MessageGroupCollection extends BaseCollection
{
    public $collects = MessageGroupResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
