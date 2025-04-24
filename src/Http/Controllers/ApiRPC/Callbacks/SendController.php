<?php

namespace Partymeister\Core\Http\Controllers\ApiRPC\Callbacks;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Motor\Backend\Http\Controllers\ApiController;
use Partymeister\Competitions\Events\CompetitionSaved;
use Partymeister\Competitions\Events\LiveVoteUpdated;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Models\LiveVote;
use Partymeister\Core\Models\Callback;
use Partymeister\Core\Services\StuhlService;

/**
 * Class SendController
 */
class SendController extends ApiController
{
    /**
     * @return ResponseFactory|JsonResponse|Response
     *
     * @throws GuzzleException
     */
    public function callback($hash)
    {
        if ($hash == 'single') {
            return $this->single(request());
        }
        $callback = Callback::where('hash', $hash)
            ->first();
        if (is_null($callback)) {
            return response(404);
        }

        if ($callback->has_fired) {
            return response('Already fired', 403);
        }

        $status = 'THIS SHOULD NOT HAPPEN';

        if ($callback->is_timed && strtotime($callback->embargo_until) > time()) {
            return response('Embargo time '.$callback->embargo_until.' not reached', 403);
        }

        switch ($callback->action) {
            case 'competition_ends':
                $payload = json_decode($callback->payload);
                $competition = Competition::find($payload->competition_id);
                if (is_null($competition)) {
                    return response('Competition does not exist', 403);
                }

                $competition->voting_enabled = true;
                $competition->save();

                event(new CompetitionSaved($competition));

                break;
            case 'competition_starts':

                // Get entries that didn't pass preselection and opted in to receive an email
                $payload = json_decode($callback->payload);
                $competition = Competition::find($payload->competition_id);

                foreach ($competition->unqualified_entries_with_opt_in as $entry) {
                    try {
                        Mail::to($entry->visitor->email)
                            ->send(new \Partymeister\Competitions\Mail\EntryStatusInfo($entry));
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
                    return response('Entry or competition does not exist', 403);
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
        $callback->fired_at = date('Y-m-d H:i:s');
        $callback->save();

        return response()->json($status);
    }

    /**
     * @return ResponseFactory|Response
     *
     * @throws GuzzleException
     */
    public function single(Request $request)
    {
        dd('HIER');
        $status = StuhlService::send('TEST');

        return response($status);
    }
}
