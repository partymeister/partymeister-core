<?php

namespace Partymeister\Core\Components;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Motor\CMS\Models\PageVersionComponent;

class ComponentSchedules {

    protected $component;
    protected $pageVersionComponent;

    protected $days = [];

    public function __construct(PageVersionComponent $pageVersionComponent, \Partymeister\Core\Models\Component\ComponentSchedule $component)
    {
        $this->component = $component;
        $this->pageVersionComponent = $pageVersionComponent;
    }

    public function index(Request $request)
    {
        $data = fractal($this->component->schedule, \Partymeister\Core\Transformers\ScheduleTransformer::class)->toArray();

        foreach (array_get($data, 'data.events.data') as $key => $event)
        {
            $date = Carbon::createFromTimestamp(strtotime(array_get($event, 'starts_at')));
            $dayKey = $date->format('l');
            $timeKey = $date->format('H:i');
            if (!isset($this->days[$dayKey]))
            {
                $this->days[$dayKey] = [];
            }

            if (!isset($this->days[$dayKey][$timeKey]))
            {
                $this->days[$dayKey][$timeKey] = [];
            }
            $this->days[$dayKey][$timeKey][] = [
                "web_color"   => array_get($event, 'event_type.data.web_color'),
                "slide_color" => array_get($event, 'event_type.data.slide_color'),
                "id"          => array_get($event, 'id'),
                "typeid"      => array_get($event, 'event_type_id'),
                "type"        => array_get($event, 'event_type.data.name'),
                "name"        => array_get($event, 'name'),
                "description" => "",
                "link"        => "",
                "starttime"   => $date->format('Y-m-d H:i'),
                "endtime"     => ""
            ];
        }

        return $this->render();
    }


    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), ['component' => $this->component, 'days' => $this->days]);
    }

}
