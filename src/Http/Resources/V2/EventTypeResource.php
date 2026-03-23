<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseResource;
use Partymeister\Core\Models\EventType;

/**
 * @mixin EventType
 */
class EventTypeResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'web_color' => $this->web_color,
            'slide_color' => $this->slide_color,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
