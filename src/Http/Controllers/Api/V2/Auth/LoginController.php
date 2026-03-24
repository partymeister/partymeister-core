<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Motor\Admin\Http\Controllers\Controller;
use Partymeister\Core\Http\Requests\Api\V2\Auth\LoginRequest;
use Partymeister\Core\Http\Resources\V2\VisitorResource;
use Partymeister\Core\Models\Visitor;

/**
 * @tags Visitor Auth
 */
class LoginController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        if (! config('partymeister-core.visitor_login_enabled', false)) {
            return response()->json([
                'error' => [
                    'code' => 'service_unavailable',
                    'message' => 'Login is currently disabled',
                ],
                'meta' => ['api_version' => 'v2'],
            ], 503);
        }

        $name = $request->input('name');
        $password = $request->input('password');

        if (! Auth::guard('visitor')->attempt(['name' => $name, 'password' => $password])) {
            return response()->json([
                'error' => [
                    'code' => 'invalid_credentials',
                    'message' => 'Login unsuccessful',
                ],
                'meta' => ['api_version' => 'v2'],
            ], 401);
        }

        $visitor = Auth::guard('visitor')->user();

        // Revoke any existing tokens for this visitor
        $visitor->tokens()->delete();

        // Create a new Sanctum personal access token
        $token = $visitor->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'data' => [
                'visitor' => (new VisitorResource($visitor))->toArray($request),
                'token' => $token,
            ],
            'meta' => [
                'api_version' => 'v2',
                'message' => 'Login successful',
            ],
        ], 200);
    }
}
