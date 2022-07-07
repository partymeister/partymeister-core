<?php

namespace Partymeister\Core\Http\Controllers\ApiRPC\Guests;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Motor\Admin\Http\Controllers\ApiController;
use Partymeister\Core\Http\Requests\Backend\GuestRequest;
use Partymeister\Core\Http\Resources\GuestResource;
use Partymeister\Core\Models\Guest;

/**
 * Class ScanTicketsController
 */
class ScanTicketsController extends ApiController
{
    /**
     * @param  GuestRequest  $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $guest = Guest::where('ticket_code', $request->get('ticket_code'))
                      ->first();
        if (is_null($guest)) {
            return response()->json([
                'error'   => 'partymeister-core.guests.ticket_code_not_found',
                'replace' => ['ticket_code' => $request->get('ticket_code')],
            ], 404);
        }

        if ($guest->ticket_code_scanned) {
            return response()->json([
                'error'   => 'partymeister-core.guests.ticket_code_already_scanned',
                'replace' => [
                    'ticket_code' => $request->get('ticket_code'),
                    'date'        => $guest->arrived_at,
                ],
            ], 404);
        }
        if ($guest->has_arrived) {
            return response()->json([
                'error' => 'partymeister-core.guests.guest_already_arrived', 'replace' => ['date' => $guest->arrived_at],
            ], 404);
        }
        $guest->has_arrived = true;
        $guest->ticket_code_scanned = true;
        $guest->arrived_at = date('Y-m-d H:i:s');
        $guest->save();

        $response = [];
        $response['record'] = new GuestResource($guest);

        return response()->json($response, 200);
    }
}
