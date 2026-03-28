<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Auth;

use Illuminate\Http\Request;
use Motor\Admin\Http\Controllers\Controller;
use Partymeister\Core\Http\Resources\V2\Auth\MessageResource;

/**
 * @tags Core: Visitor Auth
 */
class LogoutController extends Controller
{
    public function store(Request $request): MessageResource
    {
        $request->user()->currentAccessToken()->delete();

        return (new MessageResource)
            ->additional(['meta' => ['message' => 'Logged out']]);
    }
}
