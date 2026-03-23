<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Motor\Admin\Http\Controllers\Controller;

/**
 * @tags Visitor Auth
 */
class LogoutController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'data' => null,
            'meta' => [
                'api_version' => 'v2',
                'message' => 'Logged out',
            ],
        ], 200);
    }
}
