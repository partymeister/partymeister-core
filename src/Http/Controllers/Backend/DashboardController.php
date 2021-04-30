<?php

namespace Partymeister\Core\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Core\Models\Visitor;
use Partymeister\Slides\Models\Playlist;
use Partymeister\Slides\Models\Slide;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function show(Request $request)
    {
        //$messageGroups = [];

        //foreach (MessageGroup::all() as $mg) {
        //    foreach ($mg->users as $user) {
        //        if ($user->id == Auth::user()->id) {
        //            $messageGroups[] = [ 'name' => $mg->name, 'uuid' => $mg->uuid ];
        //        }
        //    }
        //}

        //$visitors = [];
        //foreach (Visitor::orderBy('name', 'ASC')->get() as $visitor) {
        //    $visitors[] = [ 'name' => $visitor->name . ($visitor->group != '' ? ' / '.$visitor->group : ''), 'uuid' => $visitor->api_token ];
        //}

        //return view('partymeister-core::backend.dashboard',
        //    [ 'messageGroups' => json_encode($messageGroups), 'visitors' => json_encode($visitors) ]);

        $competitionCount = $entryCount = $lastEntries = $visitorCount = $lastVisitors = $slideCount = $lastSlides = $playlistCount = $lastPlaylists = null;

        $visitorCount = Visitor::count();
        $lastVisitors = Visitor::orderBy('created_at', 'DESC')
                               ->limit(5)
                               ->get();

        // Check if competition module is installed
        if (class_exists('\Partymeister\Competitions\Providers\PartymeisterServiceProvider')) {
            $competitionCount = Competition::count();

            $entryCount = Entry::count();
            $lastEntries = Entry::orderBy('created_at', 'DESC')
                                ->limit(5)
                                ->get();
        }

        // Check if slides module is installed
        if (class_exists('\Partymeister\Slides\Providers\PartymeisterServiceProvider')) {
            $slideCount = Slide::count();
            $lastSlides = Slide::orderBy('created_at', 'DESC')
                               ->limit(5)
                               ->get();

            $playlistCount = Playlist::count();
            $lastPlaylists = Playlist::orderBy('created_at', 'DESC')
                                     ->limit(5)
                                     ->get();
        }

        return view('partymeister-core::backend.dashboard', compact('competitionCount', 'entryCount', 'lastEntries', 'visitorCount', 'lastVisitors', 'slideCount', 'lastSlides', 'playlistCount', 'lastPlaylists'));
    }
}
