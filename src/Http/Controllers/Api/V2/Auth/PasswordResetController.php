<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Motor\Admin\Http\Controllers\Controller;
use Partymeister\Core\Http\Requests\Api\V2\Auth\PasswordResetRequest;
use Partymeister\Core\Http\Resources\V2\Auth\MessageResource;
use Partymeister\Core\Models\Visitor;

/**
 * @tags Core: Visitor Auth
 */
class PasswordResetController extends Controller
{
    public function store(PasswordResetRequest $request): JsonResponse|MessageResource
    {
        $token = $request->input('token');

        $resetRecord = DB::table('password_resets')
            ->where('token', $token)
            ->first();

        if (! $resetRecord) {
            return response()->json([
                'error' => [
                    'code' => 'not_found',
                    'message' => 'Invalid or expired reset token',
                ],
                'meta' => ['api_version' => 'v2'],
            ], 404);
        }

        // Check if token is expired (older than 60 minutes)
        if (Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) {
            // Clean up expired token
            DB::table('password_resets')->where('token', $token)->delete();

            return response()->json([
                'error' => [
                    'code' => 'not_found',
                    'message' => 'Invalid or expired reset token',
                ],
                'meta' => ['api_version' => 'v2'],
            ], 404);
        }

        $visitor = Visitor::where('email', $resetRecord->email)->first();

        if (! $visitor) {
            return response()->json([
                'error' => [
                    'code' => 'not_found',
                    'message' => 'Visitor not found',
                ],
                'meta' => ['api_version' => 'v2'],
            ], 404);
        }

        // Update visitor password
        $visitor->password = bcrypt($request->input('password'));
        $visitor->save();

        // Delete all reset tokens for this email
        DB::table('password_resets')->where('email', $resetRecord->email)->delete();

        return (new MessageResource)
            ->additional(['meta' => ['message' => 'Password has been reset']]);
    }
}
