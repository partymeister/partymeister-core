<?php

namespace Partymeister\Core\Http\Resources\V2\Auth;

use Illuminate\Http\Request;
use Motor\Core\Http\Resources\V2\BaseResource;
use Partymeister\Core\Http\Resources\V2\VisitorResource;

/**
 * Wraps a Visitor model with its Sanctum token for auth responses.
 *
 * Produces: { data: { visitor: {...}, token: "..." }, meta: {...} }
 */
class AuthVisitorResource extends BaseResource
{
    /** The plain-text Sanctum token to include alongside the visitor. */
    private string $token;

    public function __construct($resource, string $token)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    public function toArray(Request $request): array
    {
        return [
            'visitor' => (new VisitorResource($this->resource))->toArray($request),
            'token' => $this->token,
        ];
    }
}
