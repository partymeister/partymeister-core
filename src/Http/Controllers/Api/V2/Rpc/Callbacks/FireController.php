<?php

namespace Partymeister\Core\Http\Controllers\Api\V2\Rpc\Callbacks;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Partymeister\Competitions\Events\CompetitionSaved;
use Partymeister\Competitions\Events\LiveVoteUpdated;
use Partymeister\Competitions\Mail\EntryStatusInfo;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Models\LiveVote;
use Partymeister\Core\Models\Callback;
use Partymeister\Core\Services\StuhlService;

/**
 * @tags Callbacks
 */
class FireController extends Controller
{
    public function __invoke(Callback $callback): JsonResponse
    {
        if ($callback->has_fired) {
            return response()->json([
                'data' => [
                    'status' => 'already_fired',
                    'fired_at' => Carbon::parse($callback->fired_at)->toIso8601String(),
                ],
                'meta' => ['api_version' => 'v2', 'message' => 'Callback has already been fired'],
            ], 200);
        }

        if ($callback->is_timed && Carbon::parse($callback->embargo_until)->isFuture()) {
            return response()->json([
                'data' => null,
                'meta' => [
                    'api_version' => 'v2',
                    'message' => 'Embargo time '.$callback->embargo_until.' not reached',
                ],
            ], 403);
        }

        $status = null;

        switch ($callback->action) {
            case 'competition_ends':
                $payload = json_decode($callback->payload);
                $competition = Competition::find($payload->competition_id);
                if (is_null($competition)) {
                    return response()->json([
                        'data' => null,
                        'meta' => ['api_version' => 'v2', 'message' => 'Competition does not exist'],
                    ], 403);
                }

                $competition->voting_enabled = true;
                $competition->save();

                event(new CompetitionSaved($competition));
                break;

            case 'competition_starts':
                $payload = json_decode($callback->payload);
                $competition = Competition::find($payload->competition_id);

                foreach ($competition->unqualified_entries_with_opt_in as $entry) {
                    try {
                        Mail::to($entry->visitor->email)
                            ->send(new EntryStatusInfo($entry));
                    } catch (\Exception $exception) {
                        Log::error('Mail could not be sent to', [$entry->visitor->email, $exception]);
                    }
                }

                $status = StuhlService::send($callback->body, $callback->title, '', EVENT_LEVEL_BORING, $callback->destination);
                break;

            case 'notification':
                $status = StuhlService::send($callback->body, $callback->title, '', EVENT_LEVEL_BORING, $callback->destination);
                break;

            case 'live_with_notification':
                $payload = json_decode($callback->payload);
                $entry = Entry::find($payload->entry_id);
                $competition = Competition::find($payload->competition_id);
                if (is_null($entry) || is_null($competition)) {
                    return response()->json([
                        'data' => null,
                        'meta' => ['api_version' => 'v2', 'message' => 'Entry or competition does not exist'],
                    ], 403);
                }

                $l = LiveVote::first();
                if (is_null($l)) {
                    $l = new LiveVote;
                }
                $l->entry_id = $payload->entry_id;
                $l->competition_id = $payload->competition_id;
                $l->sort_position = $entry->sort_position;
                $l->save();

                $status = StuhlService::send($callback->body, $callback->title, '', EVENT_LEVEL_GOOD, $callback->destination);

                event(new LiveVoteUpdated($l));
                break;
        }

        $callback->has_fired = true;
        $callback->fired_at = now();
        $callback->save();

        return response()->json([
            'data' => [
                'status' => 'fired',
                'action' => $callback->action,
                'stuhl_response' => $status,
            ],
            'meta' => ['api_version' => 'v2', 'message' => 'Callback fired successfully'],
        ], 200);
    }
}
