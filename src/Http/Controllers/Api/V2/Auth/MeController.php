<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Motor\Admin\Http\Controllers\Controller;
use Partymeister\Core\Http\Resources\V2\VisitorResource;

/**
 * @tags Visitor Auth
 */
class MeController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $visitor = $request->user();

        return response()->json([
            'data' => (new VisitorResource($visitor))->toArray($request),
            'meta' => [
                'api_version' => 'v2',
                'message' => 'Profile loaded',
            ],
        ], 200);
    }
}
