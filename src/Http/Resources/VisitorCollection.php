<?php

namespace Partymeister\Core\Http\Resources;

use Motor\Backend\Http\Resources\BaseCollection;

class VisitorCollection extends BaseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
