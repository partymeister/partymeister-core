<?php

namespace Partymeister\Core\Http\Resources\V2\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Lightweight resource for status-only V2 responses (no model data).
 *
 * Produces: { data: null, meta: { api_version: "v2", message: "..." } }
 */
class MessageResource extends JsonResource
{
    public static $wrap = 'data';

    public function __construct()
    {
        parent::__construct(null);
    }

    public function toArray(Request $request): ?array
    {
        return null;
    }

    public function with(Request $request): array
    {
        return [
            'meta' => [
                'api_version' => 'v2',
            ],
        ];
    }
}
