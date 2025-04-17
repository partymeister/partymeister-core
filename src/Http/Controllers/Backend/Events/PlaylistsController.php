<?php

namespace Partymeister\Core\Http\Controllers\Backend\Events;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Core\Models\Event;
use Partymeister\Slides\Models\SlideTemplate;
use Partymeister\Slides\Services\PlaylistService;

/**
 * Class PlaylistsController
 */
class PlaylistsController extends Controller
{
    use FormBuilderTrait;

    /**
     * @param Competition $competition
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Event $event, Request $request)
    {
        PlaylistService::generateEventPlaylist($event, $request->all());

        return redirect(route('backend.playlists.index'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Competition $event
     * @param Request $request
     * @return bool|Factory|\Illuminate\Http\JsonResponse|View|string
     */
    public function index(Event $event, Request $request)
    {
        $nowTemplate = SlideTemplate::where('template_for', 'now')
                                    ->first();
        $comingupTemplate = SlideTemplate::where('template_for', 'coming_up')
                                         ->first();
        $endTemplate = SlideTemplate::where('template_for', 'end')
                                    ->first();

        $emptyTemplate = SlideTemplate::where('name', 'Empty')
                                    ->first();

        return view('partymeister-core::backend.events.playlists.show', compact('event',  'comingupTemplate', 'nowTemplate', 'endTemplate', 'emptyTemplate'));
    }
}
