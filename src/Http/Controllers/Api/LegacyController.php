<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Accounting\Models\ItemType;
use Partymeister\Core\Models\Schedule;
use stdClass;

class LegacyController extends Controller
{

    public function infodesk()
    {
        $itemTypes = new stdClass();
        foreach (ItemType::where('is_visible', true)->orderBy('sort_position', 'ASC')->get() as $key => $itemType) {
            $items = [];
            foreach ($itemType->items()->where('is_visible', true)->orderBy('sort_position', 'ASC')->get() as $item) {
                $items[] = [
                    "name"           => $item->name,
                    "description"    => $item->description,
                    "price_incl_vat" => '<span>' . number_format($item->price_with_vat, 2, ',', '.') . ' &euro;</span>'
                ];
            }
            $itemTypes->{"$key"} = [
                "name"  => $itemType->name,
                "items" => $items
            ];
        }

        $content             = new stdClass();
        $content->item_types = $itemTypes;

        $blocks         = new stdClass();
        $blocks->blocks = [
            [
                'component' => "Component_Item_List",
                'content'   => $content
            ]
        ];

        $response = [
            "page"    => "infodesk",
            "content" => $blocks
        ];

        return response()->json($response);
    }

    public function visitors()
    {
        $data = fractal(\Partymeister\Core\Models\Visitor::orderBy('created_at', 'DESC')->get(),
            \Partymeister\Core\Transformers\VisitorTransformer::class)->toArray();

        $visitors = [];

        foreach (Arr::get($data, 'data') as $visitor) {
            $visitors[] = [
                'handle'       => $visitor['handle'],
                'groups'       => $visitor['groups'],
                'country_code' => $visitor['country']
            ];

        }
        $content           = new stdClass();
        $content->visitors = $visitors;

        $blocks         = new stdClass();
        $blocks->blocks = [
            [
                'component' => "Component_Visitor_List",
                'content'   => $content
            ]
        ];

        $response = [
            "page"    => "visitors",
            "content" => $blocks
        ];

        return response()->json($response);
    }

    public function timetable()
    {
        $data = fractal(Schedule::first(), \Partymeister\Core\Transformers\ScheduleTransformer::class)->toArray();

        $days = [];

        foreach (Arr::get($data, 'data.events.data') as $event) {
            $date    = Carbon::createFromTimestamp(strtotime(Arr::get($event, 'starts_at')));
            $dayKey  = $date->format('Y-m-d') . ' - ' . $date->format('l');
            $timeKey = $date->format('H:i');
            if ( ! isset($days[$dayKey])) {
                $days[$dayKey] = [];
            }

            if ( ! isset($days[$dayKey][$timeKey])) {
                $days[$dayKey][$timeKey] = [];
            }
            $days[$dayKey][$timeKey][] = [
                "web_color"   => Arr::get($event, 'event_type.data.web_color'),
                "slide_color" => Arr::get($event, 'event_type.data.slide_color'),
                "id"          => Arr::get($event, 'id'),
                "typeid"      => Arr::get($event, 'event_type_id'),
                "type"        => Arr::get($event, 'event_type.data.name'),
                "name"        => Arr::get($event, 'name'),
                "description" => "",
                "link"        => "",
                "starttime"   => $date->format('Y-m-d H:i'),
                "endtime"     => ""
            ];
        }
        $items = new stdClass();
        foreach ($days as $dayKey => $day) {
            $items->{$dayKey} = $day;
        }

        $content           = new stdClass();
        $content->schedule = "Main";
        $content->items    = $items;

        $blocks         = new stdClass();
        $blocks->blocks = [
            [
                'component' => "Component_Event_Schedule",
                'content'   => $content
            ]
        ];

        $response = [
            "page"    => "timetable",
            "content" => $blocks
        ];

        return response()->json($response);
    }
}