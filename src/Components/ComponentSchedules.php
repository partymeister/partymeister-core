<?php

namespace Partymeister\Core\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
     * ComponentSchedules constructor.
     *
     * @param  PageVersionComponent  $pageVersionComponent
     * @param  ComponentSchedule  $component
     */
    public function __construct(
        PageVersionComponent $pageVersionComponent,
        ComponentSchedule $component
    ) {
        $this->component = $component;
        $this->pageVersionComponent = $pageVersionComponent;
    }

    /**
     * @param  Request  $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $timetableJson = $this->loadTimetableJson();

        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), [
            'component'     => $this->component,
            'timetableJson' => $timetableJson,
        ]);
    }

    /**
     * Load timetable JSON from local file or remote URL.
     * Same source priority as the import command.
     */
    private function loadTimetableJson(): string
    {
        $localPath = '/data/timetable/timetable.json';

        if (file_exists($localPath)) {
            $data = file_get_contents($localPath);
            if ($data !== false) {
                return $data;
            }
        }

        $url = config('partymeister-core.timetable_url');
        if (! empty($url)) {
            $data = @file_get_contents($url);
            if ($data !== false) {
                return $data;
            }
            Log::warning('Timetable component: failed to fetch from URL: '.$url);
        }

        Log::warning('Timetable component: no timetable source available');

        return json_encode(['timetable' => []]);
    }
}
