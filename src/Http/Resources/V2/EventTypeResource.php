<?php

namespace Partymeister\Core\Http\Resources\V2;

use Illuminate\Http\Request;
use Motor\Core\Http\Resources\V2\BaseResource;

class EventTypeResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'web_color' => $this->web_color,
            'slide_color' => $this->slide_color,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
