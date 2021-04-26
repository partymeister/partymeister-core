<?php

namespace Partymeister\Core\Http\Controllers\ApiRPC\Guests;

use Illuminate\Http\JsonResponse;
use Motor\Backend\Http\Controllers\ApiController;
use Partymeister\Core\Http\Requests\Backend\GuestRequest;
use Partymeister\Core\Models\Guest;

/**
 * Class ScanTicketsController
 *
 * @package Partymeister\Core\Http\Controllers\Api\Guests
 */
class ScanTicketsController extends ApiController
{
    /**
     * @param GuestRequest $request
     * @return JsonResponse
     */
    public function index(GuestRequest $request)
    {
        $guest = Guest::where('ticket_code', $request->get('ticket_code'))
                      ->first();
        if (is_null($guest)) {
            return response()->json([
                'error' => trans('partymeister-core::backend/guests.ticket_code_not_found', ['ticket_code' => $request->get('ticket_code')]),
            ], 404);
        }

        if ($guest->ticket_code_scanned) {
            return response()->json([
                'error' => trans('partymeister-core::backend/guests.ticket_code_already_scanned', [
                    'ticket_code' => $request->get('ticket_code'),
                    'date'        => $guest->arrived_at,
                ]),
            ], 404);
        }
        if ($guest->has_arrived) {
            return response()->json([
                'error' => trans('partymeister-core::backend/guests.guest_already_arrived', ['date' => $guest->arrived_at]),
            ], 404);
        }
        $guest->has_arrived = true;
        $guest->ticket_code_scanned = true;
        $guest->arrived_at = date('Y-m-d H:i:s');
        $guest->save();

        $response = [];
        $response['success'] = '<b>'.$guest->ticket_type.'</b> ('.$guest->ticket_code.')';

        $response['name'] = '';

        if ($guest->name != '') {
            if ($guest->company != '') {
                $response['name'] .= '<b>'.$guest->name.' ('.$guest->company.')</b>';
            } else {
                $response['name'] .= '<b>'.$guest->name.'</b>';
            }
        }

        if ($response['name'] == '') {
            unset($response['name']);
        }

        $response['info'] = '';

        if ($guest->has_badge) {
            $response['info'] .= '<p>'.trans('partymeister-core::backend/guests.badge_info').'</p>';
        }

        if ($guest->comment != '') {
            $response['info'] .= '<p>'.nl2br($guest->comment).'</p>';
        }

        if ($response['info'] == '') {
            unset($response['info']);
        }

        return response()->json($response, 200);
    }
}
