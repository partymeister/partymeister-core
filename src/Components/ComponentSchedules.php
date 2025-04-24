<?php

namespace Partymeister\Core\Components;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonTimeZone;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Http\Resources\ScheduleResource;
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
        $data = (new ScheduleResource($this->component->schedule->load('events')))->toArrayRecursive();

        // $tz = CarbonTimeZone::create('Europe/Berlin'); // static way
        // $carbon = new Carbon();
        // $carbon->setTimezone($tz);

        foreach (Arr::get($data, 'events', []) as $event) {
            if (Arr::get($event, 'is_visible') == false) {
                continue;
            }
            $date = CarbonImmutable::parse($event['starts_at'])->shiftTimezone('GMT')
                ->setTimezone('Europe/Berlin');
            $dayKey = $date->format('l, F jS');
            $timeKey = $date->format('H:i');
            if (! isset($this->days[$dayKey])) {
                $this->days[$dayKey] = [];
            }

            if (! isset($this->days[$dayKey][$timeKey])) {
                $this->days[$dayKey][$timeKey] = [];
            }
            $this->days[$dayKey][$timeKey][] = [
                'web_color' => Arr::get($event, 'event_type.web_color'),
                'slide_color' => Arr::get($event, 'event_type.slide_color'),
                'id' => Arr::get($event, 'id'),
                'typeid' => Arr::get($event, 'event_type.id'),
                'type' => Arr::get($event, 'event_type.name'),
                'name' => Arr::get($event, 'name'),
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
