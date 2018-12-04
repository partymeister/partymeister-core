<?php

use Illuminate\Support\Carbon;
use Partymeister\Accounting\Models\ItemType;
use Partymeister\Core\Models\Schedule;
use Partymeister\Core\Services\ScheduleService;
use Partymeister\Core\Transformers\ScheduleTransformer;
use Partymeister\Slides\Models\SlideTemplate;

Route::group([
    'as'         => 'backend.',
    'prefix'     => 'backend',
    'namespace'  => 'Partymeister\Core\Http\Controllers\Backend',
    'middleware' => [
        'web',
        'web_auth',
        'navigation'
    ]
], function () {

    Route::group([ 'middleware' => [ 'permission' ] ], function () {
        Route::resource('callbacks', 'CallbacksController');
        Route::get('callbacks/{callback}/duplicate', 'CallbacksController@duplicate')->name('callbacks.duplicate');
        Route::resource('schedules', 'SchedulesController');
        Route::get('schedules/{schedule}/slides', 'Schedules\SlidesController@index')->name('schedules.slides.index');
        Route::post('schedules/{schedule}/slides', 'Schedules\SlidesController@store')->name('schedules.slides.store');

        Route::resource('events', 'EventsController');
        Route::get('events/{event}/duplicate', 'EventsController@duplicate')->name('events.duplicate');

        Route::resource('event_types', 'EventTypesController');
        Route::resource('guests', 'GuestsController');

        Route::resource('visitors', 'VisitorsController');
        Route::resource('message-groups', 'MessageGroupsController');
    });
});

Route::group([
    'middleware' => [
        'web',
        'web_auth',
        'bindings',
        'permission'
    ],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], function () {
    Route::get('callbacks', 'CallbacksController@index')->name('callbacks.index');
});

Route::get('infodesk.json', function () {

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
})->name('infodesk');

Route::get('visitors.json', function () {
    $data = fractal(\Partymeister\Core\Models\Visitor::orderBy('created_at', 'DESC')->get(),
        \Partymeister\Core\Transformers\VisitorTransformer::class)->toArray();

    $visitors = [];

    foreach (array_get($data, 'data') as $visitor) {
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
})->name('visitors');

Route::get('timetable.json', function () {
    $data = fractal(Schedule::first(), \Partymeister\Core\Transformers\ScheduleTransformer::class)->toArray();

    $days = [];

    foreach (array_get($data, 'data.events.data') as $key => $event) {
        $date    = Carbon::createFromTimestamp(strtotime(array_get($event, 'starts_at')));
        $dayKey  = $date->format('Y-m-d') . ' - ' . $date->format('l');
        $timeKey = $date->format('H:i');
        if ( ! isset($days[$dayKey])) {
            $days[$dayKey] = [];
        }

        if ( ! isset($days[$dayKey][$timeKey])) {
            $days[$dayKey][$timeKey] = [];
        }
        $days[$dayKey][$timeKey][] = [
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
})->name('timetable');

// Only add the route group if you don't already have one for the given namespace
Route::group([
    'as'         => 'component.',
    'prefix'     => 'component',
    'namespace'  => 'Partymeister\Core\Http\Controllers\Backend\Component',
    'middleware' => [
        'web',
    ]
], function () {
    // You only need this part if you already have a component group for the given namespace
    Route::get('schedules', 'ComponentSchedulesController@create')->name('schedules.create');
    Route::post('schedules', 'ComponentSchedulesController@store')->name('schedules.store');
    Route::get('schedules/{component_schedule}', 'ComponentSchedulesController@edit')->name('schedules.edit');
    Route::patch('schedules/{component_schedule}', 'ComponentSchedulesController@update')->name('schedules.update');

    Route::get('visitor-logins', 'ComponentVisitorLoginsController@create')->name('visitor-logins.create');
    Route::post('visitor-logins', 'ComponentVisitorLoginsController@store')->name('visitor-logins.store');
    Route::get('visitor-logins/{component_visitor_login}', 'ComponentVisitorLoginsController@edit')
         ->name('visitor-logins.edit');
    Route::patch('visitor-logins/{component_visitor_login}', 'ComponentVisitorLoginsController@update')
         ->name('visitor-logins.update');
});