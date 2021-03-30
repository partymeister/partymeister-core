<?php

namespace Partymeister\Core\Transformers\Components;

use League\Fractal;
use Partymeister\Core\Models\Event;

/**
 * Class PageTransformer
 * @package Motor\CMS\Transformers
 */
class ScheduleTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];


    /**
     * Transform record to array
     *
     * @return array
     */
    public function transform($record)
    {
        // Load schedule
        $collection = Event::where('schedule_id', $record->component->schedule_id)
                           ->where('is_visible', true)
                           ->orderBy('starts_at', 'ASC')
                           ->orderBy('sort_position', 'ASC')
                           ->orderBy('event_type_id', 'ASC')
                           ->orderBy('name', 'ASC')
                           ->get();

        $data = [
            'component' => $record->component_name,
            'container' => $record->container,
            'content'   => [],
        ];

        $rArr  = [];
        $i     = 0;
        $items = [];
        foreach ($collection as $evt) {
            if ($i == 0) {
                $rArr['schedule'] = $evt->schedule->name;
            }
            $day  = substr($evt->starts_at, 0, 10).' - '.Date("l", strtotime($evt->starts_at));
            $time = substr($evt->starts_at, 11, 5);
            if ( ! array_key_exists($day, $items)) {
                $items[$day] = [];
            }
            if ( ! array_key_exists($time, $items[$day])) {
                $items[$day][$time] = [];
            }
            $items[$day][$time][] = [
                'web_color'     => $evt->event_type->web_color,
                'slide_color'   => $evt->event_type->slide_color,
                'id'            => $evt->id,
                'event_type_id' => $evt->event_type_id,
                'type'          => $evt->event_type->name,
                'name'          => $evt->name,
                'description'   => $evt->description,
                'link'          => $evt->link,
                'starts_at'     => substr($evt->starts_at, 0, 16),
                'ends_at'       => ($evt->ends_at != null && $evt->ends_at != "0000-00-00 00:00:00") ? substr($evt->ends_at,
                    0, 16) : ''
            ];
            $i++;
        }
        $rArr['items'] = $items;

        $data['content'] = $rArr;

        return $data;
    }
}
