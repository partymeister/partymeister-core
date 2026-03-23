<?php

namespace Partymeister\Core\Http\Resources\V2;

use Motor\Core\Http\Resources\V2\BaseResource;
use Partymeister\Core\Models\Guest;

/**
 * @mixin Guest
 */
class GuestResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => (int) $this->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'handle' => $this->handle,
            'email' => $this->email,
            'company' => $this->company,
            'country' => $this->country,
            'ticket_code' => $this->ticket_code,
            'ticket_type' => $this->ticket_type,
            'ticket_order_number' => $this->ticket_order_number,
            'has_badge' => $this->has_badge,
            'has_arrived' => $this->has_arrived,
            'ticket_code_scanned' => $this->ticket_code_scanned,
            'comment' => $this->comment,
            'arrived_at' => $this->arrived_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
