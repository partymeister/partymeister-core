<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseCollection;

class CallbackCollection extends BaseCollection
{
    public $collects = CallbackResource::class;

    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
