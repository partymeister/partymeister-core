<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseCollection;

class VisitorCollection extends BaseCollection
{
    public $collects = VisitorResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
