<?php

namespace Partymeister\Core\Http\Controllers\Backend\Schedules;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Core\Models\Schedule;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Partymeister\Core\Services\ScheduleService;
use Partymeister\Slides\Models\SlideTemplate;

class SlidesController extends Controller
{

    use FormBuilderTrait;


    /**
     * Display a listing of the resource.
     *
     * @param Schedule $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Schedule $record)
    {
        $resource = $this->transformItem($record, \Partymeister\Core\Transformers\ScheduleTransformer::class);

        $timetableTemplate = SlideTemplate::where('template_for', 'timetable')->first();

        $data = $this->fractal->createData($resource)->toArray();

        $days = [];

        foreach (Arr::get($data, 'data.events.data') as $key => $event) {
            $date = Carbon::createFromTimestamp(strtotime(Arr::get($event, 'starts_at')));
            if ( ! isset($days[$date->format('l')])) {
                $days[$date->format('l')] = [];
            }

            $days[$date->format('l')][] = [
                'name'  => Arr::get($event, 'name'),
                'type'  => Arr::get($event, 'event_type.data.name'),
                'color' => Arr::get($event, 'event_type.data.slide_color'),
                'time'  => $date->format('H:i')
            ];
        }

        foreach ($days as $key => $day) {
            $days[$key] = array_chunk($day, 10);
        }

        return view('partymeister-core::backend.schedules.slides.show', compact('timetableTemplate', 'days', 'record'));
    }

    public function store(Schedule $record, Request $request)
    {
        ScheduleService::generateSlides($record, $request->all());

        return redirect(route('backend.schedules.index'));
    }
}
