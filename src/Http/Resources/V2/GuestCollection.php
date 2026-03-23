<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseCollection;

class GuestCollection extends BaseCollection
{
    public $collects = GuestResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
