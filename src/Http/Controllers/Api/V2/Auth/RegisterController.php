<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Motor\Admin\Http\Controllers\Controller;
use Partymeister\Competitions\Models\AccessKey;
use Partymeister\Core\Http\Requests\Api\V2\Auth\RegisterRequest;
use Partymeister\Core\Http\Resources\V2\Auth\AuthVisitorResource;
use Partymeister\Core\Models\Visitor;

/**
 * @tags Core: Visitor Auth
 */
class RegisterController extends Controller
{
    public function store(RegisterRequest $request): JsonResponse|AuthVisitorResource
    {
        if (! config('partymeister-core.visitor_registration_enabled', false)) {
            return response()->json([
                'error' => [
                    'code' => 'service_unavailable',
                    'message' => 'Registration is currently disabled',
                ],
                'meta' => ['api_version' => 'v2'],
            ], 503);
        }

        $name = $request->input('name');

        // Check name uniqueness
        if (Visitor::where('name', $name)->exists()) {
            return response()->json([
                'error' => [
                    'code' => 'conflict',
                    'message' => 'Profile already registered',
                ],
                'meta' => ['api_version' => 'v2'],
            ], 409);
        }

        // Validate access key
        $accessKey = AccessKey::where('access_key', $request->input('access_key'))
            ->whereNull('visitor_id')
            ->first();

        if (is_null($accessKey)) {
            return response()->json([
                'error' => [
                    'code' => 'forbidden',
                    'message' => 'Access key invalid',
                ],
                'meta' => ['api_version' => 'v2'],
            ], 403);
        }

        // Create visitor
        $visitor = new Visitor;
        $visitor->name = $name;
        $visitor->password = bcrypt($request->input('password'));
        $visitor->group = $request->input('group', '');
        $visitor->country_iso_3166_1 = $request->input('country_iso_3166_1', '');
        $visitor->additional_data = $request->input('additional_data', []);
        $visitor->api_token = Str::random(60);
        $visitor->save();

        // Assign access key to visitor
        $accessKey->visitor_id = $visitor->id;
        $accessKey->registered_at = date('Y-m-d H:i:s');
        $accessKey->ip_address = $request->ip();
        $accessKey->save();

        // Create a Sanctum personal access token
        $token = $visitor->createToken('mobile-app')->plainTextToken;

        return (new AuthVisitorResource($visitor, $token))
            ->additional(['meta' => ['message' => 'Registration successful']])
            ->response()
            ->setStatusCode(201);
    }
}
