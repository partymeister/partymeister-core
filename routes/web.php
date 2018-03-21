<?php

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
        Route::resource('schedules', 'SchedulesController');
        Route::resource('events', 'EventsController');
        Route::resource('event_types', 'EventTypesController');
    });
});
