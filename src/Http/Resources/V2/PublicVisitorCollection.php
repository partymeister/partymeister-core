<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseCollection;

class PublicVisitorCollection extends BaseCollection
{
    public $collects = PublicVisitorResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
