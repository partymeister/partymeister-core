<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Rpc\Guests;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Partymeister\Core\Http\Requests\Api\V2\Rpc\ScanTicketRequest;
use Partymeister\Core\Http\Resources\V2\GuestResource;
use Partymeister\Core\Models\Guest;

/**
 * @tags Guests
 */
class ScanTicketController extends Controller
{
    public function __invoke(ScanTicketRequest $request): JsonResponse
    {
        $guest = Guest::where('ticket_code', $request->input('ticket_code'))->first();

        if (is_null($guest)) {
            return response()->json([
                'data' => null,
                'meta' => [
                    'api_version' => 'v2',
                    'message' => 'Ticket code not found',
                ],
            ], 404);
        }

        if ($guest->ticket_code_scanned) {
            return response()->json([
                'data' => [
                    'ticket_code' => $guest->ticket_code,
                    'arrived_at' => $guest->arrived_at,
                ],
                'meta' => [
                    'api_version' => 'v2',
                    'message' => 'Ticket code has already been scanned',
                ],
            ], 409);
        }

        if ($guest->has_arrived) {
            return response()->json([
                'data' => [
                    'arrived_at' => $guest->arrived_at,
                ],
                'meta' => [
                    'api_version' => 'v2',
                    'message' => 'Guest has already arrived',
                ],
            ], 409);
        }

        $guest->has_arrived = true;
        $guest->ticket_code_scanned = true;
        $guest->arrived_at = Carbon::now();
        $guest->save();

        return (new GuestResource($guest))
            ->additional(['meta' => ['message' => 'Ticket scanned successfully']])
            ->response()
            ->setStatusCode(200);
    }
}
