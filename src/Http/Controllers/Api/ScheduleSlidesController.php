<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Core\Models\Schedule;
use Partymeister\Core\Services\ScheduleService;
use Partymeister\Slides\Models\SlideTemplate;

class ScheduleSlidesController extends Controller
{
    public function show(Schedule $schedule): JsonResponse
    {
        $template = SlideTemplate::where('template_for', 'timetable')->first();

        $events = $schedule->events()->with('event_type')->get();

        $days = [];
        foreach ($events as $event) {
            if (! $event->is_visible || $event->is_organizer_only) {
                continue;
            }

            $date = CarbonImmutable::parse($event->starts_at)
                ->shiftTimezone('GMT')
                ->setTimezone('Europe/Berlin');

            $dayName = $date->format('l');

            $days[$dayName][] = [
                'name' => $event->name,
                'type' => $event->event_type->name ?? '',
                'color' => $event->event_type->slide_color ?? '#ffffff',
                'time' => $date->format('H:i'),
            ];
        }

        foreach ($days as $dayName => $dayEvents) {
            $days[$dayName] = array_chunk($dayEvents, 8);
        }

        return response()->json([
            'schedule' => [
                'id' => $schedule->id,
                'name' => $schedule->name,
            ],
            'template' => $template ? [
                'id' => $template->id,
                'definitions' => $template->definitions,
            ] : null,
            'days' => $days,
        ]);
    }

    public function store(Schedule $schedule, Request $request): JsonResponse
    {
        $data = [
            'slide' => [],
            'name' => [],
            'cached_html_preview' => [],
            'cached_html_final' => [],
        ];

        foreach ($request->input('slides', []) as $slide) {
            $key = $slide['key'];
            $data['slide'][$key] = $slide['definitions'];
            $data['name'][$key] = $slide['name'];
            $data['cached_html_preview'][$key] = $slide['cached_html_preview'] ?? '';
            $data['cached_html_final'][$key] = $slide['cached_html_final'] ?? '';
        }

        ScheduleService::generateSlides($schedule, $data);

        return response()->json(['status' => 'ok']);
    }
}
