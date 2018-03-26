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
        Route::get('schedules/{schedule}/slides', 'Schedules\SlidesController@index')->name('schedules.slides.index');
        Route::post('schedules/{schedule}/slides', 'Schedules\SlidesController@store')->name('schedules.slides.store');

        Route::resource('events', 'EventsController');
        Route::get('events/{event}/duplicate', 'EventsController@duplicate')->name('events.duplicate');

        Route::resource('event_types', 'EventTypesController');
        Route::resource('guests', 'GuestsController');

        Route::resource('visitors', 'VisitorsController');
    });
});

Route::group([
    'middleware' => [ 'web', 'web_auth', 'bindings', 'permission' ],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], function () {
    Route::get('callbacks', 'CallbacksController@index')->name('callbacks.index');
});

Route::get('stuhl/test', function() {
    $result = \Partymeister\Core\Services\StuhlService::send('Test 1, 2, 3');

    return response()->json($result);
});