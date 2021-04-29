<?php

namespace Partymeister\Core\Http\Controllers\Backend\Schedules;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Core\Http\Resources\ScheduleResource;
use Partymeister\Core\Models\Schedule;
use Partymeister\Core\Services\ScheduleService;
use Partymeister\Slides\Models\SlideTemplate;

/**
 * Class SlidesController
 *
 * @package Partymeister\Core\Http\Controllers\Backend\Schedules
 */
class SlidesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Partymeister\Core\Models\Schedule $record
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, Schedule $record)
    {
        $timetableTemplate = SlideTemplate::where('template_for', 'timetable')
                                          ->first();

        $resource = new ScheduleResource($record->load('events'));
        $data = $resource->toArrayRecursive();

        foreach (Arr::get($data, 'events') as $key => $event) {
            $date = Carbon::createFromTimestamp(strtotime(Arr::get($event, 'starts_at')));
            if (! isset($days[$date->format('l')])) {
                $days[$date->format('l')] = [];
            }

            $days[$date->format('l')][] = [
                'name'  => addslashes(Arr::get($event, 'name')),
                'type'  => addslashes(Arr::get($event, 'event_type.name')),
                'color' => Arr::get($event, 'event_type.slide_color'),
                'time'  => $date->format('H:i'),
            ];
        }

        foreach ($days as $key => $day) {
            $days[$key] = array_chunk($day, 8);
        }

        return view('partymeister-core::backend.schedules.slides.show', compact('timetableTemplate', 'days', 'record'));
    }

    /**
     * @param Schedule $record
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Schedule $record, Request $request)
    {
        ScheduleService::generateSlides($record, $request->all());

        return redirect(route('backend.schedules.index'));
    }
}
