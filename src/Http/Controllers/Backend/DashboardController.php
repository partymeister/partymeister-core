<?php

namespace Partymeister\Core\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Partymeister\Core\Models\MessageGroup;
use Partymeister\Core\Models\Visitor;

/**
 * Class DashboardController
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $messageGroups = [];

        //foreach (MessageGroup::all() as $mg) {
        //    foreach ($mg->users as $user) {
        //        if ($user->id == Auth::user()->id) {
        //            $messageGroups[] = [ 'name' => $mg->name, 'uuid' => $mg->uuid ];
        //        }
        //    }
        //}

        $visitors = [];
        //foreach (Visitor::orderBy('name', 'ASC')->get() as $visitor) {
        //    $visitors[] = [ 'name' => $visitor->name . ($visitor->group != '' ? ' / '.$visitor->group : ''), 'uuid' => $visitor->api_token ];
        //}

        return view('partymeister-core::backend.dashboard', [ 'messageGroups' => json_encode($messageGroups), 'visitors' => json_encode($visitors) ]);
    }
}