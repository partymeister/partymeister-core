<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Rpc\Callbacks;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Partymeister\Core\Services\StuhlService;

/**
 * @tags Callbacks
 */
class SendTestController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $status = StuhlService::send('TEST');

        return response()->json([
            'data' => [
                'stuhl_response' => $status,
            ],
            'meta' => ['api_version' => 'v2', 'message' => 'Test notification sent'],
        ], 200);
    }
}
