<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseResource;
use Partymeister\Core\Models\Callback;

/**
 * @mixin Callback
 */
class CallbackResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'action' => $this->action,
            'payload' => $this->payload,
            'title' => $this->title,
            'body' => $this->body,
            'link' => $this->link,
            'destination' => $this->destination,
            'hash' => $this->hash,
            'embargo_until' => $this->embargo_until?->toIso8601String(),
            'fired_at' => $this->fired_at?->toIso8601String(),
            'has_fired' => $this->has_fired,
            'is_timed' => $this->is_timed,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
