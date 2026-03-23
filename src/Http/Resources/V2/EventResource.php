<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseResource;
use Partymeister\Core\Models\Event;

/**
 * @mixin Event
 */
class EventResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'starts_at' => $this->starts_at?->toIso8601String(),
            'ends_at' => $this->ends_at?->toIso8601String(),
            'is_visible' => $this->is_visible,
            'is_organizer_only' => $this->is_organizer_only,
            'sort_position' => $this->sort_position,
            'notify_minutes' => $this->notify_minutes,
            'link' => $this->link,
            'event_type' => EventTypeResource::make($this->whenLoaded('event_type')),
            'schedule_id' => $this->schedule_id,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
