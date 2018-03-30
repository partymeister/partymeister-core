<?php

namespace Partymeister\Core\Http\Controllers\Api\Callbacks;

use Illuminate\Http\Request;
use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Models\LiveVote;
use Partymeister\Core\Models\Callback;
use Partymeister\Core\Services\StuhlService;

class SendController extends Controller
{
    public function callback($hash)
    {
        $callback = Callback::where('hash', $hash)->first();
        if (is_null($callback)) {
            return response(404);
        }

        if ($callback->has_fired) {
            return response('Already fired', 403);
        }

        if ($callback->is_timed && strtotime($callback->embargo_until) > time()) {
            return response('Embargo time ' . $callback->embargo_until . ' not reached', 403);
        }

        switch ($callback->action) {
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
                    $l = new LiveVote();
                }
                $l->entry_id = $payload->entry_id;
                $l->competition_id = $payload->competition_id;
                $l->sort_position = $entry->sort_position;
                $l->save();

                $status = StuhlService::send($callback->body, $callback->title, '', EVENT_LEVEL_GOOD, $callback->destination);

                break;
        }

        $callback->has_fired = true;
        $callback->save();

        return response()->json($status);
    }

    public function single(Request $request)
    {
        $status = StuhlService::send('TEST');
        return response($status);
    }
}