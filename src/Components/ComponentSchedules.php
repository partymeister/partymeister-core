<?php

namespace Partymeister\Core\Components;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Models\Component\ComponentSchedule;

/**
 * Class ComponentSchedules
 */
class ComponentSchedules
{
    /**
     * @var ComponentSchedule
     */
    protected $component;

    /**
     * @var PageVersionComponent
     */
    protected $pageVersionComponent;

    /**
     * @var array
     */
    protected $days = [];

    /**
     * ComponentSchedules constructor.
     */
    public function __construct(
        PageVersionComponent $pageVersionComponent,
        ComponentSchedule $component
    ) {
        $this->component = $component;
        $this->pageVersionComponent = $pageVersionComponent;
    }

    /**
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $events = $this->component->schedule->events()
            ->with('event_type')
            ->where('is_visible', true)
            ->orderBy('starts_at')
            ->get();

        foreach ($events as $event) {
            $date = CarbonImmutable::parse($event->starts_at)->shiftTimezone('GMT')
                ->setTimezone('Europe/Berlin');
            $dayKey = $date->format('l, F jS');
            $timeKey = $date->format('H:i');

            $this->days[$dayKey][$timeKey][] = [
                'web_color' => $event->event_type->web_color,
                'slide_color' => $event->event_type->slide_color,
                'id' => $event->id,
                'typeid' => $event->event_type->id,
                'type' => $event->event_type->name,
                'name' => $event->name,
                'description' => '',
                'link' => '',
                'starttime' => $date->format('Y-m-d H:i'),
                'endtime' => '',
            ];
        }

        return $this->render();
    }

    /**
     * @return Factory|View
     */
    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), [
            'component' => $this->component,
            'days' => $this->days,
        ]);
    }
}
