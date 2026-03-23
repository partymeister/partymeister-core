<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Admin\Http\Resources\V2\UserResource;
use Motor\Core\Http\Resources\V2\BaseResource;
use Partymeister\Core\Models\MessageGroup;

/**
 * @mixin MessageGroup
 */
class MessageGroupResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'uuid' => $this->uuid,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
